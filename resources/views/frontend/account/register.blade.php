@extends('frontend.layout.master')
@section('css')
<link rel="stylesheet" type="text/css" href="/frontend/css/login.css">
@endsection
@section('login')
<div class="container clearfix">
    <div class="wp-form-login">
        <form action="" method="POST" class="form-login">
            @csrf
            <h4 class="title">Đăng kí</h4>
            <div class="group-input">
                <label for="name">Fullname</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required />
                @if($errors->has('name'))
                <p class="text-danger text-s-13">{{ $errors->first('name') }}</p>
                @endif

            </div>
            <div class="group-input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required />
                @if($errors->has('email'))
                <p class="text-danger text-s-13">{{ $errors->first('email') }}</p>
                @endif
            </div>
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
            <div class="group-button clearfix mt-5">
                <input type="submit" name="sm-btn" value="Đăng kí" class="sm-login">
            </div>
            <a href="{{ route('account.get.login') }}" class="link-regis">Đăng nhập</a><span>nếu đã có tài
                khoản ?</span>
        </form>
    </div>
    <!-- end wp-form-login -->
</div>
@endsection