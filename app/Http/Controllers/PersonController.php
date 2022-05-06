<?php

namespace App\Http\Controllers;

use App\DAOs\Actors;
use App\DAOs\Persons;
use Illuminate\Http\Request;

class PersonController extends Controller
{

    public function index($id){

        // person
        $person = Persons::getPersonById($id);



        return view('person', compact('person', 'id'));
    }
}
