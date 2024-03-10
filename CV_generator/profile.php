<?php
session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['identifiant'])) {
    header("Location: login.php");
    exit();
}

require('connect.php');

$identifiant = $_SESSION['identifiant'];
$sql = "SELECT * FROM user WHERE identifiant = :identifiant";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':identifiant', $identifiant);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        .button-container {
            margin-top: 20px;
        }
        a.button {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        a.button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<div class="container">
    <h1>Welcome, <?php echo $user['identifiant']; ?></h1>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Nom: <?php echo $user['nom']; ?></p>
    <p>Prénom: <?php echo $user['prenom']; ?></p>
    <p>Téléphone: <?php echo $user['telephone']; ?></p>
    <div class="button-container">
        <a href="update_profile.php" class="button">Update Profile</a>
        <a href="delete_account.php" class="button">Delete Account</a>
        <a href="cvdatacollector1.php" class="button">Back to Resume Maker</a>
    </div>
</div>

</body>
</html>

