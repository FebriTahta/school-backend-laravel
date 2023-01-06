@extends('fe_layouts.master2')

@section('fe_content')
<main>

    <!-- instructor details area start -->
    <section class="teacher__area pt-100 pb-110">
       <div class="page__title-shape">
          <img class="page-title-shape-5 d-none d-sm-block" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-1.png') }}" alt="">
          <img class="page-title-shape-6" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-6.png') }}" alt="">
          <img class="page-title-shape-3" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-3.png') }}" alt="">
          <img class="page-title-shape-7" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-4.png') }}" alt="">
       </div>
       <div class="container">
          <div class="row">
             <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                <div class="teacher__details-thumb p-relative w-img pr-30">
                   <img src="{{ asset('fe_assets/assets/img/teacer-details-1.jpg') }}" alt="">
                   <div class="teacher__details-shape">
                      <img class="teacher-details-shape-1" src="{{ asset('fe_assets/assets/img/teacher/details/shape/shape-1.png') }}" alt="">
                      <img class="teacher-details-shape-2" src="{{ asset('fe_assets/assets/img/teacher/details/shape/shape-2.png') }}" alt="">
                   </div>
                </div>
             </div>
             <div class="col-xxl-8 col-xl-8 col-lg-8">
                <div class="teacher__wrapper">
                   <div class="teacher__top d-md-flex align-items-end justify-content-between">
                      <div class="teacher__info">
                         <h4 class="text-capitalize">{{ $guru->guru_name }}</h4>
                         <span>Guru SMK 1 Krian Sidoarjo</span>
                      </div>
                   </div>
                   <div class="teacher__bio">
                      <h3>Short Bio</h3>
                      <p>Bapak memiliki tujuan pribadi dalam hidup, yaitu ikut serta mencerdaskan anak bangsa dibidang ilmu teknologi dan komunikasi dengan cara menjadi guru di salah satu sekolah kebanggaan Bapak
                         yaitu SMK 1 Krian. Dengan mengikuti seluruh arahan bapak dengan baik, kalian akan menjadi manusia yang maju dibidang IPTEK
                      </p>
                   </div>
                   
                </div>
                
             </div>
          </div>
          <div class="teacher__courses pt-55">
             <div class="section__title-wrapper mb-30">
                <div class="row">
                   <div class="col-md-8">
                      <h2 class="section__title">Materi <span class="yellow-bg yellow-bg-big">Pengajar<img src="assets/img/shape/yellow-bg.png" alt=""></span></h2>
                   </div>
                   <div class="col-md-4">
                      <div class="sidebar__search p-relative">
                         <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><i class="fad fa-search"></i></button>
                         </form>
                      </div>
                   </div>
                </div>
                
                
             </div>
             
             <div class="teacher__course-wrapper">
                <div class="row">
                   @foreach ($guru->mapelmaster as $item)
                     
                     <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                        <div class="course__item white-bg mb-30 fix">
                           <div class="course__thumb w-img p-relative fix">
                              @if ($item->image == null || $item->image == '')
                              <img src="{{ asset('assets/lms-default.png') }}"
                                 alt=""
                                 style="max-height: 100%; border-radius: 10px; margin-top: 15px">
                              @else
                                 <img src="{{ asset('mapl_image/' . $item->image . '') }}"
                                    alt="">
                              @endif
                           </div>
                           <div class="course__content" style="max-height: 120px">
                              <div class="course__meta d-flex align-items-center justify-content-between">
                                 <div class="course__lesson">
                                    <span style="font-size: 14px; margin-right: 10px"><i class="far fa-book-alt"></i>72 Materi</span>
                                 </div>
                              </div>
                              <h3 class="course__title"><a href="/mapel/{{ $item->id }}">{{ $item->kelas->angkatan->angkatan_name }} {{ $item->kelas->angkatan->tingkat->tingkat_name }} {{ $item->kelas->jurusan->jurusan_name }} {{ $item->kelas->kelas_name }} : {{ $item->mapel->mapel_name }}</a></h3>
                           </div>
                        </div>
                     </div>
                   @endforeach
                </div>
             </div>
          </div>
       </div>
       
    </section>

    

 </main>
@endsection
