<?php
// Koneksi ke database
include 'koneksi.php';

// Tambah tugas baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'pending';

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO todos (title, description, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $status);
        $stmt->execute();
        $stmt->close();
    }
}

// Edit tugas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title)) {
        $stmt = $conn->prepare("UPDATE todos SET title=?, description=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $description, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Hapus tugas
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM todos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}


// Tandai sebagai selesai
if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    $stmt = $conn->prepare("UPDATE todos SET status='completed' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Ambil semua tugas dari database
$result = $conn->query("SELECT * FROM todos ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body { background-color: #121212; color: white; font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 10px; }
        th { background-color: #222; }
        tr:nth-child(even) { background-color: #1e1e1e; }
        .form-container { width: 80%; margin: 20px auto; background: #1e1e1e; padding: 20px; border-radius: 8px; }
        input, textarea, select, button { width: 100%; padding: 10px; margin: 5px 0; }
        .btn { cursor: pointer; }
        .edit { background: orange; color: white; }
        .delete { background: red; color: white; }
        .complete { background: green; color: white; }
    </style>
</head>
<body>

<h1>To-Do List</h1>

<!-- Form Tambah Tugas -->
<div class="form-container">
    <form method="POST">
        <input type="text" name="title" placeholder="Judul Tugas" required>
        <textarea name="description" placeholder="Deskripsi Tugas (opsional)"></textarea>
        <select name="status">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select>
        <button type="submit" name="add">Tambah Tugas</button>
    </form>
</div>

<!-- Tabel Tugas -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Waktu Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <button class="edit btn" onclick="editTask(<?= $row['id'] ?>, '<?= $row['title'] ?>', '<?= $row['description'] ?>')">Edit</button>
                    <a href="?delete=<?= $row['id'] ?>" class="delete btn" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
                    <?php if ($row['status'] != 'completed'): ?>
                        <a href="?complete=<?= $row['id'] ?>" class="complete btn">Selesaikan</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Form Edit Tugas -->
<div class="form-container" id="editForm" style="display: none;">
    <h2>Edit Tugas</h2>
    <form method="POST">
        <input type="hidden" name="id" id="editId">
        <input type="text" name="title" id="editTitle" required>
        <textarea name="description" id="editDescription"></textarea>
        <button type="submit" name="edit">Simpan Perubahan</button>
        <button type="button" onclick="document.getElementById('editForm').style.display='none'">Batal</button>
    </form>
</div>

<script>
    function editTask(id, title, description) {
        document.getElementById('editForm').style.display = 'block';
        document.getElementById('editId').value = id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editDescription').value = description;
    }
</script>

</body>
</html>