@extends('backend.master')
@section('css')
<link href="{{ asset('backend/build/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<form action="" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="right_col" role="main" style="min-height: 2825px;">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Sản phẩm - Thêm mới</h3>
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <!-- form input mask -->
        <div class="col-md-6 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <br>
              <div class="form-horizontal form-label-left">
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Tên sản phẩm</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                      value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3" for="cat_id">Danh mục cha</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                    <select class="form-control" name="cat_id">
                      @if (!empty($categories))
                      @foreach (multi_category($categories, 0) as $k => $category)
                      <option value="{{ $category['id'] }}">
                        {{ str_repeat('--', $category['level']).$category['c_name'] }}
                      </option>
                      @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3" for="price">Giá bán</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="price">
                    @if ($errors->has('price'))
                    <p class="text-danger">{{ $errors->first('price') }}</p>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3" for="sale">% Giảm giá</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="sale" value="{{ old('sale') }}" class="form-control" id="sale">
                  </div>
                </div>
                {{-- <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3" for="keyword">Khóa tìm kiếm</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                    <select class="js-keyword-multiple" name="keyword[]" multiple="multiple" class="form-control">
                      <option value="AL">Alabama</option>
                      <option value="WY">Wyoming</option>
                      <option value="WY">Wyoming</option>
                      <option value="WY">Wyoming</option>
                      <option value="WY">Wyoming</option>
                    </select>
                    @if ($errors->has('keyword'))
                    <p class="text-danger">{{ $errors->first('keyword') }}</p>
                @endif
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
    <!-- /form input mask -->
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <br>
          <div class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Trạng thái</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="">
                  <label>
                    <input type="checkbox" class="js-switch" name="status" value="1" data-switchery="true"
                      style="display: none;">
                    Active
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Sản phẩm nổi bật ?</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="">
                  <label>
                    <input type="checkbox" class="js-switch" name="hot" value="1" data-switchery="true"
                      style="display: none;">
                    Nổi bật
                  </label>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /form input mask -->

  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_content">
          <br>
          <div class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-1 col-sm-1 col-xs-3">Ảnh đại diện</label>
              <div class="col-md-11 col-sm-11 col-xs-9">
                <div class="row">
                  <div class="col-md-2">
                    <img id="image-preview-avatar" class="img-fluid"
                      src="{{ old('avatar') ?? '/backend/build/images/default.jpg' }}">
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="avatar" value="{{ old('avatar') ?? '/backend/build/images/default.jpg' }}"
                      id="avatar" class="form-control" />
                  </div>
                  <div class="col-md-2">
                    <div class=" input-group-append">
                      <button
                        onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=avatar&akey={{ $keyAccessFileManagerBackend}}')"
                        class="btn btn-primary" type="button"><i class="fa fa-cloud-upload"></i> Chọn</button>
                      <button onclick="resetInput('avatar')" class="btn btn-danger reset" data-reset="avatar"
                        type="button"><i class="fa fa-trash"></i> Xóa</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_content">
          <br>
          <div class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-1 col-sm-1 col-xs-3">Ảnh mô tả</label>
              <div class="col-md-11 col-sm-11 col-xs-9">
                <div class="row" style="margin-bottom: 15px;">
                  <div class="col-md-2">
                    <img id="image-preview-image_detail" class="img-fluid" src='/backend/build/images/default.jpg'>
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="image_detail[]" value="/backend/build/images/default.jpg" id="image_detail"
                      class="form-control" />
                  </div>
                  <div class="col-md-2">
                    <div class=" input-group-append">
                      <button
                        onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=image_detail&akey={{ $keyAccessFileManagerBackend}}')"
                        class="btn btn-primary" type="button"><i class="fa fa-cloud-upload"></i> Chọn</button>
                      <button class="btn btn-danger reset" data-reset="avatar" type="button"><i
                          class="material-icons"><i class="fa fa-trash"></i> Xóa</i></button>
                    </div>
                  </div>
                </div>
                <button onclick="addImage(this, 'image_detail', '{{ $keyAccessFileManagerBackend}}')"
                  class="btn btn-success w-162" type="button"><i class="fa fa-plus-circle"></i> Thêm ảnh</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_content">
          <br>
          <div class="form-horizontal form-label-left">
            <div class="form-group">
              <label class="control-label col-md-1 col-sm-1 col-xs-2">Mô tả ngắn</label>
              <div class="col-md-11 col-sm-11 col-xs-10">
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-1 col-sm-1 col-xs-2">Chi tiết sản phẩm</label>
              <div class="col-md-11 col-sm-11 col-xs-10">
                <textarea id="ckeditor" name="content">{!! old('content') !!}</textarea>
                @if ($errors->has('content'))
                <p class="text-danger">{{ $errors->first('content') }}</p>
                @endif
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href="{{ route('admin.product.list') }}" class="btn btn-info" type="button"><i
                    class="fa fa-list"></i>
                  Danh sách</a>

                <a href="{{ route('admin.product.add') }}" class="btn btn-warning" type="reset"><i
                    class="fa fa-rotate-left"></i>
                  Làm
                  mới</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Lưu
                  lại</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--drop zone -->
  {{-- <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label class="control-label">Photos</label>
        <div class="dropzone" id="photo-dropzone">
          <input type="file" name="photo" accept="image/*" multiple hidden>
        </div>
      </div>
    </div>
  </div> --}}



  </div>
  </div>
</form>
@endsection
@section('script')
@endsection
@push('tools')
@includeIf('tools.ckeditor')
@endpush