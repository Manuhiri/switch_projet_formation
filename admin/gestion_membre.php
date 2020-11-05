<?php $title = 'Gestion des membres';
        $lien ='../';
    require_once "../inc/header.inc.php"; ?>
<?php
//Admin uniquement
if (!adminConnect() ){
	redirige('../index.php');
    exit();
}
//-------------------------------------------------------------------------
//SUPPRESSION :
if( isset($_GET['action']) && $_GET['action'] == "suppression" ){ 

	execute_requete(" DELETE FROM switch_membre WHERE id_membre = '$_GET[id_membre]' ");

}
//-------------------------------------------------------------------------
$r = execute_requete(" SELECT * FROM switch_membre ");

$content .= '<h2>Affichage des ' . $r->rowCount() . ' membres</h2>';

$content .= '<table border="1" cellpadding="5">';

	//En-tête tableau
	$content .= '<tr class="table-primary">';
		for($i=0; $i < $r->columnCount(); $i++){

			$colonne = $r->getColumnMeta( $i );

			if( $colonne['name'] != 'mdp'){

				$content .= "<th>$colonne[name]</th>";
			}
		}
		$content .= "<th>suppression</th>";
		$content .= "<th>modification</th>";
	$content .= '</tr>';

	//Corps du tableau
	while( $ligne = $r->fetch( PDO::FETCH_ASSOC ) ){

		// Zone correspondant à la table membre
		$content .= '<tr>';
			foreach( $ligne as $index => $valeur){

				if( $index != 'mdp'){ 
					$content .= "<td>$valeur</td>";
				}
			}

			// Colonne suprimer et modifier
			$content .='<td class="text-center">
							<a href="?action=suppression&id_membre='.$ligne['id_membre'].'"	 onclick="return( confirm(\'Es tu certain ?\') )" > 
								<i class="fas fa-trash-alt"></i>
							</a>
						</td>';
			$content .= '<td class="text-center">
							<a href="?action=modification&id_membre='.$ligne['id_membre'].'" > 
								<i class="fas fa-edit"></i>
							</a>
						</td>';
		$content .= '</tr>';
	}
$content .= '</table>';

?>

<h1 class="col-12"> GESTION DES MEMBRES </h1>
<section class="d-flex flex-column col-12 align-items-center">
	<?= $content; ?>
</section>


<?php

if( isset($_GET['action']) && $_GET['action'] == 'modification' ) :

	$r = $pdo->query(" SELECT * FROM switch_membre WHERE id_membre = '$_GET[id_membre]' ");

	$membre = $r->fetch(PDO::FETCH_ASSOC);
	//debug( $membre );

	if( $_POST ){ 

		execute_requete(" UPDATE switch_membre SET 

							civilite = '$_POST[civilite]',
							pseudo = '$_POST[pseudo]',
							nom = '$_POST[nom]',
							prenom = '$_POST[prenom]',
							email = '$_POST[email]',
							statut = '$_POST[statut]'

							WHERE id_membre = '$_GET[id_membre]'
						");
		//debug($_GET['id_membre']);
		//redirection
		redirige('gestion_membre.php');
		//header('location: gestion_membre.php');
	} 
?>

<section class="col-12 mt-4">
    <h2> Modifier le profil </h2>

    <form method="post" class="row">
        <!-- Statut -->
        <div class="col-sm-2 my-1">
			<label for="statut" class="mr-sm-2">Statut</label>
            <select class="custom-select mr-sm-2" name="statut" id="statut">
                <option <?php  if( $membre['statut']=='0') echo "selected"; ?> value="0" selected>Utilisateur</option>
                <option <?php  if( $membre['statut']=='1') echo "selected"; ?> value="1">Admin</option>
            </select>
        </div>
        <!-- Civilité -->
        <div class="col-sm-2 my-1">
			<label for="civilite" class="mr-sm-2">Civilité</label>
            <select class="custom-select mr-sm-2" name="civilite" id="statut">
                <option <?php  if( $membre['statut']=='m') echo "selected"; ?> value="m" selected>Homme</option>
                <option <?php  if( $membre['statut']=='f') echo "selected"; ?> value="f">Femme</option>
            </select>
        </div>
        <!-- Pseudo -->
        <div class="col-sm-3 my-1">
        	<label for="pseudo">Pseudo</label>
            	<div class="input-group">
                	<div class="input-group-prepend">
                    	<div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                	</div>
                	<input type="text" class="form-control" name="pseudo" id="pseudo" value="<?=$membre['pseudo'] ?>">
            	</div>
        	</div>
        <!-- Nom -->
        <div class="col-sm-3 my-1">
        	<label for="nom">Nom</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-pen"></i></div>
                </div>
                <input type="text" class="form-control" name="nom" id="nom" value="<?=$membre['nom'] ?>">
            </div>
        </div>	
        <!-- Prénom -->
        <div class="col-sm-3 my-1">
            <label for="prenom">Prenom</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-pencil-alt"></i></div>
                </div>
	            <input type="text" class="form-control" name="prenom" id="prenom" value="<?=$membre['prenom'] ?>">
            </div>
        </div>	
        <!-- email -->
        <div class="col-sm-3 my-1">
	    	<label for="email">Email</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
	            <input type="text" class="form-control" name="email" id="email" value="<?=$membre['email'] ?>">
            </div>
        </div>
        <!-- bouton -->
        <div class="col-12 my-3">
	        <input type="submit" value="Enregistrer" name="membre" class="btn btn-primary">
        </div>

    </form>





<?php endif; ?>

































<?php require_once "../inc/footer.inc.php"; ?>	