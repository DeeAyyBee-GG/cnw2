<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user'])) {
    header('Location: dangnhap.php');
    exit();
} 
$user = $_SESSION['user'];
$id = $_GET['id'];
$sql = "DELETE FROM duan WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header('Location: duan.php');
    exit();
} else {
    echo "Lỗi khi xóa dự án: " . mysqli_error($conn);
}
?>