<?php
include 'koneksi.php';

// Query untuk mendapatkan data ringkasan
$query_total_items = "SELECT COUNT(*) as total FROM barang";
$query_total_value = "SELECT SUM(harga * stok) as total_value FROM barang";
$query_low_stock = "SELECT COUNT(*) as total FROM barang WHERE stok <= 10";
$query_expired = "SELECT COUNT(*) as total FROM barang WHERE tanggal_kadaluarsa < CURDATE()";
$query_by_company = "SELECT nama_perusahaan, COUNT(*) as total_items, SUM(stok) as total_stock, SUM(harga * stok) as total_value FROM barang GROUP BY nama_perusahaan ORDER BY total_value DESC";

// Eksekusi query
$result_total_items = mysqli_query($koneksi, $query_total_items);
$result_total_value = mysqli_query($koneksi, $query_total_value);
$result_low_stock = mysqli_query($koneksi, $query_low_stock);
$result_expired = mysqli_query($koneksi, $query_expired);
$result_by_company = mysqli_query($koneksi, $query_by_company);

// Ambil data
$total_items = mysqli_fetch_assoc($result_total_items)['total'];
$total_value = mysqli_fetch_assoc($result_total_value)['total_value'];
$low_stock_count = mysqli_fetch_assoc($result_low_stock)['total'];
$expired_count = mysqli_fetch_assoc($result_expired)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Sistem Manajemen Stok Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-wrapper {
            flex: 1 0 auto;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            flex-shrink: 0;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-boxes me-2"></i> Sistem Manajemen Stok Barang
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="laporan.php"><i class="fas fa-chart-bar me-1"></i> Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tugas.php"><i class="fas fa-cog me-1"></i> Tugas Jurnal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container">
            <h2 class="mb-4"><i class="fas fa-chart-bar me-2"></i> Laporan Stok Barang</h2>
            
            <!-- Ringkasan Kartu -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-box me-2"></i> Total Barang</h5>
                            <h2><?php echo $total_items; ?> item</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-money-bill-wave me-2"></i> Total Nilai</h5>
                            <h3 class="mb-0">Rp <?php echo number_format($row_nilai['total_nilai'] ?? 0, 0, ',', '.'); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-dark bg-warning">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-exclamation-triangle me-2"></i> Stok Rendah</h5>
                            <h2><?php echo $low_stock_count; ?> item</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-calendar-times me-2"></i> Kadaluarsa</h5>
                            <h2><?php echo $expired_count; ?> item</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Grafik -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Distribusi Stok per Perusahaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="companyStockChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Nilai Stok per Perusahaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="companyValueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tabel Ringkasan per Perusahaan -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-building me-2"></i> Ringkasan per Perusahaan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>Jumlah Item</th>
                                    <th>Total Stok</th>
                                    <th>Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result_by_company)) { ?>
                                <tr>
                                    <td><?php echo $row['nama_perusahaan']; ?></td>
                                    <td><?php echo $row['total_items']; ?></td>
                                    <td><?php echo $row['total_stock']; ?></td>
                                    <td>Rp <?php echo number_format($row['total_value'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistem Manajemen Stok Barang</h5>
                    <p>Aplikasi untuk mengelola dan memantau stok barang dengan mudah dan efisien.</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Beranda</a></li>
                        <li><a href="laporan.php" class="text-white">Laporan</a></li>
                        <li><a href="tugas.php" class="text-white">Tugas Jurnal</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> info@stockmanager.com</li>
                        <li><i class="fas fa-phone me-2"></i> (021) 123-4567</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">© 2023 Sistem Manajemen Stok Barang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script>
        // Data dari PHP
        <?php 
        mysqli_data_seek($result_by_company, 0);
        $companies = [];
        $stockData = [];
        $valueData = [];
        $backgroundColors = [
            '#007bff', '#28a745', '#ffc107', '#dc3545', '#6610f2', '#fd7e14', '#20c997', '#17a2b8',
            '#6c757d', '#343a40', '#f8f9fa', '#e83e8c', '#6f42c1', '#d63384', '#198754', '#0dcaf0'
        ];
        
        $i = 0;
        while ($row = mysqli_fetch_assoc($result_by_company)) {
            $companies[] = $row['nama_perusahaan'];
            $stockData[] = $row['total_stock'];
            $valueData[] = $row['total_value'];
            $i++;
        }
        ?>
        
        // Grafik Distribusi Stok
        const companyStockCtx = document.getElementById('companyStockChart').getContext('2d');
        const companyStockChart = new Chart(companyStockCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($companies); ?>,
                datasets: [{
                    data: <?php echo json_encode($stockData); ?>,
                    backgroundColor: <?php echo json_encode(array_slice($backgroundColors, 0, count($companies))); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
        
        // Grafik Nilai Stok
        const companyValueCtx = document.getElementById('companyValueChart').getContext('2d');
        const companyValueChart = new Chart(companyValueCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($companies); ?>,
                datasets: [{
                    label: 'Nilai Stok (Rp)',
                    data: <?php echo json_encode($valueData); ?>,
                    backgroundColor: <?php echo json_encode(array_slice($backgroundColors, 0, count($companies))); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>