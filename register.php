
<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];
    $bio = $_POST['bio'];

    $target_dir = "uploads/";
    $profile_picture = "default.png"; 
    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
        $profile_picture = basename($_FILES["profile_picture"]["name"]);
    }

    $query = "INSERT INTO user (username, password, full_name, bio, profile_picture) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $password, $full_name, $bio, $profile_picture);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Registrasi gagal!";
    }
}
?>
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
          background-color: #343a40; 
          color: #f8f9fa; 
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
      }
      .register-container {
          background-color: #212529; 
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
          background-color: #28a745; 
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
        <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback">Please enter a username.</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
                <div class="invalid-feedback">Isi nama lengkap.</div>
            </div>
            <div class="form-group">
                <label for="bio">Bio Singkat</label>
                <textarea class="form-control" name="bio" id="bio"></textarea>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profil Anda</label>
                <input class="form-control" type="file" name="profile_picture" id="profile_picture">
            </div>
            <button type="submit" class="btn btn-success">Daftar</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>
    </div>

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
