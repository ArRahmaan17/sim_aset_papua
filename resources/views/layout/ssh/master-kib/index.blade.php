@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-header row align-items-center">
                    <div class="col-6 col-md-10">
                        Master Kib
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table-master-kib" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Type</th>
                                    <th>Kode</th>
                                    <th>Kib</th>
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
    <div class="modal fade" id="modalFormMasterMasterKib" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterMasterKibTitle">Tambah Master Kib</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-master-kib" action="">
                        <input type="hidden" name="id">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-menu'></i></span>
                            <input type="text" class="form-control" name="type" placeholder="deskripsi"
                                aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bxs-barcode'></i></span>
                            <input type="text" class="form-control" name="kode" placeholder="kode"
                                aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-group'></i></span>
                            <input type="text" class="form-control" name="kib" placeholder="jenis kib"
                                aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <select name="form" id="">
                                <option value="">Pilih type form</option>
                                <option value="kib_a">Kib A</option>
                                <option value="kib_b">Kib B</option>
                                <option value="kib_c">Kib C</option>
                                <option value="kib_d">Kib D</option>
                                <option value="kib_e">Kib E</option>
                                <option value="kib_f">Kib F</option>
                            </select>
                        </div>
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
    <script>
        window.datatable_master_kib = undefined;

        function updateMasterMasterKib() {
            data = serializeObject($('#form-master-kib'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.master-kib.update') }}/" + data.id,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_master_kib.ajax.reload();
                }
            });
        }

        function saveMasterMasterKib() {
            data = serializeObject($('#form-master-kib'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.master-kib.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_master_kib.ajax.reload();
                }
            });
        }


        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_master_kib.rows('.selected').data().length == 0) {
                    $('#table-master-kib tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_master_kib.rows('.selected').data()[0];
                $('#modalFormMasterMasterKib').modal('show');
                $('#modalFormMasterMasterKib').find('.modal-title').html('Edit Master Kib');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.master-kib.show') }}/" + data[5],
                    dataType: "json",
                    success: function(response) {
                        $("#form-master-kib").find('[name=id]')
                            .val(response.data.id);
                        $("#form-master-kib").find('[name=type]')
                            .val(response.data.type);
                        $("#form-master-kib").find('[name=kode]')
                            .val(response.data.kode);
                        $("#form-master-kib").find('[name=kib]')
                            .val(response.data.kib);
                        $("#form-master-kib").find('[name=form]')
                            .val(response.data.form).trigger('change');
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_master_kib.rows('.selected').data().length == 0) {
                    $('#table-master-kib tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_master_kib.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data master-kib ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.master-kib.delete') }}/" + data[5],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_master_kib.ajax.reload()
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

        $(function() {
            $('#table-master-kib tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_master_kib = new DataTable('#table-master-kib', {
                ajax: "{{ route('master.master-kib.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columns: [{
                    targets: 0,
                    searchable: false,
                    orderable: false
                }, {
                    targets: 1,
                    searchable: true,
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    targets: 2,
                    searchable: true,
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    targets: 3,
                    searchable: true,
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                    }
                }],
            });
            window.datatable_master_kib.on('draw.dt', function() {
                actionData();
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterMasterKib').modal('show');
                $('#modalFormMasterMasterKib').find('.modal-title').html('Tambah Master Kib');
                $("#form-master-kib")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterMasterKib();
                } else {
                    updateMasterMasterKib();
                }
            });
            $('.multiple').click(function() {
                saveMasterMasterKib();
                $('#modalFormMasterMasterKib').modal('show');
                $('#modalFormMasterMasterKib').find('.modal-title').html('Tambah Master Kib');
            });
        });
    </script>
@endpush
