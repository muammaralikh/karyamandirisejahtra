@include('admin.layouts.header')
@include('admin.layouts.menu')
<style>
    .ukuran-box {
        border: 2px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 18px;
        cursor: pointer;
        font-weight: 500;
        transition: all .2s ease;
        background: #fff;
    }

    .ukuran-box input {
        display: none;
    }

    .ukuran-box:hover {
        border-color: #28a745;
        background: #eafaf0;
    }

    .ukuran-box input:checked+span {
        color: #155724;
        font-weight: 600;
    }

    .ukuran-box:has(input:checked) {
        border-color: #28a745;
        background: #28a745;
        color: #fff;
    }

    .ukuran-box:has(input:checked):hover {
        background: #218838;
        border-color: #1e7e34;
    }

    /* Gaya responsif tambahan */
    .img-thumbnail-sm {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    .badge-custom {
        font-size: 0.85em;
        padding: 4px 10px;
    }

    .modal-lg-custom {
        max-width: 800px;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Gaya untuk tombol aksi di tabel */
    .btn-action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .btn-action-group .btn {
        flex: 1;
        min-width: 70px;
        font-size: 0.85rem;
        padding: 4px 8px;
    }
    .filter-form .form-group {
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .btn-action-group .btn {
            min-width: 60px;
            font-size: 0.8rem;
            padding: 3px 6px;
        }
        
        .img-thumbnail-sm {
            width: 50px;
            height: 50px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
        
        .card-header h3 {
            font-size: 1.2rem;
        }
        
        .content-header h1 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .btn-action-group {
            flex-direction: column;
        }
        
        .btn-action-group .btn {
            width: 100%;
        }
        
        .img-thumbnail-sm {
            width: 40px;
            height: 40px;
        }
        
        .badge-custom {
            font-size: 0.75em;
            padding: 3px 6px;
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}'
        });
    </script>
@endif

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Produk</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#tambahProduk">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Produk</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('produk.index') }}" class="mb-4 filter-form">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 mb-2">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <div class="form-group">
                                    <select name="kategori" class="form-control">
                                        <option value="">-- Semua Kategori --</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12 mb-2">
                                <div class="form-group d-flex">
                                    <button class="btn btn-primary btn-sm mr-2">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-sm mr-2">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                    <div class="ml-auto">
                                        <span class="badge badge-light">Total: {{ $produk->total() }} produk</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="40">#</th>
                                    <th width="80">Gambar</th>
                                    <th>Nama</th>
                                    <th width="120">Kategori</th>
                                    <th width="200">Deskripsi</th>
                                    <th width="120">Harga</th>
                                    <th width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produk as $p)
                                    <tr>
                                        <td>{{ ($produk->currentPage() - 1) * $produk->perPage() + $loop->iteration }}</td>
                                        <td>
                                            @if($p->gambar)
                                                <img src="{{ asset('storage/' . $p->gambar) }}" class="img-thumbnail-sm" alt="{{ $p->nama }}">
                                            @else
                                                <div class="img-thumbnail-sm bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">{{ Str::limit($p->nama, 30) }}</td>
                                        <td>
                                            <span class="badge badge-info badge-custom">
                                                {{ $p->kategori->nama ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($p->deskripsi, 50) }}</small>
                                        </td>
                                        <td class="text-nowrap">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="btn-action-group">
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $p->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus{{ $p->id }}" title="Hapus">
                                                    <i class="fas fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-box-open fa-2x mb-3"></i>
                                                <p>Tidak ada produk ditemukan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($produk->hasPages())
                        <div class="mt-3">
                            {{ $produk->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="tambahProduk">
    <div class="modal-dialog modal-lg-custom">
        <div class="modal-content">
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus"></i> Tambah Produk Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" name="nama" placeholder="Masukkan nama produk" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kat)
                                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" name="harga" placeholder="Masukkan harga" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gambar Produk</label>
                                <div class="custom-file">
                                    <input type="file" name="gambar" class="custom-file-input" id="gambarInput" accept="image/*">
                                    <label class="custom-file-label" for="gambarInput">Pilih file...</label>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, JPEG (Maks: 2MB)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi produk" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($produk as $p)
    <div class="modal fade" id="edit{{ $p->id }}">
        <div class="modal-dialog modal-lg-custom">
            <div class="modal-content">
                <form action="{{ route('produk.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="fas fa-edit"></i> Edit Produk
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" value="{{ $p->nama }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori_id" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}" {{ $p->kategori_id == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="harga" value="{{ $p->harga }}" class="form-control" required min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gambar Produk</label>
                                    <div class="custom-file">
                                        <input type="file" name="gambar" class="custom-file-input" id="editGambar{{ $p->id }}">
                                        <label class="custom-file-label" for="editGambar{{ $p->id }}">Pilih file...</label>
                                    </div>
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ $p->deskripsi }}</textarea>
                        </div>
                        
                        @if($p->gambar)
                            <div class="form-group">
                                <label>Gambar Saat Ini</label>
                                <div>
                                    <img src="{{ asset('storage/' . $p->gambar) }}" width="100" class="img-thumbnail">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hapus{{ $p->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('produk.destroy', $p->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-trash"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                        </div>
                        <p>Anda yakin ingin menghapus produk:</p>
                        <h5 class="text-danger font-weight-bold">{{ $p->nama }}</h5>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : "Pilih file...";
            var label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                var required = form.querySelectorAll('[required]');
                var valid = true;
                
                required.forEach(function(field) {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                if (!valid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Harap isi semua field yang wajib diisi!'
                    });
                }
            });
        });
    });
</script>