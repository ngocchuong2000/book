<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordReset;
use App\Mail\SendLink;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Register account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if($request->password === $request->repassword) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);
            Alert::success('Success', 'Đăng ký thành công');
            return redirect()->back();
        }else {
            Alert::error('Error', 'Mật khẩu không trùng khớp');
            return redirect()->back();
        }
    }

    /**
     * Login account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $result = Auth::attempt(['email' => $request->email, 'password' => $request->password], true);
            if ($result) {
                if (Auth::user()->status == 0) {
                    Auth::logout();
                    Alert::error('Error', 'Hiện tài khoản của bạn đã bị khoá, vui lòng liên hệ quản trị viên để được hỗ trợ');
                    return redirect()->back();
                } else {
                    Alert::success('Success', 'Đăng nhập thành công');
                    return redirect()->back();
                }
            } else {
                Alert::error('Error', 'Mật khẩu / Email không đúng');
                return redirect()->back();
            }
        } catch (\Throwable $e) {
            \Log::info($e->getMessage());
        }
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        Alert::success('Success', 'Đăng xuất thành công');
        return redirect()->route('client.home');
    }

    public function changeAccount()
    {
        $user = User::find(Auth::user()->id);
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->get();
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();
        return view('client.account', compact('user', 'orders', 'wishlists'));
    }

    public function postChangeAccount(Request $request)
    {
        if ($request->changepass) {
            if (Hash::check($request->oldpass, Auth::user()->password)) {
                if($request->newpass === $request->confirmpass){
                    User::where('email', Auth::user()->email)->update(['password' => bcrypt($request->newpass)]);
                }else{
                    Alert::error('Error', 'Mật khẩu không trùng khớp');
                    return redirect()->back();
                }
            } else {
                Alert::error('Error', 'Mật khẩu hiện tại không trùng không đúng');
                return redirect()->back();
            }
        }
        $user = Auth::user();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();
        Alert::success('Success', 'Cập nhật thành công');
        return redirect()->back();
    }

    public function resetPass()
    {
        return view('client.auth.reset-password');
    }

    /**
     * Send mail link
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendLink(Request $request)
    {
        $check = User::where('email' ,$request->email)->exists();
        if ($check) {
            $token = Str::random(30);
            PasswordReset::create([
                'email'    => $request->email,
                'token'    => $token
            ]);
            Mail::to($request->email)->send(new SendLink($token));
            Alert::success('Success', 'Gửi link thành công, vui lòng kiểm tra hộp thư của bạn');

            return redirect()->back();
        } else {
            Alert::error('Error', 'Mail không tồn tại trong hệ thống');

            return redirect()->back();
        }
    }

    /**
     * Show password change form
     * 
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function showChangePassword($token)
    {
        $user = PasswordReset::where('token', '=', $token)->first();

        return view('client.auth.change-password',['email' => $user['email']]);
    }

    /**
     * Update password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        
        if($request->password === $request->repassword){
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            Alert::success('Success', 'Cập nhật thành công');

            return redirect()->route('client.home');
        }else{
            Alert::error('Error', 'Mật khẩu không trùng khớp');

            return redirect()->back();
        }
    }
}
