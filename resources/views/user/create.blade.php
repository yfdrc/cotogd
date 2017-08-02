@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@include("layouts.shortcut12")
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    新建账户
                </div>
                <div class="panel-body">
                    {!! Form::open(["url"=>"user","method"=>"POST","class"=>"form-horizontal"]) !!}
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            必填项目
                        </div>
                        <div class='panel-body'>
                            <div class='form-group'>
                                {{ Form::label('dianpu_id', '店铺名称',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::select('dianpu_id', $dps, null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('role_id', '用户权限',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::select('role_id', $roles, null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('name', '账户名称',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('email', '电子邮件',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('email', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('password', '账户密码',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::password('password', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('password_confirmation', '确认密码',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::password('password_confirmation', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('yzm', '验证码',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::password('yzm', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-offset-3 col-sm-6'>
                            <button type='submit' class='btn btn-success'>确定增加</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
