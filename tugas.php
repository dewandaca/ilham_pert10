<?php
include 'koneksi.php';

// No database operations needed for displaying links

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Jurnal - Sistem Manajemen Stok Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                        <a class="nav-link" href="laporan.php"><i class="fas fa-chart-bar me-1"></i> Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="tugas.php"><i class="fas fa-cog me-1"></i> Tugas Jurnal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container">
            <h2 class="mb-4"><i class="fas fa-file-alt me-2"></i> Daftar Tugas Jurnal</h2>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i> Link Tugas Jurnal Sebelumnya</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 1.pdf" target="_blank" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 1 (Tugas HTML, CSS, PHP, JS Dasar)
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 2&3.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 2
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 2&3.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 3
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 4 buat form.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 4 
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 5.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 5 
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_ Tugas 6 kalkulator dan form login regis dengan pop up.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 6 
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 7.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 7 
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 8.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 8
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="ILHAM ZIKRI ROBBANI_2205684_Tugas 9.rar" class="text-decoration-none">
                                <i class="fas fa-link me-2"></i> Pertemuan ke 9 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistem Manajemen Stok Barang</h5>
                    <p>Aplikasi untuk mengelola dan memantau stok barang dengan mudah dan efisien.</p>
                </div>
                <div class="col-md-3">
                    <h5>Tautan</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Beranda</a></li>
                        <li><a href="laporan.php" class="text-white">Laporan</a></li>
                        <li><a href="pengaturan.php" class="text-white">Tugas Jurnal</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> info@stokbarang.com</li>
                        <li><i class="fas fa-phone me-2"></i> (021) 1234-5678</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: #6c757d;">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Sistem Manajemen Stok Barang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>