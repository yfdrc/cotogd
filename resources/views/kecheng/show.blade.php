@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("kecheng/create","增加课程") !!} | @endcan @can("dianzhang", new \App\Model\Role){!! link_to("kecheng/$task->id/edit","编辑课程") !!} || @endcan @include("layouts.shortcut12")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
课程详情
</div>
<div class="panel-body">
{!!  Form::model($task, ['url'=>"kecheng/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
<div class='form-group'>
{{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->dianpu->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('name', '课程名称',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('ageMin', '年龄下限',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->ageMin, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('ageMax', '年龄上限',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->ageMax, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('quanZhong', '课程权重',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->quanZhong, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('boach', '老师姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->boach, ['class'=>'form-control']) }}
</div>
</div>
@can("manage", new App\Model\Role)
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