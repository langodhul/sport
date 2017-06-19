<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Coach_classifies;
use Illuminate\Support\Facades\Validator;

use App\Coaches;

class CoachController extends Controller
{
    public function coachForm()
    {
        $this->setBackstageSessionXY('coach', 'createcoach');
        $classifies = Coach_classifies::all();
        return view('backstage.createcoach', compact('classifies'));
    }

    public function coachList()
    {
        $this->setBackstageSessionXY('coach', 'coachlist');
        $coaches = $this->getCoachDesc();
        return view('backstage.coachlist', compact('coaches'));
    }

    public function createCoach(Request $request)
    {
        $req = $request->all();
        $descript = htmlspecialchars(str_replace("\n", '<br>', $req['descript']));
        $data = [
            'name' => $req['name'],
            'classify_id' => $req['classify'],
            'synopsis' => $req['synopsis'],
            'descript' => $descript,
            'rect_picture' => $req['rect'],
            'square_picture' => $req['square'],
        ];
        $fail = Validator::make($data, [
            'name' => 'required',
            'classify_id' => 'required|numeric',
            'synopsis' => 'required',
            'descript' => 'required',
            'rect_picture' => 'required',
            'square_picture' => 'required',
        ])->fails();

        if ($fail)
        {
            return back()->with('message', '操作失败！');
        }

        if(Coaches::create($data))
        {
            Cache::forever('coaches', $this->getCoach());
            return back()->with('message', '创建成功！');
        }
        return back()->with('message', '操作失败');
        
    }

    public function editForm($id)
    {
        $classifies = Coach_classifies::all();
        $coaches = Cache::rememberForever('coaches', function(){
            return $this->getCoach();
        });
        foreach ($coaches as $one)
        {
           if($one->id == $id)
           {
               $coach = $one;
           }
        }
        $coach->descript = htmlspecialchars_decode($coach->descript);
        $coach->descript = str_replace('<br>', "\n", $coach->descript);
        return view('backstage.editcoach', compact('classifies', 'coach'));
    }

    public function edit(Request $request)
    {
        $req = $request->all();
        $fail = Validator::make($req, [
            'type' => 'required',
            'id' => 'required|numeric',
        ])->fails();
        if($fail)
        {
            return back()->with('message', '操作失败！');
        }

        switch ($req['type'])
        {
            case 'delete':
                if(Coaches::find($req['id'])->delete())
                {
                    Cache::forever('coaches', $this->getCoach());
                    return back()->with('message', '删除成功！');
                }
                break;
            case 'isshow':
                if($isshow = Coaches::find($req['id'])->is_show)
                {
                    Coaches::find($req['id'])->update(['is_show' => 0]);
                    Cache::forever('coaches', $this->getCoach());
                    return back()->with('message', '隐藏成功！');
                }else{
                    Coaches::find($req['id'])->update(['is_show' => 1]);
                    Cache::forever('coaches', $this->getCoach());
                    return back()->with('message', '显示成功！');
                }
                break;
            case 'edit':
                $descript = htmlspecialchars(str_replace("\n", '<br>', $req['descript']));
                $data = [
                    'name' => $req['name'],
                    'classify_id' => $req['classify'],
                    'synopsis' => $req['synopsis'],
                    'descript' => $descript,
                    'rect_picture' => $req['rect'],
                    'square_picture' => $req['square'],
                ];
                $fail = Validator::make($data, [
                    'name' => 'required',
                    'classify_id' => 'required|numeric',
                    'synopsis' => 'required',
                    'descript' => 'required',
                    'rect_picture' => 'required',
                    'square_picture' => 'required',
                ])->fails();

                if ($fail)
                {
                    return back()->with('message', '操作失败！');
                }

                if(Coaches::find($req['id'])->update($data))
                {
                    Cache::forever('coaches', $this->getCoach());
                    return back()->with('message', '更新成功！');
                }
                return back()->with('message', '更新失败！');
            default:
                return back()->with('message', '更新失败！');
        }

    }
    
    public function coachclassify()
    {
        $classifies = Coach_classifies::where([])->orderBy('id', 'desc')->get();
        session(['bx' => 'coach']);
        session(['by' => 'coachclassify']);
        return view('backstage.coachclassify', compact('classifies'));
    }

    public function createClassify(Request $request)
    {
        $req = $request->all();
        $fail = Validator::make($req ,[
            'name' => 'required|string',
        ])->fails();

        if(!$fail)
        {
            if(Coach_classifies::create(['name' => $req['name']]))
            {
                return back()->with('message', '创建成功！');
            }
        }

        return back()->with('message', '操作失败！');
    }

    public function editClassify(Request $request)
    {
        $req = $request->all();
        $fail = Validator::make($req ,[
            'id' => 'required|string',
            'type' => 'required|string',
            'name' => 'required|string',
        ])->fails();

        if(!$fail)
        {
            if($req['type'] == 'edit')
            {
                if(Coach_classifies::where('id', $req['id'])->update(['name' => $req['name']]))
                {
                    return back()->with('message', '修改成功！');
                }
            }elseif($req['type'] == 'delete'){
                if(Coach_classifies::where('id', $req['id'])->delete())
                {
                    return back()->with('message', '删除成功！');
                }
            }
        }
        return back()->with('message', '操作失败！');
    }

    public function uploadPicture(Request $request)
    {
        $req = $request->all();
        $fail = Validator::make($req ,[
            'name' => 'required|string',
            'picture' => 'required|image'
        ])->fails();

        if(!$fail)
        {
            $file = $request->file('picture');
            $dir = 'uploads/pictures/';
            $filename = time().str_random(10).$file->getClientOriginalName();
            $file->move($dir, $filename);
            Image::make($dir.$filename)->resize(550, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();


            return response()->json([
                'code' => 1,
                'path' => '/'.$dir.$filename,
                'type' => $req['name'],
            ]);
        }

        return response()->json([
            'code' => 0,
            'msg' => '操作失败！',
        ]);

    }

    public function cropPicture(Request $request)
    {
        $req = $request->all();
        $fail = Validator::make($req ,[
            'type' => 'required',
            'picture' => 'required',
            'x' => 'required',
            'y' => 'required',
            'h' => 'required',
            'w' => 'required',
        ])->fails();
        if($fail)
        {
            return response()->json([
                'code' => 0,
                'msg' => '操作失败！',
            ]);
        }
        $picture = public_path().$request->get('picture');
        $w = (int) $request->get('w');
        $h = (int) $request->get('h');
        $x = (int) $request->get('x');
        $y = (int) $request->get('y');
        Image::make($picture)->crop($w, $h, $x, $y)->resize(223, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();
        if($req['type'] == 'rect')
        {
            $msg = "竖形图片上传成功！";
        }else{
            $msg = "正方形图片上传成功！";
        }

        return response()->json([
            'code' => 1,
            'msg' => $msg,
            'path' => $req['picture'],
            'type' => $req['type'],
            'url' => url($req['picture']),
        ]);
    }


}
