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
                        Master Masa Manfaaat
                    </div>
                    <div class="col-6 col-md-2">
                        <button
                            class="btn btn-success add {{ $data->jumlah_masa == $data->jumlah_barang ? 'disabled' : '' }}"
                            type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_masamanfaat" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Kodebarang & Urai</th>
                                    <th>Tahun Masa Manfaat</th>
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
    <div class="modal fade" id="modalFormMasterMasaManfaat" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterWarnaTitle">Tambah Master Warna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap d-none col-12">
                        <table class="table table-striped data-table" id="barang_belum_masamanfaat"
                            style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Kodebarang & Urai</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <form id="form-masamanfaat" action="">
                        <input type="hidden" name="kodemasamanfaat">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-palette'></i></span>
                            <input type="text" class="form-control money-mask" name="masamanfaat" placeholder="6">
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
        window.datatable_masamanfaat = undefined
        window.datatable_belum = undefined

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_masamanfaat.rows('.selected').data().length == 0) {
                    $('#table_masamanfaat tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_masamanfaat.rows('.selected').data()[0];
                $('#modalFormMasterMasaManfaat').modal('show');
                $('#modalFormMasterMasaManfaat').find('.modal-title').html('Edit Master Masa Manfaat');
                $('#modalFormMasterMasaManfaat').find('.table-responsive').addClass('d-none')
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.masamanfaat.show') }}/" + data[4],
                    dataType: "json",
                    success: function(response) {
                        $("#form-masamanfaat").find('[name=kodemasamanfaat]')
                            .val(response.data.kodemasamanfaat);
                        $("#form-masamanfaat").find('[name=masamanfaat]')
                            .val(response.data.masamanfaat);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_masamanfaat.rows('.selected').data().length == 0) {
                    $('#table_masamanfaat tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_masamanfaat.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data masa manfaat ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.masamanfaat.delete') }}/" + data[4],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_masamanfaat.ajax.reload()
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

        function updateMasterWarna() {
            data = serializeObject($('#form-masamanfaat'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.masamanfaat.update') }}/" + data.kodemasamanfaat,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_masamanfaat.ajax.reload()
                }
            });
        }

        function saveMasterWarna() {
            var data = serializeObject($('#form-masamanfaat'));
            if (window.datatable_belum.rows('.selected').data().length == 0) {
                $('#barang_belum_masamanfaat tbody').find('tr').removeClass('selected');
                $(this).parents('tr').addClass('selected')
            }
            data = {
                ...data,
                kode: window.datatable_belum.rows('.selected').data()[0][1]
            }
            $.ajax({
                type: "POST",
                url: "{{ route('master.masamanfaat.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_masamanfaat.ajax.reload();
                }
            });
        }

        $(function() {
            $('#table_masamanfaat tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            $('#barang_belum_masamanfaat tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_masamanfaat = new DataTable('#table_masamanfaat', {
                ajax: "{{ route('master.masamanfaat.data-table') }}",
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
                    name: 'kodebarang_urai',
                    searchable: false,
                    orderable: true
                }, {
                    targets: 2,
                    name: 'masamanfaat',
                    searchable: false,
                    orderable: false,
                }, {
                    targets: 3,
                    name: 'aksi',
                    searchable: false,
                    orderable: false
                }],
            });
            window.datatable_masamanfaat.on('draw.dt', function() {
                actionData();
            });
            window.datatable_belum = new DataTable('#barang_belum_masamanfaat', {
                ajax: "{{ route('master.masamanfaat.data-belum-masamanfaat') }}",
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
                    name: 'kodebarang_urai',
                    searchable: false,
                    orderable: true
                }],
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterMasaManfaat').modal('show');
                $('#modalFormMasterMasaManfaat').find('.modal-title').html('Edit Master Warna');
                $('#modalFormMasterMasaManfaat').find('.table-responsive').removeClass('d-none');
                window.datatable_belum.ajax.reload();
                $("#form-masamanfaat")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterWarna();
                } else {
                    updateMasterWarna();
                }
            });
            $('.multiple').click(function() {
                saveMasterWarna();
                $('#modalFormMasterWarna').modal('show');
                $('#modalFormMasterWarna').find('.modal-title').html('Tambah Master Warna');
            });
            $('.money-mask').attr('maxlength', '2').inputmask('numeric', {
                radixPoint: ",",
                allowMinus: false,
                regex: "[0-9]*",
                groupSeparator: ".",
                rightAlign: false,
                digits: 2,
                min: 0,
                alias: 'numeric'
            });
        });
    </script>
@endpush
