jQuery(document).ready(function(){
	console.log('test');

	$(function(){
		$("#connexion button").click(function(){
			$('#connexion').modal('hide');
		});
	});

	
	// récupérer les valeur des differente variable
	 var categorie = $("#categorie").text();
	 console.log(categorie);
	 var ville = $("#ville").text();
	 console.log(ville);
	 var capacite = $("#capacite").text();
	 console.log(capacite);
	 var prix = $("#prix").text();
	 console.log(prix);
	 var dateEntree = $("#dateEntree").text();
	 console.log(dateEntree);
	 var dateSortie = $("#dateSortie").text();
	 console.log(dateSortie);

	// récupérer la valeur du champ capacite
	 $( "#capacites select" ).change(function () {
		var capacite = "";
		$( "#capacites select option:selected" ).each(function() {
			capacite = $( this ).text();
		});
		console.log('capacite');
		// On remplace la balise form existante
		$("#capacites").each(function(){
			// On recupere ce qu'il y a dans la balise form
			var elemForm = $(this);
			//On reconstruit la balise form avec la valeur du select capacite
			elemForm.replaceWith('<form action="index.php?categorie='+ categorie +' &ville='+ ville +' &capacite='+ capacite +' & prix='+ prix +' & dateEntree='+ dateEntree +' & dateSortie='+ dateSortie +'" id="capacites" method="post">' + elemForm.html() + '</form>');
		  });
	 })


	//recuperer la valeur du range prix
		var slider = document.getElementById("myRange");
		var selectPrix = document.getElementById("demo");
		selectPrix.innerHTML = slider.value;
 
		slider.oninput = function() {
			selectPrix.innerHTML = this.value;
			var prix = $("#demo").text();
			console.log('prix');
			   
			$(".pri").each(function(){
				// On recupere ce qu'il y a dans la balise form
				var elemForm = $(this);
				//On reconstruit la balise form avec la valeur du select capacite
				elemForm.replaceWith('<form action="index.php?categorie='+ categorie +' &ville='+ ville +' &capacite='+ capacite +' & prix='+ prix +' & dateEntree='+ dateEntree +' & dateSortie='+ dateSortie +'" class="pri" method="post">' + elemForm.html() + '</form>');
			});
		}

	// récupérer la valeur du champ Date entree
		$( "#dateArrivee select" ).change(function () {
			var dateEntree = "";
    		$( "#dateArrivee select option:selected" ).each(function() {
				dateEntree = $( this ).text();
    		});
			console.log('dateEntree');
			// On remplace la balise form existante
			$("#dateArrivee").each(function(){
				// On recupere ce qu'il y a dans la balise form
				var elemForm = $(this);
				//On reconstruit la balise form 
				elemForm.replaceWith('<form action="index.php?categorie='+ categorie +' &ville='+ ville +' &capacite='+ capacite +' & prix='+ prix +' & dateEntree='+ dateEntree +' & dateSortie='+ dateSortie +'" id="dateArrivee" method="post">' + elemForm.html() + '</form>');
		  	});
		})

		// récupérer la valeur du champ Date Depart
			$( "#dateDeparts select" ).change(function () {
				var  dateSortie= "";
				$( "#dateDeparts select option:selected" ).each(function() {
					dateSortie = $( this ).text();
				});
				
				console.log('dateSortie');
				// On remplace la balise form existante
				$("#dateDeparts").each(function(){
					// On recupere ce qu'il y a dans la balise form
					var elemForm = $(this);
					//On reconstruit la balise form 
					elemForm.replaceWith('<form action="index.php?categorie='+ categorie +' &ville='+ ville +' &capacite='+ capacite +' & prix='+ prix +' & dateEntree='+ dateEntree +' & dateSortie='+ dateSortie +'" id="dateDeparts" method="post">' + elemForm.html() + '</form>');
				});
			})

 


});


