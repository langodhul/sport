@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">管理员列表</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>用户名</th>
                            <th>创建人</th>
                            <th>创建时间</th>
                            <th>最后登陆时间</th>
                            <th>最后登陆IP</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->username }}</td>
                                <td>{{ $admin->creator }}</td>
                                <td>{{ $admin->created_at }}</td>
                                <td>{{ $admin->updated_at }}</td>
                                <td>{{ $admin->last_ip }}</td>
                                <td>
                                    @if($admin->username != 'admin')
                                        <a href="{{ '/admin/doedit/'.$admin->id }}" data-uid="{{ $admin->id }}">编辑</a>
                                        <a class="z-delete" href="javascript:void(0)" data-url="{{ '/admin/deleteadmin/'.$admin->id }}">删除</a>
                                        @if($admin->is_active)
                                            <a class="z-active" href="javascript:void(0)" data-url="{{ '/admin/activeadmin/'.$admin->id }}" data-name="{{ $admin->username }}">启用中</a>
                                        @else
                                            <a class="z-active" href='javascript:void(0)' data-url="{{ '/admin/activeadmin/'.$admin->id }}" data-name="{{ $admin->username }}">禁用中</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="text-align: center">{{ $admins->links() }}</div>
            </div>
        </div>
    </div>

@endsection

@section('rightjs')
    <script>
        //admin active
        $('.z-active').click(function(){
            var url = $(this).attr('data-url')
            var el = $(this)
            var name = $(this).attr('data-name')
            $.ajax({
                url: url,
                type: 'post',
                dataTypr: 'text',
                success: function (rep) {
                    el.text(rep)
                    $('.message').show()
                    $('.message').text(name + ' ' + rep + '！')
                    setTimeout(function () {
                        $('.message').fadeOut('show',function () {
                            $('.message').text('')
                        });
                    },3000);//3秒后消失
                }
            })
        });

        //admin delete
        $('.z-delete').click(function(){
            if(confirm('确定要删除吗？')){
                var url = $(this).attr('data-url')
                $.ajax({
                    url: url,
                    type: 'post',
                    success: function (rep) {
                        if(!rep)
                        {
                            window.location.href='{{ url('/backstage/adminlist') }}'
                        }else{
                            $('.message').show()
                            $('.message').text(rep)
                            setTimeout(function () {
                                $('.message').fadeOut('show',function () {
                                    $('.message').text('')
                                });
                            },3000);//3秒后消失
                        }
                    }
                })
            }
        });
    </script>

@endsection