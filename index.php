<?php
include 'koneksi.php';

// Proses Hapus Data
if (isset($_GET['hapus'])) {
    $id_barang = $_GET['hapus'];
    $query = "DELETE FROM barang WHERE id_barang = '$id_barang'";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        header("Location: index.php?status=success&message=" . urlencode("Data berhasil dihapus!"));
    } else {
        // Use urlencode for message to pass it safely in URL
        header("Location: index.php?status=error&message=" . urlencode("Data gagal dihapus! " . mysqli_error($koneksi)));
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Stok Barang</title>
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
            margin-bottom: 20px;
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
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .table {
            border-radius: 5px;
            overflow: hidden;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            flex-shrink: 0;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        /* Custom row styling */
        .low-stock {
    background-color: #fff3cd; /* Light yellow */
        }
        .expired {
            background-color: #f8d7da; /* Light red/pink */
        }
        .low-stock.expired { /* This rule applies when both classes are present */
            background-color: #ffcccc; /* A different shade of red/pink, or a warning orange, etc. */
            /* You might even want to change text color: color: #842029; */
        }
        
        .search-container {
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
                        <a class="nav-link active" href="index.php"><i class="fas fa-home me-1"></i> Beranda</a>
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
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-search me-2"></i> Cari Barang</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="keyword" placeholder="Nama barang atau perusahaan" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="filter">
                                        <option value="all" <?php echo (!isset($_GET['filter']) || $_GET['filter'] == 'all') ? 'selected' : ''; ?>>Semua</option>
                                        <option value="low_stock" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'low_stock') ? 'selected' : ''; ?>>Stok Menipis</option>
                                        <option value="expired" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'expired') ? 'selected' : ''; ?>>Kadaluarsa</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Cari</button>
                                </div>
                                <div class="col-md-2">
                                    <a href="index.php" class="btn btn-secondary w-100"><i class="fas fa-sync-alt me-1"></i> Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-boxes me-2"></i> Data Stok Barang</h5>
                            <a href="tambah.php" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i> Tambah Barang
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Pencarian dan filter
                                        $where = "1=1";
                                        if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                                            $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
                                            $where .= " AND (nama_barang LIKE '%$keyword%' OR nama_perusahaan LIKE '%$keyword%')";
                                        }
                                        
                                        $today = date('Y-m-d');
                                        if (isset($_GET['filter'])) {
                                            if ($_GET['filter'] == 'low_stock') {
                                                $where .= " AND stok < 5"; // Assuming 5 is the low stock threshold
                                            } elseif ($_GET['filter'] == 'expired') {
                                                $where .= " AND tanggal_kadaluarsa < '$today'";
                                            }
                                        }
                                        
                                        $query = "SELECT * FROM barang WHERE $where ORDER BY id_barang DESC";
                                        $result = mysqli_query($koneksi, $query);
                                        $no = 1;
                                        
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $row_classes = []; // Use an array to store multiple classes
                                                
                                                // Check for low stock (e.g., less than 10)
                                                if ($row['stok'] < 10) {
                                                    $row_classes[] = 'low-stock';
                                                }
                                                
                                                // Check for expired date
                                                // Using strtotime() to ensure proper date comparison if format differs
                                                if (strtotime($row['tanggal_kadaluarsa']) < strtotime($today)) {
                                                    $row_classes[] = 'expired';
                                                }
                                                
                                                // Join classes with a space
                                                $final_row_class = implode(' ', $row_classes); 
                                                
                                                echo "<tr class='$final_row_class'>"; // Apply all collected classes
                                                echo "<td>" . $no++ . "</td>";
                                                echo "<td>" . htmlspecialchars($row['id_barang']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['nama_perusahaan']) . "</td>";
                                                echo "<td>" . date('d-m-Y', strtotime($row['tanggal_kadaluarsa'])) . "</td>";
                                                echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                                                echo "<td>" . htmlspecialchars($row['stok']) . "</td>";
                                                echo "<td class='action-buttons'>";
                                                echo "<a href='edit.php?id=" . htmlspecialchars($row['id_barang']) . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a> ";
                                                echo "<button type='button' class='btn btn-danger btn-sm' onclick='confirmDelete(\"" . htmlspecialchars($row['id_barang']) . "\")'><i class='fas fa-trash'></i> Hapus</button>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <?php
                // Total Barang
                $query_total = "SELECT COUNT(*) as total FROM barang";
                $result_total = mysqli_query($koneksi, $query_total);
                $row_total = mysqli_fetch_assoc($result_total);
                
                // Total Nilai Stok
                $query_nilai = "SELECT SUM(harga * stok) as total_nilai FROM barang";
                $result_nilai = mysqli_query($koneksi, $query_nilai);
                $row_nilai = mysqli_fetch_assoc($result_nilai);
                
                // Barang Hampir Habis
                $query_habis = "SELECT COUNT(*) as total_habis FROM barang WHERE stok < 10"; // Assuming 10 is the low stock threshold
                $result_habis = mysqli_query($koneksi, $query_habis);
                $row_habis = mysqli_fetch_assoc($result_habis);
                
                // Barang Kadaluarsa
                $today = date('Y-m-d');
                $query_kadaluarsa = "SELECT COUNT(*) as total_kadaluarsa FROM barang WHERE tanggal_kadaluarsa < '$today'";
                $result_kadaluarsa = mysqli_query($koneksi, $query_kadaluarsa);
                $row_kadaluarsa = mysqli_fetch_assoc($result_kadaluarsa);
                ?>
                
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Barang</h6>
                                    <h3 class="mb-0"><?php echo htmlspecialchars($row_total['total']); ?></h3>
                                </div>
                                <i class="fas fa-boxes fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Nilai Stok</h6>
                                    <h3 class="mb-0">Rp <?php echo number_format($row_nilai['total_nilai'] ?? 0, 0, ',', '.'); ?></h3>
                                </div>
                                <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Stok Menipis</h6>
                                    <h3 class="mb-0"><?php echo htmlspecialchars($row_habis['total_habis']); ?></h3>
                                </div>
                                <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Barang Kadaluarsa</h6>
                                    <h3 class="mb-0"><?php echo htmlspecialchars($row_kadaluarsa['total_kadaluarsa']); ?></h3>
                                </div>
                                <i class="fas fa-calendar-times fa-3x opacity-50"></i>
                            </div>
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
        function showSweetAlert(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                showConfirmButton: false,
                timer: 3000 // Auto-close after 3 seconds
            });
        }

        // Handle delete confirmation using SweetAlert2
        function confirmDelete(id_barang) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan bisa mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?hapus=' + id_barang;
                }
            });
        }

        // Check for URL parameters for notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');
            
            if (status && message) {
                if (status === 'success') {
                    showSweetAlert('success', 'Berhasil!', decodeURIComponent(message));
                } else if (status === 'error') {
                    showSweetAlert('error', 'Gagal!', decodeURIComponent(message));
                }
                
                // Clear the URL parameters to prevent re-showing the alert on refresh
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.hash;
                window.history.replaceState({path: newUrl}, '', newUrl);
            }
        });
    </script>
</body>
</html>