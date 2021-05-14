@extends('backend.master')
@section('css')
    <link href="{{ asset('backend/build/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@extends('backend.master')
@section('content')
<div class="right_col" role="main" style="min-height: 3538px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Danh mục</h3>
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
                        @include('backend.PublishPage.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('tools')
    @includeIf('tools.ckeditor')
@endpush
