@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapiuser/create","增加微信用户") !!} | @endcan {!! link_to("wechatapiuser/$task->openid","微信用户详情") !!} ||  @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    编辑微信用户
                </div>
                <div class="panel-body">
                    {{ Form::model($task, ["url"=>"wechatapiuser/$task->openid", "method" => "PUT", "class" => "form-horizontal"]) }}
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            必填项目
                        </div>
                        <div class='panel-body'>
                            <div class='form-group'>
                                {{ Form::label('nickname', '昵称',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('nickname', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('remark', '手机号',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('remark', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('address', '地址',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('address', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('xh1name', '小孩1',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('xh1name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('xh2name', '小孩2',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('xh2name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('xh3name', '小孩3',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('xh3name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('group_id', '用户组号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('group_id', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-offset-3 col-sm-6'>
                            <button type='submit' class='btn btn-warning'>确定修改</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
