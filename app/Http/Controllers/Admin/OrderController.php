<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUpdateOrder;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::join('users','orders.user_id','=','users.id')->orderBy('orders.created_at','DESC')->get(['orders.*','users.name']);
        return view('admin.orders.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders_detail = OrderDetail::where('order_id',$id)
        ->join('products','products.id','=','order_details.product_id')
        ->get(['order_details.*','products.name','products.price','products.start_date','products.end_date','products.sale_price']);
        $order = Order::find($id);
        return view('admin.orders.show', compact('orders_detail', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if ($request->status == 3) {
            $orderDetails = OrderDetail::where('order_id', $id)->get();
            foreach ($orderDetails as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                Product::where('product_id', $orderDetail->product_id)->update(['qty' => $product->qty + $orderDetail->qty]);
                Product::where('product_id', $orderDetail->product_id)->update(['qty_buy' => $product->qty_buy - $orderDetail->qty ]);
            }
        }
        $order->status = $request->status;
        $order->save();
        Mail::to(User::find($order->user_id)->email)->send(new SendUpdateOrder($order, $request->status));
        return redirect()->route('order.list')->with('success','Cập nhật trạng thái thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function print($id)
    {
        $order = Order::find($id);
        $orders_detail = OrderDetail::where('order_id',$id)
        ->join('products','products.id','=','order_details.product_id')
        ->get(['order_details.*','products.name','products.price','products.start_date','products.end_date','products.sale_price']);
        return view('admin.orders.print',compact('order','orders_detail'));
    }
}
