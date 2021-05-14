<div class="">
    <a href="#" id="goTop" style="display: inline;">↑</a>
</div>
<div class="container banner-fixed">
    <div class="item banner-left">
        <a href="" class="image"><img src="/frontend/image/banner.jpg" /></a>
    </div>
    <div class="item banner-right">
        <a href="" class="image"><img src="/frontend/image/banner.jpg" /></a>
    </div>
</div>
<!-- end banner-fixed -->
<div id="wp-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>GADGET STORE</h3>
                <ul>
                    <li><a>Giới thiệu về Gadget Store</a></li>
                    <li><a>Qui chế chuyển hàng</a></li>
                    <li><a>Thông báo khuyeens mại</a></li>
                    <li><a>Tra cứu đơn hàng</a></li>
                    <li><a>Liên hệ với Gadget Store</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Chăm sóc khách hàng</h3>
                <ul>
                    <li><a>Chính sách thanh toán</a></li>
                    <li><a>Chính sách bảo hành</a></li>
                    <li><a>Chính sách đổi trả</a></li>
                    <li><a>Chính sách giao hàng</a></li>
                    <li><a>Hướng dẫn mua hàng</a></li>
                    <li><a>Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>HOTLINE</h3>
                <ul>
                    <li><a>Phone: +84 123456789</a></li>
                    <li><a>Máy lẻ: 1900 00067</a></li>
                    <li><a>Email: info@gmail.com</a></li>
                </ul>
                <a class="img_sucrib"><img src="/frontend/image/img_sucrib.png"></a>
                <h3 class="bill">Chấp nhận thanh toán bởi</h3>
                <a class="img_bill"><img src="/frontend/image/img_nl.png"></a>
            </div>
            <div class="col-md-3">
                <h3>Fanpage</h3>
                <div class="ifames_face">
                    {{-- <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fwestartvnp%2F&tabs=timeline&width=288px&height=192px&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                        width="288px" height="192px" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                        allowTransparency="true" allow="encrypted-media"></iframe> --}}
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end wp-footer -->
<div id="footer_bottrom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Công ty cổ phần Gadget Store</h3>
                <p>Số 72 Lê Thánh Tôn, Phường Bến Nghé, Quận 1,</p>
                <p>Thành phố Hồ Chí Minh, Việt Nam.</p>
                <p>Điện thoại:HN - 024-3975.9568, HCM - 028-3975-9568.Email: info@gmail.com.</p>
            </div>
        </div>
    </div>
</div>

</div>
<!-- end wrapper -->
<script src="/frontend/bootstrap/js/jquery-3.3.1.min.js"></script>
{{-- <script src="/frontend/bootstrap/js/popper.min.js"></script> --}}
<script src="/frontend/bootstrap/js/bootstrap.min.js"></script>
<script src="/frontend/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/frontend/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
<script src="/frontend/js/myJs.js"></script>
<script src="/frontend/js/lightslider.js"></script>
<script src="/frontend/js/lightgallery-all.min.js"></script>
<script src="/backend/build/js/toastr.min.js"></script>
<script type="text/javascript">
    if (typeof TYPE_MESSAGE != "undefined")
                {
                    switch (TYPE_MESSAGE) {
                        case 'success':
                        toastr.success(MESSAGE)
                        break;
                        case 'warning':
                        toastr.warning(MESSAGE)
                        break;
                        case 'info':
                        toastr.info(MESSAGE)
                        break;
                        case 'error':
                        toastr.error(MESSAGE)
                        break;
                    }
                }
</script>
@yield('script')
</body>

</html>