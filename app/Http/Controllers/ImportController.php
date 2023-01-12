<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Support\Facades\Input;
use App\Imports\SiswaImport;
use App\Imports\GuruImport;
use App\Imports\QuizImport;
use App\Imports\MapelImport;
use App\Models\Kelas;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportController extends Controller
{
    public function import_data_siswa(Request $request)
    {
        $kelas = Kelas::where('id', $request->kelas_id)->with('angkatan')->first();
        Excel::import(new SiswaImport($kelas), request()->file('file'));
        return redirect()->back()->with('success', 'data siswa berhasil diimport');
    }

    public function import_data_guru()
    {
        Excel::import(new GuruImport(), request()->file('file'));
        return redirect()->back()->with('success', 'data guru berhasil diimport');
    }

    public function import_data_quiz()
    {

        try {
            $objphpexcel = IOFactory::load(request()->file('file'));

            // $uuid = [];
            // $path = [];
            // $idx = [];
            foreach ($objphpexcel->getActiveSheet()->getDrawingCollection() as $key => $drawing) {
                $uid = Str::uuid();
                if ($drawing instanceof MemoryDrawing) {
                    ob_start();
                    call_user_func(
                        $drawing->getRenderingFunction(),
                        $drawing->getImageResource()
                    );
                    $imageContents = ob_get_contents();
                    ob_end_clean();
                    switch ($drawing->getMimeType()) {
                        case MemoryDrawing::MIMETYPE_PNG:
                            $extension = 'png';
                            break;
                        case MemoryDrawing::MIMETYPE_JPEG:
                            $extension = 'jpeg';
                            break;
                        case MemoryDrawing::MIMETYPE_JPEG:
                            $extension = 'jpg';
                            break;
                    }
                } else {
                    if ($drawing->getPath()) {
                        // Check if the source is a URL or a file path
                        if ($drawing->getIsURL()) {
                            $imageContents = file_get_contents($drawing->getPath());
                            $filePath = tempnam(sys_get_temp_dir(), 'Drawing');
                            file_put_contents($filePath, $imageContents);
                            $mimeType = mime_content_type($filePath);
                            // You could use the below to find the extension from mime type.
                            // https://gist.github.com/alexcorvi/df8faecb59e86bee93411f6a7967df2c#gistcomment-2722664
                            $extension = File::mime2ext($mimeType);
                            unlink($filePath);
                        } else {
                            $zipReader = fopen($drawing->getPath(), 'r');
                            $imageContents = '';
                            while (!feof($zipReader)) {
                                $imageContents .= fread($zipReader, 1024);
                            }
                            fclose($zipReader);
                            $extension = $drawing->getExtension();
                        }
                    }
                }
                $myFileName = 'be_assets\quiz\quiz_' . $uid . '.' . $extension;
                file_put_contents($myFileName, $imageContents);
                $objphpexcel->getActiveSheet()->setCellValue($drawing->getCoordinates(), $myFileName);
            }
            $writer = new Xlsx($objphpexcel);
            $temp = 'be_assets\quiz\tempImportQuiz.xlsx';
            $writer->save($temp);
            Excel::import(new QuizImport(), $temp);
            return redirect()->back()->with('success', 'data quiz berhasil diimport');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function import_data_mapel()
    {
        Excel::import(new MapelImport(), request()->file('file'));
        return redirect()->back()->with('success','data mapel berhasil diimport');
    }
}
