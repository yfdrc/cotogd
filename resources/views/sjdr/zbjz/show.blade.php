@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("update", new \App\Model\Role){!! link_to("yssjzbjz/$task->id/edit","编辑原始资料 - 总表 - 家长学员") !!} || @endcan @include("layouts.shortcut31")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    原始资料 - 总表 - 家长学员详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"yssjzbjz/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
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
                        {{ Form::label('moname', '妈妈姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->moname }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('motele', '妈妈电话',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->motele }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('pksj', '排课时间',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->pksj }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhname1', '小孩1姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhname1 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhbirth1', '小孩1生日',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhbirth1 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhsex1', '小孩1性别',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhsex1 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhname2', '小孩2姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhname2 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhbirth2', '小孩2生日',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhbirth2 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhsex2', '小孩2性别',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhsex2 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhname3', '小孩3姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhname3 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhbirth3', '小孩3生日',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhbirth3 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhsex3', '小孩3性别',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->xhsex3 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('faname', '爸爸姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->faname }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('fatele', '爸爸电话',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->fatele }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('addr', '地址',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->addr }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('quyu', '区域',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->quyu }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('hqqd', '获取渠道',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->hqqd }}
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