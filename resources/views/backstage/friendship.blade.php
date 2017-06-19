@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-defautl">
            <div class="panel-heading">
                友情链接
            </div>
            <div class="panel-body">
                <form action="{{ url('/backstage/friendship') }}" method="post" class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="create">
                    <div class="form-group">
                        <label for="f-name" class="control-label col-md-1">名称</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="f-name" name="name" required>
                        </div>

                        <label for="f-url" class="control-label col-md-1">链接</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="f-url" name="url" required>
                        </div>
                        <label for="f-priority" class="control-label col-md-1">优先级</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control" id="f-priority" name="priority" value="9" style="text-align: center" required>
                        </div>
                        <button type="submit" class="btn btn-default">创建</button>
                    </div>
                </form>
                <hr>
                @if(isset($friendships))
                    <form role="form" class="form-horizontal" method="post">
                        @foreach($friendships as $friendship)
                            <div class="form-group">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="name{{ $friendship->id }}" name="name" value="{{ $friendship->value }}">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="url{{ $friendship->id }}" name="url" value="{{ $friendship->value2 }}">
                                </div>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" id="priority{{ $friendship->id }}" name="priority" value="{{ $friendship->value3 }}" style="text-align: center">
                                </div>
                                <div class="col-md-2">
                                    <div class="btn btn-default" data-type="update" data-name="name{{ $friendship->id }}" data-url="url{{ $friendship->id }}" data-priority="priority{{ $friendship->id }}" data-id="{{ $friendship->id }}">保存</div>
                                    <div class="btn btn-default" data-type="delete" data-name="name{{ $friendship->id }}" data-url="url{{ $friendship->id }}" data-priority="priority{{ $friendship->id }}" data-id="{{ $friendship->id }}">删除</div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                    @endif
                <form action="{{ url('/backstage/friendship') }}" method="post" style="display: none" id="hideForm">
                    {{ csrf_field() }}
                    <input type="hidden" class="h-type" name="type">
                    <input type="hidden" class="h-id" name="id">
                    <input type="hidden" class="h-name" name="name">
                    <input type="hidden" class="h-url" name="url">
                    <input type="hidden" class="h-priority" name="priority">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $('div[data-type]').click(function(){
            if(!confirm('确定要删除吗？')){
                return false;
            }
            var nameid = $(this).attr('data-name')
            var urlid = $(this).attr('data-url')
            var priorityid = $(this).attr('data-priority')
            var name = $('#'+nameid).val()
            var url = $('#'+urlid).val()
            var priority = $('#'+priorityid).val()
            if($.trim(name) &&$.trim(url) &&$.trim(priority)){
                $('.h-type').val($(this).attr('data-type'))
                $('.h-id').val($(this).attr('data-id'))
                $('.h-name').val(name)
                $('.h-url').val(url)
                $('.h-priority').val(priority)
                $('#hideForm').submit()
            }else{
                alert('字段不能为空！')
            }

        })
    </script>
@endsection