<?php

namespace App\Imports;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection
{
    public function __construct($kelas)
    {
        $this->kelas=$kelas;
        // $this->angkatan_id = Kelas::where('id',$this->kelas->id)->select('angkatan_id')->first();
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            if ($key >= 6) {

                    $usr = new User;
                    $usr->username = $row[2];
                    $usr->pass = $row[1];
                    $usr->password = Hash::make($row[1]);
                    $usr->role = 'siswa';
                    $usr->save();

                    $sis = new Siswa;
                    $sis->user_id = $usr->id;
                    $sis->kelas_id = $this->kelas->id;
                    $sis->angkatan_id = $this->kelas->angkatan->id;
                    $sis->siswa_nik= $row[1];
                    $sis->siswa_name = $row[2];
                    $sis->siswa_slug = Str::slug($row[2]);
                    $sis->siswa_status = 'aktif';
                    $sis->save();
            }
        }
    }
}
