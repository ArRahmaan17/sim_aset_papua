<div>
    <form id="form-kib-a" class="m-2">
        <div class="mb-3">
            <label class="form-label" for="deskripsibarang">Nama (asli) Barang
                <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
            <input id="deskripsibarang" name="deskripsibarang" type="text" class="form-control">
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nilaibarang">Nilai Satuan
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    </label>
                    <input id="nilaibarang" name="nilaibarang" type="text" maxlength="22"
                        class="form-control money-mask">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="luas">Luas (m2) <i
                            class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <input id="luas" name="luas" type="text" class="form-control money-mask">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="tahunperolehan">Tahun Perolehan
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <input id="tahunperolehan" name="tahunperolehan" type="text" class="form-control yearpickernew"
                        readonly value="{{ env('TAHUN_APLIKASI') }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label control-label" for="kodeasalusul">Asal Usul
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <select class="select2modal" name="select-asal-usul-barang-perolehan-aset" id="kodeasalusul"
                        style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label control-label" for="kategorikodeasalusul">Kategori Asal Usul
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <select class="select2modal" name="kodeasalusul" id="kategorikodeasalusul" style="width: 100%">
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="4" style="resize: none;"></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="keterangan">Keterangan <i
                            class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4" style="resize: none;"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="penggunaan">Penggunaan</label>
                    <input id="penggunaan" name="penggunaan" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="kodehak">Hak</label>
                    <select class="select2modal" name="kodehak" id="kodehak" style="width: 100%">
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label col-2" for="kodesatuan">Satuan</label>
                    <select class="select2modal" id="kodesatuan" name="kodesatuan" style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label col-2" for="koderuang">Ruangan</label>
                <div class="mb-3">
                    <select id="koderuang" name="koderuang" class="select2modal" style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="kodegolonganbarang">Golongan Barang</label>
                    <select class="select2modal" name="kodegolonganbarang" id="kodegolonganbarang"
                        style="width: 100%">
                    </select>
                </div>
            </div>
        </div>
    </form>

    <form id="form-kib-b" class="m-2">
        <div class="mb-3">
            <label class="form-label" for="deskripsibarang">Nama (asli) Barang <i
                    class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
            <input id="deskripsibarang" name="deskripsibarang" type="text" class="form-control">
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nilaibarang">Nilai Satuan <i
                            class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    </label>
                    <input id="nilaibarang" name="nilaibarang" type="text" maxlength="22"
                        class="form-control money-mask">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="jumlah">Jumlah <i
                            class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <input id="jumlah" name="jumlah" type="text" class="form-control money-mask">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label class="form-label" for="kodekondisi">Kondisi <i
                        class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                <div class="mb-3">
                    <select name="kodekondisi" id="kodekondisi" class="select2modal" style="width:100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="tahunperolehan">Tahun Perolehan <i
                            class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <input id="tahunperolehan" name="tahunperolehan" type="text"
                        class="form-control yearpickernew" readonly value="{{ env('TAHUN_APLIKASI') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label control-label" for="kodeasalusul">Asal Usul
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <select class="select2modal" name="select-asal-usul-barang-perolehan-aset" id="kodeasalusul"
                        style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label control-label" for="kategorikodeasalusul">Kategori Asal Usul
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <select class="select2modal" name="kodeasalusul" id="kategorikodeasalusul" style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="keterangan">Keterangan <i
                            class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="tahunpembuatan">Tahun Pembuatan</label>
                    <input id="tahunpembuatan" name="tahunpembuatan" type="text" class="form-control yearpicker">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="kodegolonganbarang">Golongan Barang</label>
                    <div class="mb-3">
                        <select class="select2modal" name="kodegolonganbarang" id="kodegolonganbarang"
                            style="width: 100%">
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label" for="kodewarna">Warna</label>
                <div class="mb-3">
                    <select name="kodewarna" id="kodewarna" class="select2modal" style="width:100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="bahan">Bahan</label>
                    <input id="bahan" name="bahan" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nopabrik">No Pabrik</label>
                    <input id="nopabrik" name="nopabrik" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="norangka">No Rangka</label>
                    <input id="norangka" name="norangka" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nomesin">No Mesin</label>
                    <input id="nomesin" name="nomesin" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nopolisi">No Polisi</label>
                    <input id="nopolisi" name="nopolisi" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nobpkb">No BPKB</label>
                    <input id="nobpkb" name="nobpkb" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label col-2" for="kodesatuan">Satuan</label>
                <div class="mb-3">
                    <select class="select2modal" id="kodesatuan" name="kodesatuan" style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="merktype">Merk / Type</label>
                    <input id="merktype" name="merktype" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label col-2" for="koderuang">Ruangan</label>
                <div class="mb-3">
                    <select class="select2modal" id="koderuang" name="koderuang" style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="ukuran">Ukuran / CC</label>
                    <input id="ukuran" name="ukuran" type="text" class="form-control">
                </div>
            </div>
        </div>
    </form>

    <form id="form-kib-e" class="m-2">
        <div class="mb-3">
            <label class="form-label" for="deskripsibarang">Nama (asli) Barang <i
                    class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i>
                class="uil uil-star text-danger"></i></label>
            <input id="deskripsibarang" name="deskripsibarang" type="text" class="form-control">
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nilaibarang">Nilai Satuan <i
                            class="uil uil-star text-danger"></i></label>
                    <input id="nilaibarang" name="nilaibarang" type="text" maxlength="22"
                        class="form-control money-mask">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="jumlah">Jumlah <i
                            class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <input id="jumlah" name="jumlah" type="text" class="form-control money-mask">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nilaihibahtotal">Perolehan Hibah Total</label>
                    <input id="nilaihibahtotal" name="nilaihibahtotal" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="tahunperolehan">Tahun Perolehan <i
                            class="uil uil-star text-danger"></i></label>
                    <input id="tahunperolehan" name="tahunperolehan" type="text"
                        class="form-control yearpickernew" value="{{ env('TAHUN_APLIKASI') }}">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="mb-0">
                    <label class="form-label" for="keterangan">Keterangan <i
                            class="uil uil-star text-danger"></i></label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4" style="resize: none;"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label col-2" for="kodesatuan">Satuan</label>
                    <select class="select2modal" id="kodesatuan" name="kodesatuan" style="width: 100%;">
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label col-2" for="koderuang">Ruangan</label>
                    <select class="select2modal" id="koderuang" name="koderuang" style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label control-label" for="kodeasalusul">Asal Usul
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <select class="select2modal" name="select-asal-usul-barang-perolehan-aset" id="kodeasalusul"
                        style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label control-label" for="kategorikodeasalusul">Kategori Asal Usul
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <select class="select2modal" name="kodeasalusul" id="kategorikodeasalusul" style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="kodegolonganbarang">Golongan Barang</label>
                    <select class="select2modal" name="kodegolonganbarang" id="kodegolonganbarang"
                        style="width: 100%">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div id="container-detail-form"></div>
        </div>
    </form>
    <div id="detail-form-kib-e-17" class="col-12">
        <hr>
        <h6>BUKU / PERPUSTAKAAN</h6>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="judul">Judul</label>
                    <input class="form-control" id="judul" name="judul" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="pencipta">Pencipta/Pengarang</label>
                    <input class="form-control" id="pencipta" name="pencipta" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="bahan">Bahan</label>
                    <input class="form-control" id="bahan" name="bahan" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="asaldaerah">Asal Daerah</label>
                    <input class="form-control" id="asaldaerah" name="asaldaerah" />
                </div>
            </div>
        </div>
    </div>

    <div id="detail-form-kib-e-18" class="col-12">
        <hr>
        <h6>Barang Bercorak Kesenian / Budaya</h6>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="jenis">Jenis</label>
                    <input class="form-control" id="jenis" name="jenis" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="ukuran">Ukuran</label>
                    <input class="form-control" id="ukuran" name="ukuran" />
                </div>
            </div>
        </div>

    </div>

    <div id="detail-form-kib-e-19" class="col-12">
        <hr>
        <h6>Hewan Ternak dan Tumbuhan</h6>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="asaldaerah">Asal Daerah</label>
                    <input class="form-control" id="asaldaerah" name="asaldaerah" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="pencipta">Pencipta/Pengarang</label>
                    <input class="form-control" id="pencipta" name="pencipta" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-0">
                    <label class="form-label" for="bahan">Bahan</label>
                    <input class="form-control" id="bahan" name="bahan" />
                </div>
            </div>
        </div>
    </div>

    <form id="form-kib-f" class="m-2">
        <div class="mb-3">
            <label class="form-label" for="deskripsibarang">Nama (asli) Barang <i
                    class="uil uil-star text-danger"></i></label>
            <input id="deskripsibarang" name="deskripsibarang" type="text" class="form-control">
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nilaibarang">Nilai Buku Total</label>
                    <input id="nilaibarang" name="nilaibarang" type="text" maxlength="22"
                        class="form-control money-mask">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="luas">Luas (m2)
                        <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                    <input id="luas" name="luas" type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nilaihibahtotal">Perolehan Hibah Total</label>
                    <input id="nilaihibahtotal" name="nilaihibahtotal" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label col-2" for="kodejenisbangunan">Jenis Bangunan</label>
                <div class="mb-3">
                    <select class="select2modal" name="kodejenisbangunan" id="kodejenisbangunan"
                        style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label col-2" for="kodestatustanah">Status Tanah</label>
                <div class="mb-3">
                    <select class="select2modal" id="kodestatustanah" name="kodestatustanah" style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="tahunperolehan">Tahun Perolehan <i
                            class="uil uil-star text-danger"></i></label>
                    <input id="tahunperolehan" name="tahunperolehan" type="text"
                        class="form-control yearpickernew" value="{{ env('TAHUN_APLIKASI') }}">
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label" for="konstruksi">Jenis Konstruksi</label>
                <div id="container-contruction-type" class="mb-3 row">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="nodokumen">No Dokumen</label>
                    <input id="nodokumen" name="nodokumen" type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="tgldok">Tgl Dokumen</label>
                    <div class="input-group">
                        <input type="text" id="tgldok" name="tgldok"
                            class="form-control datetimepickermodal">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="tglmulai">Tgl Mulai</label>
                    <div class="input-group">
                        <input type="text" id="tglmulai" name="tglmulai"
                            class="form-control datetimepickermodal">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label col-2" for="kodekondisi">Kondisi
                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                <div class="mb-3">
                    <select id="kodekondisi" name="kodekondisi" class="select2modal" style="width: 100%;">
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <label class="form-label col-2" for="kodesatuan">Satuan</label>
                <div class="mb-3">
                    <select class="select2modal" id="kodesatuan" name="kodesatuan" style="width: 100%;">
                    </select>
                </div>
                <label class="form-label col-2" for="koderuang">Ruangan</label>
                <div class="mb-3">
                    <select class="select2modal" id="koderuang" name="koderuang" style="width: 100%;">
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="form-label" class="control-label" for="kodeasalusul">Asal Usul
                    <i class='tf-icons bx bxs-star bx-tada bx-xs align-top text-danger'></i></label>
                <div class="mb-3">
                    <select class="select2modal" name="select-asal-usul-barang-perolehan-aset"
                        id="select-asal-usul-barang-perolehan-aset" style="width: 100%">>
                    </select>
                </div>
                <div id="container-asal-usul" class="mb-3 row">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-0">
                    <label class="form-label" for="keterangan">Keterangan <i
                            class="uil uil-star text-danger"></i></label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4" style="resize: none;"></textarea>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div id="container-detail-form"></div>
        </div>
    </form>
</div>
