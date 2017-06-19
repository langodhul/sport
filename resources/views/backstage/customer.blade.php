@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                合作客户
            </div>
            <div class="panel-body">
                <form method="post" id="uploadForm" action="{{ url('/backstage/customer') }}" enctype="multipart/form-data" role="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-name">名称</label>
                        <div class="col-md-2">
                            <input type="text" id="f-name" class="form-control" name="name" required>
                        </div>

                        <label class="control-label col-md-1" for="f-priority">优先级</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control" id="f-priority" name="priority" value="9" style="text-align: center" required>
                        </div>
                        <label class="control-label col-md-1" for="f-url">链接</label>
                        <div class="col-md-4">
                            <input type="text" id="f-url" class="form-control" name="url" required>
                        </div>
                        <input type="file" name="picture" id="f-picture" style="display: none">
                        <div class="col-md-2">
                            <div class="btn btn-default addPicture">
                                选图并添加
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                @if(isset($customers))
                    <form role="form" class="form-horizontal">
                        @foreach($customers as $customer)
                            <div class="form-group">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="y-name" name="name" value="{{ $customer->name }}" readonly>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" id="y-priority" name="priority" value="{{ $customer->priority }}" style="text-align: center" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="y-url" name="url" value="{{ $customer->url }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ url('/backstage/customer/edit/'.$customer->id) }}" class="btn btn-default">编辑</a>
                                    <a href="{{ url($customer->path) }}" target="view_window" class="btn btn-default">图片</a>
                                    <div class="btn btn-default b-delete" data-type="delete" data-id="{{ $customer->id }}">删除</div>
                                    @if($customer->is_show)
                                        <div class="btn btn-success b-hide" data-type="isshow" data-id="{{ $customer->id }}">显示中</div>
                                    @else
                                        <div class="btn btn-default b-show" data-type="isshow" data-id="{{ $customer->id }}">隐藏中</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </form>
                @endif
                <form action="{{ url('/backstage/customer/edit') }}" method="post" style="display: none" id="hideForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="h-type" name="type">
                    <input type="hidden" id="h-id" name="id">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $('.addPicture').click(function(){
            if($.trim($('#f-name').val()) && $.trim($('#f-url').val())){
                $('#f-picture').click()
            }else{
                alert('名称或链接不能为空')
            }
        })

        $('#f-picture').change(function(){
            $('#uploadForm').submit()
        })

        $('div[data-type]').click(function(){
            if($(this).attr('data-type') == 'delete'){
                if(!confirm('确定要删除吗？')){
                    return false;
                }
            }
            $('#h-type').val($(this).attr('data-type'))
            $('#h-id').val($(this).attr('data-id'))
            $('#hideForm').submit()
        })

    </script>
@endsection