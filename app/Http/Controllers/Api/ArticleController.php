<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CategoryBlog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    //
    public function get_article()
    {
        $article = Blog::all();
        return DataTables::of($article)
            ->editColumn('check', function ($article) {
                return ' <div class="custom-checkbox custom-control">
                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-' . $article->id . '">
                    <label for="checkbox-' . $article->id . '" class="custom-control-label">&nbsp;</label>
                </div>';
            })
            ->editColumn('title', function ($article) {
                return $article->title . '
                <div class="table-links">
                  <a href="#"><i class="fas fa-eye"></i></a>
                  <div class="bullet"></div>
                  <a href="#"><i class="fas fa-edit"></i></a>
                  <div class="bullet"></div>
                  <a href="#" class="text-danger"><i class="fas fa-trash"></i></a>
                </div>';
            })
            ->editColumn('category', function ($article) {
                $category = ' ';
                foreach ($article->categories as $value) {
                    $category .= '<a class="text-white badge badge-primary m-1">
                    ' . $value->name . '
                  </a>';
                }
                return $category;
            })
            ->editColumn('author', function ($article) {
                $user = User::find($article->user_id);
                return $user->name;
            })
            ->editColumn('created_at', function ($article) {
                return date('d-M-Y H:i', strtotime($article->created_at));
            })
            ->editColumn('status', function ($article) {
                if ($article->status == 100) {
                    $status = 'Draft';
                    $color = 'secondary';
                } else if ($article->status == 200) {
                    $status = 'Published';
                    $color = 'success';
                } else if ($article->status == 300) {
                    $status = 'Suspended';
                    $color = 'info';
                } else if ($article->status == 400) {
                    $status = 'Block';
                    $color = 'danger';
                } else if ($article->status == 500) {
                    $status = 'Error';
                    $color = 'warning';
                } else {
                    $status = 'Deleted';
                }
                return '<div class="badge badge-' . $color . '">' . $status . '</div>';
            })
            ->rawColumns(['check', 'category', 'status', 'title'])
            ->make(true);
    }

    public function insert_article(Request $request)
    {
        if ($request->title == null) {
            return response()->json(['message' => 'Error, Lengkapi form kosong terlebih dahulu!', 'status' => 'error'], 500);
        }
        if ($request->hasFile('image')) {
            $name = auth()->user()->name . '-' . date('YmdHi') . '-' . round(0, 10) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move('private_file/user/image-article/', $name);
            $request->request->add(['thumbnail' => $name]);
        }
        $request->request->add(['user_id' => auth()->user()->id, 'slug' => str_replace(" ", "-", $request->title)]);
        $blog = Article::create($request->except('image'));

        if ($request->category) {
            foreach ($request->category as $category) {
                DB::insert('insert into blog_category (blog_id, category_id) values (?, ?)', [$blog->id, $category]);
            }
        }

        return response()->json(['message' => 'Selamat, article berhasil ditambahkan!', 'status' => 'success'], 200);
    }
}
