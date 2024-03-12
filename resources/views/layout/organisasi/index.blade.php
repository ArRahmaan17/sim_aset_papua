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
                <div class="card-header">Master Organisasi</div>
                <div class="card-body">
                    <div class="row">
                        <div id="container-jstree-organisasi" class="col-12 col-md-6"></div>
                        <div class="col-12 col-md-6"></div>
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
        function initialJsTree() {
            $.ajax({
                type: "GET",
                url: "{{ route('master.organisasi.all') }}",
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
                    $("#container-jstree-organisasi").jstree({
                        'core': {
                            'data': [{
                                id: '0',
                                text: 'Master Organisasi',
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
        });
    </script>
@endpush
