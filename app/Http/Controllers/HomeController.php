<?php

namespace App\Http\Controllers;

use App\DAOs\Movies;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // banner movie data
        $bannerMovie = Movies::getRandomMovieWithCover();
        $bannerMovieGenres = Movies::getMovieGenresByMovieId($bannerMovie['id']);

        // features movies data
        $featuredMovies = Movies::getNHighestRatedMovies(14);

        return view('home', compact('bannerMovie', 'bannerMovieGenres', 'featuredMovies'));
    }
}
