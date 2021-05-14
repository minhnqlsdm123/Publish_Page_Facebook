<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAccount;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Mail\AccountRegister;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function getRegister()
    {
        return view('frontend.account.register');
    }
    public function postRegister(RequestAccount $request)
    {
        $account = new Account();
        $account->name = $request->name;
        $account->email = $request->email;
        $account->password = Hash::make($request->password);
        $account->created_at = Carbon::now();
        $account->save();
        //Gửi emai cho người dùng
        $name = $request->name;
        Mail::to($request->email)->send(new AccountRegister($name));
        //Cho người dùng đăng nhập luôn
        Auth::guard('account')->attempt(['email' => $request->email, 'password' => $request->password], true);
        $request->session()->flash('toastr', [
            'type' => 'success',
            'message' => 'Đăng kí thành công'
        ]);
        return redirect()->route('frontend.home');
    }
}