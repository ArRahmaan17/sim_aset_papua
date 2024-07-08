@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-header row align-items-center">
                    <div class="col-6 col-md-10">
                        Master Jenis Aset
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table-jenis-aset" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Jenis Aset</th>
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
    <div class="modal fade" id="modalFormMasterHakTanah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterHakTanahTitle">Tambah Master Jenis Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-jenis-aset" action="">
                        <input type="hidden" name="id">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-palette'></i></span>
                            <input type="text" class="form-control" name="jenis" placeholder="Jenis Aset"
                                aria-label="Jenis Aset" aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <select name="id_master" id="id_master" class="select2 form-select">
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
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script>
        window.datatable_jenis_aset = undefined;

        function updateMasterHakTanah() {
            data = serializeObject($('#form-jenis-aset'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.jenis-aset.update') }}/" + data.id,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_jenis_aset.ajax.reload();
                }
            });
        }

        function saveMasterHakTanah() {
            data = serializeObject($('#form-jenis-aset'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.jenis-aset.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_jenis_aset.ajax.reload();
                }
            });
        }


        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_jenis_aset.rows('.selected').data().length == 0) {
                    $('#table-jenis-aset tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_jenis_aset.rows('.selected').data()[0];
                $('#modalFormMasterHakTanah').modal('show');
                $('#modalFormMasterHakTanah').find('.modal-title').html('Edit Master Jenis Aset');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.jenis-aset.show') }}/" + data[4],
                    dataType: "json",
                    success: function(response) {
                        $("#form-jenis-aset").find('[name=id]')
                            .val(response.data.id);
                        $("#form-jenis-aset").find('[name=jenis]')
                            .val(response.data.jenis);
                        $("#form-jenis-aset").find('[name=id_master]')
                            .val(response.data.id_master);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_jenis_aset.rows('.selected').data().length == 0) {
                    $('#table-jenis-aset tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_jenis_aset.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data jenis-aset ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.jenis-aset.delete') }}/" + data[4],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_jenis_aset.ajax.reload()
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
            $('#table-jenis-aset tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            $("#modalFormMasterHakTanah").on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('.select2').select2({
                        dropdownParent: $("#modalFormMasterHakTanah")
                    });
                }, 100);
            })
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.kib_master') }}`,
                dataType: "json",
                success: function(response) {
                    $('#id_master').html(response.html_kib_master)
                }
            });
            window.datatable_jenis_aset = new DataTable('#table-jenis-aset', {
                ajax: "{{ route('master.jenis-aset.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columnDefer: [{
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
                    searchable: false,
                    orderable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                    }
                }],
            });
            window.datatable_jenis_aset.on('draw.dt', function() {
                actionData();
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterHakTanah').modal('show');
                $('#modalFormMasterHakTanah').find('.modal-title').html('Tambah Master Jenis Aset');
                $("#form-jenis-aset")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterHakTanah();
                } else {
                    updateMasterHakTanah();
                }
            });
            $('.multiple').click(function() {
                saveMasterHakTanah();
                $('#modalFormMasterHakTanah').modal('show');
                $('#modalFormMasterHakTanah').find('.modal-title').html('Tambah Master Jenis Aset');
            });
        });
    </script>
@endpush
