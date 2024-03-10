<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["telephone"]);
    $identifiant = htmlspecialchars($_POST["identifiant"]);
    $password = htmlspecialchars($_POST["password"]);
    require("connect.php");
    $sql = "SELECT * FROM user WHERE identifiant = :identifiant";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        
    // Si l'identifiant existe, demander à l'utilisateur de le changer
        if ($row) {
            echo "<script>alert('L\'identifiant est déjà utilisé. Veuillez en choisir un autre.');</script>";
            header("Location: index.html");
            exit();}
        else{

        // Préparation de la requête SQL pour l'insertion des données dans la table des utilisateurs
        $sql = "INSERT INTO user (nom, prenom, email, telephone, identifiant, password ) VALUES (:nom, :prenom, :email, :telephone, :identifiant, :password)";
        $stmt = $conn->prepare($sql);

        // Liaison des paramètres de la requête avec les valeurs du formulaire
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':password', $password);

        // Exécution de la requête
        $stmt->execute();

        // Redirection vers une page de confirmation ou autre
        header("Location: login.php");
        exit();
        }
    

    // Fermeture de la connexion à la base de données
    $conn = null;
}
?>
