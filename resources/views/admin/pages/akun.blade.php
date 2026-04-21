@include('admin.layouts.header')
@include('admin.layouts.menu')
<style>
    :root {
        --primary-color: #007bff;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --info-color: #17a2b8;
        --dark-color: #343a40;
        --light-color: #f8f9fa;
    }

    .content-wrapper {
        background-color: #f4f6f9;
        min-height: calc(100vh - 97px);
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e0e0e0;
    }

    .user-avatar-lg {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #dee2e6;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-active {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .status-inactive {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .role-badge {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-admin {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    .role-user {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .role-staff {
        background-color: rgba(23, 162, 184, 0.15);
        color: #17a2b8;
    }

    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-responsive-custom {
        margin-bottom: 0;
    }

    .table-responsive-custom thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        padding: 15px 12px;
        white-space: nowrap;
    }

    .table-responsive-custom tbody tr {
        transition: background-color 0.2s;
    }

    .table-responsive-custom tbody tr:hover {
        background-color: rgba(0,123,255,0.03);
    }

    .table-responsive-custom td {
        vertical-align: middle;
        padding: 12px;
        border-color: #f1f1f1;
    }

    .filter-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .btn-view {
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
        border: 1px solid rgba(23, 162, 184, 0.2);
    }

    .btn-view:hover {
        background-color: #17a2b8;
        color: white;
        border-color: #17a2b8;
    }

    .btn-edit {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .btn-edit:hover {
        background-color: #ffc107;
        color: #212529;
        border-color: #ffc107;
    }

    .btn-delete {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    .btn-delete:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        background: white;
        border-radius: 8px;
        margin: 20px 0;
    }

    .empty-state i {
        font-size: 60px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #6c757d;
        margin-bottom: 10px;
    }

    .avatar-upload {
        position: relative;
        display: inline-block;
    }

    .avatar-upload input[type="file"] {
        display: none;
    }

    .avatar-upload label {
        cursor: pointer;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .avatar-upload:hover .avatar-overlay {
        opacity: 1;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 38px;
        cursor: pointer;
        color: #6c757d;
    }

    .modal-lg-custom {
        max-width: 800px;
    }

    .permission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        background: #f8f9fa;
    }

    .permission-item {
        background: white;
        padding: 10px 15px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .permission-item:hover {
        border-color: var(--primary-color);
        background: rgba(0,123,255,0.05);
    }

    .permission-item input:checked + label {
        color: var(--primary-color);
        font-weight: 600;
    }

    .permission-item input:checked ~ .permission-name {
        color: var(--primary-color);
        font-weight: 600;
    }

    .permission-name {
        flex: 1;
        font-size: 0.9rem;
        color: #495057;
    }

    @media (max-width: 768px) {
        .table-responsive-custom {
            font-size: 0.9rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 3px;
        }
        
        .btn-icon {
            width: 28px;
            height: 28px;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
        }
        
        .permission-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .table-container {
            border-radius: 0;
            margin: 0 -15px;
        }
        
        .filter-card {
            padding: 15px;
        }
        
        .modal-lg-custom {
            margin: 10px;
        }
    }

    .loading-spinner {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.8);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .loading-spinner.active {
        display: flex;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            toast: true,
            position: 'top-end'
        });
    </script>
@endif

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-users"></i> Data Pengguna</h1>
                    <small class="text-muted">Manajemen pengguna dan hak akses sistem</small>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahPengguna">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Filter Section -->
            <div class="filter-card">
                <h5 class="mb-3"><i class="fas fa-filter"></i> Filter Data</h5>
                <form method="GET" action="{{ route('daftar-user.index') }}" id="filterForm">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Cari Pengguna</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                    <input type="text" name="search" class="form-control" 
                                       placeholder="Nama, username, email..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        
                        
                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="" class="btn btn-outline-secondary flex-fill">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Pengguna</span>
                            <span class="info-box-number">{{ $totalUsers }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-user-shield"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Admin</span>
                            <span class="info-box-number">{{ $adminCount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengguna</h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">Total: {{ $users->total() }} data</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive-custom">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Informasi Pengguna</th>
                                        <th width="120">Role</th>
                                        <th width="120" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                            <td>
                                                <div>
                                                    <strong class="d-block">{{ $user->name }}</strong>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user mr-1"></i>{{ $user->username }}
                                                    </small>
                                                    <small class="d-block text-muted">
                                                        <i class="fas fa-envelope mr-1"></i>{{ $user->email }}
                                                    </small>
                                                    <small class="d-block text-muted">
                                                        Bergabung: {{ $user->created_at->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="role-badge role-{{ $user->role }}">
                                                    {{ strtoupper($user->role) }}
                                                </span>
                                                @if($user->is_super_admin)
                                                    <small class="d-block text-danger mt-1">
                                                        <i class="fas fa-crown"></i>Admin
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <button class="btn btn-icon btn-edit" 
                                                            data-toggle="modal" 
                                                            data-target="#edit{{ $user->id }}"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-icon btn-delete" 
                                                            data-toggle="modal" 
                                                            data-target="#hapus{{ $user->id }}"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-user-slash"></i>
                                                    <h5 class="mt-3">Tidak ada data pengguna</h5>
                                                    <p class="text-muted">
                                                        @if(request()->hasAny(['search', 'role', 'status']))
                                                            Tidak ada pengguna yang sesuai dengan filter yang dipilih
                                                        @else
                                                            Belum ada pengguna terdaftar
                                                        @endif
                                                    </p>
                                                    <button class="btn btn-primary mt-2" 
                                                            data-toggle="modal" 
                                                            data-target="#tambahPengguna">
                                                        <i class="fas fa-user-plus"></i> Tambah Pengguna Pertama
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if($users->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

<!-- Loading Spinner -->
<div class="loading-spinner" id="loadingSpinner">
    <div class="spinner"></div>
</div>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="tambahPengguna" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg-custom" role="document">
        <div class="modal-content">
            <form action="{{ route('daftar-user.store') }}" method="POST" enctype="multipart/form-data" id="formTambah">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Opsional">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        <span class="password-toggle" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control" required onchange="togglePermissions(this)">
                                    <option value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User Biasa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals untuk setiap user -->
@foreach($users as $user)
    <!-- Modal Detail -->
    <div class="modal fade" id="detail{{ $user->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-circle"></i> Detail Pengguna
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     class="user-avatar-lg mb-3" alt="{{ $user->name }}">
                            @else
                                <div class="user-avatar-lg bg-light d-inline-flex align-items-center justify-content-center mb-3">
                                    <span class="display-4 text-muted">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <h5 class="mb-0">{{ $user->name }}</h5>
                            <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                {{ $user->is_active ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'staff' ? 'info' : 'success') }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                        @if($user->is_super_admin)
                                            <span class="badge badge-warning ml-1">SUPER ADMIN</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bergabung</th>
                                    <td>{{ $user->created_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg-custom" role="document">
            <div class="modal-content">
                <form action="{{ route('daftar-user-update.index', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="fas fa-user-edit"></i> Edit Pengguna
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control" required onchange="toggleEditPermissions({{ $user->id }}, this)">
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="hapus{{ $user->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('daftar-user.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-user-times"></i> Hapus Pengguna
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>PERHATIAN!</strong> Menghapus pengguna akan:
                            <ul class="mb-0 mt-2 text-left">
                                <li>Menghapus semua data terkait pengguna</li>
                                <li>Tidak dapat dikembalikan</li>
                                @if($user->orders->count() > 0)
                                    <li class="text-danger">Terdapat {{ $user->orders->count() }} pesanan terkait</li>
                                @endif
                            </ul>
                        </div>
                        
                        @if($user->id == auth()->id())
                            <div class="alert alert-danger">
                                <i class="fas fa-ban"></i>
                                Anda tidak dapat menghapus akun Anda sendiri!
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger" 
                                {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                            <i class="fas fa-trash"></i> Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    // Fungsi untuk toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Preview avatar saat upload
    document.getElementById('avatarInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('avatarPreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Toggle permissions section berdasarkan role
    function togglePermissions(select) {
        const permissionsSection = document.getElementById('permissionsSection');
        if (select.value === 'admin' || select.value === 'staff') {
            permissionsSection.style.display = 'block';
        } else {
            permissionsSection.style.display = 'none';
            // Uncheck semua permission
            document.querySelectorAll('#permissionsSection input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
        }
    }

    function toggleEditPermissions(userId, select) {
        const permissionsSection = document.getElementById('editPermissionsSection' + userId);
        if (select.value === 'admin' || select.value === 'staff') {
            permissionsSection.style.display = 'block';
        } else {
            permissionsSection.style.display = 'none';
            // Uncheck semua permission
            document.querySelectorAll('#editPermissionsSection' + userId + ' input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
        }
    }

    // Preview avatar di modal edit
    document.querySelectorAll('input[id^="editAvatar"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const userId = this.id.replace('editAvatar', '');
            const preview = document.getElementById('editAvatarPreview' + userId);
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    });

    // Validasi form
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                // Tampilkan loading spinner
                const loadingSpinner = document.getElementById('loadingSpinner');
                loadingSpinner?.classList.add('active');
                
                // Validasi required fields
                const required = form.querySelectorAll('[required]');
                let valid = true;
                
                required.forEach(function(field) {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                        
                        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'Field ini wajib diisi';
                            field.parentNode.appendChild(errorDiv);
                        }
                    } else {
                        field.classList.remove('is-invalid');
                        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
                        if (errorDiv) {
                            errorDiv.remove();
                        }
                    }
                });
                
                // Validasi password confirmation
                const password = form.querySelector('input[name="password"]');
                const confirmPassword = form.querySelector('input[name="password_confirmation"]');
                
                if (password && confirmPassword && password.value && confirmPassword.value) {
                    if (password.value !== confirmPassword.value) {
                        valid = false;
                        confirmPassword.classList.add('is-invalid');
                        if (!confirmPassword.nextElementSibling || !confirmPassword.nextElementSibling.classList.contains('invalid-feedback')) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'Konfirmasi password tidak sesuai';
                            confirmPassword.parentNode.appendChild(errorDiv);
                        }
                    }
                }
                
                if (!valid) {
                    e.preventDefault();
                    loadingSpinner?.classList.remove('active');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Harap periksa kembali form Anda!'
                    });
                }
            });
        });
    });

    // Reset form tambah saat modal ditutup
    $('#tambahPengguna').on('hidden.bs.modal', function () {
        const form = document.getElementById('formTambah');
        if (form) {
            form.reset();
            document.getElementById('avatarPreview').src = '{{ asset('admin/img/default-avatar.png') }}';
            document.getElementById('permissionsSection').style.display = 'none';
            document.querySelectorAll('#permissionsSection input[type="checkbox"]').forEach(cb => {
                cb.checked = false;
            });
        }
    });


    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
