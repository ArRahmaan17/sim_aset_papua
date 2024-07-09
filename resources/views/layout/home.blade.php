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
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <div class="row justify-content-start align-items-center g-0">
                                <div class="col">
                                    <i class='bx bxs-error-alt bx-lg'></i>
                                    <span class="fw-bold">{{ session('error') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col">
                        <h5 class="card-header m-0 me-2 pb-3">Jumlah BA Organisasi
                            {{ session('organisasi') !== null ? getOrganisasi() : '' }}</h5>
                        <div id="totalRevenueChart" class="px-2"></div>
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
                                <select class="select2modal" name="kodesubsubunit" id="kodesubsubunit" style="width: 100%">
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
        let cardColor, headingColor, axisColor, shadeColor, borderColor;

        cardColor = config.colors.white;
        headingColor = config.colors.headingColor;
        axisColor = config.colors.axisColor;
        borderColor = config.colors.borderColor;
        const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
            totalRevenueChartOptions = {
                series: [{
                        name: '{{ env('TAHUN_APLIKASI') }}',
                        data: [parseInt(`{{ $countBaNow }}`)]
                    },
                    {
                        name: '{{ intval(env('TAHUN_APLIKASI')) - 1 }}',
                        data: [parseInt(`{{ $countBaPast }}`)]
                    }
                ],
                chart: {
                    height: 300,
                    stacked: true,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '33%',
                        borderRadius: 12,
                        startingShape: 'rounded',
                        endingShape: 'rounded'
                    }
                },
                colors: [config.colors.primary, config.colors.info],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 6,
                    lineCap: 'round',
                    colors: [cardColor]
                },
                legend: {
                    show: true,
                    horizontalAlign: 'left',
                    position: 'top',
                    markers: {
                        height: 8,
                        width: 8,
                        radius: 12,
                        offsetX: -3
                    },
                    labels: {
                        colors: axisColor
                    },
                    itemMargin: {
                        horizontal: 10
                    }
                },
                grid: {
                    borderColor: borderColor,
                    padding: {
                        top: 0,
                        bottom: -8,
                        left: 20,
                        right: 20
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    labels: {
                        style: {
                            fontSize: '13px',
                            colors: axisColor
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '13px',
                            colors: axisColor
                        }
                    }
                },
                responsive: [{
                        breakpoint: 1700,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '32%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 1580,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '35%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 1440,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '42%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 1300,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '48%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '40%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 1040,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 11,
                                    columnWidth: '48%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 991,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '30%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 840,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '35%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 768,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '28%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 640,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '32%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 576,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '37%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 480,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '45%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 420,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '52%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 380,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '60%'
                                }
                            }
                        }
                    }
                ],
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    },
                    active: {
                        filter: {
                            type: 'none'
                        }
                    }
                }
            };
        if (typeof totalRevenueChartEl !== undefined && totalRevenueChartEl !== null) {
            const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
            totalRevenueChart.render();
        }
    </script>
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
