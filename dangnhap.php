<?php
session_start();
require 'config.php';
if(isset($_POST['login'])){
  $tk= $_POST['tai_khoan'];
  $mk= $_POST['password'];
  $sql = "SELECT * FROM users WHERE tai_khoan = '$tk' AND mat_khau = '$mk'  ";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $user;
            header("Location: trangchu.php");
            exit();

        } else {
            $error = "Sai tên đăng nhập hoặc mật khẩu, vui lòng thử lại.";
        }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-size: cover;
      height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .blur-card {
      backdrop-filter: blur(10px);
      background-color: rgba(255, 255, 255, 0.3);
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 0 20px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }

    .form-label {
      font-weight: bold;
    }

    .btn-primary {
      font-weight: bold;
    }

    .text-danger {
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="blur-card">
    <h3 class="text-center text-primary mb-4">Đăng Nhập</h3>
    <form method="POST">
      <div class="mb-3">
        <label for="phone" class="form-label">Email / Số điện thoại</label>
        <input type="text" class="form-control" id="phone" name="tai_khoan" placeholder="0989216986" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember">
          <label class="form-check-label" for="remember">Ghi nhớ</label>
        </div>
        <a href="" class="text-decoration-none">Quên mật khẩu?</a>
        <a href="dangki.php" class="text-decoration-none">Đăng kí tài khoản</a>
      </div>
      <button type="submit" class="btn btn-primary w-100" name="login">ĐĂNG NHẬP</button>
      <?php if (isset($error)) echo "<div class='text-danger'>$error</div>"; ?>
    </form>
  </div>
</body>
</html>