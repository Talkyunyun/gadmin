@extends('layout.master')

@section('title', 'dd')

@section('content')
    <div class="ticket_face">
        <div class="uimg" style="background:#ccc url(http://wx.qlogo.cn/mmopen/0dNeAtzHRh1tzmpWSfxKCibpX4usKgYxxlxxS5cYseibdWhmPgnibBDKhgR83Orlibz5u67yCVcaTiafBgAkPTSibY0iazZGBFNt6Fy/0?v=0330) no-repeat center center;background-size:cover"></div>

        <div class="uname">Gene</div>
        <p>送了您一张PiTube直播门票</p>
    </div>

    {{-- ticket --}}
    <div class="ticket_show">
        <div class="mask">
            <img src="{{ asset('img/live-ticket-mask@3x.png') }}" alt="ticket">
        </div>

        <div class="live_cover" style="background:url(http://tubes.gutplus.com/Uploads_dev/Live/201611/6bdd80ce4042bada98c9ba873566bcde.jpg@1e_0o_1l_600h_600w_100q.src) no-repeat center/cover"></div>

        {{-- ticket info --}}
        <div class="live_info">
            <h3>大家觉得好吗?</h3>
            <div class="live_time">
                <p>主播: 看手机打开</p>
                <p>时间: 2016-12-12 09:32:32</p>
            </div>

            <div class="live_price">票价: 2</div>
        </div>
    </div>

    <div class="ticket_btn">
        <a href="{{ url('get-ticket') }}?live_id=&code=">点击领取门票</a>
    </div>

    <hr class="ticket_ge">

    {{-- footer --}}
    <div class="live_msg_bottom" style="background:#242424">
        <div class="live_msg_logo">
            <img src="{{asset('img/logo.png')}}" alt="PiTube live TV">
        </div>
        <div class="live_down">
            <a class="live_down_btn" href="{{ config('site.app_download_url') }}">
                <img src="{{asset('img/live-msg/download_ios_dark.png')}}" alt="PiTube live ios download APP">
            </a>
            <a class="live_down_btn" href="{{ config('site.app_download_url') }}">
                <img src="{{asset('img/live-msg/download_android_dark.png')}}" alt="PiTube live android download APP">
            </a>
        </div>
    </div>
@endsection