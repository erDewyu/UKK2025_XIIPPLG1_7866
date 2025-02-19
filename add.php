
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $status = "pending";
    
    $stmt = $conn->prepare("INSERT INTO todos (category, description, priority, status, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $category, $description, $priority, $status);
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
    <title>Tambah Tugas</title>
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h2 class="text-center">Tambah Tugas</h2>
        <form method="POST" class="bg-secondary p-4 rounded">
        <div class="form-group">
         <label for="category">Kategori</label>
         <select name="category" class="form-control">
          <?php
          $result = $conn->query("SELECT name FROM categories");
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
          }
          ?>
         </select>
        </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Prioritas</label>
                <select name="priority" class="form-control">
                    <option value="normal" class="text-success">Normal</option>
                    <option value="urgent" class="text-danger">Urgent</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>