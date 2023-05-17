<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Alert;
use Srmklive\PayPal\Services\ExpressCheckout;
use AmrShawky\Currency;

class OrderController extends Controller
{
    public function cart()
    {
        return view('client.cart');
    }

    public function checkout()
    {
        return view('client.checkout');
    }

    /**
     * Pay
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        $products = [];
        $total = 0;
        if (!Session::has('cart')) {
            return view('cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach ($cart->items as $row) {
            $total += $row['price'] * $row['qty'];
        }

        try {
            if (isset($request->voucher)) {
                $voucher = Voucher::where('code', $request->voucher)->first();
                Voucher::where('code', $request->voucher)->update(['qty' => $voucher->qty - 1]);
                $order = Order::create([
                    'id'      => 'order_' . $this->generateRandomString(),
                    'user_id' => Auth::user()->id,
                    'total'   => $total - $voucher->price,
                    'address' => $request->address,
                    'voucher_code' => $request->voucher
                ]);
            } else {
                $order = Order::create([
                    'id'      => 'order_' . $this->generateRandomString(),
                    'user_id' => Auth::user()->id,
                    'total'   => $total,
                    'address' => $request->address,
                    'voucher_code' => $request->voucher
                ]);
            }
            foreach ($cart->items as $row) {
                OrderDetail::create([
                    'product_id' => $row['item']['id'],
                    'price' => $row['price'],
                    'qty' => $row['qty'],
                    'order_id' => $order->id
                ]);
                $product = Product::find($row['item']['id']);
                Product::where('id', $row['item']['id'])->update(['qty' => $product['qty'] - $row['qty']]);
                Product::where('id', $row['item']['id'])->update(['qty_buy' => $product['qty_buy'] + $row['qty']]);
            }
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->route('client.checkout')->with('invalid', $e->getMessage());
        }
        
        foreach($cart->items as $row){
            $productDetail = Product::find($row['item']['id']); 
            $products['items'][] = [
                'name' => $productDetail->name,
                'price' => (int) Currency::convert()
                ->from('VND')
                ->to('USD')
                ->amount($row['price'])
                ->get(),
                'qty' => $row['qty']
            ];
        }
  
        $products['invoice_id'] = $order->id;
        $products['invoice_description'] = "Pay successful, you get the new Order#{$order->id}";
        $products['return_url'] = route('done.payment.paypal');
        $products['cancel_url'] = route('cancel.payment.paypal');
        $products['total'] = (int) Currency::convert()
        ->from('VND')
        ->to('USD')
        ->amount($total)
        ->get();
  
        $paypalModule = new ExpressCheckout;
  
        $res = $paypalModule->setExpressCheckout($products);
        $res = $paypalModule->setExpressCheckout($products, true);

        return redirect($res['paypal_link']);
    }

    private function generateRandomString($length = 24) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function cancelPaymentPaypal()
    {
        Alert::error('Error', 'Bạn đã hủy thanh toán');

        return redirect()->route('client.checkout');
    }
  
    public function donePaymentPaypal(Request $request)
    {
        $paypalModule = new ExpressCheckout;
        $response = $paypalModule->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            Session::forget('cart');
            Alert::success('Success', 'Thanh toán thành công');
            
            return redirect()->route('auth.change.account');
        }
    }

    public function showMyOrder($id)
    {
        $orders_detail = OrderDetail::where('order_id',$id)
        ->join('products','products.id','=','order_details.product_id')
        ->get(['order_details.*','products.name','products.price','products.start_date','products.end_date','products.sale_price']);
        return view('client.my-order-detail', compact('orders_detail'));
    }

    public function checkVoucher(Request $request)
    {
        $voucher = Voucher::where('code',$request->code)->first();
        if (!is_null($voucher)) {
            return response()->json([
                'status' => 200,
                'total' => $request->total - $voucher->price,
                'code' => $request->code
            ]);
        } else {
            return response()->json([
                'status' => 403,
                'msg'   => 'Voucher không tồn tại',
                'total' => $request->total
            ]);
        }
    }
}
