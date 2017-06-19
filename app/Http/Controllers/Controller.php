<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use App\Site_configs;
use App\Site_navigations;
use App\Courses;
use App\News;
use App\Activities;
use App\Knowledges;
use App\Photos;
use App\Customers;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function setBackstageSessionXY($x, $y)
    {
        session(['bx' => $x]);
        session(['by' => $y]);
    }

    protected function getSiteConfig()
    {
        $configs = [];
        $num = 0;
        foreach (Site_configs::all() as $config)
        {
            if($config->name == 'carousel')
            {
                $configs[$config->name][$num]['id'] = $config->id;
                $configs[$config->name][$num]['path'] = $config->value;
                $configs[$config->name][$num]['url'] = $config->value2;
                $num ++;
            }else{
                $configs[$config->name] = $config->value;
            }
        }

        return $configs;
    }

    protected function getSiteNavigation(){
        $navigations = [];
        foreach (Site_navigations::where('fid', 0)->orderBy('priority')->get() as $navigation)
        {
            $navigations[$navigation->id]['id'] = $navigation->id;
            $navigations[$navigation->id]['name'] = $navigation->name;
            $navigations[$navigation->id]['url'] = $navigation->url;
            $navigations[$navigation->id]['picture_url'] = $navigation->picture_url;
            $navigations[$navigation->id]['priority'] = $navigation->priority;
            $navigations[$navigation->id]['content'] = $navigation->content;
            if(Site_navigations::where('fid', $navigation->id)->count())
            {
                foreach(Site_navigations::where('fid', $navigation->id)->orderBy('priority')->get() as $child)
                {
                    $navigations[$navigation->id]['child'][$child->id]['id'] = $child->id;
                    $navigations[$navigation->id]['child'][$child->id]['name'] = $child->name;
                    $navigations[$navigation->id]['child'][$child->id]['url'] = $child->url;
                    $navigations[$navigation->id]['child'][$child->id]['priority'] = $child->priority;
                    $navigations[$navigation->id]['child'][$child->id]['content'] = $child->content;

                }
            }
        }

        return $navigations;
    }

    protected function getBottomList()
    {
        $bottomlist = [];
        foreach (Site_navigations::where('fid', 0)->get() as $navigation)
        {
            if(Site_navigations::where('fid', $navigation->id)->count())
            {
                $bottomlist[$navigation->id]['id'] = $navigation->id;
                $bottomlist[$navigation->id]['picture_url'] = $navigation->picture_url;
                $bottomlist[$navigation->id]['name'] = $navigation->name;
                $bottomlist[$navigation->id]['url'] = $navigation->url;
                foreach(Site_navigations::where('fid', $navigation->id)->get() as $child)
                {
                    $bottomlist[$navigation->id]['child'][$child->id]['id'] = $child->id;
                    $bottomlist[$navigation->id]['child'][$child->id]['name'] = $child->name;
                    $bottomlist[$navigation->id]['child'][$child->id]['url'] = $child->url;

                }
            }
        }

        return $bottomlist;
    }

    protected function getCourse()
    {
        $courses = [];
        foreach (Courses::all() as $course)
        {
            $courses[$course->id]['id'] = $course->id;
            $courses[$course->id]['name'] = $course->name;
            $courses[$course->id]['english_name'] = $course->english_name;
            $courses[$course->id]['url'] = $course->url;
            $courses[$course->id]['picture_url'] = $course->picture_url;
            $courses[$course->id]['describe'] = $course->describe;
            if (mb_strlen($course->describe) > 33)
            {
                $courses[$course->id]['index_describe'] = mb_substr($course->describe,'0','33').'...';
            }else{
                $courses[$course->id]['index_describe'] = $course->describe;
            }
            $courses[$course->id]['is_show'] = $course->is_show;
        }

        return $courses;
    }

    protected function getNew()
    {
        $news = [];
        foreach (News::where('is_show', '1')->orderBy('updated_at', 'desc')->get() as $new)
        {
            $news[$new->id]['id'] = $new->id;
            $news[$new->id]['title'] = $new->title;
            $news[$new->id]['creator'] = $new->creator;
            $news[$new->id]['content'] = $new->content;
            $news[$new->id]['is_show'] = $new->is_show;
            $news[$new->id]['describe'] = $new->describe;
            $news[$new->id]['updated_at'] = $new->updated_at;
            $news[$new->id]['year_month'] = mb_substr($new->updated_at, 0, 7);
            $news[$new->id]['day'] = mb_substr($new->updated_at, 8, 2);
        }
        return $news;
    }

    protected function getCoach()
    {
        $coachse = DB::select('select a.id,a.name,b.id as classify_id,b.name as classify,synopsis,descript,rect_picture,square_picture,is_show,created_at from coaches as a inner join coach_classifies as b on a.classify_id = b.id');

        return $coachse;
    }

    protected function getCoachDesc()
    {
        $coachse = DB::select('select a.id,a.name,b.id as classify_id,b.name as classify,synopsis,descript,rect_picture,square_picture,is_show,created_at from coaches as a inner join coach_classifies as b on a.classify_id = b.id order by a.id desc');

        return $coachse;
    }

    protected function getActivity()
    {
        $activities = [];
        foreach (Activities::where('is_show', 1)->orderBy('id', 'desc')->take(3)->get() as $activity)
        {
            $activities[$activity->id]['id'] = $activity->id;
            $activities[$activity->id]['title'] = $activity->title;
            $activities[$activity->id]['creator'] = $activity->creator;
            $activities[$activity->id]['content'] = $activity->content;
            $activities[$activity->id]['is_show'] = $activity->is_show;
            $activities[$activity->id]['descript'] = $activity->descript;
            $activities[$activity->id]['updated_at'] = $activity->updated_at;
            $activities[$activity->id]['month'] = mb_substr($activity->updated_at, 5, 2);
            $activities[$activity->id]['day'] = mb_substr($activity->updated_at, 8, 2);
            $activities[$activity->id]['date'] = mb_substr($activity->updated_at, 0, 10);
        }

        return $activities;
    }

    protected function getKnowledge()
    {
        $knowledges = [];
        foreach (Knowledges::where('is_show', 1)->orderBy('id', 'desc')->take(3)->get() as $knowledge)
        {
            $knowledges[$knowledge->id]['id'] = $knowledge->id;
            $knowledges[$knowledge->id]['title'] = $knowledge->title;
            $knowledges[$knowledge->id]['creator'] = $knowledge->creator;
            $knowledges[$knowledge->id]['content'] = $knowledge->content;
            $knowledges[$knowledge->id]['is_show'] = $knowledge->is_show;
            $knowledges[$knowledge->id]['descript'] = $knowledge->descript;
            $knowledges[$knowledge->id]['updated_at'] = $knowledge->updated_at;
            $knowledges[$knowledge->id]['month'] = mb_substr($knowledge->updated_at, 5, 2);
            $knowledges[$knowledge->id]['day'] = mb_substr($knowledge->updated_at, 8, 2);
            $knowledges[$knowledge->id]['date'] = mb_substr($knowledge->updated_at, 0, 10);
        }

        return $knowledges;
    }

    protected function getPhoto()
    {
        $photos = [];
        foreach (Photos::where('is_show', 1)->orderBy('priority')->take(3)->get() as $photo)
        {
            $photos[$photo->id]['path'] = $photo->path;
        }
        return $photos;
    }

    protected function getCustomer()
    {
        return Customers::where('is_show', 1)->orderBy('priority')->get();
    }

    protected function getFriendship()
    {
        $friendships = [];
        foreach (Site_configs::where('name', 'friendship')->orderBy('value3', 'desc')->get() as $friendship)
        {
            $friendships[$friendship->id]['name'] = $friendship->value;
            $friendships[$friendship->id]['url'] = $friendship->value2;
        }
        return $friendships;
    }

    protected function about($err)
    {
        $error = $err;
        return view('error');
    }
}
