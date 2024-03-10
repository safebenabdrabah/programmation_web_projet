<?php
session_start();


if (!isset($_SESSION['identifiant'])) {
    header("Location: login.php");
    exit();
}

require('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Supprimer le compte utilisateur de la base de données
    $identifiant = $_SESSION['identifiant'];
    $sql = "DELETE FROM user WHERE identifiant = :identifiant";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->execute();

    
    // Détruire la session et rediriger vers la page de connexion
    session_destroy();
    header("Location: index.html");
    exit();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2; 
        }
        h1 {
            text-align: center;
            margin-top: 50px;
        }
        p {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
        }
        input[type="submit"] {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete your account?</p>
    <form method="POST" action="">
        <input type="submit" value="Delete">
    </form>
</body>
</html>
