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
                <div class="card-header row align-items-center">
                    <div class="col-12 col-md-7 col-lg-8">
                        List Usulan
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 text-end">
                        {{-- <a href="{{ route('usulan.download-pakta') }}" target="_blank" class="btn btn-success"><i
                                class='bx bxs-download'></i> Download Pakta</a> --}}
                        <a class="btn btn-success text-white"><i class='bx bxs-download'></i> Download Pakta</a>
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-plus mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_usulan" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nomer</th>
                                    <th>Tahun</th>
                                    <th>Usulan</th>
                                    <th>Pakta</th>
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
    <div class="modal fade" id="modalFormMasterUsulan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterWarnaTitle">Tambah Usulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-usulan" action="" enctype="multipart/form-data">
                        <div class="divider">
                            <div class="divider-text">Usulan</div>
                        </div>
                        <input type="hidden" name="id">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                            <input type="text" class="form-control" name="tahun" placeholder="Tahun Usulan"
                                aria-label="Tahun Usulan" aria-describedby="basic-addon11">
                        </div>
                        <select name="induk_perubahan" id="induk_perubahan" class="form-select mb-3">
                            <option value="">Pilih Jenis Usulan</option>
                            <option value="1">Induk</option>
                            <option value="2">Perubahan</option>
                        </select>
                        <div class="input-group mb-3">
                            <label for="ssd_dokumen" class="input-group-text"><i class='bx bxs-file-pdf'></i></label>
                            <input class="form-control" type="file" accept="application/pdf" name="ssd_dokumen"
                                id="ssd_dokumen">
                        </div>
                        <div class="divider">
                            <div class="divider-text">List rincian usulan</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_rincian_usulan">
                                <thead>
                                    <tr role="row">
                                        <td>Kode Barang</td>
                                        <td>Nama Barang</td>
                                        <td>Uraian</td>
                                        <td>Spesfikasi</td>
                                        <td>Satuan</td>
                                        <td>Harga</td>
                                        <td>Rekening</td>
                                        <td>TKDN</td>
                                        <td>Aksi</td>
                                        <td>Jenis</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="row" id="container-rincian">
                            <input type="hidden" name="id_detail">
                            <div class="col-6">
                                <div class="divider">
                                    <div class="divider-text">Rincian usulan</div>
                                </div>
                                <div class="mb-3">
                                    <select name="id_kode" id="id_kode" class="select2 form-select">
                                        <option value="">Pilih Barang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="uraian" placeholder="Uraian">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="spesifikasi" placeholder="Spesifikasi">
                                </div>
                                <div class="mb-3">
                                    <select name="id_satuan" id="id_satuan" class="select2 form-select">
                                        <option value="">Pilih Satuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="harga" placeholder="Harga">
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="tkdn" placeholder="TKDN">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="divider">
                                    <div class="divider-text">Rekening rincian usulan</div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_1" class="select2 form-select">
                                                <option value="">Pilih rekening 1</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_2" class="select2 form-select">
                                                <option value="">Pilih rekening 2</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_3" class="select2 form-select">
                                                <option value="">Pilih rekening 3</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_4" class="select2 form-select">
                                                <option value="">Pilih rekening 4</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_5" class="select2 form-select">
                                                <option value="">Pilih rekening 5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_6" class="select2 form-select">
                                                <option value="">Pilih rekening 6</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_7" class="select2 form-select">
                                                <option value="">Pilih rekening 7</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_8" class="select2 form-select">
                                                <option value="">Pilih rekening 8</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_9" class="select2 form-select">
                                                <option value="">Pilih rekening 9</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <select name="rekening[]" id="rekening_10" class="select2 form-select">
                                                <option value="">Pilih rekening 10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning" onclick="addRincian()"><i
                                class='bx bx-plus'></i>Rincian</button>
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
 <div class="modal fade" id="modalFormTolakUsulan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormTolakUsulanTitle">Tambah Usulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-reject" action="">
                        <input type="hidden" name="id_detail">
                        @csrf
                        <div class="mb-3">
                            <label for="keterangan">Keterangan Untuk Pengusul</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger align-middle reject" data-bs-dismiss="modal">
                        <i class='tf-icons bx bx-save mb-1'></i> Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/jstree.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        window.datatable_usulan = undefined;
        window.state_rincian = 'add';
        window.rincian = 0;

        function getRekening(element) {
            let data = serializeObject($('#form-usulan'))
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.rekening') }}`,
                data: {
                    rekening: data['rekening[]']
                },
                dataType: "json",
                success: function(response) {
                    $(element).html(response.html_rekening);
                }
            });
        }
        function resetFormDetail(){
            $('#container-rincian').find('input, select').map((index, element) => {
                $(element).val('').trigger('change');
                if ($(element).attr('name') == 'rekening[]' && $(element).attr('id') !==
                    'rekening_1') {
                    $(element).html(
                        `<option value=''>Pilih ${$(element).attr('id').split('_').join(' ')}</option>`
                    )
                }
            });
        }
        function resetListData(){
            $('#table_rincian_usulan tbody').html('');
        }
        function addRincian(data = serializeObject($('#form-usulan'))) {
            delete data.tahun;
            delete data.induk_perubahan;
            let rekening = '';
            data['rekening[]'].forEach((datarekening) => {
                rekening += `<li class='list-group-item border-0 p-0 m-0'>${datarekening}</li>`;
            });
            let cari_nama_barang = () => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "get",
                        url: `{{ route('master.data.barang.show') }}` + '/' + data.id_kode,
                        dataType: "json",
                        success: function(response) {
                            resolve(response.data.urai);
                        },
                        error: function(error) {
                            reject(false);
                        }
                    });
                })
            };
            cari_nama_barang().then((nama_barang) => {
                if(data.id_detail != undefined){
                    $('#table_rincian_usulan tbody').find('tr').map((index, element)=>{
                        if($(element).data('id') == data.id_detail){
                            $(element).remove();
                            window.state_rincian = 'add';
                        }
                    })
                }
                let html =
                    `<tr data-id='${data.id_detail?? (window.rincian+=1)}' data-rincian='${JSON.stringify(data)}'><td class='py-0 px-1'>${data.id_kode}</td><td class='py-0 px-1'>${nama_barang}</td><td class='py-0 px-1'>${data.uraian}</td><td class='py-0 px-1'>${data.spesifikasi}</td><td class='py-0 px-1'>${data.id_satuan}</td><td class='py-0 px-1'>${data.harga}</td><td class='py-0 px-1'><ol class='list-group list-group-numbered list-group-flush'>${rekening}</ol></td><td class='py-0 px-1'>${data.tkdn}</td><td><button type='button' class='btn btn-icon btn-warning edit-rincian'><i class='bx bxs-pencil'></i></button><button type='button' class='btn btn-icon btn-danger hapus-rincian'><i class='bx bxs-trash'></i></button></td><td class='py-0 px-1'>${data.id_kode}</td></tr>`;
                $('#table_rincian_usulan').append(html);
                resetFormDetail();
                $('.hapus-rincian').click(function(e) {
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
                        message: 'Apakah anda yakin akan menghapus data rincian ini?',
                        position: 'center',
                        icon: 'bx bx-question-mark',
                        buttons: [
                            ['<button><b>IYA</b></button>', function(instance, toast) {
                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast, 'button');
                                $(e.currentTarget).parents('tr').remove();
                            }, true],
                            ['<button>TIDAK</button>', function(instance, toast) {
                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast, 'button');
                            }],
                        ],
                    });
                });

                $('.edit-rincian').click(function(e) {
                    iziToast.question({
                        timeout: 5000,
                        layout: 2,
                        close: false,
                        overlay: true,
                        color: 'yellow',
                        displayMode: 'once',
                        id: 'question',
                        zindex: 9999,
                        title: 'Konfirmasi',
                        message: 'Apakah anda yakin akan mengedit data rincian ini?',
                        position: 'center',
                        icon: 'bx bx-question-mark',
                        buttons: [
                            ['<button><b>IYA</b></button>', function(instance, toast) {
                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast, 'button');
                                $('.edit-rincian').removeClass('disabled');
                                $('.hapus-rincian').removeClass('disabled');
                                $(e.currentTarget).addClass('disabled');
                                $(e.currentTarget).siblings('.hapus-rincian').addClass(
                                    'disabled');
                                let data_detail = $(e.currentTarget).parents('tr').data(
                                    'rincian');
                                $('#container-rincian').find('input, select').map((index,
                                    element) => {
                                    $(element).val('').trigger('change');
                                    if ($(element).attr('name') == 'rekening[]' &&
                                        $(element).attr('id') !== 'rekening_1') {
                                        $(element).html(
                                            `<option value=''>Pilih ${$(element).attr('id').split('_').join(' ')}</option>`
                                        )
                                    }
                                });
                                $('#container-rincian').find('input, select').map((index,
                                    element) => {
                                    if (data_detail.hasOwnProperty($(element).attr(
                                            'name')) && $(element).attr('name') !=
                                        'rekening[]') {
                                        $(element).val(data_detail[$(element).attr(
                                            'name')]).trigger('change')
                                    }
                                    if ($(element).attr('name') == 'rekening[]') {
                                        let id = $(element).attr('id');
                                        if (data_detail['rekening[]'][
                                                parseInt(id.split('rekening_').join('')) - 1
                                            ] !== undefined) {
                                            setTimeout(() => {
                                                $(element).val(data_detail['rekening[]'][parseInt(id.split('rekening_').join('')) -1]).trigger('change');
                                            }, 500 * parseInt(id.split('rekening_').join('')))
                                        }
                                    }
                                });
                                window.state_rincian = 'update';
                            }, true],
                            ['<button>TIDAK</button>', function(instance, toast) {
                                instance.hide({
                                    transitionOut: 'fadeOut'
                                }, toast, 'button');
                            }],
                        ],
                    });
                });
            });
        }

        function updateMasterUsualan() {
            data = serializeObject($('#form-usulan'));
            data.detail = [];
            $('#table_rincian_usulan tbody').find('tr').each((index, element) => {
                let data_rekening = $(element).data('rincian');
                console.log(data_rekening);
                data_rekening.rekening = data_rekening['rekening[]']
                delete data_rekening['rekening[]'];
                data.detail.push(data_rekening);
            });
            if(document.querySelector('[name=ssd_dokumen]').files[0] != undefined ){
                fileToBase64(document.querySelector('[name=ssd_dokumen]').files[0]).then(result => {
                    data.ssd_dokumen = result;
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('usulan.update') }}/" + data.id,
                        data: {
                            _token: `{{ csrf_token() }}`,
                            ...data
                        },
                        dataType: "json",
                        success: function(response) {
                            window.datatable_usulan.ajax.reload();
                        }
                    });
                });
            }else{
                $.ajax({
                    type: "PUT",
                    url: "{{ route('usulan.update') }}/" + data.id,
                    data: {
                        _token: `{{ csrf_token() }}`,
                        ...data
                    },
                    dataType: "json",
                    success: function(response) {
                        window.datatable_usulan.ajax.reload();
                    }
                });
            }
        }

        function fileToBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                // Read file content on load
                reader.onload = () => {
                    // Convert array buffer to Base64 string
                    const base64String = btoa(
                        new Uint8Array(reader.result)
                        .reduce((data, byte) => data + String.fromCharCode(byte), '')
                    );
                    resolve(base64String);
                };

                // Handle errors during read
                reader.onerror = error => {
                    reject(error);
                };

                // Read file as array buffer
                reader.readAsArrayBuffer(file);
            });
        }

        function saveMasterUsulan() {
            data = serializeObject($('#form-usulan'));
            data.detail = [];
            $('#table_rincian_usulan tbody').find('tr').each((index, element) => {
                let data_rekening = $(element).data('rincian');
                data_rekening.rekening = data_rekening['rekening[]']
                delete data_rekening['rekening[]'];
                data.detail.push(data_rekening);
            });
            fileToBase64(document.querySelector('[name=ssd_dokumen]').files[0]).then(result => {
                data.ssd_dokumen = result;
                $.ajax({
                    type: "POST",
                    url: "{{ route('usulan.store') }}",
                    data: {
                        _token: `{{ csrf_token() }}`,
                        ...data
                    },
                    dataType: "json",
                    success: function(response) {
                        window.datatable_usulan.ajax.reload();
                    }
                });
            });
        }


        function actionData() {
            $('.edit').click(function() {
                window.state = 'update';
                if (window.datatable_usulan.rows('.selected').data().length == 0) {
                    $('#table_usulan tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_usulan.rows('.selected').data()[0];
                $('#modalFormMasTolakUsulan').modal('show');
                $('#modalFormMasterUsulan').find('.modal-title').html('Edit Usulan');
                $.ajax({
                    type: "GET",
                    url: "{{ route('usulan.show') }}/" + data[7],
                    dataType: "json",
                    success: function(response) {
                        $("#form-usulan").find('[name=id]')
                            .val(response.data.id);
                        $("#form-usulan").find('[name=tahun]')
                            .val(response.data.tahun);
                        $("#form-usulan").find('[name=induk_perubahan]')
                            .val(response.data.induk_perubahan);
                        response.data.detail.forEach(detail => {
                            detail['rekening[]'] = detail.rekening;
                            delete detail.rekening;
                            window.rincian = detail.id_detail;
                            addRincian(detail);
                        });
                    }
                });
                $('.multiple').addClass('d-none');
            });
            $('.delete').click(function() {
                if (window.datatable_usulan.rows('.selected').data().length == 0) {
                    $('#table_usulan tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_usulan.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data usulan ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('usulan.delete') }}/" + data[7],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_usulan.ajax.reload()
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
            $('.send').click(function() {
                if (window.datatable_usulan.rows('.selected').data().length == 0) {
                    $('#table_usulan tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_usulan.rows('.selected').data()[0];
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    color: 'blue',
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan mengirim data usulan ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "POST",
                                url: "{{ route('usulan.send') }}/" + data[7],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_usulan.ajax.reload()
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
        function formReject(){
            $('.reject').click(function(){
                let data = serializeObject($('#form-reject'));
                $.ajax({
                    type: "POST",
                    url: `{{route('usulan.reject')}}/${data.id_detail}`,
                    data: {...data},
                    dataType: "json",
                    success: function (response) {
                        window.datatable_usulan.ajax.reload();
                    }
                });
            })
        }
        function actionDetail(){
            $('.accept').click(function() {
                let id = $(this).data('id_detail');
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    color: 'blue',
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan menerima data usulan ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "POST",
                                url: "{{ route('usulan.accept') }}/" + $(this).data('id_detail'),
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_usulan.ajax.reload()
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
            $('.return').click(function() {
                let id = $(this).data('id_detail');
                iziToast.question({
                    timeout: 5000,
                    layout: 2,
                    close: false,
                    overlay: true,
                    color: 'yellow',
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan menolak data usulan ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                                $('#form-reject > input[name=id_detail]').val(id);
                                $('#modalFormTolakUsulan').modal('show');
                                formReject();
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

        function detail_table(d) {
            var html = '';
            d[6].forEach((element, index) => {
                let html_rekening = '';
                removeDuplicates(JSON.parse(element.rekening).flat()).forEach(rek => {
                    html_rekening += `<li class='list-group-item border-0 p-0 m-0 px-1'>${rek}</li>`
                })
                let status = ''
                if((`{{getRole()}}` == 'Developer' || `{{getRole()}}` == 'User Aset') && element.status == '1'){
                    status = `<button class='btn btn-icon btn-info mx-1 accept' data-id_detail='${element.id}'><i class='bx bx-check'></i></button><button class='btn btn-icon btn-danger mx-1 return' data-id_detail='${element.id}'><i class='bx bx-refresh'></i></button>`;
                }else if ((`{{getRole()}}` == 'Developer' || `{{getRole()}}` == 'User_aset') && element.status == '2'){
                    status = "Sudah di Validasi";
                }else if ((`{{getRole()}}` == 'Developer' || `{{getRole()}}` == 'User_aset') && element.status == '3'){
                    status = "Ditolak";
                }else{
                    status = "Menunggu Validasi";
}
                html += `
                <tr>
                    <td class='p-0 m-0 px-1'>${index+1}</td>
                    <td class='p-0 m-0 px-1'>${element.id_kode}</td>
                    <td class='p-0 m-0 px-1'>${element.urai}</td>
                    <td class='p-0 m-0 px-1'>${element.uraian}</td>
                    <td class='p-0 m-0 px-1'>${element.spesifikasi}</td>
                    <td class='p-0 m-0 px-1'>${element.satuan}</td>
                    <td class='p-0 m-0 px-1'>${element.harga}</td>
                    <td class='p-0 m-0 px-1'><ol class='list-group list-group-numbered list-group-flush'>${html_rekening}</ol></td>
                    <td class='p-0 m-0 px-1'>${element.tkdn}</td>
                    <td class='p-0 m-0 px-1'>${status}</td>
                    <td class='p-0 m-0 px-1'>${element.jenis}</td>
                </tr>`
            });
            return (
                `<div class='table-responsive'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th class='p-0 m-0 px-1'>No</th>
                                <th class='p-0 m-0 px-1'>Kode Barang</th>
                                <th class='p-0 m-0 px-1'>Nama Barang</th>
                                <th class='p-0 m-0 px-1'>Uraian</th>
                                <th class='p-0 m-0 px-1'>Spesifikasi</th>
                                <th class='p-0 m-0 px-1'>Satuan</th>
                                <th class='p-0 m-0 px-1'>Harga</th>
                                <th class='p-0 m-0 px-1'>Rekening</th>
                                <th class='p-0 m-0 px-1'>TKDN</th>
                                <th class='p-0 m-0 px-1'>Status</th>
                                <th class='p-0 m-0 px-1'>Jenis</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${html}
                        </tbody>
                    </table>
                </div>`
            );
        }
        $(function() {
            $('#table_usulan tbody').on('click', 'tr:not(tr[data-dt-row])', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            window.datatable_usulan = new DataTable('#table_usulan', {
                ajax: "{{ route('usulan.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [2, 'desc']
                ],
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        width: '5%'
                    },
                    {
                        orderable: false,
                        width: '5%'
                    },
                    {
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    }, {
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    }, {
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<div class='text-wrap'>${data}</div>`
                        }
                    },
                    {
                        orderable: false,
                        render: (data, type, row, meta) => {
                            return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                        }
                    },
                ],
            });
            window.datatable_usulan.on('draw.dt', function() {
                actionData();
            });
            window.datatable_usulan.on('click', 'td.dt-control', function(e) {
                let tr = e.target.closest('tr');
                let row = window.datatable_usulan.row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                } else {
                    row.child(detail_table(row.data())).show();
                    actionDetail();
                }
            });
            $("#modalFormMasterUsulan").on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('.select2').select2({
                        dropdownParent: $("#modalFormMasterUsulan")
                    });
                }, 100);
            });
            $("#modalFormMasterUsulan").on('hidden.bs.modal', function() {
                setTimeout(() => {
                    resetFormDetail();
                    resetListData();
                    window.rincian = 0;
                    window.state = 'add';
                    window.state_rincian = 'add';
                }, 100);
            })

            $.ajax({
                type: "GET",
                url: `{{ route('master.data.barang') }}`,
                dataType: "json",
                success: function(response) {
                    $('#id_kode').html(response.html_barang);
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.satuan') }}`,
                dataType: "json",
                success: function(response) {
                    $('#id_satuan').html(response.html_satuan);
                }
            });
            getRekening('#rekening_1');
            $('[name="rekening[]"]').change(function() {
                if (this.value != '') {
                    let id = [];
                    id = $(document).find('[name="rekening[]"]').filter((index, element) => {
                        return $(element).val() == ''
                    });
                    if (id.length > 0) {
                        getRekening(`#` + $(id[0]).attr('id'))
                    }
                }
            })

            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterUsulan').modal('show');
                $('#modalFormMasterUsulan').find('.modal-title').html('Tambah Usulan');
                $("#form-usulan")[0].reset()
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterUsulan();
                } else {
                    updateMasterUsualan();
                }
            });
            $('.multiple').click(function() {
                saveMasterUsulan();
                $('#modalFormMasterUsulan').modal('show');
                $('#modalFormMasterUsulan').find('.modal-title').html('Tambah Usulan');
            });
        });
    </script>
@endpush
