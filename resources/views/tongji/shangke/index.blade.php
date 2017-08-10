@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@include("layouts.shortcut32")
        </div>
        <div class="panel-body">
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        上课情况
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>课程名称</th>
                            <th>最少人数</th>
                            <th>最多人数</th>
                            <th>当前人数</th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->skrsMin }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->skrsMax }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->skrs }}</div>
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
