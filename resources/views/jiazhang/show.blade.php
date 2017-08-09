@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("jiazhang/create","增加家长") !!} | @endcan @can("update", new \App\Model\Role){!! link_to("jiazhang/$task->id/edit","编辑家长") !!} || @endcan @include("layouts.shortcut11")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    家长详情
                </div>
                <div class="panel-body">
                    {!!  Form::model($task, ['url'=>"jiazhang/$task->id", "method" => "DELETE", "class" => "form-horizontal"]) !!}
                    <div class='form-group'>
                        {{ Form::label('dianpu->name', '店铺名称',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->dianpu->name, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('bh', '家长编号',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->bh, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name', '家长姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->name, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('tele', '家长手机',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->tele, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('name2', '家长2姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->name2, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('tele2', '家长2手机',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->tele2, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('hAddress', '家庭住址',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->hAddress, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('howGet', '获取渠道',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->howGet, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('region', '所在区域',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->region, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('whenStud', '排课时间',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->whenStud, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('leftKeshi', '剩余课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->leftKeshi, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('buyZw', '买短时课',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->buyDs, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('buyZw', '买中文课',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->buyZw, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('buyYw', '买英文课',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->buyYw, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('studKssj', '学习课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->studKssj, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('studKszh', '折合课时',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->studKszh, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('buyMoney', '购买金额',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::label('', $task->buyMoney, ['class'=>'form-control']) }}
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