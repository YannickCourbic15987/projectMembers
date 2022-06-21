<?php
session_start();

if (isset($_SESSION['connect'])) {
    header('location: ./');
    exit();
}


//creéation d'une session 
//connection
require "./src/login.php";
if (
    !empty($_POST['pseudo']) &&
    !empty($_POST['password'])
) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    //hashage du mdp 
    $password = "us1" . sha1($password . "1258") . "25";
    $req = $connectDB->prepare('SELECT * FROM users WHERE pseudo = ?');
    $req->execute(array($pseudo));
    while ($user = $req->fetch()) {
        if ($password == $user['password']) {
            $_SESSION['connect'] = 1; //optionnel , 
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['ID_USER'] = $user['ID_USER'];
            header('location: connection.php?success=1');
        } elseif ($password !== $user['password']) {
            header('location: connection.php?error=1');
        }

        // password_verify()
    }
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
        </ul>
    </nav>

    <h1 class="h1 text-danger text-center">connexion</h1>
    <p class="text-primary  text-center"> Bienvenue sur mon site ,pour en savoir plus, si vous êtes pas inscrit , sinon <a href="index.php">inscrivez vous </a></p>

    <?php
    if (isset($_GET['success'])) {
        echo "<p class= 'text-success text-center'> connecté ! </p>";
    } elseif (isset($_GET['error'])) {
        echo "<p class= 'text-danger text-center' > connection refuser ! </p>";
    }
    ?>

    <form class="w-50 container " action="connection.php" method="post">
        <div class="form-group ">
            <label for="pseudo" class="my-mb-1">pseudo</label>
            <input type="pseudo" name="pseudo" id="pseudo" class="form-control my-mb-1" placeholder="example15987" required>
        </div>
        <div class="form-group">
            <label for="password">password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="example15987" required>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="connect" checked>
                <p>Connection automatique</p>

            </label>
        </div>

        <button type="submit" class="btn btn-outline-success"> Submit </button>

    </form>
</body>

</html>