@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("yonggong/create","增加员工") !!} || @endcan @include("layouts.shortcut12")
        </div>
        <div class="panel-body">
            <div>
                {!! Form::open( ["method"=>"put", "class"=>"form-inline"]) !!}
                <div class="form-group">
                    每页行数：<input type="text" class="form-control" name="xshs" value="{!! Illuminate\Support\Facades\Cache::get("yghs") !!}">
                </div>
                <div class="form-group">
                    查询：<input type="text" class="form-control" name="cxnr" value="{!! Illuminate\Support\Facades\Cache::get("ygcx") !!}" placeholder="姓名联系电话">
                </div>
                <button type="submit" class="btn btn-default">确定</button>
                {!! Form::close() !!}
            </div>
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        员工列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>店铺名称</th>
                            <th>员工姓名</th>
                            <th>联系电话</th>
                            <th>职位</th>
                            <th>出生日期</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->dianpu->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->tele }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->job }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->birthday }}</div>
                                    </td>
                                    <td>
                                        <a href="yonggong\{{ $task->id }}">详情</a> @can("dianzhang", new \App\Model\Role) | <a href="yonggong\{{ $task->id }}\edit">编辑</a> @endcan @can("manage", new \App\Model\Role) | <a href="yonggong\{{ $task->id }}">删除</a>@endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $tasks->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
