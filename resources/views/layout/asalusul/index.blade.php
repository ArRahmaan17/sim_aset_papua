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
                        Master Asal Usul
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_asalusul" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Kategori Asal Usul</th>
                                    <th>Nama Asal Usul</th>
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
    <div class="modal fade" id="modalFormMasterAsalUsul" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterAsalUsulTitle">Tambah Master Asal Usul</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-asalusul" action="">
                        <input type="hidden" name="kodeasalusul">
                        <div class="mb-3">
                            <select name="kategori" class="select2 form-control">
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class='bx bxs-traffic-cone'></i></span>
                            <input type="text" class="form-control" name="asalusul" placeholder="Nama Asal Usul">
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
        window.datatable_asalusul = undefined;

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_asalusul.rows('.selected').data().length == 0) {
                    $('#table_asalusul tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_asalusul.rows('.selected').data()[0];
                $('#modalFormMasterAsalUsul').modal('show');
                $('#modalFormMasterAsalUsul').find('.modal-title').html('Edit Master Asal Usul');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.asal-usul.show') }}/" + data[4],
                    dataType: "json",
                    success: function(response) {
                        $("#form-asalusul").find('[name=kodeasalusul]')
                            .val(response.data.kodeasalusul);
                        $("#form-asalusul").find('[name=asalusul]')
                            .val(response.data.asalusul);
                        $("#form-asalusul").find('[name=kategori]')
                            .val(response.data.kategori);
                        $("#form-asalusul").find('[name=kategori]').prop('disabled', true);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_asalusul.rows('.selected').data().length == 0) {
                    $('#table_asalusul tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_asalusul.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data master asalusul ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.asal-usul.delete') }}/" + data[4],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_asalusul.ajax.reload()
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

        function updateMasterAsalUsul() {
            data = serializeObject($('#form-asalusul'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.asal-usul.update') }}/" + data.kodeasalusul,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_asalusul.ajax.reload();
                }
            });
        }

        function saveMasterAsalUsul() {
            data = serializeObject($('#form-asalusul'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.asal-usul.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_asalusul.ajax.reload();
                }
            });
        }
        $(function() {
            $('#table_asalusul tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });

            window.datatable_asalusul = new DataTable("#table_asalusul", {
                ajax: "{{ route('master.asal-usul.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columns: [{
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

            window.datatable_asalusul.on('draw.dt', function() {
                actionData();
            });

            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterAsalUsul').modal('show');
                $('#modalFormMasterAsalUsul').find('.modal-title').html('Tambah Master Asal Usul');
                $("#form-asalusul")[0].reset();
                $("#form-asalusul").find('[name=kategori]').prop('disabled', false);
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.asal-usul.useable') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kategori]').html(response.data);
                }
            });
            $("#modalFormMasterAsalUsul").on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('.select2').select2({
                        dropdownParent: $("#modalFormMasterAsalUsul")
                    });
                }, 100);
            })

            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterAsalUsul();
                } else {
                    updateMasterAsalUsul();
                }
            });

            $('.multiple').click(function() {
                saveMasterAsalUsul();
                $('#modalFormMasterAsalUsul').modal('show');
                $('#modalFormMasterAsalUsul').find('.modal-title').html('Tambah Master Asal Usul');
            });
        });
    </script>
@endpush
