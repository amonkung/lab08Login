<?php
session_start(); // ต้องเริ่ม Session ก่อนถึงจะสั่งทำลายได้

// ล้างค่า Session ทั้งหมด
$_SESSION = array();

// ทำลาย Session ในเครื่อง Server
session_destroy();

// ส่งตัวผู้ใช้กลับไปหน้าแรก (index.php)
header("Location: index.php");
exit();
?>
<?php include 'footer.php'; ?>