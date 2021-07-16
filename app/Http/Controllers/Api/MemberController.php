<?php

namespace App\Http\Controllers\Api;

use App\Models\{Activity, Member, Eskul, MemberReg, Schedule, ScoreList, TestList, User, UserProfile};
use App\Http\Requests\MemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Test;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\MemberExport;
use Maatwebsite\Excel\Facades\Excel;
class MemberController extends Controller
{

    public function index()
    {
        if (!empty($_GET['id'])) {
            $data = Member::find($_GET['id']);
            return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $data]);
        }

        $member = Member::all();

        if (!empty($_GET['parm'])) {
            if ($_GET['parm'] != 'null') {
                $member = Member::where('division_id', $_GET['parm']);
            }
            return DataTables::of($member)
                ->addIndexColumn()
                ->addColumn('btn', function ($member) {
                    return '
                    <a href="#" class="btn btn-icon btn-sm btn-primary" data-id="' . $member->id . '" data-value="' . $member->division_id . '" id="edit"><i class="fas fa-edit"></i></a>
                    ';
                })
                ->addColumn('imageMember', function ($member) {
                    return '<img src="' . $member->image() . '" width="50">';
                })
                ->addColumn('class_majors', function ($member) {
                    return $member->class . ' ' . $member->majors;
                })
                ->editColumn('division_id', function ($member) {
                    return $member->division->name;
                })
                ->rawColumns(['btn', 'imageMember',])
                ->make(true);
        }

        return DataTables::of($member)
            ->addIndexColumn()
            ->addColumn('check', function ($member) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" value="' . $member->id . '" name="id-checkbox" onchange="checkbox_this(this)" id="checkbox-' . $member->id . '" >
                    <label for="checkbox-' . $member->id . '" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($member) {
                return '
            <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $member->id . '" id="edit"><i class="fas fa-edit"></i></a>
            <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $member->id . '" id="delete"><i class="fas fa-trash"></i></a>
            ';
            })
            ->addColumn('imageMember', function ($member) {
                return '<img src="' . $member->image() . '" width="50">';
            })
            ->addColumn('class_majors', function ($member) {
                return $member->class . ' ' . $member->majors;
            })
            ->editColumn('user_id', function ($member) {
                return $member->user->email;
            })
            ->editColumn('division_id', function ($member) {
                return $member->division->name;
            })
            ->rawColumns(['check', 'btn', 'imageMember', 'user_id', 'division_id'])
            ->make(true);
    }

    public function export() 
    {
        return Excel::download(new MemberExport, 'Data_member.xlsx');
    }


    public function show($id)
    {
        $member = Member::with('division', 'alumni', 'created_by')->find($id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'member not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $member
        ], 200);
    }

    public function create()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'form create'
        ]);
    }

    public function store(MemberRequest $request)
    {
        $user = User::where('id', $request->user_id)->exists();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $memberId = Member::where('user_id', $request->user_id)->exists();
        if ($memberId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member Already exists'
            ]);
        }

        $division = Eskul::where('id', $request->division_id)->exists();
        if (!$division) {
            return response()->json([
                'status' => 'error',
                'message' => 'division not found'
            ], 404);
        }

        $member = Member::create([
            'name' => $request->name,
            'class' => $request->class,
            'division_id' => $request->division_id,
            'image' => $request->image ? request()->file('image')->store('images/member') : null,
            'position' => $request->position,
            'majors' => $request->majors,
            'status' => 1,
            'user_id' => $request->user_id,
            'entry_year' => $request->entry_year,
            'created_by' => auth()->user()->id
        ]);

        activity('menambah data member');

        return response()->json([
            'status' => 'success',
            'message' => 'data added successfuly'
        ], 200);
    }

    public function edit($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'member not found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'form edit',
            'data' => $member
        ]);
    }

    public function update(MemberRequest $request)
    {
        $member = Member::find($request->id);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'member not found'
            ], 404);
        }


        $division = Eskul::where('id', $request->division_id)->exists();
        if (!$division) {
            return response()->json([
                'status' => 'error',
                'message' => 'division not found'
            ], 404);
        }

        if ($request->image) {
            \Storage::delete($member->image);
            $image = request()->file('image')->store('images/member');
        } elseif ($member->image) {
            $image = $member->image;
        } else {
            $image = null;
        }

        $member->update([
            'name' => $request->name,
            'class' => $request->class,
            'division_id' => $request->division_id,
            'image' => $image,
            'position' => $request->position,
            'majors' => $request->majors,
            'status' => 1,
            'user_id' => $request->user_id,
            'entry_year' => $request->entry_year,
            'created_by' => auth()->user()->id
        ]);

        activity('mengedit data member');

        return response()->json([
            'status' => 'success',
            'message' => 'member update successfuly'
        ], 200);
    }

    public function destroy(Request $request)
    {

        if (is_array($request->value)) {
            foreach ($request->value as $value) {
                $member = Member::find($value);
                
                $member->delete();
            }
            activity('menghapus data member');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus!'], 200);
        }


        $member = Member::find($request->value);

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'member not found'
            ], 404);
        }

        // \Storage::delete($member->image);

        
        $member->delete();

        activity('menghapus data member');

        return response()->json([
            'status' => 'success',
            'message' => 'member deleted successfuly'
        ], 200);
    }

    public function get_profile()
    {
        $user = User::where('name', $_GET['name']);
        $profile = UserProfile::where('user_id', $user->get()[0]->id);

        if ($profile->count() < 1) {
            return response()->json(['message' => 'query gagal, data tidak ditemukan', 'status' => 'error'], 404);
        }
        return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => $profile->get()[0]], 200);
    }

    public function insert_profile(Request $request)
    {
        $user = UserProfile::where('user_id', auth()->user()->id);
        $request->request->add(['user_id' => auth()->user()->id]);

        if ($request->hasFile('image')) {
            $name = auth()->user()->name . '-' . date('YmdHi') . '-' . round(0, 10) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move('private_file/user/image-thumbnail/', $name);
            $request->request->add(['thumbnail' => $name]);
        }

        if ($user->count() < 1) {
            UserProfile::create($request->except('image'));
        }
        $user->update($request->except('image'));

        activity('memperbarui data profile');
        return response()->json(['status' => 'success', 'message' => 'Profile berhasil diperbarui'], 200);
    }

    public function delete_image_profile()
    {
        $user = UserProfile::where('user_id', auth()->user()->id);
        $user->update(['thumbnail' => NULL]);
        activity('menghapus data image profile');
        return response()->json(['status' => 'success', 'message' => 'Profile berhasil diperbarui'], 200);
    }

    public function setting_changepassword(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $password = password_verify($request->oldpassword, $user->password);
        if ($password == true) {
            $newpassword = password_verify($request->newpassword, $user->password);
            if ($newpassword == false) {
                $user->update(['password' => bcrypt($request->newpassword)]);
                return response()->json(['status' => 'success', 'message' => 'Password has been changes'], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'the new password is the same as the old password'], 500);
        }
        activity('memperbarui data password');
        return response()->json(['status' => 'error', 'message' => 'Old Password is wrong'], 404);
    }

    public function get_activity()
    {
        return DataTables::of(Activity::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC'))
            ->editColumn('user_id', function ($activity) {
                return $activity->user->name;
            })
            ->editColumn('status', function ($activity) {
                $data = '<div class="badge badge-secondary">Unknown</div>';
                if (strpos($activity->url_access, 'delete') == TRUE) {
                    $data = '<div class="badge badge-danger">Delete</div>';
                } else if (strpos($activity->url_access, 'insert') == TRUE) {
                    $data = '<div class="badge badge-success">Insert</div>';
                } else if (strpos($activity->url_access, 'update') == TRUE) {
                    $data = '<div class="badge badge-warning">Edit</div>';
                } else if (strpos($activity->url_access, 'recovery') == TRUE) {
                    $data = '<div class="badge badge-info">Recovery</div>';
                }
                return $data;
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function upgrade(Request $request)
    {
        $image  = null;
        if ($request->image) {
            $name = auth()->user()->name . '-' . date('YmdHi') . '-' . round(0, 10) . '.' . $request->file('image')->getClientOriginalExtension();
            $image = \Storage::putFileAs('images/member_reg', $request->file('image'), $name);
        }


        if ($request->asal_pendaftar == 'lainnya') {
            $data = [
                'name' => $request->name,
                'user_id' => auth()->user()->id,
                'division_id' => $request->divisions,
                'image' => $image,
                'email' => auth()->user()->email,
            ];
        } else {
            $data = [
                'name' => $request->name,
                'user_id' => auth()->user()->id,
                'division_id' => $request->divisions,
                'class' => $request->class,
                'entry_year' => $request->entry_year,
                'majors' => $request->majors,
                'image' => $image,
                'email' => auth()->user()->email,
            ];
        }

        if (MemberReg::where('user_id', auth()->user()->id)->count() > 0) {
            return response()->json(['status' => 'error', 'message' => 'Registrasi gagal, anda telah terdaftar sebagai member atau telah mendaftar sebelumnya'], 500);
        }

        MemberReg::create($data);
        return response()->json(['status' => 'success', 'message' => 'Registrasi berhasil, mohon tunggu data sedang di proses'], 200);
    }

    public function registration_get()
    {
        if (!empty($_GET['id'])) {
            $data = DB::table('member_reg')->where('id', $_GET['id'])->get()[0];
            $division = Eskul::find($data->division_id);
            return response()->json(['message' => 'query berhasil', 'status' => 'success', 'data' => compact('data', 'division')]);
        }

        $member_reg = DB::table('member_reg')->get();

        return DataTables::of($member_reg)
            ->addIndexColumn()
            ->addColumn('check', function ($member_reg) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($member_reg) {
                return '
                    <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $member_reg->id . '" id="Access"><i class="fas fa-eye"></i></a>
                    ';
            })
            ->editColumn('image', function ($member_reg) {
                return '<img alt="image" src="/storage/' . $member_reg->image . '" class="rounded-circle" width="35" data-toggle="tooltip" title="" data-original-title="Nur Alpiana">';
            })
            ->editColumn('status', function ($member_reg) {
                if ($member_reg->deleted_at == null) {
                    if ($member_reg->status == 1) {
                        $data = '<div class="badge badge-success"><i class="fas fa-check"></i> Diterima</div>';
                    } else {
                        $data = '<div class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu</div>';
                    }
                } else {
                    $data = '<div class="badge badge-danger"><i class="fas fa-times"></i> Ditolak</div>';
                }
                return $data;
            })
            ->rawColumns(['check', 'btn', 'image', 'status'])
            ->make(true);
    }

    public function registration_accept(Request $request)
    {
        activity('Accept new member');
        $member = DB::table('member_reg')->where('id', $request->id);
        $member->update(['status' => 1, 'deleted_at' => null]);
        $value = $member->get()[0];
        $data = [
            'name' => $value->name,
            'division_id' => $value->division_id,
            'user_id' => $value->user_id,
            'class' => $value->class,
            'majors' => $value->majors,
            'image' => $value->image,
            'entry_year' => $value->entry_year,
        ];

        if ($value->type == 'smkn5') {
            Member::create($data);
        }

        $user = User::find($value->user_id)->update(['role_id' => 4]);
        access_update(4, $value->user_id);

        return response()->json(['status' => 'success', 'message' => 'User berhasil diterima, menjadi member resmi sekarang']);
    }

    public function registration_reject(Request $request)
    {
        activity('Reject new member');
        $member = DB::table('member_reg')->where('id', $request->id);
        $member->update(['status' => 0, 'deleted_at' => date('Y-m-d H:i:s')]);
        $value = $member->get()[0];

        if ($value->type == 'smkn5') {
            Member::where('user_id', $value->user_id)->delete();
        }

        $user = User::find($value->user_id)->update(['role_id' => 5]);
        access_update(5, $value->user_id);
        return response()->json(['status' => 'success', 'message' => 'User gagal diterima, tidak bisa menjadi member resmi sekarang']);
    }

    public function schedule_get()
    {
        if (!empty($_GET['id'])) {
            $schedule = Schedule::find($_GET['id']);
            return response()->json(['message' => 'Query berhasil', 'status' => 'success', 'values' => $schedule], 200);
        }

        if (!empty($_GET['member'])) {
            $member = 0;
            $data = Member::where('user_id', auth()->user()->id)->get();
            if ($data->count() > 0) {
                $member = $data[0]->division_id;
                $table = DB::table('schedule')->where('division', $member)->orWhere('division', 'all')->orderBy('id', 'asc')->where('deleted_at', null)->get();
            } else {
                if (auth()->user()->role_id <= 2) {
                    $table = DB::table('schedule')->orderBy('id', 'asc')->where('deleted_at', null)->get();
                } else {
                    $table = DB::table('schedule')->orderBy('id', 'asc')->where('deleted_at', null)->orWhere('division', 'no')->get();
                }
            }
            return DataTables::of($table)
                ->addIndexColumn()
                ->addColumn('status', function ($schedule) {
                    if ($schedule->date == date('Y-m-d')) {
                        $color = 'success';
                        $text = 'Today';
                    } else if ($schedule->date > date('Y-m-d')) {
                        $color = 'primary';
                        $text = 'Already';
                    } else {
                        $color = 'danger';
                        $text = 'Ended';
                    }
                    return '<div class="badge badge-pill badge-' . $color . ' mb-1 float-right">' . $text . '</div>';
                })
                ->rawColumns(['status', 'check'])
                ->make(true);
        }

        return DataTables::of(Schedule::all())
            ->addColumn('check', function ($schedule) {
                return  '<div class="custom-checkbox custom-control">
                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" name="id-checkbox" value="' . $schedule->id . '" class="custom-control-input" id="checkbox-' . $schedule->id . '" onclick="checkbox_this(this)">
                    <label for="checkbox-' . $schedule->id . '" class="custom-control-label">&nbsp;</label>
                    </div>';
            })
            ->addColumn('btn', function ($schedule) {
                return '
                    <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $schedule->id . '" id="edit"><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $schedule->id . '" id="delete"><i class="fas fa-trash"></i></a>
            ';
            })
            ->addColumn('division', function ($schedule) {
                return $schedule->division == 'all' ? 'All' : $schedule->divisions->name;
            })
            ->rawColumns(['btn', 'check'])
            ->make(true);
    }

    public function schedule_insert(Request $request)
    {
        $data = Schedule::where('date', $request->date)->where('division', $request->division)->count();
        if ($data > 0) {
            return response()->json(['status' => 'error', 'message' => 'Jadwal sudah ada, coba lagi!'], 500);
        }

        $request->request->add(['created_by' => auth()->user()->id]);
        Schedule::create($request->all());
        activity('Menambahkan jadwal member');
        return response()->json(['status' => 'success', 'message' => 'Jadwal berhasil ditambahkan'], 200);
    }

    public function schedule_update(Request $request)
    {
        $data = Schedule::find($request->id);
        if ($data->count() < 1) {
            return response()->json(['status' => 'error', 'message' => 'Jadwal tidak terdaftar, coba lagi!'], 500);
        }

        $data->update($request->all());
        activity('Mengubah jadwal member');
        return response()->json(['status' => 'success', 'message' => 'Jadwal berhasil diperbaharui'], 200);
    }

    public function schedule_delete(Request $request)
    {
        if (is_array($request->value)) {
            foreach ($request->value as $item) {
                $schedule = Schedule::find($item);
                $schedule->delete();
            }
            activity('Menghapus jadwal member');
            return response()->json(['message' => 'Jadwal berhasil dihapus', 'status' => 'success'], 200);
        }
        $schedule = Schedule::find($request->value);
        $schedule->delete();
        activity('Menghapus jadwal member');
        return response()->json(['message' => 'Jadwal berhasil dihapus', 'status' => 'success'], 200);
    }

    public function member_profile()
    {
        $data = Member::where('user_id', auth()->user()->id)->get()[0];
        $schedule = Schedule::where('date', '>', date('Y-m-d'))->where('division', $data->division_id)->orWhere('division', 'all')->limit(1);
        $jadwal = $schedule->count() > 0 ? $schedule->get()[0] : 0;
        $divisi = $data->division->name;

        return response()->json(['status' => 'success', 'message' => 'Query data berhasil', 'values' => compact('data', 'jadwal', 'divisi')], 200);
    }

    public function precentages_test()
    {
        if (!empty($_GET['id'])) {
            $test = TestList::find($_GET['id']);
            $division = $test->division->name;
            return response()->json(['status' => 'success', 'message' => 'Query data berhasil', 'values' => $test], 200);
        }
        return DataTables::of(TestList::where('created_by', auth()->user()->id))
            ->addColumn('check', function ($test) {
                return  '<div class="custom-checkbox custom-control">
                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" name="id-checkbox" value="' . $test->id . '" class="custom-control-input" id="checkbox-' . $test->id . '" onclick="checkbox_this(this)">
                <label for="checkbox-' . $test->id . '" class="custom-control-label">&nbsp;</label>
                </div>';
            })
            ->editColumn('division_id', function ($test) {
                return $test->division->name;
            })
            ->addColumn('action', function ($test) {
                return '
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-value="' . $test->id . '" id="edit"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-value="' . $test->id . '" id="delete"><i class="fas fa-trash"></i></a>';
            })
            ->rawColumns(['action', 'check'])
            ->make(true);
    }

    public function precentages_test_insert(Request $request)
    {
        $request->request->add(['created_by' => auth()->user()->id]);
        TestList::create($request->all());
        Activity('Menambah data test member');
        return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan'], 200);
    }

    public function precentages_test_update(Request $request)
    {
        $data = TestList::find($request->id);
        $data->update($request->all());
        Activity('Memperbaharui data test member');
        return response()->json(['status' => 'success', 'message' => 'Data berhasil diperbaharui'], 200);
    }

    public function precentages_test_delete(Request $request)
    {
        if (is_array($request->value)) {
            foreach ($request->value as $value) {
                $item = TestList::find($value);
                $item->delete();
            }
            Activity('Menghapus data test member');
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus'], 200);
        }
        $item = TestList::find($request->value);
        $item->delete();
        Activity('Menghapus data test member');
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus'], 200);
    }


    public function precentages_score()
    {
        return DataTables::of(TestList::all()->where('division_id', $_GET['value']))
            ->addIndexColumn()
            ->addColumn('check', function ($test) {
                return  '<div class="custom-checkbox custom-control">
                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" name="id-checkbox" value="' . $test->id . '" class="custom-control-input" id="checkbox-' . $test->id . '" onclick="checkbox_this(this)">
                <label for="checkbox-' . $test->id . '" class="custom-control-label">&nbsp;</label>
                </div>';
            })
            ->editColumn('score', function ($test) {
                $data = '<input type="number" class="form-control" id="input-' . $test->id . '" value="' . score($_GET['id'], $test->id) . '" style="display:none; width:55px;"><a id="nilai-' . $test->id . '">' . score($_GET['id'], $test->id) . '</a>';
                return $data;
            })
            ->addColumn('action', function ($test) {
                return '
                <a href="#" class="btn btn-icon btn-sm btn-warning Edit" data-id="' . $_GET['id'] . '" data-value="' . $test->id . '" id="edit-' . $test->id . '"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-success disabled Save" data-id="' . $_GET['id'] . '" data-value="' . $test->id . '" id="save-' . $test->id . '"><i class="fas fa-save"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger Delete" data-id="' . $_GET['id'] . '" data-value="' . $test->id . '" id="delete"><i class="fas fa-trash"></i></a>'; 

            })
            ->rawColumns(['action', 'check', 'score'])
            ->make(true);
    }

    public function precentages_score_insert(Request $request)
    {
        $test = ScoreList::where('test_id', $request->test_id)->where('user_id', $request->user_id);

        if ($test->count() > 0) {
            $test->delete();
        }
        $request->request->add(['created_by' => auth()->user()->id]);
        ScoreList::create($request->all());
        Activity('Menambah data score member');
        return response()->json(['status' => 'success', 'message' => 'Score berhasil ditetapkan'], 200);
    }

     public function precentages_score_delete(Request $request)
    {
        $test = ScoreList::where('test_id', $request->test_id)->where('user_id', $request->user_id);
        $test->delete();

        Activity('Menghapus data score member');
        return response()->json(['status' => 'success', 'message' => 'Score berhasil dihapus'], 200);

    }
}
