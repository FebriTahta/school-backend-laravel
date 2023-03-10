@extends('be_layouts.be_master')

@section('content')
    <div class="page has-sidebar-left height-full">
        <header class="blue accent-3 relative nav-sticky">
            <div class="container-fluid text-white">
                <div class="row p-t-b-10 ">
                    <div class="col">
                        <h4>
                            <i class="icon-box"></i>
                            Ranking Kelas<p id="gets"></p>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                        <li>
                            <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1">
                                <i class="icon icon-home2"></i>Update ranking kelas pada halaman ini</a>
                        </li>
                    </ul>
                    {{-- <a class="btn-fab absolute fab-right-bottom btn-primary" data-toggle="control-sidebar">
                        <i class="icon icon-menu"></i>
                    </a> --}}
                </div>
            </div>
        </header>
        <div class="container-fluid relative animatedParent animateOnce">
            <div class="tab-content pb-3" id="v-pills-tabContent">
                <!--Today Tab Start-->
                <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
                    <div class="row my-3">
                        



                    </div>
                    <style>
                        td {
                        text-align: left;
                        }
                    </style>
                    <div class="white">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example"
                                    class="responsive nowrap table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">No</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>UTS1</th>
                                            <th>UTS2</th>
                                            <th>UAS1</th>
                                            <th>UAS2</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-capitalize">
                                        {{-- data --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Today Tab End-->
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-xl-2" id="modaladd" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title mt-0" id="myExtraLargeModalLabel" style="color: white">USER BARU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formadd">@csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="radio" class="radio" name="userbaru" id="userguru" value="userguru" checked><label>Guru Baru</label><br>
                            <input type="radio" class="radio" name="userbaru" id="usersiswa" value="usersiswa"><label>Siswa Baru</label>
                        </div>
                        <hr>
                        <div class="div guru" id="divguru">
                            <div class="form-group">
                                <input type="text" class="form-control mb-10" name="guru_name" placeholder="Nama Guru" >
                            </div>
                            <div class="form-group" >
                                <input type="text" class="form-control mb-10" name="guru_nip" placeholder="NIP Guru" >
                            </div>
                        </div>
                        <div class="div siswa" id="divsiswa" style="display: none">
                            <div class="form-group" >
                                <input type="text" class="form-control mb-10" name="siswa_name" placeholder="Nama Siswa" >
                            </div>
                            <div class="form-group" >
                                <input type="text" class="form-control mb-10" name="siswa_nik" placeholder="NIK Siswa" >
                            </div>
                            <div class="form-group" >
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="btnadd" class="btn btn-sm btn-primary" value="SUBMIT">
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade bs-example-modal-xl-2" id="modalrank" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">UPDATE RANKING</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formupdaterank">@csrf
                    <div class="modal-body">
                        <input type="hidden" class="form-control text-capitalize" name="kelas_id" id="kelas"
                            placeholder="id" required>
                        <input type="hidden" class="form-control text-capitalize" name="jenis_exam" id="jenis"
                            placeholder="id" required>
                        <p>Lakukan update Ranking pada Kelas Tersebut ?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="btnupdaterank" class="btn btn-sm btn-primary" value="UPDATE">
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade bs-example-modal-xl-2" id="modaledit" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">UPDATE DATA USER</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formedit">@csrf
                    <div class="modal-body">
                        
                            <div class="card-body" style="margin: auto; ">
                                <div class="logo" style="text-align: center">
                                    <img src="{{ asset('logo1.png') }}" style="max-width: 200px;" alt="">
                                    <p style="padding-right: 10px; padding-left: 10px">Tambahkan anggota user baru untuk
                                        mempermudah manajemen page info lomba official</p>
                                </div>
                                <div class="form" style="margin-top: 30px">

                                    <div class="form-group">
                                        <label><b>Username </b></label>
                                        <input type="hidden" class="form-control" name="id" id="id">
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label><b>Role </b></label>
                                        <select name="role" class="form-control" id="role" required>
                                            <option value=""></option>
                                            <option value="admin">Admin</option>
                                            <option value="super_admin">Super Admin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><b>Password </b></label>
                                        <input type="text" class="form-control" id="pass" name="pass"
                                            required>
                                    </div>


                                </div>
                            </div>
                            
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="btnedit" class="btn btn-sm btn-primary" value="UPDATE">
                    </div>
                </form>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
    <!-- Toast -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <script>
        $(document).ready(function() {

            $('#modalrank').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var kelas = button.data('kelas')
                var jenis = button.data('jenis')
                var modal = $(this)
                modal.find('.modal-body #kelas').val(kelas);
                modal.find('.modal-body #jenis').val(jenis);
            })

            $('#modaledit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var username = button.data('username')
                var role = button.data('role')
                var pass = button.data('pass')
                var modal = $(this)
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #username').val(username);
                modal.find('.modal-body #role').val(role);
                modal.find('.modal-body #pass').val(pass);
            })

            $('#formupdaterank').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "/update-ranking-kelas",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btnupdaterank').attr('disabled', 'disabled');
                        $('#btnupdaterank').val('Process...');
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                            $('#modalrank').modal('hide');
                            $("#formupdaterank")[0].reset();
                            $('#btnupdaterank').val('REMOVE');
                            $('#btnupdaterank').attr('disabled', false);
                            toastr.info(response.message);
                            swal({
                                title: "SUCCESS!",
                                text: response.message,
                                type: "info"
                            });
                        } else {
                            $('#btnupdaterank').val('Update');
                            $('#btnupdaterank').attr('disabled', false);
                            toastr.error(response.message);
                            $('#errList').html("");
                            $('#errList').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#errList').append('<div>' + err_values + '</div>');
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $('#formadd').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "/admin-user-baru",
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
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                            $('#modaladd').modal('hide');
                            $("#formadd")[0].reset();
                            $('#btnadd').val('SUBMIT');
                            $('#btnadd').attr('disabled', false);
                            toastr.success(response.message);
                            swal({
                                title: "SUCCESS!",
                                text: response.message,
                                type: "success"
                            });
                        } else {
                            $("#formadd")[0].reset();
                            $('#btnadd').val('SUBMIT!');
                            $('#btnadd').attr('disabled', false);
                            toastr.error(response.message);
                            $('#errList').html("");
                            $('#errList').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#errList').append('<div>' + err_values + '</div>');
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $('#formedit').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "/backend-store-user",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btnedit').attr('disabled', 'disabled');
                        $('#btnedit').val('Process...');
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            var oTable = $('#example').dataTable();
                            oTable.fnDraw(false);
                            $('#modaledit').modal('hide');
                            $("#formedit")[0].reset();
                            $('#btnedit').val('UPDATE');
                            $('#btnedit').attr('disabled', false);
                            toastr.success(response.message);
                            swal({
                                title: "SUCCESS!",
                                text: response.message,
                                type: "success"
                            });
                        } else {
                            $("#formedit")[0].reset();
                            $('#btnedit').val('SUBMIT!');
                            $('#btnedit').attr('disabled', false);
                            toastr.error(response.message);
                            $('#errList').html("");
                            $('#errList').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#errList').append('<div>' + err_values + '</div>');
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            var table = $('#example').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: "/daftar-ranking-kelas",
                columns: [{
                        "width": 10,
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'angkatan_kelas',
                        name: 'angkatan_kelas'
                    },
                    {
                        data: 'kelas_jurusan',
                        name: 'kelas_jurusan'
                    },
                    {
                        data: 'uts1',
                        name: 'uts1'
                    },
                    {
                        data: 'uts2',
                        name: 'uts2'
                    },
                    {
                        data: 'uas1',
                        name: 'uas1'
                    },
                    {
                        data: 'uas2',
                        name: 'uas2'
                    },
                ]
            });
        });

        
    </script>
@endsection
