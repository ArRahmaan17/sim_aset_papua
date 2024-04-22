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
                        Master Kapitalisasi
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_kapitalisasi" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Nama Kapitalisasi</th>
                                    <th>Nilai Kapitalisasi</th>
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
    <div class="modal fade" id="modalFormMasterKapitalisasi" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterKapitalisasiTitle">Tambah Master Kapitalisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-kapitalisasi" action="">
                        <input type="hidden" name="kodekapitalisasi">
                        <div class="container-kodebarang mb-3">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <input type="text" name="kodegolongan" class="form-control"
                                        placeholder="Kode Golongan">
                                </div>
                                <div class="mb-3 col-6">
                                    <input type="text" name="kodebidang" class="form-control" placeholder="Kode Bidang">
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class='bx bx-dollar'></i></span>
                            <input type="text" class="form-control number-mask" name="nilai"
                                placeholder="Nilai Kapitalisasi">
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
        window.datatable_kapitalisasi = undefined;

        function pilihKodeBarang(state) {
            let html = `<div class="row">
                <div class="mb-3 col-6">
                    <input type="text" name="kodegolongan" class="form-control"
                        placeholder="Kode Golongan">
                </div>
                <div class="mb-3 col-6">
                    <input type="text" name="kodebidang" class="form-control" placeholder="Kode Bidang">
                </div>
            </div>`;
            if (state == 'add') {
                html = `<select class='select2 form-control' name='kodebarang'></select>`
            }
            $('.container-kodebarang').html(html)
        }

        function setMaskMoney() {
            $('.number-mask').attr('maxlength', '12').inputmask('numeric', {
                radixPoint: ",",
                allowMinus: false,
                regex: "[0-9]*",
                groupSeparator: ".",
                rightAlign: false,
                digits: 2,
                min: (-1),
                allowZero: true,
                alias: 'numeric'
            });
        }

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                pilihKodeBarang(window.state);
                setMaskMoney();
                if (window.datatable_kapitalisasi.rows('.selected').data().length == 0) {
                    $('#table_kapitalisasi tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_kapitalisasi.rows('.selected').data()[0];
                $('#modalFormMasterKapitalisasi').modal('show');
                $('#modalFormMasterKapitalisasi').find('.modal-title').html('Edit Master Kapitalisasi');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.kapitalisasi.show') }}/" + data[4],
                    dataType: "json",
                    success: function(response) {
                        $("#form-kapitalisasi").find('[name=kodekapitalisasi]')
                            .val(response.data.kodekapitalisasi);
                        $("#form-kapitalisasi").find('[name=kodegolongan]')
                            .val(response.data.kodegolongan);
                        $("#form-kapitalisasi").find('[name=kodegolongan]').prop('disabled', true);
                        $("#form-kapitalisasi").find('[name=kodebidang]')
                            .val(response.data.kodebidang);
                        $("#form-kapitalisasi").find('[name=kodebidang]').prop('disabled', true);
                        $("#form-kapitalisasi").find('[name=nilai]')
                            .val(parseInt((response.data.nilai).split('.').join('')) / 100);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_kapitalisasi.rows('.selected').data().length == 0) {
                    $('#table_kapitalisasi tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_kapitalisasi.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data master kapitalisasi ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.kapitalisasi.delete') }}/" +
                                    data[4],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_kapitalisasi.ajax.reload()
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

        function updateMasterKapitalisasi() {
            data = serializeObject($('#form-kapitalisasi'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.kapitalisasi.update') }}/" + data.kodekapitalisasi,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_kapitalisasi.ajax.reload();
                }
            });
        }

        function numberFormat(nilai, prefix = 'Rp. ') {
            return $.fn.dataTable.render.number('.', ',', 2, prefix).display(nilai);
        }

        function saveMasterKapitalisasi() {
            data = serializeObject($('#form-kapitalisasi'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.kapitalisasi.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_kapitalisasi.ajax.reload();
                }
            });
        }
        $(function() {
            $('#table_kapitalisasi tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });

            window.datatable_kapitalisasi = new DataTable("#table_kapitalisasi", {
                ajax: "{{ route('master.kapitalisasi.data-table') }}",
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

            window.datatable_kapitalisasi.on('draw.dt', function() {
                actionData();
            });

            $(".add").click(function() {
                window.state = 'add';
                pilihKodeBarang(window.state);
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterKapitalisasi').modal('show');
                $('#modalFormMasterKapitalisasi').find('.modal-title').html(
                    'Tambah Master Kapitalisasi');
                $("#form-kapitalisasi")[0].reset();
                $.ajax({
                    type: "get",
                    url: `{{ route('master.kapitalisasi.useable-kobarang') }}`,
                    dataType: "json",
                    success: function(response) {
                        $('[name=kodebarang]').html(response.data);
                    }
                });
                setTimeout(() => {
                    $('.select2').select2({
                        dropdownParent: $(
                            "#modalFormMasterKapitalisasi")
                    });
                    setMaskMoney();
                }, 600);
            });

            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterKapitalisasi();
                } else {
                    updateMasterKapitalisasi();
                }
            });

            $('.multiple').click(function() {
                saveMasterKapitalisasi();
                $('#modalFormMasterKapitalisasi').modal('show');
                $('#modalFormMasterKapitalisasi').find('.modal-title').html(
                    'Tambah Master Kapitalisasi');
            });
        });
    </script>
@endpush
