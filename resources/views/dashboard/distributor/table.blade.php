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
                                <th>Alamat</th>
                                <th>No. Telp</th>
                                <th>Actions</th>
                                
                        </thead>
                        <tbody>
                            @foreach ($dist as $dis)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dis->nama_distributor }}</td>
                                    <td>{{ $dis->alamat }}</td>
                                    <td>{{ $dis->no_telpon }}</td>

                                    <td style="position: relative;">
                                        <div class="custom-dropdown">
                                            <button class="dropdown-btn" onclick="toggleDropdown(this)">
                                                Action ▾
                                            </button>

                                            <div class="dropdown-menu-custom">
                                                <a href="{{ route('distributor.edit', $dis->id) }}">Edit</a>

                                                <form action="{{ route('distributor.destroy', $dis->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn" onclick="confirmDelete(this)">
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
        <a href="{{ route('distributor.create') }}" class="btn btn-dark">
            Add Distributor
        </a>
    </div>
</div>
