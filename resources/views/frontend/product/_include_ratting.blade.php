<div class="tab-pane fade show active" id="ratting-content" role="tabpanel" aria-labelledby="ratting-tab">
    <strong class="title-page">{{ $product->pro_review_total }} đánh giá sản phẩm: {{ $product->pro_name }} </strong>
    <div class="tool-ratting-star">
        <div class="row">
            <div class="col-md-3 col-item">
                <span
                    class="score">{{$product->pro_review_total != 0 ? round($product->pro_review_star / $product->pro_review_total, 2) : 0 }}</span>
                <span class="checked"><i class="fa fa-star" aria-hidden="true"></i></span>
            </div>
            <div class="col-md-7 col-item col-item-2">
                @foreach($rattingDefault as $key => $item)
                <div class="item">
                    <div class="">
                        <span class="checked">{{ $key }}<i class="fa fa-star ml-1" aria-hidden="true"></i></span>
                    </div>
                    <div class="progress">
                        @php
                        $percent = 0;
                        if ($product->pro_review_total) $percent = $item['count_num_star'] * 100
                        / $product->pro_review_total;
                        @endphp
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%;"
                            aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="">
                        <span>{{ $item['count_num_star'] }} đánh giá</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-md-2 col-item">
                <button type="button"
                    class="btn btn-info {{ \Auth::guard('account')->id() ? 'show-form-ratting' : 'js-check-login-account' }}">Gửi
                    đánh
                    giá</button>
            </div>
        </div>
        @if (\Request::route()->getName() == 'ratting.get.all')
        <ul class="nav tool-nav-filter-star">
            <li class="nav-item">
                <a class="nav-link disabled">Lọc theo <i class="fa fa-star checked"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Tất cả</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">5 sao</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">4 sao</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">3 sao</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">2 sao</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">1 sao</a>
            </li>
        </ul>
        @endif
        <div class="dashboard-ratting">
            <div class="vote-star">
                <p>
                    <span>Bạn đánh giá sản phẩm này mấy sao: </span>
                    <span>
                        @for ($i = 1; $i <=5; $i++) <i class="fa fa-star {{ $i == 1 ? 'checked' : '' }}"
                            data-i="{{ $i }}" aria-hidden="true">
                            </i>@endfor

                    </span>
                    <span class="reviews-text" id="reviews-text">Rất tốt</span>
                </p>
                <p class="text-success">(Click vào ngôi sao để đánh giá cho sản phẩm)</p>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('ajax.ratting.product', $product->id) }}" method="POST"
                        id="form-ratting-product">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="star_ratting" id="number_star_ratting" value="1" />
                            <textarea name="content" rows="4" class="form-control"></textarea>
                        </div>
                        <p class="error text-danger text-s-12"></p>
                        <button type="submit" name="btn-submit"
                            class="btn btn-outline-success js-send-ratting-product">Gửi đánh
                            giá</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- dashboard-ratting -->
        <div class="row">
            <div class="col-md-8">
                <div class="list-rattings-cus">
                    @include('frontend.product._include_ratting_list_item', ['rattings' => $rattings])
                </div>
            </div>
        </div>
    </div>
    <!-- end tool-ratting-star -->
    @if (\Request::route()->getName() == 'product.detail')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('ratting.get.all', [$product->pro_slug.'-'.$product->id]) }}"
                class="btn btn-outline-info">Xem
                tất cả đánh giá</a>
        </div>
    </div>
    @endif

</div>