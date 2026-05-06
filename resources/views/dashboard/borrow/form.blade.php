@extends('be.master')

@section('menu')
    @include('be.menu')
@endsection

@section('main')
    <div class="card shadow-lg border-0 border-radius-xl">
        <div class="card-header pb-0 text-left bg-transparent">
            <h3 class="font-weight-bolder text-primary text-gradient">Form Peminjaman Buku</h3>
            <p class="mb-0">Catat transaksi peminjaman buku baru</p>
        </div>
        <div class="card-body">
            <form action="{{ route('borrow.store') }}" method="POST" role="form">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label font-weight-bold text-uppercase text-xs">Tanggal Pinjam</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                            <input type="datetime-local" name="tgl_pinjam" id="tgl_pinjam" class="form-control form-control-lg" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label font-weight-bold text-uppercase text-xs">Nama Peminjam</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select name="id_peminjam" class="form-select form-control-lg" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach ($peminjam as $pem)
                                    <option value="{{ $pem->id }}">{{ $pem->nama_peminjam }} ({{ $pem->status }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="horizontal dark my-4">

                    <div class="col-md-6 mb-4">
                        <label class="form-label font-weight-bold text-uppercase text-xs">Buku yang Dipinjam</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <select name="id_buku" id="id_buku" class="form-select form-control-lg" required>
                                <option value="">-- Pilih Buku --</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">
                                        {{ $book->judul }} (Tersedia: {{ $book->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label class="form-label font-weight-bold text-uppercase text-xs">Jumlah Pinjam</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                            <input type="number" name="jumlah_pinjam" class="form-control form-control-lg" value="1" min="1" required>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label class="form-label font-weight-bold text-uppercase text-xs">Denda Perhari (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="denda_perhari" class="form-control form-control-lg" value="2000" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label font-weight-bold text-uppercase text-xs text-danger">Tenggat Kembali (Deadline)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-history"></i></span>
                            <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control form-control-lg border-danger" required>
                        </div>
                        <small class="text-muted">Buku harus dikembalikan sebelum tanggal ini.</small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label font-weight-bold text-uppercase text-xs">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-link text-secondary me-3" onclick="history.back()">Batal</button>
                    <button type="submit" class="btn bg-gradient-primary btn-lg px-5 shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> Proses Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection