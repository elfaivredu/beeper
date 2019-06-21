<?php
if(session_status ()==1) session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;
            charset=utf-8" />
</head>
<title>Profil Publique</title>
<body>
<h1><?= $params['member']->getLogin() ?></h1>
<p>
    Profil de <?= $params['member']->getLogin(); ?>
</p>
<p>
    Date de Naissance : <?= $params['member']->getBirthday(); ?>
</p>
<p>
    Sexe : <?= $params['member']->getGender(); ?>
</p>
<p>
    <?php if($params['member']->isFollow()) : ?><form action="/handleSuppFollow" method="POST">
    <input type="hidden" name="follow_id" value="<?php echo $params['member']->getId() ?>" />
    <button type="submit">Supp Follow</button>
</form>

    <?php else :?><form action="/handleAddFollow" method="POST">
    <input type="hidden" name="follow_id" value="<?php echo $params['member']->getId() ?>" />
    <button type="submit">Follow</button>
</form>
<?php endif?>
</p>

<p> Ses Tweets :
<table>
    <?php foreach ($params['tweets'] as $tweet) : ?>
        <?php if($params['member']->getId() === $tweet->getAuthorId()) : ?>
            <tr>
                <td>
                    Tweet: <?= $tweet->getPost(); ?>
                </td>

                <td>Date du Post : <?= $tweet->getDate(); ?></td>

                <td>

                </td>
            </tr>
        <?php endif?>
    <?php endforeach; ?>


</table>


</p>
<p>
    <a href="/homepage">
        Back to homepage
    </a>
</p>

<p>
    <a href="/user/<?=$_SESSION['id']; ?>">Retour au Profil</a>
</p>
</body>
</html>
