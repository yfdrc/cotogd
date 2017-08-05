@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapiuser/create","增加微信用户") !!} | @endcan @can("create", new \App\Model\Role){!! link_to("wechatapiuser/$task->openid/edit","编辑微信用户") !!} || @endcan @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    微信用户详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"wechatapiuser/$task->openid", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('nickname', '昵称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->nickname }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('remark', '手机号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->remark }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('address', '地址',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->address }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xh1name', '小孩1',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xh1name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xh2name', '小孩2',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xh2name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xh3name', '小孩3',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xh3name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('group_id', '用户组号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->group_id }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('subtime', '加入日期',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->subtime }}
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