<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Admin::where('role',1)->get();
        return view('admin.staffs.list', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.staffs.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return redirect()->route('staff.list')->with("success","Lưu thành công");
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
        $staff = Admin::find($id);
        return view('admin.staffs.edit', compact('staff'));
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
        $staff = Admin::find($id);
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->password = $staff->password == $request->password ? $staff->password : bcrypt($request->password);
        $staff->save();
        return redirect()->route('staff.list')->with("success","Cập nhật thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Admin::find($id);
        $staff->delete();
        return redirect()->route('staff.list')->with("success","Xóa thành công");
    }

    public function showChangeInfo($id)
    {
        $staff = Admin::find($id);
        return view('admin.staffs.change_info', compact('staff'));
    }

    public function changeInfo(Request $request, $id)
    {
        $staff = Auth::guard('admin')->user();
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->save();
        return redirect()->back()->with("success","Cập nhật thành công");
    }

    public function showChangePass($id)
    {
        $staff = Admin::find($id);
        return view('admin.staffs.change_pass', compact('staff'));
    }

    public function changePass(Request $request, $id)
    {
        $staff = Admin::find($id);
        if (Hash::check($request->oldpassword, $staff->password)) {
            if($request->input('password') === $request->input('repassword')){
                Admin::where('email', $staff->email)->update(['password' => bcrypt($request->input('password'))]);
                if(Auth::guard('admin')->check()){
                    Auth::guard('admin')->logout();
                }
                return redirect()->route('admin.form.login')->with('success', 'Đổi mật khẩu thành công');
            }else{
                return redirect()->back()->with('invalid','Mật khẩu không trùng khớp.');
            }
        } else {
            return redirect()->back()->with('invalid','Mật khẩu hiện tại không trùng khớp');
        }
    }
}
