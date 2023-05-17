<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Media;
use App\Models\Brand;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->join('authors', 'products.author_id', '=', 'authors.id')
        ->join('brands', 'brands.id', '=', 'products.brand_id')
        ->get(['products.*', 'categories.name AS cate_title', 'categories.parent_category_id', 'suppliers.name AS supplier_title', 'authors.name AS author_title', 'brands.name AS brand_title']);
        return view('admin.products.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $authors = Author::all();
        $brands = Brand::all();
        return view('admin.products.add', compact('categories', 'suppliers', 'authors', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('thumbnail')) {
            $validated = $request->validate([
                'name' => 'required',
                'category_id' => 'required',
                'supplier_id' => 'required'
            ]);
            if ($request->type == 0) {
                $product = Product::create([
                    'name' => $validated['name'],
                    'price' => $request->input('price'),
                    'category_id' => $validated['category_id'],
                    'supplier_id' => $validated['supplier_id'],
                    'author_id' => $request->author_id,
                    'brand_id' => $request->brand_id,
                    'description' => $request->input('description'),
                    'qty' => $request->input('qty'),
                    'public_date' => $request->public_date,
                    'size' => $request->size,
                    'cover' => $request->cover,
                    'page' => $request->page,
                    'type' => $request->type
                ]);
            } else {
                $product = Product::create([
                    'name' => $validated['name'],
                    'price' => $request->input('price'),
                    'category_id' => $validated['category_id'],
                    'supplier_id' => $validated['supplier_id'],
                    'author_id' => $request->author_id,
                    'brand_id' => $request->brand_id,
                    'description' => $request->input('description'),
                    'qty' => $request->input('qty'),
                    'public_date' => $request->public_date,
                    'size' => $request->size,
                    'cover' => $request->cover,
                    'page' => $request->page,
                    'sale_price' => $request->input('price_sale'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'type' => $request->type
                ]);
            }
            foreach($request->thumbnail as $image) {
                $name = $image->getClientOriginalName();
                $image->storeAs('/public/images/products', $name);
                $product->image()->create(["url" => "storage/images/products/". $name]);
            }
            return redirect()->route('product.list')->with("success","Lưu thành công");
        } else {
            return redirect()->back()->with("invalid","Vui lòng thêm ảnh");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $authors = Author::all();
        $brands = Brand::all();
        $product = Product::find($id);
        return view('admin.products.edit', compact('categories', 'suppliers', 'product', 'authors', 'brands'));
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

        $product = Product::find($id);
        $delete_images_src = [];
        if($request->has('thumbnail_src')) {
            foreach($product->image as $product_thumbnail_src) {
                $is_delete = true;
                foreach($request->thumbnail_src as $request_thumbnail_src) {
                    if(trim($product_thumbnail_src->url) == trim($request_thumbnail_src)) {
                        $is_delete = false;
                        break;
                    }
                }
                if($is_delete) {
                    array_push($delete_images_src, $product_thumbnail_src->url);
                }
            }
        } else {
            foreach($product->image as $product_thumbnail_src) {
                array_push($delete_images_src, $product_thumbnail_src->url);
            }
        }
        Media::whereIn("url", $delete_images_src)->delete();
        foreach($delete_images_src as $product_thumbnail_src) {
            Storage::delete("images/products/$product_thumbnail_src");
        }
        if($request->has('thumbnail')) {
            foreach($request->thumbnail as $image) {
                $name = $image->getClientOriginalName();
                $image->storeAs('/public/images/products', $name);
                $product->image()->create(["url" => "storage/images/products/". $name]);
            }
        }
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->supplier_id = $request->input('supplier_id');
        $product->author_id = $request->input('author_id');
        $product->brand_id = $request->input('brand_id');
        $product->description = $request->input('description');
        $product->qty = $request->input('qty');
        $product->public_date = $request->public_date;
        $product->size = $request->size;
        $product->cover = $request->cover;
        $product->page = $request->page;
        $product->type = $request->type;
        if ($request->type == 0) {
            $product->sale_price = 0;
            $product->start_date = null;
            $product->end_date = null;
        } else {
            $product->sale_price = $request->input('price_sale');
            $product->start_date = $request->input('start_date');
            $product->end_date = $request->input('end_date');
        }
        $product->save();
        return redirect()->route('product.list')->with("success","Sửa thành công");
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.list')->with("success","Xóa thành công");
    }

    public function updateStatus($id, $status)
    {
        $product = Product::find($id);
        $product->status = $status;
        $product->save();
        return redirect()->route('product.list')->with("success","Cập nhật trạng thái thành công");
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.products.show', compact('product'));
    }
}
