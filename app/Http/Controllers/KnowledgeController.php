<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Knowledges;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class KnowledgeController extends Controller
{
    public function createForm()
    {
        $this->setbackstageSessionXY('knowledge', 'createknowledge');
        return view('backstage.createknowledge');
    }

    public function show()
    {
        $this->setbackstageSessionXY('knowledge', 'knowledgelist');
        $knowledges = Knowledges::where([])->orderBy('id', 'desc')->get();

        return view('backstage.knowledgelist', compact('knowledges'));
    }

    public function create(Request $request)
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

        if(Knowledges::create($data))
        {
            return back()->with('message', '创建成功！');
        }
        return back()->with('message', '创建失败！');
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
                if(Knowledges::find($req['id'])->delete())
                {
                    Cache::forever('knowledges', $this->getKnowledge());
                    return back()->with('message', '删除成功！');
                }
                break;
            case 'isshow':
                if($isshow = knowledges::find($req['id'])->is_show)
                {
                    knowledges::find($req['id'])->update(['is_show' => 0]);
                    Cache::forever('knowledges', $this->getKnowledge());
                    return back()->with('message', '隐藏成功！');
                }else{
                    knowledges::find($req['id'])->update(['is_show' => 1]);
                    Cache::forever('knowledges', $this->getKnowledge());
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

                if(Knowledges::find($req['id'])->update($data))
                {
                    Cache::forever('knowledges', $this->getKnowledge());
                    return back()->with('message', '更新成功！');
                }
                return back()->with('message', '更新失败！');
            default:
                return back()->with('message', '更新失败！');
        }
    }

    public function editForm($id)
    {
        $knowledge = Knowledges::find($id);
        return view('backstage.editknowledge', compact('knowledge'));
    }
}
