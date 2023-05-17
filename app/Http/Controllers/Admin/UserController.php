<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.list',compact('users'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Order::where('user_id', $id)->exists();
        if ($check) {
            return redirect()->back()->with('invalid',"Hiện có một vài hóa đơn đang chứa khách hàng này, bạn không thể xóa được mà thay vào đó bạn có thể khóa tài khoản này");
        }
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success','Xóa tài khoản thành công.');
    }

    public function disable($id)
    {
        User::where('id',$id)->update(['status' => 0]);
        return redirect()->back()->with('success','Khóa tài khoản thành công.');
    }

    public function enable($id)
    {
        User::where('id',$id)->update(['status' => 1]);
        return redirect()->back()->with('success','Mở tài khoản thành công.');
    }
}
