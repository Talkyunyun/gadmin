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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $result->username }}拥有的角色
                        </div>
                        <div class="panel-body">
                            <ul class="nodeStyle">
                                @foreach($roles as $row)
                                    <li>
                                        <input @if(in_array($row->id, $result->roles)) checked @endif  name="roles[]" value="{{ $row->id }}" type="checkbox" id="role_{{ $row->id }}">
                                        <label for="role_{{ $row->id }}">{{ $row->name }}</label>
                                    </li>
                                @endforeach
                            </ul>
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
