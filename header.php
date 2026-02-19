<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐱 ระบบข้อมูลสายพันธุ์แมว</title>
    <style>
        /* CSS หลักสำหรับทุกหน้า */
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #fff0f6; margin: 0; display: flex; flex-direction: column; min-height: 100vh; color: #444; }
        
        /* Header Styling */
        .main-header { background: #ff4d6d; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .logo { font-size: 1.5rem; font-weight: bold; text-decoration: none; color: white; }
        .nav-menu a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; transition: 0.3s; }
        .nav-menu a:hover { opacity: 0.8; }

        .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; flex: 1; width: 100%; box-sizing: border-box; }

        /* การจัดการรูปภาพให้เข้ากรอบ */
        .img-fit { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; }
        
        /* ฟอร์มและปุ่ม */
        .btn-primary { background: #ff4d6d; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-primary:hover { background: #ff1f4d; }
    </style>
</head>
<body>

<header class="main-header">
    <a href="index.php" class="logo">🐾 CatSystem</a>
    <nav class="nav-menu">
        <a href="index.php">หน้าแรก</a>
        <?php if(isset($_SESSION['admin_id'])): ?>
            <a href="admin.php">จัดการข้อมูล</a>
            <a href="profile.php">โปรไฟล์</a>
            <a href="logout.php" style="background: rgba(0,0,0,0.1); padding: 5px 12px; border-radius: 5px;">ออกจากระบบ</a>
        <?php else: ?>
            <a href="login.php">เข้าสู่ระบบ</a>
        <?php endif; ?>
    </nav>
</header>