@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：{!! link_to("tempyonggong/$task->id","临时员工详情") !!} ||  @include("layouts.shortcut21")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
编辑临时员工
</div>
<div class="panel-body">
{{ Form::model($task, ["url"=>"tempyonggong/$task->id", "method" => "PUT", "class" => "form-horizontal"]) }}
<div class='panel panel-primary'>
<div class='panel-heading'>
必填项目
</div>
<div class='panel-body'>
<div class='form-group'>
{{ Form::label('name', '员工姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('name', null, ['class'=>'form-control']) }}
</div>
</div>
</div>
</div>
<div class='form-group'>
{{ Form::label('tele', '联系电话',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('tele', null, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('job', '职位',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::text('job', null, ['class'=>'form-control']) }}
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
