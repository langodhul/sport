@extends('layouts.manage')

@section('right')
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">网页配置</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/site/saveconfig') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-2 control-label">标题</label>

                        <div class="col-md-10">
                            <input id="title" type="title" class="form-control" name="title" value="{{ $configs['title'] }}" required>

                            @if ($errors->has('title'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
                        <label for="keywords" class="col-md-2 control-label">关键词</label>

                        <div class="col-md-10">
                            <input id="keywords" type="text" class="form-control" name="keywords" value="{{ $configs['keywords'] }}" required>

                            @if ($errors->has('keywords'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('keywords') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-2 control-label">描述</label>

                        <div class="col-md-10">
                            <input id="description" type="text" class="form-control" name="description" value="{{ $configs['description'] }}" required>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="welcome" class="col-md-2 control-label">欢迎语</label>

                        <div class="col-md-10">
                            <input id="welcome" type="text" class="form-control" name="welcome" value="{{ $configs['welcome'] }}" required>

                            @if ($errors->has('welcome'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('welcome') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="weibo" class="col-md-2 control-label">微博地址</label>

                        <div class="col-md-10">
                            <input id="weibo" type="text" class="form-control" name="weibo" value="{{ $configs['weibo'] }}" required>

                            @if ($errors->has('weibo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('weibo') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="copyright" class="col-md-2 control-label">网站版权</label>

                        <div class="col-md-10">
                            <input id="copyright" type="text" class="form-control" name="copyright" value="{{ $configs['copyright'] }}" required>

                            @if ($errors->has('copyright'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('copyright') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-md-2 control-label">地址</label>

                        <div class="col-md-10">
                            <input id="address" type="text" class="form-control" name="address" value="{{ $configs['address'] }}" required>

                            @if ($errors->has('address'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-2 control-label">邮箱</label>

                        <div class="col-md-10">
                            <input id="email" type="text" class="form-control" name="email" value="{{ $configs['email'] }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contactTitle" class="col-md-2 control-label">联系标题</label>

                        <div class="col-md-10">
                            <input id="contactTitle" type="text" class="form-control" name="contact_title" value="{{ $configs['contact_title'] }}" required>

                            @if ($errors->has('contact_title'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('contact_title') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contactTime" class="col-md-2 control-label">联系时段</label>

                        <div class="col-md-4">
                            <input id="contactTime" type="text" class="form-control" name="contact_time" value="{{ $configs['contact_time'] }}" required>
                        </div>

                        <label for="contactPhone" class="col-md-2 control-label">联系热线</label>

                        <div class="col-md-4">
                            <input id="contactPhone" type="text" class="form-control" name="contact_phone" value="{{ $configs['contact_phone'] }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">
                                保存
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection