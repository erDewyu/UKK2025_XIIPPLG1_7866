
<?php
include 'koneksi.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Tambah kategori
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Kategori berhasil ditambahkan!";
        } else {
            $_SESSION['message'] = "Kategori sudah ada atau terjadi kesalahan.";
        }
    } else {
        $_SESSION['message'] = "Nama kategori tidak boleh kosong!";
    }
    header("Location: categories.php");
    exit();
}

// Hapus kategori
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Kategori berhasil dihapus!";
    }
    header("Location: categories.php");
    exit();
}

// Edit kategori
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Kategori berhasil diperbarui!";
        }
    } else {
        $_SESSION['message'] = "Nama kategori tidak boleh kosong!";
    }
    header("Location: categories.php");
    exit();
}

// Ambil semua kategori
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manajemen Kategori</title>
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h2 class="text-center">Manajemen Kategori</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <!-- Form Tambah Kategori -->
        <form method="POST" class="bg-secondary p-4 rounded">
            <h4>Tambah Kategori</h4>
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Tambah</button>
        </form>

        <hr>

        <!-- Tabel Data Kategori -->
        <h4>Daftar Kategori</h4>
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['NAME']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $row['id']; ?>">Edit</button>
                        <a href="categories.php?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-light">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Kategori</h5>
                                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <div class="form-group">
                                        <label for="name">Nama Kategori</label>
                                        <input type="text" name="name" class="form-control" value="<?= $row['NAME']; ?>" required>
                                    </div>
                                    <button type="submit" name="edit" class="btn btn-warning">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
