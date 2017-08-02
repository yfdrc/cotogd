@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：@include("layouts.shortcut21")
</div>
<div class="panel-body">
<div class="panel panel-success">
<div class="panel-heading">
新建临时扣课
</div>
<div class="panel-body">
{!! Form::open(["url"=>"tempkouke","method"=>"POST","class"=>"form-horizontal"]) !!}
<div class='panel panel-primary'>
<div class='panel-heading'>
必填项目
</div>
<div class='panel-body'>
<div class='form-group'>
{{ Form::label('xueyuan_id', '学员姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::select('xueyuan_id', $dp, null, ['class'=>'form-control']) }}
</div>
</div>
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
<button type='submit' class='btn btn-success'>确定增加</button>
</div>
</div>
{!! Form::close() !!}
</div>
</div>
</div>
</div>

@endsection
