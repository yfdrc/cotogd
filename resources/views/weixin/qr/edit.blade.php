@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapiqr/create","增加微信课程二维码") !!} | @endcan {!! link_to("wechatapiqr/$task->id","微信二维码详情") !!} ||  @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    编辑微信课程二维码
                </div>
                <div class="panel-body">
                    {{ Form::model($task, ["url"=>"wechatapiqr/$task->id", "method" => "PUT", "class" => "form-horizontal"]) }}
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            必填项目
                        </div>
                        <div class='panel-body'>
                            <div class='form-group'>
                                {{ Form::label('scene_str', '名称',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('scene_str', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
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
