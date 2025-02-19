

<?php
include 'koneksi.php';
$id = $_GET['id'];
$conn->query("UPDATE todos SET status='completed', completed_at=NOW() WHERE id=$id");
header("Location: index.php");
?>
