@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：{!! link_to("yssjzbjz/$task->id","原始资料 - 总表 - 家长学员详情") !!} ||  @include("layouts.shortcut31")
        </div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    编辑原始资料 - 总表 - 家长学员
                </div>
                <div class="panel-body">
                    {{ Form::model($task, ["url"=>"yssjzbjz/$task->id", "method" => "PUT", "class" => "form-horizontal"]) }}
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            必填项目
                        </div>
                        <div class='panel-body'>
                            <div class='form-group'>
                                {{ Form::label('dianpu_id', '店铺编号',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('dianpu_id', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('jzbh', '家长编号',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('jzbh', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('moname', '妈妈姓名',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('moname', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('motele', '妈妈电话',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('motele', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('pksj', '排课时间',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('pksj', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('xhname1', '小孩1姓名',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('xhname1', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('xhbirth1', '小孩1生日',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('xhbirth1', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class='form-group'>
                                {{ Form::label('xhsex1', '小孩1性别',['class'=>'col-sm-3 control-label']) }}
                                <div class='col-sm-6'>
                                    {{ Form::text('xhsex1', null, ['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhname2', '小孩2姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('xhname2', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhbirth2', '小孩2生日',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('xhbirth2', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhsex2', '小孩2性别',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('xhsex2', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhname3', '小孩3姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('xhname3', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhbirth3', '小孩3生日',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('xhbirth3', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('xhsex3', '小孩3性别',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('xhsex3', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('faname', '爸爸姓名',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('faname', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('fatele', '爸爸电话',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('fatele', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('addr', '地址',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('addr', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('quyu', '区域',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('quyu', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('hqqd', '获取渠道',['class'=>'col-sm-3 control-label']) }}
                        <div class='col-sm-6'>
                            {{ Form::text('hqqd', null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-offset-3 col-sm-6'>
                            <button type='submit' class='btn btn-warning'>确定修改</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
