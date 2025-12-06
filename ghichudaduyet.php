<?php
session_start();
require 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: dangnhap.php');
    exit();
}

// Lấy toàn bộ ghi chú từ bảng notes
$sql = "SELECT notes.*, users.ho_ten 
        FROM notes 
        JOIN users ON notes.created_by = users.id 
        WHERE notes.status = 'confirmed'
        ORDER BY notes.created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Chi tiết dự án</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    :root{--brand:#1877f2}
    body{background:#fafbfd;min-height:100vh}
    .site-header{background:var(--brand);color:#fff;padding:.6rem 0;box-shadow:0 4px 18px rgba(24,119,242,.12)}
    .site-brand{font-weight:700;letter-spacing:.3px}
    .search-box .form-control{border-radius:30px 0 0 30px;padding:14px}
    .search-box .btn{border-radius:0 30px 30px 0}
    .post-card{border-radius:8px;box-shadow:0 6px 20px rgba(44,62,80,.06)}
    .post-thumb{height:160px;object-fit:cover;border-radius:6px}
    .meta{font-size:.9rem;color:#6c757d}
    .read-more{background:var(--brand);border:none}
    footer{background:#f8f9fa;border-top:1px solid #e9ecef;margin-top:80px}
    a{
        text-decoration: none;
    }
  </style>
</head>
<body>
    <header class="site-header mb-4">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-3">
        <div class="site-brand d-flex align-items-center gap-2">
          <a href="trangchu.php" class="text-white me-3">PROJECT</a>
        </div>
      </div>
      <nav class="d-none d-md-block">
        <a href="duan.php" class="text-white me-3">Dự án</a>
        <a href="thongtincanhan.php" class="text-white me-3">Thông tin cá nhân</a>
        <a href="dangxuat.php" class="text-white me-3">Đăng xuất</a>
      </nav>
    </div>
  </header>
<div class="container mt-4">
  <h3>Danh sách ghi chú chờ duyệt</h3>
  <?php if (mysqli_num_rows($result) > 0): ?>
    <ul class="list-group">
      <?php while ($note = mysqli_fetch_assoc($result)): ?>
        <?php if($note['status']==='confirmed'): ?>
        <li class="list-group-item">
          <h5><?= htmlspecialchars($note['title']) ?></h5>
          <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
          <small>
            <i class="fa-regular fa-user"></i> <?= htmlspecialchars($note['ho_ten']) ?> |
            <i class="fa-regular fa-calendar"></i> <?= date("d/m/Y H:i", strtotime($note['created_at'])) ?> |
            Trạng thái: <?= htmlspecialchars($note['status']) ?>
          </small>
          <div>
            <a href="xoaghichu.php?id=<?php echo $note['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa ghi chú này?')">Xóa</a>
          </div>
        </li>
        <?php endif; ?>
      <?php endwhile; ?>
    </ul>
  <?php else: echo"Không có ghi chú nào"; ?>
  <br>
    <?php endif; ?>
  <a href="trangchu.php" class="btn btn-secondary mt-3">Quay lại</a>
</div>
</body>
</html>