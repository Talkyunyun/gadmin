@extends('admin.layout.master')

@section('content')
    <section class="container" style="margin:20px;">
        <div class="row">
            <div class="col-sm-12">
                <form role="form" method="post" action="">
                    <div class="form-group">
                        <label for="name">角色名称:<span class="must_option">(必填)</span></label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="角色名称">
                    </div>
                    <div class="form-group">
                        <label for="remark">备注:</label>
                        <textarea name="remark" class="form-control" placeholder="备注"></textarea>
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
        var name    = $('#name');
        if (name.val().trim().length < 1) {
            APP.msg('名称为空');
            name.focus();
            return false;
        }
    });
});
</script>
@endsection
