<?php
if( isset ($_POST['inscription']) ){ //Si on a cliqué sur la bouton submit (c'est qu'il existe)

	//debug($_POST);

	if( strlen( $_POST['pseudo'] ) <= 3 || strlen( $_POST['pseudo'] ) >= 15 ){
	 //Si la taille du pseudo est inférieur ou égale a 3 OU qu il est supérieur à 15

		$errorIns .= '<div class="alert alert-danger">Votre pseudo doit contenir entre 3 et 15 lettres</div>';
	}

	//Tester si le pseudo est disponible :
	$r = execute_requete(" SELECT pseudo FROM switch_membre WHERE pseudo = '$_POST[pseudo]' " );

	if( $r->rowCount() >= 1 ){
	 //Si le pseudo renvoie au moins 1 résultat, c'est que le pseudo est déjà attribué

		$errorIns .= '<div class="alert alert-danger">Le pseudo saisie est déjà utilisé</div>';
	}

	//boucle sur les saisies afin de les passer dans la fonction addslashes
	foreach ($_POST as $key => $value) {

		$_POST[$key] = addslashes( $value );
		//addslashes() : permet d'accepter les apostrophes
	}

	//Cryptage du mot de passe :
	$_POST['mdp'] = password_hash( $_POST['mdp'], PASSWORD_DEFAULT );

	if( empty( $errorIns ) ){ //Si la variable $error est vide, c'est qu'il n'y a pas eu d'erreurs donc on peut lancer l'inscription (insertion)

		execute_requete(" INSERT INTO switch_membre(civilite, pseudo, mdp, nom, prenom, email) VALUES (
                            '$_POST[civilite]',
                            '$_POST[pseudo]', 
							'$_POST[mdp]',
							'$_POST[nom]',
							'$_POST[prenom]',
							'$_POST[email]'
                             )
                        ");
            $pseudo = $_POST['pseudo'];
        $errorIns .= ' <div class="bg-secondary text py-3 text-center text-white">' 
            . $pseudo . 
            ': Votre inscription est validé!<br><br>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#connexion">
                    <i class="fas fa-user-lock text-white"></i> Me Connecter
                </button>
        </div>';
	}
}



?>

<!-- Modal -->
<div class="modal fade" id="inscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">INSCRIPTION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
    
                    <!-- Civilité -->
                    <div class="col-6 my-1 p-0">
	                    <label class="mr-sm-2">Civilité</label>
                        <select class="custom-select mr-sm-2" name="civilite" id="statut">
                            <option value="m" selected>Homme</option>
                            <option value="f">Femme</option>
                        </select>
                    </div>
                    <!-- Pseudo -->
                    <div class="my-1">
                        <label for="pseudo">Pseudo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                            </div>
                            <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Pseudo">
                        </div>
                    </div>
                    <!-- mdp -->
                    <div class="my-1">
                        <label for="mdp">Mot de passe</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
                            </div>
                            <input type="text" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe">
                        </div>
                    </div>
                    <!-- Nom -->
                    <div class="my-1">
                        <label for="nom">Nom</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-pen"></i></div>
                            </div>
                            <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom">
                        </div>
                    </div>	
                    <!-- Prénom -->
                    <div class="my-1">
                        <label for="prenom">Prenom</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-pencil-alt"></i></div>
                            </div>
	                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prénom">
                        </div>
                    </div>	
                    <!-- email -->
                    <div class="my-1">
	                    <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                            </div>
	                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                    </div>
                    <!-- bouton -->
                    <div class="col-auto my-3">
	                    <input type="submit" value="Inscrire" name="inscription" class="btn btn-primary">
                    </div>

                </form>

            </div>
        </div>
    </div>
  </div>
</div>



