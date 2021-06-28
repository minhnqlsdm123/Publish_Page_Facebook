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
//        dd($request->all());
        $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email không được trống',
                'email.unique' => 'Email đã tồn tại trên hệ thống',
                'email.email' => 'Email chưa đúng định dạng',
                'password' => 'Password không được để trống'
            ]
        );

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

    public function getLogout(Request $request)
    {
        if (Auth::check()) {
            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();

            session(['user_logged_out' => true]);
            Auth::logout();
            \Session::flash('toastr', [
                'type' => 'info',
                'message' => 'Đăng xuất hệ thống'
            ]);
        }
        return redirect()->route('admin.user.login');
    }
}
