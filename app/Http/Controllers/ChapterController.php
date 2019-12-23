<?php

namespace App\Http\Controllers;

use App\Subchapter3_1;
use App\Subchapter4_3;
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
        $jsonChapters = Cookie::get('mainChapters');
        $mainArrChapters = json_decode($jsonChapters, true);
        if (!empty($subChapters)) {
            $chapKey = substr(array_key_first($subChapters), 0, -2);
            $mainArrChapters[$chapKey] = $subChapters;
            Cookie::queue('mainChapters', json_encode($mainArrChapters));
        }
        else{
            return back();
        }


        if (key_exists('chapter3_1', $subChapters)) {
            $serviceDays = Subchapter3_1::get();
            return view('subchapters.chapter3_1')
                ->with('serviceDays', $serviceDays);
        } elseif (key_exists('chapter4_3', $subChapters)) {

            if ((key_exists('chapter3', $mainArrChapters) && (key_exists('chapter3_1', $mainArrChapters['chapter3'])))) {
                unset($mainArrChapters['chapter4']['chapter4_2']);
                $subChaptersOptions = Subchapter4_3::get();
                return view('subchapters.chapter4_3')
                    ->with([
                        'subChapterOptions' => $subChaptersOptions
                    ]);
            } else {

                $subChaptersOptions = Subchapter4_3::get();
                $serviceDays = Subchapter3_1::get();
                return view('subchapters.chapter4_3')
                    ->with([
                        'serviceDays' => $serviceDays,
                        'subChapterOptions' => $subChaptersOptions
                    ]);
            }

        } elseif (key_exists('chapter4_2', $subChapters)) {

            if (key_exists('chapter3', $mainArrChapters) && (key_exists('chapter3_1', $mainArrChapters['chapter3']))) {
                unset($mainArrChapters['chapter4']['chapter4_2']);
                return view('subchapters.chapter4_3');
            } else {

                $serviceDays = Subchapter3_1::get();
                return view('subchapters.chapter4_3')
                    ->with([
                        'serviceDays' => $serviceDays,
                    ]);
            }
        }

        $restJsonChapters = Cookie::get('restChapters');
        $restArrChapters = json_decode($restJsonChapters, true);
        $chapter = array_key_first($restArrChapters);
        unset($restArrChapters[$chapter]);
        Cookie::queue('restChapters', json_encode($restArrChapters));
        if (empty($chapter)) {
            return view('subchapters.chapter4_3');
        }
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

        if (empty($restArrChapters)) {
            return view('subchapters.chapter4_3');
        };

        if (!empty($restJsonChapters)) {
            $restArrChapters = json_decode($restJsonChapters, true);
            $chapter = array_key_first($restArrChapters);
            unset($restArrChapters[$chapter]);
            Cookie::queue('restChapters', json_encode($restArrChapters));
            return redirect(route($chapter, $chapter));
        }


    }

}
