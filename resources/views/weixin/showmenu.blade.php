@extends('layouts.app')

@section('shortcut')
    @include("layouts.wx.$menu")
@endsection

@section('content')
    @include('common.errors')

    <div class="panel panel-primary">
        <div class="panel-heading">
            {!! isset($bt) ? $bt : '' !!}
        </div>
        <div class="panel-body">
            {!! isset($ts) ? $ts : '' !!}
        </div>
    </div>

@endsection
