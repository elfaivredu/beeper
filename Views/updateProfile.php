<!doctype html>

<html lang="fr">

<head>

    <title>modifier profil</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <div class="premiere-rubrique">
        <div class="logo">
            <img src="image/a_sheep.png" alt="logo_sheep" height="35px"/>
        </div>
        <h2>Beeper</h2>

    </div>

</head>

<body>

    <?php if(isset($params['error'])) {
        $e = $params['error'];
        echo "
           <p style='color: red'>
            $e
           </p>
        ";
    }
    if(isset($params['valid'])){
        $a = $params['valid'];
        echo "
           <p style='color: limegreen'>
            $a
           </p>
        ";
    }?>

    <div class="grid">

        <div class="troisieme-rubrique">
            <h1> Modifier mon compte beeper</h1>
            <div class="woa">
                <img src="image/open_mouth.png" alt="sheep_etonné" height="200px"/>
            </div>
        </div>
        <div class="deuxieme-rubrique">
            <form method="POST" action="/handleUpdateProfile">
        <table>
            <tr>
                <td align="right">
                    <label for="
                            pseudo">Modifier votre Pseudo :
                    </label>
                </td>
                <td align="right">
                    <input type="text" placeholder="@pseudo"
                           id="login" name="login" value = "<?php if(isset($params['account'])) echo $params['account']->getLogin(); ?>"/>
                </td>
            </tr>
                <td align="right">
                    <label for="
                            email">Changer votre Mail :
                    </label>
                </td>
                <td align="right">
                    <input type="email" placeholder="mail@mail.fr"
                           id="
                            email" name="email" value="<?php if(isset($params['account'])) echo $params['account']->getEmail(); ?>"/>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="
                            mdp">Nouveau Mot de Passe :
                    </label>
                </td>
                <td align="right">
                    <input type="password" placeholder="Nouveau Mot de Passe"
                           id="mdp" name="mdp" value="<?php if(isset($params['account'])) echo $params['account']->getPassword(); ?>"/>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="
                            mdp2">Confirmation du Nouveau Mot de Passe :
                    </label>
                </td>
                <td align="right">
                    <input type="password" placeholder="Confirmer Mot de Passe"
                           id="mdp2" name="mdp2" value="<?php if(isset($params['account'])) echo $params['account']->getPassword(); ?>"/>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="
                            dateNaissance">Date de Naissance :
                    </label>
                </td>
                <td align="right">
                    <input type="date" placeholder="jj/mm/aaaa"
                           id= dateNaissance" name="dateNaissance" value="value="<?php if(isset($params['account'])) echo $params['account']->getBirthday(); ?>" />
                </td>
            </tr>
            <td align="right">
                <label for="
                            Sexe"> Sexe :
                </label>
            <td align="right">
                <select name="genre">
                <option value="Femme">Femme</option>
                <option value="Homme">Homme</option>
                </select>
            </td>
            <tr>
                <td align="right"><br/>
                    <input type="submit" value="Valider les Modifications">
                </td>
            </tr>
        </table>
    </form>
        </div>
    <a href="/user/<?=$_SESSION['id']; ?>">Retour au Profil</a>
</div>
</body>
</html>