@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title col-12">{{ session('app') == 'aset' ? 'List Data SP2D' : 'List Rekening' }}</div>
                    <div class="row row-bordered g-0 flex-column-reverse flex-sm-row">
                        <div class="table-responsive">
                            <table id="table_penyusutan" class="table table-striped">
                                <thead>
                                    <tr>
                                        @if (session('status') == 'aset')
                                            <th>Nomer</th>
                                            <th>Nomer SP2D</th>
                                            <th>Tanggal SP2D</th>
                                            <th>Kode Organisasi</th>
                                            <th>Organisasi</th>
                                            <th>Keperluan</th>
                                            <th>Nilai SP2D</th>
                                            <th>Tahun</th>
                                        @else
                                            <th>Nomer</th>
                                            <th>Kode Akun</th>
                                            <th>Nama Akun</th>
                                            <th>Aksi</th>
                                        @endif
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
    </div>
@endsection

@push('js')
    <script>
        $(function() {
let column = null;
            if(`{{session('app')}}` == 'aset'){
column = [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    width: '50px'
                }, {
                    targets: 1,
                    searchable: true,
                    orderable: true,
                    width: '50px',
                }, {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    width: '50px',
                }, {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    width: '50px',
                }, {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    width: '50px',
                }, {
                    targets: 5,
                    searchable: false,
                    orderable: false,
                    width: '50px',
                }, {
                    targets: 6,
                    searchable: false,
                    orderable: false,
                    width: '50px',
                }]
} else{ column = [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    width: '50px'
                }, {
                    targets: 1,
                    searchable: true,
                    orderable: true,
                    width: '50px',
                }, {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    width: '50px',
                }, {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    width: '50px',
                }]
}
            new DataTable("#table_penyusutan", {
                ajax: "{{ session('app') == 'aset' ? route('sp2d.data-table') : route('rekening.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columns: column,
            });
        });
    </script>
@endpush
