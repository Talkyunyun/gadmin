<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>欢迎访问系统</title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_8o6kbss0lz44e7b9.css">
<link rel="stylesheet" href="{{ asset('master/h-ui/css/H-ui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('master/h-ui.admin/css/H-ui.admin.css') }}?v=1.0" />
<link rel="stylesheet" href="{{ asset('master/h-ui.admin/skin/default/skin.css') }}" id="skin" />
<link rel="stylesheet" href="{{ asset('master/h-ui.admin/css/style.css') }}" />
</head>
<body>

{{-- header --}}
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl">
            <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/">后台系统</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">v1.0</span>
            <a aria-hidden="false" class="nav-toggle visible-xs fa fa-bars" href="javascript:;"></a>
            <nav class="nav navbar-nav">
                <ul class="cl">
                    <li class="dropDown dropDown_hover">
                        <a href="javascript:;" class="dropDown_A">
                            <i class="fa fa-plus-circle"></i> 新增 <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li>
                                <a href="javascript:;" onclick="product_add('添加资讯','product-add.html')">
                                    <i class="fa fa-meh-o"></i> 产品
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')">
                                    <i class="fa fa-user"></i> 用户
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>超级管理员</li>
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A">
                            admin <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="#">个人信息</a></li>
                            <li><a href="{{ url('logout') }}">退出</a></li>
                        </ul>
                    </li>
                    <li id="Hui-msg">
                        <a href="#" title="消息">
                            <span class="badge badge-danger">1</span>
                            <i class="fa fa-envelope"></i>
                        </a>
                    </li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover">
                        <a href="javascript:;" class="dropDown_A" title="换肤">
                            <i class="iconfont icon-skin"></i>
                        </a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
{{-- header --}}

{{-- aside --}}
<aside class="Hui-aside">
    <input runat="server" id="divScrollValue" type="hidden" value="" />
    <div class="menu_dropdown bk_2">
        <dl>
            <dt>
                <i class="fa fa-cog"></i> 系统管理
                <i class="fa fa-caret-down menu_dropdown-arrow"></i>
            </dt>
            <dd>
                <ul>
                    <li><a data-href="/" data-title="系统设置" href="javascript:void(0)">系统设置</a></li>
                </ul>
            </dd>
        </dl>
        <dl>
            <dt>
                <i class="fa fa-users"></i> 管理员模块
                <i class="fa fa-caret-down menu_dropdown-arrow"></i>
            </dt>
            <dd>
                <ul>
                    <li><a href="javascript:void(0)" data-href="{{ url('manager') }}" data-title="管理员管理">管理员管理</a></li>
                    <li><a href="javascript:void(0)" data-href="{{ url('role') }}" data-title="角色管理">角色管理</a></li>
                    <li><a href="javascript:void(0)" data-href="{{ url('node') }}" data-title="节点管理">节点管理</a></li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
{{-- aside --}}

{{-- content --}}
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active">
                    <span title="我的桌面" data-href="{{ url('welcome') }}">我的桌面</span>
                    <em></em>
                </li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group">
            <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;">
                <i class="Hui-iconfont">&#xe6d4;</i>
            </a>
            <a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;">
                <i class="Hui-iconfont">&#xe6d7;</i>
            </a>
        </div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="{{ url('welcome') }}"></iframe>
        </div>
    </div>
</section>
{{-- content --}}

<div class="dislpayArrow hidden-xs">
    <a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
</div>

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libs/layer/layer.js') }}"></script>
<script type="text/javascript" src="{{ asset('master/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('master/h-ui.admin/js/H-ui.admin.js') }}"></script>
</body>
</html>