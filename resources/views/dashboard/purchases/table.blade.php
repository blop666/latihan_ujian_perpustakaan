<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Borrow table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Nota</th>
                                <th>Nama Distributor</th>
                                <th>Total</th>
                                <th>Detail Pembelian</th>
                                <th>Actions</th>

                        </thead>
                        <tbody>
                            @foreach ($purchase as $pur)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pur->tgl_nota }}</td>

                                    {{-- {{ dd($pur->total_bayar) }} --}}
                                    <td>{{ $pur->distributor->nama_distributor }}</td>
                                    <td>{{ $pur->total_bayar }}</td>

                                    <td>
                                        <a href="{{ route('purchase.show', $pur->id) }}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Detail">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                    </td>

                                    <td style="position: relative;">
                                        <div class="custom-dropdown">
                                            <button type="button" class="btn btn-sm  btn-info shadow-sm"
                                                onclick="openAuthAlert({{ $pur->id }})">
                                                <i class="fas fa-lock me-1"></i> Edit
                                            </button>
                                            <div class="dropdown-menu-custom">

                                            </div>
                                            <button type="button"
                                                onclick="event.stopImmediatePropagation(); pinoConfirmDelete({{ $pur->id }})"
                                                class="btn btn-danger">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>

                                    <style>
                                        .custom-dropdown {
                                            position: relative;
                                            display: inline-block;
                                        }

                                        .dropdown-btn {
                                            padding: 6px 12px;
                                            border: none;
                                            background: #4f46e5;
                                            color: white;
                                            border-radius: 6px;
                                            cursor: pointer;
                                            font-size: 14px;
                                        }

                                        .dropdown-btn:hover {
                                            background: #4338ca;
                                        }

                                        .dropdown-menu-custom {
                                            display: none;
                                            position: absolute;
                                            right: 0;
                                            margin-top: 8px;
                                            background: white;
                                            min-width: 120px;
                                            border-radius: 8px;
                                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                                            overflow: hidden;
                                            z-index: 1000;
                                        }

                                        .dropdown-menu-custom a,
                                        .dropdown-menu-custom button {
                                            width: 100%;
                                            padding: 10px;
                                            text-align: left;
                                            background: none;
                                            border: none;
                                            cursor: pointer;
                                            font-size: 14px;
                                        }

                                        .dropdown-menu-custom a:hover {
                                            background: #f3f4f6;
                                        }

                                        .delete-btn {
                                            color: #dc2626;
                                        }

                                        .delete-btn:hover {
                                            background: #fee2e2;
                                        }
                                    </style>



                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ADD BUTTON -->
        <a href="{{ route('purchase.create') }}" class="btn btn-dark">
            Add Purchase
        </a>

        <script>
            async function openAuthAlert(id) {
                const {
                    value: password
                } = await Swal.fire({
                    title: 'Otoritas Diperlukan',
                    text: 'Masukkan password Kepala Perpustakaan',
                    input: 'password',
                    inputPlaceholder: '••••••••',
                    showCancelButton: true,
                    confirmButtonText: 'Verifikasi Akun',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#11cdef', // Warna info/gradient-info
                    inputAttributes: {
                        autocapitalize: 'off',
                        autocorrect: 'off'
                    },
                    // Loading state saat tombol ditekan
                    showLoaderOnConfirm: true,
                    preConfirm: async (password) => {
                        try {
                            const response = await fetch(`/dashboard/purchase/${id}/verify`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json', // <--- WAJIB ADA
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    password: password
                                })
                            });

                            const data = await response.json();

                            if (!response.ok || !data.success) {
                                throw new Error(data.message || 'Password salah');
                            }

                            return data;
                        } catch (error) {
                            Swal.showValidationMessage(`Gagal: ${error.message}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });

                // Jika verifikasi berhasil
                if (password) {
                    window.location.href = `/dashboard/purchase/${id}/edit`;
                }
            }



            window.pinoConfirmDelete = function(id) {
                Swal.close();

                Swal.fire({
                    title: 'Otoritas Diperlukan',
                    text: 'Masukkan password Kepala Perpustakaan',
                    input: 'password',
                    showCancelButton: true,
                    confirmButtonText: 'Verifikasi & Hapus',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: async (password) => {
                        try {
                            const response = await fetch(`/dashboard/purchase/${id}/verify`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    password: password
                                })
                            });

                            const data = await response.json();
                            if (!response.ok) {
                                // Kalau salah, lemparkan error agar tetap di popup password
                                throw new Error(data.message || 'Password salah');
                            }
                            return data;
                        } catch (error) {
                            Swal.showValidationMessage(`Gagal: ${error.message}`);
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        executeDelete(id);
                    }
                });

                return false; // Mencegah bubbling event
            }

            async function executeDelete(id) {
                try {
                    const response = await fetch(`/dashboard/purchase/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        Swal.fire('Terhapus!', 'Data pembelian dan stok telah diperbarui.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                }
            }
        </script>
    </div>
</div>
