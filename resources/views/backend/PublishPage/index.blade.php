@extends('backend.master')
@section('content')
<div class="right_col" role="main" style="min-height: 917px;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Danh mục <small></small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="message"
                                value="" placeholder="Nội dung...">
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
                        <table class="table table-striped projects" id="tblPublishPage">
                            <thead>
                                <tr>
                                    <th style="width: 20%">#</th>
                                    <th style="width: 20%">ID</th>
                                    <th style="width: 20%">Message</th>
                                    <th style="width: 20%">Trạng thái</th>
                                    <th style="width: 20%">action</th>
                                </tr>
                            </thead>
                            <tbody>
{{--                            {{dd($posts)}}--}}
                                @if (!empty($posts))
                                @foreach ($posts as $k => $post)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>
                                        <a>{{ $post['post_id'] }}</a>
                                    </td>
                                    @if (!empty($post['message']))
                                    <td><a>{{ $post['message'] }}</a></td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        @if($post['status'] == 1)
                                           <span class="text-success">Published</span>
                                        @elseif($post['status'] == 2)
                                            <span class="text-danger">Unpublished</span>
                                        @else
                                            <span class="text-warning">Published Scheduled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post['status'] == 1 || $post['status'] == 3)

                                        <a href="{{ route('admin.PublishPage.update', $post['id']) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Sửa </a>
                                            @elseif($post['status'] == 2)
                                            <a href="{{ route('admin.PublishPage.repost', $post['id']) }}" onclick="return confirm('Bạn chắc chắn muốn đăng lại bài viết')" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>Dang lai</a>
                                        @endif
                                            <a href="{{ route('admin.PublishPage.delete', [$post['id']]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Bạn chắc chắn muốn xóa')"><i  class="fa fa-trash-o"></i> Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $posts->links() }}
                        </div>
                        <!-- end project list -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{{--    <script>--}}
    {{--    $(function() {--}}
    {{--        $('#tblPublishPage').DataTable({--}}
    {{--            processing: true,--}}
    {{--            serverSide: true,--}}
    {{--            ajax: '{{route('admin.PublishPage.dataTable')}}',--}}
    {{--            columns: [--}}
    {{--                {data:'id', name: 'id'},--}}
    {{--                {data:'message', name: 'message'},--}}
    {{--                // {data:'created_at', name: 'created_at'},--}}
    {{--                // {data:'action', name: 'action'},--}}
    {{--            ]--}}

    {{--        });--}}
    {{--    });--}}
    {{--</script>--}}
@endsection
