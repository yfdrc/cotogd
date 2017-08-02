@extends('layouts.app')

@section('content')
@include('common.errors')

<div class="panel panel-default">
<div class="panel-heading">
快捷方式：@can("manage", new \App\Model\Role){!! link_to("dianpu/create","增加店铺") !!} || @endcan @include("layouts.shortcut12")
</div>
<div class="panel-body">
@if (count($tasks) > 0)
<div class="panel panel-info">
<div class="panel-heading">
店铺列表
</div>
<div class="panel-body">
<table class='table table-striped task-table'>
<thead>
<th>店铺名称</th>
<th>店铺说明</th>
<th>店铺电话</th>
<th>店铺地址</th>
<th></th>
</thead>
<tbody>
@foreach ($tasks as $task)
<tr>
<td class='table-text'>
<div>{{ $task->name }}</div>
</td>
<td class='table-text'>
<div>{{ $task->description }}</div>
</td>
<td class='table-text'>
<div>{{ $task->telephone }}</div>
</td>
<td class='table-text'>
<div>{{ $task->address }}</div>
</td>
<td>
<a href="dianpu\{{ $task->id }}">详情</a> @can("dianzhang", new \App\Model\Role) | <a href="dianpu\{{ $task->id }}\edit">编辑</a> @endcan @can("manage", new \App\Model\Role) | <a href="dianpu\{{ $task->id }}">删除</a>@endcan
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
