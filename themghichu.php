<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php");
    exit;
}

$error = '';
$user = $_SESSION['user'];
$user_id = $user['id'];

if (!isset($_GET['project_id'])) {
    die("Project ID không hợp lệ.");
}

$project_id = $_GET['project_id'];

if (isset($_POST['themghichu'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (empty($title)) {
        $error = "Tiêu đề ghi chú không được để trống.";
    } else {

        $sql = "INSERT INTO notes (project_id, title, content, created_by, created_at, status)
                VALUES ('$project_id', '$title', '$content', '$user_id', NOW(), 'pending')";

        if (mysqli_query($conn, $sql)) {
            header("Location: duanchitiet.php?id=$project_id");
            exit();
        } else {
            $error = "Lỗi khi thêm ghi chú: " . mysqli_error($conn);
        }
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Thêm ghi chú</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    :root{--brand:#1877f2}
    body{background:#fafbfd;min-height:100vh}
    .site-header{background:var(--brand);color:#fff;padding:.6rem 0;box-shadow:0 4px 18px rgba(24,119,242,.12)}
    .site-brand{font-weight:700;letter-spacing:.3px}
    a{text-decoration:none}
</style>
</head>
<body>

<header class="site-header mb-4">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="site-brand">
        <a href="trangchu.php" class="text-white">PROJECT</a>
      </div>
      <nav>
        <a href="duan.php" class="text-white me-3">Dự án</a>
        <a href="dangxuat.php" class="text-white">Đăng xuất</a>
      </nav>
    </div>
</header>

<div class="container mt-4">
  <h3>Thêm ghi chú mới</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Tiêu đề ghi chú</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea name="content" class="form-control" rows="4"></textarea>
    </div>

    <button type="submit" class="btn btn-primary" name="themghichu">Thêm ghi chú</button>
    <a href="duanchitiet.php?id=<?= $project_id ?>" class="btn btn-secondary">Quay lại</a>
  </form>
</div>

</body>
</html>
