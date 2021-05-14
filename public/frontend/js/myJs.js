$(document).ready(function() {
    //scroll top
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $("#goTop").fadeIn();
            $('#main-menu').addClass('active');
        } else {
            $("#goTop").fadeOut();
            $('#main-menu').removeClass('active');
        }
    });
    $("#goTop").click(function() {
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

    //respon menu 
    $('#wp-header .tools li .icon-nav-menu').click(function(event) {
        event.preventDefault();
        let $this = $(this);
        $('#main-menu').toggleClass('active-responsive');
    });

    //carousel
    $(".group .owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 5,
            },
        },
    });
    $(".popover-dismiss").popover({
        trigger: "focus",
    });

    // slide gallery
    $("#image-gallery").lightSlider({
        gallery: true,
        item: 1,
        loop: true,
        thumbItem: 9,
        slideMargin: 0,
        enableDrag: false,
        currentPagerPosition: "left",
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: "#imageGallery .lslide",
            });
        },
    });

    //rattings
    $('.show-form-ratting').click(function(event) {
        event.preventDefault();
        let $this = $(this);
        $('.dashboard-ratting').slideToggle();
        $this.toggleClass('active');

        if ($this.hasClass('active')) {
            $this.text('Đóng form');
        } else {
            $this.text('Gửi đánh giá');
        }
    });

    let $itemI = $('.dashboard-ratting .vote-star i');
    let arrTextRating = {
        1: "Không thích",
        2: "Tạm được",
        3: "Bình thường",
        4: "Rất tốt",
        5: "Tuyệt vời"
    }

    $itemI.mouseover(function() {
        let $this = $(this);
        let $i = $this.attr('data-i');
        $itemI.removeClass('checked');
        $itemI.each(function(key, value) {
            if (key + 1 <= $i) {
                $(this).addClass('checked')
            }
        })
        $("#reviews-text").text(arrTextRating[$i]);
        $('#number_star_ratting').val($i);
    });

    //Check phải đăng nhập mới được xài tính năng này
    $('.js-check-login-account').click(function(event) {
        event.preventDefault();
        toastr.warning('Vui lòng đăng nhập để thực hiện tính năng này');
    });

    //Add sản phẩm yêu thích
    $('.ajax-add-favourite-product').click(function(event) {
        event.preventDefault();
        $(this).addClass('active');
        let URL = $(this).attr('href');
        if (URL) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: URL
            }).done(function(data) {
                if (data.code == 1) {
                    toastr.success('Yêu thích thành công');
                } else {
                    toastr.warning('Sản phẩm này bạn đã yêu thích');
                }
            });
        }
    });
    //Đánh giá ratting
    $('.js-send-ratting-product').click(function(event) {
        event.preventDefault();
        let $this = $(this);
        let URL = $('#form-ratting-product').attr('action');
        let data = $(this).parent('form').serialize();
        if (URL) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: URL,
                data: data,
            }).done(function(result) {
                if (result.error) {
                    $('#form-ratting-product .error').show();
                    $('#form-ratting-product .error').text(result.error);
                }
                if (result.message) {
                    toastr.success(result.message);
                    $('#form-ratting-product .error').hide(300);
                    $('.show-form-ratting').trigger('click');
                    $('#form-ratting-product')[0].reset();
                    if (result.html) {
                        $('.list-rattings-cus').prepend(result.html);
                        $('.list-rattings-cus .item-cus:nth-child(3)').hide(300);
                    }
                }
            });
        }
    });



});