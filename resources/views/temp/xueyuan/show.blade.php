@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("update", new \App\Model\Role){!! link_to("tempxueyuan/$task->id/edit","编辑临时学员") !!} || @endcan @include("layouts.shortcut21")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    临时学员详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"tempxueyuan/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->dianpu->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('getJzname()', '家长姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->getJzname() }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('bh', '学员编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->bh }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name', '学员姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('sexboy', '男孩',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->sexboy }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('birthday', '出生日期',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->birthday }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('studKssj', '学中文课',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->studKssj }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('studKszh', '学英文课',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->studKszh }}
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