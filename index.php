<?php
require 'config.php';
require 'functions.php';

$contacts = getContacts($pdo);
$token = generateToken();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contacts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Liste des contacts</h1>

<a href="form.php">Ajouter un contact</a>

<ul>
<?php foreach ($contacts as $c): ?>
    <li>
        <?= htmlspecialchars($c['name']) ?> - <?= htmlspecialchars($c['email']) ?>

        <a href="form.php?id=<?= $c['id'] ?>">Modifier</a>

        <form method="POST" action="" style="display:inline;">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <input type="hidden" name="token" value="<?= $token ?>">
            <button name="delete">Supprimer</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>

</body>
</html>