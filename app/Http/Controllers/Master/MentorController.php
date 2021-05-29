<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Eskul;

class MentorController extends Controller
{
    public function mentor()
    {
        $eskul = Eskul::get();
        return view('main.master.profiles.mentor', compact('eskul'));
    }
}
