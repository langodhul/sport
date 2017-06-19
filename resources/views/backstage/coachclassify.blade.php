@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">教练类型管理</div>
            <div class="panel-body">
                <form method="post" action="{{ url('/coach/createclassify') }}" class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name" class="control-label col-md-2">类型名称</label>
                        <div class="col-md-8">
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary" >创建</button>
                        </div>
                    </div>
                </form>
                <hr>
                @if(isset($classifies))
                <form role="form" class="form-horizontal">
                    @foreach($classifies as $classify)
                        <div class="form-group">

                        <div class="col-md-10">
                            <input type="text" id="z-name{{ $classify->id }}" class="form-control" name="name" value="{{ $classify->name }}">
                        </div>
                        <div class="col-md-2">
                            <div class="btn btn-default" data-type="edit" data-name="z-name{{ $classify->id }}" data-id="{{ $classify->id }}">修改</div>
                            <div class="btn btn-default" data-type="delete" data-name="z-name{{ $classify->id }}" data-id="{{ $classify->id }}">删除</div>
                        </div>
                    </div>
                    @endforeach
                </form>
                @endif
                <form method="post" action="{{ url('/coach/editclassify') }}" style="display: none" id="z-hideForm">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="f-id" value="">
                    <input type="hidden" name="name" id="f-name" value="">
                    <input type="hidden" name="type" id="f-type" value="">
                </form>
            </div>
        </div>
    </div>
    @endsection

@section('rightjs')
    <script>
        $('div[data-type]').click(function () {
            if($(this).attr('data-type') == 'delete'){
                if(!confirm('确定要删除吗？')){
                    return false;
                }
            }
            var type = $(this).attr('data-type')
            var nameid = '#' + $(this).attr('data-name')
            var name = $(nameid).val()

            if($.trim(name)) {
                $('#f-id').val($(this).attr('data-id'))
                $('#f-type').val($(this).attr('data-type'))

                $('#f-name').val(name)
                $('#z-hideForm').submit()
            }else{
                alert('名称不能位空！')
            }
        })
    </script>
    @endsection