function calculMontantFrais(input, montant, i)
	{
		var quantite = input.value
		
			var id = 'montant_Frais'+i;
				document.getElementById(id).innerHTML=quantite * montant;
				
			var tdtotal = document.getElementById('prixTotal');
			var actuel = parseFloat(tdtotal.innerText);
			tdtotal.innerHTML = actuel + (quantite * montant);
			
	}