@extends('backend.master')
@section('css')

@endsection
@section('content')
    <div class="right_col" role="main" style="min-height: 3538px;">
        <div class="">
            <div class="page-title">
                <div class="title_left"><h3>Bài viết</h3></div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form action="{{ route('admin.PublishPage.list') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" value="{{ \Request::get('name') ?? '' }}" placeholder="Nội dung...">
                                <span class="input-group-btn"><button class="btn btn-default" type="submit"><i class="fa fa-search"> Tìm kiếm</i></button></span>
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
                                    <label class="form-label col-md-2 col-sm-2 col-xs-3">Nội dung<span class="text-danger"> *</span></label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" id="content" name="content" value="{{ old('content', $post['content'] ?? '') }}" class="form-control col-md-7 col-xs-12" />
                                        @if ($errors->has('content'))
                                            <p class="text-danger">{{ $errors->first('content') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($post->file_count > 1)
                                        <label class="form-label col-md-2 col-sm-2 col-xs-3">Ảnh mô tả</label>
                                        <div class="col-md-10 col-sm-10 col-xs-9">
                                            @foreach($post->file as $k => $item)
                                                <div class="row" style="margin-bottom: 15px;">
                                                    <div class="col-md-5">
                                                        <img id="image-preview-image_detail{{ $k }}" class="img-fluid"
                                                             src="{{ '/public'.$item->url ?? '/public/backend/build/images/default.jpg' }}">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="image_detail[]" value="{{ $item->url }}"
                                                               id="image_detail{{ $k }}" class="form-control hidden" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class=" input-group-append">
                                                            <button
                                                                onclick="open_popup('/public/filemanager/dialog.php?type=1&popup=1&field_id=image_detail{{ $k }}')"
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
                                    @endif
                                    @if($post->file_count == 1)
                                        @foreach($post->file as $k => $item)
                                            @if($item->type == 'IMG')
                                                <label class="form-label col-md-2 col-sm-2 col-xs-3">Ảnh mô tả</label>
                                            @else
                                                <label class="form-label col-md-2 col-sm-2 col-xs-3">Video</label>
                                            @endif
                                            <div class="col-md-10 col-sm-1 col-xs-9">
                                                <div class="row" >
                                                    <div class="col-md-5">
                                                        @if($item->type == 'IMG')
                                                            <img id="image-preview-image_detail{{ $k }}" class="img-fluid"
                                                                 src="{{ $item->url ?? '/backend/build/images/default.jpg' }}">
                                                            <div class="row text-danger mess-dont-update-file" style="margin: 0px; color: red"><span>Không thể cập nhật ảnh</span></div>
                                                        @endif
                                                        @if($item->type == 'VIDEO')
                                                            <video  style="width: 500px" controls>
                                                                <source id="video-preview-video" src="{{ $item->url }}"  type="video/mp4">
                                                            </video>
                                                            <div class="row text-danger mess-dont-update-file" style="margin: 0px; color: red"><span>Không thể cập nhật video</span></div>
                                                        @endif

                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
{{--                                        <a href="{{ route('admin.PublishPage.list') }}" class="btn btn-info" type="button"><i class="fa fa-list"></i>Danh sách</a>--}}

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
