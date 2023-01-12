<?php

namespace App\Http\Controllers;
use App\Exports\TemplateSiswaExport;
use App\Exports\TemplateGuruExport;
use App\Exports\TemplateQuizExport;
use Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function download_template_siswa($kelas_id)
    {
        return Excel::download(new TemplateSiswaExport($kelas_id),'template_siswa.xlsx',ExcelExcel::XLSX);
    }

    public function download_template_guru()
    {
        return Excel::download(new TemplateGuruExport(), 'template_guru.xlsx',ExcelExcel::XLSX);
    }

    public function download_template_quiz()
    {
        return Excel::download(new TemplateQuizExport(), 'template_quiz.xlsx',ExcelExcel::XLSX);
    }
}
