<?php
	$this->load->helper('url');
?>

<div id="contenu">
	<h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<form method="post"  action="<?php echo base_url("c_visiteur/majForfait");?>">
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
					foreach ($lesFraisForfait as $unFrais)
					{
						$idFrais = $unFrais['idfrais'];
						$libelle = $unFrais['libelle'];
						$quantite = $unFrais['quantite'];
						$montant = $unFrais['montant'];

						echo 
						'<tr>
							<td> <label for="'.$idFrais.'">'.$libelle.'</label></td>';
						echo	'<td> <input type="number" min="0" class="inputQuantite" id="input_'.$idFrais.'" name="lesFrais['.$idFrais.']" size="10" maxlength="5" value="'.$quantite.'" onchange = "calculMontantFrais(input_'.$idFrais.', '.$montant.','.$nb.')" onload = "calculMontantFrais(input_'.$idFrais.', '.$montant.', '.$nb.')" /></td>
								 <td id = td_'.$idFrais.'>'.$montant.'</td>
								 <td id="montant_Frais'.$nb.'" name="montant_Frais'.$nb.'"></td>
						</tr>';
						$nb++;
					}
				?>
				
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td id="prixTotal"></td>
				</tr>
					</table>
				
			</fieldset>
		</div>
		<div class="piedForm">
			<p>
				<input id="ok" type="submit" value="Enregistrer" size="20" />
				<input id="annuler" type="reset" value="Effacer" size="20" />
			</p> 
		</div>
	</form>

	
	<table class="listeLegere">
		<caption>Descriptif des éléments hors forfait</caption>
		
		<tr>
			<th >Date</th>
			<th >Libellé</th>  
			<th >Montant</th>  
			<th >&nbsp;</th>              
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
					<td class="action">'.
					anchor(	"c_visiteur/supprFrais/$id", 
							"Supprimer ce frais", 
							'title="Suppression d\'une ligne de frais" onclick="return confirm(\'Voulez-vous vraiment supprimer ce frais ?\');"'
						).
					'</td>
				</tr>';
			}
		?>	  
                                          
    </table>

	<form method="post" action="<?php echo base_url("c_visiteur/ajouteFrais");?>">
		<div class="corpsForm">
			<fieldset>
				<legend>Nouvel élément hors forfait</legend>
				<p>
					<label for="txtDateHF">Date (jj/mm/aaaa): </label>
					<input type="date" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  required />
				</p>
				<p>
					<label for="txtLibelleHF">Libellé</label>
					<input type="text" id="txtLibelleHF" name="libelle" size="60" maxlength="256" value="" required />
				</p>
				<p>
					<label for="txtMontantHF">Montant : </label>
					<input type="number" id="txtMontantHF" min="0" step = "0.01" name="montant" size="10" maxlength="10" value="" required/>
				</p>
			</fieldset>
		</div>
		<div class="piedForm">
			<p>
				<input id="ajouter" type="submit" value="Ajouter" size="20" />
				<input id="effacer" type="reset" value="Effacer" size="20" />
			</p> 
		</div>
	</form>
</div>