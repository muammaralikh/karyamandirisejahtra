@extends('layouts.app')

@section('title', 'Instruksi Pembayaran - Toko Lele Premium')

@section('content')
<div class="instructions-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Instruksi Pembayaran</h1>
            <p class="page-subtitle">Ikuti langkah-langkah berikut untuk menyelesaikan pembayaran</p>
        </div>
        
        <div class="instructions-container">
            <div class="instruction-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Konfirmasi via WhatsApp</h3>
                        <p>Klik tombol "Konfirmasi via WhatsApp" di halaman checkout</p>
                        <p>Pesan akan terisi otomatis dengan detail pesanan Anda</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Kirim Pesan ke Admin</h3>
                        <p>Kirim pesan yang sudah terisi ke nomor WhatsApp admin</p>
                        <p>Tunggu konfirmasi dari admin mengenai ketersediaan stok</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Transfer Pembayaran</h3>
                        <p>Transfer ke rekening yang diberikan admin</p>
                        <div class="bank-info">
                            <div class="bank-card">
                                <i class="fas fa-university"></i>
                                <h4>BCA</h4>
                                <p>1234567890</p>
                                <p>A/N: Toko Lele Premium</p>
                            </div>
                            <div class="bank-card">
                                <i class="fas fa-university"></i>
                                <h4>Mandiri</h4>
                                <p>0987654321</p>
                                <p>A/N: Toko Lele Premium</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Kirim Bukti Transfer</h3>
                        <p>Screenshot bukti transfer dan kirim ke WhatsApp admin</p>
                        <p>Pesanan akan diproses dalam 1x24 jam setelah pembayaran</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Tunggu Pengiriman</h3>
                        <p>Admin akan mengirimkan resi pengiriman via WhatsApp</p>
                        <p>Lacak pengiriman Anda menggunakan nomor resi</p>
                    </div>
                </div>
            </div>
            
            <div class="support-section">
                <div class="support-card">
                    <h3><i class="fas fa-headset"></i> Butuh Bantuan?</h3>
                    <p>Hubungi customer service kami:</p>
                    <div class="contact-info">
                        <p><i class="fab fa-whatsapp"></i> WhatsApp: 0812-3456-7890</p>
                        <p><i class="fas fa-phone"></i> Telepon: (021) 1234-5678</p>
                        <p><i class="fas fa-clock"></i> Jam Operasional: 08:00 - 22:00 WIB</p>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('checkout.index') }}" class="btn-checkout">
                            <i class="fas fa-shopping-cart"></i> Kembali ke Checkout
                        </a>
                        <a href="{{ route('cart.index') }}" class="btn-cart">
                            <i class="fas fa-arrow-left"></i> Lihat Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.instructions-page {
    padding: 40px 0;
    min-height: 80vh;
}

.page-header {
    text-align: center;
    margin-bottom: 50px;
}

.page-title {
    font-size: 2.2rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.page-subtitle {
    color: #666;
    font-size: 1rem;
    max-width: 600px;
    margin: 0 auto;
}

.instructions-container {
    max-width: 800px;
    margin: 0 auto;
}

.instruction-steps {
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-bottom: 50px;
}

.step {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.step-number {
    width: 40px;
    height: 40px;
    background: #4CAF50;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 700;
    flex-shrink: 0;
}

.step-content {
    flex: 1;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
}

.step-content h3 {
    margin: 0 0 15px 0;
    color: #2c3e50;
    font-size: 1.3rem;
}

.step-content p {
    color: #555;
    margin-bottom: 10px;
    line-height: 1.6;
}

.bank-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.bank-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #e0e0e0;
}

.bank-card i {
    font-size: 2rem;
    color: #4CAF50;
    margin-bottom: 10px;
}

.bank-card h4 {
    margin: 10px 0 5px;
    color: #2c3e50;
}

.bank-card p {
    margin: 5px 0;
    color: #666;
    font-size: 0.9rem;
}

.support-section {
    margin-top: 50px;
}

.support-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
}

.support-card h3 {
    margin: 0 0 20px 0;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.support-card p {
    margin-bottom: 15px;
    opacity: 0.9;
}

.contact-info {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 10px;
    margin: 25px 0;
}

.contact-info p {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin: 10px 0;
    font-size: 1.1rem;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-checkout,
.btn-cart {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-checkout {
    background: white;
    color: #764ba2;
}

.btn-checkout:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-cart {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-cart:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .instructions-page {
        padding: 20px 0;
    }
    
    .page-title {
        font-size: 1.8rem;
    }
    
    .step {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .step-content {
        padding: 20px;
    }
    
    .bank-info {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-checkout,
    .btn-cart {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection