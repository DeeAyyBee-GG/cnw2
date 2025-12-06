<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php");
    exit;
}
$user = $_SESSION['user'];
$note_id = $_GET['id'] ?? 0;
if (!$note_id) {
    die("ID ghi chú không hợp lệ.");
}
// Lấy thông tin ghi chú
$sql = "SELECT * FROM notes WHERE id = $note_id";
$result = mysqli_query($conn, $sql);
$note = mysqli_fetch_assoc($result);
if (!$note) {
    die("Không tìm thấy ghi chú.");
}

$sql = "DELETE FROM notes WHERE id = $note_id";
if (mysqli_query($conn, $sql)) {
    header("Location: ghichuchoduyet.php");
    exit();
} else {
    echo "Lỗi khi xóa ghi chú: " . mysqli_error($conn);
}

?>