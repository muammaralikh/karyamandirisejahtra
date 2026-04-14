@include('admin.layouts.header')
@include('admin.layouts.menu')
<style>
    /* Custom Styles for Dashboard */
    :root {
        --primary-color: #2d6a4f;
        --secondary-color: #52b788;
        --success-color: #95d5b2;
        --warning-color: #8ac926;
        --info-color: #40916c;
        --light-color: #f8faf7;
        --dark-color: #1b4332;
    }

    .dashboard-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 20px;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .card-gradient-1 {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
    }

    .card-gradient-2 {
        background: linear-gradient(135deg, #4cc9f0 0%, #4361ee 100%);
    }

    .card-gradient-3 {
        background: linear-gradient(135deg, #7209b7 0%, #3a0ca3 100%);
    }

    .card-gradient-4 {
        background: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
    }

    .card-gradient-5 {
        background: linear-gradient(135deg, #ff9a00 0%, #ff6a00 100%);
    }

    .card-gradient-6 {
        background: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%);
    }

    .stat-card {
        padding: 25px 20px;
        color: white;
        position: relative;
    }

    .stat-card .inner {
        position: relative;
        z-index: 2;
    }

    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-card p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
        font-weight: 500;
    }

    .stat-card .icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 4rem;
        opacity: 0.2;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .dashboard-card:hover .icon {
        transform: translateY(-50%) scale(1.1);
        opacity: 0.3;
    }

    .progress-card {
        background: white;
        border-left: 4px solid var(--primary-color);
    }

    .chart-container {
        position: relative;
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 18px 40px rgba(45, 106, 79, 0.08);
        margin-bottom: 20px;
        overflow: hidden;
        min-height: 8cm;
        width: 100%;
    }

    .chart-container::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle at center, rgba(82, 183, 136, 0.28), transparent 65%);
        z-index: 0;
    }

    .chart-canvas {
        width: 100%;
        height: 8cm;
        max-width: 100%;
        max-height: 8cm;
        display: block;
        position: relative;
        z-index: 1;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(45, 106, 79, 0.12);
        position: relative;
        z-index: 1;
    }

    .chart-header h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
    }

    .chart-header span {
        color: #4f6b53;
        opacity: 0.85;
        font-size: 0.95rem;
        max-width: 320px;
        text-align: right;
    }

    .chart-notes {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1.25rem;
    }

    .chart-note-card {
        flex: 1 1 220px;
        background: #f5fbf6;
        padding: 18px 20px;
        border-radius: 18px;
        border: 1px solid rgba(45, 106, 79, 0.12);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chart-note-card strong {
        display: block;
        margin-bottom: 8px;
        color: #2d6a4f;
        font-size: 0.95rem;
    }

    .chart-note-card .note-value {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f5132;
    }

    .note-meta {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.92rem;
        color: #406a50;
    }

    .note-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(45, 106, 79, 0.12);
        color: #2d6a4f;
        font-weight: 700;
    }

    .note-badge.negative {
        background: rgba(208, 0, 0, 0.12);
        color: #d00000;
    }

    .recent-activity {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 15px 0;
        border-bottom: 1px solid #f1f3f4;
        transition: background-color 0.2s;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin: 0 -15px;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .activity-icon.product {
        background: rgba(67, 97, 238, 0.1);
        color: #4361ee;
    }

    .activity-icon.user {
        background: rgba(76, 201, 240, 0.1);
        color: #4cc9f0;
    }

    .activity-icon.order {
        background: rgba(247, 37, 133, 0.1);
        color: #f72585;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--dark-color);
    }

    .activity-time {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .view-all {
        text-align: center;
        padding-top: 15px;
    }

    .dashboard-header {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .welcome-message h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 5px;
    }

    .welcome-message p {
        color: #6c757d;
        margin-bottom: 0;
    }

    .date-info {
        text-align: right;
        color: #6c757d;
        font-weight: 500;
    }

    .quick-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .quick-action-btn {
        padding: 8px 15px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        color: var(--dark-color);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-action-btn:hover {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
        border-color: var(--primary-color);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .stat-card h3 {
            font-size: 2rem;
        }

        .stat-card .icon {
            font-size: 3rem;
        }

        .welcome-message h1 {
            font-size: 1.5rem;
        }

        .date-info {
            text-align: left;
            margin-top: 10px;
        }

        .quick-actions {
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .stat-card {
            padding: 20px 15px;
        }

        .stat-card h3 {
            font-size: 1.8rem;
        }

        .chart-container,
        .recent-activity {
            padding: 15px;
        }

        .activity-item {
            padding: 12px 0;
        }
    }

    /* Animation for numbers */
    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .count-animation {
        animation: countUp 0.8s ease-out;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<div class="content-wrapper" style="background-color: #f8fafc; min-height: 100vh;">
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="welcome-message">
                    <h1>Selamat Datang, Admin!</h1>
                    <p>Selamat datang di panel administrasi. Berikut adalah ringkasan aktivitas sistem.</p>
                    <div class="quick-actions">
                        <a href="{{ route('produk.index') }}" class="quick-action-btn">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </a>
                        <a href="{{ route('kategori.index') }}" class="quick-action-btn">
                            <i class="fas fa-tags"></i> Kelola Kategori
                        </a>
                        <a href="{{ route('daftar-user.index') }}" class="quick-action-btn">
                            <i class="fas fa-users"></i> Kelola User
                        </a>
                        <a href="{{ route('pesanan.index') }}" class="quick-action-btn">
                            <i class="fas fa-shopping-bag"></i> Kelola Pesanan
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="date-info">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <span id="current-date"></span>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Statistik Utama -->
            <div class="row">
                <!-- Total Produk -->
                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <div class="stat-card card-gradient-1">
                            <div class="inner">
                                <h3 id="totalProduk">{{ $totalProduk }}</h3>
                                <p>Total Produk</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Kategori -->
                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <div class="stat-card card-gradient-2">
                            <div class="inner">
                                <h3 id="totalKategori">{{ $totalKategori }}</h3>
                                <p>Total Kategori</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tags"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total User -->
                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <div class="stat-card card-gradient-3">
                            <div class="inner">
                                <h3 id="totalUser">{{ $totalUser }}</h3>
                                <p>Total User</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="dashboard-card">
                        <div class="stat-card card-gradient-3">
                            <div class="inner">
                                <h3 id="totalPesanan">{{ $totalPesanan }}</h3>
                                <p>Total Order</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-start">
                <div class="col-xl-3 col-lg-4 col-md-12 mb-4">
                    <div class="dashboard-card">
                        <div class="stat-card card-gradient-4">
                            <div class="inner">
                                <h3 id="totalPendapatan">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h3>
                                <p>Total Pendapatan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div>
                                <h3>Grafik Pendapatan Bulanan</h3>
                                <p style="margin:0; color:#4f6b53; opacity:0.85; font-size:0.95rem;">Tiap titik menunjukkan pendapatan untuk bulan tersebut. Arah garis menunjukkan naik/turun dibanding bulan sebelumnya.</p>
                            </div>
                            <span>Data 12 bulan terakhir</span>
                        </div>
                        <canvas id="monthlySalesChart" class="chart-canvas"></canvas>
                        <div class="chart-notes">
                            <div class="chart-note-card">
                                <div class="note-meta">
                                    <span class="note-badge {{ $currentMonthRevenue < $previousMonthRevenue ? 'negative' : '' }}">{{ $currentMonthRevenue < $previousMonthRevenue ? '↘' : '↗' }}</span>
                                    <span>Performa terbaru</span>
                                </div>
                                <strong>Pendapatan Bulan Ini</strong>
                                <div class="note-value">
                                    Rp {{ number_format($currentMonthRevenue, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="chart-note-card">
                                <div class="note-meta">
                                    <span class="note-badge">•</span>
                                    <span>Referensi sebelumnya</span>
                                </div>
                                <strong>Pendapatan Bulan Lalu</strong>
                                <div class="note-value">
                                    Rp {{ number_format($previousMonthRevenue, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Set current date
    document.getElementById('current-date').textContent = new Date().toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Count up animation for stats
    function animateValue(element, start, end, duration, prefix = '', suffix = '') {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = prefix + value.toLocaleString() + suffix;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }



    // Add hover effect to dashboard cards
    document.querySelectorAll('.dashboard-card').forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });

    // Auto refresh stats every 5 minutes
    setInterval(() => {
        // In real application, you would fetch new data from API here
        console.log('Refreshing dashboard data...');
    }, 300000);

    // Monthly sales chart
    const monthlySalesLabels = @json($chartLabels);
    const monthlySalesData = @json($chartData);
    const monthlySalesTrend = monthlySalesData.map((value, index, array) => {
        if (index === 0) return 'flat';
        return value >= array[index - 1] ? 'up' : 'down';
    });

    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    const gradient = monthlySalesCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(45, 106, 79, 0.45)');
    gradient.addColorStop(1, 'rgba(45, 106, 79, 0.05)');

    new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: monthlySalesLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: monthlySalesData,
                segment: {
                    borderColor: ctx => ctx.p1 && ctx.p0 && ctx.p1.parsed.y >= ctx.p0.parsed.y ? '#2d6a4f' : '#d00000'
                },
                borderColor: '#2d6a4f',
                backgroundColor: gradient,
                pointBackgroundColor: monthlySalesTrend.map(status => status === 'down' ? '#d00000' : '#2d6a4f'),
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#2d6a4f',
                pointRadius: 6,
                pointHoverRadius: 8,
                pointStyle: 'circle',
                fill: true,
                tension: 0.4,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#2d6a4f'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(45, 106, 79, 0.08)',
                        borderDash: [4, 4]
                    },
                    ticks: {
                        stepSize: 10000,
                        color: '#2d6a4f',
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#212529',
                    bodyColor: '#212529',
                    borderColor: '#dee2e6',
                    borderWidth: 1,
                    borderRadius: 12,
                    boxPadding: 10,
                    bodySpacing: 6,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        },
                        afterLabel: function(context) {
                            if (context.dataIndex === 0) return '';
                            const previous = context.dataset.data[context.dataIndex - 1];
                            const current = context.parsed.y;
                            const change = current - previous;
                            const prefix = change >= 0 ? 'Naik: ' : 'Turun: ';
                            return prefix + 'Rp ' + Math.abs(change).toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>