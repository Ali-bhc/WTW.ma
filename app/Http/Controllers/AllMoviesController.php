<?php

namespace App\Http\Controllers;
use App\DAOs\Actors;
use App\DAOs\Genres;
use App\DAOs\Movies;
use Illuminate\Http\Request;

class AllMoviesController extends Controller
{

    public function getAllMovies($page)
    {
        $search= \request('search');
        $rating= \request('rating');
        $genre= \request('genre');
        $year= \request('year');
        $language= \request('language');
        $orderby= \request('orderby');
        $Movies = Movies::getMoviesbyFilter($page,$search ,$genre, $rating,$year,$language,$orderby);
        $years=array("2022" , "2021-2020" , "2019-2010" , "2009-2000","older");
        $conditions=array("Latest","Oldest","Highest rating","Lowest rating","Visits number","RT Audiance","revenue","Alphabitical");
        $nbr = Movies::getMoviesCount($search ,$genre, $rating,$year,$language);
        if ($nbr%28 == 0)
            $nbrpage=(int)($nbr/28);
        else
            $nbrpage=(int)(($nbr/28)+1);
        //dd($nbrpage);
        return view('AllMovies', compact(  'Movies','years' , 'conditions','nbr','nbrpage'));
    }

}
