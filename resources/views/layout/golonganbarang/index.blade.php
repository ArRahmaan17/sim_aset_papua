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
                        Master Warna
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_golongan_barang" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Golongan Barang</th>
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
    <div class="modal fade" id="modalFormMasterGolonganBarang" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterGolonganBarangTitle">Tambah Master Golongan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-golongan-barang" action="">
                        <input type="hidden" name="kodegolonganbarang">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-palette'></i></span>
                            <input type="text" class="form-control" name="golonganbarang" placeholder="Tanah Keluarga">
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
        window.datatable_golongan_barang = undefined;

        function updateMasterGolonganBarang() {
            data = serializeObject($('#form-golongan-barang'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.golonganbarang.update') }}/" + data.kodegolonganbarang,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_golongan_barang.ajax.reload();
                }
            });
        }

        function saveMasterGolonganBarang() {
            data = serializeObject($('#form-golongan-barang'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.golonganbarang.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_golongan_barang.ajax.reload();
                }
            });
        }


        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_golongan_barang.rows('.selected').data().length == 0) {
                    $('#table_golongan_barang tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_golongan_barang.rows('.selected').data()[0];
                $('#modalFormMasterGolonganBarang').modal('show');
                $('#modalFormMasterGolonganBarang').find('.modal-title').html('Edit Master Golongan Barang');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.golonganbarang.show') }}/" + data[3],
                    dataType: "json",
                    success: function(response) {
                        $("#form-golongan-barang").find('[name=kodegolonganbarang]')
                            .val(response.data.kodegolonganbarang);
                        $("#form-golongan-barang").find('[name=golonganbarang]')
                            .val(response.data.golonganbarang);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_golongan_barang.rows('.selected').data().length == 0) {
                    $('#table_golongan_barang tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_golongan_barang.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data golongan barang ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.golonganbarang.delete') }}/" + data[
                                    3],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_golongan_barang.ajax.reload()
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
            $('#table_golongan_barang tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_golongan_barang = new DataTable('#table_golongan_barang', {
                ajax: "{{ route('master.golonganbarang.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columnDefer: [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
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
            window.datatable_golongan_barang.on('draw.dt', function() {
                actionData();
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterGolonganBarang').modal('show');
                $('#modalFormMasterGolonganBarang').find('.modal-title').html(
                    'Edit Master Golongan Barang');
                $("#form-golongan-barang")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterGolonganBarang();
                } else {
                    updateMasterGolonganBarang();
                }
            });
            $('.multiple').click(function() {
                saveMasterGolonganBarang();
                $('#modalFormMasterGolonganBarang').modal('show');
                $('#modalFormMasterGolonganBarang').find('.modal-title').html(
                    'Tambah Master Golongan Barang');
            });
        });
    </script>
@endpush
