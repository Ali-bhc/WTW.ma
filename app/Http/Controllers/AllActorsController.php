<?php

namespace App\Http\Controllers;

use App\DAOs\Actors;

class AllActorsController
{
    public function getpage($page)
    {
        $Actors = Actors::getActorsPage($page);
        return view('AllActors', compact(  'Actors'));
    }

}
