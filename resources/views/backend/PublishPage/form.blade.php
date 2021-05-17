<form class="form-horizontal form-label-left" action="" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="form-group @if ($errors->has('message')) bad @endif">
            <label class="control-label col-md-1 col-sm-1 col-xs-3">Trạng thái<span class="required"> *</span></label>
            <div class="col-md-9 col-sm-6 col-xs-12" >
                <input type="text" id="message" name="message" value="{{ old('message', $post['message'] ?? '') }}" class="form-control col-md-10 col-xs-12" />
                @if ($errors->has('message'))
                    <p class="text-danger">{{ $errors->first('message') }}</p>
                @endif
            </div>
        </div>
    <div class="form-group">
        <label class="control-label col-md-1 col-sm-1 col-xs-3">Ảnh mô tả</label>
        <div class="col-md-11 col-sm-11 col-xs-9">
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-2">
                    <img id="image-preview-image_detail" class="img-fluid" src='/backend/build/images/default.jpg'>
                    {{--                            <img id="image-preview-image_detail" class="img-fluid" src='{{ old('message', $post['src_photos'][0] ?? '') }}'>--}}
                </div>
                <div class="col-md-8">
                    <input type="text" name="image_detail[]" value="/backend/build/images/default.jpg" id="image_detail" class="form-control" />
                </div>
                <div class="col-md-2">
                    <div class=" input-group-append">
                        <button onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=image_detail')" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload"></i> Chọn</button>
                        <button class="btn btn-danger reset" data-reset="avatar" type="button"><i class="material-icons"><i class="fa fa-trash"></i> Xóa</i></button>
                    </div>
                </div>
            </div>
            <button onclick="addImage(this, 'image_detail')" class="btn btn-success w-162" type="button"><i class="fa fa-plus-circle"></i> Thêm ảnh</button>
        </div>
    </div>
{{--    <div class="ln_solid"></div>--}}
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <a href="{{ route('admin.PublishPage.list') }}" class="btn btn-info" type="button"><i class="fa fa-list"></i>Danh sách</a>

            <a href="{{ route('admin.PublishPage.add') }}" class="btn btn-warning" type="reset"><i class="fa fa-rotate-left"></i> Làm mới</a>
            <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Lưu lại</button>
        </div>
    </div>
</form>
