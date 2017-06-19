@extends('layouts.manage')
@section('rightcss')
    <link rel="stylesheet" href="/css/jquery.Jcrop.min.css">
    <style>
        .jcrop-style {
            display: inline-block;
        }
        .crop-image-wrapper {
            text-align: center;
        }
    </style>
@endsection

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">添加教练</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/coach/createcoach') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-1 control-label">姓名</label>

                        <div class="col-md-11">
                            <input id="name" type="text" class="form-control" name="name" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="classify" class="col-md-1 control-label">类型</label>

                        <div class="col-md-3">
                            <select name="classify" id="classify" class="form-control">
                                @if(isset($classifies))
                                    @foreach($classifies as $classify)
                                        <option @if($loop->first) selected @endif value="{{ $classify->id }}">{{ $classify->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="synopsis" class="col-md-1 control-label">简介</label>

                        <div class="col-md-9">
                            <input id="synopsis" type="text" class="form-control" name="synopsis" value="" required>
                        </div>
                        <div class="col-md-2 control-label" style="text-align: center">建议最多90字</div>
                    </div>

                    <div class="form-group">
                        <label for="descript" class="col-md-1 control-label">描述</label>
                        <div class="col-md-11">
                            <textarea class="form-control" rows="5" id="descript" name="descript" required></textarea>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descript" class="col-md-1 control-label">照片</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="rect" id="f-rect" value="" readonly>
                        </div>
                        <div class="col-md-1">
                            <a href="javascript:viod(0)" data-show="rect" class="btn btn-default" target="view_frame">查看</a>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="square" id="f-square" value="" readonly>
                        </div>
                        <div class="col-md-1">
                            <a href="javascript:viod(0)" data-show="square" class="btn btn-default" target="view_frame">查看</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-1">
                            <div class="btn btn-default z-upload" data-name="rect">上传竖型照片</div>
                            <div class="btn btn-default z-upload" data-name="square">上传正方形照片</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-1">
                            <button type="submit" class="btn btn-primary">
                                添加
                            </button>
                        </div>
                    </div>
                </form>
                <form id="uploadForm" method="post" action="{{ url('/coach/uploadpicture') }}" enctype="multipart/form-data" style="display: none">
                    <input type="hidden" class="z-name" name="name" value="">
                    <input type="file" class="z-fileInput" name="picture" style="display: none">
                </form>

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModal" id="exampleModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form id='cropForm' action="{{ url('/coach/croppicture') }}" onsubmit="checkCorrds()" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">裁剪照片</h4>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <div class="crop-image-wrapper">
                                        <img src="" class="ui centered image" id="cropBox">
                                        <input type="hidden" id="y-picture" name="picture">
                                        <input type="hidden" id="y-type" name="type">
                                        <input type="hidden" id="y-x" name="x">
                                        <input type="hidden" id="y-y" name="y">
                                        <input type="hidden" id="y-w" name="w">
                                        <input type="hidden" id="y-h" name="h">
                                    </div>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                    <button type="submit" class="btn btn-primary">剪裁照片</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('rightjs')
    <!-- 实例化编辑器 -->
    <script src="/js/jquery.Jcrop.min.js"></script>
    <script>
        $('div[data-name]').click(function () {
            $('.z-name').val($(this).attr('data-name'))
            $('.z-fileInput').click()
        })

        $('.z-fileInput').change(function(){
            if($.trim($(this).val)){
                $('#uploadForm').submit()
            }
        })
        var jcrop_api;

        $('#uploadForm').submit(function(e){
            e.preventDefault();
            var el = this;
            $.ajax({
                url: '{{ url('/coach/uploadpicture') }}',
                type: 'post',
                data:  new FormData(this),
                contentType: false,
                processData: false,
                success: function (rep) {
                    if(rep.code){
//                        $('.z-fileInput').val('')
//                        $('.crop-image-wrapper img').each(function(){
//                            $(this).attr('src', rep.path)
//                        })
                        $('#cropBox').attr('src', rep.path)
                        $('#y-picture').val(rep.path)
                        $('#y-type').val(rep.type)
                        $('#exampleModal').modal({backdrop: 'static', keyboard: false});
                        if (typeof jcrop_api != 'undefined')
                            jcrop_api.destroy();
                        if(rep.type == 'rect'){
                            $('#cropBox').Jcrop({
                                allowSelect: true,
                                keySupport: false,
                                aspectRatio: 0.77,
                                onSelect: setCoords,
                                addClass: 'jcrop-style',
                            }, function(){
                                jcrop_api = this;
                            })
                        }else{
                            $('#cropBox').Jcrop({
                                allowSelect: true,
                                keySupport: false,
                                aspectRatio: 1,
                                onSelect: setCoords,
                                addClass: 'jcrop-style',
                            }, function(){
                                jcrop_api = this;
                            })
                        }
                    }
                }
            })
        })

        $('#cropForm').submit(function (e) {
            e.preventDefault()
            var type = this.type.value
            var el = this
            $.ajax({
                url: '{{ url('/coach/croppicture') }}',
                data: $(el).serialize(),
                type: 'post',
                success: function (rep) {
                    if(rep.code){
                        $('#exampleModal').modal('hide')
                        $('#f-' + rep.type).val(rep.path)
                        $('a[data-show=' + rep.type +']').attr('href', rep.url)

                        if(rep.type == 'rect'){
                            $('div[data-name='+ rep.type +']').text('更换竖行图片').removeClass('btn-default').addClass('btn-success')
                        }else{
                            $('div[data-name='+ rep.type +']').text('更换正方形图片').removeClass('btn-default').addClass('btn-success')
                        }
                    }
                    $('.message').show()
                    $('.message').text(rep.msg)
                    setTimeout(function () {
                        $('.message').fadeOut('show',function () {
                            $('.message').text('')
                        });
                    },3000);//3秒后消失
                }
            })
        })

        function setCoords (c){
            $('#y-x').val(c.x);
            $('#y-y').val(c.y);
            $('#y-w').val(c.w);
            $('#y-h').val(c.h);
        }

        function checkCorrds (){
            if(parseInt($('#y-w').val())) return true
            alert('请选择图片')
            return false
        }

    </script>
@endsection