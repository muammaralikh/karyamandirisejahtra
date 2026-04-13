@extends('layouts.app')

@section('title', 'Tentang Kami - ' . config('app.name'))

@section('content')
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

    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #f8f9fa;
            --dark-color: #2c3e50;
            --text-color: #333;
            --text-light: #666;
            --border-color: #e0e0e0;
            --shadow: 0 5px 15px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }
        
        .about-hero {
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.9) 0%, rgba(52, 152, 219, 0.9) 100%);
            color: white;
            padding: 100px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,138.7C672,128,768,160,864,165.3C960,171,1056,149,1152,138.7C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-position: bottom;
            background-size: cover;
        }
        
        .about-hero-content {
            position: relative;
            z-index: 1;
        }
        
        .about-hero h1 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }
        
        .about-hero p {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .about-section {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 15px;
            color: var(--primary-color);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--secondary-color);
        }
        
        .section-title.center {
            text-align: center;
        }
        
        .section-title.center::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 50px;
            max-width: 700px;
        }
        
        .story-img {
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }
        
        .story-img:hover {
            transform: translateY(-10px);
        }
        
        .story-img img {
            width: 100%;
            height: auto;
        }
        
        .story-content {
            padding-left: 40px;
        }
        
        .highlight-box {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin: 40px 0;
            box-shadow: var(--shadow);
        }
        
        .highlight-box h3 {
            color: white;
            margin-bottom: 15px;
        }
        
        .value-card {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 100%;
        }
        
        .value-card:hover {
            transform: translateY(-10px);
        }
        
        .value-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        
        .value-icon i {
            font-size: 2rem;
            color: white;
        }
        
        .team-section {
            background-color: var(--light-color);
        }
        
        .team-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            margin-bottom: 30px;
        }
        
        .team-card:hover {
            transform: translateY(-10px);
        }
        
        .team-img {
            height: 280px;
            overflow: hidden;
        }
        
        .team-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .team-card:hover .team-img img {
            transform: scale(1.05);
        }
        
        .team-info {
            padding: 25px;
        }
        
        .team-name {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }
        
        .team-role {
            color: var(--secondary-color);
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .team-social {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .team-social a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            transition: var(--transition);
        }
        
        .team-social a:hover {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .stats-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a252f 100%);
            color: white;
        }
        
        .stats-section .section-title {
            color: white;
        }
        
        .stats-section .section-title::after {
            background-color: var(--secondary-color);
        }
        
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        .cta-section {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        
        .cta-section .section-title {
            color: white;
        }
        
        .cta-section .section-title::after {
            background-color: var(--secondary-color);
            left: 50%;
            transform: translateX(-50%);
        }
        
        .btn-cta {
            background-color: var(--secondary-color);
            color: white;
            padding: 12px 40px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: var(--transition);
            border: 2px solid var(--secondary-color);
            margin-top: 20px;
        }
        
        .btn-cta:hover {
            background-color: transparent;
            color: var(--secondary-color);
        }
        
        @media (max-width: 991px) {
            .about-hero h1 {
                font-size: 2.5rem;
            }
            
            .story-content {
                padding-left: 0;
                margin-top: 40px;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .about-hero {
                padding: 80px 0 60px;
            }
            
            .about-hero h1 {
                font-size: 2rem;
            }
            
            .about-section {
                padding: 60px 0;
            }
            
            .value-card {
                margin-bottom: 30px;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .about-hero h1 {
                font-size: 1.8rem;
            }
            
            .section-title {
                font-size: 1.7rem;
            }
            
            .highlight-box {
                padding: 30px 20px;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .delay-1 {
            animation-delay: 0.2s;
        }
        
        .delay-2 {
            animation-delay: 0.4s;
        }
        
        .delay-3 {
            animation-delay: 0.6s;
        }
    </style>

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="about-hero-content animate-fade-in">
                <h1>Tentang Kami</h1>
                <p>
                    Kami adalah perusahaan yang berdedikasi untuk memberikan pengalaman berbelanja terbaik 
                    dengan produk berkualitas tinggi dan layanan pelanggan yang luar biasa.
                </p>
            </div>
        </div>
    </section>

    

    <!-- Mission & Vision -->
    <section class="about-section" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0 animate-fade-in">
                    <div class="highlight-box">
                        <div class="d-flex align-items-center mb-4">
                            <div class="value-icon me-3">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3 class="mb-0">Misi Kami</h3>
                        </div>
                        <p>
                            Menyediakan produk berkualitas tinggi dengan harga terjangkau, 
                            memberikan pengalaman belanja yang mudah dan menyenangkan, 
                            serta membangun hubungan jangka panjang dengan pelanggan melalui 
                            layanan yang luar biasa dan inovasi berkelanjutan.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 animate-fade-in delay-1">
                    <div class="highlight-box">
                        <div class="d-flex align-items-center mb-4">
                            <div class="value-icon me-3">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3 class="mb-0">Visi Kami</h3>
                        </div>
                        <p>
                            Menjadi platform e-commerce terdepan di Indonesia yang dikenal 
                            karena kualitas produk, keandalan layanan, dan komitmen terhadap 
                            kepuasan pelanggan. Kami bertekad untuk terus berinovasi dan 
                            memberikan nilai terbaik bagi semua stakeholder.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="about-section">
        <div class="container">
            <h2 class="section-title center">Nilai-Nilai Kami</h2>
            <p class="section-subtitle center mx-auto">
                Prinsip-prinsip yang menjadi pedoman dalam setiap keputusan dan tindakan kami
            </p>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card animate-fade-in">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Integritas</h4>
                        <p>
                            Kami berkomitmen untuk selalu jujur dan transparan dalam setiap aspek bisnis, 
                            menjaga kepercayaan yang diberikan oleh pelanggan dan mitra.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card animate-fade-in delay-1">
                        <div class="value-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Kualitas</h4>
                        <p>
                            Tidak ada kompromi untuk kualitas. Setiap produk yang kami tawarkan melalui 
                            proses seleksi ketat untuk memastikan kepuasan pelanggan.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card animate-fade-in delay-2">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Kepuasan Pelanggan</h4>
                        <p>
                            Pelanggan adalah prioritas utama. Kami selalu berusaha melebihi ekspektasi 
                            melalui layanan yang responsif dan solusi yang tepat.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card animate-fade-in">
                        <div class="value-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Inovasi</h4>
                        <p>
                            Terus berinovasi dalam produk, layanan, dan teknologi untuk memberikan 
                            pengalaman belanja yang lebih baik dan efisien.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card animate-fade-in delay-1">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Kolaborasi</h4>
                        <p>
                            Kami percaya kekuatan kerjasama, baik dengan tim internal, mitra, 
                            maupun pelanggan untuk mencapai hasil yang optimal.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card animate-fade-in delay-2">
                        <div class="value-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4>Keberlanjutan</h4>
                        <p>
                            Berkomitmen untuk praktik bisnis yang ramah lingkungan dan 
                            memberikan dampak positif bagi komunitas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="about-section cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title center">Siap Bergabung dengan Kami?</h2>
                    <p class="lead mb-4">
                        Jadilah bagian dari komunitas pelanggan yang puas. 
                        Temukan produk terbaik dengan layanan yang luar biasa.
                    </p>
                    <a href="{{ route('produk.showall') }}" class="btn-cta">
                        <i class="fas fa-shopping-cart me-2"></i> Mulai Belanja
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu toggle (sesuaikan dengan layout.app Anda)
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function () {
                    mobileMenu.classList.toggle('active');
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-bars');
                        icon.classList.toggle('fa-times');
                    }
                });
            }

            // Smooth scroll untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if(targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if(targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Scroll animation untuk cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                    }
                });
            }, observerOptions);
            
            // Observe elements untuk animation
            document.querySelectorAll('.value-card, .team-card, .stat-item').forEach(el => {
                observer.observe(el);
            });

            // Auto-hide success message
            const successMessage = document.querySelector('.alert-success');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = 'opacity 0.5s';
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endpush