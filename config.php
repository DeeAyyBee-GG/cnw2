
<?php
        
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "K73_HH";
        $conn = mysqli_connect($host, $user, $pass, $db);
        if (!$conn) {
            die("Kết nối thất bại: " . mysqli_connect_error());
        }

    ?> 