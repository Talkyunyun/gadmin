@extends('layout.master')

@section('title', trans('msg.http_code_404'))

@section('content')
    <div class="live_face">
        <div class="live_face_img" style="background:#ddd url({{ config('site.msg_default_bg') }}) no-repeat center center;background-size:cover;"></div>
        <div class="live_status_tips_bg">
            <div class="live_status_tips">
                <h1>{{ trans('msg.http_code_404') }}</h1>
                <p>{{ trans('msg.download_tips') }}</p>
            </div>
        </div>
    </div>

    <div class="live_msg_bottom">
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

@section('footer')
@endsection