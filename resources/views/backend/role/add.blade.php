@extends('backend.master')
@section('content')
<div class="right_col" role="main" style="min-height: 3538px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Role (Vai trò user)</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form action="{{ route('admin.category.list') }}" method="GET">
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
                        <h2>Thêm mới<small></small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        <form class="form-horizontal form-label-left" action="" method="POST">
                            @csrf
                            <div class="form-group @if ($errors->has('name')) bad @endif">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group @if ($errors->has('display_name')) bad @endif">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="display_name">Display name
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="display_name" name="display_name"
                                        value="{{ old('display_name') }}" class="form-control col-md-7 col-xs-12">
                                    @if ($errors->has('display_name'))
                                    <p class="text-danger">{{ $errors->first('display_name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Chọn
                                    quyền
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                        <div class="col-md-4 col-sm-3 col-xs-12 pt-8">
                                            <label style="padding-top: 8px">
                                                <input type="checkbox" class="js-switch" name="permission[]"
                                                    value="{{ $permission->id }}" data-switchery="true"
                                                    style="display: none;"><span
                                                    style="padding: 5px">{{ $permission->display_name }}</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @if ($errors->has('permission'))
                                    <p class="text-danger">{{ $errors->first('permission') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{ route('admin.role.list') }}" class="btn btn-info" type="button"><i
                                            class="fa fa-list"></i>
                                        Danh sách</a>

                                    <a href="{{ route('admin.role.add') }}" class="btn btn-warning" type="reset"><i
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