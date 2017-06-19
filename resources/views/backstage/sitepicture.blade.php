@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">网页图片配置</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">

                    <div class="form-group">
                        <label for="icon" class="col-md-2 control-label">标题图标</label>

                        <div class="col-md-6">
                            <input id="icon" class="form-control" name="icon" value="{{ $configs['icon'] }}" readonly required>
                        </div>

                        <div class="col-md-2">
                            <div class="btn btn-default" data-name="icon">更换</div>
                            <div class="btn btn-default browse" data-url="{{ $configs['icon'] }}" >浏览</div>
                        </div>
                        <label for="logo" class="col-md-2 control-label">icon格式16*16px</label>
                    </div>

                    <div class="form-group">
                        <label for="logo" class="col-md-2 control-label">Logo</label>

                        <div class="col-md-6">
                            <input id="logo" class="form-control" name="logo" value="{{ $configs['logo'] }}" readonly required>
                        </div>

                        <div class="col-md-2">
                            <div class="btn btn-default" data-name="logo">更换</div>
                            <div class="btn btn-default browse" data-url="{{ $configs['logo'] }}" >浏览</div>
                        </div>
                        <label for="logo" class="col-md-2 control-label">建议330*120px</label>
                    </div>

                    <div class="form-group">
                        <label for="consult" class="col-md-2 control-label">咨询</label>

                        <div class="col-md-6">
                            <input id="consult" class="form-control" name="consult" value="{{ $configs['consult'] }}" readonly required>
                        </div>

                        <div class="col-md-2">
                            <div class="btn btn-default" data-name="consult">更换</div>
                            <div class="btn btn-default browse" data-url="{{ $configs['consult'] }}" >浏览</div>
                        </div>
                        <label for="consult" class="col-md-2 control-label">建议330*120px</label>
                    </div>

                    <div class="form-group">
                        <label for="wechat" class="col-md-2 control-label">微信二维码</label>

                        <div class="col-md-6">
                            <input id="consult" class="form-control" name="wechat" value="{{ $configs['wechat'] }}" readonly required>
                        </div>

                        <div class="col-md-2">
                            <div class="btn btn-default" data-name="wechat">更换</div>
                            <div class="btn btn-default browse" data-url="{{ $configs['wechat'] }}" >浏览</div>
                        </div>
                        <label for="wechat" class="col-md-2 control-label"></label>
                    </div>
                    <hr>
                    <div class="col-md-12" style="text-align: center;height: 150px">
                        <img src="" alt="" class="showpicture" style="max-height: 150px; display: none">
                    </div>
                </form>
            </div>

            <div class="panel-body">
                <form method="POST" action="{{ url('/site/savepicture') }}" id="uploadForm"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <input class="picturename" style="display: none;" name="name" type="text" value="" >
                    <input style="display: none;" name="picture" type="file" class="fileinput" />
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $("div[data-name]").click(function (){
            $('.picturename').val($(this).attr('data-name'));
            $('.fileinput').click();
        })
        $('.fileinput').change(function(){
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