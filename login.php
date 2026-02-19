<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>เข้าสู่ระบบ Admin</title>
    <style>
        body{font-family:sans-serif;background:#f7e9f1;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}
        .login-card{background:#fff;padding:30px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,0.1);width:320px}
        input{width:100%;padding:10px;margin:10px 0;border:1px solid #ddd;border-radius:8px;box-sizing:border-box}
        button{background:#ff4d6d;color:white;padding:10px;border:none;border-radius:8px;width:100%;cursor:pointer;font-weight:bold}
        button:hover{background:#ff1f4d}
    </style>
</head>
<body>
<div class="login-card">
    <h2 style="text-align:center;color:#ff4d6d">🐱 Admin Login</h2>
    <form method="post">
        <input name="user" placeholder="Username" required>
        <input name="pass" type="password" placeholder="Password" required>
        <button name="login">เข้าสู่ระบบ</button>
    </form>
    <?php
    if(isset($_POST['login'])){
        $u = mysqli_real_escape_string($conn, $_POST['user']);
        $p = mysqli_real_escape_string($conn, $_POST['pass']);
        $res = $conn->query("SELECT * FROM Admins WHERE username='$u' AND password='$p'");
        if($row = $res->fetch_assoc()){
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['display_name'];
            header("Location: admin.php");
        } else {
            echo "<p style='color:red;text-align:center'>ชื่อผู้ใช้หรือรหัสผ่านผิด</p>";
        }
    }
    ?>
</div>
</body>
</html>