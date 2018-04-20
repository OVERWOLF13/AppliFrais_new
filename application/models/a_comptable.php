<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A_comptable extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		// chargement du modèle d'accès aux données qui est utile à toutes les méthodes
		$this->load->model('dataAccess');
    }

	/**
	 * Accueil du utilisateur
	 * La fonction intègre un mécanisme de contrôle d'existence des 
	 * fiches de frais sur les 6 derniers mois. 
	 * Si l'une d'elle est absente, elle est créée
	*/
	public function accueil()
	{	// TODO : Contrôler que toutes les valeurs de $unMois sont valides (chaine de caractère dans la BdD)
	
		// chargement du modèle contenant les fonctions génériques
		$this->load->model('functionsLib');

		// obtention de la liste des 6 derniers mois (y compris celui ci)
		$lesMois = $this->functionsLib->getSixDerniersMois();
		
		// obtention de l'id de l'utilisateur mémorisé en session
		$idVisiteur = $this->session->userdata('idUser');
		
		// contrôle de l'existence des 6 dernières fiches et création si nécessaire
		foreach ($lesMois as $unMois){
			if(!$this->dataAccess->ExisteFiche($idVisiteur, $unMois)) $this->dataAccess->creeFiche($idVisiteur, $unMois);
		}
	}

	/**
	 * Présente le détail de la fiche sélectionnée 
	 * 
	 * @param $idVisiteur : l'id du utilisateur 
	 * @param $mois : le mois de la fiche à modifier 
	*/

	/** 
	 * Signe une fiche de frais en changeant son état
	 * 
	 * @param $idVisiteur : l'id du utilisateur 
	 * @param $mois : le mois de la fiche à signer
	*/
	public function signeFiche($idVisiteur, $mois)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : intégrer une fonctionnalité d'impression PDF de la fiche

	    $this->dataAccess->signeFiche($idVisiteur, $mois);
	}
	
	public function getLesLignesHorsForfait($idVisiteur,$mois)
	{
		return $this->dataAccess->getLesLignesHorsForfait($idVisiteur,$mois);
	}
	
	public function getLesLignesForfait($idVisiteur,$mois)
	{
		return $this->dataAccess->getLesLignesForfait($idVisiteur,$mois);
	}
	
	public function getFichesCom()
	{
		return $this->dataAccess->getFichesCom();
	}

	/**
	 * Modifie les quantités associées aux frais forfaitisés dans une fiche donnée
	 * 
	 * @param $idVisiteur : l'id du utilisateur 
	 * @param $mois : le mois de la fiche concernée
	 * @param $lesFrais : les quantités liées à chaque type de frais, sous la forme d'un tableau
	*/
	public function majForfait($idVisiteur, $mois, $lesFrais)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : valider les données contenues dans $lesFrais ...
		
		$this->dataAccess->majLignesForfait($idVisiteur,$mois,$lesFrais);
		$this->dataAccess->recalculeMontantFiche($idVisiteur,$mois);
	}

	/**
	 * Ajoute une ligne de frais hors forfait dans une fiche donnée
	 * 
	 * @param $idVisiteur : l'id du utilisateur 
	 * @param $mois : le mois de la fiche concernée
	 * @param $lesFrais : les quantités liées à chaque type de frais, sous la forme d'un tableau
	*/
	public function ajouteFrais($idVisiteur, $mois, $uneLigne)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session
		// TODO : valider la donnée contenues dans $uneLigne ...

		$dateFrais = $uneLigne['dateFrais'];
		$libelle = $uneLigne['libelle'];
		$montant = $uneLigne['montant'];

		$this->dataAccess->creeLigneHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
	}

	/**
	 * Supprime une ligne de frais hors forfait dans une fiche donnée
	 * 
	 * @param $idVisiteur : l'id du utilisateur 
	 * @param $mois : le mois de la fiche concernée
	 * @param $idLigneFrais : l'id de la ligne à supprimer
	*/
	public function supprLigneFrais($idVisiteur, $mois, $idLigneFrais)
	{	// TODO : s'assurer que les paramètres reçus sont cohérents avec ceux mémorisés en session et cohérents entre eux

	    $this->dataAccess->supprimerLigneHorsForfait($idLigneFrais);
	}
	
	/**
	 * Valide  une fiche de frais
	 * 
	 * @param $mois
	 * @param $idVisiteur
	 */
	public function validFiche($mois, $idVisiteur)
	{
		$this->dataAccess->validFiche($idVisiteur, $mois);
	}
	
	/**
	 * Refuse une fiche
	 * 
	 * @param $idVisiteur
	 * @param $mois
	 * @param $commentaire
	 */
	public function refuFiche($idVisiteur, $mois, $commentaire)
	{
		$this->dataAccess->refuFiche($idVisiteur, $mois, $commentaire);
	}
	
	/**
	 * Modifie le montant du frais
	 * 
	 * @param $mois
	 * @param $idVisiteur
	 * @param $nouveauMontantFrais
	 * @param $idFrais
	 */
	public function modifMontantFrais($mois, $idVisiteur, $nouveauMontantFrais, $idFrais)
	{
		$this->dataAccess->modifMontantFrais($mois, $idVisiteur, $nouveauMontantFrais, $idFrais);
	}
	
	/**
	 * Donne les fiches à suivre
	 * 
	 * @return FichesASuivre
	 */
	public function SuivreFiches()
	{
		return $this->dataAccess->getFichesASuivre();
	}
	
	/**
	 * Met la fiche à l'état "Mise en paiement"
	 * 
	 * @param $mois
	 * @param $idVisiteur
	 */
	public function mettreEnPaiement($mois, $idVisiteur)
	{
		$this->dataAccess->mettreEnPaiement($mois, $idVisiteur);
	}
	
	/**
	 * Met la fiche à l'état "Remboursée"
	 * 
	 * @param $mois
	 * @param $idVisiteur
	 */
	public function rembourse($mois, $idVisiteur)
	{
		$this->dataAccess->rembourse($mois, $idVisiteur);
	}
}