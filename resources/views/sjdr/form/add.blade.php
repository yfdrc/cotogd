@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    用于开发 - 自动生成代码
                </div>
                <div class="panel-body">
                    <table class="table center-block">
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"createform?type=wxuser","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>微信用户</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=wxgroup","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>微信用户组</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"createform?type=dianpu","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>店铺</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=kecheng","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>课程</button>
                                </div>
                                {!! Form::close() !!}

                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=yonggong","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>员工</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {{--{!! Form::open(["url"=>"createform?type=user","method"=>"POST","class"=>"form-horizontal"]) !!}--}}
                                {{--<div class='col-sm-2'>--}}
                                {{--<button type='submit' class='btn btn-success'>账户</button>--}}
                                {{--</div>--}}
                                {{--{!! Form::close() !!}--}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"createform?type=jiazhang","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>家长</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=xueyuan","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>学员</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=xieyi","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>协议</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=kouke","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>扣课</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </table>
                    <table class="table center-block">
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"createform?type=tmkecheng","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>临时课程</button>
                                </div>
                                {!! Form::close() !!}

                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=tmyonggong","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>临时员工</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"createform?type=tmjiazhang","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>临时家长</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=tmxueyuan","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>临时学员</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=tmxieyi","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>临时协议</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=tmkouke","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>临时扣课</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"createform?type=yssjzbjz","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>原始家长学员</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=yssjzbxy","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>原始员工协议</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"createform?type=yssjkkb","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>原始课程扣课</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection