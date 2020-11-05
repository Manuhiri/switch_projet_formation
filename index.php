<?php $title = 'SWITCH';
        $lien ='';
    require_once "inc/header.inc.php"; ?>

<?php

if( adminConnect() ){ //si on est connecté et que l'on est admin, on affiche un titre 'admnistrateur'
	$content .= '<h2 class="col-12 bg-danger text-white text-center p-4 my-2">ADMINISTRATEUR</h2>';
}

//-----------------------------------------------------------
//debug( $_SESSION );

?>

<section id="accueil">
    <div>
        <?=$errorCon;?>
        <?=$errorIns;?>
    </div>
    
 <?php if( userConnect() ) : ?>
    <?= $content;?>
    <h1>Bonjour <?php echo $_SESSION['membre']['pseudo'];?></h1>

    <div class="intro">
        <p>Vous êtes connecté en tant que <?php echo $_SESSION['membre']['nom'];?> <?php echo $_SESSION['membre']['prenom'];?></p>
    
        <p>l'adresse mail lier à votre compte est : <?php echo $_SESSION['membre']['email'];?></p>
    </div>


 <?php else : ?>
    <h1>Bonjour</h1>

 <?php endif; ?>    
</section>

<section class="row">
    <div class="col-12 d-flex justify-content-around">
     <?php
        if( isset ( $_GET['categorie'] ) || isset ( $_GET['ville'] ) || isset ( $_GET['capacite'] )  || isset ( $_GET['prix'] ) || isset ( $_GE['dateEntree'] ) || isset ( $_GET['dateSortie'] )){
            $categorie = $_GET['categorie'];
            $ville = $_GET['ville'];
            $capacite = $_GET['capacite'];
            $prix = $_GET['prix'];
            $dateEntree = $_GET['dateEntree'];
            $dateSortie = $_GET['dateSortie'];
        }else{
            $categorie = '';
            $ville = '';
            $capacite = '';
            $prix = '';
            $dateEntree = '';
            $dateSortie = '';
        }
        //debug( $categorie );
        //debug( $ville );
        //debug( $capacite );
        //debug( $prix );
        //debug( $dateEntree );
        //debug( $dateSortie );
     ?>
        <p id="categorie"><?php echo $categorie;?> </p>
        <p id="ville"> <?php echo $ville;?> </p>
        <p id="capacite"> <?php echo $capacite;?> </p>
        <p id="prix"> <?php echo $prix;?> </p>
        <p id="dateEntree"> <?php echo $dateEntree;?> </p>
        <p id="dateSortie"> <?php echo $dateSortie;?> </p>
    </div>
    <!-- Selection -->
    <aside class="col-md-3">
     <!-- Recuperer les valeur de l'url les faire passer en js, pour les reinjecter dans l'url selon les choix -->    


     <!-- Affichage des Catégories-->
        <div class="col-12">
            <h2>Catégorie</h2>
            <?php
                $r = execute_requete(" SELECT DISTINCT(categorie) FROM switch_salle ");
                while( $categorie = $r->fetch(PDO::FETCH_ASSOC) ){
            ?>
                <div class="list-group-item">
                    <a href=" ?categorie=<?= $categorie['categorie'] ?> &ville=<?= $ville?> &capacite=<?= $capacite ?> & prix=<?= $prix ?> & dateEntree=<?= $dateEntree ?> & dateSortie=<?= $dateSortie ?>">
                        <?php echo $categorie['categorie']?>
                    </a>
                </div>
            <?php } ?>
        </div>

     <!-- Affichage des villes --> 
        <div class="col-12">
            <h2>Ville</h2>
            <?php
                $r = execute_requete(" SELECT DISTINCT(ville) FROM switch_salle ");
                while( $ville = $r->fetch(PDO::FETCH_ASSOC) ){
 
                    if( isset ( $_GET['categorie'] ) && isset ( $_GET['capacite'] ) ){
                        $categorie = $_GET['categorie'];
                        $capacite = $_GET['capacite'];
                        $prix = $_GET['prix'];
                        $dateEntree = $_GET['dateEntree'];
                        $dateSortie = $_GET['dateSortie'];
                    }else{
                        $categorie = '';
                        $capacite = '';
                        $prix = '';
                        $dateEntree = '';
                        $dateSortie = '';
                    }
                //debug( $ville );
            ?>
                <div class="list-group-item">
                    <a href="?categorie=<?= $categorie ?> &ville=<?= $ville['ville'] ?> &capacite=<?= $capacite ?> & prix=<?= $prix ?> & dateEntree=<?= $dateEntree ?> & dateSortie=<?= $dateSortie ?>">
                        <?php echo $ville['ville']?>
                    </a>
                </div>
            <?php } ?>
        </div>

     <!-- Capacité -->
     <div  class="col-12">
        <form id="capacites">
            <h2>Capacité</h2>
                <select class="custom-select mr-sm-2 col-7" name="capacite" id="selectCapacite">
                    <option>Choix</option>
                    <?php
                        $r = execute_requete(" SELECT DISTINCT(capacite) 
                                                FROM switch_salle 
                                                WHERE categorie = '$_GET[categorie]' && ville = '$_GET[ville]' ");
                         while( $capacite = $r->fetch(PDO::FETCH_ASSOC) ){
                     ?>
                    
                        <option value="<?php echo $capacite['capacite']?>"> <?php echo $capacite['capacite']?> </option>
                     <?php    //debug ($capacite); 
                    } ?>
                </select>    
            <button type="submit" class="btn btn-primary"><i class="fas fa-check text-white"></i></button>
        </form>
     </div>

     <!-- Prix -->
        <form class="pri col-12">
            <h2>Prix </h2>
            <p>Moin de <span id="demo"></span> </p>
            <div class="d-flex">
                <input type="range" min="0" max="5000" step="100" value="2500" class="slider w-75" id="myRange">

                <button type="submit" class="btn btn-primary"><i class="fas fa-check text-white"></i></button>

            </div>
        </form>

     <!-- Date Arrivee -->
        <form id="dateArrivee">
         <h2 class="col-12" >Date Arrivee</h2>
            <select class="custom-select mr-sm-2 col-8" name="dateEntree" id="selectDateArrivee">
                <option>Choix</option>
                 <?php
                    $r = execute_requete(" SELECT DISTINCT(date_arrivee) 
                                            FROM switch_produit 
                                            WHERE etat = 'libre'");

                        while( $dateEntree = $r->fetch(PDO::FETCH_ASSOC) ){
                            echo "<option value=", $dateEntree['date_arrivee']," \">", $dateEntree['date_arrivee'], "</option>";
                            //debug ($capacite); 
                        } 
                    ?>
            </select>

            <button type="submit" class="btn btn-primary"><i class="fas fa-check text-white"></i></button>
        </form>

     <!-- Date Depart -->
        <form id="dateDeparts">
        <h2 class="col-12">Date Sortie</h2>
            <select class="custom-select mr-sm-2 col-8" name="dateDepart" id="selectDateDeparts">
                    <option>Choix</option>
                 <?php
                    $r = execute_requete(" SELECT DISTINCT(date_depart) 
                                            FROM switch_produit 
                                            WHERE etat = 'libre' && date_arrivee = '$_GET[dateEntree]' ");

                            while( $dateDepart = $r->fetch(PDO::FETCH_ASSOC) ){
                            echo "<option value=", $dateDepart['date_depart']," \">", $dateDepart['date_depart'], "</option>";
                        } 
                    ?>
            </select>

            <button type="submit" class="btn btn-primary"><i class="fas fa-check text-white"></i></button>
        </form>






    </aside>

    <!-- Affichage -->
    <section class="row col-md-9">
        <!-- Fonction Php et liaison avec la bdd -->
        <?php
            //debug ($_GET);
            if ( !empty ( $_GET ) ):
     
            $r = execute_requete(" SELECT s.*,p.id_produit, p.prix, p.date_arrivee, p.date_depart 
                FROM switch_salle as s, switch_produit as p
                WHERE p.id_salle = s.id_salle && categorie = '$_GET[categorie]' && ville = '$_GET[ville]' ");
            //debug ($r);

            while( $salle = $r->fetch(PDO::FETCH_ASSOC) ){
                //debug ($salle);
         ?>

            <div class="col-md-6 col-lg-4">
                <div class="card ">
                    <!-- Photo -->
                    <?php echo $photo = "<img src='$salle[photo]' class='w-100' alt='$salle[titre]'>"; ?>

                    <!-- Titre, Prix et descriptif -->
                    <div class="card-body p-0">
                    
                        <div class=" d-flex justify-content-between text-white bg-primary p-3">
                            <h5 class="card-title m-0 "> 
                                <?php echo $salle['titre'];?>
                            </h5>
                            <p class="m-0">
                                <?php echo $salle['prix'];?>
                            </p>
                        </div>

                        <!-- Descriptif -->
                        <p class="card-text py-3">
                            <?php echo $salle['description'];?>
                         </p>

                         <div class="text-secondary d-flex justify-content-between">
                            <p>
                                <?php echo $salle['date_arrivee'];?>
                            </p>
                            <p class="text-right">
                                <?php echo $salle['date_depart'];?>
                            </p>
                        </div>
                    </div>
                
                    <!-- Date -->
                    <div class="card-footer">
                        <small class="text-muted d-flex justify-content-between">
                        <p>
                            Avis
                        </p>

                        <p>
                            <a href="fiche_produit.php?id_produit=<?php echo $salle['id_produit'];?>">
                                Fiche produits
                            </a>
                        </p>
                        </small>
                    </div>
                </div>
            </div>
    
    <?php } endif;?>
    </section>
</section>









































<?php require_once "inc/footer.inc.php"; ?>	