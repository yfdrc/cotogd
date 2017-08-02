@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-success">
<div class="panel-heading">
快捷方式：@can("create", new \App\Model\Role){!! link_to("xieyi/create","增加协议") !!} | @endcan @can("update", new \App\Model\Role){!! link_to("xieyi/$task->id/edit","编辑协议") !!} || @endcan @include("layouts.shortcut11")
</div>
<div class="panel-body">
<div class="panel panel-primary">
<div class="panel-heading">
协议详情
</div>
<div class="panel-body">
{!!  Form::model($task, ['url'=>"xieyi/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
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
{{ Form::label('name', '协议编号',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->name, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('ksZw', '中文课时',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->ksZw, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('ksYw', '英文课时',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->ksYw, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('jinE', '协议金额',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->jinE, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('date', '签约日期',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->date, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('kebao', '课包',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->kebao, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('isZZ', '是否转账',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->isZZ, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('guWen1', '顾问1',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->guWen1, ['class'=>'form-control']) }}
</div>
</div>
<div class='form-group'>
{{ Form::label('guWen2', '顾问2',['class'=>'col-sm-3 control-label']) }}
<div class='col-sm-6'>
{{ Form::label('', $task->guWen2, ['class'=>'form-control']) }}
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