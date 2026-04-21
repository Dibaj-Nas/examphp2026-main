<?php
require 'config.php';
require 'functions.php';

// gestion de la suppression (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $token = $_POST['token'] ?? '';
    $id = $_POST['id'] ?? null;
    
    if (!verifyToken($token)) {
        header('Location: index.php?error=token+CSRF+invalide');
        exit;
    }

    if ($id === null) {
        header('Location: index.php?error=ID+contact+manquant');
        exit;
    }

    $result =deleteContact($pdo, $id);
    $redirectParam = $result['success'] ? 'success' : 'error';
    header('Location: index.php?' . $redirectParam . '=' . urlencode($result['message']));
    exit;
}

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

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>


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