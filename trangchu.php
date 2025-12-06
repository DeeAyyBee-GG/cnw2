
<?php
  session_start();
  require 'config.php';

  // Kiểm tra xem người dùng đã đăng nhập chưa
  if (!isset($_SESSION['user'])) {
      header('Location: dangnhap.php');
      exit();
  }

  $user = $_SESSION['user'];
  $role = $user['role'];

  // Lấy danh sách dự án từ database bằng MySQLi
$sql = "SELECT projects.*, users.ho_ten 
        FROM projects 
        JOIN users ON projects.created_by = users.id 
        ORDER BY projects.created_at DESC";

$result = mysqli_query($conn, $sql);

  // Đếm số lượng người dùng
  $sql_user = "SELECT COUNT(*) as count FROM users";
  $user_count_result = mysqli_query($conn, $sql_user);
  $user_count_row = mysqli_fetch_assoc($user_count_result);
  $user_count = $user_count_row['count'];

  // Đếm số lượng dự án
  $sql_project = "SELECT COUNT(*) as count FROM projects";
  $project_count_result = mysqli_query($conn, $sql_project);
  $project_count_row = mysqli_fetch_assoc($project_count_result);
  $project_count = $project_count_row['count'];

  // Đếm số lượng ghi chú chờ duyệt
  $sql_pending_notes = "SELECT COUNT(*) as count FROM notes WHERE status = 'pending'";
  $pending_notes_result = mysqli_query($conn, $sql_pending_notes);
  $pending_notes_row = mysqli_fetch_assoc($pending_notes_result);
  $pending_notes_count = $pending_notes_row['count'];

  // Đếm số lượng ghi chú đã duyệt
  $sql_confirmed_notes = "SELECT COUNT(*) as count FROM notes WHERE status = 'confirmed'";
  $confirmed_notes_result = mysqli_query($conn, $sql_confirmed_notes);
  $confirmed_notes_row = mysqli_fetch_assoc($confirmed_notes_result);
  $confirmed_notes_count = $confirmed_notes_row['count'];
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
    .read-more{background:var(--brand);border:none;margin-left: 100px;}
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
    <?php if($role ==='admin'):?>
    <div class="container mb-5">
          <h3>Xin chào, <?php echo htmlspecialchars($user['ho_ten']); ?>! 👋</h3>
          <p> Đây là các thống kê hệ thống của bạn.</p>
        </div>
      <div class="container">
    <div class="blur-card">
      <div class="row">
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Dự Án</h5>
              <p class="card-text"><?php echo $project_count; ?></p>
              <a href="duan.php" class="btn btn-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Quản lí người dùng</h5>
              <p class="card-text"><?php echo $user_count ?></p>
              <a href="quanlynguoidung.php" class="btn btn-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Ghi chú chờ duyệt</h5>
              <p class="card-text"><?php echo $pending_notes_count; ?></p>
              <a href="ghichuchoduyet.php" class="btn btn-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Ghi chú Đã duyệt</h5>
              <p class="card-text"><?php echo $confirmed_notes_count; ?></p>
              <a href="ghichudaduyet.php" class="btn btn-primary btn-sm">Xem chi tiết</a>
            </div>
          </div>
        </div>
      </div>


    <?php endif; ?>


  <?php if ($role==='viewer'||$role==='contributor'||$role==='operator'):?>
    <main class="container mb-5">
    <h4 class="mb-3"><i class="fa-solid fa-house"></i> Trang chủ - Danh sách dự án</h4>
    <div class="row gy-4">
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-12">
          <div class="card post-card p-3">
            <div class="row g-3 ">
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
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
    </div>
  </main>
  <?php endif; ?>

  <footer class="py-4 text-center text-muted">
    <div class="container">
     Sản phẩm nhóm CNW Hiếu Hiệp
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
