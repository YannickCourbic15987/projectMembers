<?php  session_start(); 
require './src/login.php';




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>suppArticle</title>
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