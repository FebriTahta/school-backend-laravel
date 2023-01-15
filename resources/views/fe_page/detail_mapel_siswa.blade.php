@extends('fe_layouts.master2')

@section('fe_content')
    <main>
        <!-- instructor details area start -->
        <section class="teacher__area pt-50 pb-50">
            <div class="page__title-shape">
                <img class="page-title-shape-5 d-none d-sm-block"
                    src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-1.png') }}" alt="">

                <img class="page-title-shape-3" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-3.png') }}"
                    alt="">
                <img class="page-title-shape-7" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-4.png') }}"
                    alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 pb-20">
                        <div class="teacher__details-thumb p-relative w-img">
                            <div class="blocl">
                                <img src="{{ asset('fe_assets/assets/img/teacer-details-1.jpg') }}" alt="">
                            </div>
                            <div class="events__sidebar-widget white-bg">
                                <div class="events__sponsor">
                                    <h3 class="events__sponsor-title">Name : {{ auth()->user()->siswa->siswa_name }}</h3>
                                    <div class="events__sponsor-info">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <button style="width: 100%" class="btn btn-sm btn-outline-info">credential</button>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <button style="width: 100%" class="btn btn-sm btn-outline-info">my photo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="events__sponsor">
                                    <h3 class="events__sponsor-title">Class Overview</h3>
                                    <div class="events__sponsor-info">
                                        <h3>Guru : {{ $mapelmaster->guru->guru_name }}</h3>
                                        <h4><span>Materi pada matapelajaran ini meliputi : {{ $mapelmaster->docs_count }} dokumen {{ $mapelmaster->vids_count }} video
                                             dan {{ $mapelmaster->ujian_count }} exam</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher__details-shape">
                                <img class="teacher-details-shape-1"
                                    src="{{ asset('fe_assets/assets/img/teacher/details/shape/shape-1.png') }}"
                                    alt="">
                                <img class="teacher-details-shape-2"
                                    src="{{ asset('fe_assets/assets/img/teacher/details/shape/shape-2.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-xl-8 col-lg-8">
                        <div class="teacher__wrapper">
                            <div class="teacher__top d-md-flex align-items-end justify-content-between">
                                <div class="teacher__info">
                                    <h4 class="text-capitalize">{{ $mapelmaster->mapel->mapel_name }}</h4>
                                    <span>" {{ $mapelmaster->kelas->angkatan->angkatan_name }} "
                                        {{ $mapelmaster->kelas->angkatan->tingkat->tingkat_name }}
                                        {{ $mapelmaster->kelas->jurusan->jurusan_name }}
                                        {{ $mapelmaster->kelas->kelas_name }}</span>
                                </div>
                            </div>

                            <div class="teacher_bio" style="margin-top: 10px">
                                <div class="course__tab-2 mb-45">
                                    <ul class="nav nav-tabs" id="courseTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="curriculum-tab" data-bs-toggle="tab"
                                                data-bs-target="#curriculum" type="button" role="tab"
                                                aria-controls="curriculum" aria-selected="false"> <i
                                                    class="icon_book_alt"></i>
                                                <span>Materi </span> </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="review-tab" data-bs-toggle="tab"
                                                data-bs-target="#review" type="button" role="tab"
                                                aria-controls="review" aria-selected="false"> <i class="icon_star_alt"></i>
                                                <span>Nilai</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="member-tab" data-bs-toggle="tab"
                                                data-bs-target="#member" type="button" role="tab"
                                                aria-controls="member" aria-selected="false"> <i class="fal fa-user"></i>
                                                <span>Siswa</span> </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link " id="description-tab" data-bs-toggle="tab"
                                                data-bs-target="#description" type="button" role="tab"
                                                aria-controls="description" aria-selected="true"> <i
                                                    class="icon_ribbon_alt"></i>
                                                <span>Tugas</span> </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course__tab-content mb-95">
                                <div class="tab-content" id="courseTabContent">
                                    <div class="tab-pane fade" id="description" role="tabpanel"
                                        aria-labelledby="description-tab">
                                        <div class="course__description">
                                            <h3>Petunjuk</h3>
                                            <p>
                                                Lakukan display sama seperti materi kalau bisa tampilkan dengan preview dokumen, kalau belum bisa lewati dulu preview dokumennya
                                                1 tugas dapat memiliki beberapa docs_file
                                                
                                            </p>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade  show active" id="curriculum" role="tabpanel"
                                        aria-labelledby="curriculum-tab">
                                        <div class="course__curriculum">
                                            
                                            @if ($mapelmaster->materi_count < 1)
                                                <div class="accordion" style="margin-top: 20px">
                                                    <h4 style="color: red">
                                                        Belum ada materi yang tersedia pada pelajaran ini
                                                    </h4>
                                                </div>
                                            @endif

                                            @foreach ($mapelmaster->materi as $key => $item)
                                                <div class="accordion" id="course__accordion">
                                                    <div class="accordion-item mb-50">
                                                        <h2 class="accordion-header" id="week-01">
                                                            <button class="accordion-button text-capitalize"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#x{{ $key }}"
                                                                aria-expanded="true" aria-controls="week-01-content">
                                                                {{ $item->materi_name }}
                                                            </button>
                                                        </h2>

                                                        <div id="x{{ $key }}"
                                                            class="accordion-collapse collapse show"
                                                            aria-labelledby="week-01" data-bs-parent="#course__accordion">
                                                            <div class="accordion-body">
                                                                @if ($mapelmaster->vids_count == 0 && $mapelmaster->docs_count == 0 && $mapelmaster->ujian_count == 0)
                                                                    <div
                                                                        class="course__curriculum-content d-sm-flex justify-content-between align-items-center">
                                                                        <div class="course__curriculum-info">
                                                                            <svg class="document" viewBox="0 0 24 24"
                                                                                style="color: red">
                                                                                <path class="st0"
                                                                                    d="M14,2H6C4.9,2,4,2.9,4,4v16c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8L14,2z" />
                                                                                <polyline class="st0"
                                                                                    points="14,2 14,8 20,8 " />
                                                                                <line class="st0" x1="16"
                                                                                    y1="13" x2="8"
                                                                                    y2="13" />
                                                                                <line class="st0" x1="16"
                                                                                    y1="17" x2="8"
                                                                                    y2="17" />
                                                                                <polyline class="st0"
                                                                                    points="10,9 9,9 8,9 " />
                                                                            </svg>
                                                                            <h3 class="course__curriculum-meta"> <span
                                                                                    class="question">Belum ada konten pada
                                                                                    materi ini</span></h3>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @foreach ($item->vids as $v)
                                                                    <div
                                                                        class="course__curriculum-content d-sm-flex justify-content-between align-items-center">
                                                                        <div class="course__curriculum-info">
                                                                            <svg class="document" viewBox="0 0 24 24">
                                                                                <path class="st0"
                                                                                    d="M14,2H6C4.9,2,4,2.9,4,4v16c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8L14,2z" />
                                                                                <polyline class="st0"
                                                                                    points="14,2 14,8 20,8 " />
                                                                                <line class="st0" x1="16"
                                                                                    y1="13" x2="8"
                                                                                    y2="13" />
                                                                                <line class="st0" x1="16"
                                                                                    y1="17" x2="8"
                                                                                    y2="17" />
                                                                                <polyline class="st0"
                                                                                    points="10,9 9,9 8,9 " />
                                                                            </svg>
                                                                            <h3> <span>{{ $v->vids_name }}</span></h3>
                                                                        </div>
                                                                        <div class="course__curriculum-meta">
                                                                            <span class="item"
                                                                                style="margin-right: 10px"><i
                                                                                    class="icon_clock_alt"></i></span>
                                                                            <a href="#{{ $v->vids_link }}"  data-bs-toggle="modal" data-bs-target="#modalplayvids" 
                                                                                data-src="{{ $v->vids_link }}" class="text-danger"><i
                                                                                    class="fa fa-play"
                                                                                    style="font-size: 12px" ></i> tonton</a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                @foreach ($item->docs as $d)
                                                                    <div
                                                                        class="course__curriculum-content d-sm-flex justify-content-between align-items-center">
                                                                        <div class="course__curriculum-info">
                                                                            <svg class="document" viewBox="0 0 24 24">
                                                                                <path class="st0"
                                                                                    d="M14,2H6C4.9,2,4,2.9,4,4v16c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8L14,2z" />
                                                                                <polyline class="st0"
                                                                                    points="14,2 14,8 20,8 " />
                                                                                <line class="st0" x1="16"
                                                                                    y1="13" x2="8"
                                                                                    y2="13" />
                                                                                <line class="st0" x1="16"
                                                                                    y1="17" x2="8"
                                                                                    y2="17" />
                                                                                <polyline class="st0"
                                                                                    points="10,9 9,9 8,9 " />
                                                                            </svg>
                                                                            <h3> <span>{{ $d->docs_name }} </span></h3>
                                                                        </div>
                                                                        <div class="course__curriculum-meta">
                                                                           <span class="item"
                                                                           style="margin-right: 10px"><i
                                                                               class="icon_clock_alt"></i></span>
                                                                       <a href="#" data-bs-toggle="modal" data-bs-target="#modaldownloaddocs"
                                                                       data-id="{{ $d->id }}" data-docs_name="{{ $d->docs_name }}"
                                                                       data-docs_desc="{{ $d->docs_desc }}" class="text-primary"><i
                                                                               class="fa fa-download"
                                                                               style="font-size: 14px"></i> unduh</a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane  fade" id="review" role="tabpanel"
                                        aria-labelledby="review-tab">
                                        <div class="course__review">
                                            <div class="course__comment mb-75">
                                                <ul>
                                                    <li>
                                                        <div class="course__comment-box ">
                                                            <div class="course__comment-thumb float-start">
                                                                <img src="{{ asset('fe_assets/assets/img/course/comment/course-comment-1.jpg') }}"
                                                                    alt="">
                                                            </div>
                                                            <div class="course__comment-content">
                                                                <div class="course__comment-wrapper ml-70 fix">
                                                                    <div class="course__comment-info float-start">
                                                                        <h4>Nama Ujian 1 / Tugas 1</h4>
                                                                        <span>July 14, 2022</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="member" role="tabpanel"
                                        aria-labelledby="member-tab">
                                        <div class="course__member mb-45">
                                            @foreach ($mapelmaster->kelas->siswa as $item)
                                            <div class="course__member-item">
                                                <div class="row align-items-center">
                                                    
                                                    <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-8">
                                                        <div class="course__member-thumb d-flex align-items-center">
                                                            <img src="{{ asset('fe_assets/assets/img/course/instructor/course-instructor-1.jpg') }}"
                                                                alt="">
                                                            <div class="course__member-name ml-20">
                                                                <h5>{{ $item->siswa_name }}</h5>
                                                                <span>RPL</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4">
                                                        <div class="course__member-info pl-45">
                                                            <h5>70</h5>
                                                            <span>AVG</span>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modalhapusvideo" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" style="font-size: 16px; color:white">HAPUS VIDEO</h4>
                </div>
                <form id="formremovevids"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" id="id" name="id">
                            </div>
                            <div class="col-md-12 col-12" id="block-new-jurusan" style="padding-right: 5px">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closemodalmateri" class="btn btn-sm btn-default"
                            data-dismiss="modal">Close</button>
                        <input type="submit" id="btnremovevids" class="btn btn-sm btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    <div class="modal fade" id="modaladdvids" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" style="font-size: 16px; color:white">MATERI VIDEO BARU</h4>
                </div>
                <form id="formaddvids"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-12" id="block-new-jurusan" style="padding-right: 5px">
                                <div class="form-group mb-20">
                                    <input type="hidden" class="form-control" value="{{ $mapelmaster->id }}" name="mapelmaster_id">
                                    <select name="materi_id" id="materi_id" required class="form-control">
                                        <option value="">:: Materi ::</option>
                                        @foreach ($mapelmaster->materi as $item)
                                            <option value="{{ $item->id }}">{{ $item->materi_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-20">
                                    <input type="text" class="form-control" name="vids_name"
                                        placeholder="Nama Video">
                                </div>
                                <div class="form-group mb-20">
                                    <input type="text" class="form-control" name="vids_link"
                                        placeholder="Link Video">
                                </div>
                                <div class="form-group mb-20">
                                    <textarea name="vids_desc" cols="30" rows="3" class="form-control" placeholder="Deskripsi Video"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closemodalvids" class="btn btn-sm btn-default"
                            data-dismiss="modal">Close</button>
                        <input type="submit" id="btnaddvids" class="btn btn-sm btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalplayvids" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="ratio ratio-16x9">
                            <iframe  width="420" height="315" class="embed-responsive-item" src="" id="video" frameborder="0"  allowscriptaccess="always" allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closemodalplayvids" class="btn btn-sm btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaldownloaddocs" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <h5 class="text-uppercase" id="docs_name"></h5>
                        <p id="docs_desc"></p>
                    </div>
                    <div class="form-group">
                        <a href="" id="download" class="btn btn-sm btn-outline-primary"><i class="fa fa-download"></i> unduh</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closemodaldownloaddocs" class="btn btn-sm btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaladddocs" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" style="font-size: 16px; color:white">MATERI VIDEO BARU</h4>
                </div>
                <form id="formadddocs"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-12" id="block-new-jurusan" style="padding-right: 5px">
                                <div class="form-group mb-20">
                                    <input type="hidden" class="form-control" value="{{ $mapelmaster->id }}" name="mapelmaster_id">
                                    <select name="materi_id" id="materi_id" required class="form-control">
                                        <option value="">:: Materi ::</option>
                                        @foreach ($mapelmaster->materi as $item)
                                            <option value="{{ $item->id }}">{{ $item->materi_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-20">
                                    <input type="text" class="form-control" name="docs_name"
                                        placeholder="Nama Dokumen">
                                </div>
                                <div class="form-group mb-20">
                                    <input type="file" class="form-control" accept=".xlsx,.docs,.doc,.pdf,.csv"
                                        name="docs_file" placeholder="Source Dokumen">
                                </div>
                                <div class="form-group mb-20">
                                    <textarea name="docs_desc" cols="30" rows="3" class="form-control" placeholder="Deskripsi Dokumen"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closemodaldocs" class="btn btn-sm btn-default"
                            data-dismiss="modal">Close</button>
                        <input type="submit" id="btnadddocs" class="btn btn-sm btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaladdmateri4" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" style="font-size: 16px; color:white">UJIAN BARU</h4>
                </div>
                <form id="formaddmateri4"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#modalcreateujian"><i class="fa fa-plus"></i>
                                Ujian</a>
                                <a href="#" class="btn btn-sm btn-outline-primary" id="showtemplateujian" data-bs-toggle="modal"
                                data-bs-target="#modaltemplateujian"><i class="fa fa-book"></i> Download Template</a>
                                <a href="#" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#modalimportujian"><i class="fa fa-upload"></i>
                                Import From Template</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closemodalmateri4" class="btn btn-sm btn-default"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaltemplateujian" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" style="font-size: 16px; color:white">JUMLAH SOAL BARU</h4>
                </div>
                <form id="formaddujian"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" name="number_soal" id="number_soal"
                                        placeholder="Jumlah soal" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closemodaladdujian" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                        <a href="#" class="btn btn-sm btn-outline-primary" id="btnaddujian">Download</a>
                        {{-- <input type="submit" id="btnaddujian" class="btn btn-sm btn-primary" value="Submit"> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {})
        $('#closemodalmateri').on('click', function() {
            $('#modaladdmateri').modal('hide');
        })
        $('#closemodalvids').on('click', function() {
            $('#modaladdvids').modal('hide');
        })
        $('#closemodaldocs').on('click', function() {
            $('#modaladddocs').modal('hide');
        })
        $('#closemodaldownloaddocs').on('click', function() {
            $('#modaldownloaddocs').modal('hide');
        })
        $('#modaldownloaddocs').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var docs_name = button.data('docs_name')
            var docs_desc = button.data('docs_desc')
            var modal = $(this)
            $("#download").attr("href", '/download-docs/'+id);
            modal.find('.modal-body #docs_name').html(docs_name);
            modal.find('.modal-body #docs_desc').html(docs_desc);
        })
       
        var videoSrc;
        $('#closemodalplayvids').on('click', function() {
            $('#modalplayvids').modal('hide');
            $('#video').attr('src',videoSrc);
        })
        $('#modalplayvids').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget)
            videoSrc = button.data('src')
            $('#video').attr('src',videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
            console.log(videoSrc);
        })
        $('#closemodalmateri4').on('click', function() {
            $('#modaladdmateri4').modal('hide');
        })

        $("#showtemplateujian").on('click', function(){
            $('#modaladdmateri4').modal('hide');
        })
        $('#btnaddujian').on('click', function(){
            var number_soal;
            number_soal = document.getElementById('number_soal').value;
            // number_soal = 1;
            // alert(number_soal);
            var modal = $(this)
            $("#btnaddujian").attr("href","/guru-download-template-ujian/"+number_soal)
            $('#modaltemplateujian').modal('hide');
        })
        $('#closemodaladdujian').on('click', function(){
            $('#modaltemplateujian').modal('hide');
        })

        $('#modaladdmateri').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var jurusan_name = button.data('jurusan_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #jurusan_name').val(jurusan_name);
        })

        $('#formadd').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/post-materi",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btnadd').attr('disabled', 'disabled');
                    $('#btnadd').val('Process...');
                },
                success: function(response) {
                    if (response.status == 200) {
                        $('#modaladdmateri').modal('hide');
                        $("#formadd")[0].reset();
                        $('#btnadd').val('Submit');
                        $('#btnadd').attr('disabled', false);

                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
                        reload();

                    } else {
                        $('#btnadd').val('Submit');
                        $('#btnadd').attr('disabled', false);
                        var values = '';
                        jQuery.each(response.message, function(key, value) {
                            values += value + '\n'
                        });
                        swal({
                            title: "Maaf",
                            text: values,
                            type: "error",
                        });
                        toastr.error(values);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $('#formaddvids').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/post-vids",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btnaddvids').attr('disabled', 'disabled');
                    $('#btnaddvids').val('Process...');
                },
                success: function(response) {
                    if (response.status == 200) {
                        $('#modaladdvids').modal('hide');
                        $("#formaddvids")[0].reset();
                        $('#btnaddvids').val('Submit');
                        $('#btnaddvids').attr('disabled', false);

                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
                        reload();

                    } else {
                        $('#btnaddvids').val('Submit');
                        $('#btnaddvids').attr('disabled', false);
                        var values = '';
                        jQuery.each(response.message, function(key, value) {
                            values += value + '\n'
                        });
                        swal({
                            title: "Maaf",
                            text: values,
                            type: "error",
                        });
                        toastr.error(values);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $('#formadddocs').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/post-docs",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btnadddocs').attr('disabled', 'disabled');
                    $('#btnadddocs').val('Process...');
                },
                success: function(response) {
                    if (response.status == 200) {
                        $('#modaladddocs').modal('hide');
                        $("#formadddocs")[0].reset();
                        $('#btnadddocs').val('Submit');
                        $('#btnadddocs').attr('disabled', false);

                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
                        reload();

                    } else {
                        $('#btnadddocs').val('Submit');
                        $('#btnadddocs').attr('disabled', false);
                        var values = '';
                        jQuery.each(response.message, function(key, value) {
                            values += value + '\n'
                        });
                        swal({
                            title: "Maaf",
                            text: values,
                            type: "error",
                        });
                        toastr.error(values);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function reload() {
            location.reload();
        }
    </script>
@endsection
