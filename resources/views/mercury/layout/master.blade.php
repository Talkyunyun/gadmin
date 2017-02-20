<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8" >
<title>@yield('title')-{{ trans('msg.download_tips') }}</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="full-screen" content="yes">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<meta name="x5-fullscreen" content="true">
<meta name="keywords" content="PiTube,派播,live,直播,派播直播,PiTube直播,直播平台">
<meta name="description" content="PiTube直播平台,只做有价值的内容直播平台...">
<link rel="stylesheet" href="//at.alicdn.com/t/font_wkehx04alvleg66r.css" >
<link rel="stylesheet" href="{{ asset('css/core.min.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.1">
@yield('header')
</head>
<body>

<section id="main">
    @section('content')
    @show
</section>

@section('footer')
<script type="text/javascript" src="http://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="{{ asset('js/template.min.js') }}?v=1.0"></script>
<script type="text/javascript" src='{{ asset('js/gutplus.min.js') }}?v=1.0'></script>
<script type="text/javascript" src='{{ asset('js/core.min.js') }}?v=1.0'></script>
@show
</body>
</html>