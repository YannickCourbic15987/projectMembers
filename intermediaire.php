<?php
   //recup des données 
   session_start();
   $i = 0;
   if(!empty(  $_POST['nom_article']) && !empty($_POST['description'])){

      $_SESSION['nom_article'] =  $_POST['nom_article'];
      $_SESSION['description']= $_POST['description'];

    
    //récuperer l'id_user de users 
        header('location:article.php');
        exit();
    }

