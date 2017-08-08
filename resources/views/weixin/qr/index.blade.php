@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("create", new \App\Model\Role){!! link_to("wechatapiqr/create","增加微信课程二维码") !!} || @endcan @include("layouts.wx.wx04")
        </div>
        <div class="panel-body">
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        微信课程二维码列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>名称</th>
                            <th>票据</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        <div class='col-lg-2'>{{ $task->scene_str }}</div>
                                    </td>
                                    <td>
                                        <div class='col-lg-4'>{{ $task->ticket }}</div>
                                    </td>
                                    <td>
                                        <a href="wechatapiqr\{{ $task->id }}">详情</a> @can("create", new \App\Model\Role) | <a href="wechatapiqr\{{ $task->id }}\edit">编辑</a> @endcan
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
