<?php

namespace App\Http\Controllers\Auth;

use App\DAOs\Users;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function view;

class ProfileController extends Controller
{

    public function getprofiledata()
    {
        $user = Auth::user();
        $userdata= Users::getuserdata($user->id);
        $bookmarkedcount=Users::BookmarkedCount($user->id);
        return view('UserProfile',compact('userdata','bookmarkedcount'));
    }

    public function editprofile()
    {
        $user = Auth::user();
        $userdata= Users::getuserdata($user->id);
        return view('EditUserProfile',compact('userdata'));
    }

    public function updateProfile()
    {
        $user = Auth::user();
       // dd($user);

        // Data Validation

        $data = request()->validate([
            'name' => 'required',
            'IMG_USER' =>''
        ]);

        if (request('IMG_USER')) {
            $imagePath = request('IMG_USER');
            $filename = date('YmdHi'). 'User' . $user->id .'.'.$imagePath->getClientOriginalExtension();
            $imagePath->move(public_path('img/uploads'),$filename);
            // If user had an image delete it
            if($user->IMG_USER){
                @unlink(public_path('img/uploads/') . $user->IMG_USER);
            }
            $user['IMG_USER'] = $filename;

        }
        $update = $user->update($data);
        $user->save();

        //update in neo4j
        $userdata=Users::updateuser($user->id,$user->name,$user->IMG_USER);

        if($update)
            return redirect("/profile")->with('success','Profile Updated!');
        else
        {
            return redirect("Editprofile")->with('fail', 'Something went wrong');
        }
    }

}
