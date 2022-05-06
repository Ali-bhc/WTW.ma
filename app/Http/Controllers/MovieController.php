<?php

namespace App\Http\Controllers;

use App\DAOs\Actors;
use App\DAOs\Directors;
use App\DAOs\Movies;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index($id){

        // increment number of visits
        Movies::incrementNbrVisits($id);

        // get movie and its actors, directors and genres
        $movie = Movies::getMovieById($id);
//        $directors = Directors::getMovieDirectors($id);
//        $actors = Actors::getMovieActors($id);
//        $genres = Movies::getMovieGenresByMovieId($id);



        // Similar Movies
//        $similarMovies = Movies::getNSimilarMovies($id, 4);

        return view('movie', compact('movie', 'id'));
    }



}
