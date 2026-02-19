<?php
include 'db.php';
$id=$_GET['id'];
$conn->query("UPDATE CatBreeds SET is_visible=1-is_visible WHERE id=$id");
header("Location: admin.php");
?>