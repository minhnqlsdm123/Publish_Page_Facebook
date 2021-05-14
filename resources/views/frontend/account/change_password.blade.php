@extends('frontend.layout.master')
@section('css')
<link rel="stylesheet" type="text/css" href="/frontend/css/login.css">
@endsection
@section('login')
<div class="container clearfix">
    <div class="wp-form-login">
        <form action="" method="POST" class="form-login">
            @csrf
            <h4 class="title">Đổi mật khẩu mới</h4>
            <div class="group-input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="" required>
                @if($errors->has('password'))
                <p class="text-danger text-s-13">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="group-input">
                <label for="confirm_password">Confirm password</label>
                <input type="password" name="confirm_password" id="confirm_password" value="" required>
                @if($errors->has('confirm_password'))
                <p class="text-danger text-s-13">{{ $errors->first('confirm_password') }}</p>
                @endif
            </div>
            <div class="group-button clearfix">
                <input type="submit" name="sm-btn" value="Cập nhập" class="sm-login">
                <a href="{{route('account.get.reset.password')}}" class="forget-pass">Quên mật khẩu ?</a>
            </div>
        </form>
    </div>
    <!-- end wp-form-login -->
</div>
@endsection