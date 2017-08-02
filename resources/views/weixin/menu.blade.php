@extends('layouts.app')

@section('shortcut')
    @include('layouts.wx.wx01')
@endsection

@section('content')
    @include('common.errors')

    <div class="panel panel-primary">
        <div class="panel-heading">
            微信菜单
        </div>
        <div class="panel-body">
            {!! isset($ts) ? $ts : '' !!}
        </div>
    </div>

@endsection
