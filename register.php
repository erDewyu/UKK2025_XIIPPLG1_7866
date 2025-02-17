<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
      body {
          background-color: #343a40; /* Latar belakang gelap */
          color: #f8f9fa; /* Teks berwarna terang */
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
      }
      .register-container {
          background-color: #212529; /* Warna latar belakang form */
          padding: 40px;
          border-radius: 10px;
          box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
          max-width: 400px;
          width: 100%;
      }
      .register-container h2 {
          color: #f8f9fa;
          margin-bottom: 30px;
          text-align: center;
      }
      .btn {
          background-color: #28a745; /* Hijau */
          border: none;
          color: #fff;
          font-weight: bold;
          width: 100%;
      }
      .btn:hover {
          background-color: #218838;
      }
      .form-group label {
          color: #f8f9fa;
      }
      .form-control {
          background-color: #495057;
          color: #f8f9fa;
          border: 1px solid #6c757d;
      }
      .login-link {
          text-align: center;
          margin-top: 20px;
      }
      .login-link a {
          color: #28a745;
          text-decoration: none;
      }
      .login-link a:hover {
          text-decoration: underline;
      }
      .alert {
          margin-top: 20px;
      }
  </style>
</head>
<body>

    <div class="register-container">
        <h2>Register</h2>
        <form action="" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                <div class="invalid-feedback">Please enter a username.</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
        </form>

        <!-- Link ke halaman login -->
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    </script>

</body>
</html>

<?php
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Periksa apakah username sudah ada
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username sudah digunakan!";
    } else {
        // Jika username belum ada, masukkan ke dalam database
        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();  
        } else {
            $error_message = "Terjadi kesalahan, coba lagi.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
