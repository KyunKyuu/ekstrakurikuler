<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Eskul;

class EskulController extends Controller
{
     public function eskul()
    {
        return view('main.master.eskul.eskul');
    }
}
