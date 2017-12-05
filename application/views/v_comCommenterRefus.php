<?php
$this->load->helper('url');
echo '
<form action="'.anchor('c_comptable/refuFiche/'.$ValiderFiches['mois'].'/'.$ValiderFiches['idVisiteur']).'" method="post">
<textarea rows="10" cols="50" placeholder="Commentaire de refus" name="commentaire"></textarea>
<input type="submit" value="Confirmer le refuse de la fiche" onclick = "return confirm(\'Voulez-vous vraiment valider cette fiche ?\');">
</form>';
?>