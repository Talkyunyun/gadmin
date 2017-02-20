@extends('layout.master')

@section('title', $result->username . '达人简介')

@section('header')
    <style>
        body{
            background-color: #ffffff
        }
    </style>
@endsection
@section('content')
    {{-- master index --}}
    <div class="master_index">
        {{-- logo --}}
        <div class="master_logo">
            <img src="{{ asset('img/logo_3.png') }}" alt="PiTube live">
        </div>

        {{-- 封面 --}}
        <div class="master_cover" style="background:#ccc url({{ $result->cover }}@1e_0o_1l_600h_600w_100q.src) no-repeat center center;background-size:cover;"></div>

        {{-- 阴影背景 --}}
        <div class="master_shadow"></div>

        {{-- 资料介绍 --}}
        <div class="master_info">
            <div class="master_name">
                {{ $result->username }}
                @if($result->role == 1)
                <img src="{{ asset('img/pro.png') }}" alt="pro">
                @endif
            </div>
            <div class="master_role">{{ $result->identity }}</div>
            <div class="master_resume">{{ $result->resume }}</div>
        </div>

        {{-- 提示向上滑动 --}}
        <div class="master_arrow"></div>
    </div>

    {{-- master info --}}
    <div class="master_user">
        <div class="master_umain">
            <div class="master_uimg" style="background:#ccc url({{ $result->avatar }}) no-repeat center center;background-size:cover;"></div>

            <div class="master_uname">
                {{ $result->username }}
                @if($result->role == 1)
                <img src="{{ asset('img/pro.png') }}" alt="pro">
                @endif
            </div>
            <div class="master_follow">
                关注: {{ $result->follow }}&nbsp;&nbsp;|&nbsp;&nbsp;粉丝: {{ $result->fans }}
            </div>
            <div class="master_uresume" data-content="{{ $result->resume }}">{{ $result->resume_dot }}</div>

            <div class="master_more_btn">
                <i class="iconfont icon-xiangxia"></i>
            </div>
        </div>

        <div class="master_ubg" style="background:#ccc url({{ $result->cover }}@1e_0o_1l_600h_600w_100q.src) no-repeat center center;background-size:cover;"></div>

        <div class="master_ubgshadow"></div>
    </div>
    
    <div class="master_how">
        <a href="{{ url('master/join') }}">如何获得PRO版资料卡?</a>
    </div>
    
    {{-- footer --}}
    <div class="live_msg_bottom" style="background:#fff;margin-bottom:2rem">
        <div class="live_msg_logo">
            <img src="{{asset('img/logo_2.png')}}" alt="PiTube live TV">
        </div>
        <div class="live_down">
            <a class="live_down_btn" href="{{ config('site.app_download_url') }}">
                <img src="{{asset('img/download_ios.png')}}" alt="PiTube live ios download APP">
            </a>
            <a class="live_down_btn" href="{{ config('site.app_download_url') }}">
                <img src="{{asset('img/download_android.png')}}" alt="PiTube live android download APP">
            </a>
        </div>
    </div>
@endsection

@section('footer')
@parent
<script type="application/javascript">
$(function() {
    var upShow = 0;
    $('.master_more_btn').click(function() {
        var dom   = $('.master_uresume'),
            resume= dom.attr('data-content'),
            html  = dom.html();
        dom.html(resume).attr('data-content', html);
        if (upShow == 0) {
            $(this).find('i').removeClass('icon-xiangxia').addClass('icon-xiangshang');
            upShow = 1;
        } else {
            $(this).find('i').removeClass('icon-xiangshang').addClass('icon-xiangxia');
            upShow = 0;
        }
    });
    $('.master_index').css('height', $(window).height());
});
</script>
@endsection