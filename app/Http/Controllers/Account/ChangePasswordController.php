<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestChangePassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Account;


class ChangePasswordController extends Controller
{
    public function getChange(Request $request)
    {
        $email = $request->email;
        $token = $request->_token;
        $checkToken = DB::table('password_resets')->where('token', $token)->first();
        //1. Kiểm tra mã token
        if ($checkToken) {
            //2. Kiểm tra nếu vượt quá 3 phút thì token hết hạn
            $now = Carbon::now();
            if ($now->diffInHours($checkToken->created_at) > 1) {
                DB::table('password_resets')->where('email', $email)->delete();
                $request->session()->flash('toastr', [
                    'type' => 'warning',
                    'message' => 'Thời hạn đổi mật khẩu đã vượt quá 1h, vui lòng gửi yêu cầu mới'
                ]);
                return redirect()->route('frontend.home');
            }
            return view('frontend.account.change_password');
        } else {
            $request->session()->flash('toastr', [
                'type' => 'warning',
                'message' => 'Mã xác nhận đã hết hạn hoặc không chính xác, vui lòng kiểm tra lại yêu cầu'
            ]);
            return redirect()->route('frontend.home');
        }
    }
    public function postChange(RequestChangePassword $request)
    {
        $password = Hash::make($request->password);
        $email = $request->email;
        $account = Account::where('email', $email)->first();
        $account->password = $password;
        $account->save();
        //Đổi thành công mkhau thì xóa yêu cầu ở bảng password_resets đi
        DB::table('password_resets')->where('email', $email)->delete();
        $request->session()->flash('toastr', [
            'type' => 'success',
            'message' => 'Đổi mật khẩu thành công, bạn có thể đăng nhập luôn'
        ]);
        return redirect()->route('account.get.login');
    }
}