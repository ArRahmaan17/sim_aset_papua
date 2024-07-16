@extends('template.parent')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jstree.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="card-header row align-items-center">
                    <div class="col-12 col-md-7 col-lg-8">
                        Kontrak
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 text-end">
                        <button class="btn btn-success add" type="button"><i class='tf-icons bx bx-plus mb-1'></i>Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_kontrak" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Kontrak</th>
                                    <th>Kegiatan</th>
                                    <th>Penyedia</th>
                                    <th>Tahun</th>
                                    <th>Tanggal</th>
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
    <div class="modal fade" id="modalFormKontrak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormMasterWarnaTitle">Tambah Kontrak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-kontrak" action="">
                        <div class="divider">
                            <div class="divider-text">Kontrak</div>
                        </div>
                        <input type="hidden" name="id" value="{{ generateNextIdKontrak() }}">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-list-ul'></i></span>
                            <input type="text" class="form-control" name="no_kontrak" placeholder="Nomor Kontrak" aria-label="Nomor Kontrak" aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bx-heading'></i></span>
                            <input type="text" class="form-control" name="nm_kontrak" placeholder="Judul Kontrak" aria-label="Judul Kontrak" aria-describedby="basic-addon11">
                        </div>
                        <div class="mb-3"><select name="penyedia_id" id="penyedia_id" class="form-select"></select></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                            <input type="text" class="form-control" name="tahun" placeholder="Tahun" aria-label="Tahun" aria-describedby="basic-addon11">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                            <input type="text" class="form-control datetimepickermodal-kontrak" name="t_kontrak" placeholder="Tanggal Kontrak" aria-label="Tanggal Kontrak" aria-describedby="basic-addon11">
                        </div>
                    </form>
                    <div class="divider">
                        <div class="divider-text">List rincian Kontrak</div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped data-table" id="table_rincian" style="min-width: 100%;">
                            <thead>
                                <tr role="row">
                                    <td>No.</td>
                                    <td>Jenis Aset</td>
                                    <td>Kode Aset</td>
                                    <td>No. Register</td>
                                    <td>Asal Usul Dana</td>
                                    <td>Harga</td>
                                    <td>KIB</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-warning add-rincian"><i class='bx bx-plus'></i>Rincian</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success align-middle single">
                        <i class='tf-icons bx bx-save mb-1'></i> Close And Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFormRincian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormRincianTitle">Tambah Rincian Kontrak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-rincian" action="">
                        <div class="general">
                            <input type="hidden" name="id_rincian">
                            <div class="select-container mb-3"><select name="kelompok" id="kelompok" class="form-select"></select></div>
                            <div class="select-container mb-3"><select name="jenis" id="jenis" class="form-select"></select></div>
                            <div class="select-container mb-3"><select name="objek" id="objek" class="form-select"></select></div>
                            <div class="select-container mb-3"><select name="rincian" id="rincian" class="form-select"></select></div>
                            <div class="select-container mb-3"><select name="subrincian" id="subrincian" class="form-select"></select></div>
                            <div class="select-container mb-3"><select name="uraian" id="uraian" class="form-select"></select></div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-barcode'></i></span>
                                <input type="text" class="form-control" name="kode" placeholder="Kode" aria-label="Kode" aria-describedby="basic-addon11" readonly>
                            </div>
                            <div class="jumlahbarang-container input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-calculator'></i></span>
                                <input type="text" class="form-control" name="jumlahbarang" placeholder="Jumlah Barang" aria-label="Jumlah Barang" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-transfer-alt'></i></span>
                                <input type="text" class="form-control" name="asal" placeholder="Asal Usul Dana" aria-label="Asal Usul Dana" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-calculator'></i></span>
                                <input type="text" class="form-control" name="harga" placeholder="Harga Rincian" aria-label="Harga Rincian" aria-describedby="basic-addon11">
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Detail</div>
                        </div>
                        <div class="kiba">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                                <input type="text" class="form-control datetimepickermodal-rincian" name="tgl_sertifikat" placeholder="Tanggal Sertifikat" aria-label="Tanggal Sertifikat" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-list-ul'></i></span>
                                <input type="text" class="form-control" name="no_sertifikat" placeholder="Nomor Sertifikat" aria-label="Nomor Sertifikat" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-expand'></i></span>
                                <input type="text" class="form-control" name="luas_tanah" placeholder="Luas Tanah" aria-label="Luas Tanah" aria-describedby="basic-addon11">
                            </div>
                            <div class="mb-3"><select name="id_hak" id="id_hak" class="form-select mb-3">
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-run'></i></span>
                                <input type="text" class="form-control" name="penggunaan" placeholder="Penggunaan" aria-label="Penggunaan" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                                <input type="text" class="form-control" name="tahun" placeholder="Tahun" aria-label="Tahun" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-location-plus'></i></span>
                                <textarea name="alamat" class="form-control" placeholder="Alamat" aria-describedby="basic-addon11"></textarea>
                            </div>
                        </div>
                        <div class="kibb">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-barcode'></i></span>
                                <input type="text" class="form-control" name="merek" placeholder="Merek" aria-label="Merek" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-factory'></i></span>
                                <input type="text" class="form-control" name="pabrik" placeholder="Pabrik" aria-label="Pabrik" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="no_bpkb" placeholder="No. BPKB" aria-label="No. BPKB" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="no_rangka" placeholder="No. Rangka" aria-label="No. Rangka" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="no_mesin" placeholder="No. Mesin" aria-label="No. Mesin" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="nopol" placeholder="No. Polisi" aria-label="No. Polisi" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-car'></i></span>
                                <input type="text" class="form-control" name="spesifikasi" placeholder="Ukuran/CC" aria-label="Ukuran/CC" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-tree'></i></span>
                                <input type="text" class="form-control" name="bahan" placeholder="Bahan" aria-label="Bahan" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                                <input type="text" class="form-control" name="tahun" placeholder="Tahun" aria-label="Tahun" aria-describedby="basic-addon11">
                            </div>
                        </div>
                        <div class="kibc">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                                <input type="text" class="form-control datetimepickermodal-rincian" name="tgl_dokumen" placeholder="Tanggal Dokumen" aria-label="Tanggal Dokumen" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-list-ul'></i></span>
                                <input type="text" class="form-control" name="no_dokumen" placeholder="Nomor Dokumen" aria-label="Nomor Dokumen" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-expand'></i></span>
                                <input type="text" class="form-control" name="luas_lantai" placeholder="Luas Lantai" aria-label="Luas Lantai" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-expand'></i></span>
                                <input type="text" class="form-control" name="luas_tanah" placeholder="Luas Tanah" aria-label="Luas Tanah" aria-describedby="basic-addon11">
                            </div>
                            <div class="mb-3"><select name="tingkat" id="tingkat" class="form-select mb-3">
                                    <option value="">Pilih Tingak</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="mb-3"><select name="beton" id="beton" class="form-select mb-3">
                                    <option value="">Pilih Beton</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="id_status_tanah" id="id_status_tanah" class="form-select mb-3">
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="kode_tanah" placeholder="Kode Tanah" aria-label="Kode Tanah" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-question-mark'></i></span>
                                <input type="text" class="form-control" name="kondisi" placeholder="Kondisi" aria-label="Kondisi" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-paperclip'></i></span>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan" aria-describedby="basic-addon11"></textarea>
                            </div>
                        </div>
                        <div class="kibd">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                                <input type="text" class="form-control datetimepickermodal-rincian" name="tgl_dokumen" placeholder="Tanggal Dokumen" aria-label="Tanggal Dokumen" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-list-ul'></i></span>
                                <input type="text" class="form-control" name="no_dokumen" placeholder="Nomor Dokumen" aria-label="Nomor Dokumen" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-calculator'></i></span>
                                <input type="text" class="form-control" name="panjang" placeholder="Panjang" aria-label="Panjang" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-expand'></i></span>
                                <input type="text" class="form-control" name="luas_tanah" placeholder="Luas Tanah" aria-label="Luas Tanah" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-calculator'></i></span>
                                <input type="text" class="form-control" name="lebar" placeholder="Lebar" aria-label="Lebar" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-cog'></i></span>
                                <input type="text" class="form-control" name="konstruksi" placeholder="Konstruksi" aria-label="Konstruksi" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-location-plus'></i></span>
                                <textarea name="alamat" class="form-control" placeholder="Lokasi/Alamat" aria-describedby="basic-addon11"></textarea>
                            </div>
                            <div class="mb-3"><select name="id_status_tanah" id="id_status_tanah" class="form-select mb-3">
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="kode_tanah" placeholder="Kode Tanah" aria-label="Kode Tanah" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-question-mark'></i></span>
                                <input type="text" class="form-control" name="kondisi" placeholder="Kondisi" aria-label="Kondisi" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-paperclip'></i></span>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan" aria-describedby="basic-addon11"></textarea>
                            </div>
                        </div>
                        <div class="kibe">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-edit'></i></span>
                                <input type="text" class="form-control" name="nm_aset" placeholder="Nama Aset" aria-label="Nama Aset" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-location-plus''></i></span>
                                <input type="text" class="form-control" name="asal_daerah" placeholder="Asal Daerah" aria-label="Asal Daerah" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-user'></i></span>
                                <input type="text" class="form-control" name="pencipta" placeholder="Pencipta" aria-label="Pencipta" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-list-plus'></i></span>
                                <input type="text" class="form-control" name="jenis" placeholder="Jenis Aset" aria-label="Jenis Aset" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-calculator'></i></span>
                                <input type="text" class="form-control" name="ukuran" placeholder="Ukuran" aria-label="Ukuran" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="jumlah" placeholder="Jumlah" aria-label="Jumlah" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-paperclip'></i></span>
                                <textarea name="keterangan" class="form-control" placeholder="Keterangan" aria-describedby="basic-addon11"></textarea>
                            </div>
                        </div>
                        <div class="kibf">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                                <input type="text" class="form-control datetimepickermodal-rincian" name="tgl_dokumen" placeholder="Tanggal Dokumen" aria-label="Tanggal Dokumen" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-code-curly'></i></span>
                                <input type="text" class="form-control" name="no_dokumen" placeholder="Nomor Dokumen" aria-label="Nomor Dokumen" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-expand'></i></span>
                                <input type="text" class="form-control" name="luas_tanah" placeholder="Luas Tanah" aria-label="Luas Tanah" aria-describedby="basic-addon11">
                            </div>
                            <div class="mb-3">
                                <select name="bangunan" id="bangunan" class="form-select mb-3">
                                    <option value="">Pilih Jenis Bangunan</option>
                                    <option value="P">Permanen</option>
                                    <option value="SP">Semi Permanen</option>
                                    <option value="D">Darurat</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="tingkat" id="tingkat" class="form-select mb-3">
                                    <option value="">Pilih Tingkat</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bxs-time'></i></span>
                                <input type="text" class="form-control datetimepickermodal-rincian" name="t_mulai" placeholder="Tanggal Mulai" aria-label="Tanggal Mulai" aria-describedby="basic-addon11">
                            </div>
                            <div class="mb-3">
                                <select name="beton" id="beton" class="form-select mb-3">
                                    <option value="">Pilih Beton</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="id_status_tanah" id="id_status_tanah" class="form-select mb-3">
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-barcode'></i></span>
                                <input type="text" class="form-control" name="kode_tanah" placeholder="Kode Tanah" aria-label="Kode Tanah" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-question-mark'></i></span>
                                <input type="text" class="form-control" name="kondisi" placeholder="Kondisi" aria-label="Kondisi" aria-describedby="basic-addon11">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon11"><i class='bx bx-location-plus'></i></span>
                                <textarea name="alamat" class="form-control" placeholder="Alamat" aria-describedby="basic-addon11"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success align-middle store-rincian">
                        <i class='tf-icons bx bx-save mb-1'></i> Close And Save
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/jstree.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.id.min.js') }}"></script>
    <script>
        window.datatable_kontrak = undefined;
        window.datatable_rincian = undefined;

        function hakSelect() {
            $.ajax({
                type: "get",
                url: `{{ route('master.hak.useable') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=id_hak]').html(response.data);
                }
            });
        }

        function statusTanahSelect() {
            $.ajax({
                type: "get",
                url: `{{ route('master.statustanah.useable') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=id_status_tanah]').html(response.data);
                }
            });
        }

        function updateKontrak() {
            data = serializeObject($('#form-kontrak'));
            $.ajax({
                type: "PUT",
                url: "{{ route('kontrak.update') }}/" + data.id,
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_kontrak.ajax.reload();
                }
            });
        }

        function updateRincian() {
            const jenis = $('[name=kode]').val().split('.')[0];
            let dataRincianKib;
            if (jenis == '131') {
                dataRincianKib = serializeObject($('#form-rincian .kiba :input'));
            } else if (jenis == '132') {
                dataRincianKib = serializeObject($('#form-rincian .kibb :input'));
            } else if (jenis == '133') {
                dataRincianKib = serializeObject($('#form-rincian .kibc :input'));
            } else if (jenis == '134') {
                dataRincianKib = serializeObject($('#form-rincian .kibd :input'));
            } else if (jenis == '135') {
                dataRincianKib = serializeObject($('#form-rincian .kibe :input'));
            } else if (jenis == '136') {
                dataRincianKib = serializeObject($('#form-rincian .kibf :input'));
            } else {
                dataRincianKib = serializeObject($('#form-rincian :input'));
            }

            const dataRincian = serializeObject($('#form-rincian .general :input').not('[name=kelompok], [name=jenis], [name=objek], [name=rincian], [name=subrincian], [name=uraian]'));
            const dataKontrak = serializeObject($('#form-kontrak'));
            const data = {
                ...dataKontrak,
                detail: {
                    ...dataRincian,
                    ...dataRincianKib
                }
            }

            $.ajax({
                type: "PUT",
                url: "{{ route('kontrak.rincian.update') }}/" + $('#form-rincian [name=id_rincian]').val(),
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_rincian.ajax.reload();
                    $('#modalFormRincian').modal('hide');
                    $('#modalFormKontrak').modal('show');
                }
            });
        }

        function saveKontrak() {
            data = serializeObject($('#form-kontrak'));
            $.ajax({
                type: "POST",
                url: "{{ route('kontrak.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_kontrak.ajax.reload();
                    $('#modalFormKontrak').modal('hide');
                }
            });
        }

        function saveRincian() {
            const jenis = $('#jenis').val().split('.')[0];
            let dataRincianKib;
            if (jenis == '131') {
                dataRincianKib = serializeObject($('#form-rincian .kiba :input'));
            } else if (jenis == '132') {
                dataRincianKib = serializeObject($('#form-rincian .kibb :input'));
            } else if (jenis == '133') {
                dataRincianKib = serializeObject($('#form-rincian .kibc :input'));
            } else if (jenis == '134') {
                dataRincianKib = serializeObject($('#form-rincian .kibd :input'));
            } else if (jenis == '135') {
                dataRincianKib = serializeObject($('#form-rincian .kibe :input'));
            } else if (jenis == '136') {
                dataRincianKib = serializeObject($('#form-rincian .kibf :input'));
            } else {
                dataRincianKib = serializeObject($('#form-rincian :input'));
            }

            const dataRincian = serializeObject($('#form-rincian .general :input').not('[name=kelompok], [name=jenis], [name=objek], [name=rincian], [name=subrincian], [name=uraian]'));
            const dataKontrak = serializeObject($('#form-kontrak'));
            const data = {
                ...dataKontrak,
                detail: {
                    ...dataRincian,
                    ...dataRincianKib
                }
            }

            $.ajax({
                type: "POST",
                url: "{{ route('kontrak.rincian.store') }}",
                data: {
                    _token: `{{ csrf_token() }}`,
                    ...data
                },
                dataType: "json",
                success: function(response) {
                    window.datatable_rincian.ajax.reload();
                    $('#modalFormRincian').modal('hide');
                    $('#modalFormKontrak').modal('show');

                }
            });
        };

        function actionData() {
            $('#table_kontrak .edit').click(function() {
                window.state = 'update';
                if (window.datatable_kontrak.rows('.selected').data().length == 0) {
                    $('#table_kontrak tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_kontrak.rows('.selected').data()[0];
                $('#modalFormKontrak').modal('show');
                $('#modalFormKontrak').find('.modal-title').html('Edit Kontrak');
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontrak.show') }}/" + data[7],
                    dataType: "json",
                    success: function(response) {
                        $("#form-kontrak").find('[name=id]')
                            .val(response.data.id);
                        $("#form-kontrak").find('[name=no_kontrak]')
                            .val(response.data.no_kontrak);
                        $("#form-kontrak").find('[name=nm_kontrak]')
                            .val(response.data.nm_kontrak);
                        $("#form-kontrak").find('[name=penyedia_id]')
                            .val(response.data.penyedia_id);
                        $("#form-kontrak").find('[name=tahun]')
                            .val(response.data.tahun);
                        $("#form-kontrak").find('[name=t_kontrak]')
                            .val(response.data.t_kontrak);

                        window.datatable_rincian.ajax.reload();
                    }
                });
            })
            $('#table_kontrak .delete').click(function() {
                if (window.datatable_kontrak.rows('.selected').data().length == 0) {
                    $('#table_kontrak tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_kontrak.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data Kontrak ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('kontrak.delete') }}/" + data[7],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_kontrak.ajax.reload()
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
            });
        }

        function actionDataRincian() {
            $('#table_rincian .edit').click(function() {
                window.state = 'update';
                if (window.datatable_rincian.rows('.selected').data().length == 0) {
                    $('#table_kontrak tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_rincian.rows('.selected').data()[0];
                $('#modalFormKontrak').modal('hide');
                $('#modalFormRincian').modal('show');
                $('#modalFormRincian').find('.modal-title').html('Edit Kontrak');
                hakSelect();
                statusTanahSelect();
                $.ajax({
                    type: "GET",
                    url: "{{ route('kontrak.rincian.show') }}/" + data[8],
                    dataType: "json",
                    success: function(response) {
                        $("#form-rincian").find('.select-container').hide();
                        $("#form-rincian").find('.jumlahbarang-container').hide();
                        $("#form-rincian").find(`[name=kode]`)
                            .val(response.data.kode);
                        $("#form-rincian").find('[name=id_rincian]')
                            .val(response.data.id);
                        const jenis = $('[name=kode]').val().split('.')[0];
                        if (jenis == '131') {
                            $('.kiba').show();
                            $('.kibb, .kibc, .kibd, .kibe, .kibf').hide();
                        } else if (jenis == '132') {
                            $('.kibb').show();
                            $('.kiba, .kibc, .kibd, .kibe, .kibf').hide();
                        } else if (jenis == '133') {
                            $('.kibc').show();
                            $('.kiba, .kibb, .kibd, .kibe, .kibf').hide();
                        } else if (jenis == '134') {
                            $('.kibd').show();
                            $('.kiba, .kibb, .kibc, .kibe, .kibf').hide();
                        } else if (jenis == '135') {
                            $('.kibe').show();
                            $('.kiba, .kibb, .kibc, .kibd, .kibf').hide();
                        } else if (jenis == '136') {
                            $('.kibf').show();
                            $('.kiba, .kibb, .kibc, .kibd, .kibe').hide();
                        } else {
                            $('.kiba, .kibb, .kibc, .kibd, .kibe, .kibf').hide();
                        }

                        Object.keys(response.data).forEach(function(key) {
                            $("#form-rincian").find(`[name=${key}]`)
                                .val(response.data[key]);
                        });

                        window.datatable_rincian.ajax.reload();
                    }
                });
            })
            $('#table_rincian .delete').click(function() {
                if (window.datatable_rincian.rows('.selected').data().length == 0) {
                    $('#table_kontrak tbody').find('tr').removeClass('selected');
                    $(this).parents('tr').addClass('selected')
                }
                var data = window.datatable_rincian.rows('.selected').data()[0];
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
                    message: 'Apakah anda yakin akan menghapus data Kontrak ini?',
                    position: 'center',
                    icon: 'bx bx-question-mark',
                    buttons: [
                        ['<button><b>IYA</b></button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('kontrak.rincian.delete') }}/" + data[8],
                                data: {
                                    _token: `{{ csrf_token() }}`,
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.datatable_rincian.ajax.reload()
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
            });
        }

        // function detail_table(d) {
        //     var html = '';
        //     d[6].forEach((element, index) => {
        //         html += `
    //     <tr>
    //         <td>${index+1}</td>
    //         <td>${element.persentase_awal} %</td>
    //         <td>${element.persentase_akhir} %</td>
    //         <td>${element.tahunmasamanfaat} Tahun</td>
    //     </tr>`
        //     });
        //     return (
        //         `<div class='table-responsive'>
    //         <table class='table' id='table_rincian'>
    //             <thead>
    //                 <tr role="row">
    //                     <td>No.</td>
    //                     <td>Jenis Aset</td>
    //                     <td>Kode Aset</td>
    //                     <td>No. Register</td>
    //                     <td>Asal Usul Dana</td>
    //                     <td>Harga</td>
    //                     <td>KIB</td>
    //                     <td>Jenis</td>
    //                 </tr>
    //             </thead>
    //             <tbody>
    //                 ${html}
    //             </tbody>
    //         </table>
    //     </div>`
        //     );
        // }

        $(function() {
            $('#table_kontrak tbody').on('click', 'tr', function(e) {
                if ($(e.currentTarget).hasClass('selected')) {
                    $('tr').removeClass('selected');
                } else {
                    $('tr').removeClass('selected');
                    $(e.currentTarget).addClass('selected');
                }
            });
            $('.kiba, .kibb, .kibc, .kibd, .kibe, .kibf').hide();
            window.datatable_kontrak = new DataTable('#table_kontrak', {
                ajax: "{{ route('kontrak.data-table') }}",
                processing: true,
                serverSide: true,
                order: [
                    [2, 'desc']
                ],
                columns: [{
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                    }
                }],
            });
            window.datatable_rincian = new DataTable('#table_rincian', {
                ajax: {
                    url: "{{ route('kontrak.rincian.data-table') }}",
                    data: function(d) {
                        console.log($('[name=id]').val())
                        d.id_kontrak = $('[name=id]').val();
                    }
                },
                processing: true,
                serverSide: true,
                order: [
                    [2, 'desc']
                ],
                columns: [{
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: true,
                    render: (data, type, row, meta) => {
                        return `<div class='text-wrap'>${data}</div>`
                    }
                }, {
                    orderable: false,
                    render: (data, type, row, meta) => {
                        return `<div class='d-flex gap gap-1 justify-content-center'>${data}</div>`
                    }
                }, ],
            });
            window.datatable_kontrak.on('draw.dt', function() {
                actionData();
            });
            window.datatable_rincian.on('draw.dt', function() {
                actionDataRincian();
            });
            window.datatable_kontrak.on('click', 'td.dt-control', function(e) {
                let tr = e.target.closest('tr');
                let row = window.datatable_kontrak.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(detail_table(row.data())).show();
                }
            });
            $.ajax({
                type: "get",
                url: `{{ route('master.penyedia.useable') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=penyedia_id]').html(response.data);
                }
            });
            $("#modalFormKontrak").on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('[name=penyedia_id]').select2({
                        dropdownParent: $("#modalFormKontrak"),
                        placeholder: "Penyedia"
                    });
                    $('.datetimepickermodal-kontrak').datepicker({
                        format: "dd MM yyyy",
                        todayBtn: "linked",
                        clearBtn: true,
                        language: "id",
                        autoclose: true,
                        orientation: "top auto",
                        toggleActive: true,
                        container: '#modalFormKontrak'
                    });
                }, 250);
            });
            $.ajax({
                type: "get",
                url: `{{ route('kontrak.kelompok.useable') }}`,
                dataType: "json",
                success: function(response) {
                    $('[name=kelompok]').html(response.data);
                }
            });
            $("#modalFormRincian").on('shown.bs.modal', function() {
                setTimeout(() => {
                    $('[name=kelompok]').select2({
                        dropdownParent: $("#modalFormRincian"),
                        placeholder: "Kelompok"
                    });
                    $('[name=jenis]').select2({
                        dropdownParent: $("#modalFormRincian"),
                        placeholder: "Jenis"
                    });
                    $('[name=objek]').select2({
                        dropdownParent: $("#modalFormRincian"),
                        placeholder: "Objek"
                    });
                    $('[name=rincian]').select2({
                        dropdownParent: $("#modalFormRincian"),
                        placeholder: "Rincian"
                    });
                    $('[name=subrincian]').select2({
                        dropdownParent: $("#modalFormRincian"),
                        placeholder: "Sub Rincian"
                    });
                    $('[name=uraian]').select2({
                        dropdownParent: $("#modalFormRincian"),
                        placeholder: "Uraian"
                    });
                    $('.datetimepickermodal-rincian').datepicker({
                        format: "dd MM yyyy",
                        todayBtn: "linked",
                        clearBtn: true,
                        language: "id",
                        autoclose: true,
                        orientation: "top auto",
                        toggleActive: true,
                        container: '#modalFormRincian'
                    });
                }, 250);
            });
            $('#kelompok').on('change', function() {
                $('#jenis').empty().prop('disabled', false);
                $('#objek').empty().prop('disabled', true);
                $('#rincian').empty().prop('disabled', true);
                $('#subrincian').empty().prop('disabled', true);
                $('#uraian').empty().prop('disabled', true);
                $.ajax({
                    type: "get",
                    url: `{{ route('kontrak.jenis.useable') }}`,
                    data: {
                        prev: $('#kelompok').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $('[name=jenis]').html(response.data);
                    }
                });
            });
            $('#jenis').on('change', function() {
                $('#objek').empty().prop('disabled', false);
                $('#rincian').empty().prop('disabled', true);
                $('#subrincian').empty().prop('disabled', true);
                $('#uraian').empty().prop('disabled', true);

                const jenis = $('#jenis').val().split('.')[0];
                if (jenis == '131') {
                    $('.kiba').show();
                    $('.kibb, .kibc, .kibd, .kibe, .kibf').hide();
                } else if (jenis == '132') {
                    $('.kibb').show();
                    $('.kiba, .kibc, .kibd, .kibe, .kibf').hide();
                } else if (jenis == '133') {
                    $('.kibc').show();
                    $('.kiba, .kibb, .kibd, .kibe, .kibf').hide();
                } else if (jenis == '134') {
                    $('.kibd').show();
                    $('.kiba, .kibb, .kibc, .kibe, .kibf').hide();
                } else if (jenis == '135') {
                    $('.kibe').show();
                    $('.kiba, .kibb, .kibc, .kibd, .kibf').hide();
                } else if (jenis == '136') {
                    $('.kibf').show();
                    $('.kiba, .kibb, .kibc, .kibd, .kibe').hide();
                } else {
                    $('.kiba, .kibb, .kibc, .kibd, .kibe, .kibf').hide();
                }

                $.ajax({
                    type: "get",
                    url: `{{ route('kontrak.objek.useable') }}`,
                    data: {
                        prev: $('#jenis').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $('[name=objek]').html(response.data);
                    }
                });
            });
            $('#objek').on('change', function() {
                $('#rincian').empty().prop('disabled', false);
                $('#subrincian').empty().prop('disabled', true);
                $('#uraian').empty().prop('disabled', true);
                $.ajax({
                    type: "get",
                    url: `{{ route('kontrak.rincian.useable') }}`,
                    data: {
                        prev: $('#objek').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $('[name=rincian]').html(response.data);
                    }
                });
            });
            $('#rincian').on('change', function() {
                $('#subrincian').empty().prop('disabled', false);
                $('#uraian').empty().prop('disabled', true);
                $.ajax({
                    type: "get",
                    url: `{{ route('kontrak.subrincian.useable') }}`,
                    data: {
                        prev: $('#rincian').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $('[name=subrincian]').html(response.data);
                    }
                });
            });
            $('#subrincian').on('change', function() {
                $('#uraian').empty().prop('disabled', false);
                $.ajax({
                    type: "get",
                    url: `{{ route('kontrak.uraian.useable') }}`,
                    data: {
                        prev: $('#subrincian').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $('[name=uraian]').html(response.data);
                    }
                });
            });
            $('#uraian').on('change', function() {
                $('[name=kode]').val($('#uraian').val());
            });
            $(".add").click(function() {
                window.state = 'add';
                $('#modalFormKontrak').modal('show');
                $('#modalFormKontrak').find('.modal-title').html('Tambah Kontrak');
                $('#modalFormKontrak').find('[name=id]').val("{{ generateNextIdKontrak() }}");
                $("#form-kontrak")[0].reset();
            });
            $(".add-rincian").click(function() {
                window.state = 'add';
                hakSelect();
                statusTanahSelect()
                $('#modalFormKontrak').modal('hide');
                $('#modalFormRincian').modal('show');
                $("#form-rincian").find('.select-container').show();
                $("#form-rincian").find('.jumlahbarang-container').show();
                $("#form-rincian")[0].reset();
                $('#jenis').empty().prop('disabled', true);
                $('#objek').empty().prop('disabled', true);
                $('#rincian').empty().prop('disabled', true);
                $('#subrincian').empty().prop('disabled', true);
                $('#uraian').empty().prop('disabled', true);
                $('.kiba, .kibb, .kibc, .kibd, .kibe, .kibf').hide();
            });
            $('.single').off('click').click(function() {
                if (window.state == 'add') {
                    saveKontrak();
                } else {
                    updateKontrak();
                }
            });
            $('.store-rincian').off('click').click(function() {
                if (window.state == 'add') {
                    saveRincian();
                } else {
                    updateRincian();
                }
            })
        });
    </script>
@endpush
