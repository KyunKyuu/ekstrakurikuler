<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Eskul;
class VideoEskulController extends Controller
{
    public function video_eskul()
    {
        $eskul = Eskul::get();
        return view('main.master.eskul.video_eskul',compact('eskul'));
    }
}
