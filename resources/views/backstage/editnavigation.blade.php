@extends('layouts.manage')

@section('right')
    @include('vendor.ueditor.assets')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                导航编辑
            </div>
            <div class="panel-body">
                <form method="post" id="uploadForm" action="{{ url('/backstage/editnavigation') }}" role="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $navigation->id }}">
                    <input type="hidden" name="fid" value="{{ $navigation->fid }}">
                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-name">名称</label>
                        <div class="col-md-8">
                            <input type="text" id="f-name" class="form-control" name="name" value="{{ $navigation->name }}" required>
                        </div>
                        <label class="control-label col-md-1" for="f-url">链接</label>
                        <div class="col-md-2">
                            <input type="text" id="f-url" class="form-control" name="url" value="{{ $navigation->url }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-priority">优先级</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="f-priority" name="priority" value="{{ $navigation->priority }}" style="text-align: center" required>
                        </div>
                    </div>
                    @if($navigation->fid == 0)
                    <div class="form-group">
                        <label for="f-pictureUrl" class="control-label col-md-1">横幅</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="f-pictureUrl" value="{{ $navigation->picture_url }}" name="picture_url" readonly required>
                        </div>
                        <div class="col-md-3">
                            <div class="btn btn-default changePhoto">更换图片</div>
                            <a href="{{ url($navigation->picture_url) }}" target="view_window" class="btn btn-default viewPhoto">浏览</a>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="content" class="control-label col-md-1">页面</label>
                        <script id="container" class="col-md-10" name="content" type="text/plain" style="height: 180px">{!! $navigation->content !!} </script>

                        </div>
                    <div class="form-group">
                        <div class="col-md-offset-1 col-md-2">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <a href="{{ url('/backstage/sitenavigation') }}" class="btn btn-default">返回</a>
                        </div>
                    </div>
                </form>

                <form action="{{ url('/backstage/photo/edit') }}" method="post" enctype="multipart/form-data" style="display: none" id="hideForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="h-type" name="type" value="changephoto">
                    <input type="hidden" id="h-id" name="id" value="{{ $navigation->id }}">
                    <input type="file" id="h-fileInput" name="photo" style="display: none">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        var ue = UE.getEditor('container');
        ue.ready(function() {
             ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });

        $('.changePhoto').click(function(){
            $('#h-fileInput').click()
        })
        $('#h-fileInput').change(function(){
            $('#hideForm').submit()
        })

        $('#hideForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ url('/backstage/photo/edit') }}',
                type: 'post',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (rep){
                    if(rep.code)
                    {
                        $('#f-pictureUrl').val(rep.path)
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