<?php   $title = 'Gestion des salles';
        $lien ='../';
    require_once "../inc/header.inc.php"; 
?>
<?php
//Restreindre l'accès à cette page Admin uniquement
if (!adminConnect() ){
	redirige('../index.php');
    exit();
}

//--------------------------------------------
//SUPPRESSION :
if( isset($_GET['action']) && $_GET['action'] == 'suppression' ){
    
    $r = execute_requete(" SELECT * FROM switch_salle WHERE id_salle = '$_GET[id_salle]' ");
    
    $article_a_supprimer = $r->fetch( PDO::FETCH_ASSOC );
    
    $chemin_photo_a_supprimer = str_replace( "http://switch.manuhiri-anihia.fr/", $_SERVER['DOCUMENT_ROOT'], $article_a_supprimer['photo'] );
    
    if( !empty( $chemin_photo_a_supprimer ) && file_exists( $chemin_photo_a_supprimer ) ){

		unlink( $chemin_photo_a_supprimer );

    }
    
    execute_requete(" DELETE FROM switch_salle WHERE id_salle='$_GET[id_salle]' ");
    
    //redirection vers l'affichage
	//header("location:gestion_boutique.php?action=affichage");


}

//-------------------------------------------
//INSERTION
if( !empty( $_POST) ){

    foreach ($_POST as $key => $value) { 
        $_POST[$key] = htmlentities( addslashes( $value ) );
	}

    if( isset( $_GET['action']) && $_GET['action'] == 'modification' ){
        $photo_bdd = $_POST['photo_actuelle'];
    }
    //debug($_POST);
    //debug($_FILES);
    //debug($_SERVER);

    if ( !empty($_FILES['photo']['name'] ) ){
            $nom_photo =$_POST['titre'] . '_' 	. $_FILES['photo']['name'];

            $photo_bdd = URL . "photo/$nom_photo";

            $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . "/photo/$nom_photo";

            copy( $_FILES['photo']['tmp_name'], $photo_dossier );
    }
    //debug ($photo_dossier);

    if( isset($_GET['action']) && $_GET['action'] == 'modification' ){
		execute_requete(" UPDATE switch_salle SET 
							titre = '$_POST[titre]',
							description = '$_POST[description]',
							photo = '$photo_bdd',
							pays = '$_POST[pays]',
							ville = '$_POST[ville]',
							adresse = '$_POST[adresse]',
							cp = '$_POST[cp]',
							capacite = '$_POST[capacite]',
							categorie = '$_POST[categorie]'

							WHERE id_salle = '$_GET[id_salle]'
						");
	    redirige('gestion_salle.php');
    }
    else{
		//Insertion nouveau produit :
		execute_requete(" INSERT INTO switch_salle(titre, description, photo, pays, ville, adresse, cp, capacite, categorie) 
					VALUES( '$_POST[titre]', '$_POST[description]', '$photo_bdd', '$_POST[pays]', '$_POST[ville]', '$_POST[adresse]', '$_POST[cp]', '$_POST[capacite]', '$_POST[categorie]'
					) ");
	    redirige('gestion_salle.php');
    }

}

//-------------------------------------------
//AFFICHAGE DES SALLES
if( isset( $_GET['action'] ) && $_GET['action'] == 'affichage' ){
    $r = execute_requete("SELECT * FROM switch_salle");

    $content.='<h2> Affichage des '. $r->rowCount() .' salles</h2>';

    $content .= '<Table border="1" ceelpadding="5">';
    
        //En tête tableau
        $content .= '<tr class="table-primary">';
            for ($i=0; $i < $r->columnCount(); $i++){
                $colonne = $r->getColumnMeta( $i );
                $content.="<th>$colonne[name]</th>";
            }

            $content.= "<th>Supression</th>";
            $content.= "<th>Modification</th>";

        $content .='</tr>';

        //Corps du tableau
        while ( $ligne = $r->fetch( PDO::FETCH_ASSOC) ) {
            $content .= '<tr>';

                foreach ($ligne as $index => $valeur){
                    if($index == 'photo'){
                        $content .="<td>
                                    <img src='$valeur'width='80'>
                                </td>";
                     }
                     else{

                        $content.="<td>$valeur</td>";

                    }    
                }
		        $content .= '<td> 
			                    <a href="?action=suppression&id_salle='.$ligne['id_salle'].'"  onclick="return( confirm(\'Es tu certain ?\') )" > 
				                    <i class="fas fa-trash-alt"></i>
			                    </a> 
			                </td>';
		        $content .= "<td> 
			                    <a href='?action=modification&id_salle=$ligne[id_salle]'> 
				                    <i class='fas fa-edit'></i>
			                    </a> 
					        </td>";
            $content .='</tr>';
        }
    $content .= '</table>';
}

?>

<h1>Gestion des salles</h1>

<section id="accueil" class="row justify-content-center">
<div class="test"></div>
    <div class="btn btn-outline-light bg-secondary m-2 my-sm-0" type="submit">
        <a href="?action=affichage" class="text-white">
            <i class="fas fa-search text-white"></i> Affichage des salles
        </a>
    </div>

    <div class="btn btn-outline-light bg-secondary m-2 my-sm-0" type="submit">
        <a href="?action=ajout" class="text-white">
            <i class="fas fa-plus-circle text-white"></i> Ajout d'une salle
        </a>
    </div>
</section>

<!-- Affichage du tableau php -->
<?= $content; ?>


<?php 
    //debug($_GET);
    if( isset( $_GET['action'] ) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification') ) :
        if( !isset( $_GET['id_salle'] ) ){
            
            $id_salle='';

        }else{
            $r = execute_requete(" SELECT * FROM switch_salle WHERE id_salle = '$_GET[id_salle]' ");
            $article_actuel = $r->fetch(PDO::FETCH_ASSOC);
            //debug($article_actuel);
        }
        
	    $titre = ( isset($article_actuel['titre']) ) ? $article_actuel['titre'] : '';
	    $description = ( isset($article_actuel['description']) ) ? $article_actuel['description'] : '';
	    $pays = ( isset($article_actuel['pays']) ) ? $article_actuel['pays'] : '';
	    $ville = ( isset($article_actuel['ville']) ) ? $article_actuel['ville'] : '';
	    $adresse = ( isset($article_actuel['adresse']) ) ? $article_actuel['adresse'] : '';
	    $cp = ( isset($article_actuel['cp']) ) ? $article_actuel['cp'] : '';
	    $capacite = ( isset($article_actuel['capacite']) ) ? $article_actuel['capacite'] : '';
        $reunion = ( isset($article_actuel['categorie']) &&  $article_actuel['categorie'] == 'reunion') ? 'selected' : '';
        $bureau = ( isset($article_actuel['categorie']) &&  $article_actuel['categorie'] == 'bureau') ? 'selected' : '';
        $formation = ( isset($article_actuel['categorie']) &&  $article_actuel['categorie'] == 'formation') ? 'selected' : '';


 ?>

 <!-- Formulaire -->
    <form method="post" enctype="multipart/form-data" class="row">	
        <!-- Photo -->
        <div class="col-3">
            <div class="my-1">
                <label for="photo">Photo</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-camera"></i></div>
                    </div>
                    <input type="file" class="form-control col-12" name="photo" id="photo">

                    <?php if( isset($article_actuel) ) { //
                     //debug($article_actuel);?>
			            <i>Vous pouvez uploader une nouvelle photo</i>
                        <img src="<?=$article_actuel['photo']?>" class="w-50">
                        <input type="hidden" class="form-control" name="photo_actuelle" value="<?=$article_actuel['photo']?>">
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="col-9 row">
            <!-- Titre -->
             <div class="col-sm-3 my-1">
        	    <label for="titre">Titre</label>
        	    <div class="input-group">
            	    <div class="input-group-prepend">
                	    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
             	    </div>
                    <input type="text" class="form-control" name="titre" id="titre" value="<?=$titre ?>">
                </div> 
             </div>
            <!-- Description -->
             <div class="col-sm-3 my-1">
        	    <label for="description">Description</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-align-justify"></i></div>
                    </div>
                    <input type="text" class="form-control" name="description" id="description" value="<?=$description ?>">
                </div>
             </div>	
            <!-- Pays -->
             <div class="col-sm-3 my-1">
	    	    <label for="pays">Pays</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-atlas"></i></div>
                    </div>
	                <input type="text" class="form-control" name="pays" id="pays" value="<?=$pays ?>">
                </div>
             </div>	
            <!-- Ville -->
             <div class="col-sm-3 my-1">
	    	    <label for="ville">Ville</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="far fa-building"></i></div>
                    </div>
	                <input type="text" class="form-control" name="ville" id="ville" value="<?=$ville ?>">
                </div>
             </div>	
            <!-- Adresse -->
             <div class="col-sm-3 my-1">
	    	    <label for="adresse">Adresse</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-bullseye"></i></div>
                    </div>
	                <input type="text" class="form-control" name="adresse" id="adresse" value="<?=$adresse ?>">
                </div>
             </div>
            <!-- CP -->
             <div class="col-sm-3 my-1">
	    	    <label for="cp">Code Postal</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="far fa-circle"></i></div>
                    </div>
	                <input type="text" class="form-control" name="cp" id="cp" value="<?=$cp ?>">
                </div>
             </div>
            <!-- Capacite  -->
             <div class="col-sm-3 my-1">
	    	    <label for="capacite">Capacite</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-box"></i></div>
                    </div>
	                <input type="text" class="form-control" name="capacite" id="capacite" value="<?=$capacite ?>">
                </div>
             </div>
		    <!-- Categorie -->
		     <div class="col-sm-2 my-1">
	            <label for="categorie" class="mr-sm-2">Categorie</label>
                <select class="custom-select mr-sm-2" name="categorie" id="categorie">
                    <option value="reunion" <?= ($reunion) ?> >Réunion</option>
                    <option value="bureau" <?= ($bureau) ?> >Bureau</option>
                    <option value="formation" <?= ($formation) ?> >Formation</option>
                </select>
             </div>
            <!-- Bouton -->
             <div class="col-12 my-3">
	            <input type="submit" value="Enregistrer" class="btn btn-primary">
             </div>
        </div>

    </form>
<?php endif;?>

   
<?php require_once "../inc/footer.inc.php"; ?>