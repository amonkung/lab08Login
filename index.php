<?php include 'header.php'; ?>

<div class="container">
    <h1 style="text-align: center; color: #ff4d6d;">🐾 สายพันธุ์แมวที่น่าสนใจ</h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php
        $res = $conn->query("SELECT * FROM CatBreeds");
        while($cat = $res->fetch_assoc()):
        ?>
        <div style="background: #fff; padding: 15px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <img src="<?=$cat['image_url']?>" class="img-fit">
            <h2 style="color: #ff4d6d; margin: 15px 0 5px;"><?=$cat['name_th']?></h2>
            <p style="font-size: 0.9rem; color: #666;"><?=mb_strimwidth($cat['description'], 0, 100, "...")?></p>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>