<?php include 'db.php'; check_login(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #f7e9f1; margin: 0; padding: 0; }
        header { background: #ff4d6d; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        header a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; font-size: 0.9rem; }
        
        .container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        .form-card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 40px; }
        h3 { color: #ff4d6d; margin-top: 0; border-bottom: 2px solid #f7e9f1; padding-bottom: 10px; }
        
        label { display: block; margin-top: 15px; font-weight: bold; font-size: 0.9rem; }
        input, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { background: #ff4d6d; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 20px; width: 100%; transition: 0.3s; }
        button:hover { background: #ff1f4d; }

        .cat-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        .cat-item { background: white; padding: 10px; border-radius: 12px; text-align: center; }
        .cat-item img { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; }
        .cat-item h4 { margin: 10px 0 5px; font-size: 1rem; }
        .action-links a { font-size: 0.8rem; text-decoration: none; color: #ff4d6d; margin: 0 5px; }
    </style>
</head>
<body>

<header>
    <div style="font-size: 1.2rem; font-weight: bold;">🐱 Cat Admin</div>
    <nav>
        <a href="index.php">หน้าแรก</a>
        <a href="profile.php">โปรไฟล์</a>
        <a href="logout.php">ออกจากระบบ</a>
    </nav>
</header>

<div class="container">
    <div class="form-card">
        <h3>+ เพิ่มข้อมูลแมวใหม่</h3>
        <form method="post" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label>ชื่อไทย</label>
                    <input name="name_th" required placeholder="เช่น แมวสีสวาด">
                </div>
                <div>
                    <label>ชื่ออังกฤษ</label>
                    <input name="name_en" required placeholder="เช่น Korat Cat">
                </div>
            </div>
            
            <label>คำอธิบาย</label>
            <textarea name="description" rows="3"></textarea>
            
            <label>รูปภาพหลัก (อัปโหลด หรือ วางลิงก์)</label>
            <input type="file" name="image" accept="image/*">
            <input name="image_url_main" placeholder="https://...">

            <label>รูปภาพเพิ่มเติม (อัปโหลดหลายไฟล์ หรือ วางลิงก์คั่นด้วย ,)</label>
            <input type="file" name="extra_files[]" multiple accept="image/*">
            <textarea name="extra_links" placeholder="ลิงก์รูปที่ 1, ลิงก์รูปที่ 2"></textarea>
            
            <button name="save">บันทึกข้อมูลแมว</button>
        </form>
    </div>

    <h3>📦 รายการทั้งหมด</h3>
    <div class="cat-list">
        <?php
        $res = $conn->query("SELECT * FROM CatBreeds");
        while($row = $res->fetch_assoc()){
            echo "<div class='cat-item'>
                    <img src='".$row['image_url']."'>
                    <h4>".$row['name_th']."</h4>
                    <div class='action-links'>
                        <a href='edit.php?id=".$row['id']."'>แก้ไข</a>
                        <a href='delete.php?id=".$row['id']."' style='color:#aaa' onclick=\"return confirm('ลบหรือไม่?')\">ลบ</a>
                    </div>
                  </div>";
        }
        ?>
    </div>
</div>

<?php
// PHP บันทึกข้อมูล (ส่วนเดิมที่ใช้งานได้)
if(isset($_POST['save'])){
    $name_th = mysqli_real_escape_string($conn, $_POST['name_th']);
    $name_en = mysqli_real_escape_string($conn, $_POST['name_en']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $main_img = "";

    if(!empty($_FILES['image']['name'])){
        $path = "uploads/".time()."_".$_FILES['image']['name'];
        if(!is_dir('uploads')) mkdir('uploads', 0777, true);
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
        $main_img = $path;
    } else { $main_img = $_POST['image_url_main']; }

    $conn->query("INSERT INTO CatBreeds (name_th, name_en, description, image_url) VALUES ('$name_th', '$name_en', '$desc', '$main_img')");
    $cat_id = $conn->insert_id;

    // จัดการรูปเพิ่มเติม (ไฟล์)
    if(!empty($_FILES['extra_files']['name'][0])){
        foreach($_FILES['extra_files']['tmp_name'] as $key => $tmp){
            $p = "uploads/".time()."_ex_".$key."_".$_FILES['extra_files']['name'][$key];
            move_uploaded_file($tmp, $p);
            $conn->query("INSERT INTO CatImages (cat_id, image_url) VALUES ('$cat_id', '$p')");
        }
    }

    // จัดการรูปเพิ่มเติม (ลิงก์)
    if(!empty($_POST['extra_links'])){
        $links = explode(',', $_POST['extra_links']);
        foreach($links as $l){
            $l = trim($l);
            if(!empty($l)) $conn->query("INSERT INTO CatImages (cat_id, image_url) VALUES ('$cat_id', '$l')");
        }
    }
    echo "<script>window.location='admin.php';</script>";
}
?>

</body>
</html>