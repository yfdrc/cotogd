@extends('layouts.app')

@section('content')
    @include('common.errors')

    <div class="panel panel-primary">
        <div class="panel-heading">
            账户登录
        </div>
        <div class="panel-body">
            <form action="{{url('auth/login')}}" method='POST' class="form-horizontal">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">邮件地址</label>

                    <div class="col-sm-4">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">用户密码</label>

                    <div class="col-sm-3">
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="remember" class="col-sm-3 control-label">记住登录信息</label>

                    <div class="col-sm-2">
                        <input type="checkbox" name="remember" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-success">确定登录</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection