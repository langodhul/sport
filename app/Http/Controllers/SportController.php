<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site_configs;
use App\Site_navigations;
use App\Courses;
use Illuminate\Support\Facades\Cache;

class SportController extends Controller
{
    public $configs;
    public $navigations;
    public $courses;
    public $news;
    public $coaches;
    public $activities;
    public $knowledges;
    public $photos;
    public $customers;
    public $friendships;
    public $bottomlist;
    public function __construct()
    {
        $this->configs =  Cache::rememberForever('configs', function (){
            return $this->getSiteConfig();
        });

        $this->navigations =  Cache::rememberForever('navigations', function (){
            return $this->getSiteNavigation();
        });

        $this->courses =  Cache::rememberForever('courses', function (){
            return $this->getCourse();
        });

        $this->news =  Cache::rememberForever('news', function (){
            return $this->getNew();
        });

        $this->coaches =  Cache::rememberForever('coaches', function (){
            return $this->getCoach();
        });

        $this->activities =  Cache::rememberForever('activities', function (){
            return $this->getActivity();
        });

        $this->knowledges =  Cache::rememberForever('knowledges', function (){
            return $this->getKnewledge();
        });
        Cache::forever('configs', $this->getSiteConfig());
        $this->photos =  Cache::rememberForever('photos', function (){
            return $this->getPhoto();
        });

        $this->customers =  Cache::rememberForever('customers', function (){
            return $this->getCustomer();
        });

        $this->friendships =  Cache::rememberForever('friendships', function (){
            return $this->getFriendship();
        });

        $this->bottomlist = Cache::rememberForever('bottomlist', function(){
            return $this->getBottomList();
        });
    }

    public function index()
    {
        $configs = $this->configs;
        $navigations = $this->navigations;
        $courses = $this->courses;
        $news = $this->news;
        $coaches = $this->coaches;
        $firstnew = current($news);
        $knowledges = $this->knowledges;
        $activities = $this->activities;
        $photos = $this->photos;
        $customers = $this->customers;
        $friendships = $this->friendships;
        $bottomlist = $this->bottomlist;
        return view('index', compact('bottomlist', 'friendships', 'customers', 'configs', 'navigations', 'courses', 'news', 'firstnew', 'coaches', 'knowledges', 'activities', 'photos'));
    }

    public function article($one)
    {
        $navigation_url = '/article/'.$one;
        if($one_navigation = Site_navigations::where('url', $navigation_url)->first()){
            if($two_navigation = Site_navigations::where('fid', $one_navigation->id)->orderBy('priority')->first())
            {
                return redirect($two_navigation->url);
            }
            return view('article', compact('one_navigation'));
        }
        $error = 404;
        return view('error', compact('error'));
    }

    public function articles($one, $two)
    {
        $navigation_url = '/article/'.$one.'/'.$two;
        if($two_navigation = Site_navigations::where('url', $navigation_url)->first())
        {
            $one_navigation = Site_navigations::where('id', $two_navigation->fid)->first();
            $list = Site_navigations::where('fid', $two_navigation->fid)->orderBy('priority')->get();
            return view('articles', compact('one_navigation', 'two_navigation', 'list'));
        }
        $error = 404;
        return view('error', compact('error'));
    }

}
