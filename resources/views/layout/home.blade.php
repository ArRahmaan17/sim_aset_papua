@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="alert alert-primary d-none my-2" role="alert">
                    Halaman akan di refresh dalam 5 detik
                </div>
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                        <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                        <div id="totalRevenueChart" class="px-2"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                        id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        2022
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                        <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                        <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                        <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="growthChart"></div>
                        <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-primary p-2"><i
                                            class="bx bx-dollar text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>2022</small>
                                    <h6 class="mb-0">$32.5k</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>2021</small>
                                    <h6 class="mb-0">$41.2k</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-top fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTop" tabindex="-1"
        aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">Pilih Organisasi Terlebih Dahulu</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodeurusan">Kode urusan
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodeurusan" id="kodeurusan" style="width: 100%">
                                    <option value="">Mohon Pilih</option>
                                    @foreach ($organisasi as $org)
                                        <option
                                            value="{{ $org->kodeurusan . '.' . $org->kodesuburusan . '.' . $org->kodesubsuburusan . '.' . $org->kodeorganisasi . '.' . $org->kodesuborganisasi . '.' . $org->kodeunit . '.' . $org->kodesubunit . '.' . $org->kodesubsubunit }}">
                                            {{ $org->kodeurusan . '.' . stringPad($org->kodesuburusan) . '.' . $org->kodeorganisasi . '.' . stringPad($org->kodeorganisasi) . '.' . $org->kodesuborganisasi . '.' . stringPad($org->kodeunit) . '.' . stringPad($org->kodesubunit) . '.' . stringPad($org->kodesubsubunit) . '|' . $org->organisasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodesuburusan">Kode sub urusan
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodesuburusan" id="kodesuburusan" style="width: 100%">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodesubsuburusan">Kode sub sub urusan
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodesubsuburusan" id="kodesubsuburusan"
                                    style="width: 100%">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodeorganisasi">Kode organisasi
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodeorganisasi" id="kodeorganisasi" style="width: 100%">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodesuborganisasi">Kode sub organisasi
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodesuborganisasi" id="kodesuborganisasi"
                                    style="width: 100%">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodeunit">Kode unit
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodeunit" id="kodeunit" style="width: 100%">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodesubunit">Kode sub unit
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodesubunit" id="kodesubunit" style="width: 100%">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label control-label" for="kodesubsubunit">Kode sub sub unit
                                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                                <select class="select2modal" name="kodesubsubunit" id="kodesubsubunit"
                                    style="width: 100%">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="pilih-organisasi" class="btn btn-primary"><i
                            class='bx bx-lock-alt mb-1'></i> Gunakan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        function changeGetData(element, value) {
            $.ajax({
                type: "get",
                url: "{{ route('master.organisasi-child') }}",
                dataType: "json",
                data: {
                    value: value
                },
                success: function(response) {
                    $(`#${element}`).html(response.html_organisasi_child);
                }
            });
            window.organisasi = value;
        }
        $(function() {
            if (`{!! json_encode(session('organisasi')) !!}` == "null") {
                $("#modalTop").modal('show');
                $('.select2modal').select2({
                    dropdownParent: $("#modalTop"),
                });
            }
            $('#pilih-organisasi').click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('set-organisasi') }}",
                    data: {
                        _token: `{{ csrf_token() }}`,
                        organisasi: window.organisasi
                    },
                    dataType: "json",
                    success: function(response) {
                        $('.alert').removeClass('d-none');
                        $('.modal.show').modal('hide');
                        var countdown = 5000;
                        setInterval(() => {
                            $('.alert').html(
                                `Halaman akan di refresh dalam ${(countdown/1000).toString().split('.').join(',')} detik`
                            );
                            countdown -= 100;
                        }, 100);
                        setTimeout(() => {
                            window.location = response.redirect;
                        }, 5000);
                    }
                });
            });
            $("#kodeurusan").change(function() {
                changeGetData('kodesuburusan', this.value);
            });
            $("#kodesuburusan").change(function() {
                changeGetData('kodesubsuburusan', this.value);
            });
            $("#kodesubsuburusan").change(function() {
                changeGetData('kodeHalaman', this.value);
            });
        });
    </script>
@endpush
