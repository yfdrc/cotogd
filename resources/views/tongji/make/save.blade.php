@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    生成统计信息 - {!! $ts !!}情况
                </div>
                <div class="panel-body">
                    {!! $xsnr !!}
                </div>
            </div>
        </div>
        <div class="panel-footer">
            {!! Form::open(["url"=>"tjmake?type=kouke","method"=>"get","class"=>"form-horizontal"]) !!}
            <button type='submit' class='btn btn-success'>返回</button>
            {!! Form::close() !!}
        </div>
    </div>

@endsection