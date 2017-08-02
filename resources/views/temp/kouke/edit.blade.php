@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：{!! link_to("tempkouke/$task->id","临时扣课详情") !!} ||  @include("layouts.shortcut21")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
编辑临时扣课
</div>
<div class="panel-body">
{{ Form::model($task, ["url"=>"tempkouke/$task->id", "method" => "PUT", "class" => "form-horizontal"]) }}
<div class='panel panel-primary'>
<div class='panel-heading'>
必填项目
</div>
<div class='panel-body'>
<div class='form-group'>
{{ Form::label('studTime', '上课日期',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::textarea('studTime', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('studKs', '上课时数',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('studKs', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('zeheKs', '折合课数',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('zeheKs', null, ['class'=>'form-control']) }}
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
