<?php
$this->load->helper('url');
?>

<div id="contenu">
	<h2>Fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<div class="corpsForm">
	  
		<fieldset>
			<legend>Eléments forfaitisés</legend>
			<?php
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
					$montant = $unFrais['montant'];

					echo 
					'<div>
						<form action="'.base_url('c_comptable/modifMontantFrais/'.$mois.'/'.$idVisiteur.'/'.$idFrais).'" method="post" class="flotant">
						<label for="'.$idFrais.'">'.$libelle.' : '. $quantite.'</label> <input type="number" step="0.01" value="'.$montant.'" min="0" name = "'.$idFrais.'"></input>
						<input type="submit" value = "modifier le montant du frais" />
						</form>
					</div>';
				}
			?>
		</fieldset>
		<p></p>
	</div>  

	 
	<table class="listeLegere">
		<caption>Descriptif des éléments hors forfait</caption>
		<tr>
			<th >Date</th>
			<th >Libellé</th>  
			<th >Montant</th>             
		</tr>
          
		<?php    
			foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
			{
				$libelle = $unFraisHorsForfait['libelle'];
				$date = $unFraisHorsForfait['date'];
				$montant=$unFraisHorsForfait['montant'];
				$id = $unFraisHorsForfait['id'];
				echo 
				'<tr>
					<td class="date">'.$date.'</td>
					<td class="libelle">'.$libelle.'</td>
					<td class="montant">'.$montant.'</td>
				</tr>';
			}
		?>	  
                                          
    </table>

</div>
