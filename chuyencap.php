<?php
session_start();
require 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: dangnhap.php');
    exit();
}

// Kiểm tra ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Không tìm thấy ID người dùng.");
}

$id = intval($_GET['id']);

// Lấy thông tin user
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Người dùng không tồn tại.");
}

$user = mysqli_fetch_assoc($result);

// Xử lý cập nhật
if (isset($_POST['update'])) {
    $ho_ten = mysqli_query($conn, $_POST['ho_ten']);
    $tai_khoan = mysqli_query($conn, $_POST['tai_khoan']);
    $mat_khau = mysqli_query($conn, $_POST['mat_khau']);
    $role = mysqli_query($conn, $_POST['role']);

    $update_sql = "UPDATE users SET 
                    ho_ten = '$ho_ten',
                    tai_khoan = '$tai_khoan',
                    mat_khau = '$mat_khau',
                    role = '$role'
                   WHERE id = $id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: quanlynguoidung.php");
        exit();
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($conn);
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Chỉnh sửa User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<header class="site-header mb-4">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <div class="site-brand d-flex align-items-center gap-2">
          <a href="trangchu.php" class="text-white me-3">PROJECT</a>
        </div>
      </div>
      <nav class="d-none d-md-block">
        <a href="duan.php" class="text-white me-3">Dự án</a>
        <?php echo htmlspecialchars($user['ho_ten']);?>
        <a href="dangxuat.php" class="text-white me-3">Đăng xuất</a>
      </nav>
    </div>
  </header>

<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Chỉnh sửa thông tin User</h4>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Họ và Tên</label>
                    <input type="text" name="ho_ten" class="form-control" value="<?php echo $user['ho_ten']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tài Khoản</label>
                    <input type="text" name="tai_khoan" class="form-control" value="<?php echo $user['tai_khoan']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="text" name="mat_khau" class="form-control" value="<?php echo $user['mat_khau']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Vai trò</label>
                    <select name="role" class="form-select" required>
                        <option value="admin"   <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="operator"<?php if ($user['role'] == 'operator') echo 'selected'; ?>>Operator</option>
                        <option value="viewer"  <?php if ($user['role'] == 'viewer') echo 'selected'; ?>>Viewer</option>
                        <option value="viewer"  <?php if ($user['role'] == 'viewer') echo 'selected'; ?>>Contributor</option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn btn-success">
                    Lưu thay đổi
                </button>

                <a href="quanlynguoidung.php" class="btn btn-secondary">
                    Quay lại
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
