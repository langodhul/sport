@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                照片管理
            </div>
            <div class="panel-body">
                <form method="post" id="uploadForm" action="{{ url('/backstage/photo') }}" enctype="multipart/form-data" role="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-title">标题</label>
                        <div class="col-md-6">
                            <input type="text" id="f-title" class="form-control" name="title" required>
                        </div>
                        <label class="control-label col-md-1" for="f-creator">作者</label>
                        <div class="col-md-2">
                            <input type="text" id="f-creator" class="form-control" name="creator" value="{{ Auth::guard('admin')->user()['username'] }}" required>
                        </div>
                        <label class="control-label col-md-1" for="f-priority">优先级</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control" id="f-priority" name="priority" value="9" style="text-align: center" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-1" for="f-descript">描述</label>
                        <div class="col-md-9">
                            <input type="text" id="f-descript" class="form-control" name="descript" required>
                        </div>
                        <input type="file" name="photo" id="f-photo" style="display: none">
                        <div class="col-md-2">
                            <div class="btn btn-default addPhoto">
                                选图并添加
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                @if(isset($photos))
                <form role="form" class="form-horizontal">
                    @foreach($photos as $photo)
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="y-title" name="title" value="{{ $photo->title }}" readonly>
                            </div>
                            <div class="col-md-1">
                                <input type="text" class="form-control" id="y-priority" name="priority" value="{{ $photo->priority }}" style="text-align: center" readonly>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="y-updated_at" name="updated_at" value="{{ $photo->updated_at }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/backstage/photo/edit/'.$photo->id) }}" class="btn btn-default">编辑</a>
                                <a href="{{ url($photo->path) }}" target="view_window" class="btn btn-default">浏览</a>
                                <div class="btn btn-default b-delete" data-type="delete" data-id="{{ $photo->id }}">删除</div>
                                @if($photo->is_show)
                                    <div class="btn btn-success b-hide" data-type="isshow" data-id="{{ $photo->id }}">显示中</div>
                                @else
                                    <div class="btn btn-default b-show" data-type="isshow" data-id="{{ $photo->id }}">隐藏中</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </form>
                @endif
                <form action="{{ url('/backstage/photo/edit') }}" method="post" style="display: none" id="hideForm">
                    {{ csrf_field() }}
                    <input type="hidden" id="h-type" name="type">
                    <input type="hidden" id="h-id" name="id">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $('.addPhoto').click(function(){
            if($.trim($('#f-title').val()) && $.trim($('#f-descript').val())){
                $('#f-photo').click()
            }else{
                alert('标题或描述不能为空')
            }
        })

        $('#f-photo').change(function(){
            $('#uploadForm').submit()
        })

        $('div[data-type]').click(function(){
            $('#h-type').val($(this).attr('data-type'))
            $('#h-id').val($(this).attr('data-id'))
            $('#hideForm').submit()
        })

    </script>
@endsection