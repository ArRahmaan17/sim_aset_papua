@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0 flex-column-reverse flex-sm-row">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nomer</th>
                                    <th>KodeBap</th>
                                    <th>Kodekib</th>
                                    <th>Alamat</th>
                                    <th>Keterangan</th>
                                    <th>Nilai Transaksi</th>
                                    <th>Tahun</th>
                                    <th>Tanggal Penyusutan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nomer</td>
                                    <td>KodeBap</td>
                                    <td>Kodekib</td>
                                    <td>Alamat</td>
                                    <td>Keterangan</td>
                                    <td>Nilai Transaksi</td>
                                    <td>Tahun</td>
                                    <td>Tanggal Penyusutan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
