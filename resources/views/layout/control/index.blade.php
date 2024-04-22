@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
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
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ session('user')->foto !== null ? asset(session('user')->foto) : '../assets/img/avatars/1.png' }}"
                            alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block"><i class='bx bx-cloud-upload'></i> Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <form id="formAccountSettings" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="username" class="form-label">NIK</label>
                                <input class="form-control" type="text" id="username" name="username"
                                    placeholder="Kristanto" value="{{ session('user')->username }}" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nohp" class="form-label">Nomer Handphone</label>
                                <input class="form-control" type="text" name="nohp" id="nohp"
                                    placeholder="012312223123" value="{{ session('user')->nohp }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="displayname" class="form-label">Display Name</label>
                                <input class="form-control" type="text" id="displayname" name="displayname"
                                    placeholder="User Pusat" value="{{ session('user')->displayname }}" />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2"><i class='bx bxs-save'></i> Save
                                changes</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to change your password?</h6>
                            <p class="mb-0">Once you change your password, there is no going back. Please be certain.
                            </p>
                        </div>
                    </div>
                    <form id="formAccountDeactivation" onsubmit="return false">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label" for="password">Password Saat Ini</label>
                                <input class="form-control" type="password" name="password" id="password" />
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label" for="newpassword">Password Baru</label>
                                <input class="form-control"type="password" name="newpassword" id="newpassword" />
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="confirm" id="confirm" />
                            <label class="form-check-label" for="confirm">Konfirmasi Perubahan Password</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        window.profile = null;
        $(function() {
            const deactivateAcc = document.querySelector('#formAccountDeactivation');

            // Update/reset user image of account page
            let accountUserImage = document.getElementById('uploadedAvatar');
            const fileInput = document.querySelector('.account-file-input'),
                resetFileInput = document.querySelector('.account-image-reset');

            if (accountUserImage) {
                const resetImage = accountUserImage.src;
                fileInput.onchange = () => {
                    if (fileInput.files[0]) {
                        window.profile = fileInput.files[0];
                        accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                    }
                };
                resetFileInput.onclick = () => {
                    fileInput.value = '';
                    window.profile = null
                    accountUserImage.src = resetImage;
                };
            }
            $("#formAccountSettings").submit(function(e) {
                e.preventDefault();
                let data = new FormData($(this)[0]);
                if (window.profile != null) {
                    data.append('foto', window.profile);
                }
                $.ajax({
                    type: "POST",
                    url: `{{ route('control.user') }}`,
                    processData: false,
                    contentType: false,
                    data: data,
                    dataType: "json",
                    success: function(response) {

                    }
                });
            });
        });
    </script>
@endpush
