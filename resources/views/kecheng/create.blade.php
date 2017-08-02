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
新建课程
</div>
<div class="panel-body">
{!! Form::open(["url"=>"kecheng","method"=>"POST","class"=>"form-horizontal"]) !!}
<div class='panel panel-primary'>
<div class='panel-heading'>
必填项目
</div>
<div class='panel-body'>
<div class='form-group'>
{{ Form::label('dianpu_id', '店铺名称',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::select('dianpu_id', $dp, null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('name', '课程名称',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('name', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('ageMin', '年龄下限',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('ageMin', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('ageMax', '年龄上限',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('ageMax', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('quanZhong', '课程权重',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('quanZhong', null, ['class'=>'form-control']) }}
</div>
</div>
</div>
</div>
<div class='form-group'>
{{ Form::label('boach', '老师姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('boach', null, ['class'=>'form-control']) }}
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
