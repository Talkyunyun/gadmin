@extends('admin.layout.master')

@section('content')
    <section class="container" style="margin:20px;">
        <div class="row">
            <div class="col-sm-12">
                <form role="form" method="post" action="">
                    <div class="form-group">
                        <label for="username">用户名:<span class="must_option">(必填)</span></label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="用户名">
                    </div>
                    <div class="form-group">
                        <label for="real_name">真实姓名:<span class="must_option">(必填)</label>
                        <input type="text" name="real_name" class="form-control" id="real_name" placeholder="真实姓名">
                    </div>
                    <div class="form-group">
                        <label for="password">密码:<span class="must_option">(必填)</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <label for="notpassword">确认密码:<span class="must_option">(必填)</label>
                        <input type="password" name="notpassword" class="form-control" id="notpassword" placeholder="确认密码">
                    </div>
                    <div class="form-group">
                        <label for="phone">手机号码:</label>
                        <input type="number" name="phone" class="form-control" id="phone" placeholder="手机号码">
                    </div>
                    <div class="form-group">
                        <label for="email">邮箱:</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="邮箱">
                    </div>

                    <div class="form-group">
                        <label for="">状态:</label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" checked> 正常
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="0"> 禁用
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" id="submit" class="btn btn-primary">保存</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('footer')
@parent
<script>
$(function() {
    // 登录验证
    $('#submit').click(function() {
        var username    = $('#username'),
            real_name   = $('#real_name'),
            password    = $('#password'),
            notpassword = $('#notpassword'),
            phone       = $('#phone'),
            email       = $('#email');
        // 验证用户名合法性
        if (!APP.regular.name.test(username.val())) {
            APP.msg('用户名为空');
            username.focus();
            return false;
        }
        if (real_name.val().trim().length < 1) {
            APP.msg('姓名为空');
            real_name.focus();
            return false;
        }
        if (!APP.regular.password.test(password.val())) {
            APP.msg('密码太短');
            password.focus();
            return false;
        }
        if (password.val() != notpassword.val()) {
            APP.msg('确认密码错误');
            notpassword.focus();
            return false;
        }
        if (phone.val() && !APP.regular.phone.test(phone.val())) {
            APP.msg('错误号码!');
            phone.focus();
            return false;
        }
        if (email.val() && !APP.regular.email.test(email.val())) {
            APP.msg('错误邮箱');
            email.focus();
            return false;
        }
    });
});
</script>
@endsection
