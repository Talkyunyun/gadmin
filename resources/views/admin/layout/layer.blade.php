<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>@yield('title')</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//at.alicdn.com/t/font_zh56iqvgkyq77gb9.css" rel="stylesheet">
<link href="{{ asset('css/core.min.css') }}?v=1.0" rel="stylesheet" />
@yield('header')
</head>
<body>

@section('content')

@show

@section('footer')
<script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="{{ asset('libs/layer/layer.js') }}"></script>
<script src="{{ asset('js/template.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/gene.min.js') }}?v=1.0"></script>
<script src="{{ asset('js/core.min.js') }}?v=1.1"></script>
<script src="{{ asset('js/app.js') }}?v=1.3"></script>
@show
</body>
</html>