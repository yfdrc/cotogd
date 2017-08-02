@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("update", new \App\Model\Role){!! link_to("yssjzbxy/$task->id/edit","编辑原始资料 - 总表 - 员工协议") !!} || @endcan @include("layouts.shortcut31")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    原始资料 - 总表 - 员工协议详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"yssjzbxy/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
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
                        {{ Form::label('xybh', '协议编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xybh }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('qysj', '签约时间',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->qysj }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('kszw', '中文课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->kszw }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('ksyw', '英文课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->ksyw }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('jine', '金额',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->jine }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('kebao', '课包',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->kebao }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('zffs', '是否转账',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->zffs }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('gw1', '顾问1',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->gw1 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('gw2', '顾问2',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->gw2 }}
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