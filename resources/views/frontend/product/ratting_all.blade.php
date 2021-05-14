@extends('frontend.layout.master')
@section('content')
<div class="container bg-color-white pb-5">
    @include('frontend.product._include_ratting')
</div>
@endsection
@section('script')
<script>
    //ajax phân trang ratting-all
    $(document).ready(function() {
        $('body').on('click', '.pagination > li > a', function(event) {
            event.preventDefault();
            let URL = $(this).attr('href');
            getAjaxPaginate(URL);
        });
        function getAjaxPaginate(URL) {
            $.ajax({
                method: 'GET',
                url: URL
            }).done(function(data) {
                // console.log(data);
                $('.list-rattings-cus .item-cus').remove();
                $('.list-rattings-cus').html(data.html);
                $("html, body").animate({ scrollTop: 0 }, 1500);
            });
        }
    });
</script>
@stop