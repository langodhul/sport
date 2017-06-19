@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                管理员登陆日志
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>管理员</th>
                            <th>登陆时间</th>
                            <th>登陆IP</th>
                            <th>登陆信息</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->username }}</td>
                                <td>{{ $log->updated_at }}</td>
                                <td>{{ $log->ip }}</td>
                                <td>{{ $log->comment }}</td>

                            </tr>
                        @endforeach
                        </tbody>    </table>
                </div>
                <div style="text-align: center">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>

@endsection