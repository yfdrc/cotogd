@extends('layouts.app')

@section('shortcut')
    @include('layouts.shortcut01')
@endsection

@section('content')
    @include('common.errors')

    <div class="panel panel-info">
        <div class="panel-heading">
            联系我们
        </div>
        <div class="panel-body">
            {!! $tasks -> description !!}
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            联系电话
        </div>
        <div class="panel-body">
            {!! $tasks -> telephone !!}
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            Email
        </div>
        <div class="panel-body">
            {!! $tasks -> email !!}
        </div>
    </div>
    <div class="panel panel-warning">
        <div class="panel-heading">
            联系地址
        </div>
        <div class="panel-body">
            {!! $tasks -> address !!}
        </div>
    </div>
@endsection
