@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                客户修改
            </div>
            <div class="panel-body">
                <form method="post" id="uploadForm" action="{{ url('/backstage/customer/edit') }}" role="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $customer->id }}">
                    <input type="hidden" name="type" value="update">
                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-name">名称</label>
                        <div class="col-md-11">
                            <input type="text" id="f-name" class="form-control" name="name" value="{{ $customer->name }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-priority">优先级</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="f-priority" name="priority" value="{{ $customer->priority }}" style="text-align: center" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-url">链接</label>
                        <div class="col-md-11">
                            <input type="text" id="f-url" class="form-control" name="url" value="{{ $customer->url }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f-path" class="control-label col-md-1">照片</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="f-path" value="{{ $customer->path }}" name="path" readonly required>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url($customer->path) }}" target="view_window" class="btn btn-default viewPhoto">浏览</a>
                            <div class="btn btn-default changePicture">更换图片</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-1 col-md-2">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <a href="{{ url('/backstage/customer') }}" class="btn btn-default">返回</a>
                        </div>
                    </div>
                </form>

                <form action="{{ url('/backstage/customer/edit') }}" method="post" enctype="multipart/form-data" style="display: none" id="hideForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="h-type" name="type" value="changepicture">
                    <input type="hidden" id="h-id" name="id" value="{{ $customer->id }}">
                    <input type="file" id="h-fileInput" name="picture" style="display: none">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $('.changePicture').click(function(){
            $('#h-fileInput').click()
        })
        $('#h-fileInput').change(function(){
            $('#hideForm').submit()
        })

        $('#hideForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ url('/backstage/customer/edit') }}',
                type: 'post',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (rep){
                    if(rep.code)
                    {
                        $('#f-path').val(rep.path)
                        $('.viewPhoto').attr('href', rep.href)
                    }
                    $('.message').show()
                    $('.message').text(rep.msg)
                    setTimeout(function () {
                        $('.message').fadeOut('show',function(){
                            $('.message').text('')
                        })
                    },3000)
                }
            })

        })

    </script>
@endsection