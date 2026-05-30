@extends('be.master')

@section('menu')
    @include('be.menu')
@endsection


@section('main')
        <div class="card shadow-lg border-0 border-radius-xl">
            <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder text-info text-gradient">Form Transaksi Pembelian</h3>
                <p class="mb-0">Silakan lengkapi detail pembelian barang ke distributor</p>
            </div>
            <div class="card-body">
                <form action="{{ route('purchase.store') }}" method="POST" role="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label font-weight-bold text-uppercase text-xs">Tanggal Nota</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" name="tgl_nota" class="form-control form-control-lg border-radius-md"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label font-weight-bold text-uppercase text-xs">Distributor</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-truck-loading"></i></span>
                                <select name="id_distributor" class="form-select form-control-lg border-radius-md" required>
                                    <option value="">-- Pilih Distributor --</option>
                                    @foreach ($distributor as $dis)
                                        <option value="{{ $dis->id }}">{{ $dis->nama_distributor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="horizontal dark my-4">

                        <div class="col-md-6 mb-4">
                            <label class="form-label font-weight-bold text-uppercase text-xs">Pilih Buku / Produk</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                                <select name="id_buku" id="id_buku" class="form-select form-control-lg border-radius-md"
                                    required>
                                    <option value="">-- Cari Buku --</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}" data-harga="{{ $book->harga_beli ?? 0 }}">
                                            {{ $book->judul }} (Stok: {{ $book->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold text-uppercase text-xs">Harga Satuan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_beli" id="harga_beli"
                                    class="form-control form-control-lg border-radius-md" placeholder="0" required>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <label class="form-label font-weight-bold text-uppercase text-xs">Jumlah Beli</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-shopping-basket"></i></span>
                                <input type="number" name="jumlah_beli" id="jumlah_beli"
                                    class="form-control form-control-lg border-radius-md" placeholder="0" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="bg-gray-100 border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-uppercase text-muted font-weight-bolder mb-0">Estimasi Total Bayar:</h6>
                                <h3 class="font-weight-bolder text-dark mb-0" id="display_total">Rp 0</h3>
                                <input type="hidden" name="total_bayar" id="total_bayar">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <button type="button" class="btn btn-link text-secondary me-3" onclick="history.back()">Batal</button>
                        <button type="submit" class="btn bg-gradient-info btn-lg px-5 shadow-sm border-radius-lg text-white">
                            <i class="fas fa-save me-2 text-xs"></i> Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const bookSelect = document.getElementById('id_buku');
                const hargaInput = document.getElementById('harga_beli');
                const jumlahInput = document.getElementById('jumlah_beli');
                const totalInput = document.getElementById('total_bayar');
                const displayTotal = document.getElementById('display_total');

                function formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(angka);
                }

                function hitungTotal() {
                    const harga = parseFloat(hargaInput.value) || 0;
                    const jumlah = parseFloat(jumlahInput.value) || 0;
                    const total = harga * jumlah;

                    // Ini hanya untuk tampilan visual di form agar user tidak bingung
                    displayTotal.innerText = formatRupiah(total);

                    // Nilai ini tetap dikirim ke Controller, tapi nanti diabaikan 
                    // karena Controller set total_bayar = 0 dan membiarkan Trigger menghitung.
                    totalInput.value = total;
                }

                bookSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const harga = selectedOption.getAttribute('data-harga');

                    hargaInput.value = harga || 0;

                    // Efek visual biar user ngeh harganya berubah
                    hargaInput.classList.add('is-valid');
                    setTimeout(() => hargaInput.classList.remove('is-valid'), 1000);

                    hitungTotal();
                });

                jumlahInput.addEventListener('input', hitungTotal);
                hargaInput.addEventListener('input', hitungTotal);
            });
        </script>
@endsection
