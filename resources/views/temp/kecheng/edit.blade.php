@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：{!! link_to("tempkecheng/$task->id","临时课程详情") !!} ||  @include("layouts.shortcut21")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
编辑临时课程
</div>
<div class="panel-body">
{{ Form::model($task, ["url"=>"tempkecheng/$task->id", "method" => "PUT", "class" => "form-horizontal"]) }}
<div class='panel panel-primary'>
<div class='panel-heading'>
必填项目
</div>
<div class='panel-body'>
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
<button type='submit' class='btn btn-warning'>确定修改</button>
</div>
</div>
{!! Form::close() !!}
</div>
</div>
</div>
</div>

@endsection
