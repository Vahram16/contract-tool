<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ChapterController extends Controller
{
    public function createChapter()
    {

        return view('contracts.chapter');

    }

    public function storeChapter(Request $request)
    {

        $chapters = $request->except('_token');
        if (empty($chapters)) {
            return back();
        }
        Cookie::queue('mainChapters', json_encode($chapters));
        $chapter = array_key_first($chapters);
        unset($chapters[$chapter]);
        Cookie::queue('restChapters', json_encode($chapters));
        return redirect(route($chapter, $chapter));

    }

    public function storeSubchapter(Request $request)
    {

        $subChapters = $request->except('_token');
        if (!empty($subChapters)) {
            $jsonChapters = Cookie::get('mainChapters');
            $mainArrChapters = json_decode($jsonChapters, true);
            $chapKey = substr(array_key_first($subChapters), 0, -2);
            $mainArrChapters[$chapKey] = $subChapters;
            Cookie::queue('mainChapters', json_encode($mainArrChapters));
        }

        if (key_exists('chapter3_1', $subChapters)) {


            return view('subchapters.chapter3_1');
        }
//        elseif ()


        $restJsonChapters = Cookie::get('restChapters');
        $restArrChapters = json_decode($restJsonChapters, true);
        $chapter = array_key_first($restArrChapters);
        unset($restArrChapters[$chapter]);
        Cookie::queue('restChapters', json_encode($restArrChapters));
        return redirect(route($chapter, $chapter));

    }

    public function createChapter2Sub(Request $request)
    {
        $chapter = array_key_first($request->except('_token'));
        $chapter = substr_replace($chapter, ' ', -1, 0);
        return view('subchapters.chapter2')
            ->with(['chapter' => $chapter]);

    }

    public function createChapter3Sub(Request $request)
    {
        return view('subchapters.chapter3');

    }

    public function createChapter4Sub(Request $request)
    {
        return view('subchapters.chapter4');

    }

    public function storeSubVariable(Request $request)
    {
        $subChapter = $request->except('_token');
        $chapterWithSub = array_key_first($subChapter);
        $chapter = substr($chapterWithSub, 0, -2);
        $mainJsonChapters = Cookie::get('mainChapters');
        $mainArrChapters = json_decode($mainJsonChapters, true);
        $mainArrChapters[$chapter][$chapterWithSub] = $subChapter[$chapterWithSub];
        Cookie::queue('mainChapters', json_encode($mainArrChapters));

        $restJsonChapters = Cookie::get('restChapters');

        $restArrChapters = json_decode($restJsonChapters, true);
        $chapter = array_key_first($restArrChapters);
        unset($restArrChapters[$chapter]);
        Cookie::queue('restChapters', json_encode($restArrChapters));
        return redirect(route($chapter, $chapter));


    }

}
