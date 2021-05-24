<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function getLogin()
    {
        return view('backend.user.login');
    }

    public function postLogin(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            \Session::flash('toastr', [
                'type' => 'success',
                'message' => 'Xin chào'
            ]);
            return redirect()->route('admin.PublishPage.list');
        } else {
             \Session::flash('toastr', [
                'type' => 'error',
                'message' => 'Thông tin đăng nhập chưa đúng'
            ]);
            return redirect()->back()->withInput();
        }
    }

    public function getLogout()
    {
        if (Auth::check()) {
            Auth::logout();
            \Session::flash('toastr', [
                'type' => 'info',
                'message' => 'Đăng xuất hệ thống'
            ]);
        }
        return redirect()->route('admin.user.login');
    }
}
