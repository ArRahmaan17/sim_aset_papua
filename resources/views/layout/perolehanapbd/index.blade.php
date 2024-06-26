@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0 flex-column-reverse flex-sm-row">
                    <div id="container-form-perolehan" class="col-md-12">
                        <h3 class="card-header m-0 me-2 pb-3">Perolehan APBD</h3>
                        <div class="col-xl">
                            <div class="card mb-4 shadow-none">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Form Perolehan APBD</h5>
                                    <small class="text-muted float-end">input untuk penambahan aset</small>
                                </div>
                                <div class="card-header d-flex justify-content-end align-items-center">
                                    <button class="btn btn-warning" id="search-bap"><i class='bx bxs-search mb-1'></i> Cari
                                        Bap</button>
                                </div>
                                <div class="card-body">
                                    <div class="col container-alert-ba">
                                    </div>
                                    <form id="ba-form">
                                        <div class="mb-3">
                                            <h3>Form BAP</h3>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label align-middle" for="kodebap">No BAP
                                                Terima <i
                                                    class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                            <div class="input-group input-group-merge">
                                                <span id="kodebapicon" class="input-group-text"><i
                                                        class='bx bx-info-circle'></i></span>
                                                <input type="text" class="form-control formated" id="kodebap"
                                                    name="kodebap" aria-describedby="kodebapicon" />
                                            </div>
                                            <div class="form-text text-info">*setelah selesai input akan terjadi
                                                pemformatan
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label align-middle" for="tanggalbap">Tanggal
                                                BAP Terima <i
                                                    class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                            <div class="input-group input-group-merge">
                                                <span id="tanggalbapicon" class="input-group-text"><i
                                                        class='bx bx-calendar-event'></i></span>
                                                <input type="text" id="tanggalbap" name="tanggalbap"
                                                    class="form-control datetime-picker" aria-label="ACME Inc."
                                                    aria-describedby="tanggalbapicon" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nobaterima">No BAP</label>
                                            <div class="input-group input-group-merge">
                                                <span id="nobaterimaicon" class="input-group-text"><i
                                                        class='bx bx-info-circle'></i></span>
                                                <input type="text" class="form-control formated" id="nobaterima"
                                                    name="nobaterima" aria-describedby="nobaterimaicon" />
                                            </div>
                                            <div class="form-text text-info">*setelah selesai input akan terjadi
                                                pemformatan
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="tanggalbaterima">Tanggal BAP</label>
                                            <div class="input-group input-group-merge">
                                                <span id="tanggalbaterimaicon" class="input-group-text"><i
                                                        class='bx bx-calendar-event'></i></span>
                                                <input type="text" id="tanggalbaterima"
                                                    class="form-control datetime-picker" name="tanggalbaterima"
                                                    aria-describedby="tanggalbaterimaicon" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="keterangan">Keterangan</label>
                                            <div class="input-group input-group-merge">
                                                <span id="keteranganicon" class="input-group-text"><i
                                                        class='bx bx-detail'></i></span>
                                                <textarea id="keterangan" name="keterangan" rows="4" class="form-control" aria-describedby="keteranganicon"
                                                    style="resize: none;"></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nokontrak">No Kontrak</label>
                                            <div class="input-group input-group-merge">
                                                <span id="nokontrakicon" class="input-group-text"><i
                                                        class='bx bx-info-circle'></i></span>
                                                <input type="text" class="form-control" id="nokontrak"
                                                    name="nokontrak" aria-label="John Doe"
                                                    aria-describedby="nokontrakicon" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="tanggalkontrak">Tanggal
                                                Kontrak</label>
                                            <div class="input-group input-group-merge">
                                                <span id="tanggalkontrakicon" class="input-group-text"><i
                                                        class='bx bx-calendar-event'></i></span>
                                                <input type="text" id="tanggalkontrak"
                                                    class="form-control datetime-picker" name="tanggalkontrak"
                                                    aria-label="ACME Inc." aria-describedby="tanggalkontrakicon" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nilaikontrak">Nilai
                                                Kontrak</label>
                                            <div class="input-group input-group-merge">
                                                <span id="nilaikontrakicon" class="input-group-text"><i
                                                        class='bx bx-dollar-circle'></i></span>
                                                <input type="text" id="nilaikontrak" name="nilaikontrak"
                                                    class="form-control money-mask" aria-describedby="nilaikontrakicon" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="nokuitansi">No
                                                Kwitansi</label>
                                            <div class="input-group input-group-merge">
                                                <span id="nokuitansiicon" class="input-group-text"><i
                                                        class='bx bx-info-circle'></i></span>
                                                <input type="text" id="nokuitansi" class="form-control"
                                                    name="nokuitansi" aria-describedby="nokuitansiicon" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="tanggalkuitansi">Tanggal
                                                Kwitansi</label>
                                            <div class="input-group input-group-merge">
                                                <span id="tanggalkuitansiicon" class="input-group-text"><i
                                                        class='bx bx-calendar-event'></i></span>
                                                <input type="text" id="tanggalkuitansi" name="tanggalkuitansi"
                                                    class="form-control datetime-picker"
                                                    aria-describedby="tanggalkuitansiicon" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h3>APBD</h3>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="program">Program <i
                                                    class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                            <div class="input-group input-group-merge">
                                                <span id="programicon" class="input-group-text"><i
                                                        class='bx bx-calendar-check'></i></span>
                                                <select name="program" id="program" class="form-select"
                                                    aria-describedby="programicon">
                                                    <option value="">Pilih Program</option>
                                                    @foreach ($dataPerogramAPBD as $program)
                                                        <option value="{{ $program->id }}">
                                                            {{ $program->id }} - {{ $program->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="kegiatan">Kegiatan <i
                                                    class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                            <div class="input-group input-group-merge">
                                                <span id="kegiatanicon" class="input-group-text"><i
                                                        class='bx bx-calendar-check'></i></span>
                                                <select name="kegiatan" id="kegiatan" class="form-select"
                                                    aria-describedby="kegiatanicon">
                                                    <option value="">Pilih Kegiatan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h3>Detail Aset <span class="badge bg-success contract-value float-end"></span>
                                            </h3>
                                            <ul id="container-detail-asset" class="list-group">
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <h3>Tambah Nilai Attribusi</h3>
                                            <div class="col-12 sp2d attribusi" style="height: 200px; overflow-y: scroll;">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>NO APBD</th>
                                                                <th>Tanggal APBD</th>
                                                                <th>Nilai APBD</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button type="button" id="add-attribusi"
                                                class="btn btn-warning d-none disabled my-3"><span
                                                    class='tf-icons bx bx-plus'></span> Tambah Attribusi</button>
                                            <ul id="container-attribusi-asset" class="list-group mt-3">
                                            </ul>
                                        </div>
                                        <button type="button" id="add-detail-asset" class="btn btn-success mb-3"><span
                                                class='tf-icons bx bx-layer-plus'></span>
                                            Tambah Detail Aset</button>
                                        <button id="save-ba" type="button" class="btn btn-warning mb-3 disabled"><span
                                                class='tf-icons bx bx-save'></span>
                                            Simpan Perolehan APBD</button>
                                        <button id="update-ba" type="button"
                                            class="btn btn-warning mb-3 disabled d-none"><span
                                                class='tf-icons bx bx-pen'></span>
                                            Update Perolehan APBD</button>
                                        <button id="cancel-ba" type="button"
                                            class="btn btn-danger mb-3 disabled d-none"><span
                                                class='tf-icons bx bx-x'></span>
                                            Cancel Pengunaan Ba</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <template id="form-kib">
        @include('components.kib-form')
    </template>
    <div class="modal fade" id="modalMasterBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMasterBarangTitle">Master Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table id="table-master-barang" class="table table-bordered data-table "
                            style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>kode</th>
                                    <th>Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataMaster as $master)
                                    <tr data-master="{{ json_encode($master) }}">
                                        <td>
                                            {{ splitKodeGolongan($master->kodegolongan) . '.' . stringPad($master->kodebidang) . '.' . stringPad($master->kodekelompok) . '.' . stringPad($master->kodesub) . '.' . stringPad($master->kodesubsub, 3) }}
                                        </td>
                                        <td>{{ $master->urai }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td rowspan="2">Data Kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDetailAsset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailAssetTitle">Tambah Detail Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 sp2d" style="height: 200px; overflow-y: scroll;">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO APBD</th>
                                            <th>Tanggal APBD</th>
                                            <th>Nilai APBD</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary align-middle" data-bs-dismiss="modal">
                        <i class='tf-icons bx bx-save mb-1'></i> Close And Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalListBap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailAssetTitle">Modal List Bap <i>{{ getOrganisasi() }}</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table id="list-perolehan" class="table" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>BAP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataBap as $bap)
                                    <tr data-bap="{{ json_encode($bap) }}">
                                        <td>{{ $bap->kodebap }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" onclick="showBap(this)"
                                                    class="btn btn-outline-success btn-sm"><i
                                                        class='bx bxs-pencil'></i>Gunakan</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>Data Bap Tidak Di temukan</td>
                                        <td>Data Bap Tidak Di temukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTambahAttribusi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAttribusiTitle">Form Tambah Nilai Atribusi</i>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="idattribusi">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="deskripsibarangattr">Deskripsi Atribusi</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="icon-deskripsibarangattr" class="input-group-text"><i
                                            class='bx bx-list-plus'></i></span>
                                    <input type="text" class="form-control" id="deskripsibarangattr"
                                        placeholder="Pengiriman Barang" aria-describedby="icon-deskripsibarangattr">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nilaibarangattribusi">Nilai
                                Atribusi</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="icon-nilaibarangattribusi" class="input-group-text"><i
                                            class='bx bx-dollar'></i></span>
                                    <input type="text" class="form-control money-mask" id="nilaibarangattribusi"
                                        placeholder="1000" aria-describedby="icon-nilaibarangattribusi">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button id="tambah-attribusi" type="button" class="btn btn-success"><span
                                        class='tf-icons bx bx-layer-plus'></span> Tambah</button> <button
                                    id="update-attribusi" type="button" class="btn btn-warning d-none"><span
                                        class='tf-icons bx bx-edit'></span> Edit</button>
                                <button id="selesai-attribusi" type="button" class="btn btn-warning"><span
                                        class='tf-icons bx bx-check'></span>
                                    Selesai</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.id.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script>
        window.bastatus = false;
        window.tempAsset = null;
        window.countDetailAsset = 0;
        window.detailAsset = [];
        window.iddetail = null;
        window.idattribusi = null;
        window.foto = null;
        window.state = 'add'
        window.sp2d = 0;
        window.persentaseSp2d = [];
        window.totalbarang = 0;

        function resetBa() {
            $('#ba-form').find('input, textarea').removeAttr('disabled');
            $('#ba-form')[0].reset();
            $('#container-detail-asset').html('');
            $('#save-ba').addClass('disabled').removeClass('d-none');
            $('#update-ba').addClass('disabled d-none');
            $('#cancel-ba').addClass('disabled d-none');
            $('#add-detail-asset').removeClass('disabled');
            $('.attribusi').find('div > table tbody').html('');
            $('#add-attribusi').addClass('d-none')
            $("#container-attribusi-asset").html('')
            window.bastatus = false;
            window.state = 'add';
            window.tempAsset = null;
            window.countDetailAsset = 0;
            window.detailAsset = [];
            window.iddetail = null;
            window.foto = null;
            window.sp2d = 0;
            window.persentaseSp2d = [];
            $('#program').attr('disabled', false);
            $('#kegiatan').attr('disabled', false);
            $("#modalListBap").find(`button.btn-outline-success`)
                .removeClass('disabled')
                .html(`<i class='bx bxs-pencil'></i> Gunakan`);
        }

        function showBap(element) {
            window.state = 'update';
            $(element).parents('tbody')
                .find(`button`)
                .removeClass('disabled')
                .html(`<i class='bx bxs-pencil'></i> Gunakan`);
            $(element).addClass('disabled').html(`<i class='bx bx-x'></i> Digunakan`);
            let data = $(element).parents('tr').data('bap');
            $("#ba-form").find('input,textarea').map((_, element) => {
                name = $(element).attr('name');
                if (data.hasOwnProperty(name) && data[name] != null && data[name] != "") {
                    if ($(element).hasClass('datetime-picker')) {
                        $(element).datepicker('update', new Date(data[name]))
                    } else {
                        $(element).val(data[name]).trigger('change')
                    }
                }
                setTimeout(() => {
                    $(element).attr('disabled', true)
                }, 150);
            });
            $.ajax({
                type: "get",
                url: `{{ route('perolehan-apbd.bap.show') }}/${data.idbap}`,
                dataType: "json",
                success: function(response) {
                    $('#container-detail-asset').html('');
                    response.data.dataKib.forEach(kib => {
                        kib.nilaibarang = parseFloat(currencyToNumberFormat(` ${kib.nilaibarang}`)) /
                            100;
                        window.tempAsset = kib;
                        window.iddetail = kib.iddetail;
                        window.countDetailAsset = kib.iddetail;
                        generateListDetailAsset(kib);
                    });
                    var sp2d_attribusi = [];
                    response.data.kibAttribusi.forEach(kib => {
                        window.tempAsset = kib;
                        window.iddetail = kib.iddetail;
                        window.countDetailAsset = kib.iddetail;
                        generateListAttribusi(kib);
                        if (sp2d_attribusi.length == 0) {
                            sp2d_attribusi.push(...JSON.parse(kib.sp2d));
                        }
                    });
                    $("#program").val(response.data.sp2d.program).trigger('change');
                    setTimeout(() => {
                        $("#kegiatan").val(response.data.sp2d.kegiatan).trigger('change');
                        $('#program').attr('disabled', true);
                        $('#kegiatan').attr('disabled', true);
                        let nilaikontrak = parseFloat(currencyToNumberFormat(
                            ` ${$('#nilaikontrak').val()}`)) ?? 0;
                        $('.contract-value').html(numberFormat(nilaikontrak - window.totalbarang));
                    }, 500);

                    $("#add-attribusi").removeClass('d-none disabled');
                    $("#update-ba").removeClass('disabled d-none');
                    $("#cancel-ba").removeClass('disabled d-none');
                    $("#save-ba").addClass('disabled d-none');
                }
            });
            $("#modalListBap").modal('hide');
        }

        function getListbap() {
            $.ajax({
                type: "GET",
                url: "{{ route('perolehan.bap.apbd') }}",
                dataType: "json",
                success: function(response) {
                    var html = '';
                    response.data.forEach(bap => {
                        html +=
                            `<tr data-bap='${JSON.stringify(bap)}'><td>${bap.kodebap}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" onclick="showBap(this)" class="btn btn-outline-success btn-sm"><i
                                                class='bx bxs-pencil'></i>Gunakan</button>
                                    </div>
                                </td>
                            </tr>`;
                    });
                    $('#list-perolehan tbody').html(html);
                }
            });
        }

        function updateListData(data) {
            $("#container-detail-asset").find('li').map((index, element) => {
                if ($(element).data('id') == window.iddetail) {
                    $(element).find('.badge.bg-primary:first').html(data.jumlah)
                    $(element).find('.badge.bg-primary:last').html(numberFormat(currencyToNumberFormat(
                        ` ${data.nilaibarang}`)))
                    $(element).data('master', {
                        ...window.tempAsset,
                        ...data,
                    });
                }
            })
        }

        function dataToValueElement(data) {
            $('#modalDetailAsset form').find('input, select, textarea').map((index, element) => {
                let name = $(element).attr('name');
                if (data.hasOwnProperty(name)) {
                    let value = data[name];
                    if (typeof(value) == 'string' && value.split('.00').length > 1 && value.split('.00')[1] ==
                        '') {
                        value = value.split('.00').join('');
                    }
                    $(`[name=${name}]`).val(value).trigger("change")
                }
            })
        }

        function editDetailAsset(element) {
            var data = $($(element).parent()).parent().data('master');
            window.iddetail = data.iddetail;
            $("#container-detail-asset").find('li').map((index, element) => {
                if ($(element).data('id') == window.iddetail) {
                    if (typeof($(element).data('master').sp2d) == 'string') {
                        $(element).data('master').sp2d = JSON.parse($(element).data('master').sp2d);
                    }
                    $(element).data('master').sp2d.map((sp2d) => {
                        let id = sp2d.id.split('_');
                        $("#modalDetailAsset").find('.pilih-sp2d').map((index,
                            container_sp2d) => {
                            let datasp2d = $(container_sp2d).parents(
                                'tr').data('sp2d');
                            if (id[0] == datasp2d.nosp2d &&
                                id[1] == datasp2d.tglsp2d && datasp2d
                                .keperluan == sp2d.keperluan && datasp2d
                                .kdper == sp2d.kdper) {
                                if (window.state != 'update') {
                                    $(container_sp2d).trigger('click');
                                } else {
                                    setTimeout(() => {
                                        $(container_sp2d).trigger('click');
                                    }, 2000);
                                }
                                if ($(container_sp2d).prop(
                                        'disabled') == true) {
                                    $(container_sp2d).prop('disabled',
                                        false);
                                    $(container_sp2d)
                                        .parents('tr').removeClass(
                                            'bg-warning text-white')
                                }
                            }
                        })
                    });
                }
            });
            renderFormDetailAsset(data, 'edit');
            window.totalbarang -= parseFloat(currencyToNumberFormat(` ${data.nilaibarang}`)) * parseInt(data.jumlah);
            setTimeout(() => {
                dataToValueElement(data);
            }, 500);
        }

        function generateListDetailAsset(data) {
            $('#container-detail-asset').append(`<li
                class="list-group-item d-flex justify-content-between align-items-center" data-id='${data.iddetail}' data-master='${JSON.stringify({...data,...window.tempAsset})}'>
                <div class='col-8'>
                    ${window.tempAsset.urai}
                </div>
                <div class='col-4 d-flex justify-content-between align-items-center'>
                    <span class="badge bg-primary icon-name" style='font-size:1rem;'>${parseInt(data.jumlah)}</span>
                    <span class="badge bg-primary icon-name" style='font-size:1rem;'>${numberFormat(currencyToNumberFormat(` ${data.nilaibarang}`))}</span>
                    <span class="badge bg-danger" onclick="deleteDetailAsset(${data.iddetail})"><i class='bx bx-trash bx-xs'></i></span>
                    <span class="badge bg-info"><i class='bx bx-show bx-xs'></i></span>
                    <span class="badge bg-success" onclick="editDetailAsset(this)"><i class='bx bx-pencil bx-xs'></i></span>
                </div>
            </li>`);
            window.totalbarang += parseFloat(currencyToNumberFormat(` ${data.nilaibarang}`)) * parseInt(data.jumlah ??
                1);
        }

        function generateListAttribusi(data) {
            let elementExists = $('#container-attribusi-asset').find('li').map(function(index, element) {
                let current_data = $(element).data('attribusi');
                if (current_data.deskripsibarang.toLowerCase() == data.deskripsibarang.toLowerCase()) {
                    return element;
                }
            });
            if (elementExists.length !== 1) {
                if (data.iddetail == undefined) {
                    data.iddetail = window.countDetailAsset++;
                }
                if (data.sp2d == undefined) {
                    data.sp2d = JSON.stringify(window.persentaseSp2d);
                }
                $('#container-attribusi-asset').append(`<li
                class="list-group-item d-flex justify-content-between align-items-center" data-id='${data.iddetail}' data-attribusi='${JSON.stringify({...data})}'>
                <div class='col-8'>
                    ${data.deskripsibarang}
                </div>
                <div class='col-4 d-flex justify-content-end gap-3 align-items-center'>
                    <span class="badge bg-info icon-name" style='font-size:1rem;'>${numberFormat(data.nilaibarang)}</span>
                    <span class="badge bg-danger" onclick="deleteDetailAttribusi(${data.iddetail})"><i class='bx bx-trash bx-xs'></i></span>
                    <span class="badge bg-info"><i class='bx bx-show bx-xs'></i></span>
                    <span class="badge bg-success" onclick="editDetailAttribusi(this)"><i class='bx bx-pencil bx-xs'></i></span>
                </div>
            </li>`)
            }
        }

        function deleteDetailAsset(id) {
            iziToast.question({
                timeout: 5000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Warning',
                message: 'Apakah anda yakin akan menghapus detail aset ini?',
                position: 'center',
                buttons: [
                    ['<button><b>IYA</b></button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');
                        $("#container-detail-asset").find('li').map((index, element) => {
                            if ($(element).data('id') == id) {
                                if (typeof($(element).data('master').sp2d) == 'string') {
                                    $(element).data('master').sp2d = JSON.parse($(element).data(
                                        'master').sp2d);
                                }
                                if (typeof($(element).data('master').nilaibarang) == 'number') {
                                    window.totalbarang -= $(element).data(
                                        'master').nilabarang * parseInt($(element).data(
                                        'master').jumlah);
                                } else {
                                    window.totalbarang -= parseFloat(currencyToNumberFormat(
                                            ` ${$(element).data('master').nilaibarang}`)) *
                                        parseInt($(element).data('master').jumlah ?? 1);
                                }
                                let nilaikontrak = parseFloat(currencyToNumberFormat(
                                    ` ${$('#nilaikontrak').val()}`)) ?? 0;
                                $('.contract-value').html(numberFormat(nilaikontrak - window
                                    .totalbarang));
                                $(element).data('master').sp2d.map((sp2d) => {
                                    let id = sp2d.id.split('_');
                                    $(document).find('.pilih-sp2d').map((index,
                                        container_sp2d) => {
                                        let datasp2d = $(container_sp2d)
                                            .parents(
                                                'tr').data('sp2d');
                                        if (id[0] == datasp2d.nosp2d &&
                                            id[1] == datasp2d.tglsp2d &&
                                            datasp2d.keperluan == sp2d.keperluan &&
                                            datasp2d.kdper == sp2d.kdper) {
                                            let nilai = parseFloat(
                                                currencyToNumberFormat(
                                                    $(container_sp2d)
                                                    .parents('tr')
                                                    .find('td:nth-child(3)')
                                                    .html())) / 100;
                                            nilai += parseFloat(sp2d.nilai);
                                            $(container_sp2d)
                                                .parents('tr')
                                                .find('td:nth-child(3)')
                                                .html(numberFormat(nilai));
                                            if ($(container_sp2d).prop(
                                                    'disabled') == true) {
                                                $(container_sp2d).prop(
                                                    'disabled',
                                                    false);
                                                $(container_sp2d)
                                                    .parents('tr').removeClass(
                                                        'bg-warning text-white')
                                            }
                                        }
                                    })
                                });
                                $(element).remove()
                            }
                        });
                        ($("#container-detail-asset").find('li').length == 0) ? $("#save-ba").addClass(
                            'disabled'): '';
                    }, true],
                    ['<button>TIDAK</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');

                    }],
                ],
            });
        }

        function editDetailAttribusi(elementattribusi) {
            let sp2d = $(elementattribusi).parents('li').data('attribusi');
            $('#modalTambahAttribusi').modal('show');
            $('#nilaibarangattribusi').val(parseFloat(sp2d.nilaibarang));
            $('#deskripsibarangattr').val(sp2d.deskripsibarang);
            $('#idattribusi').val(sp2d.iddetail);
            $('#update-attribusi').removeClass('d-none');
            $('#tambah-attribusi').addClass('d-none');
            $('#selesai-attribusi').addClass('d-none');
            sp2d.sp2d = JSON.parse(sp2d.sp2d);
            window.sp2d = parseFloat(sp2d.nilaibarang)
            $('.attribusi').find('div > table tbody > tr').map((index, element) => {
                sp2d.sp2d.forEach((rekening) => {
                    let data_rekening = $(element).data('sp2d');
                    if (rekening.id == `${data_rekening.nosp2d}_${data_rekening.tglsp2d}` && rekening
                        .kdper == data_rekening.kdper && rekening.keperluan == data_rekening.keperluan
                    ) {
                        $(element).find('td:nth-child(4) > input').click();
                    }
                })
            });
        }

        function updateDetailAttribusi(data, id) {
            data.sp2d = JSON.stringify(window.persentaseSp2d);
            $('#container-attribusi-asset').find('li').map((index, element) => {
                if ($(element).data('id') == id) {
                    $(element).data('attribusi', data);
                    $(element).find('.icon-name').html(`${numberFormat(data.nilaibarang)}`)
                }
            });
            $("#modalTambahAttribusi").modal('hide');
            $('#add-attribusi').addClass('disabled');
            $('#save-ba').removeClass('disabled');
            $('#update-ba').removeClass('disabled');
            $(document).find('.pilih-sp2d').map((index,
                container_sp2d) => {
                if (container_sp2d.checked == true) {
                    $(container_sp2d).prop('checked', false)
                }
            });
        }

        function deleteDetailAttribusi(id) {
            iziToast.question({
                timeout: 5000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Warning',
                message: 'Apakah anda yakin akan menghapus nilai atribusi ini?',
                position: 'center',
                buttons: [
                    ['<button><b>IYA</b></button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');
                        $('#container-attribusi-asset').find('li').map((index, element) => {
                            if ($(element).data('id') == id) {
                                let data_sp2d = JSON.parse($(element).data('attribusi').sp2d)
                                data_sp2d.map((sp2d) => {
                                    let id = sp2d.id.split('_');
                                    $(document).find('.pilih-sp2d').map((index,
                                        container_sp2d) => {
                                        let datasp2d = $(container_sp2d)
                                            .parents(
                                                'tr').data('sp2d');
                                        if (id[0] == datasp2d.nosp2d &&
                                            id[1] == datasp2d.tglsp2d &&
                                            datasp2d
                                            .keperluan == sp2d.keperluan &&
                                            datasp2d
                                            .kdper == sp2d.kdper) {
                                            let nilai = parseFloat(
                                                currencyToNumberFormat(
                                                    $(container_sp2d)
                                                    .parents('tr')
                                                    .find('td:nth-child(3)')
                                                    .html())) / 100;
                                            nilai += parseFloat(sp2d.nilai);
                                            $(container_sp2d)
                                                .parents('tr')
                                                .find('td:nth-child(3)')
                                                .html(numberFormat(nilai));
                                            if ($(container_sp2d).prop(
                                                    'disabled') == true) {
                                                $(container_sp2d).prop(
                                                    'disabled',
                                                    false);
                                                $(container_sp2d)
                                                    .parents('tr').removeClass(
                                                        'bg-warning text-white')
                                            }
                                        }
                                    })
                                });
                                $(element).remove();
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
        }

        function onClickMasterBarang() {
            $('#table-master-barang tbody').find('tr').click(function() {
                renderFormDetailAsset($(this).data('master'));
                $("#modalMasterBarang").modal('hide');
            });
        }

        function initialDataTable() {
            $('#table-master-barang').on('draw.dt', function() {
                onClickMasterBarang()
            });
            $('#list-perolehan').on('draw.dt', function() {});
        }

        function setMaskMoney() {
            $('.money-mask').attr('maxlength', '22').inputmask('numeric', {
                radixPoint: ",",
                allowMinus: false,
                regex: "[0-9]*",
                groupSeparator: ".",
                rightAlign: false,
                digits: 2,
                min: 0,
                alias: 'numeric'
            });
        }

        function hideListPerolehan() {
            $("#content-list-perolehan").switchClass('d-block', 'd-none', 50)
            $("#container-list-perolehan").switchClass('col-md-4', 'col-md-1', 100);
            $("#container-form-perolehan").switchClass('col-md-8', 'col-md-11', 100);
            $("#show-list-perolehan").removeClass('d-none')
        }

        function showListPerolehan() {
            $("#container-list-perolehan").switchClass('col-md-1', 'col-md-4', 100);
            $("#container-form-perolehan").switchClass('col-md-11', 'col-md-8', 100);
            $("#content-list-perolehan").switchClass('d-none', 'd-block', 150)
            $("#show-list-perolehan").addClass('d-none')
        }

        function showHideAsalUsul(element) {
            if (element.value != "") {
                $("#kategorikodeasalusul").find(`option[data-attr=${element.value}]`).attr('disabled', false);
                $("#kategorikodeasalusul").find(`:not(option[data-attr=${element.value}])`).attr('disabled', true);
            }
        }

        function getMasterData() {
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.asal-usul') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=select-asal-usul-barang-perolehan-aset]').html(response.html_kategori).trigger(
                        'change');
                    $("#kategorikodeasalusul").html(response.html_asal_usul);
                }
            });
            $('[name=select-asal-usul-barang-perolehan-aset]').change(function() {
                showHideAsalUsul(this);
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.kondisi') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodekondisi]').html(response.html_kondisi).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.satuan') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodesatuan]').html(response.html_satuan)
                        .trigger('change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.status-tanah') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodestatustanah]').html(response.html_status_tanah).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.golongan-barang') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodegolonganbarang]').html(response.html_golongan_barang).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.warna') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodewarna]').html(response.html_warna).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.data.hak') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodehak]').html(response.html_hak).trigger('change');
                }
            });
        }

        function numberFormat(nilai, prefix = 'Rp. ') {
            return $.fn.dataTable.render.number('.', ',', 2, prefix).display(nilai);
        }

        function currencyToNumberFormat(str) {
            let result = "";
            //  result format if your string is valid
            //  example valid string Rp 12.123.123.123,31
            //  the result 1212312312331
            result = str.split(" ");
            result = result[1].split(".").join("").split(",").join(".");
            return result;
        }

        function renderFormDetailAsset(master, state = 'add') {
            window.tempAsset = master;
            if (state == 'add') {
                $('#modalDetailAsset').find('.modal-title').html(`Tambah Detail Aset ${master.urai}`);
            } else {
                $('#modalDetailAsset').find('.modal-title').html(`Edit Detail Aset ${master.urai}`);
            }
            $('#modalDetailAsset').modal('show');
            const container = document.querySelector("#modalDetailAsset .modal-body > .row > .col-12:last-child");
            const template = document.querySelector("#form-kib");
            const cloneTemplate = template.content.cloneNode(true);
            container.innerHTML = "";
            switch (master.kodegolongan.toString()) {
                case '131':
                    container.appendChild(cloneTemplate.querySelector("#form-kib-a"))
                    break;
                case '132':
                    container.appendChild(cloneTemplate.querySelector("#form-kib-b"))
                    break;
                case '133':
                    container.appendChild(cloneTemplate.querySelector("#form-kib-c"))
                    break;
                case '134':
                    container.appendChild(cloneTemplate.querySelector("#form-kib-d"))
                    break;
                case '135':
                    container.appendChild(cloneTemplate.querySelector("#form-kib-e"));
                    detailform = container.querySelector("#container-detail-form")
                    switch (parseInt(`${master.kodekelompok}${master.kodesub}`)) {
                        case 17:
                            detailform.appendChild(cloneTemplate.querySelector("#detail-form-kib-e-17"))
                            break;
                        case 18:
                            detailform.appendChild(cloneTemplate.querySelector("#detail-form-kib-e-18"))
                            break;
                        case 19:
                            detailform.appendChild(cloneTemplate.querySelector("#detail-form-kib-e-19"))
                            break;

                        default:
                            break;
                    }
                    break;
                case '136':
                    container.appendChild(cloneTemplate.querySelector("#form-kib-f"))
                    break;
                default:
                    break;
            }
            setMaskMoney();
            getMasterData();
            $('.yearpicker').datepicker({
                format: "yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "id",
                autoclose: true,
                orientation: "bottom auto",
                toggleActive: true,
                startView: 2,
                minViewMode: 2,
                container: $('#modalDetailAsset')
            });
            $('.select2modal').select2({
                dropdownParent: $("#modalDetailAsset"),
                closeOnSelect: false
            });
            $('.datetimepickermodal').datepicker({
                format: "dd MM yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "id",
                autoclose: true,
                orientation: "top auto",
                toggleActive: true,
                container: '#modalDetailAsset'
            });
            $("#qrcode_foto").change(function() {
                window.foto = handleFileFoto();
            });
        }

        function validateElement(
            form,
            type = 'ba',
            contextElement = 'label',
            contextClass = '.bxs-star',
            validateElementParent = '.input-group',
            validateElement = 'input,select,textarea',
            addOnElement = 'span',
        ) {
            var error = [];
            if (type == 'ba') {
                var elementValidate = $($(`#${form} ${contextElement}:has(${contextClass})`).siblings(
                    `${validateElementParent}`)).find(`${validateElement}`);
            } else {
                var elementValidate = $(`#${form} ${contextElement}:has(${contextClass})`).siblings(
                    `${validateElement}`);
            }
            elementValidate.map((index, element) => {
                if ($(element).val() == "" || $(element).val() == null || ($(element).val() == "" || $(element)
                        .val() == null && $(element).hasClass('is-invalid'))) {
                    $(element).addClass('is-invalid');
                    if (type == 'ba') {
                        $(element).siblings(`${addOnElement}`).addClass('border-1 border-danger')
                    }
                    error.push({
                        name: $(element).attr('name'),
                        message: `${$(element).labels()[0].innerText.trim()} Tidak Boleh Kosong`,
                    });
                }
            });
            return error;
        }

        function savePerolehan() {
            $('#kegiatan').attr('disabled', false);
            $('#program').attr('disabled', false);
            let data = serializeObject($('#ba-form'));
            let detailData = [];
            let detailAttribusi = [];
            $('#container-detail-asset').find('li').map((index, element) => {
                detailData.push($(element).data('master'))
            });
            $('#container-attribusi-asset').find('li').map((index, element) => {
                detailAttribusi.push($(element).data('attribusi'))
            });
            data.detail = detailData;
            data.atribusi = detailAttribusi;
            data._token = `{{ csrf_token() }}`;
            $.ajax({
                type: "POST",
                url: "{{ route('perolehan-apbd.store') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    $('#ba-form')[0].reset();
                    $('#container-detail-asset').html('');
                    $('#save-ba').addClass('disabled');
                    $(window).scrollTop(0);
                    $('.datetime-picker').datepicker('clearDates');
                    setTimeout(() => {
                        $('.container-alert-ba').html(`<div class="alert alert-success alert-ba">
                            <div class="row justify-content-start align-items-center">
                                <div class="col-1">
                                    <i class='bx bxs-check-circle bx-lg' ></i>
                                </div>
                                <div class="col-11 fw-bold">
                                    <span>Success</span>
                                </div>
                            </div>
                            <div class="p-2">
                                ${response.message}
                            </div>
                        </div>`);
                    }, 500)
                    setTimeout(() => {
                        $('.alert-ba').toggle("fade", 1000);
                    }, 1500);
                    $('.attribusi').find('div > table tbody').html('');
                    $('#add-attribusi').addClass('d-none');
                    $('.contract-value').html('Rp. 0');
                    $('#add-detail-asset').removeClass('disabled');
                    $("#container-attribusi-asset").html('');
                    $('#update-ba').addClass('d-none');
                    $('#cancel-ba').addClass('d-none');
                    window.bastatus = false;
                    window.tempAsset = null;
                    window.countDetailAsset = 0;
                    window.detailAsset = [];
                    window.iddetail = null;
                    window.foto = null;
                    window.totalbarang = 0;
                    getListbap();
                }
            });
        }

        function updatePerolehan() {
            $('#ba-form').find('input, textarea, select').removeAttr('disabled');
            let data = serializeObject($('#ba-form'));
            let detailData = [];
            let detailAttribusi = [];
            $('#container-detail-asset').find('li').map((index, element) => {
                detailData.push($(element).data('master'))
            });
            $('#container-attribusi-asset').find('li').map((index, element) => {
                detailAttribusi.push($(element).data('attribusi'))
            });
            data.detail = detailData;
            data.atribusi = detailAttribusi;
            data._token = `{{ csrf_token() }}`;
            $.ajax({
                type: "PUT",
                url: "{{ route('perolehan-apbd.update') }}/" + data.kodebap,
                data: data,
                dataType: "json",
                success: function(response) {
                    $('#ba-form')[0].reset();
                    $('#container-detail-asset').html('');
                    $('#save-ba').addClass('disabled');
                    $(window).scrollTop(0);
                    $('.datetime-picker').datepicker('clearDates');
                    setTimeout(() => {
                        $('.container-alert-ba').html(`<div class="alert alert-success alert-ba">
                                <div class="row justify-content-start align-items-center">
                                    <div class="col-1">
                                        <i class='bx bxs-check-circle bx-lg' ></i>
                                    </div>
                                    <div class="col-11 fw-bold">
                                        <span>Success</span>
                                    </div>
                                </div>
                                <div class="p-2">
                                    ${response.message}
                                </div>
                            </div>`);
                    }, 500)
                    setTimeout(() => {
                        $('.alert-ba').toggle("fade", 1000);
                    }, 1500);
                    $('.attribusi').find('div > table tbody').html('');
                    $('#add-attribusi').addClass('d-none')
                    $("#container-attribusi-asset").html('')
                    $('#update-ba').addClass('d-none');
                    $('#cancel-ba').addClass('d-none');
                    $('#save-ba').removeClass('d-none')
                    window.bastatus = false;
                    window.tempAsset = null;
                    window.state = 'add';
                    window.countDetailAsset = 0;
                    window.detailAsset = [];
                    window.iddetail = null;
                    window.foto = null;
                    window.totalbarang = 0;
                    getListbap();
                }
            });
        }

        function handleFileFoto() {
            var imageArray = []
            var fileInput = document.getElementById('qrcode_foto');
            var imageContainer = document.getElementById('container-image-preview');
            $(imageContainer).html('');
            for (var i = 0; i < fileInput.files.length; i++) {
                var file = fileInput.files[i];

                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var img =
                            `<img src='${e.target.result}' style='height:150px; width:auto;' class='img-thumbnail col'>`;
                        imageArray.push(e.target.result);
                        if (fileInput.files.length > 1) {
                            $(imageContainer).append(img);
                        } else {
                            $(imageContainer).html(img);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            }
            return imageArray
        }

        function hitungPersentase() {
            window.persentaseSp2d = $(document).find('.pilih-sp2d:checked').map((index, element) => {
                let data = $(element).parents('tr').data('sp2d');
                return ({
                    persentase: parseFloat(parseFloat(data.sisa_nilai) == 0.00 ? data.nilai : data
                        .sisa_nilai) / window.sp2d * 100,
                    id: `${data.nosp2d}_${data.tglsp2d}`,
                    keperluan: `${data.keperluan}`,
                    kdper: `${data.kdper}`,
                })
            });
            window.persentaseSp2d = window.persentaseSp2d.toArray();
        }

        function minusNilaiSp2d(nilai, jumlah) {
            if (!$('#modalDetailAsset').hasClass('show')) {
                hitungPersentase()
            }
            $(document).find('.pilih-sp2d:checked').map((index, element) => {
                let data = $(element).parents('tr').data('sp2d');
                let nilaisisa = 0;
                persentase = window.persentaseSp2d[index];
                window.persentaseSp2d[index].nilai = parseFloat((persentase.id ==
                        `${data.nosp2d}_${data.tglsp2d}`) ? ((persentase.persentase / 100) * nilai) *
                    jumlah : 0).toFixed(2);
                nilaisisa = parseFloat(parseFloat(data.sisa_nilai) < parseFloat(data.nilai) && parseFloat(
                    data.sisa_nilai) != 0.00 ? data.sisa_nilai : data.nilai) - parseFloat((persentase
                        .id == `${data.nosp2d}_${data.tglsp2d}`) ? ((persentase.persentase / 100) * nilai) *
                    jumlah : 0).toFixed(2);
                $(element).parents('tr').find('td:nth-child(3)').html(numberFormat(nilaisisa))
            });
            if ($('#modalDetailAsset').hasClass('show')) {
                $('#modalDetailAsset').find('.pilih-sp2d').map((index, element) => {
                    $('.attribusi').find('.pilih-sp2d').map((indexatt, elementatt) => {
                        if (index == indexatt) {
                            $(elementatt).parents('tr').find('td:nth-child(3)').html($(element).parents(
                                'tr').find('td:nth-child(3)').html());
                        }
                    });
                });
            }
        }

        function resetElementRekening() {
            $(document).find('.pilih-sp2d').map((index, element) => {
                if (element.checked == true) {
                    if (currencyToNumberFormat($(element).parents('tr').find('td:nth-child(3)').html()) ==
                        '000') {
                        $(element).parents('tr').addClass('bg-warning text-white')
                        $(element).prop('checked', false).attr('disabled', true);
                    } else {
                        $(element).prop('checked', false);
                    }
                }
            });
        }

        function elementRekening(data) {
            let html = ``;
            data.forEach(element => {
                html += `<tr ${(element.sisa_nilai != '0.00') ? 'class=""' : "class='bg-warning text-white'"} data-sp2d='${JSON.stringify(element)}' >
                            <td>${element.nosp2d}</td>
                            <td>${element.tglsp2d}</td>
                            <td>${numberFormat((element.nilai == element.sisa_nilai) ? element.nilai : element.sisa_nilai)}</td>
                            <td><input type="checkbox" class='form-check-input pilih-sp2d'></td>
                        </tr>`;
            });
            $(".sp2d").find('table > tbody').html(html);
            if (window.state !== 'update') {
                $($(".sp2d")[0]).find('tr > td:last-child > input').prop('disabled', 'true')
            }
            pilihAPBD();
        }

        function pilihAPBD() {
            $('.pilih-sp2d').click(function() {
                let data = $(this).parents('tr').data('sp2d');
                if (window.sp2d == 0) {
                    if (this.checked == true) {
                        window.sp2d = (window.state == 'update' && window.iddetail !== null && $(
                                '#modalDetailAsset').hasClass('show')) ? parseFloat(data.sisa_nilai == data
                                .nilai ?
                                data.nilai : data.sisa_nilai) + (parseFloat(currencyToNumberFormat(
                                ` ${$('[name=nilaibarang]').val()}`)) * parseInt($('#jumlah').val())) :
                            parseFloat(
                                data.sisa_nilai) < parseFloat(data.nilai) && parseFloat(data.sisa_nilai) ==
                            0.00 ?
                            parseFloat(data.nilai) : parseFloat(data.sisa_nilai);
                        if ($('#modalDetailAsset').hasClass('show')) {
                            if ($('[name=nilaibarang]').siblings('.form-text').length == 0) {
                                $('[name=nilaibarang]')
                                    .parents('.mb-3')
                                    .append(
                                        `<div class="form-text text-danger">Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}</div>`
                                    );
                            } else {
                                $('[name=nilaibarang]')
                                    .siblings('.form-text')
                                    .html(
                                        `Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}`
                                    );
                            }
                        } else {
                            if ($('#nilaibarangattribusi').parents('.input-group').siblings('.form-text')
                                .length ==
                                0) {
                                $('#nilaibarangattribusi')
                                    .parents('.col-sm-10')
                                    .append(
                                        `<div class="form-text text-danger">Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}</div>`
                                    );
                            } else {
                                $('#nilaibarangattribusi')
                                    .parents('.col-sm-10')
                                    .find('.form-text')
                                    .html(
                                        `Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}`
                                    );
                            }
                        }
                    }
                    hitungPersentase()
                    if (!$('#modalDetailAsset').hasClass('show')) {
                        $('#add-detail-asset').addClass('disabled');
                        $('#add-attribusi').removeClass('d-none disabled');
                        $('#save-ba').addClass('disabled');
                        $('#update-ba').addClass('disabled');
                    }
                } else {
                    if (this.checked == true) {
                        window.sp2d += parseFloat(data.sisa_nilai == data.nilai ? data.nilai : data.sisa_nilai);
                    } else {
                        window.sp2d -= parseFloat(data.sisa_nilai == data.nilai ? data.nilai : data.sisa_nilai);
                    }
                    hitungPersentase();
                    if ($('#modalDetailAsset').hasClass('show')) {
                        $('[name=nilaibarang]')
                            .siblings('.form-text')
                            .html(`Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}`);
                    } else {
                        if ($('#nilaibarangattribusi')
                            .parents('.col-sm-10')
                            .find('.form-text').length == 0) {
                            $('#nilaibarangattribusi')
                                .parents('.col-sm-10')
                                .append(
                                    `<div class="form-text text-danger">Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}</div>`
                                );
                        } else {
                            $('#nilaibarangattribusi')
                                .parents('.col-sm-10')
                                .find('.form-text')
                                .html(
                                    `Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}`);
                        }
                    }
                }
                if ($('#modalDetailAsset').hasClass('show')) {
                    $('input[name=nilaibarang]').keyup(function() {
                        if (window.sp2d > 0 && parseFloat(currencyToNumberFormat(` ${this.value}`)) *
                            parseInt($('#jumlah').val() ?? 1) <= window.sp2d) {
                            $(this).removeClass('is-invalid');
                            minusNilaiSp2d(parseFloat(currencyToNumberFormat(` ${this.value}`)), $(
                                '[name=jumlah]').val() ?? 1)
                        } else {
                            $(this).addClass('is-invalid');
                        }
                    });
                } else {
                    $('#nilaibarangattribusi').keyup(function() {
                        if (window.sp2d > 0 && parseFloat(currencyToNumberFormat(` ${this.value}`)) <=
                            window
                            .sp2d) {
                            $(this).removeClass('is-invalid');
                            minusNilaiSp2d(parseFloat(currencyToNumberFormat(` ${this.value}`)), 1)
                        } else {
                            $(this).addClass('is-invalid');
                        }
                    });
                }
                if (window.state == 'update') {
                    $('#add-attribusi').removeClass('disabled');
                    $('#add-detail-asset').removeClass('disabled');
                }
            });
        }

        $(function() {
            $('.datetime-picker').datepicker({
                format: "dd MM yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "id",
                autoclose: true,
                orientation: "bottom auto",
                toggleActive: true
            });
            $('.yearpicker').datepicker({
                format: "yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "id",
                autoclose: true,
                orientation: "bottom auto",
                toggleActive: true,
                startView: 2,
                minViewMode: 2
            });
            $('button.btn-close.float-end').click(function() {
                hideListPerolehan()
            });
            $('#search-bap').click(function() {
                $("#modalListBap").modal('show')
            });
            $('#show-list-perolehan').click(function() {
                showListPerolehan();
            });
            $('#program').change(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('perolehan-apbd.get-kegiatan') }}/" + this.value,
                    dataType: "json",
                    success: function(response) {
                        $('#kegiatan').html(response.data);
                    }
                });
            });
            $('#kegiatan').change(function() {
                $.ajax({
                    type: "get",
                    url: "{{ route('perolehan-apbd.get-rekening') }}/" + this.value + "/" + $(
                        '#program').val(),
                    dataType: "json",
                    success: function(response) {
                        elementRekening(response.data);
                    }
                });
            });
            $('.formated').blur(function() {
                if (this.value == "") {
                    $(this).focus();
                    return
                }
                $(this).val(`BA-APBD-{{ env('APP_YEAR') }}-${this.value}-{{ kodeOrganisasi() }}`);
                let input = this
                $.ajax({
                    type: "get",
                    url: "{{ route('perolehan.bap.check') }}/" +
                        `${$(this).val()}/${$(this).attr('name')}`,
                    dataType: "json",
                    success: function(response) {
                        $(input).removeClass('is-invalid').siblings('span').removeClass(
                            'border-danger');
                    },
                    error: function(error) {
                        iziToast.error({
                            title: 'Error',
                            message: error.responseJSON.message,
                            position: 'topRight',
                            icon: "bx bx-error",
                            timeout: 10000,
                            displayMode: 2
                        });
                        $(input).addClass('is-invalid').siblings('span').addClass(
                            'border-danger');
                        $(input).focus()
                    }
                });
            });
            $('.formated').focus(function() {
                value = (this.value).split(`BA-APBD-{{ env('APP_YEAR') }}-`)
                    .join('')
                    .split(`-{{ kodeOrganisasi() }}`).join('');
                $(this).val(value)
            });
            $('#add-attribusi').click(function(e) {
                e.prevenDefault;
                if (window.sp2d === 0) {
                    return
                }
                $('#modalTambahAttribusi').modal('show');
                $('#add-detail-asset').addClass('disabled');
            });
            $('#update-attribusi').click(function() {
                if ($('#deskripsibarangattr').val() !== '' && $('#nilaibarangattribusi').val() !== '') {
                    let data = {
                        'deskripsibarang': $('#deskripsibarangattr').val(),
                        'nilaibarang': parseFloat(currencyToNumberFormat(` ${$('#nilaibarangattribusi')
                            .val()}`)),
                    };
                    updateDetailAttribusi(data, $('#idattribusi').val());
                    $('#deskripsibarangattr').val('');
                    $('#idattribusi').val('');
                    $('#nilaibarangattribusi').val('');
                    window.sp2d = window.sp2d - parseFloat(currencyToNumberFormat(
                        ` ${data.nilaibarang}`));
                    $('#nilaibarangattribusi')
                        .parents('.col-sm-10')
                        .find('.form-text')
                        .html(
                            `Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}`);
                    window.persentaseSp2d.map((sp2d) => {
                        $(document).find('.pilih-sp2d').map((index, container_sp2d) => {
                            let datasp2d = $(container_sp2d)
                                .parents('tr').data('sp2d');
                            let id = sp2d.id.split('_');
                            if (id[0] == datasp2d.nosp2d &&
                                id[1] == datasp2d.tglsp2d && datasp2d
                                .keperluan == sp2d.keperluan && datasp2d
                                .kdper == sp2d.kdper) {
                                datasp2d.sisa_nilai = (((datasp2d.hasOwnProperty(
                                            'sisa_nilai')) ? parseFloat(datasp2d
                                            .sisa_nilai) : parseFloat(datasp2d
                                            .nilai)) -
                                        parseFloat(sp2d.nilai))
                                    .toString();
                                $(container_sp2d)
                                    .parents('tr').data('sp2d', datasp2d);
                            }
                        })
                    });
                    window.persentaseSp2d = [];
                    window.sp2d = 0;
                    hitungPersentase();
                }
            });
            $('#tambah-attribusi').click(function() {
                if ($('#deskripsibarangattr').val() !== '' && $('#nilaibarangattribusi').val() !== '') {
                    let data = {
                        'deskripsibarang': $('#deskripsibarangattr').val(),
                        'nilaibarang': parseFloat(currencyToNumberFormat(` ${$('#nilaibarangattribusi')
                            .val()}`)),
                    };
                    generateListAttribusi(data);
                    $('#deskripsibarangattr').val('');
                    $('#nilaibarangattribusi').val('');
                    window.sp2d = window.sp2d - parseFloat(currencyToNumberFormat(
                        ` ${data.nilaibarang}`));
                    $('#nilaibarangattribusi')
                        .parents('.col-sm-10')
                        .find('.form-text')
                        .html(
                            `Batas Input Nilai pada aset ini ${numberFormat(window.sp2d.toString())}`);
                    window.persentaseSp2d.map((sp2d) => {
                        $(document).find('.pilih-sp2d').map((index, container_sp2d) => {
                            let datasp2d = $(container_sp2d)
                                .parents('tr').data('sp2d');
                            let id = sp2d.id.split('_');
                            if (id[0] == datasp2d.nosp2d &&
                                id[1] == datasp2d.tglsp2d && datasp2d
                                .keperluan == sp2d.keperluan && datasp2d
                                .kdper == sp2d.kdper) {
                                datasp2d.sisa_nilai = (((datasp2d.hasOwnProperty(
                                            'sisa_nilai')) ? parseFloat(datasp2d
                                            .sisa_nilai) : parseFloat(datasp2d
                                            .nilai)) -
                                        parseFloat(sp2d.nilai))
                                    .toString();
                                $(container_sp2d)
                                    .parents('tr').data('sp2d', datasp2d);
                            }
                        })
                    });
                    window.persentaseSp2d = [];
                    hitungPersentase();
                }
            });
            $('#selesai-attribusi').click(function() {
                $('#tambah-attribusi').click();
                $("#modalTambahAttribusi").modal('hide');
                $('#save-ba').removeClass('disabled');
                $('#update-ba').removeClass('disabled');
                $('#add-attribusi').addClass('disabled');
                $('.attribusi').find('.pilih-sp2d').map(function(index, element) {
                    $(element).prop('disabled', true);
                });
            })
            setMaskMoney();
            $('.data-table').DataTable();
            initialDataTable();
            onClickMasterBarang();
            $('#add-detail-asset').click(function() {
                window.iddetail = null;
                window.sp2d = 0;
                var order = window.countDetailAsset += 1;
                $('.input-group').find('input').removeClass('is-invalid')
                $('.input-group').find('span').removeClass('border-1 border-danger')
                var errors = validateElement('ba-form');
                if (errors.length == 0) {
                    window.bastatus = true;
                }
                if (window.bastatus) {
                    $("#modalMasterBarang").modal('show');
                } else {
                    $(window).scrollTop(0)
                    setTimeout(() => {
                        var html = '';
                        errors.map((error, index) => {
                            html +=
                                `<a class="list-group-item border-0">${error.message}</a>`;
                        });
                        $('.container-alert-ba').html(`<div class="alert alert-danger alert-ba">
                                <div class="row justify-content-start align-items-center">
                                    <div class="col-1">
                                        <i class='bx bxs-error-alt bx-lg'></i>
                                    </div>
                                    <div class="col-11 fw-bold">
                                        <span>Mandatori Error</span>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="list-group list-group-flush">
                                        ${html}
                                    </div>
                                </div>
                            </div>`);
                        $(`*[name=${errors[0].name}]`).focus();
                    }, 500)
                    setTimeout(() => {
                        $('.alert-ba').toggle("fade", 1000);
                    }, 1500);
                }
            });
            $("#cancel-ba").click(function() {
                iziToast.question({
                    timeout: 5000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'ba-konfirmasi',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan membatalkan bap ini?',
                    position: 'center',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            resetBa();
                        }, true],
                        ['<button>TIDAK</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }],
                    ],
                });
            })
            $('#save-ba').click(function() {
                iziToast.question({
                    timeout: 5000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'ba-konfirmasi',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan menambahkan bap dan list aset ini?',
                    position: 'center',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            savePerolehan();
                        }, true],
                        ['<button>TIDAK</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }],
                    ],
                });
            });
            $('#update-ba').click(function() {
                iziToast.question({
                    timeout: 5000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'update-konfirmasi',
                    zindex: 9999,
                    title: 'Konfirmasi',
                    message: 'Apakah anda yakin akan merubah bap dan list aset ini?',
                    position: 'center',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            updatePerolehan();
                        }, true],
                        ['<button>TIDAK</button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }],
                    ],
                });
            });
            $('#modalDetailAsset').on('hidden.bs.modal', function(e) {
                e.prevenDefault
                var errors = null;
                errors = validateElement("modalDetailAsset", 'detail-asset', 'label', '.bxs-star', '',
                    '.form-control, .select2modal, div > radio', '');
                var html = '';
                errors.map((error, index) => {
                    html +=
                        `<a class="list-group-item border-0">${error.message}</a>`;
                });
                let nilaikontrak = parseFloat(currencyToNumberFormat(` ${$('#nilaikontrak').val()}`)) ??
                    0;
                $('.contract-value').html(numberFormat(nilaikontrak - (window.totalbarang + parseFloat(
                    currencyToNumberFormat(` ${$('[name=nilaibarang]').val()}`)) * (
                    parseInt($('[name=jumlah]').val() ?? 1)))));
                if (nilaikontrak != 0 && nilaikontrak >= window.totalbarang) {
                    $('#save-ba').removeClass('disabled');
                } else {
                    $('.contract-value').removeClass('bg-success').addClass('bg-warning');
                    errors.push({
                        message: 'Nilai Barang Lebih Dari Nilai Kontrak',
                        name: 'Nilai Kontrak'
                    })
                    html +=
                        `<a class="list-group-item border-0">Nilai Barang Lebih Dari Nilai Kontrak</a>`;
                }
                if (errors.length !== 0) {
                    $('#modalDetailAsset .modal-body').prepend(`<div class="alert alert-danger alert-da">
                                <div class="row justify-content-start align-items-center">
                                    <div class="col-1">
                                        <i class='bx bxs-error-alt bx-lg'></i>
                                    </div>
                                    <div class="col-11 fw-bold">
                                        <span>Mandatori Error</span>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="list-group list-group-flush">
                                        ${html}
                                    </div>
                                </div>
                            </div>`);
                    $(this).modal('show');
                    $(this).on('shown.bs.modal', function(e) {
                        e.prevenDefault
                        $(`*[name=${errors[0].name}]`).focus();
                        $('.alert-da').toggle("fade", 2000);
                        setTimeout(() => {
                            $('.alert-da').remove();
                        }, 3000)
                    })
                } else {
                    let data = serializeObject($(`#${$(this)[0].id} .modal-body`).find('form'));
                    data.jumlah = data.jumlah ?? 1;
                    data.qrcode_foto = window.foto;
                    data.sp2d = window.persentaseSp2d;
                    window.persentaseSp2d.map((sp2d) => {
                        $(document).find('.pilih-sp2d').map((index, container_sp2d) => {
                            let datasp2d = $(container_sp2d)
                                .parents('tr').data('sp2d');
                            let id = sp2d.id.split('_');
                            if (id[0] == datasp2d.nosp2d &&
                                id[1] == datasp2d.tglsp2d && datasp2d
                                .keperluan == sp2d.keperluan && datasp2d
                                .kdper == sp2d.kdper) {
                                datasp2d.sisa_nilai = (((datasp2d.hasOwnProperty(
                                            'sisa_nilai')) ? parseFloat(datasp2d
                                            .sisa_nilai) : parseFloat(datasp2d
                                            .nilai)) -
                                        parseFloat(sp2d.nilai))
                                    .toString();
                                $(container_sp2d)
                                    .parents('tr').data('sp2d', datasp2d);
                            }
                        })
                    });
                    if (window.iddetail == null) {
                        data.iddetail = window.countDetailAsset += 1;
                        generateListDetailAsset(data);
                    } else {
                        data.iddetail = window.iddetail;
                        updateListData(data);
                    }
                    $('.alert-da').remove();
                    $('#add-detail-asset').removeClass('disabled');
                    window.iddetail = null;
                    window.persentaseSp2d = [];
                    window.sp2d = 0;
                    resetElementRekening();
                    $($(".sp2d")[0]).find('tr > td:last-child > input[disabled]').removeAttr(
                        'disabled');
                }
                $('#program').attr('disabled', true);
                $('#kegiatan').attr('disabled', true);
            });
            $('#modalTambahAttribusi').on('hidden.bs.modal', function(e) {
                $('#deskripsibarangattr').val('');
                $('#nilaibarangattribusi').val('');
                $(document).find('.pilih-sp2d').map((index,
                    container_sp2d) => {
                    if (container_sp2d.checked == true) {
                        $(container_sp2d).prop('checked', false)
                    }
                });
            });
            $('#nilaikontrak').change(function() {
                $('.contract-value').html(
                    numberFormat(parseFloat(currencyToNumberFormat(` ${this.value}`)) - window
                        .totalbarang));
            })
        });
    </script>
@endpush
