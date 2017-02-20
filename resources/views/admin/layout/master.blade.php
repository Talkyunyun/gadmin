<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>@yield('title')-{{ trans('msg.download_tips') }}</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//at.alicdn.com/t/font_zh56iqvgkyq77gb9.css" rel="stylesheet">
<link href="{{ asset('css/core.min.css') }}?v=1.0" rel="stylesheet" />
<style>
.nav_seat{
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    position: fixed;
    overflow: hidden;
    width: 100%;
    background: #edeeee;
    padding: 10px 0;
    font-size: 13px;
    text-indent: 4px;
    top: 0;
    left: 0;
    z-index: 999999;
}
.nav_seat button{
    position: absolute;
    right: 10px;
    top: 6px;
}
.nav_action{
    background: #f5f7f5;
    margin: 20px auto;
    border: 1px solid #fbf7f7;
    padding: 10px 6px;
    overflow: hidden;
}
.nav_search{
    padding: 10px 6px;
    margin-top: 10px;
    overflow: hidden;
}
.must_option{
    color: #F44336;
    font-size: 12px;
    font-weight: normal;
}
</style>
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
<script>
    $(function() {
        $('.nav_seat button').click(function() {
            window.location.reload();
        });
    });
</script>
@show
</body>
</html>