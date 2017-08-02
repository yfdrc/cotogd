@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("tempyonggong/$task->id/edit","编辑临时员工") !!} || @endcan @include("layouts.shortcut21")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    临时员工详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"tempyonggong/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->dianpu->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name', '员工姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('tele', '联系电话',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->tele }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('job', '职位',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->job }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('birthday', '出生日期',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->birthday }}
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