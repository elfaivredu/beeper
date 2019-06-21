<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;
            charset=utf-8" />
</head>
<title>Inscription</title>
<body>
<div align="center">
    <h2>Inscription</h2>
    <br /><br /><br />

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

    <form method="POST" action="/handleInscription">
        <table>
            <tr>
                <td align="right">
                    <label for="
                            pseudo">Pseudo :
                    </label>
                </td>
                <td align="right">
                    <input type="text" placeholder="@pseudo"
                           id="login" name="login" value = "<?php if(isset($params['login'])) echo $params['login']->getLogin(); ?>"/>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="
                            email">Mail :
                    </label>
                </td>
                <td align="right">
                    <input type="email" placeholder="mail@mail.fr"
                           id="
                            email" name="email" value="<?php if(isset($params['email'])) echo $params['email']->getEmail(); ?>"/>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="
                            email2">Confirmation du Mail :
                    </label>
                </td>
                <td align="right">
                    <input type="email" placeholder="mail@mail.fr"
                           id="email2" name="email2" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="
                            mdp">Mot de Passe :
                    </label>
                </td>
                <td align="right">
                    <input type="password" placeholder="Mot de Passe"
                           id="mdp" name="mdp" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="
                            mdp2">Confirmation du Mot de Passe :
                    </label>
                </td>
                <td align="right">
                    <input type="password" placeholder="Confirmer Mot de Passe"
                           id="mdp2" name="mdp2" />
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
                           id= dateNaissance" name="dateNaissance" />
                </td>
            </tr>
            <td align="right">
                <label for="
                            Sexe"> Sexe :
                </label>
            <td align="right">
                <input type="radio" name="genre" value="Femme">Femme
                <input type="radio" name="genre" value="Homme">Homme
            </td>
            <tr>
                <td align="right"><br/>
                    <input type="submit" value="Valider">
                </td>
            </tr>
        </table>
    </form>
    <p>
        <a href="/">Connexion </a>
    </p>
</div>
</body>
</html>