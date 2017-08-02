@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            快捷方式：@include("layouts.shortcut32")
        </div>
        <div class="panel-body">
            <div>
                {!! Form::open( ["url"=>"tjkouke","method"=>"POST", "class"=>"form-inline"]) !!}
                <div class="form-group">
                    每页行数：<input type="text" class="form-control" name="xshs" value="{!! Illuminate\Support\Facades\Cache::get("tjjzkoukehs") !!}">
                </div>
                <div class="form-group">
                    查询：<input type="text" class="form-control" name="cxnr" value="{!! Illuminate\Support\Facades\Cache::get("tjjzkoukecx") !!}" placeholder="上课日期">
                </div>
                <button type="submit" class="btn btn-default">确定</button>
                {!! Form::close() !!}
            </div>
            @if (count($tasks) > 0)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        扣课统计情况 - 家长
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped task-table'>
                            <thead>
                            <th>家长姓名</th>
                            <th>小孩情况</th>
                            <th>学习情况</th>
                            <th>上课时数</th>
                            <th>折合时数</th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class='table-text'>
                                        <div>{{ $task->jiazhang->name }}</div>
                                    </td>
                                    <td class='table-text col-lg-2'>
                                        <div>{{ $task->xhqk }}</div>
                                    </td>
                                    <td class='table-text col-md-4'>
                                        <div>{{ $task->studQk }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->studKs }}</div>
                                    </td>
                                    <td class='table-text'>
                                        <div>{{ $task->zeheKs }}</div>
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
