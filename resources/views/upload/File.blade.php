@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@include("layouts.shortcut01")
        </div>
        <div class="panel-body">
            <div class="text-danger">
                请注意：每次只能上传一个文件。csv文件以英文逗号为分隔符，故上传前必须将Excel文件的英文逗号（,）替换成中文逗号或其他，再保存为csv格式上传。<br><br>
            </div>
            {!! Form::open(["method"=>"POST", 'enctype'=>"multipart/form-data","class"=>"form-horizontal"]) !!}
            <div class='form-group'>
                {{ Form::label('fname', '请选择需上传的总表csv文件',['class'=>'col-sm-3 control-label']) }}
                <div class='col-sm-6'>
                    {{ Form::file('fname', ['class'=>'form-control']) }}
                </div>
            </div>
            <div class='form-group'>
                {{ Form::label('fname2', '请选择需上传的扣课表csv文件',['class'=>'col-sm-3 control-label']) }}
                <div class='col-sm-6'>
                    {{ Form::file('fname2', ['class'=>'form-control']) }}
                </div>
            </div>
            <div class='form-group'>
                <div class='col-sm-offset-3 col-sm-6'>
                    <button type='submit' class='btn btn-success'>确定提交</button>
                </div>
            </div>
            {!! Form::close() !!}

            <div class='col-sm-offset-3 col-sm-6'>
                {!! Form::open(["url"=>"excelTodb","method"=>"get","class"=>"form-horizontal"]) !!}
                <button type='submit' class='btn btn-success'>返回</button>
                {!! Form::close() !!}
            </div>

        </div>
        <div class="panel-footer">
            {!! isset($ts)? $ts : '' !!}
        </div>
    </div>

@endsection