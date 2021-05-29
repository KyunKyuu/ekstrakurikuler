<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Blog;
use App\Models\Eskul;
use App\Models\Category;
use App\Models\CategoryBlog;
use App\Models\Suspended;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    //
    public function get_article()
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
            if ($_GET['id'] == 'all') {
                $article = Blog::all();
            } elseif ($_GET['id'] == 'trash') {
                $article = Blog::onlyTrashed();
            } else {
                $article = Blog::all()->where('status', $_GET['id']);
            }
        } else {
            if ($_GET['id'] == 'all') {
                $article = Blog::where('user_id', auth()->user()->id);
            } else {
                $article = Blog::all()->where('status', $_GET['id'])->where('user_id', auth()->user()->id);
            }
        }
        return DataTables::of($article)
            ->editColumn('check', function ($article) {
                return ' <div class="custom-checkbox custom-control">
                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-' . $article->id . '">
                    <label for="checkbox-' . $article->id . '" class="custom-control-label">&nbsp;</label>
                </div>';
            })
            ->editColumn('title', function ($article) {
                $button = '<a href="/features/article/view/' . $article->id . '/' . $article->slug . '"><i class="fas fa-eye"></i></a>
                <div class="bullet"></div>
                <a href="#" data-id="' . $article->id . '" id="Edit" class="text-warning"><i class="fas fa-edit"></i></a>
                <div class="bullet"></div>
                <a href="#" data-id="' . $article->id . '" id="Delete" class="text-danger"><i class="fas fa-trash"></i></a>';
                if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                    $button .= '<div class="bullet"></div><a href="#" data-id="' . $article->id . '" id="Status" class="text-info"><i class="fas fa-random"></i></a>';
                }
                $data = '<div class="table-links"> ' . $button . ' </div>';
                return $article->title . $data;
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
             ->editColumn('eskul_id', function ($article) {
                return $article->eskul->name;
            })
            ->editColumn('created_at', function ($article) {
                return date('d-M-Y H:i', strtotime($article->created_at));
            })
            ->editColumn('status', function ($article) {
                if ($article->status == 100) {
                    $status = '<i class="fas fa-save"></i> Draft';
                    $color = 'secondary';
                    $added = ' ';
                } else if ($article->status == 200) {
                    $status = '<i class="fas fa-upload"></i> Published';
                    $color = 'success';
                    $added = ' ';
                } else if ($article->status == 300) {
                    $status = '<i class="fas fa-hourglass"></i> Suspended';
                    $color = 'warning';
                    $suspend = Suspended::where('blog_id', $article->id)->get()[0];
                    $added = '<div class="badge badge-secondary m-2"> <i class="fas fa-clock"></i> ' . timeMoments($suspend->suspended) . '</div>';
                } else if ($article->status == 400) {
                    $status = '<i class="fas fa-minus-circle"></i> Block';
                    $color = 'danger';
                    $added = ' ';
                } else if ($article->status == 500) {
                    $status = '<i class="fas fa-exclamation-triangle"></i> Error';
                    $color = 'warning';
                    $added = ' ';
                } else {
                    $status = 'Unknown';
                    $added = ' ';
                }
                return '<div class="badge badge-' . $color . '">' . $status . '</div> ' . $added;
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
            $imageArticle = \Storage::putFileAs('images/article', $request->file('image'), $name);
            $request->request->add(['thumbnail' => $imageArticle]);
        }

        $title = str_replace('"', '-', $request->title);
        $request->request->add(['user_id' => auth()->user()->id,'eskul_id' => $request->eskul_id, 'slug' => \Str::slug(request('title'))]);
        $blog = Article::create($request->except('image'));

        if ($request->category) {
            foreach ($request->category as $category) {
                DB::insert('insert into blog_category (blog_id, category_id) values (?, ?)', [$blog->id, $category]);
            }
        }

          activity('menambah data article');

        return response()->json(['message' => 'Selamat, article berhasil ditambahkan!', 'status' => 'success'], 200);
    }

    public function save_content(Request $request)
    {
        $article = Blog::find($request->id);
        $article->update($request->all());
        return response()->json(['message' => 'Post berhasil diperbaharui', 'status' => 'success'], 200);
    }

    public function get_first_article()
    {
        $article = Blog::find($_GET['id']);
        $category = CategoryBlog::where('blog_id', $_GET['id'])->get();
        $suspend = Suspended::where('blog_id', $_GET['id'])->get()[0] ?? 'Nothink';
        return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => ['article' => $article, 'category' => $category, 'suspend' => $suspend]], 200);
    }

    public function get_all_article()
    {
        $data = [];
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
            array_push($data, ['all' => Blog::all()->count()]);
            array_push($data, ['draft' => Blog::all()->where('status', 100)->count()]);
            array_push($data, ['published' => Blog::all()->where('status', 200)->count()]);
            array_push($data, ['suspended' => Blog::all()->where('status', 300)->count()]);
            array_push($data, ['block' => Blog::all()->where('status', 400)->count()]);
            array_push($data, ['error' => Blog::all()->where('status', 500)->count()]);
            array_push($data, ['trashed' => Blog::onlyTrashed()->count()]);
        } else {
            array_push($data, ['all' => Blog::all()->where('user_id', auth()->user()->id)->count()]);
            array_push($data, ['draft' => Blog::all()->where('status', 100)->where('user_id', auth()->user()->id)->count()]);
            array_push($data, ['published' => Blog::all()->where('status', 200)->where('user_id', auth()->user()->id)->count()]);
            array_push($data, ['suspended' => Blog::all()->where('status', 300)->where('user_id', auth()->user()->id)->count()]);
            array_push($data, ['block' => Blog::all()->where('status', 400)->where('user_id', auth()->user()->id)->count()]);
            array_push($data, ['error' => Blog::all()->where('status', 500)->where('user_id', auth()->user()->id)->count()]);
        }
        return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $data], 200);
    }

    public function category_article(Request $request)
    {
        if ($request->type == 'select') {
            CategoryBlog::create($request->only(['blog_id', 'category_id']));
            return response()->json(['message' => 'Category baru berhasil ditambahkan', 'status' => 'success'], 200);
        }
        CategoryBlog::where('blog_id', $request->blog_id)->where('category_id', $request->category_id)->delete();
        return response()->json(['message' => 'Category baru berhasil dihapus', 'status' => 'success'], 200);
    }

    public function update_article(Request $request)
    {
        if ($request->title == null) {
            return response()->json(['message' => 'Error, Lengkapi form kosong terlebih dahulu!', 'status' => 'error'], 500);
        }
        $blog = Article::find($request->id);
        if ($request->hasFile('image')) {

          \Storage::delete($blog->thumbnail); 
           $name = auth()->user()->name . '-' . date('YmdHi') . '-' . round(0, 10) . '.' . $request->file('image')->getClientOriginalExtension();
           $imageArticle = \Storage::putFileAs('images/article', $request->file('image'), $name);
           $request->request->add(['thumbnail' => $imageArticle]);
         }
        $title = str_replace('"', '-', $request->title);
        $request->request->add(['user_id' => auth()->user()->id, 'eskul_id' => $request->eskul_id,'slug' => \Str::slug(request('title'))]);
       
        $blog->update($request->except('image'));
        activity('mengubah data article');
        return response()->json(['message' => 'Selamat, article berhasil diperbaharui!', 'status' => 'success'], 200);
    }

    public function delete_article(Request $request)
    {
        $blog = Blog::find($request->id)->delete();
          activity('menghapus data article');
        return response()->json(['message' => 'Selamat, article berhasil dihapus!', 'status' => 'success'], 200);
        // $category = CategoryBlog::where('blog_id', $request->id)->delete();
    }

    public function suspended_article(Request $request)
    {
        $suspend = Suspended::where('blog_id', $request->blog_id);
        if ($suspend->count() > 0) {
            $suspend->delete();
        }
        if ($request->status > 200) {
            Suspended::create($request->all());
            $blog = Blog::find($request->blog_id);
            $blog->update($request->only('status'));
            return response()->json(['message' => 'Suspend diberikan ke blog ' . $blog->title . '!', 'status' => 'info'], 200);
        }
        $blog = Blog::find($request->blog_id);
        $blog->update($request->only('status'));
        return response()->json(['message' => 'Status blog telah diperbaharui! ', 'status' => 'info'], 200);
    }
}
