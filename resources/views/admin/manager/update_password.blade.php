@extends('admin.layout.master')

@section('content')
    <section class="container" style="margin:20px;">
        <div class="row">
            <div class="col-sm-12">
                <form role="form" method="post" action="">
                    <div class="form-group">
                        <label>用户名:</label>
                        <input type="text" class="form-control" value="admin" disabled>
                    </div>
                    <div class="form-group">
                        <label for="password">新密码:<span class="must_option">(必填)</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="新密码">
                    </div>
                    <div class="form-group">
                        <label for="notpassword">确认密码:<span class="must_option">(必填)</label>
                        <input type="password" name="notpassword" class="form-control" id="notpassword" placeholder="确认密码">
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
    $('#submit').click(function() {
        var password    = $('#password'),
            notpassword = $('#notpassword');
        if (password.val() < 4) {
            APP.msg('请输入新密码');
            password.focus();
            return false;
        }
        if (password.val() != notpassword.val()) {
            APP.msg('两次密码输入不一样');
            notpassword.focus();
            return false;
        }
    });
});
</script>
@endsection
