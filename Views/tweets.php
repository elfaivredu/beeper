<?php
if(session_status ()==1) session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;
            charset=utf-8" />
</head>

<title>Tweets Publique</title>
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

<table>
    <?php foreach ($params['tweets'] as $tweet) : ?>
    <tr>
        <td>
            Tweet de  <a href="/profilePublic/<?= $tweet->getAuthorId() ?>"> <?= $tweet->getAuthor(); ?> </a>
        </td>

        <td>
            Tweet: <?= $tweet->getPost(); ?>
        </td>

        <td>Date du Post : <?= $tweet->getDate(); ?></td>

        <td><?php if($_SESSION['id'] === $tweet->getAuthorId()) : ?>
                <a href="/deleteTweet/<?= $tweet->getId() ?>"> Supprimer son Tweet</a>
                <a href="/updateTweet/<?= $tweet->getId() ?>"> Modifier son Tweet</a>

            <?php else: ?> <form action="/tweeter/handleLike" method="POST">
                <input type="hidden" name="redirect" value="<?php echo 'tweets' ?>" />
                <input type="hidden" name="tweeID" value="<?php echo $tweet->getId() ?>" />
                <button type="submit">Like</button>
            </form>
        </td>

        <?php endif?>
    </tr>
    <?php endforeach; ?>


</table>

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