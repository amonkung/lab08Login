<?php include 'db.php'; check_login(); 
$admin_id = $_SESSION['admin_id'];
$admin = $conn->query("SELECT * FROM Admins WHERE id=$admin_id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>แก้ไขโปรไฟล์ Admin</title>
    <style>
        body{font-family:sans-serif;background:#f7e9f1;padding:40px}
        form{background:#fff;padding:30px;border-radius:15px;max-width:400px;margin:auto;box-shadow:0 4px 10px rgba(0,0,0,0.1)}
        input{width:100%;padding:10px;margin-bottom:15px;border:1px solid #ddd;border-radius:8px;box-sizing:border-box}
        button{background:#ff4d6d;color:white;padding:12px;border:none;border-radius:8px;width:100%;cursor:pointer;font-weight:bold}
        .back{display:block;text-align:center;margin-top:15px;text-decoration:none;color:#666}
    </style>
</head>
<body>
<form method="post">
    <h2 style="color:#ff4d6d;text-align:center">แก้ไขโปรไฟล์</h2>
    <label>ชื่อที่แสดง:</label>
    <input name="display_name" value="<?=$admin['display_name']?>" required>
    <label>Username:</label>
    <input name="username" value="<?=$admin['username']?>" required>
    <label>Password (พิมพ์รหัสใหม่เพื่อเปลี่ยน):</label>
    <input name="password" value="<?=$admin['password']?>" required>
    <button name="update">บันทึกการเปลี่ยนแปลง</button>
    <a href="admin.php" class="back">← กลับไปหน้า Admin</a>
</form>

<?php
if(isset($_POST['update'])){
    $dn = $_POST['display_name']; $un = $_POST['username']; $pw = $_POST['password'];
    $conn->query("UPDATE Admins SET display_name='$dn', username='$un', password='$pw' WHERE id=$admin_id");
    $_SESSION['admin_name'] = $dn;
    echo "<script>alert('อัปเดตข้อมูลแล้ว'); window.location='admin.php';</script>";
}
?>
</body>
</html>
<?php include 'footer.php'; ?>