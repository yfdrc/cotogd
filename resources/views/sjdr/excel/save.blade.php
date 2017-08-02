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
                    自Excel导入库 -- 显示结果
                </div>
                <div class="panel-body">
                    {!! $xsnr !!}
                </div>
            </div>
        </div>
    </div>

@endsection