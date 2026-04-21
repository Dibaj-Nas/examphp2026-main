<?php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=contacts_app;charset=utf8", "root", "");
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>