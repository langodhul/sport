@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">创建课程</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/course/createcourse') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-2 control-label">名称</label>

                        <div class="col-md-10">
                            <input id="name" type="name" class="form-control" name="name" value="" required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('english') ? ' has-error' : '' }}">
                        <label for="english" class="col-md-2 control-label">英文名</label>

                        <div class="col-md-10">
                            <input id="english" type="text" class="form-control" name="english" value="" required>

                            @if ($errors->has('english'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('english') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="url" class="col-md-2 control-label">链接</label>

                        <div class="col-md-10">
                            <input id="url" type="text" class="form-control" name="url" value="" required>

                            @if ($errors->has('url'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="describe" class="col-md-2 control-label">描述</label>

                        <div class="col-md-8">
                            <input id="describe" type="text" class="form-control" name="describe" value="" required>

                            @if ($errors->has('describe'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('describe') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <label class="control-label col-md-2">建议33个字符以内</label>
                    </div>

                    <div class="form-group">
                        <label for="picture" class="col-md-2 control-label">图片</label>

                        <div class="col-md-8">
                            <div class="btn btn-default z-picture">上传图片</div>
                            <div class="btn btn-default z-view" data-path="" style="display: none">浏览</div>
                            <input type="hidden" name="picture" value="" id="z-picture" required>
                        </div>

                        <label class="control-label col-md-2">建议244*166px</label>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">
                                添加
                            </button>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ url('/course/savepicture') }}" id="uploadForm"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <input style="display: none;" name="picture" type="file" class="fileInput" />
                </form>
                <hr>
                <div class="col-md-12" style="text-align: center;height: 150px">
                    <img src="" alt="" class="z-showPicture" style="max-height: 150px; display: none">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $('.z-picture').click(function () {
            $('.fileInput').click()
        })

        $('.fileInput').change(function () {
            if ($.trim($(this).val())) {
                $("#uploadForm").submit();
            }
        })

        $("#uploadForm").submit(function (e) {
            e.preventDefault()
            $.ajax({
                url: "{{url('/course/savepicture')}}",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (rep) {
                    if(rep.code){
                        $('#z-picture').val(rep.path)
                        $('.z-showPicture').attr('src', rep.path).show()
                        $('.z-picture').html('更换图片')
                        $('.message').show()
                        $('.message').text(rep.msg)
                        setTimeout(function () {
                            $('.message').fadeOut('show',function () {
                                $('.message').text('')
                            });
                        },3000);//3秒后消失
                    }
                }
            });
        })
    </script>
@endsection