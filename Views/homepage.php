<?php
if(session_status ()==1) session_start();
?>
<!DOCTYPE HTML>
<br>
<title> Page d'Acueil </title>
<meta charset="UTF-8"/>
<link rel="stylesheet" type="text/css" href="css/styleHomepage.css"/>
<div class="grid">
    <div class="premiere-rubrique un">

        <div class="logo beeper">
            <a href="/updateProfile">
            <img src="image/a_sheep.png" alt="logo_sheep" height="35px"/>
                Modifier Mon Profil</a>
        </div>
    </div>

    <div class="premiere-rubrique un">

        <div class="logo ">
            <a href="/delete">
            <img src="image/a_sheep.png" alt="logo_sheep" height="35px"/>
                Tout Niquer (Supprimer Profil) </a>
        </div>
    </div>

    <div class="premiere-rubrique un">

        <div class="logo ">
            <a href="/homepage">
            <img src="image/a_sheep.png" alt="logo_sheep" height="35px"/>
                Aller à la page d'Acceuil </a>
        </div>
    </div>

    <div class="premiere-rubrique un">

        <div class="logo ">
            <a href="/handleDisconnection">
            <img src="image/a_sheep.png" alt="logo_sheep" height="35px"/>
                Se Déconnecter</a>
        </div>
    </div>


</div>
</head>

<title>Page d'Accueil</title>
<br>
<h1> Home </h1>
<p>
    <a href="/user/<?=$_SESSION['id']; ?>"> Profile </a>
</p>
<form  align="right" action = "/search" method = "POST">
    <input type = "text" name = "recherche" placeholder="Rechercher un utilisateur -> @user">
    <button type="submit"> Rechercher </button>
</form>

<form method="POST" action="handleCreate">
    <tr>
        <td>
            <input type="text" name="post" size="90" maxlenght="140" placeholder="Vous pouvez tweeter ici"/><br/>
            <button type="submit"> Publier </button>
        </td>
    </tr>

</form></br></br>

<table>
    <?php foreach ($params['tweets'] as $tweet) : ?>
            <tr>
                <td><p>
                    Tweet de  <a href="/profilePublic/<?= $tweet->getAuthorId() ?>"> <?= $tweet->getAuthor(); ?> </a>
                    </p></td>
                <td><p>
                    Tweet: <?= $tweet->getPost(); ?>
                    </p></td>

                <td><p>Date du Post : <?= $tweet->getDate(); ?></p></td>
            </tr>
    <?php endforeach; ?>


</table>
</body>
</html>