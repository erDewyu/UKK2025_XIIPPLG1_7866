
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM deleted_tasks ORDER BY deleted_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>History Hapus</title>
</head>
<body class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">History Hapus</a>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Riwayat Tugas Dihapus</h1>
    
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Prioritas</th>
                <th>Waktu Dibuat</th>
                <th>Waktu Dihapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td><?= ucfirst($row['priority']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td><?= $row['deleted_at'] ?></td>
                    <td>
                        <a href="delete_permanent.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus permanen?')">Hapus Permanen</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>