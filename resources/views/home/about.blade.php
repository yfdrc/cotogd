@extends('layouts.app')

@section('shortcut')
    @include('layouts.shortcut01')
@endsection

@section('content')
    @include('common.errors')

    <div class="panel panel-primary">
        <div class="panel-heading">
            关于系统
        </div>
        <div class="panel-body">
            本系统主要通过Excel文件导入数据用于查询和统计。
        </div>
    </div>

@endsection
