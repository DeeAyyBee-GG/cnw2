<?php
    session_start();
    include 'config.php';

    if (!isset($_SESSION['user'])) {
      header('Location: dangnhap.php');
      exit();
  }

  $user = $_SESSION['user'];
  $role = $user['role'];

  $sql = "SELECT projects.*, users.ho_ten 
        FROM projects 
        JOIN users ON projects.created_by = users.id 
        ORDER BY projects.created_at DESC";

  $result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Trang chủ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        <?php echo htmlspecialchars($user['ho_ten']);?>
        <a href="dangxuat.php" class="text-white me-3">Đăng xuất</a>
      </nav>
    </div>
  </header>

  <main class="container mb-5">
    <h4 class="mb-3">Danh sách dự án</h4>
    <div class="mb-3 ">
    <?php if ($role === "admin" || $role === "contributor" ||$role === "operator" ) :?>
        <a href="themduan.php" class="btn btn-primary">➕ Thêm Dự Án</a>
    <?php endif; ?>
</div>
    <div class="row gy-4">
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-12">
          <div class="card post-card p-3">
            <div class="row g-3 align-items-center">
              <div class="col-md-9">
                <h4 class="mb-1">
                  <a href="duanchitiet.php" class="text-decoration-none text-dark"></a><?php echo $row['title']?></a>
                </h4>
                <p class="mb-2 text-muted"><?php echo $row['description']?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="meta">
                    <i class="fa-regular fa-user"></i> Người tạo: <?php echo $row['ho_ten']?>
                    &nbsp;|&nbsp;
                    <i class="fa-regular fa-calendar"></i> Thời gian tạo : <?php echo $row['created_at']?>
                  </div>
                  <div>
                    <a href="duanchitiet.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary read-more">
                     Xem dự án
                    </a>
                    <?php if ($role === "admin") :?>
                    <a href="suaduan.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger read-more">
                     Sửa dự án
                    </a>
                    <a href="xoaduan.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger read-more" onclick="return confirm('Bạn có chắc chắn muốn xóa dự án này?');">
                     Xóa dự án
                    </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
    </div>
  </main>

  <footer class="py-4 text-center text-muted">
    <div class="container">
     Sản phẩm nhóm CNW
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>