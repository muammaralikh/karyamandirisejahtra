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

    /* Gaya Responsif Tambahan */
    .img-thumbnail-sm {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    .img-placeholder {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }

    .badge-custom {
        font-size: 0.85em;
        padding: 4px 10px;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: white;
    }

    .table-responsive-custom {
        min-width: 100%;
        width: 100%;
        margin-bottom: 0;
    }

    .table-responsive-custom thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 10;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    .table-responsive-custom td {
        vertical-align: middle;
    }

    .btn-action-group {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-action-group .btn {
        min-width: 70px;
        font-size: 0.85rem;
        padding: 4px 8px;
    }

    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Pilih";
    }

    .preview-image {
        max-width: 150px;
        max-height: 150px;
        object-fit: contain;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        padding: 3px;
        background: white;
    }

    .card-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .img-thumbnail-sm, .img-placeholder {
            width: 50px;
            height: 50px;
        }
        
        .btn-action-group .btn {
            min-width: 60px;
            font-size: 0.8rem;
            padding: 3px 6px;
        }
        
        .card-header-actions {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .card-header-actions .btn {
            margin-top: 10px;
        }
        
        .preview-image {
            max-width: 120px;
            max-height: 120px;
        }
    }

    @media (max-width: 576px) {
        .table-container::after {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            opacity: 0.7;
            pointer-events: none;
        }
        
        .btn-action-group {
            flex-direction: column;
            gap: 3px;
        }
        
        .btn-action-group .btn {
            width: 100%;
            min-width: auto;
        }
        
        .img-thumbnail-sm, .img-placeholder {
            width: 40px;
            height: 40px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
    }

    @media (max-width: 400px) {
        .filter-form .col-md-4 {
            margin-top: 10px;
        }
        
        .filter-form .btn {
            margin-bottom: 5px;
        }
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        background: #f8f9fa;
        border-radius: 4px;
    }

    .empty-state i {
        font-size: 48px;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .modal-lg-custom {
        max-width: 500px;
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
                    <h1>Data Kategori</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#tambahKategori">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-actions">
                    <h3 class="card-title mb-0">Manajemen Kategori</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('kategori.index') }}" class="mb-4 filter-form">
                        <div class="row">
                            <div class="col-md-4 col-sm-8 mb-2">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Cari nama kategori..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 mb-2">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-2 text-right">
                                @if(request()->has('search') && request('search'))
                                    <small class="text-muted">
                                        Hasil pencarian: "{{ request('search') }}"
                                    </small>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="table-container">
                        <table class="table table-bordered table-hover table-responsive-custom">
                            <thead class="thead-light">
                                <tr>
                                    <th width="60">#</th>
                                    <th width="80">Gambar</th>
                                    <th>Nama Kategori</th>
                                    <th width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $kategori)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-center">
                                            @if($kategori->gambar)
                                                <img src="{{ asset('storage/' . $kategori->gambar) }}" 
                                                     class="img-thumbnail-sm" 
                                                     alt="{{ $kategori->nama }}"
                                                     title="{{ $kategori->nama }}">
                                            @else
                                                <div class="img-placeholder">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong class="mr-2">{{ $kategori->nama }}</strong>
                                                @if($kategori->produk_count > 0)
                                                    <span class="badge badge-info badge-pill">
                                                        {{ $kategori->produk_count }} produk
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-action-group justify-content-center">
                                                <button class="btn btn-warning btn-sm" 
                                                        data-toggle="modal" 
                                                        data-target="#edit{{ $kategori->id }}"
                                                        title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="d-none d-sm-inline"> Edit</span>
                                                </button>
                                                <button class="btn btn-danger btn-sm" 
                                                        data-toggle="modal" 
                                                        data-target="#hapus{{ $kategori->id }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="d-none d-sm-inline"> Hapus</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-folder-open"></i>
                                                <h5 class="mt-3">Tidak ada kategori ditemukan</h5>
                                                <p class="text-muted">
                                                    @if(request()->has('search') && request('search'))
                                                        Tidak ada kategori dengan nama "{{ request('search') }}"
                                                    @else
                                                        Belum ada data kategori. Silakan tambah kategori baru.
                                                    @endif
                                                </p>
                                                <button class="btn btn-info btn-sm mt-2" 
                                                        data-toggle="modal" 
                                                        data-target="#tambahKategori">
                                                    <i class="fas fa-plus"></i> Tambah Kategori Pertama
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
        </div>
    </section>
</div>
<div class="modal fade" id="tambahKategori">
    <div class="modal-dialog modal-lg-custom">
        <div class="modal-content">
            <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data" id="formTambah">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus"></i> Tambah Kategori Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" 
                               placeholder="Masukkan nama kategori" required>
                        <small class="text-muted">Masukkan nama kategori yang deskriptif</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Gambar Kategori</label>
                        <div class="custom-file">
                            <input type="file" name="gambar" class="custom-file-input" 
                                   id="gambarInput" accept="image/*">
                            <label class="custom-file-label" for="gambarInput">
                                Pilih file gambar...
                            </label>
                        </div>
                        <small class="text-muted">
                            Opsional. Format: JPG, PNG, JPEG (Maks: 2MB)
                        </small>
                        
                        <div class="mt-3" id="previewContainer" style="display: none;">
                            <label>Preview Gambar:</label>
                            <div class="mt-2">
                                <img id="previewImage" class="preview-image" src="" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($kategoris as $kategori)
    <div class="modal fade" id="edit{{ $kategori->id }}">
        <div class="modal-dialog modal-lg-custom">
            <div class="modal-content">
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">
                            <i class="fas fa-edit"></i> Edit Kategori
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ $kategori->nama }}" 
                                   class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Gambar Kategori</label>
                            <div class="custom-file">
                                <input type="file" name="gambar" class="custom-file-input" 
                                       id="editGambar{{ $kategori->id }}" accept="image/*">
                                <label class="custom-file-label" for="editGambar{{ $kategori->id }}">
                                    Pilih file baru...
                                </label>
                            </div>
                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti gambar
                            </small>
                        </div>
                        
                        @if($kategori->gambar)
                            <div class="form-group">
                                <label>Gambar Saat Ini</label>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $kategori->gambar) }}" 
                                         class="preview-image" 
                                         alt="{{ $kategori->nama }}">
                                </div>
                                <small class="text-muted">
                                    Gambar yang sedang digunakan
                                </small>
                            </div>
                        @endif
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
    <div class="modal fade" id="hapus{{ $kategori->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
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
                        <p>Anda yakin ingin menghapus kategori:</p>
                        <h5 class="text-danger font-weight-bold">{{ $kategori->nama }}</h5>
                        
                        @if(isset($kategori->produk_count) && $kategori->produk_count > 0)
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-circle"></i>
                                Kategori ini memiliki <strong>{{ $kategori->produk_count }} produk</strong>.
                                Menghapus kategori akan mempengaruhi produk terkait.
                            </div>
                        @endif
                        
                        <p class="text-muted mt-3">Tindakan ini tidak dapat dibatalkan!</p>
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
    document.getElementById('gambarInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const label = e.target.nextElementSibling;
        
        if (file) {
            label.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            label.textContent = 'Pilih file gambar...';
            previewContainer.style.display = 'none';
        }
    });

    document.querySelectorAll('.custom-file-input').forEach(function(input) {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file...';
            const label = e.target.nextElementSibling;
            label.textContent = fileName;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
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

    $('#tambahKategori').on('hidden.bs.modal', function () {
        document.getElementById('formTambah')?.reset();
        const previewContainer = document.getElementById('previewContainer');
        if (previewContainer) {
            previewContainer.style.display = 'none';
        }
        
        const fileLabel = document.querySelector('#gambarInput + .custom-file-label');
        if (fileLabel) {
            fileLabel.textContent = 'Pilih file gambar...';
        }
    });
</script>