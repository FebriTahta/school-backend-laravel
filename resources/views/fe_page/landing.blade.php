@extends('fe_layouts.master')

@section('fe_content')
    <main>
        <section class="page__title-area page__title-height page__title-overlay d-flex align-items-center"
            data-background="{{ asset('fe_assets/assets/img/page-title.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="page__title-wrapper mt-110">
                            <h3 class="page__title">{{ $siswa->kelas->jurusan->jurusan_name }}
                                {{ $siswa->kelas->angkatan->tingkat->tingkat_name }}
                                "{{ $siswa->kelas->angkatan->angkatan_name }}"</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Mapel Room</li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $siswa->siswa_name }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="course__area pt-120 pb-120">
            <div class="container">
                <div class="course__tab-inner grey-bg-2 mb-50">
                    <div class="row align-items-center">
                        {{-- <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="course__tab-wrapper d-flex align-items-center">
                                <div class="course__tab-btn">
                                    <ul class="nav nav-tabs" id="courseTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link list active" id="list-tab" data-bs-toggle="tab"
                                                data-bs-target="#list" type="button" role="tab" aria-controls="list"
                                                aria-selected="false">
                                                <svg class="list" viewBox="0 0 512 512">
                                                    <g id="Layer_2_1_">
                                                        <path class="st0"
                                                            d="M448,69H192c-17.7,0-32,13.9-32,31s14.3,31,32,31h256c17.7,0,32-13.9,32-31S465.7,69,448,69z" />
                                                        <circle class="st0" cx="64" cy="100"
                                                            r="31" />
                                                        <path class="st0"
                                                            d="M448,225H192c-17.7,0-32,13.9-32,31s14.3,31,32,31h256c17.7,0,32-13.9,32-31S465.7,225,448,225z" />
                                                        <circle class="st0" cx="64" cy="256"
                                                            r="31" />
                                                        <path class="st0"
                                                            d="M448,381H192c-17.7,0-32,13.9-32,31s14.3,31,32,31h256c17.7,0,32-13.9,32-31S465.7,381,448,381z" />
                                                        <circle class="st0" cx="64" cy="412"
                                                            r="31" />
                                                    </g>
                                                </svg>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" >
                            <div class="course__sort d-flex justify-content-sm-end">
                                <div class="course__sort-inner">
                                    <select>
                                        <option>Search Mapel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="course__tab-conent">
                            <div class="tab-content" id="courseTabContent">
                                <div class="tab-pane fade show active" id="list" role="tabpanel"
                                    aria-labelledby="list-tab">
                                    <div class="row">
                                        @foreach ($siswa->kelas->mapel as $item)
                                            <div class="col-xxl-12">
                                                <div class="course__item white-bg mb-30 fix">
                                                    <div class="row gx-0">
                                                        <div class="col-xxl-4 col-xl-4 col-lg-4">
                                                            <div class="course__thumb course__thumb-list w-img p-relative fix"
                                                                style="padding: 10px">
                                                                <a href="#">
                                                                    @if ($item->image == null || $item->image == '')
                                                                        <img src="{{ asset('assets/lms-default.png') }}"
                                                                            alt=""
                                                                            style="max-height: 100%; border-radius: 10px; margin-top: 15px">
                                                                    @else
                                                                        <img src="{{ asset('mapl_image/' . $item->image . '') }}"
                                                                            alt="">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-8 col-xl-8 col-lg-8">
                                                            <div class="course__right">
                                                                <div class="course__content ">
                                                                    <div class="course__meta d-flex align-items-center"
                                                                        style="padding: 0">
                                                                        <div class="course__lesson mr-20">
                                                                            <span style="margin-right: 10px"><i
                                                                                    class="far fa-book-alt"></i>10-Docc</span>
                                                                            <span style="margin-right: 10px"><i
                                                                                    class="far fa-video"></i>10-Video</span>
                                                                            <span style="margin-right: 10px"><i
                                                                                    class="far fa-pencil-alt"></i>10-Quiz</span>
                                                                        </div>
                                                                    </div>
                                                                    <h3 class="course__title course__title-3"
                                                                        style="margin: 0">
                                                                        <a style="font-size: 18px"
                                                                            href="course-details.html">{{ $item->mapel_name }}</a>
                                                                    </h3>
                                                                    <div class="course__summary">
                                                                        <p style="font-size: 14px" style="margin: 0">Simak &
                                                                            Pelajari secara seksama materi yang disajikan
                                                                            dalam mata pelajaran ini untuk menunjang
                                                                            pemahaman serta nilai ujian.</p>
                                                                        <div class="course__teacher d-flex align-items-center"
                                                                            style="margin: 0">
                                                                            <div class="course__teacher-thumb mr-15">
                                                                                <img src="{{ asset('fe_assets/assets/img/contact/contact-shape-4.png') }}"
                                                                                    alt="">
                                                                            </div>
                                                                            <h6 style="margin: 0"><a
                                                                                    href="instructor-details.html">Bu
                                                                                    Susi</a>
                                                                            </h6>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
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
        </section>
    </main>
@endsection
