<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\Eskul;
use App\Models\Member;
use App\Models\ScoreList;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{

    public function dashboard_general()
    {
        return view('main.dashboard.index');
    }

    public function dashboard_user()
    {
        $nilai = [];
        $id = Member::where('user_id', auth()->user()->id);
        if ($id->count() > 0) {
            $nilai = ScoreList::where('user_id', $id->first()->id)->get();
        }
        $member = Member::where('user_id', auth()->user()->id)->count();
        return view('main.dashboard.user', compact('member', 'nilai'));
    }

    public function mail()
    {
        $email =  'riezkanaprianda@gmail.com';
        $data = ['subject' => 'Verify Account!'];
        Mail::to($email)->queue(new AuthMail($data));
        return 'Terkirim';
    }

    public function profile_user()
    {
        $user = User::where('name', request()->segment(2))->get()[0];
        $profile = UserProfile::where('user_id', $user->id)->get();
        $data = [
            'user' => $user,
            'profile' => $profile->count() > 0 ? $profile[0] : NULL,
        ];
        return view('main.resource.profile_user', ['data' => $data]);
    }

    public function setting_user()
    {
        return view('main.resource.setting_user');
    }

    public function changepassword_setting()
    {
        return view('main.resource.setting_user.changepassword');
    }

    public function activities_user()
    {
        return view('main.resource.activities_user');
    }

    public function userguides_user()
    {
        return view('main.resource.userguides_user');
    }

    public function userguides()
    {
        return view('main.resource.userguides');
    }

    public function upgrade_member()
    {
        $divisi = Eskul::all();
        $reg = DB::table('member_reg')->where('user_id', auth()->user()->id)->get();
        return view('main.resource.upgrade', compact('divisi', 'reg'));
    }
}
