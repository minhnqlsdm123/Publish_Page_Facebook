@extends('backend.master')
@section('content')
<div class="right_col" role="main" style="min-height: 3538px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>User</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form action="{{ route('admin.user.list') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="name"
                                value="{{ \Request::get('name') ?? '' }}" placeholder="Nội dung...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"> Tìm
                                        kiếm</i></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Cập nhập<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form class="form-horizontal form-label-left" action="" method="POST">
                            @csrf
                            <div class="form-group @if ($errors->has('name')) bad @endif">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tên user
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                        class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('email')) bad @endif">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="form-control col-md-7 col-xs-12" readonly>
                                    @if ($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="change-password">Check đổi
                                    mật
                                    khẩu
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox" name="change_password" id="change-password" />
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('password')) bad @endif">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Mật khẩu mới
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="password" id="password" value="" name="password"
                                        class="form-control col-md-7 col-xs-12" disabled="true">
                                    @if ($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('confirm_password')) bad @endif">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm_password">Mật khẩu
                                    mới
                                    nhập lại
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="password" id="confirm_password" name="confirm_password" value=""
                                        class="form-control col-md-7 col-xs-12" disabled="true" />
                                    @if ($errors->has('confirm_password'))
                                    <p class="text-danger">{{ $errors->first('confirm_password') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm_password">Chọn vai
                                    trò
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select multiple class="form-control" id="role" name="role[]">
                                        @if (!empty($roles))
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $roleOfUser->contains($role->id) ? "selected" : '' }}>{{ $role->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{ route('admin.user.list') }}" class="btn btn-info" type="button"><i
                                            class="fa fa-list"></i>
                                        Danh sách</a>

                                    <a href="{{ route('admin.user.add') }}" class="btn btn-warning" type="reset"><i
                                            class="fa fa-rotate-left"></i> Làm
                                        mới</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Lưu
                                        lại</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#change-password').change(function() {
            if ($(this).is(':checked')) {
                $('#password').removeAttr('disabled');
                $('#confirm_password').removeAttr('disabled');
            } else {
                $('#password').attr('disabled', '');
                $('#confirm_password').attr('disabled', '');
            }
            return false;
        });
    });
</script>
@endsection
