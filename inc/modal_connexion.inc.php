<?php
//-----------------------------------------------------------------

    if( isset ($_POST['connexion']) ){ //si on a valider le formulaire
    //debug( $_POST );

        $r = execute_requete(" SELECT * FROM switch_membre WHERE pseudo = '$_POST[pseudo]' ");

        if( $r->rowCount() >= 1  ){
        
            $membre = $r->fetch( PDO::FETCH_ASSOC );
            //debug( $membre );

            if( password_verify( $_POST['mdp'] , $membre['mdp'] ) ){
                $_SESSION['membre']['id_membre'] = $membre['id_membre'];
			    $_SESSION['membre']['pseudo'] = $membre['pseudo'];
			    $_SESSION['membre']['mdp'] = $membre['mdp'];
			    $_SESSION['membre']['nom'] = $membre['nom'];
			    $_SESSION['membre']['prenom'] = $membre['prenom'];
			    $_SESSION['membre']['email'] = $membre['email'];
			    $_SESSION['membre']['civilite'] = $membre['civilite'];
			    $_SESSION['membre']['date_enregistrement'] = $membre['date_enregistrement'];
                $_SESSION['membre']['statut'] = $membre['statut'];
            }
		    else{
			    $errorCon .= '<div class="alert alert-danger col-12">Mot de passe saisie incorrecte</div>';
		    }
        }
	    else{ 
		    $errorCon .= '<div class="alert alert-danger col-12"> Pseudo saisie incorrecte</div>';

	    }
    }



?>

<!-- Modal -->
<div class="modal fade" id="connexion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONNEXION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" class="text-center">
                    <!-- $errorCon; //affichage des erreurs ?> -->
    
                    <div class="col-12 my-1 mx-auto">
                        <label class="sr-only" >Utilisateur</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                            </div>
                            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Utilisateur">
                        </div>
                    </div>

                    <div class="col-12 my-1 mx-auto">
                        <label class="sr-only">Mot de passe</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe">
                    </div>
            
                    <div class="d-flex flex-wrap justify-content-center modal-footer mt-3">
                        <button type="submit" value="connexion" name="connexion" class="col-12 btn btn-secondary" action="index.php">Me connecter</button>

                        <button type="button" class="btn btn-primary my-3 text-white" data-toggle="modal" data-target="#inscription">Créer un compte</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
  </div>
</div>