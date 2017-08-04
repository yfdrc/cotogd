<!DOCTYPE html>
<html lang="cn">
<head>
    <title>cotogd</title>
    <!-- CSS And JavaScript -->
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    {!! Html::style('/public/css/app.min.css') !!}
    <!-- 可选的Bootstrap主题文件（一般不用引入） <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">  -->
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    {{--{!! Html::script('/public/js/jquery.min.js') !!}--}}
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    {!! Html::script('/public/js/app.min.js') !!}
</head>

<body>
<div class="container">
    <div class="navbar navbar-inverse">
        {{--<div class="navbar-header">--}}
        {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">--}}
        {{--<span class="icon-bar"></span>--}}
        {{--<span class="icon-bar"></span>--}}
        {{--<span class="icon-bar"></span>--}}
        {{--</button>--}}
        {{--{!! link_to("/", "主页", ["class" => "navbar-brand"]) !!}--}}
        {{--</div>--}}
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><? if (Auth::check()){ echo Cookie::get('dp'); }else{ echo '关于我们';} ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>{!! link_to("/","主页") !!}</li>
                        <li>{!! link_to("contact","联系我们") !!}</li>
                        <li>{!! link_to("about","关于系统") !!}</li>
                    </ul>
                </li>
                {{--<li class="dropdown">--}}
                {{--<a href="javascript:void(0)" clascs="dropdown-toggle" data-toggle="dropdown">统计信息<b class="caret"></b></a>--}}
                {{--<ul class="dropdown-menu">--}}
                {{--<li>{!! link_to("dianpu","总体情况") !!}</li>--}}
                {{--<li>{!! link_to("dianpu","收支情况") !!}</li>--}}
                {{--<li>{!! link_to("dianpu","签单情况") !!}</li>--}}
                {{--<li class="divider" />--}}
                {{--<li>{!! link_to("dianpu","学员情况") !!}</li>--}}
                {{--<li>{!! link_to("dianpu","店铺管理") !!}</li>--}}
                {{--</ul>--}}
                {{--</li>--}}
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">原始数据<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        {{--                        <li>{!! link_to("createform","用于开发-生成代码") !!}</li>--}}
                        <li>{!! link_to("excelTodb","自csv文件导入库") !!}</li>
                        <li>{!! link_to("excelTodb/create","数据导出Excel") !!}</li>
                        <li class="divider" />
                        <li>{!! link_to("yssjzbjz","管理原始资料-家长学员") !!}</li>
                        <li>{!! link_to("yssjzbxy","管理原始资料-员工协议") !!}</li>
                        <li>{!! link_to("yssjkkb","管理原始资料-课程扣课") !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">临时数据<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>{!! link_to("tempyonggong","管理临时员工") !!}</li>
                        <li>{!! link_to("tempkecheng","管理临时课程") !!}</li>
                        <li class="divider" />
                        <li>{!! link_to("tempjiazhang","管理临时家长") !!}</li>
                        <li>{!! link_to("tempxueyuan","管理临时学员") !!}</li>
                        <li>{!! link_to("tempxieyi","管理临时协议") !!}</li>
                        <li>{!! link_to("tempkouke","管理临时扣课") !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">资料统计<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>{!! link_to("tjmake","扣课情况") !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">基础数据<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>{!! link_to("jiazhang","家长列表") !!}</li>
                        <li>{!! link_to("xueyuan","学员列表") !!}</li>
                        <li>{!! link_to("xieyi","协议列表") !!}</li>
                        <li>{!! link_to("kouke","扣课列表") !!}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">微信管理<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>{!! link_to("wechatapiuser","微信用户") !!}</li>
                        <li>{!! link_to("wechatapigroup","微信用户组") !!}</li>
                        <li>{!! link_to("wechatapiqr","微信二维码") !!}</li>
                        {{--<li>{!! link_to("wechatshow?fname=wx01&bt=自定义菜单","自定义菜单") !!}</li>--}}
                        {{--<li>{!! link_to("wechatshow?fname=wx02&bt=群发内容","群发内容") !!}</li>--}}
                        {{--<li>{!! link_to("wechatshow?fname=wx03&bt=发送模版","发送模版") !!}</li>--}}
                        {{--<li>{!! link_to("wechatshow?fname=wx06&bt=用户标签管理","用户标签管理") !!}</li>--}}
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">系统管理<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>{!! link_to("dianpu","店铺列表") !!}</li>
                        <li>{!! link_to("user","账户列表") !!}</li>
                        <li>{!! link_to("yonggong","员工列表") !!}</li>
                        <li>{!! link_to("kecheng","课程列表") !!}</li>
                    </ul>
                </li>
            </ul>
            <div class="navbar-right">
                <?php
                if (Auth::check()){
                    echo link_to("auth/logout","注销 - " .  Cookie::get('user'),["class" => "navbar-brand"]);
                }else{
                    echo link_to("auth/login", "请登录", ["class" => "navbar-brand"]);
                    echo link_to("password/reset", "忘记密码", ["class" => "navbar-brand"]);
                }
                ?>
            </div>
        </div>

    </div>
    @yield('shortcut')
    @yield('content')
</div>
@yield('script')
</body>
</html>