@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("tjshangke","统计上课") !!} | @endcan @can("dianzhang", new \App\Model\Role){!! link_to("tjmake","统计扣课") !!}  @endcan
        </div>
        <div class="panel-body">
            {!!  Form::model($task, ['url'=>"tjshangke/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
            <div class="panel panel-primary">
                <div class="panel-heading">
                    统计上课 - 详情
                </div>
                <div class="panel-body">
                    <div class='form-group'>
                        {{ Form::label('name', '课程名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->kecheng->name, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('skrsMin', '人数下限',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->kecheng->skrsMin, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('skrsMax', '人数上限',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->kecheng->skrsMax, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('skrs', '上课人数',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->skrs, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('boach', '老师姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->boach, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('skxy', '上课名单',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->skxy, ['class'=>'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection