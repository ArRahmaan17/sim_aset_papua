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
                        Master Kelompok
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_kelompok_ssh" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Kelompok</th>
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
    <div class="modal fade" id="modalFormMasterKelompokSsh" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterWarnaTitle">Tambah Master Kelompok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-kelompok" action="">
                        <input type="hidden" name="id">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-palette'></i></span>
                            <input type="text" class="form-control" name="kelompok" placeholder="Kelompok"
                                aria-label="Kelompok" aria-describedby="basic-addon11">
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
        window.datatable_kelompok_ssh = undefined;

        function updateMasterKelompokSsh() {
            data = serializeObject($('#form-kelompok'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.kelompok-ssh.update') }}/" + data.id,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_kelompok_ssh.ajax.reload();
                }
            });
        }

        function saveMasterKelompokSsh() {
            data = serializeObject($('#form-kelompok'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.kelompok-ssh.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_kelompok_ssh.ajax.reload();
                }
            });
        }


        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_kelompok_ssh.rows('.selected').data().length == 0) {
                    $('#table_kelompok_ssh tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_kelompok_ssh.rows('.selected').data()[0];
                $('#modalFormMasterKelompokSsh').modal('show');
                $('#modalFormMasterKelompokSsh').find('.modal-title').html('Edit Master Kelompok');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.kelompok-ssh.show') }}/" + data[3],
                    dataType: "json",
                    success: function(response) {
                        $("#form-kelompok").find('[name=id]')
                            .val(response.data.id);
                        $("#form-kelompok").find('[name=kelompok]')
                            .val(response.data.kelompok);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_kelompok_ssh.rows('.selected').data().length == 0) {
                    $('#table_kelompok_ssh tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_kelompok_ssh.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data Kelompok ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.kelompok-ssh.delete') }}/" + data[3],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_kelompok_ssh.ajax.reload()
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
            $('#table_kelompok_ssh tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_kelompok_ssh = new DataTable('#table_kelompok_ssh', {
                ajax: "{{ route('master.kelompok-ssh.data-table') }}",
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
                    searchable: false,
                    orderable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                    }
                }],
            });
            window.datatable_kelompok_ssh.on('draw.dt', function() {
                actionData();
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterKelompokSsh').modal('show');
                $('#modalFormMasterKelompokSsh').find('.modal-title').html('Tambah Master Kelompok');
                $("#form-kelompok")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterKelompokSsh();
                } else {
                    updateMasterKelompokSsh();
                }
            });
            $('.multiple').click(function() {
                saveMasterKelompokSsh();
                $('#modalFormMasterKelompokSsh').modal('show');
                $('#modalFormMasterKelompokSsh').find('.modal-title').html('Tambah Master Kelompok');
            });
        });
    </script>
@endpush
