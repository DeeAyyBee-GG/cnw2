<?php
session_start();
require 'config.php';
// Kiểm tra đăng nhập  
if (!isset($_SESSION['user'])) {
    header('Location: dangnhap.php');
    exit();
}
// Xử lý xóa user
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    // Thực hiện câu lệnh xóa user
    $sql = "DELETE FROM users WHERE id = $user_id";
    if (mysqli_query($conn, $sql)) {
        header('Location: quanlynguoidung.php');
        exit();
    } else {
        echo "Lỗi khi xóa người dùng: " . mysqli_error($conn);
    }
} else {
    echo "ID người dùng không hợp lệ.";
}
?>