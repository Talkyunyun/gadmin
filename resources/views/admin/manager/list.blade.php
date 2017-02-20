@extends('admin.layout.master')

@section('title', '我是标题')

@section('content')
    {{-- 位置导航 --}}
    <div class="nav_seat">
        <span><i class="fa fa-home"></i>首页</span> /
        <span>管理员列表</span>

        <button class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>
    </div>
    {{-- 位置导航 --}}

    <section class="container-fluid" style="margin-top:35px">
        {{-- 搜索 --}}
        <div class="nav_search">
            <form class="form-inline" role="form" action="" method="get">
                <div class="form-group">
                    <label for="cate" class="control-label">分类:</label>
                    <select class="form-control" id="cate">
                        <option value="">全部</option>
                        <option value="">家电</option>
                        <option value="">服饰</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">标题:</div>
                        <input class="form-control" type="text" placeholder="标题">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">搜索</button>
            </form>
        </div>
        {{-- 搜索 --}}

        {{-- 操作 --}}
        <div class="nav_action">
            <button class="btn btn-xs btn-info openwin" data-url="{{url('add-manager')}}" data-name="添加管理员"><i class="fa fa-plus"></i>添加</button>
            <a href="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> 删除</a>
        </div>
        {{-- 操作 --}}

        {{-- 主要内容 --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">用户名</th>
                        <th class="text-center">姓名</th>
                        <th class="text-center">邮箱</th>
                        <th class="text-center">联系号码</th>
                        <th class="text-center">角色</th>
                        <th class="text-center">状态</th>
                        <th class="text-center">创建时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $row)
                    <tr>
                        <td class="text-center">{{ $row->id }}</td>
                        <td class="text-center">{{ $row->username }}</td>
                        <td class="text-center">{{ $row->real_name }}</td>
                        <td class="text-center">{{ $row->email }}</td>
                        <td class="text-center">{{ $row->phone }}</td>
                        <td class="text-center">
                            @foreach($row->roles as $r)
                                <p>{{ $r->name }}</p>
                            @endforeach
                            <a href="javascript:void(0)" class="openwin" data-url="{{ url('role-manager') }}?id={{ $row->id }}" data-name="编辑《{{ $row->username }}》的角色">编辑角色</a>
                        </td>
                        <td class="text-center">
                            @if($row->status == 1) <sapn style="color:green">正常</sapn>
                            @elseif($row->status == 0) <span style="color:red;">禁用</span>
                            @endif
                        </td>
                        <td class="text-center">{{ date('Y-m-d H:i:s', $row->created_at) }}</td>
                        <td class="text-center">
                            @if($row->id != session('uid') && $row->status == 1)
                                <a href="{{ url('manager-on-off') }}?id={{ $row->id }}" class="btn btn-xs btn-danger">禁用</a>
                            @elseif($row->id != session('uid') && $row->status == 0)
                                <a href="{{ url('manager-on-off') }}?id={{ $row->id }}" class="btn btn-xs btn-success">开启</a>
                            @endif

                            <a href="javascript:void(0)" data-id="{{ $row->id }}" class="btn btn-xs savePasswordBtn">修改密码</a>
                            <button class="btn btn-link openwin" data-url="{{url('edit-manager')}}?id={{ $row->id }}" data-name="编辑{{$row->username}}用户资料">编辑</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="page">
            {{ $result->links() }}
        </div>
        {{-- 主要内容 --}}
    </section>
@endsection

@section('footer')
    @parent
<script>
$(function() {
    $('.savePasswordBtn').click(function() {
        var id = $(this).attr('data-id');
        layer.open({
            type: 2,
            title: '修改密码',
            shadeClose: true,
            shade: 0.8,
            area: ['400px', '400px'],
            content: "{{ url('update-password-manager') }}?id=" + id
        });
    });
});
</script>
@endsection
