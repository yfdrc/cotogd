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
                    自库导出Excel文件 -- 确认
                </div>
                <div class="panel-body">
                    <table class="table center-block">
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=dbtoout","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第一步：生成待写入Excel文件的数据</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=dbtozb","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第二步：将数据写入Excel的总表</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"excelTodb?type=dbtokkb","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>第三步：将数据写入Excel的扣课表</button>
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