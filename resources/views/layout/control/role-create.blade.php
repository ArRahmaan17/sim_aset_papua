@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link
                    {{ app('request')->route()->named('control.user') ? 'active' : '' }}""
                        href="{{ route('control.user') }}"><i class="bx bx-user me-1"></i> Account</a>
                </li>
                @if (in_array(session('user')->idrole, [0, 1, 2]))
                    <li class="nav-item">
                        <a class="nav-link {{ app('request')->route()->named('control.role.create') ? 'active' : '' }}"
                            href="{{ route('control.role.create') }}"><i class='bx bxs-user-voice me-1'></i>
                            Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ app('request')->route()->named('control.create-user') ? 'active' : '' }}"
                            href="{{ route('control.create-user') }}"><i class='bx bxs-user-plus me-1'></i>
                            Create User</a>
                    </li>
                @endif
            </ul>
            <div class="card mb-4">
                <div class="card-header row align-items-center">
                    <div class="col-6 col-md-10">
                        Role User
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_role" class="table">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFormRoleUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormRoleUserTitle">Tambah Role User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-role" action="">
                        <input type="hidden" name="idrole">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-palette'></i></span>
                            <input type="text" class="form-control" name="role" placeholder="Role" aria-label="Role"
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
        window.datatable_role = null;

        function updateRoleUser() {
            data = serializeObject($('#form-role'));
            $.ajax({
                type: "PUT",
                url: "{{ route('control.role.update') }}/" + data.idrole,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    iziToast.success({
                        title: 'SUCCESS',
                        message: response.message,
                    });
                    window.datatable_role.ajax.reload();
                }
            });
        }

        function saveRoleUser() {
            data = serializeObject($('#form-role'));
            $.ajax({
                type: "POST",
                url: "{{ route('control.role.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    iziToast.success({
                        title: 'SUCCESS',
                        message: response.message,
                    });
                    window.datatable_role.ajax.reload();
                }
            });
        }

        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_role.rows('.selected').data().length == 0) {
                    $('#table_role tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_role.rows('.selected').data()[0];
                $('#modalFormRoleUser').modal('show');
                $('#modalFormRoleUser').find('.modal-title').html('Edit Role User');
                $.ajax({
                    type: "GET",
                    url: "{{ route('control.role.show') }}/" + data[3],
                    dataType: "json",
                    success: function(response) {
                        iziToast.success({
                            title: 'SUCCESS',
                            message: response.message,
                        });
                        $("#form-role").find('[name=idrole]')
                            .val(response.data.idrole);
                        $("#form-role").find('[name=role]')
                            .val(response.data.role);
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_role.rows('.selected').data().length == 0) {
                    $('#table_role tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_role.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data role ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('control.role.delete') }}/" + data[3],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    iziToast.success({
                                        title: 'SUCCESS',
                                        message: response.message,
                                    });
                                    window.datatable_role.ajax.reload()
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
            $('#table_role tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_role = new DataTable('#table_role', {
                ajax: "{{ route('control.user-role.data-table') }}",
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
            window.datatable_role.on('draw.dt', function() {
                actionData();
            });
            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormRoleUser').modal('show');
                $('#modalFormRoleUser').find('.modal-title').html('Tambah Role User');
                $("#form-role")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveRoleUser();
                } else {
                    updateRoleUser();
                }
            });
            $('.multiple').click(function() {
                saveRoleUser();
                $('#modalFormRoleUser').modal('show');
                $('#modalFormRoleUser').find('.modal-title').html('Tambah Role User');
            });
        });
    </script>
@endpush
