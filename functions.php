<?php

function getContacts($pdo) {
    // PDO
    $stmt = $pdo->query("SELECT id, name, email FROM contacts ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getContact($pdo, $id) {
    // fonction getContact
    $stmt = $pdo->prepare("SELECT id, name, email FROM contacts WHERE id = :id");
    $stmt->execute(['id' => (int) $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addContact($pdo, $data) {
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');

    if ($name === '') {
        return ['seccess' => false, 'message' => "Le nom est obligatoire."];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['seccess' => false, 'message' => "L'email est invalide."];
    }

    $stmt = $pdo->prepare("INSERT INTO contacts (name, email) VALUES (:name, :email)");
    $ok = $stmt->execute([
        'name' => $name,
        'email' => $email
    ]);

    if (!$ok) {
        return ['seccess' => false, 'message' => "Erreur lors de l'ajout du contact."];
    }

    return ['success' => true, 'message' => "Contact ajouté avec succes."];
}

function updateContact($pdo, $id, $data) {
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');

    if ($name === '') {
        return ['success' => false, 'message' => "Le nom est obligatoire."];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => "L'email est invalide."];
    }

    $stmt = $pdo->prepare("UPDATE contacts SET name = :name, email = :email WHERE id = :id");
    $ok = $stmt->execute([
        'name' => $name,
        'email' => $email,
        'id' => (int) $id
    ]);

    if (!$ok) {
        return ['success' => false, 'message' => "Erreur lors de la mise a jour du contact."];
    }

    return ['success' => true, 'message' => "Contact modifie avec succes."];
}

function deleteContact($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
    $ok = $stmt->execute(['id' => (int) $id]);

    if (!$ok) {
        return ['success' => false, 'message' => "Erreur lors de la suppression du contact."];
    }

    return ['success' => true, 'message' => "Contact supprime avec succes."];
}


// TOKEN
function generateToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); //Cette fonction génère 32 octets (soit 256 bits) de données cryptographiquement sûres et imprévisibles (ce que dit stackoverflow).
    }
    return $_SESSION['csrf_token'];
}

function verifyToken($token) {
    if (empty($_SESSION['csrf_token'])) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], (string) $token);
    
}
?>