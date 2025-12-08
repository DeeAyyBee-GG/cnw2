<?php
session_start();
require 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php");
    exit();
}

// Kiểm tra ID ghi chú
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Không tìm thấy ghi chú!");
}

$note_id = intval($_GET['id']);

// Lấy dữ liệu ghi chú từ DB
$sql = "SELECT * FROM notes WHERE id = $note_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Ghi chú không tồn tại!");
}

$note = mysqli_fetch_assoc($result);

// Xử lý cập nhật khi submit form
if (isset($_POST['update_note'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $update_sql = "
        UPDATE notes SET
            title = '$title',
            content = '$content',
            status = '$status',
            updated_at = CURRENT_TIMESTAMP
        WHERE id = $note_id
    ";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: duanchitiet.php?id=" . $note['project_id'] . "&updated=1");
        exit();
    } else {
        $error = "Lỗi cập nhật: " . mysqli_error($conn);
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Sửa ghi chú</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#fafbfd;}
    a{text-decoration:none;}
  </style>
</head>

<body>

<div class="container mt-4">
  <h3 class="mb-4">Sửa ghi chú</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Tiêu đề</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($note['title']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea name="content" class="form-control" rows="4"><?= htmlspecialchars($note['content']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Trạng thái</label>
      <select name="status" class="form-select" required>
        <option value="pending"     <?= $note['status']=='pending'?'selected':'' ?>>Đang chờ</option>
        <option value="confirmed"   <?= $note['status']=='confirmed'?'selected':'' ?>>Đã xác nhận</option>
        <option value="in_progress" <?= $note['status']=='in_progress'?'selected':'' ?>>Đang thực hiện</option>
        <option value="resolved"    <?= $note['status']=='resolved'?'selected':'' ?>>Hoàn thành</option>
      </select>
    </div>

    <button type="submit" name="update_note" class="btn btn-primary">Cập nhật</button>
    
    <a href="trangchu.php?id=<?= $note['project_id'] ?>" class="btn btn-secondary">
        Quay lại
    </a>
  </form>
</div>

</body>
</html>
