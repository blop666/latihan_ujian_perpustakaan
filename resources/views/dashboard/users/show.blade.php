@extends('be.master') {{-- sesuaikan dengan layout kamu --}}

@section('menu')
    @include('be.menu')
@endsection

@section('main')

<div class="container-fluid py-4 mt-6">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center p-4">

                    <!-- FOTO -->
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $borrow->foto) }}"
                             class="rounded-circle shadow"
                             width="150"
                             height="150"
                             style="object-fit: cover;">
                    </div>

                    <!-- NAMA -->
                    <h4 class="mb-1">{{ $borrow->nama_peminjam }}</h4>

                    <!-- STATUS BADGE -->
                    @php
                        $badgeClass = match($borrow->status) {
                            'siswa' => 'bg-gradient-info',
                            'guru' => 'bg-gradient-success',
                            'tendik' => 'bg-gradient-warning',
                            'umum' => 'bg-gradient-secondary',
                            default => 'bg-gradient-danger'
                        };
                    @endphp

                    <span class="badge {{ $badgeClass }} mb-4">
                        {{ ucfirst($borrow->status) }}
                    </span>

                    <hr>

                    <!-- DETAIL -->
                    <div class="row text-start">

                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p class="text-muted mb-0">{{ $borrow->email }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>No Telepon:</strong>
                            <p class="text-muted mb-0">{{ $borrow->no_telpon }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Jenis Kelamin:</strong>
                            <p class="text-muted mb-0">{{ $borrow->jk }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Kelas:</strong>
                            <p class="text-muted mb-0">{{ $borrow->kelas }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>NISN:</strong>
                            <p class="text-muted mb-0">{{ $borrow->nisn }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>NIP:</strong>
                            <p class="text-muted mb-0">{{ $borrow->nip }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Tahun Ajaran:</strong>
                            <p class="text-muted mb-0">{{ $borrow->tahun_ajaran }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Alamat:</strong>
                            <p class="text-muted mb-0">{{ $borrow->alamat }}</p>
                        </div>

                    </div>

                    <div class="mt-4">
                        <a href="{{ route('borrow.index') }}" class="btn bg-gradient-dark">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection