<head>
  <title>template 2</title>
  <meta charset="utf-8">
  <meta name="viewport"
          content="width=device-width, initial-scale=1, user-scalable=no">

 
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="template.css">
</head>
<body>

   <?php
        require("connect.php");
        
       
if (isset($_GET['id'])) {
    try {
        // Récupérer l'ID du CV depuis l'URL
        $id = $_GET['id'];

        // Préparer la requête SQL pour récupérer les données du CV
        $sql = "SELECT * FROM cv_data WHERE id_utilisateur = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Vérifier si des données ont été trouvées
        if ($stmt->rowCount() > 0) {
            // Afficher les données dans le modèle de CV HTML
            $cv_data = $stmt->fetch(PDO::FETCH_ASSOC);
			// Récupérez le nom du fichier de l'image depuis la base de données

			
			
			
?>

			
			 <div class="cv-container">
      <div class="left-column">
          <img src="<?php echo $cv_data['profile_pic']; ?>" alt="Profile Picture" width="150" height="150">
          

          
        <div class="section" >
          <br>
          <h2>about</h2>
          <p style="overflow-wrap: break-word; max-width: 280px;">
            <?php echo $cv_data['professional_summary']; ?>
          </p>
         
        </div>
		
        <div class="section">
              <h2>Skills</h2>
              <h3>technical skills</h3>
          <ul class="skills">
            <li><i class="icon fas fa-check-circle text-darkblue"></i> <strong> <?php echo $cv_data['technical_skills']; ?></strong></li>
            <br><br>
			<h4>soft skills</h4>
          <ul class="skills">
            <li><i class="icon fas fa-check-circle text-darkblue"></i> <strong> <?php echo $cv_data['soft_skills']; ?></strong></li>
			
          </ul>
        </div>
        <div class="section">
          <h2>languages</h2>
          <p>
            <?php echo $cv_data['languages']; ?>
          </p>
        </div>
        <div class="section">
          <h2>proficiency_level</h2>
          <p>
             <?php echo $cv_data['proficiency_level']; ?>
          </p>
        </div>
      </div>
                <div class="right-column">
                    
					<div class="header">
          <h1><span class="text-blue text-uppercase"><?php echo $cv_data['full_name']; ?></span></h1>
           <h4> <?php echo $cv_data['date_of_birth']; ?></h4>
		   <h4><?php echo $cv_data['nationality']; ?></h4>

          <ul class="infos">
            <li><i class="icon fas fa-at text-blue"></i> <a href=<?php echo $cv_data['email']; ?>><?php echo $cv_data['email']; ?></a></li>
            <li><i class="icon fas fa-phone text-blue"></i><?php echo $cv_data['phone_number']; ?> </li>
            <li><i class="icon fas fa-map-marker-alt text-blue"></i> <?php echo $cv_data['address']; ?></li>
          </ul>
        </div>
				 <div class="content">
          <div class="section">
            <h2>professional<br><span class="text-blue">experiences</span></h2>
            <p>
              <strong> <?php echo $cv_data['employment_period']; ?></strong><br>
              <br>
			  <?php echo $cv_data['job_title']; ?> chez <?php echo $cv_data['company_name']; ?> <br>
			  
            
            <div class="icon fas fa-map-marker-alt text-blue"></div> <?php echo $cv_data['location']; ?>
			  
            </p>
           
			   <h3>Responsibilities and Achievements</h3>
              <?php echo $cv_data['responsibilities']; ?>
             
            
          </div>
      <div class="section">
            <h2>Études <br><span class="text-blue">& formations</span></h2>
            <p>
                 <strong> <?php echo $cv_data['graduation_year']; ?></strong>
              <em><?php echo $cv_data['degree']; ?>  en  <?php echo $cv_data['study_field']; ?></em>  chez  <?php echo $cv_data['institution_name']; ?>
            </p>
            <p>
              <strong><?php echo $cv_data['date_obtained']; ?></strong>
              <em><?php echo $cv_data['certification_name']; ?>  en  <?php echo $cv_data['issuing_organization']; ?></em>
            </p>
          </div>
					
					
		<?php
        } else {
            echo "No CV found with the provided ID.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No ID provided.";
}
?>	
            

</body>
</html>
