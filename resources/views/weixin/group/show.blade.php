@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapigroup/create","增加微信用户组") !!} | @endcan @can("edit", new \App\Model\Role){!! link_to("wechatapigroup/$task->openid/edit","编辑微信用户组") !!} || @endcan @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    微信用户组详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"wechatapigroup/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('id', '序号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->id }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name', '名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name', '用户数',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->count }}
                        </div>
                    </div>
                    @can("admin", new App\Model\Role)
                        <div class='form-group'>
                            <div class='col-sm-offset-3 col-sm-6'>
                                <button type='submit' class='btn btn-danger'>确定删除</button>
                            </div>
                        </div>
                    @endcan
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection