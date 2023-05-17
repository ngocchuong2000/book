<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ParentCategory;
use App\Models\Author;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Wishlist;

class ProductController extends Controller
{
    public function showProducts($id)
    {
        $parentCategory = ParentCategory::find($id);
        $categories = Category::where('parent_category_id', $id)->get();
        return view('client.products', compact('categories', 'parentCategory'));
    }

    public function showNewProduct()
    {
        $products = Product::where('qty','>',0)->where('status',1)->orderBy('id','DESC')->paginate(12);
        return view('client.product-new', compact('products'));
    }

    public function showProductCategory($id)
    {
        $category = Category::find($id);
        $products = Product::where('category_id', $id)->where('qty','>',0)->where('status',1)->orderBy('id', 'DESC')->paginate(12);
        $authors = Author::all();
        return view('client.product-category', compact('category', 'products', 'authors'));
    }

    public function showProductDetail($id)
    {
        $product = Product::find($id);
        $rating = Rating::where('product_id',$id)->avg('star');
        $rating = round($rating);
        $comments = Comment::where('product_id',$id)->join('users','users.id','=','comments.user_id')->get(['comments.*','users.name']);
        $replies = Reply::all();
        return view('client.product-detail', compact('product', 'comments', 'replies', 'rating'));
    }

    public function showProductSearch(Request $request)
    {
        $products = Product::where('qty','>',0)->where('status',1);
        $data = $request->all();

        // Filter name
        if (isset($data['q']) && !empty($data['q'])) {
            $products = $products->where('name', 'like', '%' . $data['q'] . '%');
        }

        // Filter author
        if (isset($data['author']) && !empty($data['author'])) {
            $products = $products->where('author_id', $data['author']);
        }

        // Filter price
        if (isset($data['price']) && !empty($data['price'])) {
            if ($data['price'] == 1) {
                $products = $products->where('price','<',5 * pow(10,4));
            } elseif ($data['price'] == 2) {
                $products = $products->whereBetween('price',[5 * pow(10,4), 1 * pow(10,5)]);
            } elseif ($data['price'] == 3) {
                $products = $products->whereBetween('price',[1 * pow(10,5), 15 * pow(10,4)]);
            } else {
                $products = $products->where('price','>',15 * pow(10,4));
            }
        }

        $products = $products->orderBy('id', 'DESC')->paginate(12);

        return view('client.product-search', compact('products', 'data'));
    }

    public function sort(Request $request)
    {
        if ($request->sort == 0) {
            $products = Product::orderBy('id', 'DESC')->where('category_id', $request->category_id)->where('qty','>',0)->where('status',1)->paginate(12);
        } elseif ($request->sort == 1) {
            $products = Product::orderBy('price','ASC')->where('category_id', $request->category_id)->where('qty','>',0)->where('status',1)->paginate(12);
        } else {
            $products = Product::orderBy('price','DESC')->where('category_id', $request->category_id)->where('qty','>',0)->where('status',1)->paginate(12);
        }
        return response()->json([
            'status' => 200,
            'data'   => view('client.includes.product-category', compact('products'))->render()
        ]);
    }

    public function filter(Request $request)
    {
        if ($request->id != 0) {
            $products = Product::orderBy('id', 'DESC')->where('category_id', $request->category_id)->where('author_id',$request->id)->where('qty','>',0)->where('status',1)->paginate(12);
        } else {
            $products = Product::orderBy('id', 'DESC')->where('category_id', $request->category_id)->where('qty','>',0)->where('status',1)->paginate(12);
        }
        return response()->json([
            'status' => 200,
            'data'   => view('client.includes.product-category', compact('products'))->render()
        ]);
    }

    public function addToCart(Request $request)
    {
        $total = 0;
        $product = Product::find($request->id);
        if ($product->qty < $request->qty) {
            return response()->json([
                'status' => 422,
                'title' => 'Sản phẩm chỉ còn ' . $product->qty . ', không đủ số lượng để thêm giỏ hàng'
            ]); 
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product,$product->id, $request->qty);
        $request->session()->put('cart',$cart);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach ($cart->items as $row) {
            $total += $row['price'];
        }
        return response()->json([
            'status' => 200,
            'qty'    => Session::get('cart')->totalQty,
            'price'  => $total
        ]);
    }

    public function deleteItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->deleteItem($id);
        if(count($cart->items) > 0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function changeQty(Request $request)
    {
        $total = 0;
        $product = Product::find($request->id);
        if ($product->qty < $request->qty) {
            return response()->json([
                'status' => 422,
                'title' => 'Sản phẩm chỉ còn ' . $product->qty . ', không đủ số lượng để mua hàng'
            ]); 
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->changeQty($request);
        Session::put('cart', $cart);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach ($cart->items as $row) {
            $total += $row['price'];
        }
        return response()->json([
            'status' => 200,
            'price'  => number_format($cart->items[$request->id]['price'],-3,',',',') . ' VND',
            'totalQty' => $cart->totalQty,
            'totalPrice' => number_format($total,-3,',',',') . ' VND',
            'productId' => $request->id
        ]);
    }

    public function rating(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();
            Rating::where('user_id', Auth::user()->id)->where('product_id', $data['product_id'])->delete();
            Rating::create([
                'user_id' => Auth::user()->id,
                'product_id' => $data['product_id'],
                'star' => $data['index']
            ]);
            return response()->json([
                'status' => 200
            ]);
        } else {
            return response()->json([
                'status' => 403
            ]);
        }
    }

    public function addWishlist(Request $request) {
        if (Wishlist::where([['user_id', Auth::user()->id], ['product_id', $request->id]])->exists()) {
            Wishlist::where([['user_id', Auth::user()->id], ['product_id', $request->id]])->delete();
            $isExist = true;
        } else {
            Wishlist::create([
                'product_id' => $request->id,
                'user_id' => Auth::user()->id
            ]);
            $isExist = false;
        }

        return response()->json([
            'status' => 200,
            'exist' => $isExist
        ]);
    }

    public function deleteWishlist($id)
    {
        Wishlist::find($id)->delete();

        return redirect()->back();
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        return response()->json([
            'status' => 200,
            'product' => $product,
            'image' => asset($product->image->first()->url)
        ]);
    }
}
