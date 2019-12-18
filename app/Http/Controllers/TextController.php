<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\TOC;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Shared;
use PhpOffice\PhpWord\SimpleType\DocProtect;
class TextController extends Controller
{
    public function index()
    {


        $phpWord = new PhpWord();


    }

    public function test3()
    {
        $phpWord = new PhpWord();




        $section = $phpWord->createSection();



       $a =  $section->addTable();
       $a->countColumns();

        $phpWord->getSettings()->setUpdateFields(true);

        $section = $phpWord->addSection();





        $section->addTOC();
        $section->addTitle('Chapter1');

        $section->addTextBreak();
        $section->addText('Subchapter1.1');
        $section->addPageBreak();
        $section->addText('Some Text');




//
        $section->addTitle('This is page 1', 1);

        $linkIsInternal = true;

        $section->addLink('karapet', 'chapter2 take', null, null, $linkIsInternal);

//        $section->addPageBreak();

//        $section->addTitle('This is page 2', 1);
        $section->addBookmark('karapet');
//        $section->addBookmark('MyBookmark');

        $section->addPageBreak();

        $section->addTitle('This is page 3', 1);





//        $sectionStyle = $section->getStyle();
//// half inch left margin
//        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5));
//// 2 cm right margin
//        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
//        $header = $section->createHeader();

//        $section->addTOC();
//        $section->addTitle('Chapter1');
//        $section->addTextBreak();
//        $section->addText('Subchapter1.1');
//        $section->addPageBreak();
//        $section->addText('Some Text');
//        $footer = $section->createFooter();
//        $section->addBookmark('MyBookmark');
//$section->addLink('MyBookmark',htmlspecialchars('Take me to the first page', ENT_COMPAT, 'UTF-8'), null, null, true);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('upload/template11.docx');
    }

}

