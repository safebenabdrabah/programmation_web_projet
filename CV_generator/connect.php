<?php 
// Définition des constantes pour l'accès à la base de données
define('UTILISATEUR', "root");
define('MOT_DE_PASSE', "");
define('SERVEUR', "localhost");
define('BASE_DE_DONNEES', "resume");

// Créer une connexion à la base de données
$dsn = 'mysql:dbname=' . BASE_DE_DONNEES . ';host=' . SERVEUR;
$conn = new PDO($dsn, UTILISATEUR, MOT_DE_PASSE);

// Définir le mode d'erreur PDO sur exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
