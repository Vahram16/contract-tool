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

class ContractController extends Controller
{

    public function createContract()
    {


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

        return redirect(route('createChapter'));
    }


    public function storeWordDocument(Request $request)
    {

        $subChapters = $request->except('_token');
        $mainJsonChapters = Cookie::get('mainChapters');
        $mainArrChapters = json_decode($mainJsonChapters, true);
        $docDetailsJson = $mainJsonChapters = Cookie::get('doc_details');
        $docDetailsArr = json_decode($docDetailsJson, true);
        $chapterWithSub = array_key_first($subChapters);
        $chapter = substr($chapterWithSub, 0, -2);

        if (!empty($mainArrChapters[$chapter]['chapter4_3'])) {
            $mainArrChapters[$chapter]['chapter4_3'] = $subChapters['chapter4_3'];
        };
        if (empty($mainArrChapters[$chapter]['chapter3_1']) && (!empty($subChapters['chapter4_2']))) {

            $mainArrChapters[$chapter]['chapter4_2'] = $subChapters['chapter4_2'];

        };
        $phpWord = new PHPWord();
        $phpWord->addTitleStyle(1, array('name' => 'HelveticaNeueLT Std Med', 'size' => 16, 'color' => '990000')); //h1
        $fontStyle = $phpWord->addFontStyle('rStyle', array('bold' => false, 'italic' => true, 'size' => 12));
        $sectionStyle = array(

            'colsNum' => 1,
        );
        $section = $phpWord->createSection($sectionStyle);
        $this->logo($section, $docDetailsArr);
        $phpWord->getSettings()->setUpdateFields(true);
        $this->createDocInhalt($section, $phpWord, $docDetailsArr, $mainArrChapters);
        $phpWord->getSettings()->setUpdateFields(true);
        $firstPage = $this->createDocFirstPage();
        $section->addPageBreak();
        $this->logo($section, $docDetailsArr);
        $section->addTextRun();
        $section->addTitle('Base Maintenance Attachment');
        $section->addText($firstPage, $fontStyle);
        try {
            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        } catch (Exception $e) {
        }
        Cookie::queue(Cookie::forget('mainChapters'));
        Cookie::queue(Cookie::forget('restChapters'));
        Cookie::queue(Cookie::forget('doc_details'));
        $objWriter->save('upload/template' . Auth::user()->id . '.docx');
        return response()->download('upload/template' . Auth::user()->id . '.docx')->deleteFileAfterSend(true);


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

    public function createDocInhalt($section, $phpWord, $docDetails, $mainArrChapters)
    {

        $fontStyle = array('spaceAfter' => 60, 'size' => 12,);
        $section->addText('Table of contents:');
        $section->addTextBreak(2);
        $section->addTOC($fontStyle);
        $section->addPageBreak();
        $section->addTitle('Definitions and abbreviations', 1);
        $this->createTable($phpWord, $section);
        $docChapters = config('chapters');
        foreach ($docChapters as $key => $docChapter) {
            $rChapter = str_replace('_', '.', key($docChapter));
            $subChapter = ucfirst($rChapter);
            $chapter = ucfirst($key);
            if (key_exists($key, $mainArrChapters)) {
                $section->addPageBreak();
                $this->logo($section, $docDetails);
                $section->addTitle($chapter, 1);

                foreach ($docChapter as $itemKey => $item) {
                    if (key_exists($itemKey, $mainArrChapters[$key])) {
                        $section->addTextBreak(1);
                        $section->addTitle('Sub-' . $itemKey, 2);
                        $section->addBookmark($chapter);
                        $section->addTextBreak(1);

                        $linkIsInternal = true;


                        if ($itemKey == 'chapter4_1' || $itemKey == 'chapter3_1') {

                            $section->addText('Sub-Sub' . $itemKey, ['bold' => true]);

                        } else {

                            $section->addText('Sub-Sub' . $itemKey . ' _1', ['bold' => true]);

                        };

                        if ($itemKey == 'chapter3_1') {

                            if (key_exists('chapter4', $mainArrChapters) && (key_exists('chapter4_2', $mainArrChapters['chapter4']))) {
                                unset($mainArrChapters['chapter4']['chapter4_2']);

                            }

                            $nextDay = $mainArrChapters['chapter3']['chapter3_1'] + 1;
                            $textRun = $section->addTextRun();
                            $textRun->addText("The service should not take longer than {$mainArrChapters['chapter3']['chapter3_1']} days. If it takes. $nextDay , the {$docDetails['partner']} has to tell us why. ");

                        }

                        if ($itemKey == 'chapter4_3') {
                            $section->addText("This Text is Option {$mainArrChapters['chapter4']['chapter4_3']}  ");
                        }


                        if ($itemKey == 'chapter4_1') {
                            $section->addText('YOLO!');
                        }

                        $section->addTextBreak(1);
                        if ('Sub-Sub' . $itemKey . '_1' == 'Sub-Subchapter2_1_1') {
                            $section->addText("Stuff that {$docDetails["partner"]} has to uphold. Very important. BRB.");
                        }
                        if ('Sub-Sub' . $itemKey . '_1' == 'Sub-Subchapter2_2_1') {
                            $textRun = $section->addTextRun();
                            $textRun->addText('Even more important information, see chapter');
                            $textRun->addLink("Chapter3", '3.', null, null, $linkIsInternal);
                            $textRun->addText('LOL. And some more details are in chapter 4.2.1');
                            $textRun->addLink("Chapter4", '4.2.1', null, null, $linkIsInternal);
                        }
                        if ('Sub-Sub' . $itemKey . '_1' == 'Sub-Subchapter3_2_1') {
                            $section->addText('Details regardings this chapter. IDK.');
                        }

                        if ('Sub-Sub' . $itemKey . '_1' == 'Sub-Subchapter4_1_1') {

                            $section->addtext("Stuff that {$docDetails['partner']} has to uphold. Very important. {$docDetails['kteam']} has to agree.");
                        }

                        if ('Sub-Sub' . $itemKey . '_1' == 'Sub-Subchapter4_2_1') {
                            $textRun = $section->addTextRun();
                            $textRun->addText('Even more important information, see chapter ');
                            $textRun->addLink("Chapter3", '3.', null, null, $linkIsInternal);
                            $textRun->addText("The service should not take longer than {$mainArrChapters['chapter4']['chapter4_2']} days.");
                        }
                    } else {
                        $sChapter = str_replace('_', '.', $itemKey);
                        $section->addTextBreak(1);
                        $section->addText('Sub-' . $sChapter, 2);
                        $section->addTextBreak(1);
                        $section->addText('n/a');
                    }
                }

            } else {

                $section->addPageBreak(2);
                $this->logo($section, $docDetails);
                $section->addText('Sub-' . $key, 2);
                $section->addTextBreak(2);
                $section->addText('n/a');
            }
        }
    }

    public function logo($section, $docDetails)
    {
        $textRun = $section->addTextRun(['marginTop' => 14354453245]);
        if ($docDetails['partner'] == 'Burger King') {
            $textRun->addImage('img/BurgerKing.png', [

                'width' => 115,
                'height' => 67,
                'align' => 'left',
                'posHorizontalRel' => 'margin',
                'posVerticalRel' => 'line',

            ]);
        }

        if ($docDetails['partner'] == 'Mc Donalds') {


            $textRun->addImage('img/McDonalds.png', [
                'wrapDistanceBottom' => 3333,
                'width' => 115,
                'height' => 67,
                'align' => 'left',
                'wrapDistanceLeft' => 200,
            ]);
        }
        $textRun->addtext('                                                                        ');

        $textRun->addImage('img/KTeamSolutions.jpg', [

            'width' => 115,
            'height' => 67,
            'align' => 'right',
            'wrapDistanceTop' => 200,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
        ]);
    }

    public function createTable($phpWord, $section)
    {
        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('Fancy table'));
        $styleTable = array('borderSize' => 16, 'borderColor' => '006699', 'cellMargin' => 110);
        $styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF');
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
        $table->addCell(600000)->addLink("Chapter4", "You only live once. See Chapter 4.1", null, null, $linkIsInternal);


    }


}
