@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">课程配置</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-md-1 control-label" for="z-coursename">名称</label>
                        <div class="col-md-3">
                            <input class="form-control" id="z-coursename" name="name" type="text" value="" required>
                        </div>
                        <label class="col-md-1 control-label" for="z-courseenglish">英文名</label>
                        <div class="col-md-3">
                            <input class="form-control" id='z-courseenglish' name="english" type="text" value="" required>
                        </div>
                        <label class="col-md-1 control-label" for="z-courseurl">链接</label>
                        <div class="col-md-3">
                            <input class="form-control" id='z-courseurl' name="url" type="text" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-1 control-label" for="z-coursedescribe">描述</label>
                        <div class="col-md-7">
                            <input class="form-control" id='z-coursedescribe' name="describe" type="text" value="" required>
                        </div>
                        <div class="col-md-2" >
                            <div class="btn btn-default" data-z="course" data-type="create" data-name="z-coursename"  data-english="z-courseenglish" data-url="z-courseurl" data-describe="z-coursedescribe" data-id="f">选图并添加课程</div>
                        </div>
                        <div class="col-md-2 control-label" style="vertical-align: middle;font-weight: bold">建议244*166px</div>
                    </div>
                </form>
                <div class="col-md-12"><br></div>
                <form class="form-horizontal" role="form">
                    @if(isset($courses))
                        @foreach($courses as $course)
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input class="form-control" id="y-coursename{{ $course['id'] }}" name="name" type="text" value="{{ $course['name'] }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" id='y-courseenglish{{ $course['id'] }}' name="english" type="text" value="{{ $course['english_name'] }}">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" id='y-courseurl{{ $course['id'] }}' name="url" type="text" value="{{ $course['url'] }}">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" id='y-coursepicture{{ $course['id'] }}' name="picture" type="text" value="{{ $course['picture_url'] }}" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-7">
                                    <input class="form-control" id='y-coursedescribe{{ $course['id'] }}' name="describe" type="text" value="{{ $course['describe'] }}">
                                </div>
                                <div class="col-md-5" >
                                    <div class="btn btn-default" data-z="course" data-type="save" data-name="y-coursename{{ $course['id'] }}"  data-english="y-courseenglish{{ $course['id'] }}" data-url="y-courseurl{{ $course['id'] }}" data-describe="y-coursedescribe{{ $course['id'] }}" data-id="{{ $course['id'] }}">修改</div>
                                    <div class="btn btn-default" data-z="course" data-type="update" data-name="y-coursename{{ $course['id'] }}"  data-english="y-courseenglish{{ $course['id'] }}" data-url="y-courseurl{{ $course['id'] }}" data-describe="y-coursedescribe{{ $course['id'] }}" data-id="{{ $course['id'] }}">修改图片</div>
                                    <div class="btn btn-default" data-z="course" data-type="delete" data-name="y-coursename{{ $course['id'] }}"  data-english="y-courseenglish{{ $course['id'] }}" data-url="y-courseurl{{ $course['id'] }}" data-describe="y-coursedescribe{{ $course['id'] }}" data-id="{{ $course['id'] }}">删除</div>
                                    <div class="btn @if($course['is_show'])btn-success @else btn-default @endif z-show" data-z="course" data-type="@if($course['is_show']) hide @else show @endif" data-name="y-coursename{{ $course['id'] }}"  data-english="y-courseenglish{{ $course['id'] }}" data-url="y-courseurl{{ $course['id'] }}" data-describe="y-coursedescribe{{ $course['id'] }}" data-id="{{ $course['id'] }}">首页展示</div>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>

                        @endforeach
                    @endif
                </form>

                <form method="POST" action="{{ url('/course/createcourse') }}" id="courseForm"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <input class="courseId" style="display: none;" name="id" type="text" value="" >
                    <input class="courseType" style="display: none;" name="type" type="text" value="" >
                    <input class="courseName" style="display: none;" name="name" type="text" value="" >
                    <input class="courseEnglish" style="display: none;" name="english" type="text" value="" >
                    <input class="courseUrl" style="display: none;" name="url" type="text" value="" >
                    <input class="courseDescribe" style="display: none;" name="describe" type="text" value="" >
                    <input style="display: none;" name="picture" type="file" class="fileInput" />
                </form>

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
            if($.trim($(nameid).val())){
                var type = $.trim($(this).attr('data-type'))
                var englishid = '#' + $(this).attr('data-english')
                var urlid = '#' + $(this).attr('data-url')
                var describeid = '#' + $(this).attr('data-describe')

                $('.courseId').val($(this).attr('data-id'))
                $('.courseType').val(type)
                $('.courseName').val($(nameid).val())
                $('.courseEnglish').val($(englishid).val())
                $('.courseUrl').val($(urlid).val())
                $('.courseDescribe').val($(describeid).val())
                if(type == 'create' || type == 'update'){
                    $('.fileInput').click()
                }else{
                    $("#courseForm").trigger('submit')
                }
            }else {
                alert('名称栏不能为空！')
            }
        })

        $('.fileInput').change(function(){
            if ($.trim($(this).val())) {
                $("#courseForm").trigger('submit')
            }
        })


    </script>
@endsection