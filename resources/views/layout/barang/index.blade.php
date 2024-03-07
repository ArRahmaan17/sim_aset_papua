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
                                <button id="show-barang" type="button" class="btn btn-info">
                                    <i class='bx bx-show-alt'></i>
                                    lihat</button>
                                <button id="delete-barang" type="button" class="btn btn-danger"><i
                                        class='bx bxs-trash mb-1'></i>
                                    hapus</button>
                            </div>
                            <h5 class="form-title-barang">Tambah Anak Master Barang</h5>
                            <form action="" id='form-barang'>
                                <div class="mb-3">
                                    <label for="kodebarang" class="form-label">Kode Barang</label>
                                    <input type="text" readonly class="form-control" name="kodebarang" id="kodebarang"
                                        placeholder="kodebarang">
                                    <div id="defaultFormControlHelp" class="form-text">
                                        inputan ini akan terisi secara otomatis dan tidak bisa di rubah
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="urai" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="urai" id="urai"
                                        placeholder="Bangunan Bersejarah">
                                </div>
                                <div class="demo-inline-spacing">
                                    <button id="save-barang" type="button" class="btn btn-success"><i
                                            class='bx bxs-save mb-1'></i>
                                        Simpan</button>
                                    <button id="update-barang" type="button" class="btn btn-success d-none"><i
                                            class='bx bxs-pencil mb-1'></i>
                                        Edit</button>
                                    <button id="cancel-barang" type="button" class="btn btn-warning"><i
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
        function showBarang(id) {
            $('.form-title-barang').html(`Edit Master Barang`);
            $.ajax({
                type: "GET",
                url: "{{ route('master.barang.show') }}/" + id,
                dataType: "json",
                success: function(response) {
                    dataToValue(response.data);
                    $('#save-barang').addClass('d-none');
                    $('#update-barang').removeClass('d-none');
                }
            });
        }

        function dataToValue(data) {
            $("#form-barang").find('input').map((index, element) => {
                if (data.hasOwnProperty(element.name)) {
                    $(element).val(data[element.name])
                }
            })
        }

        function resetForm() {
            $("#form-barang").find('input').val('')
        }

        function resetJsTree() {
            $("#container-jstree-barang").jstree(true).deselect_node($("#container-jstree-barang").jstree(true)
                .get_selected());
            resetForm();
        }

        function deleteMasterBarang() {
            id = $("#container-jstree-barang").jstree(true).get_selected()[0];
            $.ajax({
                type: "DELETE",
                url: "{{ route('master.barang.delete') }}/" + id,
                data: {
                    _token: `{{ csrf_token() }}`
                },
                dataType: "json",
                success: function(response) {

                }
            });
        }

        function updateMasterBarang() {
            data = serializeObject($("#form-barang"));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.barang.update') }}/" + data.kodebarang,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    resetJsTree();
                }
            });
        }

        function saveMasterBarang() {
            data = serializeObject($("#form-barang"));
            $.ajax({
                type: "POST",
                url: "{{ route('master.barang.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    resetJsTree();
                },
                error: function() {

                }
            });
        }

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
                },
                error: function() {
                    var toast = document.querySelector('.iziToast'); // Selector of your toast
                    iziToast.hide({}, toast);
                }
            });
        }
        $(function() {
            initialJsTree();
            $("#container-jstree-barang").on('select_node.jstree', (e, data) => {
                parentId = data.node.id;
                if (parentId !== '0') {
                    resetForm()
                    if (data.node.children.length > 0) {
                        var child = data.node.children[data.node.children.length - 1].split('.0');
                        var replacement = parseInt(child[0].split('.')[child[0].split('.').length - 1]) + 1;
                        child[0] = child[0].split('.');
                        child[0][child[0].length - 1] = replacement.toString();
                        child[0] = child[0].join('.');
                        console.log(child)
                        $('#kodebarang').val(child[0].padEnd(11, '.0'));
                        $('.form-title-barang').html(`Tambah Anak Master Barang`);
                    } else {
                        showBarang(parentId);
                    }
                    if (data.node.children.length > 0) {
                        $("#delete-barang").addClass('disabled')
                    } else {
                        $("#delete-barang").removeClass('disabled')
                    }
                    $("#show-barang").removeClass('disabled')
                    $("#container-jstree-barang").switchClass('col-12', 'col-6', 500);
                    $("#container-form-barang").switchClass('d-none', 'd-block', 500);
                } else {
                    $("#show-barang").addClass('disabled');
                    resetForm()
                }
            });
            $("#container-jstree-barang").on('deselect_node.jstree', () => {
                $("#container-tree-barang").switchClass('col-6', 'col-12', 700);
                $("#container-form-barang").switchClass('d-block', 'd-none', 50);
            });
            $('#cancel-barang').click(function() {
                resetJsTree();
            });
            $('#show-barang').click(function() {
                showBarang($("#container-jstree-barang").jstree(true).get_selected()[0]);
            });
            $('#save-barang').click(function() {
                saveMasterBarang();
            });
            $('#update-barang').click(function() {
                updateMasterBarang();
            });
            $('#delete-barang').click(function() {
                deleteMasterBarang();
            });
        });
    </script>
@endpush
