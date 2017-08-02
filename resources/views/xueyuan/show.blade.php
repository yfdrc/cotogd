@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：@can("create", new \App\Model\Role){!! link_to("xueyuan/create","增加学员") !!} | @endcan @can("update", new \App\Model\Role){!! link_to("xueyuan/$task->id/edit","编辑学员") !!} || @endcan @include("layouts.shortcut11")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
学员详情
</div>
<div class="panel-body">
{!!  Form::model($task, ['url'=>"xueyuan/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
<div class='form-group'>
{{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->dianpu->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('jiazhang->name', '家长姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->jiazhang->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('bh', '学员编号',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->bh, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('name', '学员姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('sexboy', '男孩',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->sexboy, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('birthday', '出生日期',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->birthday, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('studKssj', '学习课时',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->studKssj, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('studKszh', '折合课时',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->studKszh, ['class'=>'form-control']) }}
</div>
</div>
@can("delete", new App\Model\Role)
<div class='form-group'>
<div class='col-sm-offset-3 col-sm-6'>
<button type='submit' class='btn btn-danger'>确定删除</button>
</div>
</div>
@endcan
{!! Form::close() !!}
</div>
</div>
</div>
</div>

@endsection