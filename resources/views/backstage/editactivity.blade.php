@extends('layouts.manage')

@section('right')
    @include('vendor.ueditor.assets')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">编辑活动</div>
            <div class="panel-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/activity/edit') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="edit">
                    <input type="hidden" name="id" value="{{ $activity->id }}">
                    
                    <div class="form-group">
                        <label for="title" class="col-md-1 control-label">标题</label>

                        <div class="col-md-11">
                            <input id="title" type="text" class="form-control" name="title" value="{{ $activity->title }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="creator" class="col-md-1 control-label">作者</label>

                        <div class="col-md-11">
                            <input id="creator" type="text" class="form-control" name="creator" value="{{ $activity->creator }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="describe" class="col-md-1 control-label">描述</label>

                        <div class="col-md-11">
                            <input id="describe" type="text" class="form-control" name="descript" value="{{ $activity->descript }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-1 control-label">内容</label>
                        <div class="col-md-11">
                            <script id="container" name="content" type="text/plain" style="height: 180px">{!! $activity->content !!}</script>

                            </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-1">
                                <button type="submit" class="btn btn-primary">
                                保存
                                </button>
                                <a href="{{ url('/backstage/activitylist') }}" class="btn btn-default">返回</a>
                                </div>
                                </div>
                                </form>
                                </div>
                                </div>
                                </div>
                                </div>
                                    @endsection
                                    @section('rightjs')
                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                            var ue = UE.getEditor('container');
                            ue.ready(function() {
                                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                            });
                            </script>
@endsection