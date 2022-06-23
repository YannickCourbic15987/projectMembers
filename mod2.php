<?php
require './src/login.php';
if (!empty($_POST['new_nom_article']) && !empty($_POST['new_description'])) {
    session_start();
    $new_nom_article = $_POST['new_nom_article'];
    $new_description = $_POST['new_description'];
    $idMod = $_SESSION['idMod'];
    // var_dump($_POST);
    // var_dump($_SESSION);
    $req = $connectDB->prepare('update article set nom_article = ? , description = ? where ID_ARTICLE = ? ');
    $req->execute(array($new_nom_article, $new_description, $idMod));
    header('location:article.php');
}
