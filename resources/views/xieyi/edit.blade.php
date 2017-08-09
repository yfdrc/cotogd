@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("xieyi/create","增加协议") !!} | @endcan {!! link_to("xieyi/$task->id","协议详情") !!} ||  @include("layouts.shortcut11")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    编辑协议
                </div>
                <div class="panel-body">
                    {{ Form::model($task, ["url"=>"xieyi/$task->id", "method" => "PUT", "class" => "form-horizontal"]) }}
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            必填项目
                        </div>
                        <div class='panel-body'>
                            <div class='form-group'>
                                {{ Form::label('name', '协议编号',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('name', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('ksZw', '短时课时',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('ksDs', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('ksZw', '中文课时',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('ksZw', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('ksYw', '英文课时',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('ksYw', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('jinE', '协议金额',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('jinE', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('date', '签约日期',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('date', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('kebao', '课包',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('kebao', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('isZZ', '是否转账',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('isZZ', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('guWen1', '顾问1',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('guWen1', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('guWen2', '顾问2',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('guWen2', null, ['class'=>'form-control']) }}
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
