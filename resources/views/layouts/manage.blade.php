@extends('layouts.backstage')

@section('css')
    <style>
        .z-select {
            background: rgb(245,245,245)
        }
    </style>
    @yield('rightcss')
    @endsection

@section('content')
    <div class="container">
        <div class="row" style="padding-bottom:50px">
            <div class="col-md-2 manage-left">
                <ul class="list-group">
                    <a href="{{ url('backstage/home') }}" class="list-group-item @if (session('by') == 'home') z-select @endif"><b>HOME</b></a>

                    <a href="javascript:void(0)" class="list-group-item @if (session('bx') == 'admin') z-select @endif" data-f="admin">
                        <b>后台用户管理</b>
                        <span class="glyphicon @if (session('bx') == 'admin') glyphicon-chevron-down @else glyphicon-chevron-right @endif" aria-hidden="true" data-n="admin" style="float: right;@if (session('bx') == 'admin')  color: rgb(92,184,92); @endif"></span>
                    </a>
                    <a href="{{ url('backstage/adminlist') }}" class="list-group-item @if (session('by') == 'adminlist') z-select @endif" data-c="admin">后台用户列表</a>
                    <a href="{{ url('backstage/adminform') }}" class="list-group-item @if (session('by') == 'adminform') z-select @endif" data-c="admin">创建管理员</a>

                    <a href="javascript:void(0)" class="list-group-item @if (session('bx') == 'web') z-select @endif" data-f="web">
                        <b>网站配置</b>
                        <span class="glyphicon @if (session('bx') == 'web') glyphicon-chevron-down @else glyphicon-chevron-right @endif" aria-hidden="true" data-n="web" style="float: right;@if (session('bx') == 'web')  color: rgb(92,184,92); @endif"></span>
                    </a>
                    <a href="{{ url('/backstage/siteconfig') }}" class="list-group-item @if (session('by') == 'siteconfig') z-select @endif" data-c="web">网页配置</a>
                    <a href="{{ url('/backstage/sitepicture') }}" class="list-group-item @if (session('by') == 'sitepicture') z-select @endif" data-c="web">网页图片配置</a>
                    <a href="{{ url('/backstage/sitecarousel') }}" class="list-group-item @if (session('by') == 'sitecarousel') z-select @endif" data-c="web">轮播图片配置</a>
                    <a href="{{ url('/backstage/sitenavigation') }}" class="list-group-item @if (session('by') == 'sitenavigation') z-select @endif" data-c="web">导航栏配置</a>
                    <a href="{{ url('/backstage/friendship') }}" class="list-group-item @if (session('by') == 'friendship') z-select @endif" data-c="web">友情链接</a>

                    <a href="javascript:void(0)" class="list-group-item @if (session('bx') == 'course') z-select @endif" data-f="course">
                        <b>课程管理</b>
                        <span class="glyphicon @if (session('bx') == 'course') glyphicon-chevron-down @else glyphicon-chevron-right @endif" aria-hidden="true" style="float: right;@if (session('bx') == 'course')  color: rgb(92,184,92); @endif" data-n="course"></span>
                    </a>
                    <a href="{{ url('backstage/courselist') }}" class="list-group-item @if (session('by') == 'courselist') z-select @endif" data-c="course">课程列表</a>
                    <a href="{{ url('backstage/createcourse') }}" class="list-group-item @if (session('by') == 'createcourse') z-select @endif" data-c="course">添加课程</a>

                    <a href="javascript:void(0)" class="list-group-item @if (session('bx') == 'new') z-select @endif" data-f="new">
                        <b>新闻管理</b>
                        <span class="glyphicon @if (session('bx') == 'new') glyphicon-chevron-down @else glyphicon-chevron-right @endif" aria-hidden="true" style="float: right;@if (session('bx') == 'new')  color: rgb(92,184,92); @endif" data-n="new"></span>
                    </a>
                    <a href="{{ url('backstage/newlist') }}" class="list-group-item @if (session('by') == 'newlist') z-select @endif" data-c="new">新闻列表</a>
                    <a href="{{ url('backstage/createnew') }}" class="list-group-item @if (session('by') == 'createnew') z-select @endif" data-c="new">添加新闻</a>
                    <a href="{{ url('backstage/newconfig') }}" class="list-group-item @if (session('by') == 'newconfig') z-select @endif" data-c="new">新闻配置</a>

                    <a href="javascript:void(0)" class="list-group-item @if (session('bx') == 'coach') z-select @endif" data-f="coach">
                        <b>教练管理</b>
                        <span class="glyphicon @if (session('bx') == 'coach') glyphicon-chevron-down @else glyphicon-chevron-right @endif" aria-hidden="true" style="float: right;@if (session('bx') == 'coach')  color: rgb(92,184,92); @endif" data-n="coach"></span>
                    </a>
                    <a href="{{ url('backstage/coachlist') }}" class="list-group-item @if (session('by') == 'coachlist') z-select @endif" data-c="coach">教练列表</a>
                    <a href="{{ url('backstage/createcoach') }}" class="list-group-item @if (session('by') == 'createcoach') z-select @endif" data-c="coach">添加教练</a>
                    <a href="{{ url('backstage/coachclassify') }}" class="list-group-item @if (session('by') == 'coachclassify') z-select @endif" data-c="coach">教练类型</a>
                    <a href="{{ url('backstage/coachconfig') }}" class="list-group-item @if (session('by') == 'coachconfig') z-select @endif" data-c="coach">教练分类</a>

                    <a href="javascript:void(0)" class="list-group-item @if (session('bx') == 'activity') z-select @endif" data-f="activity">
                        <b>活动管理</b>
                        <span class="glyphicon @if (session('bx') == 'activity') glyphicon-chevron-down @else glyphicon-chevron-right @endif" aria-hidden="true" style="float: right;@if (session('bx') == 'activity')  color: rgb(92,184,92); @endif" data-n="activity"></span>
                    </a>
                    <a href="{{ url('backstage/activitylist') }}" class="list-group-item @if (session('by') == 'activitylist') z-select @endif" data-c="activity">活动列表</a>
                    <a href="{{ url('backstage/createactivity') }}" class="list-group-item @if (session('by') == 'createactivity') z-select @endif" data-c="activity">创建活动</a>

                    <a href="javascript:void(0)" class="list-group-item @if (session('bx') == 'knowledge') z-select @endif" data-f="knowledge">
                        <b>知识管理</b>
                        <span class="glyphicon @if (session('bx') == 'knowledge') glyphicon-chevron-down @else glyphicon-chevron-right @endif" aria-hidden="true" style="float: right;@if (session('bx') == 'knowledge')  color: rgb(92,184,92); @endif" data-n="knowledge"></span>
                    </a>
                    <a href="{{ url('backstage/knowledgelist') }}" class="list-group-item @if (session('by') == 'knowledgelist') z-select @endif" data-c="knowledge">知识列表</a>
                    <a href="{{ url('backstage/createknowledge') }}" class="list-group-item @if (session('by') == 'createknowledge') z-select @endif" data-c="knowledge">创建知识</a>

                    <a href="{{ url('backstage/photo') }}" class="list-group-item @if (session('by') == 'photo') z-select @endif"><b>照片管理</b></a>
                    <a href="{{ url('backstage/customer') }}" class="list-group-item @if (session('by') == 'customer') z-select @endif"><b>合作客户</b></a>


                </ul>
            </div>
            <div class="col-md-10 manage-right">
                @yield('right')
            </div>
        </div>
    </div>
    <div class="navbar navbar-default navbar-fixed-bottom">
        <h4 class='message' style="text-align: center;color: #2a88bd;">
            @if(!empty(session('message')))
                {{ session('message') }}
            @endif
        </h4>
    </div>
@endsection

@section('js')
<script>

@if (session('bx') != 'admin')
    $("a[data-c='admin']").hide()
@endif

@if (session('bx') != 'web')
    $("a[data-c='web']").hide()
@endif

@if (session('bx') != 'course')
    $("a[data-c='course']").hide()
@endif

@if (session('bx') != 'new')
    $("a[data-c='new']").hide()
@endif

@if (session('bx') != 'coach')
    $("a[data-c='coach']").hide()
@endif

@if (session('bx') != 'activity')
    $("a[data-c='activity']").hide()
@endif

@if (session('bx') != 'knowledge')
    $("a[data-c='knowledge']").hide()
@endif

$('a[data-f]').click(function () {
    if($(this).find('span').hasClass('glyphicon-chevron-right')){
        $('.glyphicon-chevron-down').each(function(){
            $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right')
            var name = $(this).attr('data-n')
            $('a[data-c='+name+']').slideUp()
        })
        $(this).find('span').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down')
        var child = $(this).attr('data-f')
        $('a[data-c='+child+']').slideDown()
    }else{
        $(this).find('span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right')
        var child = $(this).attr('data-f')
        $('a[data-c='+child+']').slideUp()
    }
})


setTimeout(function () {
    $('.message').fadeOut('show');
},3000);//6秒后消失
</script>
@yield('rightjs')
@endsection