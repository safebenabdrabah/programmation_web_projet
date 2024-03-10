<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>template 3</title>

    <link rel="shortcut icon" href="assets/images/fav.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<?php
        require("connect.php");
        
        // Récupérer les données de l'utilisateur depuis la base de données en utilisant l'identifiant fourni et les afficher ici
        $id = $_GET['id'];
        $sql = "SELECT * FROM cv_data WHERE id_utilisateur= :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $cv_data = $stmt->fetch(PDO::FETCH_ASSOC);
		
$imageFileName = $cv_data['profile_pic'];

// Assurez-vous que le nom du fichier de l'image est défini et non vide
if (!empty($imageFileName)) {
    // Affichez l'image en utilisant le nom du fichier dans la balise <img>
} else {
    // Si le nom du fichier de l'image est vide, affichez un message alternatif
    echo 'Image non disponible';
}

        ?>
		
		    <div class="container-fluid overcover">
        <div class="container profile-box">
            <div class="row">
                <div class="col-md-4 left-co">
                    <div class="left-side">
                        <div class="profile-info">
                        <img src="<?php echo $cv_data['profile_pic']; ?>" alt="Profile Picture" width="150" height="150">
                            <h3><strong><?php echo $cv_data['full_name']; ?></strong></h3>
                            <span><?php echo $cv_data['job_title']; ?></span>
                        </div>
                        <h4 class="ltitle">Contact</h4>
                        <div class="contact-box pb0">
                            <div class="icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail">
                                <?php echo $cv_data['phone_number']; ?> <br>
                            </div>
                        </div>
                        <div class="contact-box pb0">
                            <div class="icon">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            <div class="detail">
                                <?php echo $cv_data['email']; ?><br>
                                
                            </div>
                        </div>
                        <div class="contact-box">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail">
                                <?php echo $cv_data['address']; ?>
                            </div>
                        </div>
                   
                        <h4 class="ltitle">languages</h4>

                        <div class="refer-cov">
                            <b><?php echo $cv_data['languages']; ?></b>
                            
                        </div>
                      
                       
                        <h4 class="ltitle">proficiency_level</h4>
                        <p>
                        <?php echo $cv_data['proficiency_level']; ?>
                        </p>
                    </div>
                </div>
				 <div class="col-md-8 rt-div">
                    <div class="rit-cover">
                        <div class="hotkey">
                            <h1 class=""><?php echo $cv_data['full_name']; ?></h1>
                            
                        </div>
                        <h1 class="rit-titl"><i class="far fa-user"></i> Profile</h1>
                        <div class="about" style="word-wrap: break-word;">
                            <p> <?php echo $cv_data['professional_summary']; ?></p>
                            
                        </div>
                  
                        <h1 class="rit-titl"><i class="fas fa-briefcase"></i> Work Experience</h1>
						<div>
                        <p>
              <strong> <?php echo $cv_data['employment_period']; ?></strong>
              <br>
			  <?php echo $cv_data['job_title']; ?> chez <?php echo $cv_data['company_name']; ?>
			  <ul class="infos2">
            
            <li><i class="icon fas fa-map-marker-alt text-blue"></i> <?php echo $cv_data['location']; ?></li><br>
          </ul>
			  
            </p>
            <ul class="experience-list" style="word-wrap: break-word;">
			   <h6><strong>Responsibilities and Achievements</strong></h6>
               
              <li><?php echo $cv_data['responsibilities']; ?></li>
             
            </ul>
          </div>
                         
                        
                        <h2 class="rit-titl"><i class="fas fa-graduation-cap"></i> Education</h2>
						<div class="educ">
                            <p>
                 <strong> <?php echo $cv_data['graduation_year']; ?></strong>
              <em><?php echo $cv_data['degree']; ?> en <?php echo $cv_data['study_field']; ?></em>, <?php echo $cv_data['institution_name']; ?>
            </p>
            <p>
              <strong><?php echo $cv_data['date_obtained']; ?></strong>
              <em><?php echo $cv_data['certification_name']; ?> en <?php echo $cv_data['issuing_organization']; ?></em>
            </p>
          </div>
          <h1 class="rit-titl"><i class="fas fa-users-cog"></i> Skills</h1>
                         <h6><strong>technical skills</strong></h6>
          <ul class="skills">
            <li><i class="icon fas fa-check-circle text-darkblue"></i> <strong> <?php echo $cv_data['technical_skills']; ?></strong></li>
            <br><br>
			<h6><strong>soft skills</strong></h6>
          <ul class="skills">
            <li><i class="icon fas fa-check-circle text-darkblue"></i> <strong> <?php echo $cv_data['soft_skills']; ?></strong></li>
			
          </ul>
		  
		 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</body>

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>


</html>