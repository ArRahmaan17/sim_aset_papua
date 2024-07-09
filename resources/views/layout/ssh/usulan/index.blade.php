@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jstree.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-header row align-items-center">
                    <div class="col-12 col-md-7 col-lg-8">
                        List Usulan
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 text-end">
                        {{-- <a href="{{ route('usulan.download-pakta') }}" target="_blank" class="btn btn-success"><i
                                class='bx bxs-download'></i> Download Pakta</a> --}}
                        <a class="btn btn-success text-white"><i class='bx bxs-download'></i> Download Pakta</a>
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-plus mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_usulan" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nomer</th>
                                    <th>Tahun</th>
                                    <th>Usulan</th>
                                    <th>Pakta</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFormMasterUsulan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterWarnaTitle">Tambah Usulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-usulan" action="">
                        <div class="divider">
                            <div class="divider-text">Usulan</div>
                        </div>
                        <input type="hidden" name="id">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                            <input type="text" class="form-control" name="tahun" placeholder="Tahun Usulan"
                                aria-label="Tahun Usulan" aria-describedby="basic-addon11">
                        </div>
                        <select name="induk_perubahan" id="induk_perubahan" class="form-select mb-3">
                            <option value="">Pilih Jenis Usulan</option>
                            <option value="1">Induk</option>
                            <option value="2">Perubahan</option>
                        </select>
                        <div class="input-group mb-3">
                            <label for="ssd_dokumen" class="input-group-text"><i class='bx bxs-file-pdf'></i></label>
                            <input class="form-control" type="file" accept="application/pdf" id="ssd_dokumen">
                        </div>
                        <div class="divider">
                            <div class="divider-text">List rincian usulan</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr role="row">
                                        <td>No</td>
                                        <td>Kode Barang</td>
                                        <td>Nama Barang</td>
                                        <td>Uraian</td>
                                        <td>Spesfikasi</td>
                                        <td>Satuan</td>
                                        <td>Harga</td>
                                        <td>Rekening</td>
                                        <td>TKDN</td>
                                        <td>Jenis</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row">
                                        <td colspan="10" class="text-center">Belum Ada Data</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="divider">
                                    <div class="divider-text">Rincian usulan</div>
                                </div>
                                <div class="mb-3">
                                    <select name="id_barang" id="id_barang" class="select2 form-select">
                                        <option value="">Pilih Barang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Uraian">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Spesifikasi">
                                </div>
                                <div class="mb-3">
                                    <select name="id_satuan" id="id_satuan" class="select2 form-select">
                                        <option value="">Pilih Satuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Harga">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="TKDN">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="divider">
                                    <div class="divider-text">Rekening rincian usulan</div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 1</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 2</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 3</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 4</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 6</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 7</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 8</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 9</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="" id="" class="select2 form-select">
                                                <option value="">Pilih Rekening 10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning"><i class='bx bx-plus'></i>Rincian</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success align-middle single" data-bs-dismiss="modal">
                        <i class='tf-icons bx bx-save mb-1'></i> Close And Save
                    </button>
                    <button type="button" class="btn btn-outline-warning align-middle multiple" data-bs-dismiss="modal">
                        <i class='tf-icons bx bxs-add-to-queue mb-1'></i> Save And Add More
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/jstree.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        window.datatable_usulan = undefined;


        function updateMasterUsualan() {
            data = serializeObject($('#form-usulan'));
            $.ajax({
                type: "PUT",
                url: "{{ route('usulan.update') }}/" + data.id,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_usulan.ajax.reload();
                }
            });
        }

        function saveMasterUsulan() {
            data = serializeObject($('#form-usulan'));
            $.ajax({
                type: "POST",
                url: "{{ route('usulan.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_usulan.ajax.reload();
                }
            });
        }


        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_usulan.rows('.selected').data().length == 0) {
                    $('#table_usulan tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_usulan.rows('.selected').data()[0];
                $('#modalFormMasterUsulan').modal('show');
                $('#modalFormMasterUsulan').find('.modal-title').html('Edit Usulan');
                $.ajax({
                    type: "GET",
                    url: "{{ route('usulan.show') }}/" + data[5],
                    dataType: "json",
                    success: function(response) {
                        $("#form-usulan").find('[name=id]')
                            .val(response.data.id);
                        $("#form-usulan").find('[name=usulan]')
                            .val(response.data.usulan);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_usulan.rows('.selected').data().length == 0) {
                    $('#table_usulan tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_usulan.rows('.selected').data()[0];
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    color: 'red',
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan menghapus data usulan ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('usulan.delete') }}/" + data[5],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_usulan.ajax.reload()
                                }
                            });
                        }, true],
                        ['<button>TIDAK</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }],
                    ],
                });
            });
        }

        function detail_table(d) {
            var html = '';
            d[6].forEach((element, index) => {
                html += `
                <tr>
                    <td>${index+1}</td>
                    <td>${element.persentase_awal} %</td>
                    <td>${element.persentase_akhir} %</td>
                    <td>${element.tahunmasamanfaat} Tahun</td>
                </tr>`
            });
            return (
                `<div class='table-responsive'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Uraian</th>
                                <th>Spesifikasi</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Rekening</th>
                                <th>TKDN</th>
                                <th>Aksi</th>
                                <th>Jenis</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${html}
                        </tbody>
                    </table>
                </div>`
            );
        }
        $(function() {
            $('#table_usulan tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_usulan = new DataTable('#table_usulan', {
                ajax: "{{ route('usulan.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [2, 'desc']
                ],
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        width: '5%'
                    },
                    {
                        orderable: false,
                        width: '5%'
                    },
                    {
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    }, {
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    }, {
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    },
                    {
                        orderable: false,
                        render: (data, type, row, meta) => {
                            return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                        }
                    },
                ],
            });
            window.datatable_usulan.on('draw.dt', function() {
                actionData();
            });
            window.datatable_usulan.on('click', 'td.dt-control', function(e) {
                let tr = e.target.closest('tr');
                let row = window.datatable_usulan.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(detail_table(row.data())).show();
                }
            });
            $("#modalFormMasterUsulan").on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('.select2').select2({
                        dropdownParent: $("#modalFormMasterUsulan")
                    });
                }, 100);
            })

            $.ajax({
                type: "GET",
                url: `{{ route('master.data.barang') }}`,
                dataType: "json",
                success: function(response) {
                    $('#id_barang').html(response.html_barang);
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.satuan') }}`,
                dataType: "json",
                success: function(response) {
                    $('#id_satuan').html(response.html_satuan);
                }
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterUsulan').modal('show');
                $('#modalFormMasterUsulan').find('.modal-title').html('Tambah Usulan');
                $("#form-usulan")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterUsulan();
                } else {
                    updateMasterUsualan();
                }
            });
            $('.multiple').click(function() {
                saveMasterUsulan();
                $('#modalFormMasterUsulan').modal('show');
                $('#modalFormMasterUsulan').find('.modal-title').html('Tambah Usulan');
            });
        });
    </script>
@endpush
