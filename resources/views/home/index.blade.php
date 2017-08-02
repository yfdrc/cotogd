@extends('layouts.app')

@section('shortcut')
    @include('layouts.shortcut01')
@endsection

@section('content')
    @include('common.errors')

    <div class="panel panel-primary">
        <div class="panel-heading">
            你目前拥有的权限：
        </div>
        <div class="panel-body">
            <ol>
                @can('view', new \App\Model\Role)
                    <li>
                        <a href="#">查看权限</a>
                    </li>
                @endcan
                @can('create', new \App\Model\Role)
                    <li>
                        <a href="#">新建权限</a>
                    </li>
                @endcan
                @can('update', new \App\Model\Role)
                    <li>
                        <a href="#">编辑权限</a>
                    </li>
                @endcan
                @can('delete', new \App\Model\Role)
                    <li>
                        <a href="#">删除权限</a>
                    </li>
                @endcan
                @can('caiwu', new \App\Model\Role)
                    <li>
                        <a href="#">财务权限</a>
                    </li>
                @endcan
                @can('dianzhang', new \App\Model\Role)
                    <li>
                        <a href="#">店长权限</a>
                    </li>
                @endcan
                @can('manage', new \App\Model\Role)
                    <li>
                        <a href="#">管理员权限</a>
                    </li>
                @endcan
                @can('admin', new \App\Model\Role)
                    <li>
                        <a href="#">超级管理员</a>
                    </li>
                @endcan
            </ol>
        </div>
    </div>

@endsection
