<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- form input mask -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <br>
                    <div class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="name">Tên sản
                                phẩm</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <input type="text" name="name" value="{{ old('name', $product->pro_name) }}"
                                    class="form-control" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="cat_id">Danh mục
                                cha</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <select class="form-control" name="cat_id">
                                    @if (!empty($categories))
                                    @foreach (multi_category($categories, 0) as $k => $category)
                                    <option value="{{ $category['id'] }}"
                                        {{ $product->pro_cat_id == $category['id'] ? "selected" : '' }}>
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
                                <input type="number" name="price" value="{{ old('price', $product->pro_price) }}"
                                    class="form-control" id="price">
                                @if ($errors->has('price'))
                                <p class="text-danger">{{ $errors->first('price') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="sale">% Giảm
                                giá</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <input type="text" name="sale" value="{{ old('sale', $product->pro_sale) }}"
                                    class="form-control" id="sale">
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
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Mô tả ngắn</label>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <textarea class="form-control"
                            name="description">{{ old('description', $product->pro_description) }}</textarea>
                        @if ($errors->has('description'))
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Chi tiết sản phẩm</label>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <textarea class="form-control" id="ckeditor"
                            name="content">{!! old('content', $product->pro_content) !!}</textarea>
                        @if ($errors->has('content'))
                        <p class="text-danger">{{ $errors->first('content') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /form input mask -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <br>
                <div class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Trạng thái</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="">
                                <label>
                                    <input type="checkbox" class="js-switch" name="status"
                                        value="{{ $product->pro_status }}"
                                        {{ $product->pro_status == 1 ? "checked" : '' }} data-switchery="true"
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
                                    <input type="checkbox" class="js-switch" name="hot" value="{{ $product->pro_hot }}"
                                        {{ $product->pro_hot == 1 ? "checked" : '' }} data-switchery="true"
                                        style="display: none;">
                                    Nổi bật
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Ảnh đại diện</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <input type="file" name="avatar"
                                value="{{ $product->pro_avatar ?? '/backend/build/images/default.jpg' }}" id="avatar"
                                class="form-control" onchange="loadFile(event)" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3"></label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <img src="{{ asset(pare_url_file($product->pro_avatar)) }}" height="100px"
                                id="showAvatar" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /form input mask -->

    </div>
</form>