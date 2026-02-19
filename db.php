<?php
session_start();
$host = "localhost";   
$user = "it67040233126";        
$pass = "X9M1F2F7";            
$dbname = "it67040233126";     

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("เชื่อมต่อไม่สำเร็จ: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

// ฟังก์ชันสำหรับเช็คการ Login
function check_login() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>