<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Prestation, Eskul, VideoEskul, Article, Mentor, Alumni, Gallery, ImageGallery};


class IndexController extends Controller
{
    public function home()
    {
        $prestations = Prestation::latest()->get();
        $eskuls = Eskul::latest()->take(3)->get();
       
        $articlies = Article::where('status', '200')->latest()->take(3)->get();

        return view('index', compact('prestations', 'eskuls', 'articlies'));
    }

    public function tentang()
    {
        $eskuls = Eskul::get();
        return view('main/home/tentang', compact('eskuls'));
    }

      public function eskul()
    {
        $eskuls = Eskul::latest()->paginate(12);
        return view('main/home/eskul', compact('eskuls'));
    }
    public function eskul_detail($slug)
    {
        $eskul = Eskul::where('slug', $slug)->first();
        $VideoEskul = VideoEskul::where('eskul_id', $eskul->id)->get();
        return view('main/home/eskul_detail', compact('eskul', 'VideoEskul'));
    }

    public function gallery()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('main/home/gallery', compact('galleries'));
    }

    public function image_gallery($slug)
    {
        $gallery = Gallery::where('slug', $slug)->first();
        $imageGallery = ImageGallery::where('gallery_id', $gallery->id)->get();
        return view('main/home/gallery_image', compact('gallery', 'imageGallery'));
    }

    public function mentor()
    {

        $mentors = Mentor::latest()->paginate(12);
        return view('main/home/mentor', compact('mentors'));
    }

    public function alumni()
    {
        $alumnies = Alumni::latest()->paginate(8);
        return view('main/home/alumni', compact('alumnies'));
    }

    public function article(Request $request)
    {   


        if (!$request->eskul) {
         $articlies = Article::where('status', '200')->paginate(5);
         }else{

              if($request->eskul == 'all') {
                 $articlies = Article::where('status', '200')->paginate(5);
             }else{
                 $articlies = Article::where('status', '200')->where('eskul_id', $request->eskul)->paginate(5);
             }
           
        }
          
        $eskuls = Eskul::get();
       
        return view('main/home/article', compact('articlies','eskuls'));
    }

    public function article_detail($slug)
    {
        $article = Article::where('slug', $slug)->first();
        $articlies = Article::where('status', '200')->latest()->take(3)->get();
        return view('main/home/article_detail', compact('article', 'articlies'));
    }

    public function eLearning()
    {
        return view('main/home/eLearning');
    }
}
