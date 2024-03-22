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
                        Master Rehab
                    </div>
                    <div class="col-6 col-md-2">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-save mb-1'></i>
                            Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_rehab" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nomer</th>
                                    <th>Rehab</th>
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
    <div class="modal fade" id="modalFormMasterRehab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterRehabTitle">Tambah Master Rehab</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped data-table" id="table_barang" style="min-width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nomer</th>
                                        <th>Rehab</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <form id="form-rehab" action="">
                        <input type="hidden" name="kodebarang">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bxs-package'></i></span>
                            <input type="text" class="form-control" readonly name="urai" placeholder="Tanah Kandang">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-warning add-detail"><i class='bx bx-plus'></i> Tambah
                                Jangka Rehab</button>
                        </div>
                        <div class="detail-rehab">

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
    <script src="{{ asset('assets/js/jquery.inputmask.js') }}"></script>
    <script>
        window.datatable_rehab = undefined;
        window.datatable_barang = undefined;
        window.state = undefined;
        window.kodebarang = undefined;

        function setMaskMoney() {
            $('.number-mask').attr('maxlength', '3').inputmask('numeric', {
                radixPoint: ",",
                allowMinus: false,
                regex: "[0-9]*",
                groupSeparator: ".",
                rightAlign: false,
                digits: 2,
                min: (-1),
                allowZero: true,
                alias: 'numeric'
            });
        }

        function updateMasterRehab() {
            data = serializeObject($('#form-rehab'));
            $.ajax({
                type: "PUT",
                url: "{{ route('master.rehab.update') }}/" + data.kodebarang,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_rehab.ajax.reload();
                }
            });
        }

        function saveMasterRehab() {
            data = serializeObject($('#form-rehab'));
            $.ajax({
                type: "POST",
                url: "{{ route('master.rehab.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_rehab.ajax.reload();
                }
            });
        }

        function detail_form(data = null, deleted = false) {
            $('.detail-rehab').append(`<div class="mb-3 row">
                <div class="divider">
                    <div class="divider-text">
                       <i class='bx bx-down-arrow' ></i>
                    </div>
                </div>
                <div class='form-floating col-4'>
                    <input type="hidden" name="koderehab[]">
                    <input type="text" class="form-control number-mask" name="persentase_awal[]">
                    <label>Persentase Awal</label>
                </div>
                <div class='form-floating col-4'>
                    <input type="text" class="form-control number-mask" name="persentase_akhir[]">
                    <label>Persentase Akhir</label>
                </div>
                <div class='form-floating col-3'>
                    <input type="text" class="form-control number-mask" name="tahunmasamanfaat[]">
                    <label>Kurun Waktu</label>
                </div>
                <button type='button' class='btn btn-danger col-1 delete-detail ${deleted ? '' :'disabled'}'><i class='bx bxs-trash-alt'></i></button>
            </div>`)
            $('.delete-detail').click(function() {
                $(this).parents('.row:first').remove()
                $('.detail-rehab').find('.delete-detail:last')
                    .removeClass('disabled')
                if ($('.detail-rehab')
                    .find('input[name^="persentase_akhir"]:last')
                    .val() < 100
                ) {
                    $('.add-detail').removeClass('disabled');
                }
            });
            if (data != undefined) {
                var e = jQuery.Event("keydown");
                e.which = 32;
                $('input[name^="koderehab"]:last').val(`${data.koderehab}`).trigger(e);
                $('input[name^="persentase_awal"]:last').val(`${data.persentase_awal}`).trigger(e);
                $('input[name^="persentase_akhir"]:last').val(`${data.persentase_akhir}`).trigger(e);
                $('input[name^="tahunmasamanfaat"]:last').val(`${data.tahunmasamanfaat}`).trigger(e);
            }
            $('.number-mask').focus(function() {
                setMaskMoney();
            });
            $('.number-mask').blur(function() {
                $(this).val($(this).inputmask('unmaskedvalue') != '' ? $(this).inputmask('unmaskedvalue') : 0)
                    .inputmask('remove');
            });
        }

        function actionData() {
            $('.edit').click(function() {
                $('.add-detail').removeClass('disabled');
                window.state = 'update';
                if (window.datatable_rehab.rows('.selected').data().length == 0) {
                    $('#table_rehab tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_rehab.rows('.selected').data()[0];
                $(this).parents('tr').removeClass('selected')
                $('#modalFormMasterRehab').modal('show');
                $('#modalFormMasterRehab').find('.modal-title').html('Edit Master Rehab');
                $.ajax({
                    type: "GET",
                    url: "{{ route('master.rehab.show') }}/" + data[4],
                    dataType: "json",
                    success: function(response) {
                        $('.detail-rehab').html('');
                        response.data.forEach((detail, index) => {
                            $("#form-rehab")
                                .find('[name=kodebarang]')
                                .val(
                                    `${detail.kodegolongan}.${detail.kodebidang}.${detail.kodekelompok}.${detail.kodesub}.${detail.kodesubsub}`
                                );
                            $("#form-rehab")
                                .find('[name=urai]')
                                .val(detail.urai);
                            detail_form(detail, (response.data.length - 1) == index ? true :
                                false);
                            if (detail.persentase_akhir == 100) {
                                $('.add-detail').addClass('disabled');
                            }
                        })
                    }
                });
                $('.multiple').addClass('d-none');
            })
            $('.delete').click(function() {
                if (window.datatable_rehab.rows('.selected').data().length == 0) {
                    $('#table_rehab tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_rehab.rows('.selected').data()[0];
                $(this).parents('tr').removeClass('selected')
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
                    message: 'Apakah anda yakin akan menghapus data masa manfaat ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>YES</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('master.rehab.delete') }}/" + data[4],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_rehab.ajax.reload()
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

        function detail_table(d) {
            var html = '';
            d[5].forEach((element, index) => {
                html += `
                <tr>
                    <td>${index+1}</td>
                    <td>${element.persentase_awal} %</td>
                    <td>${element.persentase_akhir} %</td>
                    <td>${element.tahunmasamanfaat} Tahun</td>
                </tr>`
            }); // `d` is the original data object for the row
            return (
                `<div class='table-responsive'>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Persentase awal</th>
                                <th>Persentase akhir</th>
                                <th>Kurun Waktu</th>
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
            window.datatable_rehab = new DataTable('#table_rehab', {
                ajax: "{{ route('master.rehab.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [2, 'desc']
                ],
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {
                        orderable: false,
                    },
                    {
                        orderable: true,
                    },
                    {
                        orderable: false,
                    },
                ],
            });
            window.datatable_barang = new DataTable('#table_barang', {
                ajax: "{{ route('master.rehab.list-barang') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        orderable: false,
                        target: 0,
                    },
                    {
                        orderable: true,
                        target: 1,
                    },
                    {
                        orderable: false,
                        target: 2,
                    },
                ],
            });
            window.datatable_rehab.on('draw.dt', function() {
                actionData();
            });

            $(".add").click(function() {
                window.state = 'add';
                $('.multiple').removeClass('d-none');
                $('#modalFormMasterRehab').modal('show');
                $('#modalFormMasterRehab').find('.modal-title').html('Edit Master Rehab');
                $('#modalFormMasterRehab').find('input[readonly]').attr('readonly', false);
                $("#form-rehab")[0].reset();
                window.datatable_rehab.on('click', 'td.dt-control', function(e) {
                    let tr = e.target.closest('tr');
                    let row = window.datatable_rehab.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                    } else {
                        // Open this row
                        row.child(detail_table(row.data())).show();
                    }
                });
            });
            $('.single').click(function() {
                if (window.state == 'add') {
                    saveMasterRehab();
                } else {
                    updateMasterRehab();
                }
            });
            $('.multiple').click(function() {
                saveMasterRehab();
                $('#modalFormMasterRehab').modal('show');
                $('#modalFormMasterRehab').find('.modal-title').html('Tambah Master Rehab');
            });
            $('.add-detail').click(function() {
                $('.detail-rehab').find('.delete-detail:last')
                    .addClass('disabled')
                detail_form();
                $('.detail-rehab').find('.delete-detail:last')
                    .removeClass('disabled')
            });
        });
    </script>
@endpush
