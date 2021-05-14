<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function getLogin()
    {
        return view('frontend.account.login');
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($request->remember_me) {
            $remember_me = true;
        } else {
            $remember_me = false;
        }
        if (Auth::guard('account')->attempt($credentials, $remember_me)) {
            $request->session()->flash('toastr', [
                'type' => 'success',
                'message' => 'Đăng nhập thành công'
            ]);
            return redirect()->route('frontend.home');
        } else {
            $request->session()->flash('toastr', [
                'type' => 'error',
                'message' => 'Đăng nhập thất bại'
            ]);
            return redirect()->back()->withInput();
        }
    }
    public function getLogout(Request $request)
    {
        Auth::guard('account')->logout();
        $request->session()->flash('toastr', [
            'type' => 'info',
            'message' => 'Đã đăng xuất'
        ]);
        return redirect()->back();
    }
}