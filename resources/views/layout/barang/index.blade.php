@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jstree.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-header">Master Barang</div>
                <div class="card-body">
                    <div class="row">
                        <div id="container-jstree-barang" class="col-12 col-md-6 overflow-x-scroll"></div>
                        <div id="container-form-barang" class="col-12 col-md-6 d-none">
                            <h5>Aksi Master Barang</h5>
                            <div class="dome-inline-spacing mb-2">
                                <button id="show-menu" type="button" class="btn btn-info">
                                    <i class='bx bx-show-alt'></i>
                                    lihat</button>
                                <button id="delete-menu" type="button" class="btn btn-danger"><i
                                        class='bx bxs-trash mb-1'></i>
                                    hapus</button>
                            </div>
                            <h5 class="form-title-menu">Tambah Anak Master Barang</h5>
                            <form action="" id='form-menu'>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        placeholder="Master">
                                </div>
                                <div class="mb-3">
                                    <label for="icons" class="form-label">Icon</label>
                                    <input type="text" class="form-control" name="icons" id="icons"
                                        placeholder="bx bxs-x-square">
                                    <div id="defaultFormControlHelp" class="form-text">
                                        Icon yang kompatibel di <a href="https://boxicons.com/" target="_blank">boxicons</a>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link Master Barang</label>
                                    <select class="form-select select2" name="link" id="link">
                                        <option selected="">Pilih link menu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="letak" class="form-label">Letak Master Barang</label>
                                    <select class="form-select select2" name="letak" id="letak">
                                        <option selected="">Pilih letak menu</option>
                                        <option value="sidebar">sidebar</option>
                                        <option value="profile">profile</option>
                                    </select>
                                    <div class="form-text">
                                        Tidak di izinkan mengubah letak menu apabila memiliki anak menu
                                    </div>
                                </div>
                                <label for="" class="form-label">Role Accessibility</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="role[]" value="1"
                                        id="role-1" checked disabled>
                                    <label class="form-check-label" for="role-1"> Developer </label>
                                </div>
                                <div class="demo-inline-spacing">
                                    <button id="save-menu" type="button" class="btn btn-success"><i
                                            class='bx bxs-save mb-1'></i>
                                        Simpan</button>
                                    <button id="update-menu" type="button" class="btn btn-success d-none"><i
                                            class='bx bxs-pencil mb-1'></i>
                                        Edit</button>
                                    <button id="cancel-menu" type="button" class="btn btn-warning"><i
                                            class='bx bxs-x-square mb-1'></i>
                                        Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jstree.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script>
        function initialJsTree() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.barang.all') }}",
                dataType: "json",
                beforeSend: function() {
                    iziToast.question({
                        message: 'Loading Master Barang',
                        icon: 'bx bx-loader-circle bx-spin',
                        progressBar: false,
                        timeout: 20000,
                        close: false,
                        overlay: true,
                        drag: false,
                        zindex: 99999,
                        position: 'center',
                        titleSize: '30px',
                        maxWidth: '500px'
                    });
                },
                success: function(response) {
                    var toast = document.querySelector('.iziToast'); // Selector of your toast
                    iziToast.hide({}, toast);
                    $("#container-jstree-barang").jstree({
                        'core': {
                            'data': [{
                                id: '0',
                                text: 'Master Barang',
                                children: response.data,
                                state: {
                                    opened: true,
                                }
                            }],
                            "check_callback": true,
                        },
                    });
                    $("#container-form-barang").removeClass('d-none')
                },
                error: function() {
                    var toast = document.querySelector('.iziToast'); // Selector of your toast
                    iziToast.hide({}, toast);
                }
            });
        }
        $(function() {
            initialJsTree()
        });
    </script>
@endpush
