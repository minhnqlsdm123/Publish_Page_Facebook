<form class="form-horizontal form-label-left" action="" method="POST">
    @csrf
    <div class="form-group @if ($errors->has('name')) bad @endif">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tên danh mục
            <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" id="name" name="name" value="{{ old('name', $category->c_name ?? '') }}"
                class="form-control col-md-7 col-xs-12">
            @if ($errors->has('name'))
            <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Danh mục cha
            <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select id="heard" class="form-control" name="parent_id">
                <option value="">------Chọn danh mục cha-------</option>
                @if (!empty($categories))
                @foreach (multi_category($categories, 0) as $cat)
                <option value="{{ $cat['id'] }}"
                    {{ isset($category) ? $category->c_parent_id == $cat['id'] : '' ? 'selected' : '' }}>
                    {{ str_repeat('--', $cat['level']).$cat['c_name'] }}</option>
                @endforeach
                @endif

            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Trạng thái</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="">
                <label>
                    <input type="checkbox" class="js-switch" name="status"
                        {{ isset($category) ? $category->c_status == 0 : '' ? "" : "checked" }} data-switchery="true"
                        style="display: none;">
                    {{ isset($category) ? $category->c_status == 0 : '' ? "Private" : "Active"  }}
                </label>
            </div>
        </div>
    </div>
    <div class="form-group @if ($errors->has('keyword')) bad @endif">
        <label for="keyword" class="control-label col-md-3 col-sm-3 col-xs-12">Keyword</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="keyword" class="form-control col-md-7 col-xs-12" type="text" name="keyword"
                value="{{ old('keyword', $category->c_keyword ?? '') }}">
            @if ($errors->has('keyword'))
            <p class="text-danger">{{ $errors->first('keyword') }}</p>
            @endif
        </div>
    </div>
    <div class="form-group @if ($errors->has('description')) bad @endif">
        <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Mô tả
            ngắn<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea id="description" name="description" class="form-control"
                name="description">{{ old('description', $category->c_description ?? '') }}</textarea>
            @if ($errors->has('description'))
            <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
    </div>
    <div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <a href="{{ route('admin.category.list') }}" class="btn btn-info" type="button"><i class="fa fa-list"></i>
                Danh sách</a>

            <a href="{{ route('admin.category.add') }}" class="btn btn-warning" type="reset"><i
                    class="fa fa-rotate-left"></i> Làm
                mới</a>
            <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Lưu
                lại</button>
        </div>
    </div>
</form>