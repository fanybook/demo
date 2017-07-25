@extends('sec_base::_layout.user')
@php($active = 'order')

@section('title', '用户中心')

@section('sub-contents')
欢迎欢迎，热烈欢迎~
@endsection

@section('head-assets')
{!! style('/third-party/jquery-swipeslider/css/swipeslider.css') !!}

<style type="text/css">
.goods-list .thumbnail{
    margin-bottom: 30px;
}

.btn-cart .badge {
    border-radius: 8px !important;
    background: #fff !important;
    color: #d9534f !important;
}

.list-group-item a {
    display: block;
}

.list-group-item .badge {
    float: left;
    margin-right: 8px;
}
</style>
@endsection

@section('foot-assets')
{!! script('/third-party/jquery-swipeslider/js/swipeslider.min.js') !!}

{!! script('/assets/shop/js/cart.list.js') !!}

<script type="text/javascript">
$(function() {
    $('#content_slider').swipeslider({
        transitionDuration: 600,
        autoPlayTimeout: 10000,
        sliderHeight: '257px'
    });

    var cart = new CartList();
    cart.getItemList();
});
</script>
@endsection
