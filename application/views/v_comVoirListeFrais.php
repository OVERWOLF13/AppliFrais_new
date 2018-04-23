<?php
$this->load->helper('url');
?>

<div id="contenu">
	<h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
<div class="corpsForm" id="bodyForm">
		  
			<fieldset>
				<legend>Eléments forfaitisés</legend>
					<table id = "test">
					<tr align="right">
					<td></td>
					<td><strong>Quantité</strong></td>
					<td><strong>Montant</strong></td>
					<td><strong>Total</strong></td>
					</tr>
					
					<?php
					$nb = 0;
					$prixtotal = 0;
					foreach ($lesFraisForfait as $unFrais)
					{
						$idFrais = $unFrais['idfrais'];
						$libelle = $unFrais['libelle'];
						$quantite = $unFrais['quantite'];
						$montant = $unFrais['montant'];
						$prix = $quantite * $montant;
						$prixtotal += $prix;

						echo 
						'<tr>
							<td> <label for="'.$idFrais.'">'.$libelle.'</label></td>';
						echo	'<td>'.$quantite.'</td>
								 <td id = td_'.$idFrais.'>'.$montant.'</td>
								 <td id="montant_Frais'.$nb.'" name="montant_Frais'.$nb.'">'.$prix.'</td>
						</tr>';
						$nb++;
					}
				?>
				
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td id="prixTotal"><?php echo $prixtotal.' € '; ?></td>
				</tr>
					</table>
				
			</fieldset>
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