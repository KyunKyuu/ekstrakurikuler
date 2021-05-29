<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Eskul;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function list_article()
    {
        $category = Category::all();
        $eskul = Eskul::get();
      
        $status = [
            ['id' => 100, 'value' => 'draft'],
            ['id' => 200, 'value' => 'published'],
            ['id' => 300, 'value' => 'suspended'],
            ['id' => 400, 'value' => 'block'],
            ['id' => 500, 'value' => 'error'],
        ];
        $data = ['category' => $category, 'status' => $status, 'eskul' => $eskul];
        return view('main.article.list_article', ['data' => $data]);
    }

    public function article($id, $slug)
    {
        $blog = Blog::find($id);
        $status = [
            ['id' => 100, 'value' => 'draft'],
            ['id' => 200, 'value' => 'published'],
        ];
        $data = ['blog' => $blog, 'status' => $status];
        return view('main.article.view_article', ['data' => $data]);
    }

    public function user_guides()
    {
        return view('main.user_guides.index');
    }
}
