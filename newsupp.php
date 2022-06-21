<?php 

 $ID_ARTICLE = $_POST['id'];
 $upp = $_POST['supprimer'];

require './src/login.php';
$req = $connectDB->prepare("DELETE FROM article WHERE ID_ARTICLE = $ID_ARTICLE");
$rst = $req->execute();

header('location:article.php');
        exit();





?>