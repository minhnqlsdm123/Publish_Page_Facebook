<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-group"></i>Quản lý Người dùng<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.user.list') }}">Danh sách</a></li>
{{--                    <li><a href="{{ route('admin.user.add') }}">Thêm mới</a></li>--}}
                </ul>
            </li>
            <li><a><i class="fa fa-cubes"></i>Quản lý bài viết<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.PublishPage.list') }}">Danh sách</a></li>
                    <li><a href="{{ route('admin.PublishPage.add') }}">Thêm mới</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
