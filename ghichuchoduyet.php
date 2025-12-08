<?php
session_start();
require 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: dangnhap.php');
    exit();
}

// Lấy các ghi chú pending
$sql = "SELECT notes.*, users.ho_ten 
        FROM notes 
        JOIN users ON notes.created_by = users.id 
        WHERE notes.status = 'pending'
        ORDER BY notes.created_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Ghi chú chờ duyệt</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root{--brand:#1877f2}
    body{background:#fafbfd;min-height:100vh}
    a{text-decoration:none}
</style>
</head>

<body>

<div class="container mt-4">
  <h3>Danh sách ghi chú chờ duyệt</h3>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <ul class="list-group">

      <?php while ($note = mysqli_fetch_assoc($result)): ?>
        <?php $id = (int)$note['id']; ?>

        <li class="list-group-item">

          <!-- Escape đầy đủ -->
          <h5><?= htmlspecialchars($note['title'], ENT_QUOTES, 'UTF-8') ?></h5>

          <p><?= nl2br(htmlspecialchars($note['content'], ENT_QUOTES, 'UTF-8')) ?></p>

          <small>
            <i class="fa-regular fa-user"></i>
            <?= htmlspecialchars($note['ho_ten'], ENT_QUOTES, 'UTF-8') ?> |

            <i class="fa-regular fa-calendar"></i>
            <?= date("d/m/Y H:i", strtotime($note['created_at'])) ?> |

            Trạng thái:
            <span class="badge bg-warning">
              <?= htmlspecialchars($note['status'], ENT_QUOTES, 'UTF-8') ?>
            </span>
          </small>

          <div class="mt-2">

            <!-- Escape ID an toàn -->
            <a href="duyetghichu.php?id=<?php echo $id; ?>" 
               class="btn btn-success btn-sm"
               onclick="return confirm('Duyệt ghi chú này?')">
               Duyệt
            </a>  
            <a href="suaghichu.php?id=<?php echo $note['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
            <a href="xoaghichu.php?id=<?php echo $id; ?>" 
               class="btn btn-danger btn-sm"
               onclick="return confirm('Xóa ghi chú này?')">
               Xóa
            </a>

          </div>

        </li>

      <?php endwhile; ?>

    </ul>

  <?php else: ?>
    <div class="alert alert-info">Không có ghi chú nào chờ duyệt</div>
  <?php endif; ?>

  <a href="trangchu.php" class="btn btn-secondary mt-3">Quay lại</a>

</div>

</body>
</html>
