@extends('layouts.app')

@section('title', 'Checkout - Toko Lele Premium')

@section('content')
<div class="checkout-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Checkout Pesanan</h1>
            <p class="page-subtitle">Konfirmasi pesanan dan lanjutkan ke WhatsApp untuk pembayaran</p>
        </div>
        
        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif
        
        <form action="{{ route('user.account.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            
            <div class="checkout-container">
                <!-- Left Column: Form & Cart Items -->
                <div class="checkout-main">
                    <!-- Alamat Pengiriman -->
                    <div class="checkout-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat Pengiriman
                            </h3>
                        </div>
                        
                        @if($addresses->count() > 0)
                            <div class="address-grid">
                                @foreach($addresses as $address)
                                <div class="address-card {{ $address->is_primary ? 'primary' : '' }}">
                                    <input type="radio" 
                                           name="address_id" 
                                           id="address-{{ $address->id }}" 
                                           value="{{ $address->id }}" 
                                           {{ $address->is_primary ? 'checked' : '' }}
                                           required
                                           class="address-radio">
                                    
                                    <label for="address-{{ $address->id }}" class="address-label">
                                        <div class="address-header">
                                            <h4>{{ $address->label }}</h4>
                                            @if($address->is_primary)
                                            <span class="badge-primary">Alamat Utama</span>
                                            @endif
                                        </div>
                                        
                                        <div class="address-details">
                                            <p><strong>{{ $address->recipient_name }}</strong></p>
                                            <p>{{ $address->recipient_phone }}</p>
                                            <p>{{ $address->street }}</p>
                                            <p>{{ $address->district_name }}, {{ $address->city_name }}</p>
                                            <p>{{ $address->province_name }} {{ $address->postal_code }}</p>
                                            
                                            @if($address->notes)
                                            <div class="address-notes">
                                                <strong>Catatan:</strong> {{ $address->notes }}
                                            </div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('user.account.my-account') }}?tab=address" class="btn-manage-address">
                                    <i class="fas fa-edit"></i> Kelola Alamat
                                </a>
                            </div>
                        @else
                            <div class="empty-address">
                                <i class="fas fa-map-marker-alt fa-3x"></i>
                                <h4>Belum ada alamat tersimpan</h4>
                                <p>Tambahkan alamat pengiriman terlebih dahulu</p>
                                <a href="{{ route('user.account.my-account') }}?tab=address" class="btn-add-address">
                                    <i class="fas fa-plus"></i> Tambah Alamat Baru
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Catatan Pesanan -->
                    <div class="checkout-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-sticky-note"></i>
                                Catatan Pesanan (Opsional)
                            </h3>
                        </div>
                        
                        <div class="notes-section">
                            <textarea name="notes" id="notes" class="notes-input" 
                                      placeholder="Contoh: Antar sebelum jam 10 pagi, warna rumah hijau, dekat minimarket, dll." 
                                      rows="3"></textarea>
                            <p class="notes-hint">Maksimal 500 karakter</p>
                        </div>
                    </div>
                    
                    <!-- Daftar Produk -->
                    <div class="checkout-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-shopping-cart"></i>
                                Produk yang Dipesan
                            </h3>
                        </div>
                        
                        <div class="cart-items-preview">
                            @foreach($cartItems as $item)
                            <div class="cart-item-preview">
                                <div class="item-info">
                                    <h4 class="item-name">{{ $item->produk->nama }}</h4>
                                    <div class="item-meta">
                                        <span class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        <span class="item-qty">× {{ $item->qty }}</span>
                                    </div>
                                </div>
                                <div class="item-subtotal">
                                    Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Order Summary -->
                <div class="checkout-sidebar">
                    <div class="summary-card">
                        <h3 class="summary-title">Ringkasan Pesanan</h3>
                        
                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="summary-row">
                                <span>Ongkos Kirim</span>
                                <span class="free-shipping">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="summary-divider"></div>
                            
                            <div class="summary-total">
                                <span>Total Bayar</span>
                                <span class="total-amount">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <!-- Payment Instructions -->
                        <div class="payment-instructions">
                            <h4><i class="fas fa-info-circle"></i> Cara Pembayaran:</h4>
                            <ol>
                                <li>Klik tombol <strong>"Konfirmasi via WhatsApp"</strong></li>
                                <li>Anda akan diarahkan ke WhatsApp</li>
                                <li>Pesan akan terisi otomatis</li>
                                <li>Kirim pesan dan tunggu konfirmasi admin</li>
                                <li>Transfer sesuai instruksi admin</li>
                            </ol>
                        </div>
                        
                        <!-- Terms Agreement -->
                        <div class="terms-agreement">
                            <label class="checkbox-label">
                                <input type="checkbox" id="agreeTerms" required>
                                <span>Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat & Ketentuan</a></span>
                            </label>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="checkout-actions">
                            <a href="{{ route('user.account.cart.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
                            </a>
                            
                            <button type="submit" class="btn-whatsapp" id="submitBtn" {{ $addresses->count() == 0 ? 'disabled' : '' }}>
                                <i class="fab fa-whatsapp"></i> Konfirmasi via WhatsApp
                            </button>
                        </div>
                        
                        <!-- Support Info -->
                        <div class="support-info">
                            <p><i class="fas fa-headset"></i> Butuh bantuan? Hubungi: +62 813-1840-9870</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<style>
.checkout-page {
    padding: 40px 0;
    min-height: 80vh;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-title {
    font-size: 2.2rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.page-subtitle {
    color: #666;
    font-size: 1rem;
}

.checkout-container {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 30px;
}

.checkout-main {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.checkout-section {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
}

.section-header {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.section-title {
    font-size: 1.3rem;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: #4CAF50;
}

/* Address Section */
.address-grid {
    display: grid;
    gap: 15px;
}

.address-card {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 20px;
    position: relative;
    cursor: pointer;
    transition: all 0.3s;
}

.address-card:hover {
    border-color: #4CAF50;
    background: #f8fff8;
}

.address-card.primary {
    border-color: #4CAF50;
    background: #f8fff8;
}

.address-radio {
    position: absolute;
    opacity: 0;
}

.address-radio:checked + .address-label .address-card {
    border-color: #4CAF50;
    background: #f0f9f0;
}

.address-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.address-header h4 {
    margin: 0;
    color: #333;
    font-size: 1.1rem;
}

.badge-primary {
    background: #4CAF50;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.address-details {
    color: #555;
    line-height: 1.6;
}

.address-details p {
    margin: 5px 0;
}

.address-notes {
    margin-top: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid #4CAF50;
    font-size: 0.9rem;
}

.empty-address {
    text-align: center;
    padding: 40px 20px;
    color: #666;
}

.empty-address i {
    margin-bottom: 15px;
    color: #ddd;
}

.empty-address h4 {
    margin: 15px 0 10px;
    color: #444;
}

.btn-manage-address,
.btn-add-address {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-manage-address:hover,
.btn-add-address:hover {
    background: #45a049;
    color: white;
    transform: translateY(-2px);
}

/* Notes Section */
.notes-input {
    width: 100%;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    resize: vertical;
    transition: border 0.3s;
}

.notes-input:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
}

.notes-hint {
    margin-top: 5px;
    font-size: 0.85rem;
    color: #888;
    text-align: right;
}

/* Cart Items Preview */
.cart-items-preview {
    max-height: 400px;
    overflow-y: auto;
}

.cart-item-preview {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
    gap: 15px;
}

.cart-item-preview:last-child {
    border-bottom: none;
}

.cart-item-preview .item-image {
    width: 70px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.cart-item-preview .item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-item-preview .item-info {
    flex: 1;
}

.cart-item-preview .item-name {
    margin: 0 0 8px 0;
    font-size: 1rem;
    color: #333;
}

.cart-item-preview .item-meta {
    display: flex;
    gap: 15px;
    color: #666;
    font-size: 0.9rem;
}

.cart-item-preview .item-subtotal {
    font-weight: 600;
    color: #4CAF50;
    font-size: 1rem;
    min-width: 100px;
    text-align: right;
}

/* Checkout Sidebar */
.checkout-sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.summary-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
}

.summary-title {
    font-size: 1.3rem;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.summary-details {
    margin-bottom: 25px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    color: #555;
}

.free-shipping {
    color: #4CAF50;
    font-weight: 600;
}

.summary-divider {
    height: 1px;
    background: #f0f0f0;
    margin: 15px 0;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-top: 15px;
}

.total-amount {
    color: #4CAF50;
    font-size: 1.3rem;
}

/* Payment Instructions */
.payment-instructions {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.payment-instructions h4 {
    margin: 0 0 15px 0;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 8px;
}

.payment-instructions ol {
    margin: 0;
    padding-left: 20px;
    color: #555;
}

.payment-instructions li {
    margin-bottom: 8px;
    line-height: 1.5;
}

/* Terms Agreement */
.terms-agreement {
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    color: #555;
    font-size: 0.95rem;
    line-height: 1.5;
}

.checkbox-label input[type="checkbox"] {
    margin-top: 3px;
    flex-shrink: 0;
}

.checkbox-label a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: 500;
}

.checkbox-label a:hover {
    text-decoration: underline;
}

/* Action Buttons */
.checkout-actions {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.btn-back {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px;
    background: #f8f9fa;
    color: #555;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
    border: 1px solid #ddd;
}

.btn-back:hover {
    background: #e9ecef;
    color: #333;
}

.btn-whatsapp {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px;
    background: #25D366;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-whatsapp:hover:not(:disabled) {
    background: #1da851;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}

.btn-whatsapp:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Support Info */
.support-info {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #f0f0f0;
    text-align: center;
    color: #666;
    font-size: 0.9rem;
}

.support-info i {
    color: #4CAF50;
    margin-right: 5px;
}

/* Responsive */
@media (max-width: 992px) {
    .checkout-container {
        grid-template-columns: 1fr;
    }
    
    .checkout-sidebar {
        position: static;
        margin-top: 30px;
    }
}

@media (max-width: 768px) {
    .checkout-page {
        padding: 20px 0;
    }
    
    .page-title {
        font-size: 1.8rem;
    }
    
    .checkout-section {
        padding: 20px;
    }
    
    .address-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .cart-item-preview {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .cart-item-preview .item-subtotal {
        text-align: center;
        min-width: auto;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitBtn');
    const agreeTerms = document.getElementById('agreeTerms');
    const checkoutForm = document.getElementById('checkoutForm');
    
    // Cek apakah ada alamat
    const hasAddress = {{ $addresses->count() > 0 ? 'true' : 'false' }};
    
    if (!hasAddress) {
        submitBtn.disabled = true;
        submitBtn.title = 'Tambahkan alamat terlebih dahulu';
    }
    
    // Toggle submit button berdasarkan checkbox
    agreeTerms.addEventListener('change', function() {
        submitBtn.disabled = !this.checked;
    });
    
    // Form submission dengan loading
    checkoutForm.addEventListener('submit', function(e) {
        if (!agreeTerms.checked) {
            e.preventDefault();
            alert('Anda harus menyetujui syarat & ketentuan terlebih dahulu');
            return;
        }
        
        // Tampilkan loading
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        submitBtn.disabled = true;
    });
    
    // Auto-resize textarea
    const notesInput = document.getElementById('notes');
    if (notesInput) {
        notesInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
</script>
@endsection
