@extends('layout.master')

@section('title', '快圣诞节疯狂')

@section('header')
    <style>
        body{
            background-color: #ffffff
        }
    </style>
@endsection

@section('content')
    <div class="join_master_face">
        <div class="join_master_logo"><img src="{{ asset('img/master-join/icon_logo.png') }}" alt="PiTube logo"></div>
        <p>
            PiTube 是一个基于直播及视频技术<br>
            与全球用户分享和交流的移动自媒体平台
        </p>
        <div class="join_master_cate"><img src="{{ asset('img/master-join/pic_banner.png') }}" alt="PiTube Cate"></div>
    </div>

    <div class="join_master_face_bottom"><img src="{{ asset('img/master-join/bg_header_bottom.png') }}" alt="PiTube bg"></div>

    {{-- 专栏频道 --}}
    <div class="join_cate_box">
        <h3>专栏频道, 名利双收</h3>
        <div><img src="{{ asset('img/master-join/pic_con_1.png') }}" alt="专栏频道, 名利双收"></div>
    </div>

    {{-- 频道 --}}
    <div class="join_cate_box join_cate_box_border">
        <h3>在PiTube上设立频道并通过认证将获得</h3>
        <div><img src="{{ asset('img/master-join/pic_con_2.png') }}" alt="在PiTube上设立频道并通过认证将获得"></div>
    </div>

    {{-- form --}}
    <div class="join_cate_box">
        <h3>申请成为达人</h3>
        <p>请留下您的联系方式, 我们将会与您联系</p>
        <div class="join_input">
            <i class="iconfont icon-iconperson"></i>
            <input type="text" id="uname" placeholder="姓名">
        </div>
        <div class="join_input">
            <i class="iconfont icon-icon" style="font-size:1.6rem;"></i>
            <input type="text" id="phone" placeholder="手机号码">
        </div>
        <div class="join_input">
            <i class="iconfont icon-qq01" style="font-size:2rem;left:.4rem;"></i>
            <input type="text" id="wechat" placeholder="QQ或微信">
        </div>
        <button type="button" id="join_btn">立即申请</button>
    </div>

    {{-- 二维码 --}}
    <div class="join_cate_box" style="border-top:1px solid #e4e4e4">
        <h3 style="font-size:.2rem;">扫一扫, 申请开通频道</h3>
        <div style="width:10rem"><img src="{{ asset('img/master-join/pic_code_join.png') }}" alt="扫描二维码"></div>
    </div>
@endsection

@section('footer')
@parent
<script type="application/javascript">
$(function() {
    $('#join_btn').click(function() {
        var uname = $('#uname'),
            phone = $('#phone'),
            wechat= $('#wechat');
        if (uname.val().length < 2) {
            APP.msg('请输入合法的姓名');
            uname.focus();
            return false;
        }
        if (!APP.regular.phone.test(phone.val())) {
            APP.msg('错误的手机号码');
            phone.focus();
            return false;
        }
        if (wechat.val().length < 3) {
            APP.msg('错的QQ或微信');
            wechat.focus();
            return false;
        }
        var loadBox;
        $.ajax({
            type : 'post',
            url  : "{{ url('master/join') }}" ,
            data : {
                name  : uname.val(),
                phone : phone.val(),
                wechat: wechat.val(),
                _token: "{{ csrf_token() }}"
            },
            dataType : 'json',
            success : function(res) {
                loadBox.hide();
                if (res.code == 0) {
                    APP.msg(res.msg);
                } else {
                    APP.msg(res.msg, 1);
                    uname.val('');
                    phone.val('');
                    wechat.val('');
                }
            },
            error: function() {
                APP.msg('请求出错');
                loadBox.hide();
            },
            beforeSend : function() {
                loadBox = APP.msg('请求中...', 2);
            }
        });
    });

    $('input').focus(function() {
        $(this).parent().css('border-color', '#272727');
    });

    $('input').blur(function() {
        $(this).parent().css('border-color', '#dedede');
    });
});
</script>
@endsection