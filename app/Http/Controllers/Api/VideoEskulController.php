<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Eskul, VideoEskul};
use App\Http\Requests\VideoEskulRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class VideoEskulController extends Controller
{
    public function index()
    {
        if (!empty($_GET['id'])) {
            $data = VideoEskul::find($_GET['id']);
            return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $data]);
        }

        $videoEskul = VideoEskul::all();

        return DataTables::of($videoEskul)
            ->addIndexColumn()
            ->addColumn('check', function ($videoEskul) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" value="' . $videoEskul->id . '" name="id-checkbox" onchange="checkbox_this(this)" id="checkbox-' . $videoEskul->id . '" >
                    <label for="checkbox-' . $videoEskul->id . '" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($videoEskul) {
                return '
            <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $videoEskul->id . '" id="delete"><i class="fas fa-trash"></i></a>
            ';
            })
            ->editColumn('eskul_id', function ($videoEskul) {   
                return $videoEskul->eskul->name;
            })
            ->addColumn('video', function ($videoEskul) {   
                return '<iframe src="{{$videoEskul->url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            })
            ->rawColumns(['check', 'btn','eskul_id','video'])
            ->make(true);
    }

    public function create()
    {
        return response()->json([
            'status' => 'success',
            'message' =>  'form create video Eskul'
        ]);
    }

    public function store(VideoEskulRequest $request)
    {
        $eskul = Eskul::where('id', $request->eskul_id)->exists();
        if (!$eskul) {
            return response()->json([
                'status' => 'error',
                'message' =>  'Eskul not found'
            ], 404);
        }

        $videoEskul = VideoEskul::create([
            'eskul_id' => $request->eskul_id,
             'url' => $request->url,
             'created_by' => auth()->user()->id
        ]);

        activity('menambah data video Eskul');

        return response()->json([
            'status' => 'success',
            'data' => $videoEskul
        ]);
    }


    public function destroy(Request $request)
    {   

        if (is_array($request->value)) {
            foreach ($request->value as $value) {
                $videoEskul = VideoEskul::find($value);
                $videoEskul->delete();
            }
            activity('menghapus data video eskul');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!'], 200);
        }

        $videoEskul = VideoEskul::find($request->value);

        if (!$videoEskul) {
            return response()->json([
                'status' => 'error',
                'message' => 'video not found'
            ], 404);
        }

        // Storage::delete($videoEskul->video);

        $videoEskul->delete();

        activity('menghapus data video Eskul');
        
        return response()->json([
            'status' => 'success',
            'message' => 'Eskul video deleted successfuly'
        ],200);
    }
}
