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

}
