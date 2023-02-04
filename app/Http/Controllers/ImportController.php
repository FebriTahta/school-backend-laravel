<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Support\Facades\Input;
use App\Imports\SiswaImport;
use App\Imports\GuruImport;
use App\Imports\QuizImport;
use App\Imports\ExamImport;
use App\Imports\MapelImport;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Exam;
use App\Models\Ujian;
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


    public function import_data_exam(Request $request)
    {
        if ($request->id) {
            # code...
            $exam_mapel = Mapel::where('id', $request->mapel_id)->first();
            $ujian = Exam::where('id', $request->id)->update([
                'mapel_id' => $request->mapel_id,
                'exam_jenis' => $request->exam_jenis,
                'exam_status' => $request->exam_status,
                'exam_name' => $exam_mapel->mapel_name.' : '.$request->exam_jenis,
                'exam_lamapengerjaan' => $request->exam_lamapengerjaan,
                'exam_datetimestart' => $request->exam_datetimestart,
                'exam_datetimeend' => $request->exam_datetimeend,
            ]);

            return response()->json([
                'status'=>200,
                'message'=>'Data Exam / Ujian berhasil diperbarui'
            ]);

        }else {
            # code...
            try {
                $objphpexcel = IOFactory::load(request()->file('file'));
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
                    $myFileName = 'be_assets\exam\exam_' . $uid . '.' . $extension;
                    file_put_contents($myFileName, $imageContents);
                    $objphpexcel->getActiveSheet()->setCellValue($drawing->getCoordinates(), $myFileName);
                }
                $writer = new Xlsx($objphpexcel);
                $temp = 'be_assets\exam\tempImportExam.xlsx';
                $writer->save($temp);
                $exam_mapel = Mapel::where('id', $request->mapel_id)->first();
                $ujian = Exam::create([
                    'mapel_id' => $request->mapel_id,
                    'exam_jenis' => $request->exam_jenis,
                    'exam_status' => $request->exam_status,
                    'exam_name' => $exam_mapel->mapel_name.' : '.$request->exam_jenis,
                    'exam_lamapengerjaan' => $request->exam_lamapengerjaan,
                    'exam_datetimestart' => $request->exam_datetimestart,
                    'exam_datetimeend' => $request->exam_datetimeend,
                ]);
                Excel::import(new ExamImport($ujian->id), $temp);
                return redirect()->back()->with('success', 'data quiz berhasil diimport');
            } catch (\Throwable $th) {
                // return 'prob';
                throw $th;
            }
        }
    }

    public function import_data_quiz(Request $request)
    {
        try {
            $objphpexcel = IOFactory::load(request()->file('file'));
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
            $ujian = Ujian::create([
                'mapelmaster_id' => $request->mapelmaster_id,
                'materi_id' => $request->materi_id,
                'ujian_name' => $request->ujian_name,
                'ujian_slug' =>  Str::slug($request->ujian_name) . '-' . Str::random(5),
                'ujian_jenis' => 1,
                'ujian_lamapengerjaan' => $request->ujian_lamapengerjaan,
                'ujian_datetimestart' => $request->ujian_datetimestart,
                'ujian_datetimeend' => $request->ujian_datetimeend,
            ]);
            Excel::import(new QuizImport($ujian->id), $temp);
            return redirect()->back()->with('success', 'data quiz berhasil diimport');
        } catch (\Throwable $th) {
            // return 'prob';
            throw $th;
        }
    }

    public function import_data_mapel()
    {
        Excel::import(new MapelImport(), request()->file('file'));
        return redirect()->back()->with('success', 'data mapel berhasil diimport');
    }
}
