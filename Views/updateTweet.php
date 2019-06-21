<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;
            charset=utf-8" />
</head>
<title>Update</title>
<body>
<div align="center">
    <h2>Update</h2>
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

    <form method="POST" action="/handleUpdateTweet/<?= $params['tweet']->getId() ?>">
        <table>
            <tr>
                <td align="right">
                    <label for="
                            pseudo">Modifier votre Tweet :
                    </label>
                </td>
                <td align="right">
                    <input type="text" placeholder="Votre Tweet, Max 140 caractere" maxlength="140"
                           id="login" name="tweet" value = "<?php if(isset($params['tweet'])) echo $params['tweet']->getPost(); ?>"/>
                </td>
                <td align="right"><br/>
                    <input type="submit" value="Valider les Modifications">
                </td>
            </tr>
        </table>
    </form>
    <a href="/user/<?=$_SESSION['id']; ?>">Retour au Profil</a>
</div>
</body>
</html>