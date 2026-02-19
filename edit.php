<?php include 'db.php'; check_login(); 
$id = $_GET['id'];
$cat = $conn->query("SELECT * FROM CatBreeds WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>แก้ไขข้อมูลแมว</title>
    <style>
        body{font-family:sans-serif;background:#f7e9f1;margin:0;padding:20px}
        form{background:#fff;padding:25px;border-radius:15px;max-width:600px;margin:auto;box-shadow:0 2px 10px rgba(0,0,0,0.1)}
        h2{color:#ff4d6d;text-align:center}
        label{display:block;margin-top:15px;font-weight:bold;color:#333}
        input,textarea{width:100%;padding:10px;margin-top:5px;border:1px solid #ddd;border-radius:8px;box-sizing:border-box}
        .current-imgs{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px}
        .img-box{position:relative;width:100px;height:100px}
        .img-box img{width:100%;height:100%;object-fit:cover;border-radius:8px}
        .btn-save{background:#ff4d6d;color:white;border:none;padding:12px;width:100%;border-radius:8px;font-weight:bold;margin-top:20px;cursor:pointer}
        .btn-cancel{display:block;text-align:center;color:#666;margin-top:15px;text-decoration:none}
    </style>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <h2>✎ แก้ไขข้อมูลสายพันธุ์</h2>
    
    <label>ชื่อไทย:</label>
    <input name="name_th" value="<?=$cat['name_th']?>" required>
    
    <label>รูปหลัก (ปัจจุบัน):</label>
    <div class="current-imgs"><img src="<?=$cat['image_url']?>" style="width:150px;border-radius:10px"></div>
    <input type="file" name="image" accept="image/*">
    <input name="image_url_main" placeholder="หรือใส่ลิงก์รูปภาพหลักใหม่ที่นี่">

    <label>รูปภาพเพิ่มเติม (ที่มีอยู่):</label>
    <div class="current-imgs">
        <?php
        $imgs = $conn->query("SELECT * FROM CatImages WHERE cat_id=$id");
        while($ig = $imgs->fetch_assoc()){
            echo "<div class='img-box'><img src='".$ig['image_url']."'></div>";
        }
        ?>
    </div>

    <label>เพิ่มรูปเพิ่มเติม (อัปโหลดไฟล์):</label>
    <input type="file" name="extra_files[]" multiple accept="image/*">

    <label>เพิ่มรูปเพิ่มเติม (ใส่ลิงก์ คั่นด้วยเครื่องหมายคอมม่า ,):</label>
    <textarea name="extra_links" placeholder="https://link1.jpg, https://link2.jpg"></textarea>

    <button name="update" class="btn-save">✓ บันทึกการเปลี่ยนแปลง</button>
    <a href="admin.php" class="btn-cancel">ยกเลิก</a>
</form>

<?php
if(isset($_POST['update'])){
    $n_th = $_POST['name_th'];
    // อัปเดตรูปหลัก (ถ้ามีการเลือกใหม่)
    if(!empty($_FILES['image']['name'])){
        $path = "uploads/".time()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
        $conn->query("UPDATE CatBreeds SET image_url='$path' WHERE id=$id");
    } elseif(!empty($_POST['image_url_main'])){
        $path = $_POST['image_url_main'];
        $conn->query("UPDATE CatBreeds SET image_url='$path' WHERE id=$id");
    }

    // อัปเดตข้อมูลทั่วไป
    $conn->query("UPDATE CatBreeds SET name_th='$n_th' WHERE id=$id");

    // เพิ่มรูปใหม่ (ไฟล์)
    if(!empty($_FILES['extra_files']['name'][0])){
        foreach($_FILES['extra_files']['tmp_name'] as $key => $tmp){
            $p = "uploads/".time()."_".$key."_".$_FILES['extra_files']['name'][$key];
            move_uploaded_file($tmp, $p);
            $conn->query("INSERT INTO CatImages (cat_id, image_url) VALUES ('$id', '$p')");
        }
    }

    // เพิ่มรูปใหม่ (ลิงก์)
    if(!empty($_POST['extra_links'])){
        $links = explode(',', $_POST['extra_links']);
        foreach($links as $l){
            $l = trim($l);
            if(!empty($l)) $conn->query("INSERT INTO CatImages (cat_id, image_url) VALUES ('$id', '$l')");
        }
    }
    echo "<script>alert('อัปเดตสำเร็จ'); window.location='admin.php';</script>";
}
?>
</body>
</html>