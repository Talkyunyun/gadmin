@extends('admin.layout.master')

@section('content')
    <section class="container" style="margin:20px;">
        <div class="row">
            <div class="col-sm-12">
                <form role="form" method="post" action="">
                    <div class="form-group">
                        <label>用户名:</label>
                        <input type="text" class="form-control" value="{{ $result->username }}" disabled />
                    </div>
                    <div class="form-group">
                        <label for="real_name">真实姓名:<span class="must_option">(必填)</label>
                        <input type="text" value="{{ $result->real_name }}" name="real_name" class="form-control" id="real_name" placeholder="真实姓名">
                    </div>
                    <div class="form-group">
                        <label for="phone">手机号码:</label>
                        <input type="number" value="{{ $result->phone }}" name="phone" class="form-control" id="phone" placeholder="手机号码">
                    </div>
                    <div class="form-group">
                        <label for="email">邮箱:</label>
                        <input type="email" value="{{ $result->email }}" name="email" class="form-control" id="email" placeholder="邮箱">
                    </div>

                    <div class="form-group">
                        <label for="">状态:</label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" @if($result->status == 1) checked @endif > 正常
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="0" @if($result->status == 0) checked @endif > 禁用
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $result->id }}">
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
                var real_name   = $('#real_name'),
                    phone       = $('#phone'),
                    email       = $('#email');
                if (real_name.val().trim().length < 1) {
                    APP.msg('姓名为空');
                    real_name.focus();
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
