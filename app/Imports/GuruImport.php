<?php

namespace App\Imports;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class GuruImport implements ToCollection
{
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
                    $usr->role = 'guru';
                    $usr->save();

                    $gur = new Guru;
                    $gur->user_id = $usr->id;
                    $gur->guru_nip= $row[1];
                    $gur->guru_name = $row[2];
                    $gur->guru_slug = Str::slug($row[2]);
                    $gur->guru_status = 'aktif';
                    $gur->save();
            }
        }
    }
}
