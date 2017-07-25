@extends('sec_base::_layout.shop')

@section('title', '情趣用品商城')

@section('main-contents')
<div id="main-contents">
    <div class="row">
        <div class="col-xs-3">
            <div class="panel panel-default">
<!--                <div class="panel-heading">商品分类</div>-->
                @if($result['menu_index_mega'])
                <ul class="list-group">
                    @foreach($result['menu_index_mega']->top_items as $idx => $navi_item)
                    <li class="list-group-item">
                        <a href="{{ $navi_item->navi_link }}"><span class="badge">{{ $idx + 1 }}L</span> {{ $navi_item->navi_title }}</a>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="alert alert-danger" style="margin-bottom: 0;">未设置 menu_index_mega</div>
                @endif
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">热销商品</div>
                <div class="panel-body">
                    @forelse($result['goods_hot'] as $idx => $goods)
                    <div class="media">
                        <div class="media-left">
                            <a href="/goods/{{ $goods->id }}">
                                @if ($goods->goods_thumb)
                                <img class="media-object" src="{{ $goods->goods_thumb }}" alt="{{ $goods->goods_name }}" width="40px">
                                @else
                                <img class="media-object" src="/assets/base/images/noimage.jpg" alt="" width="40px">
                                @endif
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="title" title="{{ $goods->goods_name }}">{{ ellipsis_len($goods->goods_name) }}</div>
                            <div class="price"><span class="cny">￥</span><em>{{ $goods->goods_price }}</em></div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-danger" style="margin-bottom: 0;">未设置 goods_hot</div>
                    @endforelse
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">网站公告</div>
                <ul class="list-group">
                    <li class="list-group-item">正在装修中...</li>
                    <li class="list-group-item">网站部署上线</li>
                </ul>
            </div>
        </div>

        <div class="col-xs-9" style="padding-left: 5px;">
            <div class="panel panel-default">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    @if($result['slider_index'])
                        @foreach($result['slider_index']->top_items as $idx => $navi_item)
                        <div class="swiper-slide"><a href="{{ $navi_item->navi_link }}"><img src="{{ $navi_item->navi_image or '/assets/base/images/noimage.jpg' }}" alt=""></a></div>
                        @endforeach
                    @else
                        <div class="swiper-slide"><a href="#"><img src="/assets/base/images/noimage.jpg" alt=""></a></div>
                    @endif
                    </div>

                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">推荐商品</div>
                <div class="panel-body goods-list" style="min-height: 600px;">
                    @forelse ($result['goods_recommend'] as $goods)
                    <div class="col-xs-3">
                        <a href="/goods/{{ $goods->id }}" title="{{ $goods->goods_name }}">
                            <div class="thumbnail">
                                @if ($goods->goods_thumb)
                                <img src="{{ $goods->goods_thumb }}" alt="{{ $goods->goods_name }}">
                                @else
                                <img src="/assets/base/images/noimage.jpg" alt="">
                                @endif
                                <div class="caption">
                                    <p class="ellipsis">{{ $goods->goods_name }}</p>
                                    <div class="price text-right"><span class="cny">￥</span><em>{{ $goods->goods_price }}</em></div>
    <!--                                <p><a href="/goods/{{ $goods->id }}" class="btn btn-xs btn-primary" role="button">商品详情</a> <a href="#" class="btn btn-xs btn-default" role="button">加入<i class="fa fa-cart-plus"></i></a></p>-->
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="alert alert-danger" style="margin-bottom: 0;">未设置 goods_recommend</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('head-assets')
{!! style('/third-party/jquery-swiper/css/swiper.min.css') !!}

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

.swiper-container,
.swiper-container img {
    width: 100%;
    height: 257px;
}
</style>
@endsection

@section('foot-assets')
{!! script('/third-party/jquery-swiper/js/swiper.jquery.min.js') !!}

<script type="text/javascript">
$(function() {
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        spaceBetween: 30
    });
});
</script>
@endsection
