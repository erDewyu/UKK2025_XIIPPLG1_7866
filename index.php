<?php
session_start(); 

// Logika untuk memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Jika belum login, arahkan ke halaman login
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Kasir</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
      body {
          background-color: #343a40; /* Latar belakang gelap */
          color: #f8f9fa; /* Teks berwarna terang */
      }
      .navbar {
          margin-bottom: 30px;
      }
      .card {
          background-color: #212529; /* Warna latar belakang kartu */
          border: none;
          box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
      }
      .card-body {
          color: #f8f9fa;
      }
      .btn-primary {
          background-color: #28a745; /* Warna hijau */
          border: none;
      }
      .btn-primary:hover {
          background-color: #218838;
      }
      .navbar-brand, .navbar-text {
          color: #f8f9fa;
      }
  </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="navbar-text">Selamat datang, <?= $_SESSION['username']; ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white ml-3" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container">
        <div class="row">
            <!-- Transaksi Penjualan -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Transaksi Penjualan</h5>
                        <p class="card-text">Buat transaksi penjualan baru</p>
                        <a href="test1.php" class="btn btn-primary">Buka Transaksi</a>
                    </div>
                </div>
            </div>

            <!-- Manajemen Produk -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Manajemen Produk</h5>
                        <p class="card-text">Kelola produk yang dijual</p>
                        <a href="edit_produk.php" class="btn btn-primary">Kelola Produk</a>
                    </div>
                </div>
            </div>

            <!-- Laporan -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Laporan</h5>
                        <p class="card-text">Lihat laporan transaksi penjualan</p>
                        <a href="laporan.php" class="btn btn-primary">Lihat Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
