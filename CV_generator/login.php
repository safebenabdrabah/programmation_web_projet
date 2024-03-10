<?php
// Start the session
session_start();

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $identifiant = htmlspecialchars($_POST["identifiant"]);
    $password = htmlspecialchars($_POST["password"]);

    // Connexion à la base de données (à remplacer par vos propres informations de connexion)
    require('connect.php');

    // Préparation de la requête SQL pour vérifier les identifiants et le mot de passe
    $sql = "SELECT * FROM user WHERE identifiant = :identifiant AND password = :password";
    $stmt = $conn->prepare($sql);

    // Liaison des paramètres de la requête avec les valeurs du formulaire
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->bindParam(':password', $password);

    // Exécution de la requête
    $stmt->execute();

    // Vérification du résultat de la requête
    if ($stmt->rowCount() == 1) {
        // Identifiants corrects, enregistrer l'identifiant dans la session
        $_SESSION['identifiant'] = $identifiant;
        // Rediriger vers une page de succès ou autre
        header("Location: cvdatacollector1.php");
        exit();
    } else {
        // Identifiants incorrects, afficher un message d'erreur
        header("Location: login.php");
    }

    // Fermeture de la connexion à la base de données
    $conn = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }
        .container {
            position: relative; 
            z-index: 1; 
            max-width: 800px;
            margin: 100px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #333; 
        }
        h1 {
            color: #2c3e50; 
            margin-bottom: 30px;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            margin-bottom: 20px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            outline: none;
            font-size: 16px;
            border: 1px solid #b1abab;
        }
        input[type="submit"] {
            background-color: #3498db; 
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2980b9; 
        }
    </style>
    </style>
</head>
<body>
<div class="overlay"></div>
<div class="container" >
    <h1><span style="color: #3498db;">Login</span></h1>
    <form name="login" method="POST" action="login.php">
        <input type="text" name="identifiant" id="identifiant" placeholder="Identifiant">
        <input type="password" name="password" id="password" placeholder="Mot de passe">
        <input type="submit" value="Se connecter">
    </form>
</div>

</body>
</html>
