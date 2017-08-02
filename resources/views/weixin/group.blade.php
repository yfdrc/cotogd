@extends('layouts.app')

@section('shortcut')
    @include('layouts.wx.wx05')
@endsection

@section('content')
    @include('common.errors')

    <div class="panel panel-primary">
        <div class="panel-heading">
            用户组管理
        </div>
        <div class="panel-body">
            {!! isset($ts) ? $ts : '' !!}
        </div>
    </div>

@endsection
