<?php
$this->load->helper('url');
?>
<div id="contenu">
	<h2>Commenter le refus de la fiche de frais</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';
	 
	
	echo '
	<form action="'.base_url('c_comptable/refuFiche/'.$mois.'/'.$idVisiteur).'" method="post">
	<textarea rows="10" cols="50" placeholder="Commentaire de refus" name="commentaire"></textarea></br></br>
	<input type="submit" value="Confirmer le refus de la fiche" onclick = "return confirm(\'Voulez-vous vraiment refuser cette fiche ?\');">
	</form>';
	
	?>
	</div>