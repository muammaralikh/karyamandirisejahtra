<!DOCTYPE html>
<html lang="id">

<head>
    @include('layouts.header')
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #2196F3;
            --danger-color: #f44336;
            --warning-color: #ff9800;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-color: #dee2e6;
        }

        .account-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
            min-height: 70vh;
        }

        .page-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .page-title {
            font-size: 2.2rem;
            color: var(--dark-color);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
        }

        .account-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }

        /* Sidebar */
        .account-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .user-profile-card {
            padding: 25px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, #45a049 100%);
            color: white;
        }

        .user-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 15px;
        }

        .user-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-email {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .account-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #495057;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: var(--light-color);
            color: var(--primary-color);
        }

        .menu-item.active {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            font-weight: 500;
        }

        .menu-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Content Area */
        .account-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            min-height: 500px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-color);
        }

        .tab-title {
            font-size: 1.5rem;
            color: var(--dark-color);
            font-weight: 600;
        }

        .tab-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            margin-top: 5px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
            font-size: 0.95rem;
        }

        .form-label.required:after {
            content: " *";
            color: var(--danger-color);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }

        .form-control[readonly] {
            background-color: var(--light-color);
            cursor: not-allowed;
        }

        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .avatar-upload {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }

        .avatar-upload-control {
            flex: 1;
        }

        /* Address Cards */
        .address-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .address-card {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            position: relative;
            transition: all 0.3s;
        }

        .address-card.primary {
            border-color: var(--primary-color);
            background-color: rgba(76, 175, 80, 0.05);
        }

        .address-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .address-label {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .address-details {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .address-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 0.95rem;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: #495057;
        }

        .btn-outline:hover {
            background-color: var(--light-color);
        }

        .btn-sm {
            padding: 6px 15px;
            font-size: 0.85rem;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert i {
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .account-container {
                grid-template-columns: 1fr;
            }

            .account-sidebar {
                order: 2;
            }

            .account-content {
                order: 1;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .address-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .account-page {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .account-content {
                padding: 20px;
            }

            .avatar-upload {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <!-- Header & Menu -->
    @include('layouts.menu')

    <!-- Main Content -->
    <div class="account-page">
        <div class="page-header">
            <h1 class="page-title">Akun Saya</h1>
            <p class="page-subtitle">Kelola informasi akun dan preferensi Anda</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="account-container">
            <!-- Sidebar Menu -->
            <div class="account-sidebar">
                <!-- User Profile Card -->
                <div class="user-profile-card">
                    <div class="user-name">{{ $user->name }}</div>
                    <div class="user-email">{{ $user->email }}</div>
                </div>

                <!-- Menu Items -->
                <div class="account-menu">
                    <a href="#" class="menu-item active" data-tab="profile">
                        <i class="fas fa-user"></i>
                        <span>Profil Saya</span>
                    </a>
                    <a href="#" class="menu-item" data-tab="address">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Alamat Pengiriman</span>
                    </a>
                    <a href="#" class="menu-item" data-tab="orders">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Riwayat Pesanan</span>
                    </a>
                    <a href="#" class="menu-item" data-tab="stock">
                        <i class="fas fa-boxes"></i>
                        <span>Stok Produk</span>
                    </a>
                    <a href="#" class="menu-item" data-tab="password">
                        <i class="fas fa-key"></i>
                        <span>Ubah Password</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}"
                        style="border-top: 1px solid #eaeaea; margin-top: 15px; padding-top: 15px;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 12px; background: #f8f9fa; border: 1px solid #ddd; 
                   border-radius: 8px; color: #dc3545; font-weight: 500; cursor: pointer; 
                   transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-sign-out-alt"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Area -->
            <div class="account-content">
                <!-- Tab: Profile -->
                <div id="tab-profile" class="tab-content active">
                    <div class="tab-header">
                        <h2 class="tab-title">Profil Saya</h2>
                        <p class="tab-subtitle">Ubah informasi profil</p>
                    </div>

                    <form action="{{ route('user.account.update-profile') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="form-label required">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="form-text" style="color: var(--danger-color);">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label required">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <p class="form-text" style="color: var(--danger-color);">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <label for="username" class="form-label required">Username</label>
                            <input type="text" id="username" name="username" class="form-control"
                                value="{{ old('username', $user->username) }}"
                                placeholder="Opsional, akan dibuat otomatis jika kosong">
                            @error('username')
                                <p class="form-text" style="color: var(--danger-color);">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-row">
                            <!-- Gender -->
                            <div class="form-group">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Member Since -->
                        <div class="form-group">
                            <label class="form-label">Member Sejak</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('d F Y') }}"
                                readonly>
                        </div>

                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab: Address -->
                <div id="tab-address" class="tab-content">
                    <div class="tab-header">
                        <h2 class="tab-title">Alamat Pengiriman</h2>
                        <p class="tab-subtitle">Kelola alamat untuk pengiriman pesanan</p>
                    </div>

                    <!-- Address List -->
                    @if($user->addresses->count() > 0)
                        <div class="address-grid">
                            @foreach($user->addresses as $address)
                                <div class="address-card {{ $address->is_primary ? 'primary' : '' }}">
                                    @if($address->is_primary)
                                        <span class="address-badge">UTAMA</span>
                                    @endif

                                    <div class="address-label">{{ $address->label }}</div>

                                    <div class="address-details">
                                        <p><strong>Penerima:</strong> {{ $address->recipient_name }}</p>
                                        <p><strong>Telepon:</strong> {{ $address->recipient_phone }}</p>
                                        <p>{{ $address->street }}</p>
                                        <p>{{ $address->district_name }}, {{ $address->city_name }}</p>
                                        <p>{{ $address->province_name }} {{ $address->postal_code }}</p>
                                        @if($address->notes)
                                            <p><strong>Catatan:</strong> {{ $address->notes }}</p>
                                        @endif
                                    </div>

                                    <div class="address-actions">
                                        <button type="button" class="btn btn-sm btn-outline"
                                            onclick="editAddress({{ $address->id }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        @if(!$address->is_primary)
                                            <form action="{{ route('user.account.set-primary-address', $address->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-star"></i> Utama
                                                </button>
                                            </form>

                                            <form action="{{ route('user.account.delete-address', $address->id) }}" method="POST"
                                                style="display: inline;" onsubmit="return confirm('Hapus alamat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px 20px; color: #6c757d;">
                            <i class="fas fa-map-marker-alt"
                                style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i>
                            <p>Belum ada alamat tersimpan</p>
                        </div>
                    @endif

                    <!-- Address Form -->
                    <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid var(--light-color);">
                        <h3 style="font-size: 1.3rem; margin-bottom: 20px; color: var(--dark-color);"
                            id="addressFormTitle">
                            Tambah Alamat Baru
                        </h3>

                        <form action="{{ route('user.account.update-address') }}" method="POST" id="addressForm">
                            @csrf
                            <input type="hidden" name="address_id" id="address_id">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="address_label" class="form-label required">Label Alamat</label>
                                    <input type="text" id="address_label" name="address_label" class="form-control"
                                        placeholder="Contoh: Rumah, Kantor, Kos" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Alamat Utama</label>
                                    <div style="margin-top: 8px;">
                                        <label style="display: flex; align-items: center; cursor: pointer;">
                                            <input type="checkbox" id="is_primary" name="is_primary" value="1">
                                            <span style="margin-left: 8px;">Jadikan alamat utama</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="recipient_name" class="form-label required">Nama Penerima</label>
                                    <input type="text" id="recipient_name" name="recipient_name" class="form-control"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="recipient_phone" class="form-label required">Telepon Penerima</label>
                                    <input type="text" id="recipient_phone" name="recipient_phone" class="form-control"
                                        required>
                                </div>
                            </div>

                            <!-- Form Alamat -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="province_id" class="form-label required">Provinsi</label>
                                    <select id="province_id" name="province_id" class="form-control" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id', isset($editAddress) ? $editAddress->province_id : '') == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">
                                        <span id="province_loading" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i> Memuat...
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="city_id" class="form-label required">Kota/Kabupaten</label>
                                    <select id="city_id" name="city_id" class="form-control" required disabled>
                                        <option value="">Pilih Kota/Kabupaten</option>
                                    </select>
                                    <div class="form-text">
                                        <span id="city_loading" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i> Memuat...
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="district_id" class="form-label required">Kecamatan</label>
                                    <select id="district_id" name="district_id" class="form-control" required disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    <div class="form-text">
                                        <span id="district_loading" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i> Memuat...
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="postal_code" class="form-label required">Kode Pos</label>
                                    <input type="text" id="postal_code" name="postal_code" class="form-control"
                                        value="{{ old('postal_code', isset($editAddress) ? $editAddress->postal_code : '') }}"
                                        required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="street" class="form-label required">Alamat Lengkap</label>
                                <textarea id="street" name="street" class="form-control" rows="3"
                                    placeholder="Jalan, No. Rumah, RT/RW, Desa/Kelurahan" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="notes" class="form-label">Catatan (Opsional)</label>
                                <textarea id="notes" name="notes" class="form-control" rows="2"
                                    placeholder="Contoh: Dekat minimarket, warna rumah hijau"></textarea>
                            </div>

                            <div style="margin-top: 25px; display: flex; gap: 15px;">
                                <button type="submit" class="btn btn-primary" id="addressSubmitBtn">
                                    <i class="fas fa-save"></i> Simpan Alamat
                                </button>

                                <button type="button" class="btn btn-outline" id="cancelEditBtn" style="display: none;"
                                    onclick="cancelEdit()">
                                    <i class="fas fa-times"></i> Batal Edit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Tab: Orders -->
                <div id="tab-orders" class="tab-content">
                    <div class="tab-header">
                        <h2 class="tab-title">Riwayat Pesanan</h2>
                        <p class="tab-subtitle">Daftar semua pesanan Anda</p>
                    </div>

                    @if($orders->count() > 0)
                        <div class="orders-container">
                            @foreach($orders as $order)
                                <div class="order-card">
                                    <div class="order-header">
                                        <div class="order-info">
                                            <div class="order-id">Order #{{ $order->order_number }}</div>
                                            <div class="order-date">{{ $order->created_at->format('d F Y, H:i') }}</div>
                                        </div>
                                        <div class="order-status">
                                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                            </span>
                                        </div>
                                    </div>

                                    <div class="order-items">
                                        @foreach($order->items as $item)
                                            <div class="order-item">
                                                <div class="item-details">
                                                    <h4 class="item-name">{{ $item->product_name }}</h4>
                                                    <div class="item-qty-price">
                                                        <span class="item-qty">{{ $item->qty }} ×</span>
                                                        <span class="item-price">Rp
                                                            {{ number_format($item->price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                                <div class="item-total">
                                                    Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="order-footer">
                                        <div class="order-total">
                                            <span>Total Pesanan:</span>
                                            <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="order-actions">
                                            @if(in_array($order->status, ['completed', 'shipped']))
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    onclick="reviewOrder({{ $order->id }})">
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Pagination -->
                            @if($orders->hasPages())
                                <div class="pagination">
                                    {{ $orders->links() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>Belum ada pesanan</h3>
                            <p>Mulai belanja dan lihat riwayat pesanan Anda di sini</p>
                            <a href="{{ route('produk.showall') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Tab: Stock -->
                <div id="tab-stock" class="tab-content">
                    <div class="tab-header">
                        <h2 class="tab-title">Stok Produk</h2>
                        <p class="tab-subtitle">Data stok ini sinkron dengan produk yang tampil di web</p>
                    </div>

                    <div class="stock-overview">
                        <div class="stock-overview-card">
                            <span>Total Produk</span>
                            <strong>{{ $stockProducts->count() }}</strong>
                        </div>
                        <div class="stock-overview-card">
                            <span>Tersedia</span>
                            <strong>{{ $stockProducts->where('stok', '>', 0)->count() }}</strong>
                        </div>
                        <div class="stock-overview-card">
                            <span>Habis</span>
                            <strong>{{ $stockProducts->where('stok', '<=', 0)->count() }}</strong>
                        </div>
                    </div>

                    <div class="stock-table-wrapper">
                        <table class="stock-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockProducts as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->nama }}</td>
                                        <td>{{ $product->kategori->nama ?? '-' }}</td>
                                        <td>{{ $product->stok ?? 0 }}</td>
                                        <td>
                                            <span class="stock-badge {{ ($product->stok ?? 0) > 0 ? 'in-stock' : 'out-stock' }}">
                                                {{ ($product->stok ?? 0) > 0 ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="stock-empty">Belum ada data stok produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Password -->
                <div id="tab-password" class="tab-content">
                    <div class="tab-header">
                        <h2 class="tab-title">Ubah Password</h2>
                        <p class="tab-subtitle">Pastikan password Anda aman dan kuat</p>
                    </div>

                    <form action="{{ route(name: 'user.account.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password" class="form-label required">Password Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" class="form-control"
                                required>
                            @error('current_password')
                                <p class="form-text" style="color: var(--danger-color);">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label required">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            @error('password')
                                <p class="form-text" style="color: var(--danger-color);">{{ $message }}</p>
                            @enderror
                            <p class="form-text">Minimal 8 karakter, kombinasi huruf dan angka</p>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label required">Konfirmasi Password
                                Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" required>
                        </div>

                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Orders Tab Styles */
        .orders-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .order-card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .order-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid var(--border-color);
        }

        .order-info .order-id {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1.1rem;
            margin-bottom: 3px;
        }

        .order-info .order-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-processing {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #b8daff;
        }

        .status-shipped {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .order-items {
            padding: 20px;
        }

        .order-item {
            display: grid;
            grid-template-columns: 70px 1fr auto;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-details .item-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .item-details .item-variant {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .item-qty-price {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .item-qty {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .item-price {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.95rem;
        }

        .item-total {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1rem;
            min-width: 100px;
            text-align: right;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid var(--border-color);
        }

        .order-total {
            font-size: 1.1rem;
        }

        .order-total strong {
            color: var(--primary-color);
            margin-left: 10px;
        }

        .order-actions {
            display: flex;
            gap: 10px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #adb5bd;
            margin-bottom: 25px;
        }

        /* Pagination */
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination nav {
            display: flex;
            gap: 5px;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s;
        }

        .pagination .page-link:hover {
            background-color: var(--light-color);
        }

        .pagination .active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .disabled .page-link {
            color: #adb5bd;
            cursor: not-allowed;
            background-color: #f8f9fa;
        }

        .stock-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stock-overview-card {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 18px;
            background: #f8fbf8;
        }

        .stock-overview-card span {
            display: block;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 6px;
        }

        .stock-overview-card strong {
            font-size: 1.5rem;
            color: var(--dark-color);
        }

        .stock-table-wrapper {
            overflow-x: auto;
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stock-table th,
        .stock-table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }

        .stock-table th {
            background: #f8f9fa;
            color: var(--dark-color);
            font-weight: 600;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .stock-badge.in-stock {
            background: #d4edda;
            color: #155724;
        }

        .stock-badge.out-stock {
            background: #f8d7da;
            color: #721c24;
        }

        .stock-empty {
            text-align: center;
            color: #6c757d;
            padding: 30px 15px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .order-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .order-item {
                grid-template-columns: 1fr;
                grid-template-rows: auto auto;
            }

            .item-total {
                text-align: left;
                margin-top: 10px;
                padding-left: 85px;
            }
        }
    </style>
    <!-- Footer -->
    @include('layouts.footer')

    <script>
        // Tab Navigation
        document.addEventListener('DOMContentLoaded', function () {
            // Tab Switching
            const menuItems = document.querySelectorAll('.menu-item');
            const tabContents = document.querySelectorAll('.tab-content');

            menuItems.forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Remove active class from all
                    menuItems.forEach(mi => mi.classList.remove('active'));
                    tabContents.forEach(tc => tc.classList.remove('active'));

                    // Add active class to clicked
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(`tab-${tabId}`).classList.add('active');

                    // Save active tab to localStorage
                    localStorage.setItem('activeTab', tabId);
                });
            });

            // Check if there's a saved tab from session
            const savedTab = '{{ session("tab", "profile") }}';
            if (savedTab) {
                menuItems.forEach(mi => mi.classList.remove('active'));
                tabContents.forEach(tc => tc.classList.remove('active'));

                const activeMenuItem = document.querySelector(`.menu-item[data-tab="${savedTab}"]`);
                if (activeMenuItem) {
                    activeMenuItem.classList.add('active');
                    document.getElementById(`tab-${savedTab}`).classList.add('active');
                }
            }

            // Avatar Preview
            window.previewAvatar = function (input) {
                const preview = document.getElementById('avatarImagePreview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };

            // Address Data (mock for demo)
            window.addressData = @json($user->addresses);

            // Edit Address
            window.editAddress = function (addressId) {
                const address = window.addressData.find(a => a.id == addressId);
                if (!address) return;

                // Fill form
                document.getElementById('address_id').value = address.id;
                document.getElementById('address_label').value = address.label;
                document.getElementById('recipient_name').value = address.recipient_name;
                document.getElementById('recipient_phone').value = address.recipient_phone;
                document.getElementById('province').value = address.province;
                document.getElementById('city').value = address.city;
                document.getElementById('district').value = address.district;
                document.getElementById('postal_code').value = address.postal_code;
                document.getElementById('street').value = address.street;
                document.getElementById('notes').value = address.notes || '';
                document.getElementById('is_primary').checked = address.is_primary;

                // Update UI
                document.getElementById('addressFormTitle').textContent = 'Edit Alamat';
                document.getElementById('addressSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Update Alamat';
                document.getElementById('cancelEditBtn').style.display = 'inline-flex';

                // Scroll to form
                document.getElementById('addressForm').scrollIntoView({ behavior: 'smooth' });
            };

            // Cancel Edit Address
            window.cancelEdit = function () {
                // Reset form
                document.getElementById('addressForm').reset();
                document.getElementById('address_id').value = '';
                document.getElementById('is_primary').checked = false;

                // Update UI
                document.getElementById('addressFormTitle').textContent = 'Tambah Alamat Baru';
                document.getElementById('addressSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Simpan Alamat';
                document.getElementById('cancelEditBtn').style.display = 'none';
            };

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
    <script>
        // Wilayah Otomatis
        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('province_id');
            const citySelect = document.getElementById('city_id');
            const districtSelect = document.getElementById('district_id');

            // Event untuk province change
            provinceSelect.addEventListener('change', function () {
                const provinceId = this.value;

                if (!provinceId) {
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    citySelect.disabled = true;
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    districtSelect.disabled = true;
                    return;
                }

                // Show loading
                document.getElementById('city_loading').style.display = 'inline';
                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="">Memuat...</option>';

                // Fetch cities
                fetch(`/api/cities/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                            data.data.forEach(city => {
                                citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                            });
                            citySelect.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        citySelect.innerHTML = '<option value="">Error memuat data</option>';
                    })
                    .finally(() => {
                        document.getElementById('city_loading').style.display = 'none';
                    });

                // Reset district
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                districtSelect.disabled = true;
            });

            // Event untuk city change
            citySelect.addEventListener('change', function () {
                const cityId = this.value;

                if (!cityId) {
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    districtSelect.disabled = true;
                    return;
                }

                // Show loading
                document.getElementById('district_loading').style.display = 'inline';
                districtSelect.disabled = true;
                districtSelect.innerHTML = '<option value="">Memuat...</option>';

                // Fetch districts
                fetch(`/api/districts/${cityId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                            data.data.forEach(district => {
                                districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                            });
                            districtSelect.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        districtSelect.innerHTML = '<option value="">Error memuat data</option>';
                    })
                    .finally(() => {
                        document.getElementById('district_loading').style.display = 'none';
                    });
            });

            // Edit Address - Load wilayah data
            window.editAddress = function (addressId) {
                const address = window.addressData.find(a => a.id == addressId);
                if (!address) return;

                // Fill form data
                document.getElementById('address_id').value = address.id;
                document.getElementById('address_label').value = address.label;
                document.getElementById('recipient_name').value = address.recipient_name;
                document.getElementById('recipient_phone').value = address.recipient_phone;
                document.getElementById('postal_code').value = address.postal_code;
                document.getElementById('street').value = address.street;
                document.getElementById('notes').value = address.notes || '';
                document.getElementById('is_primary').checked = address.is_primary;

                // Set province
                if (address.province_id) {
                    provinceSelect.value = address.province_id;
                    provinceSelect.dispatchEvent(new Event('change'));

                    // Set city after province loaded
                    setTimeout(() => {
                        if (address.city_id) {
                            citySelect.value = address.city_id;
                            citySelect.dispatchEvent(new Event('change'));

                            // Set district after city loaded
                            setTimeout(() => {
                                if (address.district_id) {
                                    districtSelect.value = address.district_id;
                                }
                            }, 500);
                        }
                    }, 500);
                }

                // Update UI
                document.getElementById('addressFormTitle').textContent = 'Edit Alamat';
                document.getElementById('addressSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Update Alamat';
                document.getElementById('cancelEditBtn').style.display = 'inline-flex';

                // Scroll to form
                document.getElementById('addressForm').scrollIntoView({ behavior: 'smooth' });
            };
        });
    </script>
</body>

</html>
