@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：{!! link_to("tempxueyuan/$task->id","临时学员详情") !!} ||  @include("layouts.shortcut21")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
编辑临时学员
</div>
<div class="panel-body">
{{ Form::model($task, ["url"=>"tempxueyuan/$task->id", "method" => "PUT", "class" => "form-horizontal"]) }}
<div class='panel panel-primary'>
<div class='panel-heading'>
必填项目
</div>
<div class='panel-body'>
<div class='form-group'>
{{ Form::label('bh', '学员编号',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('bh', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('name', '学员姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('name', null, ['class'=>'form-control']) }}
</div>
</div>
</div>
</div>
<div class='form-group'>
{{ Form::label('sexboy', '男孩',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('sexboy', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('birthday', '出生日期',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('birthday', null, ['class'=>'form-control']) }}
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
