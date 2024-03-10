<?php
session_start();

if (!isset($_SESSION['identifiant'])) {
    header("Location: login.php");
    exit();
}

require('connect.php');

// Récupérer les données de l'utilisateur depuis la base de données
$identifiant = $_SESSION['identifiant'];
$sql = "SELECT * FROM user WHERE identifiant = :identifiant";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':identifiant', $identifiant);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données mises à jour du formulaire
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);

    
    // Mettre à jour les données de l'utilisateur dans la base de données
    $sql = "UPDATE user SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone WHERE identifiant = :identifiant";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':identifiant', $identifiant);
    $stmt->execute();

    header("Location: profile.php");
    exit();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Update Profile</h1>
    <form method="POST" action="">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" value="<?php echo $user['nom']; ?>"><br>
        <label for="prenom">Prénom:</label><br>
        <input type="text" id="prenom" name="prenom" value="<?php echo $user['prenom']; ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br>
        <label for="telephone">Téléphone:</label><br>
        <input type="text" id="telephone" name="telephone" value="<?php echo $user['telephone']; ?>"><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
