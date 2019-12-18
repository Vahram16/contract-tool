<?php

namespace App\Http\Controllers;

use App\ContractPartner;
use App\ContractType;
use App\KTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Cookie;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{

    public function createContract()
    {
// Add Titles
//        $section->addPageBreak();
//        $section->addTitle('I am Title 1', 1);
//        $section->addText('Some text...');
//        $section->addTextBreak(2);
//        $section->addTitle('I am a Subtitle of Title 1', 2);
//        $section->addTextBreak(2);
//        $section->addText('Some more text...');
//        $section->addTextBreak(2);
//        $section->addTitle('Another Title (Title 2)', 1);
//        $section->addText('Some text...');
//        $section->addPageBreak();
//        $section->addTitle('I am Title 3', 1);
//        $section->addText('And more text...');
//        $section->addTextBreak(2);
//        $section->addTitle('I am a Subtitle of Title 3', 2);
//        $section->addText('Again and again, more text...');


        $contractTypes = ContractType::select('type')
            ->get();
        $KTeams = KTeam::select('solution')
            ->get();
        $contractPartners = ContractPartner::select('name')
            ->get();

        return view('contracts.index')->with([
            'contractTypes' => $contractTypes,
            'KTeams' => $KTeams,
            'contractPartners' => $contractPartners,

        ]);

    }

    public function storeMainContract(Request $request)
    {

        $docDetails = [
            'kteam' => $request->kteam,
            'partner' => $request->partner
        ];
        Cookie::queue('doc_details', json_encode($docDetails));


//        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
//        $objWriter->save('upload/template' . Auth::user()->id . '.docx');
        return redirect(route('createChapter'));

    }

    public function storeWordDocument(Request $request)
    {
        $phpWord = new PHPWord();
        $phpWord->addTitleStyle(1, array('name' => 'HelveticaNeueLT Std Med', 'size' => 16, 'color' => '990000')); //h1


        $subChapters = $request->except('_token');
        $mainJsonChapters = Cookie::get('mainChapters');
        $mainArrChapters = json_decode($mainJsonChapters, true);
        $chapterWithSub = array_key_first($subChapters);
        $chapter = substr($chapterWithSub, 0, -2);
        $mainArrChapters[$chapter]['chapter4_3'] = $subChapters['chapter4_3'];
        Cookie::queue('mainChapters', json_encode($mainArrChapters));
        $sectionStyle = array(

            'marginTop' => 600,
            'colsNum' => 1,
        );
        $section = $phpWord->createSection($sectionStyle);
        $this->logo($section);
        $phpWord->getSettings()->setUpdateFields(true);
        $this->createDocInhalt($section, $phpWord);

        $firstPage = $this->createDocFirstPage();
        $section->addPageBreak();
        $this->logo($section);
        $section->addTextRun('Base Maintenance Attachment');

        $section->addText($firstPage);


        try {
            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        } catch (Exception $e) {
        }
        $objWriter->save('upload/template' . Auth::user()->id . '.docx');
//         response()->download('upload/template' . Auth::user()->id . '.docx');


    }


    public function createDocFirstPage()
    {

        $docDetailsJson = Cookie::get('doc_details');
        $docDetailsArr = json_decode($docDetailsJson, true);
        $partnerCountry = $docDetailsArr['partner'] == 'Mc Donalds' ? 'Spain' : 'France';
        $partnerStreet = $docDetailsArr['partner'] == 'Mc Donalds' ? 'Spanish Street' : 'French Street';
        $partnerPlace = $docDetailsArr['partner'] == 'Mc Donalds' ? 'Spanish Town' : 'French City';
        $KTeamCountry = $docDetailsArr['kteam'] == 'K Team Solutions Switzerland' ? 'Switzerland' : 'Germany';
        $KTeamStreet = $docDetailsArr['kteam'] == 'K Team Solutions Switzerland' ? 'Swiss Street' : 'German Street';
        $KTeamPlace = $docDetailsArr['kteam'] == 'K Team Solutions Switzerland' ? 'Swiss Town' : 'German Town';


        $text = ('K Team Solutions, a corporation established under the laws of ' . $docDetailsArr['kteam'] . ' having its registered office at ' . $KTeamStreet . ',' . $KTeamPlace . ',' . $KTeamCountry . '(“K TEAM”); and
' . $docDetailsArr['partner'] . ', a company incorporated under the laws of ' . $partnerCountry . ', having its registered office at ' . $partnerStreet . ', ' . $partnerPlace . ', ' . $partnerCountry . ' hereinafter referred to as “Contract Partner”)
as initially signed on XX-XXX-20XX and as amended from time to time, and specifies the provisions for the particular services defined herein.
The terms and conditions of the service shall fully apply to this contract save as not stipulated differently herein.
In case of contradiction between the terms and conditions of this contract and those of the main contract, the former shall prevail.
');
        return $text;


    }

    public function createDocInhalt($section, $phpWord)
    {


// Define the TOC font style
        $fontStyle = array('spaceAfter' => 60, 'size' => 12);
// Adddd

        $section->addText('Table of contents:');
        $section->addTextBreak(2);
// Add TOC
        $section->addTOC($fontStyle);
        $section->addPageBreak();
        $section->addTitle('Definitions and abbreviations', 1);
        $this->createTable($phpWord, $section);

        $mainChaptersJson = Cookie::get('mainChapters');
        $mainChaptersArr = json_decode($mainChaptersJson, true);

        $docChapters = config('chapters');
        foreach ($docChapters as $key => $docChapter) {

            $rChapter = str_replace('_', '.', key($docChapter));
            $subChapter = ucfirst($rChapter);
            $chapter = ucfirst($key);


            if (key_exists($key, $mainChaptersArr)) {
                $section->addPageBreak();
                $this->logo($section);
                $section->addTitle($chapter, 1);
                $section->addText('Some text...');

                foreach ($docChapter as $itemKey => $item) {

                    if (key_exists($itemKey, $mainChaptersArr[$key])) {

                        $section->addTextBreak(2);
                        $section->addTitle('Sub-' . $itemKey, 2);
                        $section->addBookmark($chapter);
//                        $section->addField();
                        $section->addTextBreak(2);
                        $section->addText('Sub-Sub' . $itemKey . ' 1');
                        $section->addTextBreak(2);
                        $section->addText('Some more text...');

                    } else {
                        $sChapter = str_replace('_', '.', $itemKey);
                        $section->addTextBreak(2);
                        $section->addText('Sub-' . $sChapter, 2);
                        $section->addTextBreak(2);
                        $section->addText('n/a');
                    }

                }


            } else {

                $section->addPageBreak(2);
                $this->logo($section);
                $section->addText('Sub-' . $key, 2);
                $section->addTextBreak(2);
                $section->addText('n/a');

            }


        }


    }

    public function logo($section)
    {
        $section->addImage('KTeamSolutions.jpg', [

            'width' => 150,
            'height' => 50,
            'top' => 1110,
            'align' => 'right',
            'wrapDistanceRight' => 200

        ]);


    }

    public function createTable($phpWord, $section)
    {

//
//        $linkIsInternal = true;
//
//        $section->addLink('chapter2', 'Take me to Chapter 2', null, null, $linkIsInternal);
//
//        $section->addPageBreak();
//
//        $section->addTitle('This is page 2', 1);
//        $section->addBookmark('MyBookmark');
//        $section->addText('aaDadADa');


        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('Fancy table'));
        $styleTable = array('borderSize' => 16, 'borderColor' => '006699', 'cellMargin' => 110);
        $styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $styleCell = array('valign' => 'center');
        $styleCellBTLR = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fontStyle = array('bold' => true, 'align' => 'center');
        $phpWord->addTableStyle('Fancy Table', $styleTable, $styleFirstRow);
        $table = $section->addTable('Fancy Table');

        $table->addRow();
        $table->addCell(600000)->addText(htmlspecialchars("BRB"));
        $table->addCell(600000)->addText(htmlspecialchars("Be right back"));
        $table->addRow();
        $table->addCell(600000)->addText(htmlspecialchars("LOL"));
        $table->addCell(600000)->addText(htmlspecialchars("Laugh out loud"));
        $table->addRow();
        $table->addCell(600000)->addText(htmlspecialchars("IDN"));
        $table->addCell(600000)->addText(htmlspecialchars("I don’t know"));
        $table->addRow();
        $table->addCell(600000)->addText(htmlspecialchars("YOLO"));

        $linkIsInternal = true;
        $section->addLink("Chapter4", 'chapter2 take', null, null, $linkIsInternal);
        $table->addCell(600000)->addText(htmlspecialchars("YOLO"));
        $table->addCell(600000)->addText(htmlspecialchars("xxxxxxxx"));


    }


}
