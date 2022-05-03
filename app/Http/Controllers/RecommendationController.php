<?php

namespace App\Http\Controllers;

use App\DAOs\Movies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index(){

//        $user = Auth::user();
//        $movies = Movies::getRecommendedMovies($user->id);


        return view('foryou');

    }
}
