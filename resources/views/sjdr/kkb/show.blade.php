@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("update", new \App\Model\Role){!! link_to("yssjkkb/$task->id/edit","编辑原始资料 - 总表 - 课程扣课") !!} || @endcan @include("layouts.shortcut31")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    原始资料 - 总表 - 课程扣课详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"yssjkkb/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('dianpu_id', '店铺编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->dianpu_id }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('jzbh', '家长编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->jzbh }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xybh', '学员编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xybh }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xyname', '学员姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xyname }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xyname', '课程姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->kcname }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('sksj', '上课时间',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->sksj }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('sks', '上课时数',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->sks }}
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