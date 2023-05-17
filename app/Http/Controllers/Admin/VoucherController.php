<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.vouchers.list',compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vouchers.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = Voucher::where('code',$request->code)->exists();
        if ($check) {
            return redirect()->back()->with("invalid","Mã khuyến mãi không được trùng");
        }

        Voucher::create([
            'code' => $request->code,
            'price' => $request->price,
            'qty' => $request->qty,
        ]);
        return redirect()->route('voucher.list')->with("success","Thêm thành công");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher = Voucher::find($id);
        return view('admin.vouchers.edit',compact('voucher'));
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
        $voucher = Voucher::find($id);
        if ($request->code != $voucher->code) {
            $check = Voucher::where('code',$request->code)->exists();
            if ($check) {
                return redirect()->back()->with("invalid","Mã khuyến mãi không được trùng");
            }
        }
        $voucher->code = $request->code;
        $voucher->price = $request->price;
        $voucher->qty = $request->qty;
        $voucher->save();
        return redirect()->route('voucher.list')->with("success","Cập nhật thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = Voucher::find($id);
        $voucher->delete();
        return redirect()->route('voucher.list')->with("success","Xóa thành công");
    }
}
