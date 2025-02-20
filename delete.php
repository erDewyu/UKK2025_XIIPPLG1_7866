
<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM todos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();

    if ($task) {
        $insertQuery = "INSERT INTO deleted_tasks (task_id, category, description, status, priority, created_at, completed_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        if (!$stmt) {
            die("Error prepare insert: " . $conn->error);
        }
        
        $stmt->bind_param("issssss", $task['id'], $task['category'], $task['description'], $task['status'], $task['priority'], $task['created_at'], $task['completed_at']);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM todos WHERE id = ?";
            $stmt = $conn->prepare($deleteQuery);
            if (!$stmt) {
                die("Error prepare delete: " . $conn->error);
            }

            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                die("Error delete: " . $stmt->error);
            }
        } else {
            die("Error insert: " . $stmt->error);
        }
    } else {
        die("Task tidak ditemukan!");
    }
}

header("Location: index.php");
?>





