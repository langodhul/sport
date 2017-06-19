<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activities;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('show');
    }

    public function createForm()
    {
        $this->setBackstageSessionXY('activity', 'createactivity');
        return view('backstage.createactivity');
    }

    public function showList()
    {
        $this->setBackstageSessionXY('activity', 'activitylist');
        $activities = Activities::where([])->orderBy('id', 'desc')->get();
        return view('backstage.activitylist', compact('activities'));
    }

    public function editForm($id)
    {
        $activity = Activities::find($id);
        return view('backstage.editactivity', compact('activity'));
    }

    public function store(Request $request)
    {
        $rep = $request->all();
        $data = [
            'title' => $rep['title'],
            'creator' => $rep['creator'],
            'descript' => $rep['descript'],
            'content' => $rep['content'],
        ];
        $fail = Validator::make($data, [
            'title' => 'required|string',
            'creator' => 'required|string',
            'descript' => 'required|string',
            'content' => 'required|string',
        ])->fails();
        if($fail)
        {
            return back()->with('message', '创建失败,请检查是否全部填写了！');
        }

        if(Activities::create($data))
        {
            Cache::forever('activities', $this->getActivity());
            return back()->with('message', '创建成功！');
        }
        return back()->with('message', '创建失败！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
                if(Activities::find($req['id'])->delete())
                {
                    Cache::forever('activities', $this->getActivity());
                    return back()->with('message', '删除成功！');
                }
                break;
            case 'isshow':
                if($isshow = Activities::find($req['id'])->is_show)
                {
                    Activities::find($req['id'])->update(['is_show' => 0]);
                    Cache::forever('activities', $this->getActivity());
                    return back()->with('message', '隐藏成功！');
                }else{
                    Activities::find($req['id'])->update(['is_show' => 1]);
                    Cache::forever('activities', $this->getActivity());
                    return back()->with('message', '显示成功！');
                }
                break;
            case 'edit':
                $data = [
                    'title' => $req['title'],
                    'creator' => $req['creator'],
                    'descript' => $req['descript'],
                    'content' => $req['content'],
                ];
                $fail = Validator::make($data, [
                    'title' => 'required|string',
                    'creator' => 'required|string',
                    'descript' => 'required|string',
                    'content' => 'required|string',
                ])->fails();

                if ($fail)
                {
                    return back()->with('message', '操作失败！');
                }

                if(Activities::find($req['id'])->update($data))
                {
                    Cache::forever('activities', $this->getActivity());
                    return back()->with('message', '更新成功！');
                }
                return back()->with('message', '更新失败！');
            default:
                return back()->with('message', '更新失败！');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
