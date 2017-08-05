@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    新建微信用户组
                </div>
                <div class="panel-body">
                    {!! Form::open(["url"=>"wechatapigroup","method"=>"POST","class"=>"form-horizontal"]) !!}
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            必填项目
                        </div>
                        <div class='panel-body'>
                            <div class='form-group'>
                                {{ Form::label('name', '名称',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('name', null, ['class'=>'form-control']) }}
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
