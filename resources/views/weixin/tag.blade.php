@extends('layouts.app')

@section('shortcut')
    @include('layouts.wx.wx06')
@endsection

@section('content')
    @include('common.errors')

    <div class="panel panel-primary">
        <div class="panel-heading">
            用户标签管理
        </div>
        <div class="panel-body">
            {!! isset($ts) ? $ts : '' !!}
        </div>
    </div>

@endsection
