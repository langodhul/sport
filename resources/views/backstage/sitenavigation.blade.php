@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">导航栏配置</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="f-name" class="col-md-1 control-label">名称</label>
                        <div class="col-md-2">
                            <input class="form-control" id="f-name" name="name" type="text" required>
                        </div>
                        <label class="col-md-1 control-label" for="f-url">链接</label>
                        <div class="col-md-3">
                            <input class="form-control" id='f-url' name="url" type="text" required>
                        </div>
                        <label class="col-md-1 control-label" for="f-npriority">优先级</label>
                        <div class="col-md-1">
                            <input class="form-control" id="f-priority" name="priority" type="text" value="9" style="text-align: center" required>
                        </div>
                        <div class="col-md-2" >
                            <div class="btn btn-default" data-z="navigation" data-name="z-name" data-type="create" data-url="z-url" data-priority="z-priority" data-id="f">选图并添加一级导航</div>
                        </div>
                        <label class="col-md-1 control-label">1600*400</label>
                    </div>
                </form>
                <hr>
                <form class="form-horizontal" role="form">
                    @if(isset($navigations))
                        @foreach($navigations as $navigation)
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input class="form-control" name=picture" type="text" value="{{ $navigation['picture_url'] }}" readonly required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" id="z-name{{ $navigation['id'] }}" name="name" type="text" value="{{ $navigation['name'] }}" readonly required>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" id='z-url{{ $navigation['id'] }}' name="url" type="text" value="{{ $navigation['url'] }}" readonly required>
                                </div>
                                <div class="col-md-1">
                                    <input class="form-control" id='z-priority{{ $navigation['id'] }}' name="priority" type="text" value="{{ $navigation['priority'] }}" readonly required>
                                </div>
                                <div class="col-md-4" >
                                    <a href="{{ url('/backstage/editnavigation/'.$navigation['id']) }}" class="btn btn-default">编辑</a>
                                    <div class="btn btn-default" data-z="navigation" data-type="delete" data-name='z-name{{ $navigation['id'] }}' data-url="z-url{{ $navigation['id'] }}" data-priority="z-priority{{ $navigation['id'] }}" data-id="{{ $navigation['id'] }}">删除</div>
                                    <div class="btn btn-default z-createchildnavigation" data-toggle="modal" data-target="#addChildModal" data-type="create" data-id="{{ $navigation['id'] }}">添加二级导航</div>
                                @if(isset($navigation['child']))
                                        <div class="btn btn-default z-childToggle" data-type="hide" data-id="{{ $navigation['id'] }}">收起</div>
                                    @endif
                                </div>
                            </div>
                            @if(isset($navigation['child']))
                                @foreach($navigation['child'] as $child)
                                    <div class="form-group child{{ $navigation['id'] }} y-child{{ $child['id'] }}">
                                        <div class="col-md-2 col-md-offset-3">
                                            <input class="form-control" id="z-name{{ $child['id'] }}" name="name" type="text" value="{{ $child['name'] }}" readonly required>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" id='z-url{{ $child['id'] }}' name="url" type="text" value="{{ $child['url'] }}" readonly required>
                                        </div>
                                        <div class="col-md-1">
                                            <input class="form-control" id='z-priority{{ $child['id'] }}' name="priority" type="text" value="{{ $child['priority'] }}" readonly required>
                                        </div>
                                        <div class="col-md-4" >
                                            <a href="{{ url('/backstage/editnavigation/'.$child['id']) }}" class="btn btn-default">编辑</a>
                                            <div class="btn btn-default" data-z="navigation" data-name="z-name{{ $child['id'] }}" data-type="delete" data-url="z-url{{ $child['id'] }}" data-priority="z-priority{{ $navigation['id'] }}" data-id="{{ $child['id'] }}">删除</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </form>
                <form method="POST" action="{{ url('/site/savenavigation') }}" id="hideForm"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <input class="h-id" style="display: none;" name="id" type="text">
                    <input class="h-type" style="display: none;" name="type" type="text">
                    <input class="h-name" style="display: none;" name="name" type="text">
                    <input class="h-url" style="display: none;" name="url" type="text">
                    <input class="h-priority" style="display: none;" name="priority" type="text">
                    <input style="display: none;" name="picture" type="file" class="fileInput" />
                </form>
                <div class="modal fade" id="addChildModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">添加二级导航</h4>
                            </div>
                            <div class="modal-body">
                                <form id="childForm" method="post" action="{{ url('/site/savenavigation') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="c-name" class="control-label">名称</label>
                                        <input type="text" class="form-control" id="c-name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="c-url" class="control-label">链接</label>
                                        <input type="text" class="form-control" id="c-url" name="url">
                                    </div>
                                    <div class="form-group">
                                        <label for="c-priority" class="control-label">优先级</label>
                                        <input type="text" class="form-control" id="c-priority" name="priority" value="9" style="text-align: center">
                                    </div>
                                    <input type="hidden" id="c-id" name="id">
                                    <input type="hidden" id="c-type" name="type">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary subChildForm" >创建</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $("div[data-z]").click(function (){
            if($(this).attr('data-type') == 'delete'){
                if(!confirm('确定要删除吗？')){
                    return false;
                }
            }
            var nameid = '#' + $(this).attr('data-name')
            var urlid = '#' + $(this).attr('data-url')
            var priorityid = '#' + $(this).attr('data-priority')
            if($.trim($(nameid).val()) && $.trim($(urlid).val()) && $.trim($(priorityid).val())){
                var type =$(this).attr('data-type')
                $('.h-id').val($(this).attr('data-id'))
                $('.h-type').val($(this).attr('data-type'))
                $('.h-name').val($(nameid).val())
                $('.h-url').val($(urlid).val())
                $('.h-priority').val($(priorityid).val())
                if(type == 'create' || type == 'updatepicture'){
                    $('.fileInput').click()
                }else{
                    $("#hideForm").submit()
                }
            }else {
                alert('检测到有字段为空！')
            }
        })

        $('.fileInput').change(function(){
            if ($.trim($(this).val())) {
                $("#hideForm").submit()
            }
        });


        $('.z-createchildnavigation').click(function () {
            $('#childForm #c-id').val($(this).attr('data-id'))
            $('#childForm #c-type').val($(this).attr('data-type'))
        })

        $('.subChildForm').click(function(){
            if($.trim($('#childForm #c-name').val()) && $.trim($('#childForm #c-url').val()) && $.trim($('#childForm #c-priority').val())){
                $('#childForm').submit()
            }else{
                alert('名称和链接栏不能为空！')
            }
        })

        $('.z-childToggle').click(function(){
            var childdiv = '.child' + $(this).attr('data-id')
            if($(this).attr('data-type') == 'hide'){
                $(childdiv).hide()
                $(this).text('展开')
                $(this).attr('data-type','show')
            }else{
                $(childdiv).show()
                $(this).text('收起')
                $(this).attr('data-type','hide')
            }
        })

    </script>
@endsection