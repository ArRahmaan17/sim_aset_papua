@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
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
                <h5 class="card-header">Tambah User Aplikasi</h5>
                <div class="card-body">
                    <form id="formCreateUser" autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="username" class="form-label">NIK</label>
                                <input class="form-control" type="text" id="username" name="username"
                                    placeholder="31831******" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle col-md-6">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="form-text">
                                    Default password <em class="text-warning">"papuabaratdaya"</em>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nohp" class="form-label">Nomer Handphone</label>
                                <input class="form-control" type="text" name="nohp" id="nohp"
                                    placeholder="012312223123" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="displayname" class="form-label">Display Name</label>
                                <input class="form-control" type="text" id="displayname" name="displayname"
                                    placeholder="User Pusat" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="">Role User</label>
                                <div class="d-flex flex-column flex-sm-row p-2 align-content-conter flex-wrap">
                                    @foreach ($roles as $role)
                                        <div class="form-check">
                                            <input type="radio" name="idrole" id="role{{ $role->idrole }}"
                                                value="{{ $role->idrole }}">
                                            <label for="role{{ $role->idrole }}"
                                                class="form-check-label">{{ $role->role }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3 col-md-12 d-none container-organisasi">
                                <label for="">Organisasi</label>
                                <select class="form-control select2" name="useropd" disabled>
                                    {!! $semuaorganisasi !!}
                                </select>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2"><i class='bx bxs-save'></i> Tambah
                                User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script>
        $(function() {
            $('[name=idrole]').click(function() {
                if (parseInt(this.value) > 3) {
                    $('.d-none').removeClass('d-none');
                    $('.select2').prop('disabled', false);
                    $('.select2').select2();
                }
            });
            $("#formCreateUser").submit(function(e) {
                e.preventDefault();
                let data = serializeObject($("#formCreateUser"));
                $.ajax({
                    type: "POST",
                    url: `{{ route('control.create-user') }}`,
                    data: {
                        _token: `{{ csrf_token() }}`,
                        ...data
                    },
                    dataType: "json",
                    success: function(response) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                        });
                        $("#formCreateUser")[0].reset();
                        $('.select2').val('').prop('disabled', true);
                        $('.container-organisasi').addClass('d-none')
                    },
                    error: function(error) {
                        iziToast.error({
                            title: 'Error',
                            message: error.responseJSON.message,
                        });
                    }
                });
            });
        });
    </script>
@endpush
