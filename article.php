<?php
session_start();
require './src/login.php';
// var_export($_SESSION['pseudo']);
// var_export($_SESSION['ID_USER']);
$i = 0;
$nom_article = null;
$description = null;
$idArticle = null;



if (!empty($_SESSION['nom_article']) && !empty($_SESSION['description'])) {
    $nom_article = $_SESSION['nom_article'];
    $description = $_SESSION['description'];
    //récuperer l'id_user de users 
    $req = $connectDB->prepare('insert into article (nom_article , description , ID_USER) values (?,?,?) ');
    $req->execute(array($nom_article, $description, $_SESSION['ID_USER']));

    //affichage et sélection des boutons !!!
    $req = $connectDB->prepare('select * from article where ID_USER = ?');
    $rst = $req->execute(array($_SESSION['ID_USER']));
}
// affichage des données 
$req = $connectDB->prepare('select * from article');
$rst = $req->execute();


//affichage des boutons supprimer  avec l'id 


if ($nom_article != null) {
    $_SESSION['nom_article'] = '';
    $_SESSION['description'] = '';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>article</title>
</head>

<body>
    <nav class="container-fluid bg-primary">

        <ul class="nav nav-tab justify-content-center ">
            <li class="nav-item ">
                <a href="index.php" class="nav-link active text-white">
                    Incription
                </a>
            </li>
            <li class="nav-item">
                <a href="connection.php" class="nav-link active text-white">
                    connection
                </a>
            </li>
            <li class="nav-item">
                <a href="article.php" class="nav-link active text-white">
                    article
                </a>
            </li>
            <?php if (isset($_SESSION['connect'])) { ?>
                <li class="nav-item">
                    <a href="addArticle.php" class="nav-link active text-white">
                        ajouter un article
                    </a>
                </li>
                <li class="nav-item">
                    <a href="suppArticle.php" class="nav-link active text-white">
                        supprimer un article
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./src/deconnection.php" class="nav-link active text-white">
                        Déconnexion
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>

    <h1 class='text-danger text-align'>article</h1>

    <?php
    if (isset($_GET['success'])) {
        echo "<p> article enrengistrer dans la base de donnée </p>";
    }
    ?>


    <?php


    if ($rst) {
        //je lis ma table
        $data = $req->fetchAll();
        foreach ($data as $article) {

            if (!isset($_SESSION['ID_USER'])) {

                echo "
     <h1 class ='text-center'> {$article['nom_article']}</h1>
      <p class ='text-center'> date de création : {$article['date_article']}</p>
     <p class ='text-center'> {$article['description']} </p>
       ";
            }


            if (isset($_SESSION['ID_USER'])) {

                echo "
                <h1 class ='text-center'> {$article['nom_article']}</h1>
                <p class ='text-center'> date de création : {$article['date_article']}</p>
                <p class ='text-center'> {$article['description']} </p>
                ";
                if ($article['ID_USER'] === $_SESSION['ID_USER']) {
                    echo "<form action='newsupp.php' method='POST'>"; ?>
                    <input type="hidden" value=<?php echo "{$article['ID_ARTICLE']}" ?> name="id">
                    <button type="submit" value="supprimer" name="supprimer">supprimer</button>
    <?php echo "</form>";
                    echo "<form action ='mod.php' method='POST'> 
                   
                   <input type='hidden' value='{$article['ID_ARTICLE']}' name ='idMod'>
                   <button type='submit'> modifier </button>
                   </form>";
                }
            }
        }
    }
    ?>





</body>

</html>