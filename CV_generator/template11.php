<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>template 1</title>
  
    <link href="css/font-awesome/css/all.min.css?ver=1.2.0" rel="stylesheet">
    <link href="css/bootstrap.min.css?ver=1.2.0" rel="stylesheet">
    <link href="css/aos.css?ver=1.2.0" rel="stylesheet">
    <link href="css/main.css?ver=1.2.0" rel="stylesheet">
	
    <noscript>
      <style type="text/css">
        [data-aos] {
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
      </style>
    </noscript>
  </head>
  <body id="top">     

<?php
// Récupérez le nom du fichier de l'image depuis la base de données
require("connect.php");

// Récupérer les données de l'utilisateur depuis la base de données en utilisant l'identifiant fourni et les afficher ici
$id = $_GET['id'];
$sql = "SELECT * FROM cv_data WHERE id_utilisateur= :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$cv_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérez le nom du fichier de l'image depuis la base de données
$imageFileName = $cv_data['profile_pic'];

// Assurez-vous que le nom du fichier de l'image est défini et non vide
if (!empty($imageFileName)) {
    // Affichez l'image en utilisant le nom du fichier dans la balise <img>
} else {
    // Si le nom du fichier de l'image est vide, affichez un message alternatif
    echo 'Image non disponible';
}





?>
    <header class="d-print-none">
      <div class="container text-center text-lg-left">
        <div class="py-3 clearfix">
          <h1 class="site-title mb-0"><?php echo $cv_data['full_name']; ?></h1>
          
        </div>
      </div>
    </header>
    <div class="page-content">
      <div class="container">
<div class="cover shadow-lg bg-white">
  <div class="cover-bg p-3 p-lg-4 text-white">
    <div class="row">
      <div class="col-lg-4 col-md-5">
	      <?php echo '<div class="avatar hover-effect bg-white shadow-sm p-1"><img src="' . $imageFileName . '" alt="Votre image" width="200" height="200"></div>';?>


      </div>
      <div class="col-lg-8 col-md-7 text-center text-md-start">
	     
        <h2 class="h1 mt-2" data-aos="fade-left" data-aos-delay="0"><?php echo $cv_data['full_name']; ?></h2>
        <p data-aos="fade-left" data-aos-delay="100"><?php echo $cv_data['job_title']; ?></p>



                                                     </div>      </div>
    </div>
  </div>
  <div class="about-section pt-4 px-3 px-lg-4 mt-1">
    <div class="row">
      <div class="col-md-6">
	  <br><br>
        <h2 class="h3 mb-3">About Me</h2>
		  <ul style="overflow-wrap: break-word; max-width: 400px;"> 
        <?php 
		    echo '<li>' . $cv_data['professional_summary'] . '</li>';
          
        ?>
        </ul>
      </div>
	        

      <div class="col-md-5 offset-md-1">
        <div class="row mt-2">
          <div class="col-sm-4">
            <div class="pb-1">date of birth</div>
          </div>
          <div class="col-sm-8">
            <div class="pb-1 text-secondary"><?php echo $cv_data['date_of_birth']; ?></div>
          </div>
          <div class="col-sm-4">
            <div class="pb-1">Email</div>
          </div>
          <div class="col-sm-8">
            <div class="pb-1 text-secondary"><?php echo $cv_data['email']; ?></div>
          </div>
          <div class="col-sm-4">
            <div class="pb-1">Phone</div>
          </div>
          <div class="col-sm-8">
            <div class="pb-1 text-secondary"><?php echo $cv_data['phone_number']; ?></div>
          </div>
          <div class="col-sm-4">
            <div class="pb-1">Address</div>
          </div>
          <div class="col-sm-8">
            <div class="pb-1 text-secondary"><?php echo $cv_data['address']; ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr class="d-print-none"/>
    <div class="work-experience-section px-3 px-lg-4">
  <h2 class="h3 mb-3">Professional Skills</h2>
<h5 style="color:#0077b6";>Technical Skills</h5>
<ul class="skills">
    <?php 
        $technicalSkills = explode("\n", $cv_data['technical_skills']);
        foreach ($technicalSkills as $skill) {
            echo '<i class="icon fas fa-check-circle text-darkblue"></i> <strong>' . $skill . '</strong>';
        }
    ?>
</ul>

<h5 style=" color : #0077b6";>Soft Skills</h5>
<ul class="skills">
    <?php 
        $softSkills = explode("\n", $cv_data['soft_skills']);
        foreach ($softSkills as $skill) {
            echo '<i class="icon fas fa-check-circle text-darkblue"></i> <strong>' . $skill . '</strong>';
        }
    ?>
</ul>

  <hr class="d-print-none"/>
  <div class="work-experience-section px-3 px-lg-4">
    <h2 class="h3 mb-4">Work Experience</h2>
    <p>
        <strong><?php echo $cv_data['employment_period']; ?></strong><br><br>
		 
        <?php 
		    echo  $cv_data['job_title'] ; ?>  chez  <?php echo  $cv_data['company_name']; ?><br><br>
		
       
       
            <i class="icon fas fa-map-marker-alt text-blue"></i> <?php echo $cv_data['location']; ?>
        
    </p>
   <h5 style="color:#0077b6;">Responsibilities and Achievements</h5>

    <ul class="experience-list">
        <?php 
            $responsibilities = explode("\n", $cv_data['responsibilities']);
            foreach ($responsibilities as $responsibility) {
                echo '<li>' . $responsibility . '</li>';
            }
        ?>
    </ul>
</div>

  <hr class="d-print-none"/>
  <div class="page-break"></div>
  <div class="education-section px-3 px-lg-4 pb-4">
    <h2 class="h3 mb-4">Education</h2>
    <div class="timeline">
      <div class="timeline-card timeline-card-success card shadow-sm">
        <div class="card-body">
          <div class="h5 mb-1">    
		  <p>
                 <strong> <?php echo $cv_data['graduation_year']; ?></strong>
              <em><?php echo $cv_data['degree']; ?> en <?php echo $cv_data['study_field']; ?></em>, <?php echo $cv_data['institution_name']; ?>
            </p>
            <p>
              <strong><?php echo $cv_data['date_obtained']; ?></strong>
              <em><?php echo $cv_data['certification_name']; ?> en <?php echo $cv_data['issuing_organization']; ?></em>
            </p><span class="text-muted h6"></span></div>
          
          
        </div>
      </div>
      
  </div>
  
        </div>
      </div>
	  </div>
    <script src="scripts/aos.js?ver=1.2.0"></script>
    <script src="scripts/main.js?ver=1.2.0"></script>
  </body>
</html>