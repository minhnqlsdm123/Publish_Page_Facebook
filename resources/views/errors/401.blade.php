@extends('backend.master')
@section('content')
<div class="right_col" role="main" style="min-height: 917px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-5">
                <h3>Bạn không có quyền trong tác vụ này</h3>
                <img src="{{ asset('backend/build/images/loading.gif') }}" />
            </div>
        </div>
    </div>
</div>
@endsection