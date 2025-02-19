
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM todos WHERE id=$id");
$tugas = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    
    $stmt = $conn->prepare("UPDATE todos SET category=?, description=?, priority=? WHERE id=?");
    $stmt->bind_param("sssi", $category, $description, $priority, $id);
    $stmt->execute();
    
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Tugas</title>
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h2 class="text-center">Edit Tugas</h2>
        <form method="POST" class="bg-secondary p-4 rounded">
        <div class="form-group">
          <label for="category">Kategori</label>
              <select name="category" class="form-control">
          <?php
            $result = $conn->query("SELECT name FROM categories");
              while ($row = $result->fetch_assoc()) {
            $selected = ($tugas['category'] == $row['name']) ? 'selected' : '';
            echo "<option value='" . $row['name'] . "' $selected>" . $row['name'] . "</option>";
              }
          ?>
             </select>
        </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" required><?= $tugas['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Prioritas</label>
                <select name="priority" class="form-control">
                    <option value="normal" <?= ($tugas['priority'] == 'normal') ? 'selected' : ''; ?>>Normal</option>
                    <option value="urgent" <?= ($tugas['priority'] == 'urgent') ? 'selected' : ''; ?>>Urgent</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>