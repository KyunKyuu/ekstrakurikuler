<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Eskul};
class MemberController extends Controller
{
    public function member()
    {
        $users = User::where('email_verified_at','!=',null)->get();
        $divisions = Eskul::get();
       
        return view('main.master.profiles.member', compact('users','divisions'));
    }
}
