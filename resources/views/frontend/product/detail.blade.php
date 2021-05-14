@extends('frontend.layout.master')
@section('content')
<div class="container bg-color-white pt-5 pb-5" id="wp-detail-product">
    <div class="row mb-5">
        <div class="col-md-7">
            <ul id="image-gallery" class="gallery list-unstyled">
                @foreach($product->pro_image_detail as $image)
                <li data-thumb="{{ str_replace('upload', 'thumbs', $image) }}" class="lslide">
                    <img src="{{ $image }}" alt="{{ $product->pro_name }}" title="{{ $product->pro_name }}" />
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-5">
            <div class="detail-product">
                <h3 class="title">{{ $product->pro_name }}</h3>
                <ul class="menu">
                    <li class="price price-new">{{ currency_format($product->pro_price) }}</li>
                    <li class="price price-old">
                        {{ currency_format(get_price_sale($product->pro_price, $product->pro_sale)) }}</li>
                </ul>
                <div class="interactive">
                    <div class="rattings">
                        @php
                        $numStar = 0;
                        if ($product->pro_review_total) $numStar = round($product->pro_review_star /
                        $product->pro_review_total, 2);
                        @endphp
                        @for($i = 1; $i <=5; $i++) <span class="fa fa-star {{ $i <= $numStar ? 'checked' : '' }}">
                            </span> @endfor
                    </div>
                    <div><i class="fa fa-eye" aria-hidden="true"></i><span>: {{ $product->pro_view }} lượt xem</span>
                    </div>
                </div>
                <div class="description">
                    {{ $product->pro_description }}
                </div>
                <div class="button">
                    <select name="sl_buy" class="sl_buy">
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                    </select>
                    <button type="button" class="btn-add-cart"><i class="fa fa-shopping-cart"
                            aria-hidden="true"></i>Chọn mua</button>
                    <a href="{{ route('ajax-favourite-product', $product->id) }}"
                        class="favourite {{ \Auth::guard('account')->id() ? 'ajax-add-favourite-product' : 'js-check-login-account' }}"><i
                            class="fa fa-heart"></i></a>
                </div>
            </div>
            <!-- end detail-product -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="group group-sale">
                <div class="group-header">
                    <h1 class="title-cat">
                        <img src="/frontend/image/sl5.png" title="" alt="" />
                        <span>Chi tiết sản phẩm</span>
                    </h1>
                    <!-- end title-cat -->
                </div>
            </div>
            <div>
                {!! $product->pro_content !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="list_product_same">
                <div class="item">
                    <ul>
                        <li>
                            <a href="" class="thumb">
                                <img src="/frontend/image/sp.jpg" />
                            </a>
                        </li>
                        <li>
                            <a href="" class="title">Ốp lưng Galaxy Tab A Plus 10 inch</a>
                            <span class="price">150.000 đ</span>
                        </li>
                    </ul>
                </div>
                <div class="item">
                    <ul>
                        <li>
                            <a href="" class="thumb">
                                <img src="/frontend/image/sp.jpg" />
                            </a>
                        </li>
                        <li>
                            <a href="" class="title">Ốp lưng Galaxy Tab A Plus 10 inch</a>
                            <span class="price">150.000 đ</span>
                        </li>
                    </ul>
                </div>
                <div class="item">
                    <ul>
                        <li>
                            <a href="" class="thumb">
                                <img src="/frontend/image/sp.jpg" />
                            </a>
                        </li>
                        <li>
                            <a href="" class="title">Ốp lưng Galaxy Tab A Plus 10 inch</a>
                            <span class="price">150.000 đ</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end content-product -->
<div id="">
    <div class="container bg-color-white pt-3 pb-5">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="comment-tab" data-toggle="tab" href="#comment-content" role="tab"
                            aria-controls="comment-content" aria-selected="false">Bình luận</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="ratting-tab" data-toggle="tab" href="#ratting-content" role="tab"
                            aria-controls="ratting-content" aria-selected="true">Đánh giá</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    @include('frontend.product._include_comment')
                    @include('frontend.product._include_ratting', ['product' => $product])
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
@stop