@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">轮播图配置</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-1 control-label" style="vertical-align: middle">链接</div>
                        <div class="col-md-7">
                            <input class="form-control" id="z-carouselUrl" name="carouselurl" type="text" value="" required>
                        </div>
                        <div class="col-md-2" >
                            <div class="btn btn-default" data-name="carousel" data-type="create" data-url="z-carouselUrl" data-id="1">选图并添加</div>
                        </div>
                        <div class="col-md-2 control-label" style="vertical-align: middle;font-weight: bold">建议1600*500px</div>

                    </div>
                </form>
                <div class="col-md-12"><br></div>
                <form class="form-horizontal" role="form">
                    @if(isset($configs['carousel']))
                        @foreach($configs['carousel'] as $carousel)
                            <div class="form-group">
                                <div class="col-md-1 control-label" style="vertical-align: middle">图片</div>
                                <div class="col-md-3">
                                    <input class="form-control" name="carouselpath" type="text" value="{{ $carousel['path'] }}" readonly required>
                                </div>
                                <div class="col-md-1 control-label" style="vertical-align: middle">链接</div>
                                <div class="col-md-3">
                                    <input class="form-control" id="z-carouselUrl{{ $carousel['id'] }}" name="carouselurl" type="text" value="{{ $carousel['url'] }}" required>
                                </div>
                                <div class="col-md-4" >
                                    <div class="btn btn-default z-saveUrl"  data-url="z-carouselUrl{{ $carousel['id'] }}" data-id="{{ $carousel['id'] }}">保存链接</div>
                                    <div class="btn btn-default" data-name="carousel" data-type="update" data-url="z-carouselUrl{{ $carousel['id'] }}" data-id="{{ $carousel['id'] }}">选图并保存</div>
                                    <div class="btn btn-default z-deleteCarousel" data-id="{{ $carousel['id'] }}">删除</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </form>
                <form method="POST" action="{{ url('/site/savecarouserl') }}" id="carouselForm"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <input class="carouselId" style="display: none;" name="id" type="text" value="" >
                    <input class="carouselType" style="display: none;" name="type" type="text" value="" >
                    <input class="carouselName" style="display: none;" name="name" type="text" value="" >
                    <input class="carouselUrl" style="display: none;" name="value2" type="text" value="" >
                    <input style="display: none;" name="picture" type="file" class="fileInput" />
                </form>
            </div>
        </div>
    </div>
@endsection
@section('rightjs')
    <script>
        $("div[data-name]").click(function (){
            if($(this).attr('data-type') == 'delete'){
                if(!confirm('确定要删除吗？')){
                    return false;
                }
            }
            var classname = '#' + $(this).attr('data-url');
            if($.trim($(classname).val())){
                $('.carouselId').val($(this).attr('data-id'));
                $('.carouselType').val($(this).attr('data-type'));
                $('.carouselName').val($(this).attr('data-name'));
                $('.carouselUrl').val($(classname).val());
                $('.fileInput').click();
            }else {
                alert('链接栏不能为空！')
            }
        })

        $('.fileInput').change(function(){
            if ($.trim($(this).val())) {
                $("#carouselForm").trigger('submit')
            }
        });

        $('.z-saveUrl').click(function(){
            var classname = '#' + $(this).attr('data-url')
            if($.trim($(classname).val())){
                var id = $(this).attr('data-id')
                var url = $(classname).val()
                $.ajax({
                    url: '{{ url('/site/savecarouselurl') }}',
                    type: 'post',
                    data: {
                        id: id,
                        url: url,
                    },
                    success: function(rep){
                        if(rep.code){
                            $('.message').show()
                            $('.message').text(rep.msg)
                            setTimeout(function () {
                                $('.message').fadeOut('show',function () {
                                    $('.message').text('')
                                });
                            },3000);//3秒后消失
                        }
                    }
                })
            }else {
                alert('链接栏不能为空！')
            }
        })

        $('.z-deleteCarousel').click(function(){
            var id = $(this).attr('data-id')
            var url = '{{ url('/site/deletecarousel') }}' + '/' +id;
            $.ajax({
                url: url,
                type: 'post',
                success: function(rep){
                    if(rep.code){
                        window.location.href = '{{ url('/backstage/sitecarousel') }}'
                    }
                }
            })
        })
    </script>
@endsection