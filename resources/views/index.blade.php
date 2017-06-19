@extends('layouts.app')
@section('appcss')
    <link rel="stylesheet" href="/css/video-js.min.css">
    <link rel="stylesheet" href="/css/owl.carousel.css">
    <link rel="stylesheet" href="/css/owl.theme.css">
@endsection

@section('appbody')

    @if(isset($configs['carousel']))
        <div class="banner">
            <ul>
                @foreach($configs['carousel'] as $carousel)
                    <li><a href="{{ $carousel['url'] }}" target="_blank"><img src="{{ $carousel['path'] }}" /></a></li>
                @endforeach
            </ul>
            <div class="btn_btn">
                @foreach($configs['carousel'] as $carousel)
                    @if($loop->first)
                        <span class="curus"></span>
                    @else
                        <span></span>
                    @endif
                @endforeach
            </div>

            <div class="btnxsd">
                <span class="btnleft fl">&lt;</span><span class="btnright fr">&gt;</span>
            </div>
        </div>
    @endif

    <div class="ny-title">
        <h5><i>课程中心</i></h5>
        <span>Course Center</span>
        <p>

            我们不仅教篮球，更注重孩子的性格

        </p>
    </div>
    <div class="kc-index">
        <div class="centerbox ingfd clearfix">
            @if(isset($courses))
                @foreach($courses as $course)
                    <a href="{{ $course['url'] }}">
                        <dl>
                            <dt>
                                <img src="{{ $course['picture_url'] }}" /><i></i>
                            </dt>
                            <dd>
                                <span>{{ $course['name'] }}</span> <em>{{ $course['english_name'] }}</em> <i>&nbsp;</i>
                                <p>
                                    {{ $course['describe'] }}
                                </p>
                            </dd>
                        </dl>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    @if(isset($news))
        <div class="index-news">
            <div class="centerbox ingfd clearfix">
                <div class="news-left">
                    <div class="news-title"><p>新闻中心</p><span>News Center</span><a href="/news/">更多&gt;&gt;</a></div>

                    <a href="/d0122ba6-1161-12bd-b415-9891ea5076b7/4abfbe58-4019-b80e-ff24-64719d49dbd0.shtml">
                        <dl class="news-1">
                            <dt><img src="{{ $configs['newpicture'] }}" ></dt>
                            <dd>
                                <h5 title="">{{ $firstnew['title'] }}</h5>
                                <p>{{ $firstnew['describe'] }}</p>
                                <span>发布时间：{{ $firstnew['updated_at'] }}</span>
                            </dd>
                        </dl>
                    </a>

                    <div class="news-2">
                        @foreach($news as $new)
                            @if(!$loop->first)
                                <a href="/d0122ba6-1161-12bd-b415-9891ea5076b7/fanqingquan.shtml">
                                    <dl>
                                        <dt><span>{{ $new['day'] }}</span><p>{{ $new['year_month'] }}</p></dt>
                                        <dd>
                                            <span title=" 上海李秋平篮球俱乐部反侵权公告">{{ $new['title'] }}</span>
                                            <i>{{ $new['updated_at'] }}</i>
                                            <p>{{ $new['describe'] }}</p>
                                        </dd>
                                    </dl>
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
                <div class="news-right">
                    <video
                            id="my-player"
                            class="video-js vjs-big-play-centered"
                            controls
                            poster="{{ $configs['newvideocover'] }}"
                            data-setup='{}'>
                        <source src="{{ $configs['newvideo'] }}" type="video/mp4"></source>
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="http://videojs.com/html5-video-support/" target="_blank">
                                supports HTML5 video
                            </a>
                        </p>
                    </video>
                </div>
            </div>
        </div>
    @endif
    <div class="ny-title">
        <h5><i>师资力量</i></h5>
        <span>Teacher strength</span>
        <p>

            选择我们的课程，是您取得成功的重大决定

        </p>
    </div>
    <div class="teacher">
        <div class="centerbox clearfix teacherbox owl-carousel">
            @if(isset($coaches))
                @foreach($coaches as $coach)
                    @if($coach->is_show)
                        <a href="{{ url('/coach/'.$coach->id) }}">
                            <dl>
                                <dt><img src="{{ $coach->rect_picture }}" /></dt>
                                <dd class="teach-1"><span>{{ $coach->name }}</span><p><font>{{ $coach->classify }}</font></p></dd>
                                <dd class="teach-2"><p>{{ $coach->synopsis }}</p></dd>
                                <dd class="teach-3">查看详情</dd>
                            </dl>
                        </a>
                    @endif
                @endforeach
            @endif

        </div>
    </div>

    <div class="fenge"></div>
    <div class="zhishi">
        <div class="centerbox ingfd clearfix">
            <div class="zhishi-left">
                <div class="news-title"><p><em class="cur">月度活动</em> / <em>篮球知识</em></p><a href="/news/" class="yuedumore">更多&gt;&gt;</a><a href="/news/" class="zhishimore">更多&gt;&gt;</a></div>
                <div class="zhishibox">
                    <div class="zhishi-list">

                        @if(isset($activities))
                            @foreach($activities as $activity)
                                <a href="{{ url('/activity/'.$activity['id'])}}">
                                    <dl>
                                        <dt>
                                            <b>{{ $activity['day'] }}</b><p>{{ $activity['month'] }}-</p>
                                        <dd>
                                            <b title="">{{ $activity['title'] }}</b>
                                            <i>{{ $activity['date'] }}</i>
                                            <p>{{ $activity['descript'] }}</p>
                                        </dd>
                                    </dl>
                                </a>
                            @endforeach
                        @endif

                    </div>
                    <div class="zhishi-list">
                        @if(isset($knowledges))
                            @foreach($knowledges as $knowledge)
                                <a href="{{ url('/knowledge/'.$knowledge['id']) }}">
                                    <dl>
                                        <dt>
                                            <b>{{ $knowledge['day'] }}</b><p>{{ $knowledge['month'] }}-</p>
                                        <dd>
                                            <b>{{ $knowledge['title'] }}</b>
                                            <i>{{ $knowledge['date'] }}</i>
                                            <p>{{ $knowledge['descript'] }}</p>
                                        </dd>
                                    </dl>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="zhishi-right">
                <div class="news-title"><p>学员图片</p><span>PHOTO</span><a href="/photo.shtml">更多&gt;&gt;</a></div>
                <div class="student-list">
                    <ul>
                        @if(isset($photos))
                            @foreach($photos as $photo)
                                <li><img src="{{ $photo['path'] }}" /></li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="student-i"><i class="cur"></i><i></i><i></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="kehu">
        <div class="centerbox ingfd clearfix">
            <div class="news-title"><p>合作客户</p><span>CUSTOMER</span></div>
            <div class="fenge"></div>
            <div class="kh-list">
                @if(isset($customers))
                    @foreach($customers as $customer)
                        <a href="{{ $customer->url }}" title="{{ $customer->name }}" target="_blank"><img src="{{ $customer->path }}" /></a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="address clearfix">
        <div class="centerbox ingfd clearfix">
            <div class="add-title">
                <b>联系我们</b>
                <p>
                    {{ $configs['contact_title'] }}
                </p>
            </div>
            <ul class="add-list">
                <li>
                    <a href="/contact.shtml" target="_blank"><i><img src="/images/add-1.png" /></i>
                        <p>
                            {{ $configs['address'] }}
                        </p>
                    </a>
                </li>
                <li>
                    <i><img src="/images/add-2.png" /></i>
                    <p>{{ $configs['contact_time'] }}<br />{{ $configs['contact_phone'] }}</p>
                </li>
                <li>
                    <a href="mailto:{{ $configs['email'] }}" target="_blank"><i><img src="/images/add-3.png" /></i>
                        <p>{{ $configs['email'] }}</p>
                    </a>
                </li>
                <li class="xjs2">
                    <a href="#" target="_blank"><i><img src="/images/add-4.png" /></i><span>在线咨询</span></a>
                </li>
            </ul>

        </div>
    </div>
@endsection

@section('appjs')
    <script src="/js/slider.js"></script>
    <script src="/js/video.min.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script>
        //活动知识
        $('.news-title em').mouseenter(function(){

            $(this).addClass('cur').siblings('em').removeClass('cur');
            $(this).parent().siblings("a").eq($(this).index()).show().siblings("a").hide();
            $('.zhishi-list').eq($(this).index()).show().siblings().hide();
        });

        $('.student-i i').click(function(){
            $(this).addClass('cur').siblings('i').removeClass('cur');
            $('.student-list li').eq($(this).index()).fadeIn().siblings('li').css('display','none');
        });

        //教练
        $('.teacherbox').owlCarousel({
            items: 4,
            autoPlay: true,
            navigation: true,
            navigationText: ["",""],
            scrollPerPage: true
        });

        //导航
        var qiehuan=$(".banner li");
        var btenr=$(".btn_btn span")
        var speed=4000;
        var nowindex=0;
        var length=qiehuan.length;


        qiehuan.eq(nowindex).fadeIn('slow').siblings().fadeOut('slow');

        function play(){
            nowindex++;
            if(nowindex>length-1){nowindex=0}
            qiehuan.eq(nowindex).fadeIn('slow').siblings().fadeOut('slow');
            btenr.eq(nowindex).addClass('curus').siblings().removeClass('curus');
        }

        btenr.click(function(){

            clearInterval(tme)
            nowindex=$(this).index()
            qiehuan.eq(nowindex).fadeIn('slow').siblings().fadeOut('slow');
            btenr.eq(nowindex).addClass('curus').siblings().removeClass('curus');

            tme=setInterval(play , speed)

        })
        $(".btnleft").click(function(){

            clearInterval(tme)
            nowindex=nowindex-1;
            if(nowindex<0){nowindex=length-1}
            qiehuan.eq(nowindex).fadeIn('slow').siblings().fadeOut('slow');
            btenr.eq(nowindex).addClass('curus').siblings().removeClass('curus');

            tme=setInterval(play , speed)

        })
        $(".btnright").click(function(){

            clearInterval(tme)
            nowindex++;
            if(nowindex>length-1){nowindex=0}
            qiehuan.eq(nowindex).fadeIn('slow').siblings().fadeOut('slow');
            btenr.eq(nowindex).addClass('curus').siblings().removeClass('curus');

            tme=setInterval(play , speed)

        })
        $(".banner").hover(function(){
            $(".btnxsd").fadeIn();
        },function(){
            $(".btnxsd").fadeOut();
        })

        //视频
        var player = videojs('my-player', { fluid: true }, function () {
        })
    </script>
@endsection



