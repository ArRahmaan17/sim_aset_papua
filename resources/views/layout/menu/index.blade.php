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
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 container-alert-invalid-process"></div>
                        <div class="row col-12 col-md-6">
                            <div id="container-tree-menu-sidebar" class="col-12">
                            </div>
                            <div id="container-tree-menu-profile" class="col-12">
                            </div>
                        </div>
                        <div id="form-container" class="col-12 col-md-6 d-none">
                            <h5>Aksi Menu</h5>
                            <div class="dome-inline-spacing mb-2">
                                <button id="show-menu" type="button" class="btn btn-info">
                                    <i class='bx bx-show-alt'></i>
                                    lihat</button>
                                <button id="delete-menu" type="button" class="btn btn-danger"><i
                                        class='bx bxs-trash mb-1'></i>
                                    hapus</button>
                            </div>
                            <h5 class="form-title-menu">Tambah Anak Menu</h5>
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
                                    <label for="link" class="form-label">Link Menu</label>
                                    <select class="form-select select2" name="link" id="link">
                                        <option selected="">Pilih link menu</option>
                                        @foreach ($routes as $route)
                                            @if (
                                                $route->methods()[0] == 'GET' &&
                                                    $route->getAction()['prefix'] == '' &&
                                                    array_search('authenticated', $route->getAction()['middleware']))
                                                <option value="{{ $route->getName() }}">
                                                    {{ url($route->uri) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="letak" class="form-label">Letak Menu</label>
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
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="role[]"
                                            value="{{ $role->idrole }}" id="role-{{ $role->idrole }}">
                                        <label class="form-check-label" for="role-{{ $role->idrole }}"> {{ $role->role }}
                                        </label>
                                    </div>
                                @endforeach
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
        function iniliatizeJstree() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.list-menu') }}",
                data: {
                    role: `{{ session('user')->idrole }}`
                },
                dataType: "json",
                success: function(response) {
                    $("#container-tree-menu-sidebar").jstree({
                        'core': {
                            'data': [{
                                id: '0-sidebar',
                                text: 'SIDEBAR',
                                children: response.data.menu_sidebar,
                                state: {
                                    opened: true,
                                }
                            }],
                            "check_callback": true,
                        },
                        "plugins": ["dnd"]
                    });
                    $("#container-tree-menu-profile").jstree({
                        'core': {
                            'data': [{
                                id: '0-profile',
                                text: 'PROFILE',
                                children: response.data.menu_profile,
                                state: {
                                    opened: true,
                                }
                            }],
                            "check_callback": true,
                        },
                        "plugins": ["dnd"]
                    });
                },
                error: function() {
                    $("#container-tree-menu-sidebar").jstree({
                        'core': {
                            'data': [{
                                id: '0-sidebar',
                                text: 'SIDEBAR',
                                state: {
                                    opened: true,
                                }
                            }],
                            "check_callback": true,
                        },
                        "plugins": ["dnd"]
                    });
                    $("#container-tree-menu-profile").jstree({
                        'core': {
                            'data': [{
                                id: '0-profile',
                                text: 'PROFILE',
                                state: {
                                    opened: true,
                                }
                            }],
                            "check_callback": true,
                        },
                        "plugins": ["dnd"]
                    });
                }
            });
        }

        function getElementData(data) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.menu.show-detail') }}/" + data,
                    dataType: "json",
                    success: function(response) {
                        resolve(response.data)
                    },
                    error: function(response) {
                        reject(response.responseJSON.data)
                    }
                });
            })
        }

        function buildChildren(elements) {
            var branch = [];
            elements.forEach(element => {
                element = getElementData(element);
                console.log(element)
                if (element['children'] != undefined) {
                    var children = buildChildren(element['children']);
                    if (children.length > 0) {
                        element['children'] = children;
                    }
                    branch.push({
                        ...element.original,
                        ...element.children
                    });
                }
            });
            return branch
        }

        function checkValidNodeDnd() {
            start = JSON.parse(localStorage.getItem('startdatajstree'))
            end = JSON.parse(localStorage.getItem('enddatajstree'));
            getElementData(start.id).then((data) => {
                if (end == false) {
                    if (start.parent == '0-sidebar') {
                        $("#container-tree-menu-sidebar").jstree(true).create_node(`${start.parent}`, ...data,
                            'last');
                        $("#container-tree-menu-profile").jstree(true).refresh()
                    } else {
                        $("#container-tree-menu-profile").jstree(true).create_node(`${start.parent}`, ...data,
                            'last');
                        $("#container-tree-menu-sidebar").jstree(true).refresh()
                    }
                    $('.container-alert-invalid-process')
                        .html(`<div class="alert alert-danger alert-invalid-process">
                                <div class="row justify-content-start align-items-center">
                                    <div class="col-1">
                                        <i class='bx bxs-error-alt bx-lg'></i>
                                    </div>
                                    <div class="col-11 fw-bold">
                                        <span>Error</span>
                                    </div>
                                </div>
                                <div class="p-2">
                                    Proses Tidak dapat di proses
                                </div>
                            </div>`);
                    setTimeout(() => {
                        $('.alert-invalid-process').toggle("fade", 2000);
                    }, 1500);
                } else {
                    if (end.parent == "#") {
                        if (start.parent == '0-sidebar') {
                            $("#container-tree-menu-sidebar").jstree(true).create_node(`${start.parent}`, ...data,
                                'last');
                        } else {
                            $("#container-tree-menu-profile").jstree(true).create_node(`${start.parent}`, ...data,
                                'last');
                        }
                        $('.container-alert-invalid-process')
                            .html(`<div class="alert alert-danger alert-invalid-process">
                            <div class="row justify-content-start align-items-center">
                                <div class="col-1">
                                    <i class='bx bxs-error-alt bx-lg'></i>
                                </div>
                                <div class="col-11 fw-bold">
                                    <span>Error</span>
                                </div>
                            </div>
                            <div class="p-2">
                                Proses Tidak dapat di proses
                            </div>
                        </div>`);
                        setTimeout(() => {
                            $('.alert-invalid-process').toggle("fade", 2000);
                        }, 1500);
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('master.update-parent-menu') }}",
                            data: {
                                _token: `{{ csrf_token() }}`,
                                menu: {
                                    ...end.original,
                                    parents: end.parent.split('-')[0],
                                    letak: end.parent.split('-')[1],
                                }
                            },
                            dataType: "json",
                            success: function(response) {

                            }
                        });
                    }
                }
            })
        }

        function dataToValueElement(data, length) {
            $('#form-menu').find('input, select').map((index, element) => {
                let name = $(element).attr('name');
                if (data.hasOwnProperty(`${name}`)) {
                    let value = data[`${name}`];
                    if (name == 'role[]') {
                        value = JSON.parse(value);
                        value.forEach(val => {
                            if ($(element).val() == val) {
                                $(element).attr('checked', true)
                            }
                        })
                    } else {
                        $(`[name=${name}]`).val(value).trigger("change")
                        if (length != 0 && name == 'letak') {
                            $(`[name=${name}]`).attr('disabled', true)
                        }
                    }
                }
            })
        }

        function resetMenuForm() {
            $("#form-menu").find('select[disabled]').removeAttr('disabled')
            $('.form-title-menu').html('Tambah Anak Menu');
            $("#form-menu")[0].reset();
            $("#update-menu").addClass('d-none');
            $("#save-menu").removeClass('d-none');
            $("#form-menu").find(':not([value=1])').attr('checked', false)
        }

        function resetJstree() {
            $("#container-tree-menu-sidebar").jstree(true).deselect_node($(
                    "#container-tree-menu-sidebar").jstree(true)
                .get_selected());
            $("#container-tree-menu-profile").jstree(true).deselect_node($(
                    "#container-tree-menu-profile").jstree(true)
                .get_selected());
        }
        $(function() {
            var parentId = null;
            iniliatizeJstree();
            $(document).on('dnd_start.vakata', function(e, data) {
                var container = $("#container-tree-menu-sidebar").jstree(true).get_node(data.data
                    .nodes);
                if (container == false) {
                    container = $("#container-tree-menu-profile").jstree(true).get_node(data.data
                        .nodes);
                }
                localStorage.setItem('startdatajstree', JSON.stringify(container));
            })
            $(document).on('dnd_stop.vakata', function(e, data) {
                var container = $("#container-tree-menu-sidebar").jstree(true).get_node(data.data
                    .nodes);
                if (container == false) {
                    container = $("#container-tree-menu-profile").jstree(true).get_node(data.data
                        .nodes);
                }
                localStorage.setItem('enddatajstree', JSON.stringify(container));
                checkValidNodeDnd();
            });
            $("#container-tree-menu-sidebar").on('select_node.jstree', (e, data) => {
                parentId = data.node.id;
                if (data.node.children.length > 0 || parentId == 0) {
                    $("#delete-menu").addClass('disabled')
                } else {
                    $("#delete-menu").removeClass('disabled')
                }
                if (parentId == 0) {
                    $("#show-menu").addClass('disabled')
                } else {
                    $("#show-menu").removeClass('disabled')
                }
                resetMenuForm();
                $("#container-tree-menu-sidebar").switchClass('col-12', 'col-6', 500);
                $("#form-container").switchClass('d-none', 'd-block', 500);
                setTimeout(() => {
                    $('.select2').select2();
                }, 600);
            })
            $("#container-tree-menu-sidebar").on('deselect_node.jstree', () => {
                $("#container-tree-menu-sidebar").switchClass('col-6', 'col-12', 700);
                $("#form-container").switchClass('d-block', 'd-none', 50);
            });
            $("#container-tree-menu-profile").on('select_node.jstree', (e, data) => {
                parentId = data.node.id;
                if (data.node.children.length > 0 || parentId == 0) {
                    $("#delete-menu").addClass('disabled')
                } else {
                    $("#delete-menu").removeClass('disabled')
                }
                if (parentId == 0) {
                    $("#show-menu").addClass('disabled')
                } else {
                    $("#show-menu").removeClass('disabled')
                }
                resetMenuForm();
                $("#container-tree-menu-profile").switchClass('col-12', 'col-6', 500);
                $("#form-container").switchClass('d-none', 'd-block', 500);
                setTimeout(() => {
                    $('.select2').select2();
                }, 600);
            });
            $("#container-tree-menu-profile").on('deselect_node.jstree', () => {
                $("#container-tree-menu-profile").switchClass('col-6', 'col-12', 700);
                $("#form-container").switchClass('d-block', 'd-none', 50);
            })
            $('#save-menu').click(function() {
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    color: 'green',
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan menyimpan menu ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            data = serializeObject($("#form-menu"));
                            data = {
                                ...data,
                                parents: parentId
                            };
                            $.ajax({
                                type: "POST",
                                url: "{{ route('master.menu.store') }}",
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                    ...data
                                },
                                dataType: "json",
                                success: function(response) {
                                    resetMenuForm();
                                    $("#container-tree-menu-sidebar")
                                        .jstree(
                                            true)
                                        .create_node(response.data
                                            .parent, {
                                                ...response.data
                                            });
                                    resetJstree()
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
            $("#update-menu").click(function() {
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    color: 'yellow',
                    id: 'question',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan mengubah menu ini?',
                    position: 'center',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            id = $("#container-tree-menu-sidebar").jstree(true)
                                .get_selected()[0]
                            if (id == undefined) {
                                id = $("#container-tree-menu-profile").jstree(true)
                                    .get_selected()[0]
                            }
                            place = $("#container-tree-menu-sidebar").jstree(true)
                                .get_selected(true)[0]
                            if (place == undefined) {
                                place = $("#container-tree-menu-profile").jstree(true)
                                    .get_selected(true)[0];
                            }
                            data = serializeObject($("#form-menu"));
                            $.ajax({
                                type: "PUT",
                                url: "{{ route('master.menu.update') }}/" +
                                    id,
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                    ...data
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (data.letak == place.original.letak &&
                                        data.letak == 'sidebar') {
                                        $("#container-tree-menu-sidebar")
                                            .jstree(true)
                                            .rename_node(
                                                $(
                                                    "#container-tree-menu-sidebar"
                                                )
                                                .jstree(true)
                                                .get_selected(),
                                                response.data.nama);
                                        resetJstree()
                                    } else if (data.letak != place.original
                                        .letak && data.letak == 'sidebar') {
                                        $("#container-tree-menu-sidebar")
                                            .jstree(true)
                                            .create_node('0-sidebar', {
                                                id: response.data.id,
                                                text: response.data.nama,
                                                children: []
                                            });
                                        $("#container-tree-menu-profile")
                                            .jstree(true)
                                            .delete_node($(
                                                "#container-tree-menu-profile"
                                            ).jstree(true).get_node([`${response
                                                    .data.id}`]));
                                        resetJstree()
                                    } else if (data.letak == place.original
                                        .letak &&
                                        data.letak == 'profile') {
                                        $("#container-tree-menu-profile")
                                            .jstree(true)
                                            .rename_node(
                                                $(
                                                    "#container-tree-menu-profile"
                                                )
                                                .jstree(true)
                                                .get_selected(),
                                                response.data.nama);
                                        resetJstree()
                                    } else if (data.letak != place.original
                                        .letak && data.letak == 'profile') {
                                        $("#container-tree-menu-profile")
                                            .jstree(true)
                                            .create_node('0-profile', {
                                                id: response.data.id,
                                                text: response.data.nama,
                                                children: []
                                            });
                                        $("#container-tree-menu-sidebar")
                                            .jstree(true)
                                            .delete_node($(
                                                    "#container-tree-menu-sidebar"
                                                )
                                                .jstree(true).get_node(response
                                                    .data.id));
                                        resetJstree()
                                    }
                                },
                                error: function() {
                                    resetJstree()
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
            $("#delete-menu").click(function() {
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    color: 'red',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan menghapus menu ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            id = $("#container-tree-menu-sidebar").jstree(true)
                                .get_selected()[0]
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.menu.delete') }}/" +
                                    id,
                                data: {
                                    _token: `{{ csrf_token() }}`
                                },
                                dataType: "json",
                                success: function(response) {
                                    $("#container-tree-menu-sidebar")
                                        .jstree(
                                            true)
                                        .delete_node($(
                                                "#container-tree-menu-sidebar"
                                            )
                                            .jstree(
                                                true)
                                            .get_selected());
                                    resetJstree()
                                },
                                error: function() {
                                    resetJstree()
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
            })
            $('#show-menu').click(function() {
                id = $("#container-tree-menu-sidebar").jstree(true)
                    .get_selected()[0]
                if (id == undefined) {
                    id = $("#container-tree-menu-profile").jstree(true)
                        .get_selected()[0]
                }
                data = $("#container-tree-menu-sidebar").jstree(true)
                    .get_selected(true)[0]
                if (data == undefined) {
                    data = $("#container-tree-menu-profile").jstree(true)
                        .get_selected(true)[0]
                }
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.menu.show') }}/" + id,
                    dataType: "json",
                    success: function(response) {
                        dataToValueElement(response.data, data.children.length);
                        $("#save-menu").addClass('d-none');
                        $("#update-menu").removeClass('d-none');
                        $('.form-title-menu').html('Edit Menu')
                    },
                    error: function() {
                        resetJstree()
                    }
                });
            });
            $('#cancel-menu').click(function() {
                resetMenuForm();
                resetJstree()
            })
        });
    </script>
@endpush
