@extends('backend.master')
@section('content')
<div class="right_col" role="main" style="min-height: 3538px;">
    <div class="">
        <div class="page-title">
            <div class="title_left"><h3>Danh mục</h3></div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <form action="{{ route('admin.PublishPage.list') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" value="{{ \Request::get('name') ?? '' }}" placeholder="Nội dung...">
                            <span class="input-group-btn"><button class="btn btn-default" type="submit"><i class="fa fa-search"> Tìmkiếm</i></button></span>
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
                        <form class="form-horizontal form-label-left" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group @if ($errors->has('message')) bad @endif">
                                <label class="control-label col-md-1 col-sm-1 col-xs-4">Trạng thái<span class="required"> *</span></label>
                                <div class="col-md-9 col-sm-6 col-xs-12">
                                    <input type="text" id="message" name="message" value="{{ old('message', $post['message'] ?? '') }}" class="form-control col-md-7 col-xs-12" />
                                    @if ($errors->has('message'))
                                        <p class="text-danger">{{ $errors->first('message') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-1 col-sm-1 col-xs-4">Ảnh mô tả</label>
                                <div class="col-md-11 col-sm-11 col-xs-9">
                                    @foreach($post->file as $k => $item)
                                        <div class="row" style="margin-bottom: 15px;">
                                            <div class="col-md-2">
                                                <img id="image-preview-image_detail{{ $k }}" class="img-fluid"
                                                     src="{{ $item->url ?? '/backend/build/images/default.jpg' }}">
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="image_detail[]" value="{{ $item->url }}"
                                                       id="image_detail{{ $k }}" class="form-control" />
                                            </div>
                                            <div class="col-md-2">
                                                <div class=" input-group-append">
                                                    <button
                                                        onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=image_detail{{ $k }}')"
                                                        class="btn btn-primary" type="button"><i class="fa fa-cloud-upload"></i>
                                                        Chọn</button>
                                                    <button class="btn btn-danger remove-input"
                                                            data-reset="image_detail{{ $k }}" type="button"><i class="material-icons"><i class="fa fa-trash"></i>Xóa</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button onclick="addImage(this, 'image_detail')" class="btn btn-success w-162" type="button"><i class="fa fa-plus-circle"></i> Thêm ảnh</button>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{ route('admin.PublishPage.list') }}" class="btn btn-info" type="button"><i class="fa fa-list"></i>Danh sách</a>

                                    <a href="{{ route('admin.PublishPage.update', $post['id']) }}" class="btn btn-warning" type="reset"><i class="fa fa-rotate-left"></i> Làm mới</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Lưu lại</button>
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
