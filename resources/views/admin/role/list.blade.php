@extends('admin.layout.master')

@section('content')
    {{-- 位置导航 --}}
    <div class="nav_seat">
        <span><i class="fa fa-home"></i>首页</span> /
        <span>角色列表</span>

        <button class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>
    </div>
    {{-- 位置导航 --}}

    <section class="container-fluid" style="margin-top:35px">
        {{-- 操作 --}}
        <div class="nav_action">
            <button class="btn btn-xs btn-info openwin" data-url="{{url('add-role')}}" data-name="添加角色"><i class="fa fa-plus"></i>添加</button>
        </div>
        {{-- 操作 --}}

        {{-- 主要内容 --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">角色名</th>
                        <th class="text-center">备注</th>
                        <th class="text-center">状态</th>
                        <th class="text-center">创建时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $row)
                    <tr>
                        <td class="text-center">{{ $row->id }}</td>
                        <td class="text-center">{{ $row->name }}</td>
                        <td class="text-center">{{ $row->remark }}</td>
                        <td class="text-center">
                            @if($row->status == 1) <sapn style="color:green">正常</sapn>
                            @elseif($row->status == 0) <span style="color:red;">禁用</span>
                            @endif
                        </td>
                        <td class="text-center">{{ date('Y-m-d H:i:s', $row->created_at) }}</td>
                        <td class="text-center">
                            @if($row->id != 1 && $row->status == 1)
                                <a href="{{ url('role-on-off') }}?id={{ $row->id }}" class="btn btn-danger btn-xs">关闭</a>
                            @elseif($row->id != 1 && $row->status == 0)
                                <a href="{{ url('role-on-off') }}?id={{ $row->id }}" class="btn btn-success btn-xs">开启</a>
                            @endif

                            <button class="btn btn-link openwin" data-url="{{ url('role-access') }}?id={{ $row->id }}" data-name="编辑《{{ $row->name }}》角色的权限">权限</button>
                            <button class="btn btn-link openwin" data-url="{{ url('edit-role') }}?id={{ $row->id }}" data-name="编辑《{{ $row->name }}》角色资料">编辑</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- 主要内容 --}}
    </section>
@endsection

@section('footer')
    @parent
<script>
$(function() {

});
</script>
@endsection
