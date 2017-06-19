@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">新闻配置</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="picture" class="col-md-2 control-label">首页图片</label>

                        <div class="col-md-6">
                            <input id="picture" class="form-control" name="newpicture" value="{{ $configs['newpicture'] }}" readonly required>
                        </div>

                        <div class="col-md-2">
                            <div class="btn btn-default" data-name="newpicture">更换</div>
                            <div class="btn btn-default browse" data-url="{{ $configs['newpicture'] }}" >浏览</div>
                        </div>
                        <label for="logo" class="col-md-2 control-label">建议210*150px</label>
                    </div>

                    <div class="form-group">
                        <label for="video" class="col-md-2 control-label">视频封面</label>

                        <div class="col-md-6">
                            <input id="video" class="form-control" name="newvideocover" value="{{ $configs['newvideocover'] }}" readonly required>
                        </div>

                        <div class="col-md-2">
                            <div class="btn btn-default" data-name="newvideocover">更换</div>
                            <div class="btn btn-default browse" data-url="{{ $configs['newvideocover'] }}" >浏览</div>
                        </div>
                        <label for="logo" class="col-md-2 control-label">建议490*436px</label>
                    </div>

                    <div class="form-group">
                        <label for="video" class="col-md-2 control-label">首页视频</label>

                        <div class="col-md-6">
                            <input id="video" class="form-control" name="newvideo" value="{{ $configs['newvideo'] }}" readonly required>
                        </div>

                        <div class="col-md-2">
                            <div class="btn btn-default" data-name="newvideo">更换</div>
                            <div class="btn btn-default browse" data-url="" >浏览</div>
                        </div>
                        <label for="logo" class="col-md-2 control-label">必须MP4格式！</label>
                    </div>

                    <hr>
                    <div class="col-md-12" style="text-align: center;height: 150px">
                        <img src="" alt="" class="showpicture" style="max-height: 150px; display: none">
                    </div>
                </form>
                <form method="POST" action="{{ url('/new/savefile') }}" id="uploadForm"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <input class="z-name" style="display: none;" name="name" type="text" value="" >
                    <input style="display: none;" name="file" type="file" class="fileInput" />
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $("div[data-name]").click(function (){
            $('.z-name').val($(this).attr('data-name'));
            $('.fileInput').click();
        })
        $('.fileInput').change(function(){
            if ($.trim($(this).val())) {
                $("#uploadForm").trigger('submit');
            }
        });
        $('.browse').mouseover(function(){
            var url = $(this).attr('data-url')
            $('.showpicture').attr('src', url)
            $('.showpicture').show()
        })
        $('.browse').mouseout(function(){
            $('.showpicture').hide()
        })
    </script>
@endsection