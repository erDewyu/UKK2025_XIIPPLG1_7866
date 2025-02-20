
<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo '<script>alert("LOGIN GAGAL! Silakan coba lagi"); window.location.href="login.php";</script>';
        }
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
 
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
      .login-container {
          background-color: #212529; 
          padding: 40px;
          border-radius: 10px;
          box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
          max-width: 400px;
          width: 100%;
      }
      .login-container h1 {
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
      .register-link {
          text-align: center;
          margin-top: 20px;
      }
      .register-link a {
          color: #28a745;
          text-decoration: none;
      }
      .register-link a:hover {
          text-decoration: underline;
      }
      .alert {
          margin-top: 20px;
          opacity: 0;
          animation: fadeIn 0.5s forwards; 
      }
      @keyframes fadeIn {
          to {
              opacity: 1;
          }
      }
  </style>
</head>
<body>

    <div class="login-container">
      <h1>Login</h1>
      <form action="" method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-success">Login</button>
      </form>

      
      <div class="register-link">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
      </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
