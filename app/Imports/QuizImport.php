<?php

namespace App\Imports;

use App\Models\Optionmulti;
use App\Models\Soalmulti;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class QuizImport implements ToCollection
{

    private $uuid, $path;

    // public function __construct(array $uuid, $path)
    // {
    //     $this->uuid = $uuid;
    //     $this->path = $path;
    // }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // return ['uuids' => $this->uuid, 'paths' =>  $this->path];
        $skip = 5; // cs 5 opt
        $soal = [];
        foreach ($collection as $key => $row) {
            if ($key >= 6) {
                $uid = Str::uuid();
                // input soal
                // return $row[2];
                if ($row[1] === 'soal') {
                    $img = '';
                    if ($collection[$key + 1][2] != null) {
                        $img = $collection[$key + 1][2];
                    }
                    $soal = [
                        'ujian_id' => '1',
                        'soal_kode' => $uid,
                        'soal_name' => $row[2],
                        'soal_img' => $img
                    ];
                    $soal = Soalmulti::create($soal);
                }
                // input opt
                if ($row[1] === 'option') {
                    $opt = Optionmulti::create([
                        'soalmulti_id' => $soal->id,
                        'option_name' => $row[2],
                        'option_true' => $row[3],
                    ]);
                }
            }
        }
    }
}
