<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>欢迎登录系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//at.alicdn.com/t/font_zh56iqvgkyq77gb9.css" rel="stylesheet">
<link href="{{ asset('css/core.min.css') }}" rel="stylesheet" />
<style>
*{margin:0;padding:0;}
html,body{
    height:100%;
}
#main{
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
}
#main .login_main{
    width: 320px;
    background: rgba(0, 0, 0, 0.53);
    border-radius: 4px;
    margin: 10% auto 0 auto;
    overflow: hidden;
    padding: 20px 20px 30px 20px;
}
#main .login_main h1{
    text-align: center;
    color: #fff;
    font-size: 24px;
    margin-bottom: 26px;
}
</style>
</head>
<body>

<section id="main">
    <div class="login_main">
        <h1>欢迎登录</h1>
        <form class="form" method="post">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon" style="padding:6px 14px;">
                        <i class="fa fa-user"></i>
                    </div>
                    <input id="uname" class="form-control" type="text" placeholder="用户名">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <input id="upass" class="form-control" type="password" placeholder="密码">
                </div>
            </div>

            <div class="form-group">
                <button type="button" id="login_btn" class="btn btn-block btn-info">登录</button>
            </div>
        </form>
    </div>
</section>

<script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.bootcss.com/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
<script src="{{ asset('js/gene.min.js') }}"></script>
<script src="{{ asset('js/core.min.js') }}"></script>
<script>
$(function() {
    $('#login_btn').click(function() {
        var uname = $('#uname'),tipObj,
            upass = $('#upass');
        if (!uname.val()) {
            APP.msg('用户名错误!');
            uname.focus();
            return false;
        }
        if (!upass.val()) {
            APP.msg('密码错误!');
            upass.focus();
            return false;
        }

        $.ajax({
            type : 'post',
            url  : "{{ url('login') }}" ,
            data : {
                uname : uname.val(),
                upass : upass.val(),
                _token: "{{ csrf_token() }}"
            },
            dataType : 'json',
            success : function(res) {
                tipObj.hide();
                if (res.code != 0) {
                    APP.msg('登录失败');
                    return false;
                }

                window.location.href = '/';
            },
            beforeSend : function() {
                tipObj = APP.msg('登录中...', 2);
            },
            error: function() {
                tipObj.hide();
                APP.msg('网络超时');
            }
        });
    });

	$.backstretch([
		'{{ asset("img/login-bg/1.jpg")}}',
		'{{ asset("img/login-bg/2.jpg")}}',
		'{{ asset("img/login-bg/3.jpg")}}',
		'{{ asset("img/login-bg/4.jpg")}}',
		'{{ asset("img/login-bg/5.jpg")}}'
	], {duration:3000,fade:750});

    // key event
    $(document).keypress(function(e) {
        if (e.keyCode == 13) {
            $('#login_btn').click();
        }
    });
});
</script>
</body>
</html>