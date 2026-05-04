@include('admin.layouts.header')
@include('admin.layouts.menu')

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

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Data belum lengkap',
            html: @json($errors->all()).join('<br>')
        });
    </script>
@endif

<style>
    .ongkir-pesanan-pagination {
        margin-top: 0;
        padding-top: 0.5rem;
    }
    .ongkir-pesanan-pagination .pagination {
        justify-content: flex-end;
        margin: 0;
    }
    .ongkir-pesanan-pagination .page-link {
        padding: 0.35rem 0.75rem;
        min-width: 0;
        border-radius: 0.35rem;
    }
    .ongkir-pesanan-pagination .page-item {
        margin: 0 0.15rem;
    }
    .ongkir-pesanan-pagination .text-muted {
        font-size: 0.85rem;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ongkir Pesanan</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#tambahOngkir">
                        <i class="fas fa-shipping-fast"></i> Tambah Ongkir
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tarif Ongkir per Kecamatan/Kota</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('ongkir-pesanan.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-5 col-sm-8 mb-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari kecamatan atau kota..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-7 col-sm-4 mb-2">
                                <button class="btn btn-primary btn-sm mr-2">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('ongkir-pesanan.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Kecamatan atau Kota</th>
                                    <th>Kabupaten</th>
                                    <th width="160">Tarif Ongkir</th>
                                    <th width="160" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shippingRates as $rate)
                                    <tr>
                                        <td>{{ ($shippingRates->currentPage() - 1) * $shippingRates->perPage() + $loop->iteration }}</td>
                                        <td>{{ $rate->district_name ?? '-' }}</td>
                                        <td>{{ $rate->city_name ?? '-' }}</td>
                                        <td class="text-nowrap">Rp {{ number_format($rate->tarif_ongkir, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editOngkir{{ $rate->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusOngkir{{ $rate->id }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada tarif ongkir.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($shippingRates->hasPages())
                    <div class="card-footer ongkir-pesanan-pagination">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Menampilkan {{ $shippingRates->firstItem() }} - {{ $shippingRates->lastItem() }} dari {{ $shippingRates->total() }} data
                            </div>
                            <div class="pagination pagination-sm">
                                {{ $shippingRates->links('vendor.pagination.ongkir-pesanan') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="tambahOngkir">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('shipping-rates.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Tambah Ongkir Pesanan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kota</label>
                        <input type="text" name="district_name" class="form-control" placeholder="Contoh: PURWOKERTO BARAT">
                        <small class="text-muted">Isi nama kota atau kabupaten.</small>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten</label>
                        <input type="text" name="city_name" class="form-control" placeholder="Contoh: BANYUMAS">
                    </div>
                    <div class="form-group">
                        <label>Tarif Ongkir <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="tarif_ongkir" class="form-control" min="0" required placeholder="10000">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($shippingRates as $rate)
    <div class="modal fade" id="editOngkir{{ $rate->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('shipping-rates.update', $rate->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Tarif Ongkir</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kota</label>
                            <input type="text" name="district_name" class="form-control" value="{{ $rate->district_name }}">
                        </div>
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <input type="text" name="city_name" class="form-control" value="{{ $rate->city_name }}">
                        </div>
                        <div class="form-group">
                            <label>Tarif Ongkir <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="tarif_ongkir" class="form-control" min="0" required value="{{ (int) $rate->tarif_ongkir }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hapusOngkir{{ $rate->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('shipping-rates.destroy', $rate->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="fas fa-trash"></i> Hapus Tarif Ongkir</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Hapus tarif ongkir untuk:</p>
                        <strong>{{ $rate->district_name ?? '-' }} {{ $rate->city_name ? ' - ' . $rate->city_name : '' }}</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
