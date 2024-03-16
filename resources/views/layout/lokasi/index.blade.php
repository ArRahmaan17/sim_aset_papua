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
                        Master Lokasi
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_lokasi" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Nama Lokasi</th>
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
@endsection
@push('js')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script>
        window.datatable_lokasi = undefined;

        function actionData() {
            $('.edit').click(function() {
                if (window.datatable_lokasi.rows('.selected').data().length == 0) {
                    $('#table_lokasi tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_lokasi.rows('.selected').data()[0];
                $('#modalFormMasterMasaManfaat').modal('show');
                $('#modalFormMasterMasaManfaat').find('.modal-title').html('Edit Master Masa Manfaat');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.lokasi.show') }}/" + data[4],
                    dataType: "json",
                    success: function(response) {
                        $("#form-lokasi").find('[name=kodelokasi]')
                            .val(response.data.kodelokasi);
                        $("#form-lokasi").find('[name=lokasi]')
                            .val(response.data.lokasi);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_lokasi.rows('.selected').data().length == 0) {
                    $('#table_lokasi tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_lokasi.rows('.selected').data()[0];
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
                                url: "{{ route('master.lokasi.delete') }}/" + data[4],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_lokasi.ajax.reload()
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
            window.datatable_lokasi = new DataTable("#table_lokasi", {
                ajax: "{{ route('master.lokasi.data-table') }}",
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
                    orderable: true
                }, {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                }],
            });
            window.datatable_lokasi.on('draw.dt', function() {
                actionData();
            });
        });
    </script>
@endpush
