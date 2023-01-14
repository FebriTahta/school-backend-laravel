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
                           
                            <div class="events__sidebar-widget white-bg">
                                <div class="events__sponsor" style="text-align: center">
                                    <h3 class="events__sponsor-title"><h4>30:00 MENIT (CD)</h4></h3>
                                    
                                    <div class="events__sponsor-info">
                                        <h3>Note : </h3>
                                        <h4><span>Usahakan selesaikan seluruh soal sebelum batas waktu pengerjaan habis</span></h4>
                                    </div>

                                    <div class="events__sponsor-info button-nav">
                                        @for ($i = 1; $i <= 20; $i++)
                                            @if (strlen($i) == '1')
                                                @if ($i == '6')
                                                    <a href="#" style="margin: 7px" class="btn btn-sm btn-success"> <span style="font-size: 12px">0{{ $i }}</span> </a>
                                                    @else
                                                    <a href="#" style="margin: 7px" class="btn btn-sm btn-outline-secondary"> <span style="font-size: 12px">0{{ $i }}</span> </a>
                                                @endif
                                            @else
                                            <a href="#" style="margin: 7px" class="btn btn-sm btn-outline-secondary"> <span style="font-size: 12px">{{ $i }}</span> </a>
                                            @endif
                                        @endfor
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
                            <div class="teacher__top d-md-flex align-items-end justify-content-between mb-20">
                                <div class="teacher__info" style="padding: 0; margin: 0">
                                    <h5>No. 06</h5>
                                    <h5 style="font-size: 28px" class="text-capitalize">Apa nama ibu kota indonesia sebelum disahkannya piagam jakarta 45 ?</h5>
                                    <span>"2020 X RPL 1 : Sejarah"</span>
                                </div>
                            </div>

                            <h4>Multiple Choice :</h4>
                            <div class="soal_multi">
                                <h4 style="font-weight: 400"></h4>
                                <div class="option">
                                    <ul>
                                        <li style="line-height: 30px">
                                            <div class="row">
                                                <div class="form-group col-md-1 col-2">
                                                    <input type="radio"> <span> A.</span> 
                                                </div>
                                                <div class="form-group col-md-11 col-10">
                                                    <span >Basuki Djakarta Purnama</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li style="line-height: 30px">
                                            <div class="row">
                                                <div class="form-group col-md-1 col-2">
                                                    <input type="radio"> <span> A.</span> 
                                                </div>
                                                <div class="form-group col-md-11 col-10">
                                                    <span >DKI Djakarta</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li style="line-height: 30px">
                                            <div class="row">
                                                <div class="form-group col-md-1 col-2">
                                                    <input type="radio"> <span> A.</span> 
                                                </div>
                                                <div class="form-group col-md-11 col-10">
                                                    <span >Djakarta Utara</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li style="line-height: 30px">
                                            <div class="row">
                                                <div class="form-group col-md-1 col-2">
                                                    <input type="radio"> <span> A.</span> 
                                                </div>
                                                <div class="form-group col-md-11 col-10">
                                                    <span >Basuki Djakarta Pusat</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li style="line-height: 30px">
                                            <div class="row">
                                                <div class="form-group col-md-1 col-2">
                                                    <input type="radio"> <span> A.</span> 
                                                </div>
                                                <div class="form-group col-md-11 col-10">
                                                    <span >Tanah Abang Indonesia</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="navigation-soal" style="margin-top: 20px">
                                <a href="#" style="float: left; font-size: 20px"><u> Prev </u></a>
                                <a href="#" style="float: right; font-size: 20px"><u> Next </u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection


@section('script')
    
@endsection
