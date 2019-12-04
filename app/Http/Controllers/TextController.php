<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
class TextController extends Controller
{
    public function index()
    {




        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $lineStyle = array('weight' => 1, 'width' => 100, 'height' => 0, 'color' => 635552);

        $section->addText('dasDASDFASFSAF SAASF ASF ASF ASAFSSAF');
        $section->addPageBreak();
        $section->addText('Page cvbxcvbnxcv dfshdfh dhd fhdfhdhh dsfhdsfh dfhdsf hdhf dfh sdfhdfh dshf dfh dfsh2');
        $templateProcessor = new TemplateProcessor('template1.docx');
//$templateProcessor->setValue('name','VVVVVV');
//$templateProcessor->saveAs('template1.docx');
//        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
//        $objWriter->save('template1.docx');






    }
    public function test3(){



        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $lineStyle = array('weight' => 1, 'width' => 100, 'height' => 0, 'color' => 635552);

        $section->addText('${name}',$lineStyle);
        $section->addPageBreak();
        $section->addText('Page cvbxcvbnxcv dfshdfh dhd fhdfhdhh dsfhdsfh dfhdsf hdhf dfh sdfhdfh dshf dfh dfsh2');
        $templateProcessor = new TemplateProcessor('template1.docx');
//        $templateProcessor->setValue('name','VVVVVV');
//        $templateProcessor->saveAs('template1.docx');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('template1.docx');




    }

}

