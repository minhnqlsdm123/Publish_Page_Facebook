<div class="item-cus mb-4 mt-2">
    <p>
        <strong>{{ $ratting->account->name }}</strong>
        <span class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
        <span class="text-success">Đã mua tại của hàng</span>
    </p>
    <p>
        <span class="mr-2">
            @for ($j = 1;$j<=5;$j++) <i class="fa fa-star {{ $j <= $ratting->r_num_star ? 'checked' : '' }}"
                aria-hidden="true"></i>
                @endfor
        </span>
        <span>{{ $ratting->r_content }}</span>
    </p>
    <p class="color-gray text-s-12">
        <i class="fa fa-clock-o" aria-hidden="true"></i>
        <span>Đánh giá {{ $ratting->created_at }}</span>
    </p>
</div>