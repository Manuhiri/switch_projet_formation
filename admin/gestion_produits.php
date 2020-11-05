<?php   $title = 'Gestion des produits';
        $lien ='../';
    require_once "../inc/header.inc.php"; ?>
<?php
//ADMIN UNIQUEMENT
if (!adminConnect() ){
	redirige('../index.php');
    exit();
}

//--------------------------------------------
//SUPPRESSION :
if( isset($_GET['action']) && $_GET['action'] == 'suppression' ){

    $r = execute_requete(" SELECT * FROM switch_produit WHERE id_produit = '$_GET[id_produit]' ");
        
	$article_a_supprimer = $r->fetch( PDO::FETCH_ASSOC );
        
	execute_requete(" DELETE FROM switch_produit WHERE id_produit='$_GET[id_produit]' ");

	//redirection vers l'affichage
	//header("location:gestion_des_produits.php?action=affichage");
}
//debug( $article_a_supprimer );
//debug( $_SERVER );
 
    
//--------------------------------------------
//INSERTION :
if(!empty($_POST)){ //Formulaire est remplis et validé

    foreach($_POST as $key => $value){

        $_POST[$key] = htmlentities(addslashes($value));

    }
    //debug($_POST);
    //debug($_SERVER);

    if( isset($_GET['action']) && $_GET['action'] == 'modification' ){
        execute_requete(" UPDATE switch_produit SET 
            
            date_arrivee = '$_POST[date_arrivee]', 
            date_depart = '$_POST[date_depart]',
            id_salle = '$_POST[id_salle]',
            prix = '$_POST[prix]'
                                
    
            WHERE id_produit = '$_GET[id_produit]'
        ");

            //redirection vers l'affichage :
            //header('location:gestion_des_produits.php?action=affichage')
    }
    else{
        execute_requete("INSERT INTO switch_produit(date_arrivee,date_depart,id_salle,prix) VALUES('$_POST[date_arrivee]','$_POST[date_depart]','$_POST[id_salle]','$_POST[prix]') ");

        //redirection vers l'affichage :
        //header('location:gestion_des_produits.php?action=affichage');
    }
}

//-------------------------------------------
//AFFICHAGE DES PRODUITS
if( isset( $_GET['action'] ) && $_GET['action'] == 'affichage' ){
    $r = execute_requete("SELECT  s.photo, s.titre, p.*
                            FROM switch_produit as p, switch_salle as s
                            WHERE p.id_salle = s.id_salle
                        ");

    $content.='<h2> Affichage des '. $r->rowCount() .' produits</h2>';

    $content .= '<Table border="1" ceelpadding="5">';
    
        //En tête tableau
        $content .= '<tr class="table-primary">';
            for( $i=0;$i < $r-> columnCount();$i++){
                $colonne = $r->getColumnMeta($i);
                    //debug($colonne);
                if($colonne['name'] !=='titre' && $colonne['name'] !=='photo'){
                    
                    $colonne = $r->getColumnMeta($i);
                    //debug($colonne);

                    $content .="<th>$colonne[name]</th>";
                }
            }
            $content.= "<th>Supression</th>";
            $content.= "<th>Modification</th>";

        $content .='</tr>';

        //Corps du tableau
        while ( $ligne = $r->fetch( PDO::FETCH_ASSOC) ) {
            $content .= '<tr>';
                
                foreach($ligne as $key => $value){
                    if($key!=='titre' && $key !=='photo'){
                        if($key !== 'id_salle'){
                            $euros='';
                            if($key == 'prix'){$euros='&euro;';}
                            $content .='<td>'.$value.$euros.'</td>';
                       
                         }
                         elseif($key == 'id_salle'){

                            $content .= '<td class="col-2">'.$ligne['id_salle'].' - '.$ligne['titre'] .'<br> <img src="'.$ligne['photo'].'" class="w-25"></td>';

                        }
                    }
                }
		        $content .= '<td  class="text-center"> 
			                    <a href="?action=suppression&id_produit='.$ligne['id_produit'].'"  onclick="return( confirm(\'Es tu certain ?\') )" > 
				                    <i class="fas fa-trash-alt"></i>
			                    </a> 
			                </td>';
                $content .= '<td  class="text-center"> 
			                    <a href="?action=modification&id_produit='.$ligne['id_produit'].'"> 
				                    <i class="fas fa-edit"></i>
			                    </a> 
					        </td>';
            $content .='</tr>';
        }
    $content .= '</table>';
}

?>


<h1>Gestion des produits</h1>

<section class="row justify-content-center">

    <div class="btn btn-outline-light bg-secondary m-2 my-sm-0 index" type="submit">
        <a href="?action=affichage" class="text-white">
            <i class="fas fa-search text-white"></i> Affichage des produits
        </a>
    </div>

    <div class="btn btn-outline-light bg-secondary m-2 my-sm-0 index" type="submit">
        <a href="?action=ajout" class="text-white">
            <i class="fas fa-plus-circle text-white"></i> Ajout un produit
        </a>
    </div>
</section>

<!-- Affichage du tableau php -->
<?= $content; ?>


<?php 
    if(isset($_GET['action'])&& ($_GET['action']=='ajout'|| $_GET['action'] == 'modification')) : 
        if( isset( $_GET['id_produit'] ) ){
            $r = execute_requete(" SELECT * FROM switch_produit WHERE id_produit = '$_GET[id_produit]' ");
    
            $produit_actuel = $r->fetch(PDO::FETCH_ASSOC);
            //debug( $produit_actuel );
        }

        $choixSalle = ( isset($produit_actuel['id_salle']) ) ? $produit_actuel['id_salle'] : '';
        $date_arrivee = ( isset($produit_actuel['date_arrivee']) ) ? $produit_actuel['date_arrivee'] : '';
        $date_depart = ( isset($produit_actuel['date_depart']) ) ? $produit_actuel['date_depart'] : '';
        $prix = ( isset($produit_actuel['prix']) ) ? $produit_actuel['prix'] : '';

        //si le produit actuel id_salle est present alors j'execute le $produit_actuel, sinons non (vide)
?>


 <!-- Formulaire -->
    <form method="post" enctype="multipart/form-data" class="row">
        <div class="col-9 row">
            <!-- Salle -->
		     <div class="col-12 my-1">
	            <label for="salle" class="mr-sm-2">Salle</label>
                <select class="custom-select mr-sm-2" id="id_salle" name="id_salle">
                    <?php
                        $r = execute_requete(" SELECT * FROM switch_salle");
        
                        while( $ligne_salle = $r->fetch( PDO::FETCH_ASSOC ) ){

                            if( $choixSalle == $ligne_salle['id_salle'] ){ 
                                $select = 'selected'; 
                             } else{ 
                                $select = ''; 
                            }

                            echo'<option value="'.$ligne_salle['id_salle'].'" '. $select  .'>';
                            foreach($ligne_salle as $key => $value){
                                if( $key !== 'photo' && $key !== 'description'){ 

                                    if($key == 'categorie'){
                                    echo "$value";
                                     } else{
                                        echo "$value - ";
                                    }
                                }
                            }
                            echo'</option>';
                        }
                    ?>      
                </select>
             </div>
            <!-- Date Arrivée -->
             <div class="col-sm-3 my-1">
        	    <label for="date_arrivee">Date Arrivee</label>
        	    <div class="input-group">
            	    <div class="input-group-prepend">
                	    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
             	    </div>
                    <input type="date" class="form-control" name="date_arrivee" id="date_arrivee" value="<?=$date_arrivee ?>">
                </div> 
             </div>
            <!-- Date Départ -->
             <div class="col-sm-3 my-1">
        	    <label for="date_depart">Date Départ</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-align-justify"></i></div>
                    </div>
                    <input type="date" class="form-control" name="date_depart" id="date_depart" value="<?=$date_depart ?>">
                </div>
             </div>	
            <!-- Prix -->
             <div class="col-sm-3 my-1">
	    	    <label for="prix">Prix</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-atlas"></i></div>
                    </div>
	                <input type="text" class="form-control" name="prix" id="prix" value="<?= $prix ?>">
                </div>
             </div>		
            <!-- bouton -->
             <div class="col-12 my-3">
	            <input type="submit" value="Enregistrer" class="btn btn-primary">
             </div>
        </div>
    </form>
<?php endif;?>  
<?php require_once "../inc/footer.inc.php"; ?>