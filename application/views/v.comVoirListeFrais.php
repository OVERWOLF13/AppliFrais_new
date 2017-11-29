<?php
$this->load->helper('url');
?>

<div id="contenu">
	<h2>Fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<div class="corpsForm">
	  
		<fieldset>
			<legend>Eléments forfaitisés</legend>
			<?php
			echo
			'<table>
					<thead>
					<th></th>
					<th>Quantité</th>
					<th>Montant</th>
					<th>Montant Total</th>
					</thead>
			';
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
					$montant = $unFrais['montant'];
					$montantTotal = $unFrais['montantTotal'];

					echo 
					'<tr>
						<td>'.$libelle.'</td></td><td>'.$quantite.'</td>
						<td> <input type="texte" id="'.$idFrais.'" name="lesFrais['.$idFrais.']" size="10" maxlength="5" value="'.$montant.'"  /></td>
						<td>'.$montantTotal.'</td>
					</tr>
					';
				}
			echo '</table>';
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
