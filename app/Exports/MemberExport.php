<?php

    namespace App\Exports;
    
    use App\Models\Member; //App\User adalah model User
    use Illuminate\Contracts\View\View; //Harus diimport untuk men-convert blade menjadi file excel
    use Maatwebsite\Excel\Concerns\FromView; //Harus diimport untuk men-convert blade menjadi file excel
    
    class MemberExport implements FromView
    {
        public function view(): View
        {
            //export adalah file export.blade.php yang ada di folder views
            return view('main.master.exports.member', [
                //data adalah value yang akan kita gunakan pada blade nanti
                //User::all() mengambil seluruh data user dan disimpan pada variabel data
                'data' => Member::all()
            ]);
        }
    }