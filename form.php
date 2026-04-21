<?php
require 'config.php';
require 'functions.php';

$contact = null;
$message = null;
$isError = false;

if (isset($_GET['id'])) {
    $contact = getContact($pdo, $_GET['id']);
}

//gestion de la creation / modification 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';

    if (!verifyToken($token)) {
        $message = "Token CSRF invalide.";
        $isError = true;
    } else {
        if (isset($_POST['create'])) {
            $result = addContact($pdo, $_POST);
        } elseif (isset($_POST['update'])) {
            $idToUpdate = $_GET['id'] ?? null;
            if ($idToUpdate === null) {
                $result = ['success' => false, 'message' => "ID contact manquant."];
            } else {
                $result = updateContact($pdo, $idToUpdate, $_POST);
            }
        } else {
            $result = ['success' => false, 'message' => "Action non reconnue."];
        }

        if ($result['success']) {
            header('Location: index.php?success=' . urlencode($result['message']));
            exit;
        }

        $message = $result['message'];
        $isError = true;
    }

    // Pour conserver la saisie utilisateur en cas d'erreur.
    $contact = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? ''
    ];
}


$token = generateToken();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire</title>
</head>
<body>

<?php if ($message): ?>
        <p style="color:<?= $isError ? 'red' : 'green' ?>;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="token" value="<?= $token ?>">

    <input type="text" name="name" placeholder="Nom" value="<?= $contact['name'] ?? '' ?>">
    <input type="email" name="email" placeholder="Email" value="<?= $contact['email'] ?? '' ?>">

    <button name="<?= $contact ? 'update' : 'create' ?>">Valider</button>
</form>

</body>
</html>