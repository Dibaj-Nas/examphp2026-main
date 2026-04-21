<?php
require 'config.php';
require 'functions.php';

$contact = null;

if (isset($_GET['id'])) {
    $contact = getContact($pdo, $_GET['id']);
}

$token = generateToken();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire</title>
</head>
<body>

<form method="POST">
    <input type="hidden" name="token" value="<?= $token ?>">

    <input type="text" name="name" placeholder="Nom" value="<?= $contact['name'] ?? '' ?>">
    <input type="email" name="email" placeholder="Email" value="<?= $contact['email'] ?? '' ?>">

    <button name="<?= $contact ? 'update' : 'create' ?>">Valider</button>
</form>

</body>
</html>