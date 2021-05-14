$(document).ready(function () {
    //scroll top
    $(window).scroll(function () {
    	if ($(this).scrollTop() > 100) {
    		$("#goTop").fadeIn();
            $('#main-menu').addClass('active');
    	} else {
    		$("#goTop").fadeOut();
            $('#main-menu').removeClass('active');
    	}
    });
    $("#goTop").click(function () {
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
    	onSliderLoad: function (el) {
    		el.lightGallery({
    			selector: "#imageGallery .lslide",
    		});
    	},
    });

    //rattings
    $('.show-form-ratting').click(function(event) {
    	event.preventDefault();
    	let $this = $(this);
    	$this.toggleClass('active');
    	$('.dashboard-ratting').slideToggle();
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
    	$itemI.each(function (key, value) {
    		if (key + 1 <= $i) {
    			$(this).addClass('checked')
    		}
    	})
    	$("#reviews-text").text(arrTextRating[$i]);
    });

});
