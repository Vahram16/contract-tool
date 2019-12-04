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
        Cookie::queue('mainChapters', json_encode($chapters));
        Cookie::queue('subchapters', json_encode($chapters));
        $chapter = array_key_first($chapters);
        $jsonChapters = Cookie::get('subchapters');
        $arrChapters = json_decode($jsonChapters, true);
        unset($arrChapters[$chapter]);
        Cookie::queue('subchapters', json_encode($arrChapters));
        return redirect(route($chapter, $chapter));


    }

    public function storeSubchapter(Request $request)
    {

        $subChapters = $request->except('_token');
        $jsonChapters = Cookie::get('mainChapters');
        $mainArrChapters = json_decode($jsonChapters, true);
        $chapKey = substr(array_key_first($subChapters), 0, -2);
        $arrChapters[$chapKey] = $subChapters;
        $jsonChapters = Cookie::get('subchapters');
        $arrChapters = json_decode($jsonChapters, true);
        $chapter = array_key_first($arrChapters);
       echo $chapter;
        unset($arrChapters[$chapKey]);
        Cookie::queue('mainChapters', json_encode($mainArrChapters));
        Cookie::queue('subchapters', json_encode($arrChapters));

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
        $chapter = array_key_first($request->except('_token'));
        $chapter = substr_replace($chapter, ' ', -1, 0);
        return view('subchapters.chapter2')
            ->with(['chapter' => $chapter]);

    }

}
