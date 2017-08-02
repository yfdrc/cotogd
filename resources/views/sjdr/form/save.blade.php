@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    自动生成Form -- 生成结果： {!! $lx !!}
                </div>
                <div class="panel-body">
                    {!! $xsnr !!}
                </div>
            </div>
        </div>
    </div>

@endsection