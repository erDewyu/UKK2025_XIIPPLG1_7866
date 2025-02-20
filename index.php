<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

$username = $_SESSION['username'];
$queryUser = "SELECT * FROM user WHERE username = '$username'";
$resultUser = $conn->query($queryUser);
$user = $resultUser->fetch_assoc();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM todos WHERE category LIKE '%$search%' OR status LIKE '%$search%' OR priority LIKE '%$search%' ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>To-Do List</title>
    <style>
        #sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background: #343a40;
            color: white;
            transition: 0.3s;
            padding: 20px;
        }
        #sidebar.active {
            right: 0;
        }
        #sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
        }

        
    </style>
</head>
<body class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">To-Do List</a>
        <span class="navbar-text">Selamat datang, <?= $_SESSION['username']; ?>!</span>
        <button class="btn btn-info ml-auto" id="toggleSidebar">Profil</button>
        <a class="btn btn-danger ml-3" href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </div>
</nav>
<div class="container mt-5">
    <h1 class="text-center">To-Do List</h1>

    <form method="GET" class="mb-3 text-center">
    <div class="input-group w-50 mx-auto">
        <input type="text" name="search" class="form-control form-control-sm" 
               placeholder="Cari kategori atau deskripsi..." value="<?= htmlspecialchars($search) ?>">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
        </div>
    </div>
</form>


<div id="sidebar">
    <button class="btn btn-danger btn-sm" onclick="toggleSidebar()">Tutup</button>
    <img src="uploads/default.png" alt="Profil">
    <!-- <img src="<?= $user['profile_picture'] ?>" alt="Profil"> -->
    <h3 class="text-center mt-2"><?= $user['full_name'] ?></h3>
    <p class="text-center"> <?= $user['bio'] ?></p>

    <a href="categories.php" class="btn btn-primary mb-3">Category</a>
    <a href="history.php" class="btn btn-danger mb-3">history</a>
</div>

<div class="container mt-5">
<a href="add.php" class="btn btn-success mb-3">Tambah Tugas</a>
   
    
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

                        <?php if ($row['status'] == 'completed'): ?>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
                        <?php endif; ?>
                        
                        <?php if ($row['status'] != 'completed'): ?>
                            <a href="complete.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Selesaikan</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
    document.getElementById('toggleSidebar').addEventListener('click', toggleSidebar);
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

