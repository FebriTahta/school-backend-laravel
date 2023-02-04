@extends('fe_layouts.master')

@section('fe_content')
    <main>
        <section class="page__title-area page__title-height page__title-overlay d-flex align-items-center"
            data-background="{{ asset('fe_assets/assets/img/page-title.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="page__title-wrapper mt-110">
                            <h3 class="page__title">{{ $kelas->kelas_name }}
                                {{ $kelas->jurusan->jurusan_name }}
                                {{ $kelas->angkatan->tingkat->tingkat_name }}
                                "{{ $kelas->angkatan->angkatan_name }}"</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Daftar Peringkat</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $siswa_ini->siswa_name }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="course__area pt-120 pb-120">
            <div class="container">
                <div class="course__member mb-45">
                    <div class="course__member mb-45">
                        @foreach ($kelas->siswa as $key=> $item)
                            <div class="course__member-item">
                                <div class="row align-items-center">

                                    <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-8 col-12">
                                        <div class="course__member-thumb d-flex align-items-center">
                                            @if ($item->detailsiswa)
                                            <img src="{{ asset('siswa_image/'.$item->detailsiswa->img_siswa) }}" alt="">    
                                            @else
                                            <img src="{{ asset('fe_assets/assets/img/course/comment/course-comment-1.jpg') }}"
                                            alt="">
                                            @endif
                                            <div class="course__member-name ml-20">
                                                <h5>{{ $item->siswa_name }}</h5>
                                                <span>rata-rata nilai berdasarkan total ujian yang dikerjakan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-4">
                                        <div class="course__member-info pl-45">
                                            @php
                                            
                                            @endphp 
                                            <h5>
                                                AVG : {{ $avg[$key] }}
                                            </h5>
                                            <span>rata-rata</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    
@endsection
