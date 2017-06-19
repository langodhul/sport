@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                照片修改
            </div>
            <div class="panel-body">
                <form method="post" id="uploadForm" action="{{ url('/backstage/photo/edit') }}" role="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $photo->id }}">
                    <input type="hidden" name="type" value="update">
                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-title">标题</label>
                        <div class="col-md-8">
                            <input type="text" id="f-title" class="form-control" name="title" value="{{ $photo->title }}" required>
                        </div>
                        <label class="control-label col-md-1" for="f-creator">作者</label>
                        <div class="col-md-2">
                            <input type="text" id="f-creator" class="form-control" name="creator" value="{{ $photo->creator }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-priority">优先级</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="f-priority" name="priority" value="{{ $photo->priority }}" style="text-align: center" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-descript">描述</label>
                        <div class="col-md-11">
                            <input type="text" id="f-descript" class="form-control" name="descript" value="{{ $photo->descript }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f-path" class="control-label col-md-1">照片</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="f-path" value="{{ $photo->path }}" name="path" readonly required>
                        </div>
                        <div class="col-md-3">
                            <div class="btn btn-default changePhoto">更换图片</div>
                            <a href="{{ url($photo->path) }}" target="view_window" class="btn btn-default viewPhoto">浏览</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-1 col-md-2">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <a href="{{ url('/backstage/createphoto') }}" class="btn btn-default">返回</a>
                        </div>
                    </div>
                </form>

                <form action="{{ url('/backstage/photo/edit') }}" method="post" enctype="multipart/form-data" style="display: none" id="hideForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="h-type" name="type" value="changephoto">
                    <input type="hidden" id="h-id" name="id" value="{{ $photo->id }}">
                    <input type="file" id="h-fileInput" name="photo" style="display: none">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
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