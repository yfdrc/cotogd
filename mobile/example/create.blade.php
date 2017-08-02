<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>绑定微信号</title>
    <link rel="stylesheet" href="{{url('public')}}/weui/weui.min.css" />
    <link rel="stylesheet" href="{{url('public')}}/weui/example.css" />
</head>
<body ontouchstart>

<div class="container" id="container"></div>

<script type="text/html" id="tpl_home">
    <div class="page">
        <div class="page__hd">
            <h1 class="page__title">绑定微信号</h1>
            <p class="page__desc">利用家长手机号绑定微信号</p>
        </div>
        <div class="page__bd_spacing">
            {!! Form::open(["url"=>"bingjiazhang","method"=>"POST","class"=>"form-horizontal"]) !!}
            <div class="weui-cells__title">请输入如下信息</div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" id="tel" type="text" placeholder="请输入手机号"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">家长姓名</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" id="name" type="text" placeholder="请输入家长姓名"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">小孩1姓名</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" id="xh1name" type="text" placeholder="请输入小孩1姓名"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">小孩2姓名</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" id="xh2name" type="text" placeholder="请输入小孩2姓名"/>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">小孩3姓名</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" id="xh3name" type="text" placeholder="请输入小孩3姓名"/>
                    </div>
                </div>
                <div class="weui-btn-area">
                    <a type='submit' class="weui-btn weui-btn_primary">确定</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="page__ft">
            <a href="javascript:home()"><img src="{{url('public')}}/weui/images/icon_footer_link.png" /></a>
        </div>
    </div>
</script>


<script src="{{url('public')}}/weui/zepto.min.js"></script>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="https://res.wx.qq.com/open/libs/weuijs/1.0.0/weui.min.js"></script>
<script src="{{url('public')}}/weui/example.js"></script>
</body>
</html>
