<?php
session_start();
require('./src/login.php');
//INSCRIPTION
if (
    !empty($_POST['pseudo'])
    && !empty($_POST['email'])
    && !empty($_POST['password'])
    && !empty($_POST['password_co'])
) {
    //VARIABLE post 
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_co = $_POST['password_co'];

    //TEST SI PASSWORD =PASSWORD_CO

    if ($password !== $password_co) {
        header('location: index.php?error=1&pass=1');
        exit();
    }
    //TEST SI EMAIL UTILISER;
    $req = $connectDB->prepare("select count(*) as numberPseudo 
    from users where pseudo = ?");
    $req->execute(array($pseudo));

    while ($pseudo_verif = $req->fetch()) {
        if ($pseudo_verif['numberPseudo'] != 0) {
            header('location: index.php?error=1&pseudo=1');
            exit();
        }
    }
    //HASHAGE DU MDP 
    $secret = sha1($pseudo) . time();
    $secret = sha1($pseudo) . time() . time();
    //CRYPATGE DU PASSWORD 
    $password = "us1" . sha1($password . "1258") . "25";
    //ENVOI DE LA REQUËTE DANS LA BASE DE DONNEE
    $req = $connectDB->prepare("insert into users (pseudo,email,password,secret) values (
  ? , ?, ?, ?
    )");
    $req->execute(array($pseudo, $email, $password, $secret));
    header('location: index.php?success=1');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Incription</title>
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
                    <a href="./src/deconnection.php" class="nav-link active text-white">
                        Déconnexion
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>
    <div class="container w-50 ">
        <?php
        if (!isset($_SESSION['connect'])) {

        ?>

            <h1 class="h1 text-danger text-center">inscription</h1>
            <?php
            if (isset($_GET['error'])) {
                if (isset($_GET['pass'])) {
                    echo '<p id="error" class="text-danger text-center"> les motes de passes ne sont pas identiques , veuillez retapez des mots de passe identiques .</p>';
                } elseif (isset($_GET['pseudo'])) {
                    echo '<p id="error" class="text-danger text-center"> le pseudo choisit est déjà existant.</p>';
                }
            }
            elseif(isset($_GET['success'])){
                echo'<p class="text-success text-center">votre inscription a été pris en compte </p>';
            }
            ?>
            <p class="text-primary  text-center"> Bienvenue sur mon site ,pour en savoir plus, inscrivez vous , sinon <a href="connection.php">connectez vous </a></p>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@sample.com" required>
                </div>
                <div class="form-group">
                    <label for="pseudo">pseudo</label>
                    <input type="pseudo" name="pseudo" id="pseudo" class="form-control" placeholder="example15987" required>
                </div>
                <div class="form-group">
                    <label for="password"> password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="example15987" required>
                </div>
                <div class="form-group">
                    <label for="password_co">confirm password</label>
                    <input type="password" name="password_co" id="password_co" class="form-control" placeholder="example15987" required>
                </div>
                <button type="submit" class="btn btn-outline-success"> Submit </button>

            </form>
        <?php } else {
            echo '<p class = "text-success text-align">Vous êtes connecté avec succès , bien joué ' . $_SESSION['pseudo'] . "</p>";
        } ?>
    </div>
</body>

</html>