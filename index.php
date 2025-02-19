
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM todos WHERE category LIKE '%$search%' OR description LIKE '%$search%' ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>To-Do List</title>
</head>
<body class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">To-Do List</a>
        <form class="form-inline my-2 my-lg-0" method="GET">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari Tugas" value="<?= $search ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
        </form>
        <a class="btn btn-danger ml-3" href="logout.php" onclick="return confirm('yakin ingin logout?')">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">To-Do List</h1>
    <a href="add.php" class="btn btn-primary mb-3">Tambah Tugas</a>
    <a href="categories.php" class="btn btn-primary mb-3">category</a>
    
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Prioritas</th>
                <th>Waktu Dibuat</th>
                <th>Waktu Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status'] == 'completed' ? 'success' : 'warning' ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-<?= $row['priority'] == 'urgent' ? 'danger' : 'success' ?>">
                            <?= ucfirst($row['priority']) ?>
                        </span>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                    <td><?= $row['completed_at'] ? $row['completed_at'] : '-' ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
                        <?php if ($row['status'] != 'completed'): ?>
                            <a href="complete.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Selesaikan</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>