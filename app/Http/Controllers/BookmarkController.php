<?php

namespace App\Http\Controllers;

use App\DAOs\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{

    public function bookmarked(){

        return view('bookmarked');
    }

    public function bookmark($movieId){

        $user = Auth::user();

        if(!$user) // if user not connected redirect to login
        {
            return redirect()->route('login');
        }


        Users::bookmark($user->id, $movieId);
        return redirect()->back();
    }

    public function UnBookmark($movieId){

        $user = Auth::user();
        Users::unBookmark($user->id, $movieId);

        return redirect()->back();
    }
}
