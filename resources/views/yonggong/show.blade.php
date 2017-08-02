@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("yonggong/create","增加员工") !!} | @endcan @can("dianzhang", new \App\Model\Role){!! link_to("yonggong/$task->id/edit","编辑员工") !!} || @endcan @include("layouts.shortcut12")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
员工详情
</div>
<div class="panel-body">
{!!  Form::model($task, ['url'=>"yonggong/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
<div class='form-group'>
{{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->dianpu->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('name', '员工姓名',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('tele', '联系电话',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->tele, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('job', '职位',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->job, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('birthday', '出生日期',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->birthday, ['class'=>'form-control']) }}
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