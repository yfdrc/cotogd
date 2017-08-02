@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("tempkecheng/$task->id/edit","编辑临时课程") !!} || @endcan @include("layouts.shortcut21")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    临时课程详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"tempkecheng/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->dianpu->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name', '课程名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('ageMin', '年龄下限',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->ageMin }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('ageMax', '年龄上限',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->ageMax }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('quanZhong', '课程权重',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->quanZhong }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('boach', '老师姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->boach }}
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