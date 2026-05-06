

@extends('be.master') {{-- sesuaikan dengan layout kamu --}}

@section('menu')
    @include('be.menu')
@endsection

@section('main')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Detail Transaksi Pembelian #{{ $purchase->id }}</h6>
                    <a href="{{ route('purchase.index') }}" class="btn btn-sm bg-gradient-secondary">Kembali</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="p-4">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Distributor</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $purchase->distributor->nama_distributor }}
                                </h5>
                                <p class="text-muted text-xs">{{ $purchase->distributor->alamat }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Tanggal Nota</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ \Carbon\Carbon::parse($purchase->tgl_nota)->format('d M Y H:i') }}
                                </h5>
                            </div>
                            <div class="col-md-4 text-end">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Bayar</p>
                                <h5 class="text-primary font-weight-bolder mb-0">
                                    Rp {{ number_format($purchase->total_bayar, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Buku</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga Beli</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->detail_pembelians as $detail)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $detail->book->judul }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $detail->book->penerbit }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-info">{{ $detail->jumlah_beli }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection