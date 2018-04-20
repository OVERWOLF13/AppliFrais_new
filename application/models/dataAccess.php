<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modèle qui implémente les fonctions d'accès aux données 
*/
class DataAccess extends CI_Model {
// TODO : Transformer toutes les requêtes en requêtes paramétrées

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
	 * Retourne les informations d'un utilisateur
	 * 
	 * @param $login 
	 * @param $mdp
	 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
	*/
	public function getInfosUtilisateur($login, $mdp){
		$req = "select utilisateur.id as id, utilisateur.statut as statut, utilisateur.nom as nom, utilisateur.prenom as prenom 
				from utilisateur
				where utilisateur.login=? and utilisateur.mdp=?";
		$rs = $this->db->query($req, array ($login, $mdp));
		$ligne = $rs->first_row('array'); 
		return $ligne;
	}

	/**
	 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
	 * concernées par les deux arguments
	 * La boucle foreach ne peut être utilisée ici car on procède
	 * à une modification de la structure itérée - transformation du champ date-
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
	*/
	public function getLesLignesHorsForfait($idVisiteur,$mois){
		$this->load->model('functionsLib');

		$req = "select * 
				from lignefraishorsforfait 
				where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
					and lignefraishorsforfait.mois = '$mois' ";	
		$rs = $this->db->query($req);
		$lesLignes = $rs->result_array();
		$nbLignes = $rs->num_rows();
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  $this->functionsLib->dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
		
	/**
	 * Retourne le nombre de justificatif d'un utilisateur pour un mois donné
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return le nombre entier de justificatifs 
	*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb 
				from  fichefrais 
				where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->result_array();
		return $laLigne['nb'];
	}
		
	/**
	 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
	 * concernées par les deux arguments
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
	*/
	public function getLesLignesForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, lignefraisforfait.quantite as quantite , lignefraisforfait.montantApplique as montant, lignefraisforfait.montantApplique * lignefraisforfait.quantite as montantTotal
				from lignefraisforfait inner join fraisforfait 
					on fraisforfait.id = lignefraisforfait.idfraisforfait
				where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
				order by lignefraisforfait.idfraisforfait";	
		$rs = $this->db->query($req);
		$lesLignes = $rs->result_array();
		return $lesLignes; 
	}
		
	/**
	 * Retourne tous les FraisForfait
	 * 
	 * @return un tableau associatif contenant les fraisForfaits
	*/
	public function getLesFraisForfait(){
		$req = "select fraisforfait.id as idfrais, libelle, montant from fraisforfait order by fraisforfait.id";
		$rs = $this->db->query($req);
		$lesLignes = $rs->result_array();
		return $lesLignes;
	}
	
	/**
	 * Met à jour la table ligneFraisForfait pour un utilisateur et
	 * un mois donné en enregistrant les nouveaux montants
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
	*/
	public function majLignesForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait 
					set lignefraisforfait.quantite = $qte
					where lignefraisforfait.idvisiteur = '$idVisiteur' 
						and lignefraisforfait.mois = '$mois'
						and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			$this->db->simple_query($req);
		}
	}
		
	/**
	 * met à jour le nombre de justificatifs de la table ficheFrais
	 * pour le mois et le utilisateur concerné
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais 
				set nbjustificatifs = $nbJustificatifs 
				where fichefrais.idvisiteur = '$idVisiteur' 
					and fichefrais.mois = '$mois'";
		$this->db->simple_query($req);	
	}
		
	/**
	 * Teste si un utilisateur possède une fiche de frais pour le mois passé en argument
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return vrai si la fiche existe, ou faux sinon
	*/	
	public function existeFiche($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais 
				from fichefrais 
				where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		if($laLigne['nblignesfrais'] != 0){
			$ok = true;
		}
		return $ok;
	}
	
	/**
	 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un utilisateur et un mois donnés
	 * L'état de la fiche est mis à 'CR'
	 * Lles lignes de frais forfait sont affectées de quantités nulles et du montant actuel de FraisForfait
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	*/
	public function creeFiche($idVisiteur,$mois){
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
				values('$idVisiteur','$mois',0,0,now(),'CR')";
		$this->db->simple_query($req);
		$lesFF = $this->getLesFraisForfait();
		foreach($lesFF as $uneLigneFF){
			$unIdFrais = $uneLigneFF['idfrais'];
			$montantU = $uneLigneFF['montant'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite, montantApplique) 
					values('$idVisiteur','$mois','$unIdFrais',0, $montantU)";
			$this->db->simple_query($req);
		 }
	}

	/**
	 * Signe une fiche de frais en modifiant son état de "CR" à "CL"
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	*/
	public function signeFiche($idVisiteur,$mois){
		$req = "UPDATE fichefrais SET idEtat = 'CL', dateModif = NOW() WHERE fichefrais.idVisiteur = '$idVisiteur' AND fichefrais.mois = '$mois'";
		
		$this->db->simple_query($req);
	}

	/**
	 * Crée un nouveau frais hors forfait pour un utilisateur un mois donné
	 * à partir des informations fournies en paramètre
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $libelle : le libelle du frais
	 * @param $date : la date du frais au format français jj//mm/aaaa
	 * @param $montant : le montant
	*/
	public function creeLigneHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$this->load->model('functionsLib');
		
		//$dateFr = $this->functionsLib->dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait 
				values('','$idVisiteur','$mois','$libelle','$date','$montant')";
		$this->db->simple_query($req);
	}
		
	/**
	 * Supprime le frais hors forfait dont l'id est passé en argument
	 * 
	 * @param $idFrais 
	*/
	public function supprimerLigneHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait 
				where lignefraishorsforfait.id =$idFrais ";
		$this->db->simple_query($req);
	}

	/**
	 * Retourne les mois pour lesquel un utilisateur a une fiche de frais
	 * 
	 * @param $idVisiteur 
	 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
	*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois 
				from  fichefrais 
				where fichefrais.idvisiteur ='$idVisiteur' 
				order by fichefrais.mois desc ";
		$rs = $this->db->query($req);
		$lesMois =array();
		$laLigne = $rs->first_row('array');
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee = substr( $mois,0,4);
			$numMois = substr( $mois,4,2);
			$lesMois["$mois"] = array(
				"mois"=>"$mois",
				"numAnnee"  => "$numAnnee",
				"numMois"  => "$numMois"
			 );
			$laLigne = $rs->next_row('array'); 		
		}
		return $lesMois;
	}

	/**
	 * Retourne les informations d'une fiche de frais d'un utilisateur pour un mois donné
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
	*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, 
					ficheFrais.nbJustificatifs as nbJustificatifs, ficheFrais.montantValide as montantValide, etat.libelle as libEtat 
				from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
				where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		return $laLigne;
	}

	/**
	 * Obtient toutes les fiches (sans détail) d'un utilisateur donné 
	 * 
	 * @param $idVisiteur : l'id du visiteur à qui appartient la fiche
	*/
	public function getFiches ($idVisiteur = NULL) {
		
			$req = "select idVisiteur, mois, montantValide, dateModif, id, libelle, idEtat
			from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id
			where fichefrais.idvisiteur = '$idVisiteur'
			order by mois desc";
		
		$rs = $this->db->query($req);
		$lesFiches = $rs->result_array();
		return $lesFiches;
	}
	/**
	 * Obtient le fiches signées
	 * 
	 * @return Les fiches signées sous forme d'un tableau associatif
	 */
	public function getFichesCom () {
		
		$req = "select concat(nom, ' ', prenom) as nomVisiteur, mois, montantValide, dateModif, idEtat, libelle, idVisiteur, CommentaireRefus AS commentaire
		from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id
						 inner join utilisateur on fichefrais.idVisiteur = utilisateur.id
		where idEtat = 'CL'
		order by idVisiteur, idEtat, mois desc;";
		
		$rs = $this->db->query($req);
		$lesFiches = $rs->result_array();
		return $lesFiches;
	}
	
	/**
	 * Obtient les foches à suivres (celles validées ou mises en paiement)
	 * 
	 * @return Les fiche à suivre sous la forme d'un tableau associatif
	 */
	public function getFichesASuivre () {
		
		$req = "select concat(nom, ' ', prenom) as nomVisiteur, mois, montantValide, dateModif, idEtat, libelle, idVisiteur, CommentaireRefus AS commentaire
		from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id
						 inner join utilisateur on fichefrais.idVisiteur = utilisateur.id
		where idEtat = 'MP' or idEtat = 'VA'
		order by  idEtat, idVisiteur, mois desc;";
		
		$rs = $this->db->query($req);
		$lesFiches = $rs->result_array();
		return $lesFiches;
	}
	
	/**
	 * Met la fiche en paiement
	 * 
	 * @param $mois : mois sous la forme aaaamm
	 * @param $idVisiteur : l'id du visiteur à qui appartient la fiche
	 */
	public function mettreEnPaiement($mois, $idVisiteur)
	{
		$req = "UPDATE fichefrais SET idEtat = 'MP', dateModif = NOW() WHERE fichefrais.idVisiteur = '$idVisiteur' AND fichefrais.mois = '$mois'";
		
		$this->db->simple_query($req);
	}
	
	/**
	 * Met la fiche à l'état rembousée
	 * 
	 * @param $mois : mois sous la forme aaaamm
	 * $param $idVisiteur : l'id du visiteur à qui appartient la fiche
	 */
	public function rembourse($mois, $idVisiteur)
	{
		$req = "UPDATE fichefrais SET idEtat = 'RB', dateModif = NOW() WHERE fichefrais.idVisiteur = '$idVisiteur' AND fichefrais.mois = '$mois'";
		
		$this->db->simple_query($req);
	}
	
	/**
	 * Calcule le montant total de la fiche pour un utilisateur et un mois donnés
	 * 
	 * @param $idVisiteur : l'id du visiteur à qui appartient la fiche
	 * @param $mois : mois sous la forme aaaamm
	 * @return le montant total de la fiche
	*/
	public function totalFiche ($idVisiteur, $mois) {
		// obtention du total hors forfait
		$req = "select SUM(montant) as totalHF
				from  lignefraishorsforfait 
				where idvisiteur = '$idVisiteur'
					and mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		$totalHF = $laLigne['totalHF'];
		
		// obtention du total forfaitisé
		$req = "select SUM(montantApplique * quantite) as totalF
				from  lignefraisforfait 
				where idvisiteur = '$idVisiteur'
					and mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		$totalF = $laLigne['totalF'];

		return $totalHF + $totalF;
	}

	/**
	 * Modifie le montantValide et la date de modification d'une fiche de frais
	 * 
	 * @param $idVisiteur : l'id du utilisateur
	 * @param $mois : mois sous la forme aaaamm
	 */
	public function recalculeMontantFiche($idVisiteur,$mois){
	
		$totalFiche = $this->totalFiche($idVisiteur,$mois);
		$req = "update ficheFrais 
				set montantValide = '$totalFiche', dateModif = now() 
				where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$this->db->simple_query($req);
	}
	
	/**
	 * Passe la fiche à l'état Validée
	 * 
	 * @param $idVisiteur : l'id du visiteur à qui appartient la fiche
	 * @param $mois : mois sous la forme aaaamm
	 */
	public function validFiche($idVisiteur, $mois)
	{
		$req = "UPDATE fichefrais SET idEtat = 'VA', dateModif = NOW() WHERE fichefrais.idVisiteur = '$idVisiteur' AND fichefrais.mois = '$mois'";
		
		$this->db->simple_query($req);
		
	}
	
	/**
	 * Passe la fiche à l'état Refusée
	 * 
	 * @param $idVisiteur : l'id du visiteur à qui appartient la fiche
	 * @param $mois : mois sous la forme aaaamm
	 * @param $commentaire : le commentaire de refus
	 */
	public function refuFiche($idVisiteur, $mois, $commentaire)
	{
		$req = "UPDATE fichefrais SET idEtat = 'RE', dateModif = NOW(), CommentaireRefus = '$commentaire' WHERE fichefrais.idVisiteur = '$idVisiteur' AND fichefrais.mois = '$mois'";
		
		$this->db->simple_query($req);
		
	}
	
	/**
	 * Mofifie le montant d'un frais sur une fiche
	 * 
	 * @param $mois : le mois de la fiche
	 * @param $idVisiteur : l'id du visiteur à qui appartient la fiche
	 * @param $nouveauMontantFrais : le nouveau montant du frais
	 * @param $idFrais : l'id du frais
	 */
	public function modifMontantFrais($mois, $idVisiteur, $nouveauMontantFrais, $idFrais)
	{
		$req = "UPDATE lignefraisforfait SET montantApplique = '".$nouveauMontantFrais."' WHERE idVisiteur = '".$idVisiteur."' AND mois = '".$mois."' AND idFraisForfait = '".$idFrais."';";
		
		$this->db->simple_query($req);
	}
}
?>