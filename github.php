<?php
    echo"Github";
    // Thông tin kết nối MySQL trong Laragon
$host = "localhost";        // hoặc 127.0.0.1
$db   = "collab_app";       // tên database bạn đã tạo
$user = "root";             // user mặc định của Laragon
$pass = "";                 // Laragon mặc định không có mật khẩu cho root

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

    // Thiết lập chế độ báo lỗi
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Nếu muốn test kết nối, bỏ comment dòng dưới
    // echo "Kết nối thành công!";
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>