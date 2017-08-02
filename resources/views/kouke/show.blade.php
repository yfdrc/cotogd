@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：@can("create", new \App\Model\Role){!! link_to("kouke/create","增加扣课") !!} | @endcan @can("update", new \App\Model\Role){!! link_to("kouke/$task->id/edit","编辑扣课") !!} || @endcan @include("layouts.shortcut11")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
扣课详情
</div>
<div class="panel-body">
{!!  Form::model($task, ['url'=>"kouke/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
<div class='form-group'>
{{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ $task->dianpu->name }}
</div>
</div>
<div class='form-group'>
{{ Form::label('xueyuan->jiazhang->name', '家长姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ $task->xueyuan->jiazhang->name }}
</div>
</div>
<div class='form-group'>
{{ Form::label('xueyuan->name', '学员姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ $task->xueyuan->name }}
</div>
</div>
<div class='form-group'>
{{ Form::label('studTime', '上课日期',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ $task->studTime }}
</div>
</div>
<div class='form-group'>
{{ Form::label('studKs', '上课时数',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ $task->studKs }}
</div>
</div>
<div class='form-group'>
{{ Form::label('kcQz', '课程权重',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ $task->kcQz }}
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