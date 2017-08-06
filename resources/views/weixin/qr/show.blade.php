@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapiqr/create","增加微信二维码") !!} | @endcan @can("create", new \App\Model\Role){!! link_to("wechatapiqr/$task->id/edit","编辑微信二维码") !!} || @endcan @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    微信二维码详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"wechatapiqr/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('scene_str', '名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->scene_str }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('ticket', '票据',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->ticket }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('url', '获取地址',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->url }}
                        </div>
                    </div>
                    @can("xxx", new App\Model\Role)
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