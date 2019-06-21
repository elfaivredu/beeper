<?php
if (session_status() == 1) session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;
            charset=utf-8" />
</head>
<title>All Searched Members</title>
<body>
<h1>All Searched Members</h1>

<form action = "/search" method = "POST">
    <input type = "text" name = "recherche" placeholder="@login" value="<?php if(isset( $params['recherche'])) echo $params['recherche']?>">
    <button type="submit"> Rechercher </button>
</form>

<table>
    <?php if($params['members'] == null) echo 'No member found'; else foreach ($params['members'] as $member) : ?>
        <tr>
            <td><a href="/profilePublic/<?php echo $member->getId() ?>"><?=
                    $member->getLogin(); ?></a></td>
        </tr>

    <?php endforeach; ?>
</table>

<p>
    <a href="/user/<?=$_SESSION['id']; ?>">
        Back to Profile
    </a>
</p>

<p>
    <a href="/handleDisconnection">Disconnect</a>
</p>

</body>
</html>