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
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Email</th>
                                <th>NISN</th>
                                <th>NIP</th>
                                <th>Profile</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrows as $borrow)
                            
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $borrow->nama_peminjam }}</td>
                                    <td>{{ $borrow->jk }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match ($borrow->status) {
                                                'siswa' => 'bg-gradient-info',
                                                'guru' => 'bg-gradient-success',
                                                'tendik' => 'bg-gradient-warning',
                                                'umum' => 'bg-gradient-secondary',
                                                default => 'bg-gradient-danger',
                                            };
                                        @endphp

                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($borrow->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $borrow->email }}</td>
                                    <td>{{ $borrow->nisn }}</td>
                                    <td>{{ $borrow->nip }}</td>

                                    <!-- PROFILE BUTTON -->
                                    <td>
                                        <a href="{{ route('borrow.show', $borrow->id) }}" class="btn btn-sm btn-info">
                                            Profile
                                        </a>
                                    </td>

                                    <!-- ACTION DROPDOWN -->
                                    {{-- <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>

                                            <ul class="dropdown-menu">
                                                <!-- EDIT -->
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('borrow.edit', $borrow->id) }}">
                                                        Edit
                                                    </a>
                                                </li>

                                                <!-- DELETE -->
                                                <li>
                                                    <form action="{{ route('borrow.destroy', $borrow->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Yakin hapus data ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td> --}}

                                    <td style="position: relative;">
                                        <div class="custom-dropdown">
                                            <button class="dropdown-btn" onclick="toggleDropdown(this)">
                                                Action ▾
                                            </button>

                                            <div class="dropdown-menu-custom">
                                                <a href="{{ route('borrow.edit', $borrow->id) }}">Edit</a>

                                                <form action="{{ route('userBorrow.destroy', $borrow->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-btn" onclick="confirmDelete(this)">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
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
        <a href="{{ route('userBorrow.create') }}" class="btn btn-dark">
            Add Users ( Admin Only )
        </a>
    </div>
</div>
