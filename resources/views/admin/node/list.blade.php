@extends('admin.layout.master')

@section('header')
<style>
    ul.nodeStyle li{
        float: left;
        margin: 0 10px;
    }
</style>
@endsection

@section('content')
    {{-- 位置导航 --}}
    <div class="nav_seat">
        <span><i class="fa fa-home"></i>首页</span> /
        <span>节点列表</span>

        <button class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>
    </div>
    {{-- 位置导航 --}}

    <section class="container-fluid" style="margin-top:35px">
        {{-- 操作 --}}
        <div class="nav_action">
            <button class="btn btn-xs btn-info openwin" data-url="{{url('add-node')}}" data-name="添加节点"><i class="fa fa-plus"></i>添加</button>
        </div>
        {{-- 操作 --}}

        {{-- 主要内容 --}}
        @foreach($result as $row)
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $row['name'] }}
                [<a href="javascript:void(0)" class="openwin" data-url="{{ url('edit-node') }}?id={{ $row['id'] }}" data-name="修改《{{ $row['name'] }}》节点信息">修改</a>]
                [<a href="{{ url('del-node') }}?id={{ $row['id'] }}">删除</a>]
            </div>
            <div class="panel-body">
                <ul class="nodeStyle">
                    @foreach($row['son'] as $r)
                    <li>
                        <span>{{ $r['name'] }}</span>
                        [<a href="javascript:void(0)" class="openwin" data-url="{{ url('edit-node') }}?id={{ $r['id'] }}" data-name="修改《{{ $r['name'] }}》节点信息">修改</a>]
                        [<a href="{{ url('del-node') }}?id={{ $r['id'] }}">删除</a>]
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
        {{-- 主要内容 --}}
    </section>
@endsection
