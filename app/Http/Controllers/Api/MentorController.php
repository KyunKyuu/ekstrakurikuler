<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Division, Mentor};
use App\Http\Requests\MentorRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\MentorExport;
use Maatwebsite\Excel\Facades\Excel;
class MentorController extends Controller
{
     public function index()
    {
        if (!empty($_GET['id'])) {
            $data = Mentor::find($_GET['id']);
          
            return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $data ]);
        }

        $mentor = Mentor::all();

        return DataTables::of($mentor)
            ->addIndexColumn()
            ->addColumn('check', function ($mentor) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" value="' . $mentor->id . '" name="id-checkbox" onchange="checkbox_this(this)" id="checkbox-' . $mentor->id . '" >
                    <label for="checkbox-' . $mentor->id . '" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($mentor) {
                return '
            <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $mentor->id . '" id="edit"><i class="fas fa-edit"></i></a>
            <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $mentor->id . '" id="delete"><i class="fas fa-trash"></i></a>
            ';
            })
            ->addColumn('images', function ($mentor) {   
                return '<img src="'.$mentor->image().'" width="50">';
            })
            ->editColumn('eskul_id', function ($mentor) {
                    return  ' <a href="#" class="btn btn-icon btn-sm btn-primary">' . $mentor->eskul->name.'</a>';
                
            })
            ->rawColumns(['check', 'btn', 'images', 'eskul_id'])
            ->make(true);
    }

    public function export() 
    {
        return Excel::download(new MentorExport, 'Data_mentor.xlsx');
    }

     public function store(MentorRequest $request)
    {

        $mentor = Mentor::create([
            'name' => $request->name,
            'eskul_id' => $request->eskul_id,
            'image' =>  $request->file('image')->store('images/mentor'),
            'created_by' => auth()->user()->id
        ]);
       
        activity('menambah data mentor');

        return response()->json([
            'status' => 'success',
            'message' => 'data added successfuly'
        ]);
    }

     public function update(MentorRequest $request)
    {
        
        $mentor = Mentor::find($request->id);
        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }

        if ($request->image) {
            \Storage::delete($mentor->image);
            $image = request()->file('image')->store('images/mentor');
        } elseif ($mentor->image) {
            $image = $mentor->image;
        } else {
            $image = null;
        }

        $mentor->update([
            'name' => $request->name,
            'eskul_id' => $request->eskul_id,
            'image' =>  $image,
            'created_by' => auth()->user()->id
        ]);
       
        activity('mengedit data mentor');

        return response()->json([
            'status' => 'success',
            'message' => 'data update successfuly'
        ]);
    }

    public function destroy(Request $request)
    {
        if (is_array($request->value)) {
            foreach ($request->value as $value) {
                $mentor = Mentor::find($value);
                $mentor->delete();
            }
            activity('menghapus data mentor');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!'], 200);
        }

        $mentor = Mentor::find($request->value);
        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ]);
        }

        $mentor->delete();

        activity('menghapus data mentor');
        
        return response()->json([
            'status' => 'success',
            'message' => 'mentor deleted successfuly'
        ], 200);
    }

}
