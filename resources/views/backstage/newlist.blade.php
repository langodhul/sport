@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">新闻列表</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    @if(isset($news))
                        @foreach($news as $new)
                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="title" value="{{$new['title']}}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="time" value="{{$new['updated_at']}}">
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ url('/new/edit/'.$new['id']) }}" class="btn btn-default">编辑</a>
                                    <a href="{{ url('/new/delete/'.$new['id']) }}" onclick="if(confirm('确定删除？')==false)return false;" class="btn btn-default">删除</a>
                                    @if($new['is_show'])
                                        <a href="{{ url('/new/status/'.$new['id']) }}" class="btn btn-success">显示中</a>
                                    @else
                                        <a href="{{ url('/new/status/'.$new['id']) }}" class="btn btn-default">未显示</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection