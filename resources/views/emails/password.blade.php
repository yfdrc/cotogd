@extends('layouts.app')

@section('content')
    @include('common.errors')

    Click here to reset your password: {{ url('password/reset/'.$token) }}

@endsection