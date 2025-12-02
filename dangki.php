<?php
  include 'config.php';
  $error = "";
  if (isset($_POST['register'])){
    $ho_ten = $_POST['name'];
    $tai_khoan = $_POST['tai_khoan'];
    $mat_khau = $_POST['password'];
    $cfmk = $_POST['confirm'];
    if($mat_khau!=$cfmk){
      $error = "Mật khẩu xác nhận không khớp.";
    }else{
      $sql="INSERT INTO users (ho_ten, tai_khoan, mat_khau) VALUES ('$ho_ten', '$tai_khoan', '$mat_khau')";
      if (mysqli_query($conn, $sql)) {
        $error="dang ki thanh cong";
      } else {
        $error = "Lỗi đăng ký tài khoản: " . mysqli_error($conn);
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký</title>
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

    .btn-success {
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
    <h3 class="text-center text-primary mb-4">Đăng ký tài khoản</h3>
    <form method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Họ và tên</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Nguyễn Văn A" required>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Email / Số điện thoại</label>
        <input type="text" class="form-control" id="phone" name="tai_khoan" placeholder="0989216986" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="mb-3">
        <label for="confirm" class="form-label">Xác nhận mật khẩu</label>
        <input type="password" class="form-control" id="confirm" name="confirm" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn btn-primary w-100" name="register">ĐĂNG KÝ</button>
      <?php if (isset($error)) echo "<div class='text-danger'>$error</div>"; ?>
    </form>
    <div class="text-center mt-3">
      <a href="dangnhap.php" class="text-decoration-none">Đã có tài khoản? Đăng nhập</a>
    </div>
  </div>
</body>
</html>