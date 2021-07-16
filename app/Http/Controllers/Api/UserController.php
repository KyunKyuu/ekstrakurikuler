<?php

namespace App\Http\Controllers\Api;

use AccessUserSection;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Menu;
use App\Models\MenuAccess;
use App\Models\SectionAccess;
use App\Models\SubmenuAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
class UserController extends Controller
{
    public function user()
    {
        if (!empty($_GET['id'])) {
            $data = User::find($_GET['id']);
            return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $data]);
        }

        $user = User::all();
        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('check', function ($user) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($user) {
                return '
            <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $user->id . '" id="edit"><i class="fas fa-edit"></i></a>
            <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $user->id . '" id="delete"><i class="fas fa-trash"></i></a>
            ';
            })
            ->editColumn('status', function ($user) {
                $checked = $user->status > 0 ? 'checked' : '';
                return '<input type="checkbox" class="input-toggle" ' . $checked . ' data-value="' . $user->id . '"> ';
            })
            ->editColumn('role_id', function ($user) {
                return $user->roles->name;
            })
            ->editColumn('email_verified_at', function ($user) {
                if ($user->email_verified_at) {
                    $data = '<a class="text-success"><i class="fas fa-check"></i> Verified</a>';
                } else {
                    $data = '<a class="text-danger"><i class="fas fa-times"></i> Not Verified</a>';
                }

                return $data;
            })
            ->rawColumns(['check', 'btn', 'status', 'email_verified_at'])
            ->make(true);
    }

    public function insert_user(Request $request)
    {
        $request->request->add(['password' => bcrypt($request->passwd), 'created_by' => auth()->user()->id, 'email_verified_at' => date('Y-m-d H:i:s')]);
        $user = User::create($request->all());
        activity('Create new user ' . $user->name);
        access_create($request->role_id, $user->id);
        return response()->json(['message' => 'Data berhasil ditambahkan', 'status' => 'success']);
    }

    public function update_user(Request $request)
    {
        $userole = User::where('id', $request->user_id)->where('role_id', $request->role_id)->count();
        if ($userole < 1) {
            access_update($request->role_id, $request->user_id);
        }
        if (empty($request->passwd)) {
            $user = User::find($request->user_id);
            $user->update($request->all());
            activity('Update user ' . $user->name);
            return response()->json(['message' => 'Data berhasil diperbaharui', 'status' => 'success']);
        } else {
            $user = User::find($request->user_id);
            $request->request->add(['password' => bcrypt($request->passwd)]);
            activity('Update user ' . $user->name);
            $user->update($request->all());
            return response()->json(['message' => 'Data berhasil diperbaharui', 'status' => 'success']);
        }
    }

    public function delete_user(Request $request)
    {
        $user = User::find($request->user_id);
        activity('Delete user ' . $user->name);
        $user->delete();
        return response()->json(['message' => 'Data berhasil dihapus', 'status' => 'success']);
    }

    public function export() 
    {
        return Excel::download(new UserExport, 'Data_user.xlsx');
    }

    public function get_all_activity()
    {
        $delete = Activity::where('url_access', 'like', '%delete%');
        $insert = Activity::where('url_access', 'like', '%insert%');
        $update = Activity::where('url_access', 'like', '%update%');
        $recovery = Activity::where('url_access', 'like', '%recovery%');
        $all = Activity::where('deleted_at', null);
        if (auth()->user()->role_id > 2) {
            $delete->where('user_id', auth()->user()->id);
            $insert->where('user_id', auth()->user()->id);
            $update->where('user_id', auth()->user()->id);
            $recovery->where('user_id', auth()->user()->id);
            $all->where('user_id', auth()->user()->id);
        }
        $data = [
            'delete' => $delete->count(),
            'insert' => $insert->count(),
            'update' => $update->count(),
            'recovery' => $recovery->count(),
            'all' => $all->count(),
            'unknown' => $all->count() - ($update->count() + $delete->count() + $insert->count() + $recovery->count())
        ];
        return response()->json(['message' => 'query berhasil', 'status' => 'success', 'values' => $data], 200);
    }

    public function get_browser_activity()
    {
        $data = DB::select('select browser, COUNT(id) as data from activities GROUP BY browser LIMIT 3');
        return response()->json(['message' => 'query berhasil', 'status' => 'success', 'values' => $data], 200);
    }
}
