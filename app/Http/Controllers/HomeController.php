<?php

namespace App\Http\Controllers;

use App\DAOs\Actors;
use App\DAOs\Genres;
use App\DAOs\Movies;
use App\DAOs\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {

        // banner movie data
        $bannerMovie = Movies::getRandomMovieWithCover();
        $bannerMovieGenres = Movies::getMovieGenresByMovieId($bannerMovie['id']);
//
//        // features movies data
//        $featuredMovies = Movies::getNHighestRatedMovies(14);
//
//
//        // Trending movies
//        $trendingMovies = Movies::getNMostVisitedMovies(14);
//
//        // Newest movies
//        $newestMovies = Movies::getNNewestMovies(14);
//
//        // Genres (Catégories)
//        $genres = Genres::allGenresWithNbrOfMovies();
//
//        // Actors
//        $actors = Actors::getNRandomActors(21);


        return view('home', compact('bannerMovie', 'bannerMovieGenres'));
    }



}
