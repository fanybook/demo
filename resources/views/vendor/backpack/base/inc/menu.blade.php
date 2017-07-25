<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->

        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><span>全局</span></a></li>
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/sbox') }}"><span>搜索</span></a></li>
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/cms') }}"><span>内容</span></a></li>
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/mall') }}"><span>商城</span></a></li>
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/ad') }}"><span>广告</span></a></li>
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/digg') }}"><span>挖掘</span></a></li>

        <!-- ========== End of top menu left items ========== -->
    </ul>
</div>


<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- ========================================================= -->
      <!-- ========== Top menu right items (ordered left) ========== -->
      <!-- ========================================================= -->

      <!-- <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        @if (Auth::guest())
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a></li>
            @if (config('backpack.base.registration_open'))
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/register') }}">{{ trans('backpack::base.register') }}</a></li>
            @endif
        @else
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
        @endif

       <!-- ========== End of top menu right items ========== -->
    </ul>
</div>
