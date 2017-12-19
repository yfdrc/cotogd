@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@can("dianzhang", new \App\Model\Role){!! link_to("tjshangke","统计上课") !!} | @endcan @can("dianzhang", new \App\Model\Role){!! link_to("tjmake","统计扣课") !!}  @endcan
        </div>
        <div class="panel-body">
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        上课情况 - 列表
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>课程名称</th>
                            <th>最少人数</th>
                            <th>最多人数</th>
                            <th>当前人数</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->kecheng->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->kecheng->skrsMin }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->kecheng->skrsMax }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->skrs }}</div>
                                    </td>
                                    <td>
                                        <a href="tjshangke\{{ $task->id }}">详情</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
