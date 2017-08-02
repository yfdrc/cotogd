@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("update", new \App\Model\Role){!! link_to("tempjiazhang/$task->id/edit","编辑临时家长") !!} || @endcan @include("layouts.shortcut21")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    临时家长详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"tempjiazhang/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->dianpu->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('bh', '家长编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->bh }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name', '家长姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->name }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('tele', '家长手机',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->tele }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name2', '家长2姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->name2 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('tele2', '家长2手机',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->tele2 }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('hAddress', '家庭住址',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->hAddress }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('howGet', '获取渠道',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->howGet }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('region', '所在区域',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->region }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('whenStud', '排课时间',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->whenStud }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('leftKeshi', '剩余课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->leftKeshi }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('buyZw', '买中文课',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->buyZw }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('buyYw', '买英文课',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->buyYw }}
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
                    <div class='form-group'>
                        {{ Form::label('buyMoney', '购买金额',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ $task->buyMoney }}
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