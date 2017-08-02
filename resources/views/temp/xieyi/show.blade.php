@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("update", new \App\Model\Role){!! link_to("tempxieyi/$task->id/edit","编辑临时协议") !!} || @endcan @include("layouts.shortcut21")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    临时协议详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"tempxieyi/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
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
                        {{ Form::label('name', '协议编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('ksZw', '中文课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->ksZw }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('ksYw', '英文课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->ksYw }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('jinE', '协议金额',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->jinE }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('date', '签约日期',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->date }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('kebao', '课包',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->kebao }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('isZZ', '是否转账',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->isZZ }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('guWen1', '顾问1',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->guWen1 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('guWen2', '顾问2',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->guWen2 }}
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