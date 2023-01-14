@extends('fe_layouts.master2')

@section('fe_content')
    <main>

        <!-- instructor details area start -->
        <section class="teacher__area pt-100 pb-110">
            <div class="page__title-shape">
                <img class="page-title-shape-5 d-none d-sm-block"
                    src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-1.png') }}" alt="">
                <img class="page-title-shape-6" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-6.png') }}"
                    alt="">
                <img class="page-title-shape-3" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-3.png') }}"
                    alt="">
                <img class="page-title-shape-7" src="{{ asset('fe_assets/assets/img/page-title/page-title-shape-4.png') }}"
                    alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                        <div class="teacher__details-thumb p-relative w-img pr-30">
                            <img src="{{ asset('fe_assets/assets/img/teacer-details-1.jpg') }}" alt="">
                            <div class="teacher__details-shape">
                                <img class="teacher-details-shape-1"
                                    src="{{ asset('fe_assets/assets/img/teacher/details/shape/shape-1.png') }}"
                                    alt="">
                                <img class="teacher-details-shape-2"
                                    src="{{ asset('fe_assets/assets/img/teacher/details/shape/shape-2.png') }}"
                                    alt="">
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-4 col-4">
                                    <button data-bs-toggle="modal" data-user_id="{{ $guru->user_id }}"
                                        data-username="{{ $guru->user->username }}" data-pass="{{ $guru->user->pass }}"
                                        data-bs-target="#modaluser" style="width: 100%"
                                        class="btn btn-sm btn-outline-info">credential</button>
                                </div>
                                <div class="col-md-4 col-4">
                                    <button style="width: 100%" class="btn btn-sm btn-outline-primary">photo</button>
                                </div>
                                <div class="col-md-4 col-4">
                                    <button style="width: 100%" class="btn btn-sm btn-outline-success">my bio</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-xl-8 col-lg-8">
                        <div class="teacher__wrapper">
                            <div class="teacher__top d-md-flex align-items-end justify-content-between">
                                <div class="teacher__info">
                                    <h4 class="text-capitalize">{{ $guru->guru_name }}</h4>
                                    <span>Guru SMK 1 Krian Sidoarjo</span> <br>
                                </div>
                            </div>
                            <div class="teacher__bio">
                                <h3>Short Bio</h3>
                                <p>Bapak memiliki tujuan pribadi dalam hidup, yaitu ikut serta mencerdaskan anak bangsa
                                    dibidang ilmu teknologi dan komunikasi dengan cara menjadi guru di salah satu sekolah
                                    kebanggaan Bapak
                                    yaitu SMK 1 Krian. Dengan mengikuti seluruh arahan bapak dengan baik, kalian akan
                                    menjadi manusia yang maju dibidang IPTEK
                                </p>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="teacher__courses pt-55">
                    <div class="section__title-wrapper mb-30">
                        <div class="course__tab-inner grey-bg-2 mb-50">
                            <div class="course__sort d-flex justify-content-sm-end">
                                <div class="course__sort-inner">
                                    <select>
                                        <option>Search Mapel</option>
                                    </select>
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
                                                <img src="{{ asset('assets/lms-default.png') }}" alt=""
                                                    style="max-height: 100%; border-radius: 10px; margin-top: 15px">
                                            @else
                                                <img src="{{ asset('mapl_image/' . $item->image . '') }}" alt="">
                                            @endif
                                        </div>
                                        <div class="course__content" style="max-height: 120px">
                                            <div class="course__meta d-flex align-items-center justify-content-between">
                                                <div class="course__lesson mr-20">
                                                    <span style="margin-right: 10px"><i
                                                            class="far fa-book-alt"></i>{{ $item->docs->count() }}-Docs</span>
                                                    <span style="margin-right: 10px"><i
                                                            class="far fa-video"></i>{{ $item->vids->count() }}-Video</span>
                                                    <span style="margin-right: 10px"><i
                                                            class="far fa-pencil-alt"></i>{{ $item->ujian->count() }}-Soal</span>
                                                </div>
                                            </div>
                                            <h3 class="course__title"><a
                                                    href="/mapel/{{ Crypt::encrypt($item->id) }}">{{ $item->kelas->angkatan->angkatan_name }}
                                                    {{ $item->kelas->angkatan->tingkat->tingkat_name }}
                                                    {{ $item->kelas->jurusan->jurusan_name }}
                                                    {{ $item->kelas->kelas_name }} : {{ $item->mapel->mapel_name }}</a>
                                            </h3>
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

    <div class="modal fade" id="modaluser" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" style="font-size: 16px; color:white">UPDATE DATA USER</h4>
                </div>
                <form id="formupdateuser"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="user_id" id="user_id" class="form-control">
                                    <input type="text" placeholder="username" id="username" name="username"
                                        class="form-control mb-3" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="password" id="pass" name="pass"
                                        class="form-control mb-3" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closemodaluser" class="btn btn-sm btn-default"
                            data-dismiss="modal">Close</button>
                        <input type="submit" id="btnupdateuser" class="btn btn-sm btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

        })

        function reload() {
            location.reload();
        }

        $('#closemodaluser').on('click', function() {
            $('#modaluser').modal('hide');
        })
        $('#modaluser').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var username = button.data('username')
            var pass = button.data('pass')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
            modal.find('.modal-body #pass').val(pass);
        })

        $('#formupdateuser').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/admin-ubah-password",
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
                        $('#btnupdateuser').val('Submit');
                        $('#btnupdateuser').attr('disabled', false);
                        $('#modaluser').modal('hide');
                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
                        // reload();

                    } else {
                        $('#btnupdateuser').val('Submit');
                        $('#btnupdateuser').attr('disabled', false);
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
    </script>
@endsection
