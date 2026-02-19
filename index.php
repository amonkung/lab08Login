<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>🐾 รวมสายพันธุ์แมว</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #fff0f6; margin: 0; color: #444; }
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        
        h1 { text-align: center; color: #ff4d6d; font-size: 2.2rem; margin-bottom: 40px; }
        
        .admin-btn { position: fixed; top: 20px; right: 20px; background: #ff4d6d; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-weight: bold; box-shadow: 0 4px 10px rgba(255, 77, 109, 0.3); z-index: 1000; }

        /* จัด Grid ให้บัตรขนาดพอดีๆ ไม่ใหญ่เกินไป */
        .cat-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 25px; 
        }
        
        .cat-card { 
            background: #fff; 
            border-radius: 15px; 
            overflow: hidden; 
            box-shadow: 0 8px 15px rgba(0,0,0,0.05); 
            display: flex; 
            flex-direction: column;
            border: 1px solid #f7e9f1;
        }

        /* ส่วนสำคัญ: ปรับรูปให้เข้ากรอบ */
        .img-container {
            width: 100%;
            height: 200px; /* กำหนดความสูงตายตัวให้เท่ากันทุกใบ */
            overflow: hidden;
            background: #eee;
        }

        .main-img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; /* ทำให้รูปเต็มกรอบโดยไม่เบี้ยว */
            display: block;
        }
        
        .content { padding: 15px; flex-grow: 1; }
        .content h2 { margin: 0; color: #ff4d6d; font-size: 1.25rem; }
        .eng-name { color: #aaa; font-size: 0.85rem; margin-bottom: 10px; }
        .description { 
            font-size: 0.9rem; 
            color: #666; 
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* ตัดข้อความให้โชว์แค่ 3 บรรทัด */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* แกลเลอรี่เล็กๆ ด้านล่าง */
        .gallery { 
            display: flex; 
            gap: 5px; 
            padding: 10px 15px 15px; 
            overflow-x: auto; 
            background: #fff;
        }
        .gallery img { 
            width: 50px; 
            height: 50px; 
            object-fit: cover; /* รูปเล็กก็ปรับให้เข้ากรอบสี่เหลี่ยมจัตุรัส */
            border-radius: 6px; 
            border: 1px solid #ff4d6d;
            flex-shrink: 0;
        }

        footer { text-align: center; padding: 40px; color: #ff4d6d; opacity: 0.7; }
    </style>
</head>
<body>

<a href="admin.php" class="admin-btn">⚙️ จัดการระบบ</a>

<div class="container">
    <h1>🐾 ระบบข้อมูลสายพันธุ์แมว</h1>

    <div class="cat-grid">
        <?php
        $res = $conn->query("SELECT * FROM CatBreeds WHERE is_visible = 1");
        while($cat = $res->fetch_assoc()){
            $cid = $cat['id'];
        ?>
        <div class="cat-card">
            <div class="img-container">
                <img src="<?=$cat['image_url']?>" class="main-img">
            </div>

            <div class="content">
                <h2><?=$cat['name_th']?></h2>
                <div class="eng-name"><?=$cat['name_en']?></div>
                <div class="description"><?=$cat['description']?></div>
            </div>
            
            <div class="gallery">
                <?php
                $imgs = $conn->query("SELECT * FROM CatImages WHERE cat_id=$cid");
                while($ig = $imgs->fetch_assoc()){
                    echo "<img src='".$ig['image_url']."'>";
                }
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<footer>© 2026 ข้อมูลแมวเหมียว 🐱</footer>

</body>
</html>