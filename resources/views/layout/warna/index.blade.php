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
                        <table class="table table-stripped data-table" id="list-warna" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Warna</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($warna as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->warna }}</td>
                                        <td>
                                            <button class="btn btn-warning edit" data-id="{{ json_encode($item) }}"><i
                                                    class='bx bx-pencil mb-1'></i>
                                                Update</button>
                                            <button class="btn btn-danger delete" data-id="{{ json_encode($item) }}"><i
                                                    class='bx bx-trash mb-1'></i>
                                                Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>Tidak Ada Data</td>
                                        <td>Tidak Ada Data</td>
                                        <td>Tidak Ada Aksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFormMasterWarna" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterWarnaTitle">Tambah Master Warna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-warna" action="">
                        <input type="hidden" name="kodewarna">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-palette'></i></span>
                            <input type="text" class="form-control" name="warna" placeholder="Warna" aria-label="Warna"
                                aria-describedby="basic-addon11">
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
        function renderDataToTable(data) {
            html = '';
            data.forEach((element, index) => {
                html += `<tr>
                            <td>${index++}</td>
                            <td>${element.warna}</td>
                            <td>
                                <button class="btn btn-warning edit" data-id='${JSON.stringify(element)}'><i
                                        class='bx bx-pencil mb-1'></i>
                                    Update</button>
                                <button class="btn btn-danger delete" data-id='${JSON.stringify(element)}'><i
                                        class='bx bx-trash mb-1'></i>
                                    Delete</button>
                            </td>
                        </tr>`;
            });
            return html;
        }

        function updateMasterWarna() {
            data = serializeObject($('#form-warna'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.warna.update') }}/" + data.kodewarna,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    $('.data-table').DataTable().destroy();
                    $('.data-table').find('tbody').html(renderDataToTable(response.data))
                    $('.data-table').DataTable();
                }
            });
        }

        function saveMasterWarna() {
            data = serializeObject($('#form-warna'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.warna.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    $('.data-table').DataTable().destroy();
                    $('.data-table').find('tbody').html(renderDataToTable(response.data))
                    $('.data-table').DataTable();
                }
            });
        }

        function actionData() {
            $('.edit').click(function() {
                var data = $(this).data('id');
                window.state = 'edit';
                $('#modalFormMasterWarna').modal('show');
                $('#modalFormMasterWarna').find('.modal-title').html('Edit Master Warna');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.warna.show') }}/" + data.kodewarna,
                    dataType: "json",
                    success: function(response) {
                        $("#form-warna").find('[name=warna]').val(response.data.warna);
                        $("#form-warna").find('[name=kodewarna]').val(response.data.kodewarna);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                var data = $(this).data('id');
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
                    message: 'Apakah anda yakin akan menghapus data warna ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>YES</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.warna.delete') }}/" + data
                                    .kodewarna,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    $('.data-table').DataTable().destroy();
                                    $('.data-table').find('tbody').html(
                                        renderDataToTable(response.data))
                                    $('.data-table').DataTable();
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

        function initialDataTable() {
            $('#list-warna').on('draw.dt', function() {
                actionData();
            });
        }


        $(function() {
            $('.data-table').DataTable();
            actionData();
            initialDataTable();
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterWarna').modal('show');
                $('#modalFormMasterWarna').find('.modal-title').html('Edit Master Warna');
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
        });
    </script>
@endpush
