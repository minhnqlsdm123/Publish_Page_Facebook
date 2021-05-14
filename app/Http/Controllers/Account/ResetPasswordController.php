<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountResetPassword;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function getReset()
    {
        return view('frontend.account.reset_password');
    }
    public function postReset(Request $request)
    {
        $email = $request->email;
        $account = Account::where('email', $email)->first();
        if ($account) {
            $name = $account->name;
            $token = Hash::make($email . $account->id);
            $link = route('account.get.change.password', ['email' => $email, '_token' => $token]);
            //insert bảng password_resets
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            Mail::to($request->email)->send(new AccountResetPassword($name, $link));
            $request->session()->flash('toastr', [
                'type' => 'success',
                'message' => 'Gửi yêu cầu thành công, vui lòng truy cập email để xác nhận đổi mật khẩu'
            ]);
        } else {
            $request->session()->flash('toastr', [
                'type' => 'warning',
                'message' => 'Yêu cầu thất bại, vui lòng kiểm tra lại thông tin email'
            ]);
        }

        return redirect()->back();
    }
}