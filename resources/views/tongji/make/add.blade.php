@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-success">
        <div class="panel-heading">
            快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("tjshangke","统计上课") !!} | @endcan @can("dianzhang", new \App\Model\Role){!! link_to("tjmake","统计扣课") !!}  @endcan
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    统计资料
                </div>
                <div class="panel-body">
                    <table class="table center-block">
                        <tr>
                            <td>
                                {!! Form::open(["url"=>"tjmake?type=kouke","method"=>"POST","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>更新统计资料</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"tjkouke/create","method"=>"GET","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>查看家长扣课情况</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                            <td>
                                {!! Form::open(["url"=>"tjkouke","method"=>"GET","class"=>"form-horizontal"]) !!}
                                <div class='col-sm-2'>
                                    <button type='submit' class='btn btn-success'>查看学员扣课情况</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection