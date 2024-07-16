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
                        Penyedia
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table-penyedia" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Nama Penyedia</th>
                                    <th>Pimpinan</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
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
    <div class="modal fade" id="modalFormPenyedia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormPenyediaTitle">Tambah Penyedia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-penyedia" action="">
                        <input type="hidden" name="id">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-buildings'></i></span>
                            <input type="text" class="form-control" name="nm_penyedia" placeholder="Nama Penyedia" aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bxs-user'></i></span>
                            <input type="text" class="form-control" name="pimpinan" placeholder="Pimpinan" aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-phone'></i></span>
                            <input type="text" class="form-control" name="telp" placeholder="No. telepon" aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-location-plus'></i></span>
                            <textarea name="alamat" class="form-control" placeholder="Alamat" aria-describedby="basic-addon11"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-envelope'></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Email" aria-describedby="basic-addon11">
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
        window.datatable_penyedia = undefined;

        function updatePenyedia() {
            data = serializeObject($('#form-penyedia'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.penyedia.update') }}/" + data.id,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_penyedia.ajax.reload();
                }
            });
        }

        function savePenyedia() {
            data = serializeObject($('#form-penyedia'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.penyedia.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_penyedia.ajax.reload();
                }
            });
        }


        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_penyedia.rows('.selected').data().length == 0) {
                    $('#table-penyedia tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_penyedia.rows('.selected').data()[0];
                $('#modalFormPenyedia').modal('show');
                $('#modalFormPenyedia').find('.modal-title').html('Edit Penyedia');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.penyedia.show') }}/" + data[7],
                    dataType: "json",
                    success: function(response) {
                        $("#form-penyedia").find('[name=id]')
                            .val(response.data.id);
                        $("#form-penyedia").find('[name=nm_penyedia]')
                            .val(response.data.nm_penyedia);
                        $("#form-penyedia").find('[name=pimpinan]')
                            .val(response.data.pimpinan);
                        $("#form-penyedia").find('[name=telp]')
                            .val(response.data.telp);
                        $("#form-penyedia").find('[name=alamat]')
                            .val(response.data.alamat);
                        $("#form-penyedia").find('[name=email]')
                            .val(response.data.email);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_penyedia.rows('.selected').data().length == 0) {
                    $('#table-penyedia tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_penyedia.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data penyedia ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.penyedia.delete') }}/" + data[7],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_penyedia.ajax.reload()
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
            $('#table-penyedia tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_penyedia = new DataTable('#table-penyedia', {
                ajax: "{{ route('master.penyedia.data-table') }}",
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
                    searchable: true,
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    targets: 5,
                    searchable: true,
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    targets: 7,
                    searchable: false,
                    orderable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                    }
                }],
            });
            window.datatable_penyedia.on('draw.dt', function() {
                actionData();
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormPenyedia').modal('show');
                $('#modalFormPenyedia').find('.modal-title').html('Tambah Penyedia');
                $("#form-penyedia")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    savePenyedia();
                } else {
                    updatePenyedia();
                }
            });
            $('.multiple').click(function() {
                savePenyedia();
                $('#modalFormPenyedia').modal('show');
                $('#modalFormPenyedia').find('.modal-title').html('Tambah Penyedia');
            });
        });
    </script>
@endpush
