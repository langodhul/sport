@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                活动列表
            </div>
            <div class="panel-body">
                @if(isset($activities))
                    <form action="" role="form" class="form-horizontal">
                        @foreach($activities as $activity)
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="title" value="{{ $activity->title }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="create" value="{{ $activity->creator }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="created_at" value="{{ $activity->created_at }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ url('/activity/edit/'.$activity->id) }}" class="btn btn-default">编辑</a>
                                    <a href="{{ url('/activity/'.$activity->id) }}" class="btn btn-default">浏览</a>
                                    <div class="btn btn-default" data-type="delete" data-id="{{ $activity->id }}">删除</div>
                                    @if($activity->is_show)
                                        <div class="btn btn-success" data-type="isshow" data-id="{{ $activity->id }}">显示中</div>
                                    @else
                                        <div class="btn btn-default" data-type="isshow" data-id="{{ $activity->id }}">隐藏中</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </form>
                    <form action="{{ url('/activity/edit') }}" method="post" style="display: none" id="hideForm">
                        {{ csrf_field() }}
                        <input type="hidden" id="f-type" name="type" value="">
                        <input type="hidden" id="f-id" name="id" value="">
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('rightjs')
    <script>
        $('div[data-id]').click(function(){
            if($(this).attr('data-type') == 'delete'){
                if(!confirm('确定要删除吗？')){
                    return false;
                }
            }
            $('#f-type').val($(this).attr('data-type'))
            $('#f-id').val($(this).attr('data-id'))
            $('#hideForm').submit()
        })
    </script>
@endsection