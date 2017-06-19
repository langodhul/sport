@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                知识列表
            </div>
            <div class="panel-body">
                @if(isset($knowledges))
                    <form action="" role="form" class="form-horizontal">
                        @foreach($knowledges as $knowledge)
                            <div class="form-group">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="title" value="{{ $knowledge->title }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="create" value="{{ $knowledge->creator }}" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="created_at" value="{{ $knowledge->created_at }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ url('/knowledge/edit/'.$knowledge->id) }}" class="btn btn-default">编辑</a>
                                    <a href="{{ url('/knowledge/'.$knowledge->id) }}" class="btn btn-default">浏览</a>
                                    <div class="btn btn-default" data-type="delete" data-id="{{ $knowledge->id }}">删除</div>
                                    @if($knowledge->is_show)
                                        <div class="btn btn-success" data-type="isshow" data-id="{{ $knowledge->id }}">显示中</div>
                                    @else
                                        <div class="btn btn-default" data-type="isshow" data-id="{{ $knowledge->id }}">隐藏中</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </form>
                    <form action="{{ url('/knowledge/edit') }}" method="post" style="display: none" id="hideForm">
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