<?php
$this->load->helper('url');
?>
<div id="contenu">
	<h2>Liste des fiches de frais à valider</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th >Visiteur</th>
				<th >Mois</th>
				<th >Etat</th>  
				<th >Montant</th>  
				<th >Date modif.</th>  
				<th  colspan="4">Actions</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php    
			foreach( $ValiderFiches as $uneFiche) 
			{
				$modLink = '';
				$validLink = '';
				$refuLink = '';
				
				if ($uneFiche['idEtat'] == 'CL') {
					$modLink = anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'modifier les montants',  'title="modifier les montants de la fiche"');
					$validLink = anchor('c_comptable/validFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'valider',  'title="Valider la fiche"  onclick="return confirm(\'Voulez-vous vraiment valider cette fiche ?\');"');
					$refuLink = anchor('c_comptable/commentRefuFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'refuser',  'title="Refuser la fiche"');
				}
				
				echo 
				'<tr>
					<td class="libelle">'.$uneFiche['nomVisiteur'].' </td>
					<td class="date">'.anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>';
				if($uneFiche['libelle'] == 'Refusée')
				{
					echo '<td class="libelle">'.$uneFiche['libelle'].' : '.$uneFiche['commentaire'].'</td>';
				}
				else
				{
					echo '<td class="libelle">'.$uneFiche['libelle'].'</td>';
				}
				echo
				   '<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					<td class="action">'.$modLink.'</td>
					<td class="action">'.$validLink.'</td>
					<td class= "action">'.$refuLink.'</td>
				</tr>';
			}
		?>
		</tbody>
    </table>
</div>