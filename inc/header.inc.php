<?php require_once "init.inc.php"; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
  <!-- Meta description -->
    <meta name="description" content=" A faire ">
    
  <!-- Title -->
    <title>
      <?php echo !empty($title) ? $title : 'Switch'; ?>
    </title>

  <!--Fave icon -->
    <link rel="icon" type="image/png" href="img/logo/logo_min.png">

  <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <!-- Google Font -->
    <!-- Body -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300;700&display=swap" rel="stylesheet">
    <!-- Title -->
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Header -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    
  <!-- CSS -->
    <link rel="stylesheet" href="<?php echo !empty($lien) ? $lien : ''; ?>asset/css/style.css">
    <link rel="stylesheet" href="<?php echo !empty($lien) ? $lien : ''; ?>asset/css/styles.css">

  <!-- animate CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    
  <!-- Jquery-ui 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
    
  <!-- Script jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Script -->
    <script src="<?php echo !empty($lien) ? $lien : ''; ?>asset/js/script.js"></script>


</head>

<body>
  <canvas></canvas>
  
  <header id="header" class="container-fluid d-flex">
    <section class="col-12 col-sm-6 col-lg-4 image">
      <figure>
        <img src="<?php echo !empty($lien) ? $lien : ''; ?>img/ville/lyon.jpg" alt="salle de formation" class="w-100">

        <div class="triangle_darkPurple"></div>
        <div class="triangle_lightOrange"></div>
        <div class="triangle_mediumOrange"></div>
        <div class="triangle_lightGreen"></div>

        <h2>Lyon</h2>

        <p><a href="#">Voir les salle <br>de Lyon</a></p>

      </figure>
    </section>
        
    <section class="col-12 col-sm-6 col-lg-4 image">
      <figure>
        <img src="<?php echo !empty($lien) ? $lien : ''; ?>img/ville/marseille.jpg" alt="salle de formation" class="w-100">
                
        <div class="triangle_darkPurple"></div>
        <div class="triangle_lightOrange"></div>
        <div class="triangle_mediumOrange"></div>
        <div class="triangle_lightGreen"></div>

        <h2 class="marseille">Marseille</h2>

        <p><a href="#">Voir les salle <br>de Marseille</a></p>

      </figure>
    </section>

    <section class="col-12 col-sm-6 col-lg-4 image">
      <figure>
        <img src="<?php echo !empty($lien) ? $lien : ''; ?>img/ville/paris.jpg" alt="salle de formation" class="w-100">

        <div class="triangle_darkPurple"></div>
        <div class="triangle_lightOrange"></div>
        <div class="triangle_mediumOrange"></div>
        <div class="triangle_lightGreen"></div>

        <h2>Paris</h2>

        <p><a href="#">Voir les salle <br>de Paris</a></p>

      </figure>
    </section>
  </header>
  
  <!-- Modal inscription -->
  <?php
    $require = $lien.'inc/modal_inscription.inc.php';
    require_once "$require"; 
  ?> 

  <!-- Modal connexion -->
  <?php
    $require = $lien.'inc/modal_connexion.inc.php';
    require_once "$require"; 
  ?>
  
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?= URL ?>index.php">
      <img src="<?php echo !empty($lien) ? $lien : ''; ?>img/logo/logo.png" alt="logo switch"  class="logo">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
          
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">         
        <?php if( userConnect() ) : ?>
          <li class="mx-2">
            <a href="<?= URL ?>profil.php">Profil</a>
          </li>
         <?php else : ?>
          <li class="mx-2" data-toggle="modal" data-target="#inscription">
            <a href="#">Inscription</a> 
          </li>
	      <?php endif; ?>
                
	      <?php if( adminConnect() ) : ?>
          <li class="mx-2 dropdown active">
            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Administrateur
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?= URL?>admin/gestion_membre.php">Gestion des membres</a>
              <a class="dropdown-item" href="<?= URL?>admin/gestion_salle.php">Gestion des salles</a>
              <a class="dropdown-item" href="<?= URL?>admin/gestion_produit.php">Gestion des produits</a>
            </div>
          </li>
        <?php endif; ?>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <?php if( userConnect() ) : ?>
          <div class="btn btn-outline-light my-2 my-sm-0" type="boutton" name="deconnexion">
            <a href="<?= URL ?>index.php?action=deconnexion">
              <i class="fas fa-user-lock"></i> Deconnexion
            </a>
          </div>
         <?php else : ?>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#connexion" value="connexion">
            <a href="#"><i class="fas fa-user-lock"></i> Connexion</a>
          </button>
        <?php endif; ?>
      </form>
    </div>
  </nav>

<main class="container-fluid">


    

