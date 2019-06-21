<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;
            charset=utf-8" />
</head>
<title>Profile</title>
<body>
<div>
    <h2>Profil de <?= $_SESSION['login']; ?></h2>


    <form align="right" action = "/search" method = "POST">
        <input type = "text" name = "recherche" placeholder="@login">
        <button type="submit"> Rechercher </button>
    </form>

    <p>
        Login : <?= $_SESSION['login']; ?>
    </p>

    <p>
        Email : <?= $_SESSION['email']; ?>
    </p>

    <p>
        Date de Naissance :  <?= $_SESSION['birthday']; ?>
    </p>
    <p>
        Sexe :  <?= $_SESSION['gender']; ?>
    </p>

    <p>
        <a href="/updateProfile">Modifier son Profil </a>
    </p>

    <p>
        <a href="/delete">Supprimer son Profil </a>
    </p>

    <p>
        <a href="/homepage">Aller à la page d'Acceuil </a>
    </p>

    <p>
        <a href="/handleDisconnection">Se Deconnecter </a>
    </p>

</div>
</body>
</html>