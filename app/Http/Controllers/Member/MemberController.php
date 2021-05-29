<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Eskul;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //
    public function registration()
    {
        return view('main.member.registration');
    }

    public function schedule()
    {
        $divisi  = Eskul::all();
        return view('main.member.schedule', compact('divisi'));
    }

    public function test()
    {
        $division = Eskul::all();
        return view('main.member.precentages.test', compact('division'));
    }

    public function score()
    {
        $division = Eskul::all();
        return view('main.member.precentages.score', compact('division'));
    }
}
