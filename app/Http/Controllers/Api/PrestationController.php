<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Prestation};
use App\Http\Requests\PrestationRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Exports\PrestationExport;
use Maatwebsite\Excel\Facades\Excel;
class PrestationController extends Controller
{
    public function index()
    {
        if (!empty($_GET['id'])) {
            $data = Prestation::find($_GET['id']);
            return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $data]);
        }

        $prestation = Prestation::all();

        return DataTables::of($prestation)
            ->addIndexColumn()
            ->addColumn('check', function ($prestation) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" value="' . $prestation->id . '" name="id-checkbox" onchange="checkbox_this(this)" id="checkbox-' . $prestation->id . '" >
                    <label for="checkbox-' . $prestation->id . '" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($prestation) {
                return '
            <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $prestation->id . '" id="edit"><i class="fas fa-edit"></i></a>
            <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $prestation->id . '" id="delete"><i class="fas fa-trash"></i></a>
            ';
            })
            ->addColumn('images', function ($prestation) {
                return '<img src="' . $prestation->image() . '" width="50">';
            })

            ->rawColumns(['check', 'btn', 'images'])
            ->make(true);
    }

    public function export() 
    {
        return Excel::download(new PrestationExport, 'Data_prestation.xlsx');
    }

    public function show($id)
    {
        $prestation = Prestation::find($id);
        if (!$prestation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestation not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $prestation
        ]);
    }

    public function create()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'form untuk creaete'
        ]);
    }

    public function store(PrestationRequest $request)
    {
        $prestation = Prestation::create([
            'name' => $request->name,
            'content' => $request->content,
            'image' => $request->file('image')->store('images/prestation'),
            'created_by' => auth()->user()->id
        ]);

         activity('menambah data prestasi');
        return response()->json([
            'status' => 'success',
            'message' => 'data added successfuly'
        ]);
    }

    public function edit($id)
    {
        $prestation = Prestation::find($id);
        if (!$prestation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestation not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'form untuk edit'
        ]);
    }

    public function update(PrestationRequest $request)
    {
        $prestation = Prestation::find($request->id);
        if (!$prestation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestation not found'
            ], 404);
        }

        if ($request->image) {
            \Storage::delete($prestation->image);
            $image = request()->file('image')->store('images/prestation');
        } elseif ($prestation->image) {
            $image = $prestation->image;
        } else {
            $image = null;
        }

        $prestation->update([
            'name' => $request->name,
            'content' => $request->content,
            'image' => $image,
            'created_by' => auth()->user()->id
        ]);

        activity('mengedit data prestasi');

        return response()->json([
            'status' => 'success',
            'message' => 'data added successfuly'
        ]);
    }

    public function destroy(Request $request)
    {   
         if (is_array($request->value)) {
            foreach ($request->value as $value) {
                $prestation = Prestation::find($value);
                $prestation->delete();
            }
            activity('menghapus data prestasi');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!'], 200);
        }

        $prestation = Prestation::find($request->value);

        if (!$prestation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prestation not found'
            ], 404);
        }

        $prestation->delete();

        activity('menghapus data prestasi');

        return response()->json([
            'status' => 'success',
            'message' => 'prestation deleted successfuly'
        ], 200);
    }
}
