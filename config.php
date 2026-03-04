<?php
try {
    // Connexion à la base campus_it définie dans votre SQL
    $pdo = new PDO('mysql:host=localhost;dbname=campus_it;charset=utf8', 'campus_it', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>