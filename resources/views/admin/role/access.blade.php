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
    <section class="container" style="margin:20px;">
        <div class="row">
            <div class="col-sm-12">
                <form role="form" method="post" action="">
                    @foreach($node as $row)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <input @if(in_array($row['id'], $access)) checked @endif name="ids[]" value="{{ $row['id'] }}" type="checkbox" id="node_0{{ $row['id'] }}">
                                <label for="node_0{{ $row['id'] }}">{{ $row['name'] }}</label>
                            </div>
                            <div class="panel-body">
                                <ul class="nodeStyle">
                                    @foreach($row['son'] as $r)
                                        <li>
                                            <input @if(in_array($r['id'], $access)) checked @endif  name="ids[]" value="{{ $r['id'] }}" type="checkbox" id="node_{{ $r['id'] }}">
                                            <label for="node_{{ $r['id'] }}">{{ $r['name'] }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach

                    <input type="hidden" name="id" value="{{ $role_id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" id="submit" class="btn btn-primary">保存</button>
                </form>
            </div>
        </div>
    </section>
@endsection
