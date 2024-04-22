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
                        Master Klasifikasi
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_klasifikasi" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Nama Klasifikasi</th>
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
    <div class="modal fade" id="modalFormMasterKlasifikasi" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterKlasifikasiTitle">Tambah Master Klasifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-klasifikasi" action="">
                        <input type="hidden" name="kodeklasifikasi">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class='bx bxs-traffic-cone'></i></span>
                            <input type="text" class="form-control" name="klasifikasi" placeholder="Nama Klasifikasi">
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
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script>
        window.datatable_klasifikasi = undefined;

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_klasifikasi.rows('.selected').data().length == 0) {
                    $('#table_klasifikasi tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_klasifikasi.rows('.selected').data()[0];
                $('#modalFormMasterKlasifikasi').modal('show');
                $('#modalFormMasterKlasifikasi').find('.modal-title').html('Edit Master Klasifikasi');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.klasifikasi.show') }}/" + data[3],
                    dataType: "json",
                    success: function(response) {
                        $("#form-klasifikasi").find('[name=kodeklasifikasi]')
                            .val(response.data.kodeklasifikasi);
                        $("#form-klasifikasi").find('[name=klasifikasi]')
                            .val(response.data.klasifikasi);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_klasifikasi.rows('.selected').data().length == 0) {
                    $('#table_klasifikasi tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_klasifikasi.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data master klasifikasi ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.klasifikasi.delete') }}/" + data[3],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_klasifikasi.ajax.reload()
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

        function updateMasterKlasifikasi() {
            data = serializeObject($('#form-klasifikasi'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.klasifikasi.update') }}/" + data.kodeklasifikasi,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_klasifikasi.ajax.reload();
                }
            });
        }

        function saveMasterKlasifikasi() {
            data = serializeObject($('#form-klasifikasi'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.klasifikasi.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_klasifikasi.ajax.reload();
                }
            });
        }
        $(function() {
            $('#table_klasifikasi tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });

            window.datatable_klasifikasi = new DataTable("#table_klasifikasi", {
                ajax: "{{ route('master.klasifikasi.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columnDefer: [{
                    targets: 0,
                    name: 'nomer',
                    searchable: false,
                    orderable: false
                }, {
                    targets: 1,
                    searchable: false,
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

            window.datatable_klasifikasi.on('draw.dt', function() {
                actionData();
            });

            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterKlasifikasi').modal('show');
                $('#modalFormMasterKlasifikasi').find('.modal-title').html('Tambah Master Klasifikasi');
                $("#form-klasifikasi")[0].reset();
            });
            $("#modalFormMasterKlasifikasi").on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('.select2').select2({
                        dropdownParent: $("#modalFormMasterKlasifikasi")
                    });
                }, 100);
            })

            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterKlasifikasi();
                } else {
                    updateMasterKlasifikasi();
                }
            });

            $('.multiple').click(function() {
                saveMasterKlasifikasi();
                $('#modalFormMasterKlasifikasi').modal('show');
                $('#modalFormMasterKlasifikasi').find('.modal-title').html('Tambah Master Klasifikasi');
            });
        });
    </script>
@endpush
