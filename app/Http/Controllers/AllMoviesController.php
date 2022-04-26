<?php

namespace App\Http\Controllers;
use App\DAOs\Actors;
use App\DAOs\Genres;
use App\DAOs\Movies;
use Illuminate\Http\Request;

class AllMoviesController extends Controller
{
    public function getpage($page)
    {
        $Movies = Movies::getMoviesPage($page);
        return view('Allmovies', compact(  'Movies'));


    }

}
