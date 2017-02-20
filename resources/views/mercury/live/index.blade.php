@extends('layout.master')

@section('title', $live->title)

@section('header')
    <style>
        body{background-color:#fff}
    </style>
    <link rel="stylesheet" href="{{ asset('libs/baguettebox/baguettebox.min.css') }}">
@endsection

@section('content')
    {{-- 预告图片 --}}
    <div class="share_index">
        <div class="share_index_face" style="background:#ccc url({{ $live->cover }}) no-repeat center center;background-size:cover;"></div>
        <div class="share_mark"></div>
        <div class="share_index_info">
            <div class="share_index_title">
                <h1>{{ $live->title }}</h1>
                <div>{{ $live->username }}</div>
            </div>
            <div class="share_index_uimg" style="background:#ccc url({{ $live->avatar }}) no-repeat center center;background-size:cover;"></div>
        </div>
    </div>

    {{-- 直播内容说明 --}}
    <div class="share_info">
        <h4>{{ trans('msg.live_remark') }}</h4>
        <div class="share_desc">{{ $live->remark }}</div>
    </div>

    {{-- 播主简介 --}}
    <div class="share_info">
        <h4>{{ trans('msg.live_introduce') }}</h4>
        <div class="share_desc">{{ $live->introduce }}</div>
    </div>

    {{-- 图片列表 --}}
    <ul class="share_index_pic">
        @foreach($live->photo as $row)
        <li>
            <a href="{{ $row->name }}" style="background:#ccc url({{ $row->name }}) no-repeat center center;background-size:cover"></a>
        </li>
        @endforeach
    </ul>

    {{-- 倒计时 --}}
    <div class="share_count_down">
        <div>{{ trans('msg.live_countdown') }}: <span id="countdown">0 days 00:00:00</span></div>
        <p>{{ trans('msg.live_start_time') }}: {{ $live->start_date }} {{ $live->start_at }} {{ $live->tzone }}</p>
    </div>

    {{-- 评论列表 --}}
    <div class="share_index_comment">
        <h5>{{ trans('msg.comment_count', ['count' => $live->comments]) }}</h5>
        <ul class="comment_main"></ul>
        <a href="javascript:void(0)" class="view_more">{{ trans('msg.view_more_btn') }}</a>
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

    {{-- 购票 --}}
    <div class="buy_bottom">
        <div class="live_price">{{ trans('msg.tickets_price', ['price'=>212]) }}</div>
        <div class="live_ticket">{{ trans('msg.surplus_tickets', ['count'=>32]) }}</div>
        <a href="" class="buy_btn">{{ trans('msg.buy_tickets') }}</a>
    </div>

    <script id="comment_tpl" type="text/html">
        <%for(var i=0; i<list.length; i++) {%>
        <li>
            <div class="comment_uimg" style="background:#ccc url(<%:=list[i].avatar%>) no-repeat center center;background-size:cover"></div>
            <div class="comment_info">
                <div class="comment_uname">
                    <span><%:=list[i].username%></span>
                    <i><%:=list[i].putime%></i>
                </div>
                <div class="comment_content"><%:=list[i].content%></div>
            </div>
        </li>
        <%}%>
    </script>
@endsection

@section('footer')
    @parent
    <script src="{{ asset('libs/baguettebox/baguettebox.min.js') }}"></script>
    <script>
        var loadBox;
        var page   = 1;
        var loadNum= 0;
        $(function() {
            // 获取评论数据
            baguetteBox.run('.share_index_pic', {
                animation: 'fadeIn'
            });
            var t = setInterval(function() {
                var endTime = APP.getTimeByZone("{{ $live->start_date }}", "{{ $live->start_at }}", "{{ $live->tzone }}");
                var nowTime = new Date();
                var poor = (endTime - nowTime.getTime())/1000;
                var d = 0, h = 0, m = 0, s = 0;
                if (poor >= 0) {
                    d = Math.floor(poor/86400);
                    h = Math.floor(poor/60/60%24);
                    m = Math.floor(poor/60%60);
                    s = Math.floor(poor%60);
                    $("#countdown").html(d+" days "+p(h)+":"+p(m)+":"+p(s));
                } else {
                    clearInterval(t);
                }
            }, 1);

            loadData();
            $('.view_more').click(function() {
                loadBox = APP.msg('{{ trans('msg.load_loading') }}', 2);
                loadData();
            });
        });
        function p(s) {
            return s < 10 ? '0' + s: s;
        }
        function loadData() {
            $.post('{{ url('get-live-comments') }}', {
                live_id : '{{ $live->id }}',
                _token  : '{{ csrf_token() }}',
                p : page
            }, function(res) {
                if (res.code == 200 && res.data.length > 0) {
                    if (loadNum > 0) {
                        APP.msg('{{ trans('msg.load_success') }}', 1);
                        loadBox.hide();
                    }

                    res = res.data;
                    var tpl  = $('#comment_tpl').html();
                    var html = template(tpl, { list: res });
                    $('.comment_main').append(html);
                    page++;
                } else {
                    if (loadNum > 0) {
                        loadBox.hide();
                        APP.msg('{{ trans('msg.load_not_data') }}', 1);
                    }
                }
                loadNum++;
            }, 'json');
        }
    </script>
@endsection