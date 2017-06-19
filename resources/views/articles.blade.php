@extends('layouts.app')

@section('appbody')
    <div class="ny-banner">
        <div class="banner-pc"><img src="{{ $one_navigation->picture_url }}"></div>
        <div class="banner-mobile"><img src="{{ $one_navigation->picture_url }}"></div>
    </div>

    <div class="ny-nav" id="nding">
        <div class="centerbox ingfd clearfix">
            <div class="ny-nav-list">
                <ul>
                    @foreach($list as $item)
                    <li @if($item->id == $two_navigation->id) class="cur" @endif><a href="{{ $item->url }}">{{ $item->name }}</a></li>
                    @endforeach

                </ul>
            </div>
            <div class="ny-nav-tit"><span>您当前的位置：</span><a href="/index.shtml">HOME</a> &gt; <span>{{ $one_navigation->name }}</span> &gt; <span>{{ $two_navigation->name }}</span></div>
        </div>
    </div>

    <div style="padding: 20px 0">
        <div class="centerbox ingfd clearfix">
            {!! $two_navigation->content !!}
        </div>
    </div>

@endsection