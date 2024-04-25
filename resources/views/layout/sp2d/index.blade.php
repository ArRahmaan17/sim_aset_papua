@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title col-12">List Data SP2D</div>
                    <div class="row row-bordered g-0 flex-column-reverse flex-sm-row">
                        <div class="table-responsive">
                            <table id="table_penyusutan" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nomer</th>
                                        <th>Nomer SP2D</th>
                                        <th>Tanggal SP2D</th>
                                        <th>Kode Organisasi</th>
                                        <th>Organisasi</th>
                                        <th>Keperluan</th>
                                        <th>Nilai SP2D</th>
                                        <th>Tahun</th>
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
            new DataTable("#table_penyusutan", {
                ajax: "{{ route('sp2d.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                columnDefer: [{
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
                }],
            });
        });
    </script>
@endpush
