@extends('layouts.app')

@section('appbody')
    <div class="ny-banner">
        <div class="banner-pc"><img src="{{ $one_navigation->picture_url }}"></div>
        <div class="banner-mobile"><img src="{{ $one_navigation->picture_url }}"></div>
    </div>

    <div class="ny-nav">
        <div class="centerbox ingfd clearfix">
            <div class="ny-nav-list">
                <ul>
                    <li class="cur"><a href="{{ $one_navigation->url }}">{{ $one_navigation->name }}</a></li>
                </ul>
            </div>
            <div class="ny-nav-tit"><span>您当前的位置：</span><a href="/" class="black">HOME </a> > {{ $one_navigation->name }}</div>
        </div>
    </div>


    <div style="padding: 20px 0">
        <div class="centerbox ingfd clearfix">
    {!! $one_navigation->content !!}
        </div>
    </div>
    @endsection