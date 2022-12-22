@extends('be_layouts.be_master')

@section('content')
    <div class="page has-sidebar-left bg-light height-full">
        <header class="blue accent-3 relative nav-sticky">
            <div class="container-fluid text-white">
                <div class="row">
                    <div class="col">
                        <h3 class="my-3" style="font-size: 16px">
                            <i class="icon icon-class"></i> Kelas & Jurusan
                        </h3>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid my-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="counter-box white r-5 p-3">
                                <div class="p-4">
                                    <div class="float-right">
                                        <span class="icon icon-note-list text-light-blue s-48"></span>
                                    </div>
                                    <div class="counter-title"><span class="" id="total_jurusan">0</span> : JURUSAN
                                    </div>
                                </div>
                                <div class="progress progress-xs r-0">
                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="128"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="counter-box white r-5 p-3">
                                <div class="p-4">
                                    <div class="float-right">
                                        <span class="icon icon-class text-light-blue s-48"></span>
                                    </div>
                                    <div class="counter-title"> <span class="" id="total_kelas">0</span> : KELAS</div>

                                </div>
                                <div class="progress progress-xs r-0">
                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="128"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    table.dataTable td {
                        padding: 5px;
                    }

                    table.dataTable thead {
                        font-size: 16px !important;
                    }
                </style>
                <div class="col-md-12" style="margin-top: 20px">
                    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modaladd"><i
                            class="icon icon-plus"></i>Kelas / Jurusan</button>
                    <button class="btn btn-xs btn-outline-primary" data-toggle="modal" id="btnjurusan" data-target="#modaljurusan"><i
                            class="icon icon-eye"></i>Tampilkan Daftar Jurusan</button>

                    <div class="row" style="margin-top: 20px">
                        <div class="col-md-8 mb-2">
                            <select name="" id="dropdown-jurusan" class="form-control"
                                style="font-size: 12px"></select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-sm btn-info" style="font-size: 12px" id="reset"><i
                                    class="icon icon-cancel"></i> reset</button>
                        </div>
                    </div>

                    <div class="card my-3 no-b">
                        <div class="card-body">
                            <span>Daftar kelas yang tersedia</span><br>
                            <small>Kelola daftar kelas yang tersedia pada tabel berikut ini</small><br><br>
                            <table id="example" class="table table-bordered table-hover table-striped data-tables">
                                <thead>
                                    <tr>
                                        <th style="width: 7%;font-weight: bold">No</th>
                                        <th style="font-weight: bold">Kelas</th>
                                        <th style="font-weight: bold">Siswa</th>
                                        <th style="font-weight: bold; width: 14%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 12px"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="modaladd" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(93, 154, 233);">
                    <h4 class="modal-title" style="font-size: 16px; color:white">ADD DATA</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formadd"> @csrf
                    <div class="modal-body">
                        <input type="radio" id="new" name="stat" value="new" checked>
                        <label for="new">Jurusan baru</label><br>
                        <input type="radio" id="recent" name="stat" value="recent">
                        <label for="recent">Jurusan yang sudah ada</label><br>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" name="keterangan" id="keterangan"
                                    value="new">
                            </div>
                            <div class="col-md-8 col-8" id="block-new-jurusan" style="padding-right: 5px">
                                <input type="text" style="font-size: 14px" name="jurusan_name" class="form-control"
                                    placeholder="nama jurusan">
                            </div>
                            <div class="col-md-8 col-8" id="block-recent-jurusan" style="display: none">
                                <select name="jurusan_id" class="form-control" id="" style="font-size: 14px">
                                    @foreach ($jurusan as $item)
                                        <option value="{{ $item->id }}">{{ $item->jurusan_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-4" style="padding-left: 5px">
                                <input type="number" style="font-size: 14px" name="total_kelas" class="form-control"
                                    placeholder="total kelas">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" id="btnadd" class="btn btn-sm btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaledit" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(181, 110, 238);">
                    <h4 class="modal-title" style="font-size: 16px; color:white">UPDATE DATA</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formedit"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" id="id" name="id">
                                <input type="hidden" class="form-control" id="jurusan_id" name="jurusan_id">
                            </div>
                            <div class="col-md-8 col-8" id="block-new-jurusan" style="padding-right: 5px">
                                <input type="text" style="font-size: 14px" id="jurusan_name" name="jurusan_name" class="form-control"
                                    placeholder="nama jurusan" readonly>
                            </div>
                            <div class="col-md-4 col-4" style="padding-left: 5px">
                                <input type="number" style="font-size: 14px" id="kelas_name" name="kelas_name" class="form-control"
                                    placeholder="nama kelas">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" id="btnedit" class="btn btn-sm btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaledit2" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(181, 110, 238);">
                    <h4 class="modal-title" style="font-size: 16px; color:white">UPDATE DATA</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formedit2"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" id="id" name="id">
                            </div>
                            <div class="col-md-12 col-12" id="block-new-jurusan" style="padding-right: 5px">
                                <input type="text" style="font-size: 14px" id="jurusan_name" name="jurusan_name" class="form-control"
                                    placeholder="nama jurusan">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" id="btnedit2" class="btn btn-sm btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaldel" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(255, 87, 87);">
                    <h4 class="modal-title" style="font-size: 16px; color:white">REMOVE DATA</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formdel"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" name="id" id="id"
                                    value="new">
                                <code>Yakin menghapus kelas tersebut ?</code><br>
                                <code>Kelas yang memiliki siswa tidak dapat dihapus oleh sistem</code>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" id="btndel" class="btn btn-sm btn-primary" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaldel2" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(255, 87, 87);">
                    <h4 class="modal-title" style="font-size: 16px; color:white">REMOVE DATA</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formdel2"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="form-control" name="id" id="id"
                                    value="new">
                                <code>Yakin menghapus jurusan tersebut ?</code><br>
                                <code>Kelas yang memiliki jurusan tidak dapat dihapus oleh sistem</code>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" id="btndel2" class="btn btn-sm btn-primary" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaljurusan" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 16px">DAFTAR JURUSAN</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table id="example2" class="table table-bordered table-hover table-striped data-tables">
                        <thead>
                            <tr>
                                <th style="font-weight: bold">Jurusan</th>
                                <th style="font-weight: bold">Kelas</th>
                                <th style="font-weight: bold; width: 15%">Opsi</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 12px"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var stat = $('[name="stat"]').val();
            $('[name="stat"]').on('change', function(e) {
                e.preventDefault();
                if (this.value == 'recent') {
                    document.getElementById('block-new-jurusan').style.display = 'none';
                    document.getElementById('block-recent-jurusan').style.display = 'block';
                    $('#keterangan').val('recent');
                } else if (this.value == 'new') {
                    document.getElementById('block-new-jurusan').style.display = 'block';
                    document.getElementById('block-recent-jurusan').style.display = 'none';
                    $('#keterangan').val('new');
                }
            })

            total();
            jurusan_dropdown();
            table_default();

        })

        // end ready function

        function table_default() {
            var table = $('#example').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: "/admin-jurusan-&-kelas",
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'kelas_jurusan',
                        name: 'kelas_jurusan'
                    },
                    {
                        data: 'siswa',
                        name: 'siswa'
                    },
                    {
                        data: 'opsi',
                        name: 'opsi',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        }

        function table_jurusan() {
            var table = $('#example2').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: "/admin-daftar-jurusan",
                columns: [
                    {
                        data: 'jurusan_name',
                        name: 'jurusan_name'
                    },
                    {
                        data: 'total_kelas',
                        name: 'total_kelas'
                    },
                    {
                        data: 'opsi',
                        name: 'opsi',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        }

        function total() {
            $.ajax({
                type: 'GET',
                url: '/admin-total-jurusan-&-kelas',
                success: function(response) {
                    $('#total_jurusan').html(response.data.jurusan);
                    $('#total_kelas').html(response.data.kelas);
                }
            });
        }

        // get value dropdown jurusan
        var val_dropdown;

        function jurusan_dropdown() {
            $.ajax({
                type: 'GET',
                url: '/admin-jurusan-dropdown',
                success: function(response) {
                    $('#dropdown-jurusan').html('<option value="">-- Pilih Jurusan --</option>')
                    $.each(response.data, function(key, value) {
                        $('#dropdown-jurusan').append('<option value="' + value.id + '">' + value
                            .jurusan_name + '</option>')
                    });

                    val_dropdown = null;
                }
            });
        }

        // change dropdown jurusan

        $('#dropdown-jurusan').on('change', function(e) {
            e.preventDefault();
            val_dropdown = this.value;
            if (this.value) {
                var table = $('#example').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    ajax: "/admin-chagne-dropdown-jurusan/" + this.value,
                    columns: [{
                            "data": null,
                            "sortable": false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'kelas_jurusan',
                            name: 'kelas_jurusan'
                        },
                        {
                            data: 'siswa',
                            name: 'siswa'
                        },
                        {
                            data: 'opsi',
                            name: 'opsi',
                            orderable: true,
                            searchable: true
                        },
                    ]
                });

            } else {
                table_default();
            }
        })

        // reset table from dropdown
        $('#reset').on('click', function(e) {
            e.preventDefault();
            if (val_dropdown) {
                jurusan_dropdown();
                table_default();
                toastr.info('Reset & Menampilkan data awal');
            } else {
                toastr.warning('Menampilkan data awal');
            }
        })

        $('#btnjurusan').on('click', function (e) {
            e.preventDefault();
            table_jurusan();
        })

        $('#formadd').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/admin-post-jurusan-&-kelas",
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
                        $('#btnadd').val('Submit');
                        $('#btnadd').attr('disabled', false);

                        document.getElementById('block-new-jurusan').style.display = 'block';
                        document.getElementById('block-recent-jurusan').style.display = 'none';
                        $('#keterangan').val('new');
                        total();

                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
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

        // $(document).ready(function() {
    
        $('#modaledit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var jurusan_name = button.data('jurusan_name')
            var kelas_name = button.data('kelas_name')
            var jurusan_id = button.data('jurusan_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #jurusan_name').val(jurusan_name);
            modal.find('.modal-body #kelas_name').val(kelas_name);
            modal.find('.modal-body #jurusan_id').val(jurusan_id);
        })

        $('#modaledit2').on('show.bs.modal', function(event) {
            $('#modaljurusan').modal('hide');
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var jurusan_name = button.data('jurusan_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #jurusan_name').val(jurusan_name);
        })

        $('#modaldel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })

        $('#modaldel2').on('show.bs.modal', function(event) {
            $('#modaljurusan').modal('hide');
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })

        $('#formedit').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/admin-update-kelas",
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
                        $('#btnedit').val('SUBMIT!');
                        $('#btnedit').attr('disabled', false);
                        toastr.error(response.message);
                        swal({
                            title: "MAAF!",
                            text: response.message,
                            type: "error"
                        });
                    }
                },
            });
        });

        $('#formedit2').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/admin-update-jurusan",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btnedit2').attr('disabled', 'disabled');
                    $('#btnedit2').val('Process...');
                },
                success: function(response) {
                    if (response.status == 200) {
                        var oTable2 = $('#example2').dataTable();
                        var oTable = $('#example').dataTable();
                        oTable2.fnDraw(false);
                        oTable.fnDraw(false);
                        jurusan_dropdown();
                        $('#modaledit2').modal('hide');
                        $("#formedit2")[0].reset();
                        $('#btnedit2').val('UPDATE');
                        $('#btnedit2').attr('disabled', false);
                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
                    } else {
                        $('#btnedit2').val('SUBMIT!');
                        $('#btnedit2').attr('disabled', false);
                        toastr.error(response.message);
                        swal({
                            title: "MAAF!",
                            text: response.message,
                            type: "error"
                        });
                    }
                },
            });
        });

        $('#formdel').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/admin-remove-kelas",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btndel').attr('disabled', 'disabled');
                    $('#btndel').val('Process...');
                },
                success: function(response) {
                    if (response.status == 200) {
                        var oTable = $('#example').dataTable();
                        oTable.fnDraw(false);
                        $('#modaldel').modal('hide');
                        $("#formdel")[0].reset();
                        $('#btndel').val('REMOVE');
                        $('#btndel').attr('disabled', false);
                        total();
                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
                    } else {
                        $("#formdel")[0].reset();
                        $('#btndel').val('REMOVE');
                        $('#btndel').attr('disabled', false);
                        toastr.error(response.message);
                        swal({
                            title: "Maaf!",
                            text: response.message,
                            type: "error"
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $('#formdel2').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "/admin-remove-jurusan",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btndel2').attr('disabled', 'disabled');
                    $('#btndel2').val('Process...');
                },
                success: function(response) {
                    if (response.status == 200) {
                        var oTable2 = $('#example2').dataTable();
                        var oTable = $('#example').dataTable();
                        oTable2.fnDraw(false);
                        oTable.fnDraw(false);
                        jurusan_dropdown();
                        $('#modaldel2').modal('hide');
                        $("#formdel2")[0].reset();
                        $('#btndel2').val('Delete');
                        $('#btndel2').attr('disabled', false);
                        total();
                        toastr.success(response.message);
                        swal({
                            title: "SUCCESS!",
                            text: response.message,
                            type: "success"
                        });
                    } else {
                        $("#formdel2")[0].reset();
                        $('#btndel2').val('REMOVE');
                        $('#btndel2').attr('disabled', false);
                        toastr.error(response.message);
                        swal({
                            title: "Maaf!",
                            text: response.message,
                            type: "error"
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });


        //     });
    </script>
@endsection
