
<?php
        
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "k73_4";
        $conn = mysqli_connect($host, $user, $pass, $db);
        if (!$conn) {
            die("Kết nối thất bại: " . mysqli_connect_error());
        }
//        mysqli_set_charset($conn, "utf8");
//        $conn->set_charset("utf8");
//        mysqli_query($conn, "SET N

    ?> 