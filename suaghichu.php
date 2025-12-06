<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Thêm dự án</title>
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
        <a href="dangxuat.php" class="text-white me-3">Đăng xuất</a>
      </nav>
    </div>
  </header>
<div class="container mt-4">
  <h3>Sửa ghi chú</h3>

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
    <button type="submit" class="btn btn-primary" name="themghichu">Sửa ghi chú</button>
    <a href="duanchitiet.php?id=<?php echo $project_id ?>" class="btn btn-secondary">Quay lại</a>
  </form>
</div>
</body>
</html>