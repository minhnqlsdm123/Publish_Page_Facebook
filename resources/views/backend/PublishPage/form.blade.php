<form class="form-horizontal form-label-left" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group @if ($errors->has('message')) bad @endif">
         <label class="form-label col-md-1 col-sm-1 col-xs-3">Nội dung<span class="required"> *</span></label>
        <div class="col-md-10 col-sm-6 col-xs-12" >
            <input type="text" id="message" name="message" value="{{ old('message', $post['message'] ?? '') }}" class="form-control col-md-10 col-xs-12" />
            @if ($errors->has('message'))
                <p class="text-danger">{{ $errors->first('message') }}</p>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-md-1 col-sm-1 col-xs-3">Đăng Video</label>
        <div class="col-md-1 col-sm-2 col-xs-2">
            <input type="checkbox" name="upload_video" class="form-control upload-video"  style="padding: 0px; width: 20px; height: 20px"/>
        </div>
    </div>
    <div class="form-group form-upload-photo">
        <label class="form-label col-md-1 col-sm-1 col-xs-3">Ảnh mô tả</label>
        <div class="col-md-11 col-sm-11 col-xs-9">
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-2">
                    <img id="image-preview-image_detail" class="img-fluid" src='/backend/build/images/default.jpg'>
{{--                    <img id="image-preview-image_detail" class="img-fluid" src='{{ old('message', $post['src_photos'][0] ?? '') }}'>--}}
                </div>
                <div class="col-md-8">
                    <input type="text" name="image_detail[]" value="" id="image_detail" class="form-control" />
                </div>
                <div class="col-md-2">
                    <div class="input-group-append">
                        <button onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=image_detail')" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload"></i> Chọn</button>
                        <button class="btn btn-danger reset" data-reset="avatar" type="button"><i class="material-icons"><i class="fa fa-trash"></i> Xóa</i></button>
                    </div>
                </div>
            </div>
            <button onclick="addImage(this, 'image_detail')" class="btn btn-success w-162" type="button"><i class="fa fa-plus-circle"></i> Thêm ảnh</button>
        </div>
    </div>
    <div class="form-group form-upload-video hidden">
        <label class="form-label col-md-1 col-sm-1 col-xs-3">Video</label>
        <div class="col-md-11 col-sm-11 col-xs-9">
            <div class="row">
                <div class="col-md-2">

                    <video  style="width: 218px" controls>
                        <source id="video-preview-video" src="" class="image-fluid" type="video/mp4">
                    </video>
                </div>
                <div class="col-md-8">
                    <input type="text" name="video" value="" id="video" class="form-control" />
                </div>
                <div class="col-md-2">
                    <div class=" input-group-append">
                        <button onclick="open_popup('/filemanager/dialog.php?type=3&popup=1&field_id=video')" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload"></i> Chọn</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-md-1 col-sm-1 col-xs-3">Đăng Lập lịch</label>
        <div class="col-md-1 col-sm-2 col-xs-2">
            <input type="checkbox" name="publish-scheduled" class="form-control publish-scheduled"  style="padding: 0px; width: 20px; height: 20px"/>
        </div>
    </div>
    <div class="form-group date-time hidden">
        <label class="control-label col-md-1 col-sm-1 col-xs-3">Thoi gian</label>
        <div class="col-md-9 col-sm-6 col-xs-12" >
            <input type="datetime-local" id="datetime" name="datetime" class="form-control col-md-10 col-xs-12" />
        </div>
    </div>
    <div class="form-group status">
        <label class="form-label col-md-1 col-sm-1 col-xs-3">Trạng thái</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="status" id="status" class="form-control">
                <option value="1">Publish</option>
                <option value="2">Unpublish</option>
                </select>
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
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.upload-video').change(function() {
                if ($(this).is(':checked')) {
                    $('.form-upload-photo').addClass('hidden');
                    $('.form-upload-video').removeClass('hidden');
                } else {
                    $('.form-upload-photo').removeClass('hidden');
                    $('.form-upload-video').addClass('hidden');
                }
                return false;
            });

            $('.publish-scheduled').change(function() {
                if ($(this).is(':checked')) {
                    $('.date-time').removeClass('hidden');
                    $('.status').addClass('hidden');
                } else {
                    $('.date-time').addClass('hidden');
                    $('.status').removeClass('hidden');
                }
            })
        });
    </script>
@endsection
