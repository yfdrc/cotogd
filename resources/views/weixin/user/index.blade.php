@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        微信用户列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>昵称</th>
                            <th>手机号</th>
                            <th>地址</th>
                            <th>所在组</th>
                            <th>课程喜好</th>
                            <th>最近上课</th>
                            <th>加入时间</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->nickname }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->remark }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->address }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->group->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->study }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->scantime==0?'':Carbon\Carbon::createFromTimestamp($task->scantime)->addHour(8)->toDateString() }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ Carbon\Carbon::createFromTimestamp($task->subtime)->addHour(8)->toDateString() }}</div>
                                    </td>
                                    <td>
                                        <a href="wechatapiuser\{{ $task->openid }}">详情</a> @can("create", new \App\Model\Role) | <a href="wechatapiuser\{{ $task->openid }}\edit">编辑</a> @endcan @can("admin", new \App\Model\Role) | <a href="wechatapiuser\{{ $task->openid }}">删除</a>@endcan
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
