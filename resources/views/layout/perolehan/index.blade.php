@extends('template.parent')
@push('css')
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/fh-3.4.0/dt-1.13.10/r-2.5.0/datatables.min.css" rel="stylesheet">
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
                        <h3 class="card-header m-0 me-2 pb-3">Perolehan</h3>
                        <div class="col-xl">
                            <div class="card mb-4 shadow-none">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Form Perolehan</h5>
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
                                            <h3>Detail Aset</h3>
                                            <ul id="container-detail-asset" class="list-group">
                                            </ul>
                                        </div>
                                        <button type="button" id="add-detail-asset" class="btn btn-success mb-3"><span
                                                class='tf-icons bx bx-layer-plus'></span>
                                            Tambah Detail Aset</button>
                                        <button id="save-ba" type="button" class="btn btn-warning mb-3 disabled"><span
                                                class='tf-icons bx bx-save'></span>
                                            Simpan Perolehan Aset</button>
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
                    <div class="table-responsive">
                        <table id="table-master-barang" class="table table-bordered data-table">
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
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailAssetTitle">Tambah Detail Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailAssetTitle">Modal List Bap <i>{{ getOrganisasi() }}</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive p-1">
                        <table id="list-perolehan" class="table table-hover data-table">
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
                                                <button type="button" class="btn btn-outline-success btn-sm"><i
                                                        class='bx bxs-pencil'></i>Gunakan</button>
                                                <button type="button" class="btn btn-outline-info btn-sm"><i
                                                        class='bx bxs-show'></i>Lihat</button>
                                                <button type="button" class="btn btn-outline-danger btn-sm"><i
                                                        class='bx bxs-trash'></i>Hapus</button>
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
@endsection
@push('js')
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/fh-3.4.0/dt-1.13.10/r-2.5.0/datatables.min.js"></script>
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
        window.foto = null;

        function getListbap() {
            $.ajax({
                type: "GET",
                url: "{{ route('perolehan.bap') }}",
                dataType: "json",
                success: function(response) {
                    var html = '';
                    response.data.forEach(bap => {
                        html +=
                            `<tr><td>${bap.kodebap}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-success btn-sm"><i
                                                class='bx bxs-pencil'></i>Gunakan</button>
                                        <button type="button" class="btn btn-outline-info btn-sm"><i
                                                class='bx bxs-show'></i>Lihat</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"><i
                                                class='bx bxs-trash'></i>Hapus</button>
                                    </div>
                                </td>
                            </tr>`;
                    });
                    $('#list-perolehan tbody').html(html);
                }
            });
        }

        function udpdateListData(data) {
            $("#container-detail-asset").find('li').map((index, element) => {
                if ($(element).data('id') == window.iddetail) {
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
                    $(`[name=${name}]`).val(value).trigger("change")
                }
            })
        }

        function editDetailAsset(element) {
            var data = $($(element).parent()).parent().data('master');
            window.iddetail = data.iddetail
            renderFormDetailAsset(data, 'edit');
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
                    <span class="badge bg-primary icon-name" style='font-size:1rem;'>${data.jumlah}</span>
                    <span class="badge bg-danger" onclick="deleteDetailAsset(${data.iddetail})"><i class='bx bx-trash bx-xs'></i></span>
                    <span class="badge bg-info"><i class='bx bx-show bx-xs'></i></span>
                    <span class="badge bg-success" onclick="editDetailAsset(this)"><i class='bx bx-pencil bx-xs'></i></span>
                </div>
            </li>`)
        }

        function deleteDetailAsset(id) {
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Warning',
                message: 'Apakah anda yakin akan menghapus detail aset ini?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');
                        $("#container-detail-asset").find('li').map((index, element) => {
                            if ($(element).data('id') == id) {
                                $(element).remove()
                            }
                        });
                        ($("#container-detail-asset").find('li').length == 0) ? $("#save-ba").addClass(
                            'disabled'): '';
                    }, true],
                    ['<button>NO</button>', function(instance, toast) {

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
                url: `{{ route('master.asal-usul') }}`,
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
                url: `{{ route('master.kondisi') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodekondisi]').html(response.html_kondisi).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.satuan') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodesatuan]').html(response.html_satuan).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.status-tanah') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodestatustanah]').html(response.html_status_tanah).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.golongan-barang') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodegolonganbarang]').html(response.html_golongan_barang).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.warna') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kodewarna]').html(response.html_warna).trigger(
                        'change');
                }
            });
            $.ajax({
                type: "GET",
                url: `{{ route('master.hak') }}`,
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
            result = result[1].split(".").join("").split(",").join("");
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
            const container = document.querySelector("#modalDetailAsset .modal-body");
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
            })
        }

        function validateElement(
            form,
            type = 'ba',
            contextElement = 'label',
            contextClass = '.bxs-star',
            validateElementParent = '.input-group',
            validateElement = 'input',
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
                if ($(element).val() == "" || $(element).val() == null) {
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
            let data = serializeObject($('#ba-form'));
            let detailData = [];
            $('#container-detail-asset').find('li').map((index, element) => {
                detailData.push($(element).data('master'))
            });
            data.detail = detailData;
            data._token = `{{ csrf_token() }}`;
            $.ajax({
                type: "POST",
                url: "{{ route('perolehan.store') }}",
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
                    window.bastatus = false;
                    window.tempAsset = null;
                    window.countDetailAsset = 0;
                    window.detailAsset = [];
                    window.iddetail = null;
                    window.foto = null;
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
            $('.formated').blur(function() {
                if (this.value == "") {
                    $(this).focus();
                    return
                }
                $(this).val(`BA/{{ env('APP_YEAR') }}/${this.value}/{{ kodeOrganisasi() }}`)
            });
            $('.formated').focus(function() {
                value = (this.value).split(`BA/{{ env('APP_YEAR') }}/`).join('').split(
                    `/{{ kodeOrganisasi() }}`).join('');
                $(this).val(value)
            })
            setMaskMoney();
            $('.data-table').DataTable();
            initialDataTable();
            onClickMasterBarang();
            $('#add-detail-asset').click(function() {
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
            $('#save-ba').click(function() {
                savePerolehan()
            });
            $('#modalDetailAsset').on('hidden.bs.modal', function(e) {
                var errors = null;
                e.prevenDefault
                errors = validateElement("modalDetailAsset", 'detail-asset', 'label', '.bxs-star', '',
                    '.form-control, .select2modal, div > radio', '');
                var html = '';
                errors.map((error, index) => {
                    html +=
                        `<a class="list-group-item border-0">${error.message}</a>`;
                });
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
                    if (window.iddetail == null) {
                        data.iddetail = window.countDetailAsset;
                        generateListDetailAsset(data);
                    } else {
                        data.iddetail = window.iddetail;
                        udpdateListData(data)
                    }
                    $('.alert-da').remove();
                    $('#save-ba').removeClass('disabled');
                    window.iddetail = null
                }
            });
        });
    </script>
@endpush
