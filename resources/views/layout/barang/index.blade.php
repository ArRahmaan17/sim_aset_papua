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
                    <div id="container-jstree-barang" class="col-md-6"></div>
                    <div id="container-form-barang" class="col-md-6"></div>
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
        function initialJsTree() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.barang.all') }}",
                dataType: "json",
                success: function(response) {
                    $("#container-jstree-barang").jstree({
                        'core': {
                            'data': [{
                                id: '0',
                                text: 'Master Barang',
                                state: {
                                    opened: true,
                                }
                            }],
                            "check_callback": true,
                        },
                        "plugins": ["checkbox"]
                    });
                }
            });
        }
        $(function() {});
    </script>
@endpush
