@extends('_layouts.front')
@php($unfolded = 'home')

@section('title', '防范一下，没有坏处')

@section('content-wrapper')
    <!-- Main content -->
    <section class="content main">
<div class="tree" style="min-height: 500px;">
<ul>
    <li class="parent_li">
        <span title="收起目录"><i class="fa fa-clock-o"></i> 全职高手 - 时间线（复习）</span>
        <ul>    <li class="parent_li" style="display: list-item;">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 序篇</span><ul>    <li>        <span><i class="glyphicon"></i> 1.为什么养猫</span>    </li>    <li>        <span><i class="glyphicon"></i> 2.为什么要养英短</span>    </li>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/4">3.买猫常见的坑</a></span>    </li>    <li>        <span><i class="glyphicon"></i> 4.养几只猫最适合</span>    </li>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/12">5.非血统猫和血统猫分别适合那些人？</a></span>    </li></ul>    </li>    <li class="parent_li" style="display: list-item;">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 一、品种篇</span><ul>    <li class="parent_li">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 1.英国短毛猫（英短）</span><ul>    <li>        <span><i class="glyphicon"></i> 1.品相要求</span>    </li>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/3">2.英短的颜色代码</a></span>    </li></ul>    </li>    <li>        <span><i class="glyphicon"></i> 2.美国短毛猫（美短）</span>    </li>    <li>        <span><i class="glyphicon"></i> 3.异国短毛猫（异短，加菲）</span>    </li>    <li>        <span><i class="glyphicon"></i> 4.暹罗猫</span>    </li>    <li>        <span><i class="glyphicon"></i> 5.布偶猫</span>    </li>    <li>        <span><i class="glyphicon"></i> 6.波斯猫</span>    </li>    <li>        <span><i class="glyphicon"></i> 7.其他猫</span>    </li></ul>    </li>    <li class="parent_li" style="display: list-item;">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 二、饲养篇</span><ul>    <li>        <span><i class="glyphicon"></i> 1.喂食</span>    </li>    <li>        <span><i class="glyphicon"></i> 2.驱虫</span>    </li>    <li>        <span><i class="glyphicon"></i> 3.逗猫</span>    </li>    <li>        <span><i class="glyphicon"></i> 4.卫生</span>    </li></ul>    </li>    <li class="parent_li" style="display: list-item;">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 三、疾病篇</span><ul>    <li>        <span><i class="glyphicon"></i> 1.猫鼻支</span>    </li>    <li>        <span><i class="glyphicon"></i> 2.猫癣</span>    </li>    <li>        <span><i class="glyphicon"></i> 3.猫瘟</span>    </li>    <li>        <span><i class="glyphicon"></i> 4.猫传腹（绝症）</span>    </li>    <li>        <span><i class="glyphicon"></i> 5.尿路感染</span>    </li>    <li>        <span><i class="glyphicon"></i> 6.其他病</span>    </li></ul>    </li>    <li class="parent_li" style="display: list-item;">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 四、猫舍篇</span><ul>    <li>        <span><i class="glyphicon"></i> 1.养几只猫最适合</span>    </li>    <li>        <span><i class="glyphicon"></i> 2.注册那些协会</span>    </li>    <li>        <span><i class="glyphicon"></i> 3.器具的选择</span>    </li>    <li>        <span><i class="glyphicon"></i> 4.种猫的来源</span>    </li>    <li>        <span><i class="glyphicon"></i> 5.如何运营维持</span>    </li></ul>    </li>    <li class="parent_li" style="display: list-item;">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 五、繁育篇</span><ul>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/2">1.猫的毛色遗传规律</a></span>    </li></ul>    </li>    <li class="parent_li" style="display: list-item;">        <span title="收起目录"><i class="glyphicon glyphicon-minus-sign"></i> 六、比赛篇</span><ul>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/9">1.国内比赛现状</a></span>    </li>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/7">2.WCF的比赛头衔</a></span>    </li>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/5">3.CFA的比赛头衔</a></span>    </li>    <li>        <span><i class="glyphicon"></i> <a href="/blog/article/6">4.做好准备成为优秀的赛猫</a></span>    </li></ul>    </li></ul>
    </li>
</ul>
</div>
    </section>
@endsection

@section('head-assets')

<link href="http://www.54mz.com/third-party/bootstrap-tree/bootstrap-tree.css" rel="stylesheet">

@endsection

@section('foot-assets')
<!-- Page script -->
<script>
  $(function () {

  });
</script>
@endsection
