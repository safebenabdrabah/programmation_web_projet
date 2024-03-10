<?php
// Démarrer la session
session_start();

require("connect.php");

class CV
{
    // Propriétés représentant les champs dans la base de données
    public $full_name;
    public $phone_number;
    public $email;
    public $address;
    public $date_of_birth;
    public $nationality;
    public $professional_summary;
    public $degree;
    public $institution_name;
    public $study_field;
    public $graduation_year;
    public $job_title;
    public $company_name;
    public $location;
    public $employment_period;
    public $responsibilities;
    public $technical_skills;
    public $soft_skills;
    public $certification_name;
    public $issuing_organization;
    public $date_obtained;
    public $languages;
    public $proficiency_level;
    public $template;
    public $identifiant;
    public $profile_pic; 
}

class CVManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createCV(CV $cv)
    {
        try {
            
            // Préparer l'instruction SQL pour insérer les données du formulaire dans la base de données
            $stmt = $this->conn->prepare('INSERT INTO cv_data (full_name, phone_number, email, address, date_of_birth, nationality, professional_summary, degree, institution_name, study_field, graduation_year, job_title, company_name, location, employment_period, responsibilities, technical_skills, soft_skills, certification_name, issuing_organization, date_obtained, languages, proficiency_level, template, identifiant, profile_pic) VALUES (:full_name, :phone_number, :email, :address, :date_of_birth, :nationality, :professional_summary, :degree, :institution_name, :study_field, :graduation_year, :job_title, :company_name, :location, :employment_period, :responsibilities, :technical_skills, :soft_skills, :certification_name, :issuing_organization, :date_obtained, :languages, :proficiency_level, :template, :identifiant, :profile_pic)');

            // Relier les paramètres avec les propriétés de l'objet CV
            foreach ($cv as $key => $value) {
                $stmt->bindParam(':' . $key, $cv->$key);
            }

           // Exécuter la requête
            $stmt->execute();

    
            $lastInsertId = $this->conn->lastInsertId();
            $template = $cv->template;

            // Retourner un tableau avec l'ID et le modèle
            return array('id' => $lastInsertId, 'template' => $template);
        } catch (PDOException $e) {
            echo 'Insertion failed' . $e->getMessage();
            return false;
        }
    }
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['identifiant'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Créer un objet CV et le remplir avec les données du formulaire
    $cv_data = new CV();
    foreach ($_POST as $key => $value) {
        $cv_data->$key = $value;
    }

    
    // Hydrater la propriété identifiant
    $identifiant = $_SESSION['identifiant'];
    $cv_data->identifiant = $identifiant;
//image
    // Vérifier si un fichier a été téléversé
   
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['profile_pic']['tmp_name'];
    $file_name = $_FILES['profile_pic']['name'];
    
    // Définir le répertoire de destination pour le stockage permanent
    $target_dir = "projet1/"; 
    $target_file = $target_dir . basename($file_name);
    
   
    // Déplacer le fichier téléversé vers le répertoire spécifié
    if (move_uploaded_file($file_tmp, $target_file)) {
            // Stocker le chemin du fichier dans la base de données
        $cv_data->profile_pic = $target_file;
    } else {
        echo "An error occurred while uploading the image.";
    }
}


    
// Créer un objet CVManager
    $cvManager = new CVManager($conn);

    // Appeler la méthode createCV pour insérer les données
    $result = $cvManager->createCV($cv_data);
    if ($result !== false) {
        
    // Rediriger vers la page de modèle en fonction du modèle choisi
        $id = $result['id'];
        $template = $result['template'];
        header("Location: template$template.php?id=$id");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resume Generator</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #2373a8; /* Couleur de fond gris clair */
    }
    
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px;
        background-color: #ffffff; /* Couleur de fond blanc */
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    
    h1 {
        text-align: center;
        color: #ffffff; /* Couleur de titre bleu foncé */
    }
    
    h2 {
        margin-top: 30px;
        margin-bottom: 10px;
        color: #2c3e50; /* Couleur de titre bleu foncé */
    }
    
    label {
        font-weight: bold;
        color: #555;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #3498db; 
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    
    .centered-fieldset {
        width: 50%; 
        margin: 0 auto; 
        padding: 20px; 
        border: 3px solid #2c3e52; 
        border-radius: 5px; 
        background-color: #f2f2f2;
    }
    .btn-create {
        display: inline-block;
        padding: 15px 30px;
        background-color: #3498db; 
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-size: 18px;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
        outline: none;
    }
    .btn-create:hover {
        background-color: #2980b9; 
    }
    .btn-create:active {
        background-color: #2c3e50; 
    }
    p {
        font-size: 18px;
        margin-bottom: 20px;
    }
    .btn-template {
        display: block;
        width: 300px;
        height: 200px;
        margin: 20px auto;
        background-color: #3498db;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-size: 18px;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
        outline: none;
        position: relative;
        overflow: hidden;
    }
    .btn-template img {
        width: 100%;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .btn-template:hover {
        background-color: #2980b9;
    }
    .btn-template:active {
        background-color: #2c3e50;
    }
</style>
</head>
<body>

<div style="position: absolute; top: 20px; right: 20px;">
    <a href="profile.php" class="btn-create">Profile</a>

</div>

<h1>Resume Generator</h1>
<fieldset class="centered-fieldset">
<form action="cvdatacollector1.php" method="post" enctype="multipart/form-data" onsubmit="return validateFormAndRedirect()">

 
<div >
    <!-- Personal Information -->
    <h2>Personal Information</h2>
    <label for="full_name">Full Name:</label><br>
    <input type="text" id="full_name" name="full_name" required><br>

    <label for="phone_number">Phone Number:</label><br>
    <input type="tel" id="phone_number" name="phone_number" required><br>

    <label for="email">Email Address:</label><br>
    <input type="email" id="email" name="email" required><br>

    <label for="address">Address:</label><br>
    <input type="text" id="address" name="address"><br>

    <label for="date_of_birth">Date of Birth:</label><br>
    <input type="date" id="date_of_birth" name="date_of_birth" required><br>

    <label for="nationality">Nationality:</label><br>
    <input type="text" id="nationality" name="nationality" required><br>
    
    <label for="profile_pic">Profile Picture:</label><br>
<input type="file" id="profile_pic" name="profile_pic" accept="image/*" enctype="multipart/form-data" required><br>



    
</div>

<div >
    <!-- Professional Summary -->
    <h2>Professional Summary</h2>
    <textarea id="professional_summary" name="professional_summary" rows="4" cols="50" required></textarea><br>
</div>
<div >
    <!-- Education -->
    <h2>Education</h2>
    <label for="degree">Degree/Certification:</label><br>
    <select id="degree" name="degree" required>
        <option value="">Select</option>
        <option value="Bachelor's Degree">Bachelor's Degree</option>
        <option value="Master's Degree">Master's Degree</option>
        <option value="PhD">PhD</option>
    </select><br>
    <label for="institution_name">Institution Name:</label><br>
    <input type="text" id="institution_name" name="institution_name" required><br>
    <label for="study_field">Study Field:</label><br>
    <input type="text" id="study_field" name="study_field" required><br>
    <label for="graduation_date">Graduation Date:</label><br>
    <input type="number" id="graduation_year" name="graduation_year" min="1990" max="2025" step="1" placeholder="YYYY" required>
</div>
<div>
    <!-- Work Experience -->
    <h2>Work Experience</h2>
    <label for="job_title">Job Title:</label><br>
    <input type="text" id="job_title" name="job_title" required><br>
    <label for="company_name">Company Name:</label><br>
    <input type="text" id="company_name" name="company_name" required><br>
    <label for="location">Location:</label><br>
    <input type="text" id="location" name="location" required><br>
    <label for="employment_period">Employment Period:</label><br>
    <input type="text" id="employment_period" name="employment_period" placeholder="Start Date - End Date" required><br>
    <label for="responsibilities">Description of Responsibilities and Achievements:</label><br>
    <textarea id="responsibilities" name="responsibilities" rows="4" cols="50" required></textarea><br>
</div>
<div >
    <!-- Skills -->
    <h2>Skills</h2>
    <label for="technical_skills">Technical Skills:</label><br>
    <textarea id="technical_skills" name="technical_skills" rows="4" cols="50" required></textarea><br>
    <label for="soft_skills">Soft Skills:</label><br>
    <textarea id="soft_skills" name="soft_skills" rows="4" cols="50" required></textarea><br>
</div>
<div>
    <!-- Certifications/Licenses -->
    <h2>Certifications/Licenses</h2>
    <label for="certification_name">Certification Name:</label><br>
    <input type="text" id="certification_name" name="certification_name" required><br>
    <label for="issuing_organization">Issuing Organization:</label><br>
    <input type="text" id="issuing_organization" name="issuing_organization" required><br>
    <label for="date_obtained">Date Obtained:</label><br>
    <input type="date" id="date_obtained" name="date_obtained" required><br>
</div>
<div >
    <!-- Languages -->
    <h2>Languages</h2>
    <label for="languages">Languages Spoken/Written:</label><br>
    <textarea id="languages" name="languages" rows="4" cols="50" required></textarea><br>
    <label for="proficiency_level">Proficiency Level:</label><br>
    <input type="text" id="proficiency_level" name="proficiency_level" required><br>
</div>

<div class="container">
    <h2>Choose Template</h2>
        <input type="radio" id="template1" name="template" value="11" required>
        <label for="template1">Template 1</label><br>
        <img src="template1.png" alt="Template 1" style="width: 50%; height: auto;">
        <br>

        <input type="radio" id="template2" name="template" value="22">
        <label for="template2">Template 2</label><br>
        <img src="template2.png" alt="Template 2" style="width: 50%; height: auto;">
        <br>

        <input type="radio" id="template3" name="template" value="33">
        <label for="template3">Template 3</label><br>
        <img src="template3.png" alt="Template 3" style="width: 50%; height: auto;">
        <br>
</div>
    <!-- Submit Button -->
    <input type="submit" value="Create Resume" class="btn-create">

    

</form>
</fieldset>


<script>
    // Fonction de validation du formulair
    function validateFormAndRedirect() {
        var inputs = document.querySelectorAll('input, textarea, select');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].hasAttribute('required') && !inputs[i].value) {
                alert('Please fill in all required fields.');
                return false; 
            }
        }
        return true; 
                // Autoriser la soumission du formulaire si la validation réussit
    }
</script>
</body>
</html>

