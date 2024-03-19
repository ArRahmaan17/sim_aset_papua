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
                        <table class="table table-striped data-table" id="table_satuan" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Satuan</th>
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
    <div class="modal fade" id="modalFormMasterSatuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterSatuanTitle">Tambah Master Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-satuan" action="">
                        <input type="hidden" name="kodesatuan">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-palette'></i></span>
                            <input type="text" class="form-control" name="satuan" placeholder="Pcs">
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
        window.datatable_satuan = undefined;

        function updateMasterWarna() {
            data = serializeObject($('#form-satuan'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.satuan.update') }}/" + data.kodesatuan,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_satuan.ajax.reload();
                }
            });
        }

        function saveMasterWarna() {
            data = serializeObject($('#form-satuan'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.satuan.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_satuan.ajax.reload();
                }
            });
        }


        function actionData() {
            $('.edit').click(function() {
                if (window.datatable_satuan.rows('.selected').data().length == 0) {
                    $('#table_satuan tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_satuan.rows('.selected').data()[0];
                $('#modalFormMasterSatuan').modal('show');
                $('#modalFormMasterSatuan').find('.modal-title').html('Edit Master Warna');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.satuan.show') }}/" + data[3],
                    dataType: "json",
                    success: function(response) {
                        $("#form-satuan").find('[name=kodesatuan]')
                            .val(response.data.kodesatuan);
                        $("#form-satuan").find('[name=satuan]')
                            .val(response.data.satuan);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_satuan.rows('.selected').data().length == 0) {
                    $('#table_satuan tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_satuan.rows('.selected').data()[0];
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
                        ['<button><b>YES</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.satuan.delete') }}/" + data[3],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_satuan.ajax.reload()
                                }
                            });
                        }, true],
                        ['<button>NO</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }],
                    ],
                });
            });
        }

        $(function() {
            $('#table_satuan tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_satuan = new DataTable('#table_satuan', {
                ajax: "{{ route('master.satuan.data-table') }}",
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
                    orderable: true
                }, {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                }],
            });
            window.datatable_satuan.on('draw.dt', function() {
                actionData();
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterSatuan').modal('show');
                $('#modalFormMasterSatuan').find('.modal-title').html('Edit Master Warna');
                $("#form-satuan")[0].reset()
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
                $('#modalFormMasterSatuan').modal('show');
                $('#modalFormMasterSatuan').find('.modal-title').html('Tambah Master Warna');
            });
        });
    </script>
@endpush
