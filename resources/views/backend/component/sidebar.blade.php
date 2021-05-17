<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a href="{{ route('admin.dasboard') }}"><i class="fa fa-home"></i> Home <span
                        class="fa fa-chevron-down"></span></a>
            </li>
            <li><a><i class="fa fa-group"></i> User<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.user.list') }}">Danh sách</a></li>
                    <li><a href="{{ route('admin.user.add') }}">Thêm mới</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-cubes"></i> Danh mục bài viết của trang<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.PublishPage.list') }}">Danh sách</a></li>
                    <li><a href="{{ route('admin.PublishPage.add') }}">Thêm mới</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-cube"></i> Sản phẩm<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.product.list') }}">Danh sách</a></li>
                    <li><a href="{{ route('admin.product.add') }}">Thêm mới</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>
