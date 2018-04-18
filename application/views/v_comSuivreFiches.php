<?php
$this->load->helper('url');
?>
<div id="contenu">
	<h2>Liste des fiches de frais à suivre</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';
	
			$ficheValide = array();
			$fichePaiement = array();
			//var_dump($LesFichesASuivre);
			foreach( $LesFichesASuivre as $uneFiche) 
			{
				if($uneFiche['idEtat'] == 'VA')
				{
					array_push($ficheValide, $uneFiche);
				}
					
				else if($uneFiche['idEtat'] == 'MP')
				{
					array_push($fichePaiement, $uneFiche);
				}
			}
			
	?>
	<table class="listeLegere">
		<thead>
			<tr>
				<th colspan="6">LES FICHES VALIDÉES</th>
			</tr>
			
			<tr>
				<th >Visiteur</th>
				<th >Mois</th>
				<th >Etat</th>  
				<th >Montant</th>  
				<th >Date modif.</th>  
				<th>Action</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php 
			
			foreach($ficheValide as $uneFicheValide)
			{
					$MPLink = '';
					
					$MPLink = anchor('c_comptable/confirmChangeEtat/'.$uneFicheValide['mois'].'/'.$uneFicheValide['idVisiteur'].'/mettreEnPaiement', 'Mettre en paiement',  'title="Mettre la fiche en paiement"');
					
					echo
					'<tr>
						<td class="libelle">'.$uneFicheValide['nomVisiteur'].' </td>
						<td class="date">'.anchor('c_comptable/voirFiche/'.$uneFicheValide['mois'].'/'.$uneFicheValide['idVisiteur'], $uneFicheValide['mois'],  'title="Consulter la fiche"').'</td>';

					echo '<td class="libelle">'.$uneFicheValide['libelle'].'</td>';
						
					echo
					'<td class="montant">'.$uneFicheValide['montantValide'].'</td>
						<td class="date">'.$uneFicheValide['dateModif'].'</td>
						<td class="action">'.$MPLink.'</td>
					</tr>';
			}
				
		?>
		
		</tbody>
    </table>
    
    <table class="listeLegere">
		<thead>
			<tr>
				<th colspan="6">LES FICHES MISE EN PAIEMENT</th>
			</tr>
			
			<tr>
				<th >Visiteur</th>
				<th >Mois</th>
				<th >Etat</th>  
				<th >Montant</th>  
				<th >Date modif.</th>  
				<th>Action</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php 
			
		foreach($fichePaiement as $uneFichePaiement)
			{
					$rembouseLink = '';
					
						$rembourseLink = anchor('c_comptable/confirmChangeEtat/'.$uneFichePaiement['mois'].'/'.$uneFichePaiement['idVisiteur'].'/rembourse', 'Remboursée',  'title="La fiche a été rembousée"');
					
					echo
					'<tr>
						<td class="libelle">'.$uneFichePaiement['nomVisiteur'].' </td>
						<td class="date">'.anchor('c_comptable/voirFiche/'.$uneFichePaiement['mois'].'/'.$uneFichePaiement['idVisiteur'], $uneFichePaiement['mois'],  'title="Consulter la fiche"').'</td>';
					
					if($uneFichePaiement['libelle'] == 'Refusée')
					{
						echo '<td class="libelle">'.$uneFichePaiement['libelle'].' : '.$uneFichePaiement['commentaire'].'</td>';
					}
					else
					{
						echo '<td class="libelle">'.$uneFichePaiement['libelle'].'</td>';
					}
					
					echo
					'<td class="montant">'.$uneFichePaiement['montantValide'].'</td>
						<td class="date">'.$uneFichePaiement['dateModif'].'</td>
						<td class="action">'.$rembourseLink.'</td>
					</tr>';
			}
				
		?>
		
		</tbody>
    </table>
</div>