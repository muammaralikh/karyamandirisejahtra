@include('admin.layouts.header')
@include('admin.layouts.menu')
<style>
    .badge-custom {
        font-size: 0.85em;
        padding: 4px 10px;
    }

    .stock-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .stock-summary-card {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 18px;
        background: #f8faf8;
    }

    .stock-summary-card h4 {
        margin: 0 0 8px;
        font-size: 1rem;
    }

    .stock-summary-card p {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    @media (max-width: 576px) {
        .badge-custom {
            font-size: 0.75em;
            padding: 3px 6px;
        }
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stok Produk</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Stok Sinkron dengan Web</h3>
                </div>
                <div class="card-body">
                    <div class="stock-summary-grid">
                        <div class="stock-summary-card">
                            <h4>Total Produk</h4>
                            <p>{{ $stockProduk->count() }}</p>
                        </div>
                        <div class="stock-summary-card">
                            <h4>Produk Tersedia</h4>
                            <p>{{ $stockProduk->where('stok', '>', 0)->count() }}</p>
                        </div>
                        <div class="stock-summary-card">
                            <h4>Produk Habis</h4>
                            <p>{{ $stockProduk->where('stok', '<=', 0)->count() }}</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="40">#</th>
                                    <th>Nama Produk</th>
                                    <th width="180">Kategori</th>
                                    <th width="120">Stok</th>
                                    <th width="160">Status di Web</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockProduk as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->kategori->nama ?? '-' }}</td>
                                        <td>{{ $item->stok ?? 0 }}</td>
                                        <td>
                                            @if(($item->stok ?? 0) > 0)
                                                <span class="badge badge-success badge-custom">{{ $item->stok }} tersedia</span>
                                            @else
                                                <span class="badge badge-danger badge-custom">Stok habis</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data stok produk.</td>
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
