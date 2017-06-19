<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Courses;
use Illuminate\Support\Facades\Cache;

class CourseController extends Controller
{

    public function courseForm()
    {
        session(['bx'=> 'course']);
        session(['by'=> 'createcourse']);
        return view('backstage.createcourse');
    }

    public function courseList()
    {
        session(['bx'=> 'course']);
        session(['by'=> 'courselist']);
        $courses = Cache::rememberForever('courses', function(){
            return $this->getCourse();
        });
        return view('backstage.coureslist', compact('courses'));
    }

    public function savePicture(Request $request)
    {
        $path = '/uploads/'.$request->file('picture')->store('pictures', 'uploads');
        if($path)
        {
            return response()->json([
                'code' => 1,
                'msg' => '图片上传成功',
                'path' => $path,
            ]);
        }

        return response()->json([
            'code' => 0,
            'msg' => '图片上传失败',
            'path' => '',
        ]);
    }

    public function createCourse(Request $request)
    {
        $req = $request;
        if(Courses::create(['name' => $req['name'], 'english_name' => $req['english'], 'url' => $req['url'], 'describe' => $req['describe'], 'picture_url' =>$req['picture']])){
            Cache::forever('courses', $this->getCourse());

            return redirect('/backstage/courselist')->with('message', '创建成功！');
        }

        return redirect('/backstage/courselist')->with('message', '创建失败！');

    }

    public function editCourse(Request $request)
    {
        $req = $request->all();
        if($req['type'] == 'create')
        {
            $path = '/uploads/'.$request->file('picture')->store('pictures', 'uploads');
            if(Courses::create(['name' => $req['name'], 'english_name' => $req['english'], 'url' => $req['url'], 'describe' => $req['describe'], 'picture_url' =>$path]))
            {
                Cache::forever('courses', $this->getCourse());
                return back()->with('message', '创建成功！');
            }
        }elseif($req['type'] == 'save'){
            if(Courses::where('id', $req['id'])->update(['name' => $req['name'], 'english_name' => $req['english'], 'url' => $req['url'], 'describe' => $req['describe']]))
            {
                Cache::forever('courses', $this->getCourse());
                return back()->with('message', '更新成功！');
            }
        }elseif($req['type'] == 'delete'){
            if(Courses::find($req['id'])->delete())
            {
                Cache::forever('courses', $this->getCourse());
                return back()->with('message', '删除成功！');
            }
        }elseif ($req['type'] == 'show'){
            if(Courses::find($req['id'])->update(['is_show' => 1]))
            {
                Cache::forever('courses', $this->getCourse());

                return back()->with('message', '已开启展示！');
            }
        }elseif ($req['type'] == 'hide'){
            if(Courses::find($req['id'])->update(['is_show' => 0]))
            {
                Cache::forever('courses', $this->getCourse());

                return back()->with('message', '已关闭展示！');
            }
        }else{
            $path = '/uploads/'.$request->file('picture')->store('pictures', 'uploads');
            if(Courses::where('id', $req['id'])->update(['name' => $req['name'], 'english_name' => $req['english'], 'url' => $req['url'], 'describe' => $req['describe'], 'picture_url' => $path]))
            {
                Cache::forever('courses', $this->getCourse());
                return back()->with('message', '更新成功！');
            }
        }

        return back()->with('message', '操作失败！');
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
}
