

@extends('be.master') {{-- sesuaikan dengan layout kamu --}}

@section('menu')
    @include('be.menu')
@endsection

@section('main')

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-lg border-radius-xl">
            <div class="card-header bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bolder mb-0">Detail Transaksi #{{ $data->id }}</h5>
                    <span class="badge {{ $data->detail_peminjaman->first()->status_pinjam == 'P' ? 'bg-gradient-warning' : 'bg-gradient-success' }}">
                        {{ $data->detail_peminjaman->first()->status_pinjam == 'P' ? 'Sedang Dipinjam' : 'Sudah Kembali' }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <p class="text-xs text-uppercase font-weight-bold mb-0">Informasi Peminjam</p>
                        <h6 class="font-weight-bolder">{{ $data->peminjam->nama_peminjam }}</h6>
                        <p class="text-sm mb-0">Status: {{ $data->peminjam->status }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="text-xs text-uppercase font-weight-bold mb-0">Tanggal Pinjam</p>
                        <h6 class="font-weight-bolder">{{ \Carbon\Carbon::parse($data->tgl_pinjam)->format('d M Y, H:i') }}</h6>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Buku</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deadline</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Denda/Hari</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->detail_peminjaman as $detail)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $detail->book->judul }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold"> {{ $detail->jumlah_pinjam }} </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-sm font-weight-bold text-danger"> {{ \Carbon\Carbon::parse($detail->tgl_kembali)->format('d M Y') }} </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-sm"> Rp {{ number_format($detail->denda_perhari) }} </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-gray-100 border-radius-xl m-3">
                <p class="text-sm mb-0 font-weight-bold">Keterangan:</p>
                <p class="text-sm text-muted italic">{{ $data->detail_peminjaman->first()->keterangan ?? '-' }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-lg border-radius-xl bg-gradient-dark">
            <div class="card-body p-3">
                <h6 class="text-white opacity-8 text-uppercase font-weight-bolder">Status Denda Saat Ini</h6>
                @php
                    $deadline = \Carbon\Carbon::parse($data->detail_peminjaman->first()->tgl_kembali);
                    $now = \Carbon\Carbon::now();
                    $late = $now->diffInDays($deadline, false);
                    $denda = 0;
                    if($late < 0 && $data->detail_peminjaman->first()->status_pinjam == 'P') {
                        $denda = abs($late) * $data->detail_peminjaman->first()->denda_perhari;
                    }
                @endphp
                
                <h2 class="text-white mb-0">Rp {{ number_format($denda) }}</h2>
                <p class="text-white text-sm opacity-8">
                    @if($late < 0)
                        Terlambat {{ abs($late) }} hari
                    @else
                        Sisa waktu {{ floor($late) }} hari lagi
                    @endif
                </p>
                <hr class="horizontal light mt-4 mb-3">
                <button class="btn btn-white btn-sm w-100 mb-0 shadow-none border-radius-lg">Proses Pengembalian</button>
            </div>
        </div>
    </div>
</div>

@endsection