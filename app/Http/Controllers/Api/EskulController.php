<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Eskul, VideoEskul};
use App\Http\Requests\EskulRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\EskulExport;
use Maatwebsite\Excel\Facades\Excel;
class EskulController extends Controller
{
    public function index()
    {
        if (!empty($_GET['id'])) {
            $data = Eskul::find($_GET['id']);
            return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $data]);
        }

        $eskul = Eskul::all();

        return DataTables::of($eskul)
            ->addIndexColumn()
            ->addColumn('check', function ($eskul) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" value="' . $eskul->id . '" name="id-checkbox" onchange="checkbox_this(this)" id="checkbox-' . $eskul->id . '" >
                    <label for="checkbox-' . $eskul->id . '" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($eskul) {
                return '
            <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $eskul->id . '" id="edit"><i class="fas fa-edit"></i></a>
            <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $eskul->id . '" id="delete"><i class="fas fa-trash"></i></a>
            ';
            })
            ->addColumn('imageEskul', function ($eskul) {
                return '<img src="' . $eskul->image() . '" width="50">';
            })

            ->rawColumns(['check', 'btn', 'imageEskul'])
            ->make(true);
    }

    public function export() 
    {
        return Excel::download(new EskulExport, 'Data_eskul.xlsx');
    }

    public function show($id)
    {
        $eskul = Eskul::with('created_by')->find($id);

        if (!$eskul) {
            return response()->json([
                'status' => 'error',
                'message' => 'eskul not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $eskul
        ], 200);
    }

    public function create()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'form create'
        ]);
    }

    public function store(EskulRequest $request)
    {

        $slug = Str::slug(request('name'));
        $eskul = Eskul::create([
            'name' => $request->name,
            'content' => $request->content,
            'image' =>  $request->file('image')->store('images/eskul'),
            'slug' => $slug,
            'created_by' => auth()->user()->id
        ]);

        activity('menambah data eskul');

        return response()->json([
            'status' => 'success',
            'message' => 'data created successfuly'
        ]);
    }

    public function edit()
    {
        $eskul = Eskul::find($_GET['id']);

        if (!$eskul) {
            return response()->json([
                'status' => 'error',
                'message' => 'division not found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'form edit',
            'data' => $eskul
        ]);
    }

    public function update(EskulRequest $request)
    {


        $eskul = Eskul::where('id', $request->id)->first();
        if (!$eskul) {
            return response()->json([
                'status' => 'error',
                'message' => 'division not found'
            ]);
        }

        $slug = Str::slug(request('name'));

        if ($request->image) {
            \Storage::delete($eskul->image);
            $image = request()->file('image')->store('images/eskul');
        } elseif ($eskul->image) {
            $image = $eskul->image;
        } else {
            $image = null;
        }

        $eskul->update([
            'name' => $request->name,
            'content' => $request->content,
            'image' =>  $image,
            'slug' => $slug,
            'created_by' => auth()->user()->id
        ]);
       
       activity('mengedit data eskul');
       return response()->json([

            'status' => 'success',
            'message' => 'data update successfuly'
        ], 200);
    }

    public function destroy(Request $request)
    {

        if (is_array($request->value)) {
            foreach ($request->value as $value) {
                $eskul = Eskul::find($value);
                $eskul->video()->delete();
                $eskul->delete();
            }
            activity('menghapus data eskul');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!'], 200);
        }

        $eskul = Eskul::find($request->value);

        if (!$eskul) {
            return response()->json([
                'status' => 'error',
                'message' => 'eskul not found'
            ], 404);
        }

        // \Storage::delete($eskul->image);

        $eskul->video()->delete();
        $eskul->delete();
        activity('menghapus data eskul');
        return response()->json([
            'status' => 'success',
            'message' => 'division deleted successfuly'
        ]);
    }
}
