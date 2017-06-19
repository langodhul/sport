<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ cache('configs')['title'] }}</title>
    <meta name="keywords" content="{{ cache('configs')['keywords'] }}">
    <meta name="description" content="{{ cache('configs')['description'] }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ cache('configs')['icon'] }}">

    <link rel="stylesheet" href="/css/public.css">
    <link rel="stylesheet" href="/css/style.css">
    @yield('appcss')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="header clearfix">
    <div class="index-top">
        <div class="centerbox ingfd clearfix">
            <div class="yindao">{{ cache('configs')['welcome'] }}
            </div>
            <div class="top-link"><a target="_blank" href="{{ cache('configs')['weibo'] }}" class="top-link1">新浪微博</a><span> | </span><a href="/#" class="top-link2">微信公众号 <em><img src="{{ cache('configs')['wechat'] }}" /></em></a><span> | </span><a href="/message.shtml" class="top-link3">在线留言</a><a href="/#" class="top-link4">English</a>
            </div>
        </div>
    </div>
    <div class="centerbox ingfd clearfix">
        <div class="logo"><a href="/"><img src="{{ cache('configs')['logo'] }}" alt="" />
            </a></div>
        <div class="tell-top"><img src="{{ cache('configs')['consult'] }}" alt="" />
        </div>
    </div>

    <div class="nav">
        <div class="centerbox ingfd clearfix">
            <ul>
                <li><a href="/">首页</a>
            @if(cache('navigations'))
                    @foreach(cache('navigations') as $navigation)
                <li><a href="{{ $navigation['url'] }}">{{ $navigation['name'] }}</a>
                    @if(isset($navigation['child']))
                    <div>
                        @foreach($navigation['child'] as $child)
                        <a href="{{ $child['url'] }}">{{ $child['name'] }}</a>
                        @endforeach
                    </div>
                    @endif
                    </li>
                    @endforeach
                    @endif
            </ul>
        </div>
    </div>
</div>

@yield('appbody')

<div class="fotbottom">
    <div class="links">
        <div class="centerbox ingfd clearfix"><div class="news-title"><p>友情链接</p><span>Link</span><a href="/contact.shtml">交换链接</a></div></div><div class="fenge"></div>
        <div class="centerbox ingfd clearfix">
            <div class="links-list">

                @if(cache('friendships'))
                    @foreach(cache('friendships') as $friendship)
                        <a href="{{ $friendship['url'] }}" target="_blank">{{ $friendship['name'] }}</a>
                    @endforeach
                @endif

            </div>
        </div>
        <div class="fenge"></div>
        <div class="centerbox ingfd clearfix">
            <div class="bottom-nav">
                <div class="bottom-navny">
                    @if(cache('bottomlist'))
                        @foreach(cache('bottomlist') as $navigation)
                            @if($loop->index < 7)
                    <dl>
                        <dt><a href="{{ $navigation['url'] }}" target="_blank">{{ $navigation['name'] }}</a></dt>
                        <dd>
                            @foreach($navigation['child'] as $child)
                            <a href="{{ $child['url'] }}">{{ $child['name'] }}</a>
                            @endforeach
                        </dd>
                    </dl>
                        @endif
                        @endforeach
                        @endif

                </div>
            </div>
            <div class="ewm">
                <p>
                    使用微信扫一扫<br />
                    获取更多惊喜
                </p>
                <img src="{{ cache('configs')['wechat'] }}" />

            </div>
        </div>
    </div>
    <div class="dibu">
        <div class="centerbox ingfd clearfix"><p>{{ cache('configs')['copyright'] }}</p></div>
    </div>
</div>

<div id="jump" style="display: block;12">
    <ul>
        <li>
            <a id="top" href="#top"></a>
        </li>
        <li>
            <a id="sina" href="{{ cache('configs')['weibo'] }}" target="_blank"></a>
        </li>
        <li>
            <a id="weixin" href="javascript:void(0)" onmouseover="showEWM()" onmouseout="hideEWM()">
                <div id="EWM">
                    <img src="{{ cache('configs')['wechat'] }}" />
                </div>
            </a>
        </li>
        <li>
            <a id="reply" href="/message.shtml" target="_blank"></a>
        </li>
    </ul>
</div>


<script src="/js/jquery-3.2.1.min.js"></script>

@yield('appjs')
<script>
    tme=setInterval(play , speed)

    if($(window).width()<600){
        $('#jump').hide();
    }
    else{

        $(window).scroll(function() {
            if ($(window).scrollTop() > 500) {
                $('#jump').fadeIn();
            } else {
                $('#jump').fadeOut();
            }
        });
    }

    $("#top").click(function() {
        $('body,html').animate({
                scrollTop: 0
            },
            500);
        return false;
    });
    $("#weixin").mouseenter(function(){
        $("#EWM").fadeIn();
    })
    $("#weixin").mouseleave(function(){
        $("#EWM").hide();
    })

</script>
</body>
</html>
