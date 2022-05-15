<?php

namespace App\Http\Controllers;

use App\DAOs\Persons;
use Illuminate\Http\Request;

class AllPersonsController extends Controller
{
    public function getpage($page)
    {
        $search=request('search');
        $genre=request('genre');
        $age=request('age');
        $type=request('type');
        $livingstatus=request('livingstatus');
        $nationality=request('nationality');
        $ages_intervals=array("01-20","20-25" , "25-30" ,"30-40","40-60",">60");
        $Nationalities=array("American","Canadian","English","French","German","Japanese","Indian","Chinese","Other");
        $Persons = Persons::getPersonsPage($page,$genre,$search,$age,$livingstatus,$type,$nationality);
        $nbr=Persons::getPersonsCount($genre,$search,$age,$livingstatus,$type,$nationality);
        if ($nbr%28 == 0)
            $nbrpage=(int)($nbr/28);
        else
            $nbrpage=(int)(($nbr/28)+1);
        return view('AllPersons', compact(  'Persons','age','ages_intervals','Nationalities','nbr','nbrpage'));
    }

}
