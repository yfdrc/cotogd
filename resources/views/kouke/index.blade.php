@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("kouke/create","增加扣课") !!} || @endcan @include("layouts.shortcut11")
        </div>
        <div class="panel-body">
            <div>
                {!! Form::open( ["method"=>"put", "class"=>"form-inline"]) !!}
                <div class="form-group">
                    每页行数：<input type="text" class="form-control" name="xshs" value="{!! Illuminate\Support\Facades\Cache::get("koukhs") !!}">
                </div>
                <div class="form-group">
                    查询：<input type="text" class="form-control" name="cxnr" value="{!! Illuminate\Support\Facades\Cache::get("koukcx") !!}" placeholder="">
                </div>
                <button type="submit" class="btn btn-default">确定</button>
                {!! Form::close() !!}
            </div>
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        扣课列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>家长姓名</th>
                            <th>学员编号</th>
                            <th>学员姓名</th>
                            <th>课程名称</th>
                            <th>上课时数</th>
                            <th>课程权重</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->jzname }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->xybh }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->xyname }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->kcname }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->studKs }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->kcQz }}</div>
                                    </td>
                                    <td>
                                        <a href="kouke\{{ $task->id }}">详情</a> @can("update", new \App\Model\Role) | <a href="kouke\{{ $task->id }}\edit">编辑</a> @endcan @can("delete", new \App\Model\Role) | <a href="kouke\{{ $task->id }}">删除</a>@endcan
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
