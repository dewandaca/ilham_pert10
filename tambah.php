<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama_barang = $_POST['nama_barang'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Cek apakah nama barang sudah ada
    // Use prepared statements for security and efficiency
    $check_query = "SELECT * FROM barang WHERE nama_barang = ?";
    $stmt_check = mysqli_prepare($koneksi, $check_query);
    mysqli_stmt_bind_param($stmt_check, "s", $nama_barang);
    mysqli_stmt_execute($stmt_check);
    $check_result = mysqli_stmt_get_result($stmt_check);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Nama barang sudah ada
        $notification_type = "error";
        $notification_message = "Nama barang sudah ada dalam database!";
    } else {
        // Nama barang belum ada, lanjutkan insert
        // Use prepared statements for security
        $query = "INSERT INTO barang (nama_barang, nama_perusahaan, tanggal_kadaluarsa, harga, stok) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt_insert, "sssdi", $nama_barang, $nama_perusahaan, $tanggal_kadaluarsa, $harga, $stok);
        $result = mysqli_stmt_execute($stmt_insert);
        
        if ($result) {
            $notification_type = "success";
            $notification_message = "Data berhasil ditambahkan!";
            // No redirect needed if we show SweetAlert on the same page
            // We can add a redirect after SweetAlert closes if desired
        } else {
            $notification_type = "error";
            $notification_message = "Data gagal ditambahkan! " . mysqli_error($koneksi); // For debugging
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Sistem Manajemen Stok Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        }
        .card-header {
            background-color: #343a40;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0069d9;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            flex-shrink: 0;
        }
        /* No need for custom .notification styles if using SweetAlert2 */
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
                        <a class="nav-link" href="tugas.php"><i class="fas fa-cog me-1"></i> Tugas Jurnal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-plus me-2"></i> Tambah Barang Baru</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                                    <input type="date" class="form-control" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga (Rp)</label>
                                    <input type="number" class="form-control" id="harga" name="harga" min="0" step="1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" min="0" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="index.php" class="btn btn-secondary me-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistem Manajemen Stok Barang</h5>
                    <p>Solusi terbaik untuk mengelola inventaris barang perusahaan Anda dengan efisien dan profesional.</p>
                </div>
                <div class="col-md-3">
                    <h5>Tautan</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Beranda</a></li>
                        <li><a href="laporan.php" class="text-white">Laporan</a></li>
                        <li><a href="tugas.php" class="text-white">Tugas Jurnal</a></li>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        // Function to show SweetAlert notifications
        function showSweetAlert(icon, title, text, redirectUrl = null) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                showConfirmButton: true, // Keep button for user to acknowledge
            }).then((result) => {
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }
            });
        }

        // Display notification if set by PHP
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (isset($notification_type) && isset($notification_message)) {
                $redirect_url = ($notification_type === "success") ? "index.php" : null; // Redirect only on success
                echo "showSweetAlert('" . $notification_type . "', '" . $notification_message . "', '', '" . $redirect_url . "');";
                // Clear the notification variables after displaying
                unset($notification_type);
                unset($notification_message);
            }
            ?>
        });
    </script>
</body>
</html>