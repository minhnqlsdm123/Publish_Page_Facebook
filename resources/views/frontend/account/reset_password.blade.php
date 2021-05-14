@extends('frontend.layout.master')
@section('css')
<link rel="stylesheet" type="text/css" href="/frontend/css/login.css">
@endsection
@section('login')
<div class="container clearfix" style="min-height: 500px">
    <div class="wp-form-login">
        <form action="" method="POST" class="form-login">
            @csrf
            <h4 class="title">Lấy lại mật khẩu</h4>
            <div class="group-input">
                <label for="email">EMAIL</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required />
            </div>
            <div class="group-button clearfix mt-3">
                <input type="submit" name="sm-btn" value="Gửi yêu cầu" class="sm-login">
                <a href="{{ route('account.get.login') }}" class="forget-pass">Đăng nhập ?</a>
            </div>
        </form>
    </div>
    <!-- end wp-form-login -->
</div>
@endsection