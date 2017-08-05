@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapigroup/create","增加微信用户组") !!} || @endcan @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        微信用户组列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>序号</th>
                            <th>名称</th>
                            <th>用户数</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->id }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->count }}</div>
                                    </td>
                                    <td>
                                        <a href="wechatapigroup\{{ $task->id }}">详情</a> @can("edit", new \App\Model\Role) | <a href="wechatapigroup\{{ $task->id }}\edit">编辑</a> @endcan @can("admin", new \App\Model\Role) | <a href="wechatapigroup\{{ $task->id }}">删除</a>@endcan
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
