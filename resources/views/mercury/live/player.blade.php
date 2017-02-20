@extends('layout.master')

@section('title', $live->title)

@section('content')
    {{-- video box --}}
    <div class="video_main">
        {{-- 直播封面 --}}
        <div class="video_bg" style="background:#242424 url('http://alcdn.img.xiaoka.tv/20161206/0cb/249/106892725/0cb249da3e4d952aaa786fdfb53a34b3.jpg@1e_1c_0o_0l_640h_640w_100q_1pr.jpg') no-repeat center center;background-size:cover;"></div>

        {{-- 播放按钮 --}}
        <div class="video_player">
            <button class="player_btn iconfont icon-bofang"></button>
        </div>

        {{-- 播主用户 --}}
        <div class="live_user">
            <div class="live_uinfo">
                <div class="live_uimg" style="background:#ccc url('http://tubes.gutplus.com/Uploads/Avatar/Thumb/9@1e_0o_1l_80h_80w_100q.src?v=5944') no-repeat center center;background-size:cover;"></div>
                <div class="live_uname">落日余晖</div>
            </div>
        </div>

        {{-- 直播间按钮 --}}
        <ul class="live_action">
            <li><i class="iconfont icon-liwu"></i></li>
            <li><i class="iconfont icon-fenxiang"></i></li>
            <li><i class="iconfont icon-yanjing"></i></li>
            <li><i class="iconfont icon-liaotian"></i></li>
        </ul>
    </div>

    {{-- trailer list --}}
    <div class="cate_nav">
        PiTube精彩预告直播
        <a href="javascript:void(0)" class="show_down_btn">更多></a>
    </div>

    <ul class="trailer"></ul>

    {{-- poker footer --}}
    <div class="poker_footer">
        <p>立即下载安装PiTube</p>
        <div>观看精彩内容,与达人互动</div>
    </div>

    {{-- poker download --}}
    <div class="footer_down">
        <a class="footer_down_btn" href="{{ config('site.app_download_url') }}">
            <img src="{{asset('img/live-msg/download_ios_dark.png')}}" alt="PiTube live ios download APP">
        </a>
        <a class="footer_down_btn" href="{{ config('site.app_download_url') }}">
            <img src="{{asset('img/live-msg/download_android_dark.png')}}" alt="PiTube live android download APP">
        </a>
    </div>
@endsection

@section('footer')
@parent
<script id="trailer_tpl" type="text/html">
    <%for(var i=0; i<list.length; i++) {%>
    <li>
        <a class="trailer_bg" href="{{ url('live') }}?live_id=<%:=list[i].id%>" style="background:#ccc url(<%:=list[i].cover_url%>) no-repeat center center;background-size:cover;"></a>
        <div class="trailer_info">
            <div class="trailer_left">
                <h3><%:=list[i].title%></h3>
                <div>
                    <i>·</i>
                    <span>直播时间:<%:=list[i].start_date%> <%:=list[i].week%> <%:=list[i].start_at%></span>
                </div>
            </div>
            <div class="trailer_right">
                <div class="trailer_uimg" style="background:#ccc url(<%:=list[i].avatar%>) no-repeat center center;background-size:cover">
                    <%if (list[i].role == 1) {%>
                    <img class="trailer_upro" src="{{ asset('img/pro.png') }}" alt="pro">
                    <%}%>
                </div>
                <div class="trailer_uname"><%:=list[i].username%></div>
            </div>
        </div>
    </li>
    <%}%>
</script>

<script type="application/javascript">
var lastDate = '<?php echo date("Y-m-d"); ?>';
var lastTime = '<?php echo date("H:i:s"); ?>';
var lastId   = 0;
var isLoading= false;
var loadNum  = 0;
var loadBox;
$(function() {
    // 初始化video height
    var winH = $(window).height();
    $('.video_main').css('height', winH + 'px');
    $('.show_down_btn').click(function() {
        APP.showDown();
    });

    loadData(lastTime, lastDate, lastId);
    // 滚动加载更多
    $(window).scroll(function() {
        var moveH = parseInt($(window).scrollTop());
        var winH  = parseInt($(window).height());
        var totalH= moveH + winH;
        var docH  = parseInt($(document).height());// 文档高度
        if (docH <= totalH) {
            if (!isLoading) {
                // 获取最后一条数据ID
                loadData(lastTime, lastDate, lastId);
                loadBox = APP.msg('{{ trans('msg.load_loading') }}', 2);
            }
        }
    });
});
function loadData(vlastTime, vlastDate, vlastId) {
    isLoading = true;
    // 获取预告数据
    $.post('{{ url('get-trailer') }}', {
        lastTime: vlastTime,
        lastDate: vlastDate,
        lastId  : vlastId,
        _token  : '{{ csrf_token() }}'
    }, function(res) {
        if (res.code == 1 && res.result.length > 0) {
            if (loadNum != 0) {
                APP.msg('{{ trans('msg.load_success') }}', 1);
                loadBox.hide();
            }
            res = res.result;
            lastTime = res[res.length-1].start_at;
            lastDate = res[res.length-1].start_date;
            lastId   = res[res.length-1].id;

            var tpl  = $('#trailer_tpl').html();
            var html = template(tpl, { list: res });
            $('.trailer').append(html);
            isLoading = false;
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