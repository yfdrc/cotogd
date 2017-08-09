@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@include("layouts.shortcut11")
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    新建家长
                </div>
                <div class="panel-body">
                    {!! Form::open(["url"=>"jiazhang","method"=>"POST","class"=>"form-horizontal"]) !!}
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            必填项目
                        </div>
                        <div class='panel-body'>
                            <div class='form-group'>
                                {{ Form::label('bh', '家长编号',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('bh', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('name', '家长姓名',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('tele', '家长手机',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('tele', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name2', '家长2姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('name2', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('tele2', '家长2手机',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('tele2', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('hAddress', '家庭住址',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('hAddress', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('howGet', '获取渠道',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('howGet', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('region', '所在区域',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('region', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('whenStud', '排课时间',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('whenStud', null, ['class'=>'form-control']) }}
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
