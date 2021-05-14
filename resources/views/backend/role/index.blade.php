@extends('backend.master')
@section('content')
<div class="right_col" role="main" style="min-height: 917px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Role<small></small></h3>
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
                                    <th style="width: 20%">Name</th>
                                    <th style="width: 20%">Display name</th>
                                    <th style="width: 20%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($roles))

                                @foreach ($roles as $k => $role )
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>
                                        <a href="{{ route('admin.role.update', $role->id) }}"
                                            class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Sửa </a>
                                        <a href="{{ route('admin.role.delete', $role->id) }}"
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
</div>
@endsection