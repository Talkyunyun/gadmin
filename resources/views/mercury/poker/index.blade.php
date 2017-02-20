@extends('layout.master')

@section('title', 'PiTube是一个基于直播及视频技术与全球用户分享和交流的移动自媒体平台')

@section('content')
    {{-- poker logo --}}
    <div class="poker_face">
        <div class="poker_logo"></div>
        <p>PiTube 是一个基于直播及视频技术<br>与全球用户分享和交流的移动自媒体平台</p>
    </div>

    {{-- users list --}}
    <div class="cate_nav">
        PiTube达人推荐
        <a href="javascript:void(0)" class="show_down_btn">更多></a>
    </div>

    <ul class="poker_master_list">
        @foreach($master as $row)
        <li class="show_down_btn">
            <div class="poker_master_img" style="background:#ccc url('{{ $row->cover_url }}') no-repeat center center;background-size:cover;"></div>
            <div class="poker_master_name">{{ $row->username }}</div>
            <div class="poker_master_tag">{{ $row->identity }}</div>
        </li>
        @endforeach
    </ul>

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