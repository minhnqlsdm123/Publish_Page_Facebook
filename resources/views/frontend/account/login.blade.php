@extends('frontend.layout.master')
@section('css')
<link rel="stylesheet" type="text/css" href="/frontend/css/login.css">
@endsection
@section('login')
<div class="container clearfix">
    <div class="wp-form-login">
        <form action="" method="POST" class="form-login">
            @csrf
            <h4 class="title">Đăng nhập</h4>
            <div class="group-input">
                <label for="email">EMAIL</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required />
            </div>
            <div class="group-input">
                <label for="password">PASSWORD</label>
                <input type="password" name="password" id="password" value="">
            </div>
            <div class="group-input-check">
                <label for="remember_me">Ghi nhớ tôi
                    <input type="checkbox" name="remember_me" id="remember_me" value="remember_me">
                    <span><span></span></span>
                </label>
            </div>
            <div class="group-button clearfix">
                <input type="submit" name="sm-btn" value="Đăng nhập" class="sm-login">
                <a href="{{route('account.get.reset.password')}}" class="forget-pass">Quên mật khẩu ?</a>
            </div>
            <div class="group-button">
                <button class="btn-social log-fb d-block w-100">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    <span>Log in with Facebook</span>
                </button>
                <a href="{{ route('account.auth.google') }}" class="btn-social log-gg d-block w-100">
                    <i class="fa fa-google" aria-hidden="true"></i>
                    <span>Log in with Google</span>
                </a>
                <a href="{{ route('account.get.register') }}" class="link-regis">Đăng ký</a><span>nếu chưa có tài
                    khoản</span>
            </div>
        </form>
    </div>
    <!-- end wp-form-login -->
</div>
@endsection