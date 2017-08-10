@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("kecheng/create","增加课程") !!} || @endcan @include("layouts.shortcut12")
        </div>
        <div class="panel-body">
            <div>
                {!! Form::open( ["method"=>"put", "class"=>"form-inline"]) !!}
                <div class="form-group">
                    每页行数：<input type="text" class="form-control" name="xshs" value="{!! Illuminate\Support\Facades\Cache::get("kchs") !!}">
                </div>
                <div class="form-group">
                    查询：<input type="text" class="form-control" name="cxnr" value="{!! Illuminate\Support\Facades\Cache::get("kccx") !!}" placeholder="课程名称">
                </div>
                <button type="submit" class="btn btn-default">确定</button>
                {!! Form::close() !!}
            </div>
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        课程列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>店铺名称</th>
                            <th>课程名称</th>
                            <th>年龄下限</th>
                            <th>年龄上限</th>
                            <th>人数下限</th>
                            <th>人数上限</th>
                            <th>课程权重</th>
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
                                        <div>{{ $task->ageMin }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->ageMax }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->skrsMin }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->skrsMax }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->quanZhong }}</div>
                                    </td>
                                    <td>
                                        <a href="kecheng\{{ $task->id }}">详情</a> @can("dianzhang", new \App\Model\Role) | <a href="kecheng\{{ $task->id }}\edit">编辑</a> @endcan @can("manage", new \App\Model\Role) | <a href="kecheng\{{ $task->id }}">删除</a>@endcan
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
