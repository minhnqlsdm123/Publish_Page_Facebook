@extends('backend.master')
@section('content')
<div class="right_col" product="main" style="min-height: 917px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Sản phẩm<small></small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
                    <form action="" method="GET">
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
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Danh sách</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- start project list -->
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 1%">#</th>
                                    <th style="width: 20%">Tên sản phẩm</th>
                                    <th style="width: 15%">Avatar</th>
                                    <th style="width: 15%">Danh mục cha trực tiếp</th>
                                    <th style="width: 10%">Trạng thái</th>
                                    <th style="width: 10%">Sản phẩm hot</th>
                                    <th style="width: 20%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($products))

                                @foreach ($products as $k => $product )
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>
                                        {{ $product->pro_name }}
                                        <p class="text-success">(giá: {{ $product->pro_price }} - giảm giá:
                                            {{ $product->pro_sale }} %)</p>
                                    </td>
                                    <td>
                                        <img src="{{ asset($product->pro_avatar) }}" height="70px" />
                                    </td>
                                    <td>
                                        <span class="text-success">{{ $product->category->c_name }}</span>
                                    </td>
                                    <td>
                                        <a href=""
                                            class="btn btn-{{ $product->getStatus($product->pro_status)['class'] }} btn-xs">{{ $product->getStatus($product->pro_status)['name'] }}</a>
                                    </td>
                                    <td>
                                        <a href=""
                                            class="btn btn-{{ $product->getHot($product->pro_hot)['class'] }} btn-xs">{{ $product->getHot($product->pro_hot)['name'] }}</a>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-xs btn-view-product" data-toggle="modal"
                                            data-target="#myModal" idProduct="{{ $product->id }}"><i
                                                class="fa fa-folder"></i> View
                                        </a>
                                        <a href="{{ route('admin.product.update', $product->id) }}"
                                            class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Sửa </a>
                                        <a href="{{ route('admin.product.delete', $product->id) }}"
                                            class="btn btn-danger btn-xs"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa')"><i
                                                class="fa fa-trash-o"></i> Xóa
                                        </a>
                                    </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                        <!-- end project list -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-view">
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">#ID: <span></span></h4>
                    </div>
                    <div class="modal-body modal-body-render">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.btn-view-product').click(function(event) {
            event.preventDefault();
            var idProduct = $(this).attr('idProduct');
            var data = {idProduct: idProduct};
            $.ajax({
                method: 'GET',
                url: '{{ route('admin.product.ajax.modal') }}',
                data: data,
            }).done(function(result) {
                $('.modal-body-render').html(result.html);
                $('#myModalLabel span').html(result.idProduct);
            });
        });
    });
</script>
@endsection
@push('tools')
@includeIf('tools.ckeditor')
@endpush