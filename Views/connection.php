<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;
            charset=utf-8" />
</head>
<title>Connexion</title>
<body>
<div align="center">
    <h2>Connexion</h2>
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


    <form method="POST" action="/handleConnection">
        <p>
            <label id="login">Login : </label> &nbsp;
            <input  id="login_box" type="text" name="login" value="<?php if(isset($account)) echo $account['login']; ?>">
        </p>
        <p>
            <label id="mdp">Mot de Passe : </label> &nbsp;
            <input  id="mdp_box" type="password" name="mdp">
        </p>
        <p>
            <input type="submit" value="Se Connecter">
        </p>

    </form>
    <p>
        <a href="/inscription">Inscription </a>
    </p>
</div>
</body>
</html>