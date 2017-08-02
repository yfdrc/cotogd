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
新建学员
</div>
<div class="panel-body">
{!! Form::open(["url"=>"xueyuan","method"=>"POST","class"=>"form-horizontal"]) !!}
<div class='panel panel-primary'>
<div class='panel-heading'>
必填项目
</div>
<div class='panel-body'>
<div class='form-group'>
{{ Form::label('jiazhang_id', '家长编号',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::select('jiazhang_id', $dp, null, ['class'=>'form-control']) }}
</div>
</div>
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
<button type='submit' class='btn btn-success'>确定增加</button>
</div>
</div>
{!! Form::close() !!}
</div>
</div>
</div>
</div>

@endsection
