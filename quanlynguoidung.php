<?php
session_start();
require 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: dangnhap.php');
    exit();
}

// Lấy danh sách users trừ admin
$sql = "SELECT * FROM users ";
$result = mysqli_query($conn, $sql);

// Đếm tổng số user
$sql_user = "SELECT COUNT(*) as count FROM users";
$user_count_result = mysqli_query($conn, $sql_user);
$user_count_row = mysqli_fetch_assoc($user_count_result);
$user_count = $user_count_row['count'];

// Đếm admin
$sql_admin = "SELECT COUNT(*) as count FROM users WHERE role = 'admin'";
$user_admin = mysqli_query($conn, $sql_admin);
$user_count_admin = mysqli_fetch_assoc($user_admin);
$user = $user_count_admin['count'];
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Quản lý Users & Phân quyền</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body{background:#f4f7f6;}
    .card-metric{box-shadow:0 4px 8px rgba(0,0,0,.05);}
</style>
</head>

<body>


<div class="container mt-5">
    
    <h2 class="mb-4 text-primary">
        <i class="fas fa-users-cog"></i> Bảng điều khiển Quản lý Users
    </h2>
    <hr><div class="row mb-5">
        
        <div class="col-md-4 mb-3">
            <div class="card card-metric border-left-success py-2 bg-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-user icon text-success"></i>
                        </div>
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold mb-1">
                                Tổng số Users
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                <?php echo $user_count; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card card-metric border-left-warning py-2 bg-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-shield-alt icon text-warning"></i>
                        </div>
                        <div class="col me-2">
                            <div class="text-uppercase text-warning fw-bold mb-1">
                                Tổng số Quản trị viên (Admin)
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                <?php echo $user; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3 text-primary">Danh sách Users</h5>

            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Họ và Tên</th>
                            <th>Tài Khoản</th>
                            <th>Mật khẩu</th>
                            <th>Vai trò</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['ho_ten']; ?></td>
                                <td><?php echo $row['tai_khoan']; ?></td>
                                <td><?php echo $row['mat_khau']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td>
                                    <a href="chuyencap.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fa-solid fa-sync"></i> Thay đổi
                                    </a>
                                    <a href="xoauser.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?');">
                                        <i class="fa-solid fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6">Không có người dùng nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <a href="trangchu.php" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
