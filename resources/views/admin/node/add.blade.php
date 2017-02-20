@extends('admin.layout.master')

@section('content')
    <section class="container" style="margin:20px;">
        <div class="row">
            <div class="col-sm-12">
                <form role="form" method="post" action="">
                    <div class="form-group">
                        <label for="username">父节点:</label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0">顶级节点</option>
                            @foreach($node as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="url_box" style="display:none;">
                        <label for="url">访问地址:<span class="must_option">(必填)</label>
                        <input type="text" name="url" class="form-control" id="url" placeholder="访问地址">
                    </div>
                    <div class="form-group">
                        <label for="name">名称:<span class="must_option">(必填)</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="名称">
                    </div>
                    <div class="form-group">
                        <label for="remark">备注:</label>
                        <textarea name="remark" id="remark" placeholder="备注" class="form-control"></textarea>
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
    $('#pid').change(function() {
        var val = $(this).val();
        if (val == 0) {
            $('#url_box').hide();
        } else {
            $('#url_box').show();
        }
    });
    $('#submit').click(function() {
        var name = $('#name'),
            pid  = $('#pid'),
            url  = $('#url');
        if (pid.val() != 0 && url.val().trim().length < 1) {
            APP.msg('缺省必要参数');
            url.focus();
            return false;
        }
        if (name.val().trim().length < 1) {
            APP.msg('名称为空');
            name.focus();
            return false;
        }
    });
});
</script>
@endsection
