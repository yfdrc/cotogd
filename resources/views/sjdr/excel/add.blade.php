@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@include("layouts.shortcut31")
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    自csv文件导入库 -- 需一步一步往下做
                </div>
                <div class="panel-body">
                    <table class="table center-block">
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"upload","method"=>"GET","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第一步：上传csv文件（两文件）</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=etodbzb","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第二步：将总表csv文件入库</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=etodbkkb","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第三步：将扣课表csv文件入库</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=dballadd","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第四步：一次性写入临时数据</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=dballsave","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第五步：一次性写入日常数据</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=dbshyu","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第六步：重新计算各课程时数</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    可选操作 -- 将数据写入指定位置
                </div>
                <div class="panel-body">
                    <table class="table center-block">
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=addyonggong","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-warning'>01：自原始数据写入临时员工</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=addkecheng","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-warning'>02：自原始数据写入临时课程</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=addjiazhang","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-warning'>03：自原始数据写入临时家长</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=addxueyuan","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-warning'>04：自原始数据写入临时学员</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=addxieyi","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-warning'>05：自原始数据写入临时协议</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=addkouke","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-warning'>06：自原始数据写入临时扣课</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=saveyonggong","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-danger'>07：自临时数据写入员工</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=savekecheng","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-danger'>08：自临时数据写入课程</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=savejiazhang","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-danger'>09：自临时数据写入家长</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=savexueyuan","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-danger'>10：自临时数据写入学员</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=savexieyi","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-danger'>11：自临时数据写入协议</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=savekouke","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-danger'>12：自临时数据写入扣课</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection