<?php

namespace App\Http\Controllers;

use App\ContractPartner;
use App\ContractType;
use App\KTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $partnerCountry = $request->partner == 'Mc Donalds' ? 'Spain' : 'France';
        $partnerStreet = $request->partner == 'Mc Donalds' ? 'Spanish Street' : 'French Street';
        $partnerPlace = $request->partner == 'Mc Donalds' ? 'Spanish Town' : 'French City';

        $KTeamCountry = $request->kteam == 'K Team Solutions Switzerland' ? 'Switzerland' : 'Germany';
        $KTeamStreet = $request->kteam == 'K Team Solutions Switzerland' ? 'Swiss Street' : 'German Street';
        $KTeamPlace = $request->kteam == 'K Team Solutions Switzerland' ? 'Swiss Town' : 'German Town';


        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addTitle('Base Maintenance Attachment');
        $section->addText('K Team Solutions, a corporation established under the laws of ' . $request->kteam . ' having its registered office at ' . $KTeamStreet . ',' . $KTeamPlace . ',' . $KTeamCountry . '(“K TEAM”); and
' . $request->partner . ', a company incorporated under the laws of ' . $partnerCountry . ', having its registered office at ' . $partnerStreet . ', ' . $partnerPlace . ', ' . $partnerCountry . ' hereinafter referred to as “Contract Partner”)
as initially signed on XX-XXX-20XX and as amended from time to time, and specifies the provisions for the particular services defined herein.
The terms and conditions of the service shall fully apply to this contract save as not stipulated differently herein.
In case of contradiction between the terms and conditions of this contract and those of the main contract, the former shall prevail.
');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('upload/template' . Auth::user()->id . '.docx');
        return redirect(route('createChapter'));

    }

    public function storeWordDocument()
    {

        $j =  Cookie::get('mainChapters');
        $a = json_decode($j,true);



    }


}
