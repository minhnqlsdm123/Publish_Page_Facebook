@extends('frontend.layout.master')
@section('content')
@include('frontend.include.slide')
<div id="wp-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="group group-sale">
                    <div class="group-header">
                        <h1 class="title-cat color-ff5722">
                            <img src="/frontend/image/sl5.png" title="" alt="" />
                            <span>Giá sốc cuối tuần</span>
                        </h1>
                        <!-- end title-cat -->
                    </div>
                    <!-- end group-header -->
                    <div class="group-content">
                        <div class="owl-carousel owl-theme">
                            <div class="item">
                                <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                <a href="" class="title">Iphone 7plus 20218</a>
                                <div class="rattings">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <ul class="menu">
                                    <li class="price-new">200.000.000 đ</li>
                                    <li class="price-old">300.000.000 đ</li>
                                </ul>
                                <div class="number-sale">
                                    <div class="percent" style="width: 20%"></div>
                                    <p class="text">Đã bán: 16</p>
                                </div>
                                <div class="label-percent">
                                    <span>20%</span>
                                </div>
                                <div class="favourite active">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="item">
                                <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                <a href="" class="title">Iphone 7plus 20218</a>
                                <div class="rattings">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <ul class="menu">
                                    <li class="price-new">200.000.000 đ</li>
                                    <li class="price-old">300.000.000 đ</li>
                                </ul>
                                <div class="number-sale">
                                    <div class="percent" style="width: 20%"></div>
                                    <p class="text">Đã bán: 16</p>
                                </div>
                                <div class="label-percent">
                                    <span>20%</span>
                                </div>
                                <div class="favourite">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end group-sale -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="group group-small">
                    <div class="group-header">
                        <h1 class="title-cat">
                            <img src="/frontend/image/sl5.png" title="" alt="" />
                            <span>Sản phẩm mới</span>
                        </h1>
                        <!-- end title-cat -->
                    </div>
                    <!-- end group-header -->
                    <div class="group-content">
                        <div class="row">
                            @if (!empty($productsNew))
                            @foreach($productsNew as $product)
                            <div class="col-md-4 col-sm-4 col-ls-2">
                                <div class="item">
                                    <a href="{{ route('product.detail', [$product->pro_slug, $product->id]) }}"
                                        class="image"><img src="{{ $product->pro_avatar }}"></a>
                                    <a href="{{ route('product.detail', [$product->pro_slug, $product->id]) }}"
                                        class="title">{{ $product->pro_name }}</a>
                                    <div class="rattings">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <ul class="menu">
                                        <li class="price-new">{{ currency_format($product->pro_price) }}</li>
                                        <li class="price-old">
                                            {{ currency_format(get_price_sale($product->pro_price, $product->pro_sale)) }}
                                        </li>
                                    </ul>
                                    <div class="number-sale">
                                        <div class="percent" style="width: 20%"></div>
                                        @if ($product->pro_pay != 0)
                                        <p class="text">Đã bán: {{ $product->pro_pay }}</p>
                                        @else
                                        <p class="text">Mới rao bán</p>
                                        @endif
                                    </div>
                                    <div class="label-percent">
                                        <span>{{ $product->pro_sale }}%</span>
                                    </div>
                                    <div class="favourite">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- end group -->
            </div>
            <div class="col-md-4">
                <div class="group">
                    <div class="group-header">
                        <h1 class="title-cat">
                            <img src="/frontend/image/sl5.png" title="" alt="" />
                            <span>Sản phẩm bán chạy</span>
                        </h1>
                        <!-- end title-cat -->
                    </div>
                    <!-- end group-header -->
                    <div class="group-content group-content-inline-block group-content-overflow ">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <div>
                                <a href="" class="title">Iphone 7plus 20218</a>
                                <div class="rattings">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <ul class="menu">
                                    <li class="price-new">200.000.000 đ</li>
                                    <li class="price-old">300.000.000 đ</li>
                                </ul>
                                <div class="number-sale">
                                    <div class="percent" style="width: 20%"></div>
                                    <p class="text">Đã bán: 16</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <div>
                                <a href="" class="title">Iphone 7plus 20218</a>
                                <div class="rattings">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <ul class="menu">
                                    <li class="price-new">200.000.000 đ</li>
                                    <li class="price-old">300.000.000 đ</li>
                                </ul>
                                <div class="number-sale">
                                    <div class="percent" style="width: 20%"></div>
                                    <p class="text">Đã bán: 16</p>
                                </div>
                                <div class="label-percent">
                                    <span>20%</span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <div>
                                <a href="" class="title">Iphone 7plus 20218</a>
                                <div class="rattings">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <ul class="menu">
                                    <li class="price-new">200.000.000 đ</li>
                                    <li class="price-old">300.000.000 đ</li>
                                </ul>
                                <div class="number-sale">
                                    <div class="percent" style="width: 20%"></div>
                                    <p class="text">Đã bán: 16</p>
                                </div>
                                <div class="label-percent">
                                    <span>20%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end group -->
            </div>
        </div>
        <!-- end row -->
        <div class="group">
            <div class="group-header">
                <h1 class="title-cat">
                    <img src="/frontend/image/sl5.png" title="" alt="" />
                    <span>Điện thoại</span>
                </h1>
                <!-- end title-cat -->
            </div>
            <!-- end group-header -->
            <div class="group-content">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end group -->
        <div class="group">
            <div class="group-header">
                <h1 class="title-cat">
                    <img src="/frontend/image/sl5.png" title="" alt="" />
                    <span>Laptop</span>
                </h1>
                <!-- end title-cat -->
            </div>
            <!-- end group-header -->
            <div class="group-content">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end group -->
        <div class="group">
            <div class="group-header">
                <h1 class="title-cat">
                    <img src="/frontend/image/sl5.png" title="" alt="" />
                    <span>Phụ kiện</span>
                </h1>
                <!-- end title-cat -->
            </div>
            <!-- end group-header -->
            <div class="group-content">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-ls-2">
                        <div class="item">
                            <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                            <a href="" class="title">Iphone 7plus 20218</a>
                            <div class="rattings">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <ul class="menu">
                                <li class="price-new">200.000.000 đ</li>
                                <li class="price-old">300.000.000 đ</li>
                            </ul>
                            <div class="number-sale">
                                <div class="percent" style="width: 20%"></div>
                                <p class="text">Đã bán: 16</p>
                            </div>
                            <div class="label-percent">
                                <span>20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end group -->
        <div class="row">
            <div class="col-md-8">
                <div class="group">
                    <div class="group-header">
                        <h1 class="title-cat">
                            <img src="/frontend/image/sl5.png" title="" alt="" />
                            <span>Phụ kiện giá rẻ</span>
                        </h1>
                        <!-- end title-cat -->
                    </div>
                    <!-- end group-header -->
                    <div class="group-content group-content-inline-block">
                        <div class="row">
                            <div class="col-md-6 col-sm-4 col-ls-2">
                                <div class="item">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="rattings">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <ul class="menu">
                                            <li class="price-new">200.000.000 đ</li>
                                            <li class="price-old">300.000.000 đ</li>
                                        </ul>
                                        <div class="number-sale">
                                            <div class="percent" style="width: 20%"></div>
                                            <p class="text">Đã bán: 16</p>
                                        </div>
                                        <div class="label-percent">
                                            <span>20%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 col-ls-2">
                                <div class="item">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="rattings">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <ul class="menu">
                                            <li class="price-new">200.000.000 đ</li>
                                            <li class="price-old">300.000.000 đ</li>
                                        </ul>
                                        <div class="number-sale">
                                            <div class="percent" style="width: 20%"></div>
                                            <p class="text">Đã bán: 16</p>
                                        </div>
                                        <div class="label-percent">
                                            <span>20%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 col-ls-2">
                                <div class="item">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="rattings">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <ul class="menu">
                                            <li class="price-new">200.000.000 đ</li>
                                            <li class="price-old">300.000.000 đ</li>
                                        </ul>
                                        <div class="number-sale">
                                            <div class="percent" style="width: 20%"></div>
                                            <p class="text">Đã bán: 16</p>
                                        </div>
                                        <div class="label-percent">
                                            <span>20%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 col-ls-2">
                                <div class="item">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="rattings">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <ul class="menu">
                                            <li class="price-new">200.000.000 đ</li>
                                            <li class="price-old">300.000.000 đ</li>
                                        </ul>
                                        <div class="number-sale">
                                            <div class="percent" style="width: 20%"></div>
                                            <p class="text">Đã bán: 16</p>
                                        </div>
                                        <div class="label-percent">
                                            <span>20%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 col-ls-2">
                                <div class="item">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="rattings">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <ul class="menu">
                                            <li class="price-new">200.000.000 đ</li>
                                            <li class="price-old">300.000.000 đ</li>
                                        </ul>
                                        <div class="number-sale">
                                            <div class="percent" style="width: 20%"></div>
                                            <p class="text">Đã bán: 16</p>
                                        </div>
                                        <div class="label-percent">
                                            <span>20%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 col-ls-2">
                                <div class="item">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="rattings">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <ul class="menu">
                                            <li class="price-new">200.000.000 đ</li>
                                            <li class="price-old">300.000.000 đ</li>
                                        </ul>
                                        <div class="number-sale">
                                            <div class="percent" style="width: 20%"></div>
                                            <p class="text">Đã bán: 16</p>
                                        </div>
                                        <div class="label-percent">
                                            <span>20%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end group -->
            </div>
            <div class="col-md-4">
                <div class="group group-article">
                    <div class="group-header">
                        <h1 class="title-cat">
                            <img src="/frontend/image/sl5.png" title="" alt="" />
                            <span>Tin tức & sự kiện</span>
                        </h1>
                        <!-- end title-cat -->
                    </div>
                    <!-- end group-header -->
                    <div class="group-content">
                        <div class="item">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                </div>
                                <div class="col-md-9">
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="description">
                                            <p>It is a long established fact that a reader will be distracted by
                                                the readable content of a page when looking at its layout. The
                                                point of using Lorem Ipsum is that it has a more-or-less normal
                                                distribution of letters</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                </div>
                                <div class="col-md-9">
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="description">
                                            <p>It is a long established fact that a reader will be distracted by
                                                the readable content of a page when looking at its layout. The
                                                point of using Lorem Ipsum is that it has a more-or-less normal
                                                distribution of letters</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="" class="image"><img src="/frontend/image/sp.jpg"></a>
                                </div>
                                <div class="col-md-9">
                                    <div>
                                        <a href="" class="title">Iphone 7plus 20218</a>
                                        <div class="description">
                                            <p>It is a long established fact that a reader will be distracted by
                                                the readable content of a page when looking at its layout. The
                                                point of using Lorem Ipsum is that it has a more-or-less normal
                                                distribution of letters</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end group -->
            </div>
        </div>
        <!-- end container -->
    </div>
</div>
<!-- end wp-content -->
@endsection