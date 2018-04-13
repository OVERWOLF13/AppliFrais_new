<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Contrôleur du module UTILISATEUR de l'application
*/
class C_comptable extends CI_Controller {

	/**
	 * Aiguillage des demandes faites au contrôleur
	 * La fonction _remap est une fonctionnalité offerte par CI destinée à remplacer 
	 * le comportement habituel de la fonction index. Grâce à _remap, on dispose
	 * d'une fonction unique capable d'accepter un nombre variable de paramètres.
	 *
	 * @param $action : l'action demandée par le utilisateur
	 * @param $params : les éventuels paramètres transmis pour la réalisation de cette action
	*/
	public function _remap($action, $params = array())
	{
		// chargement du modèle d'authentification
		$this->load->model('authentif');
		
		// contrôle de la bonne authentification de l'utilisateur
		if (!$this->authentif->estConnecte()) 
		{
			// l'utilisateur n'est pas authentifié, on envoie la vue de connexion
			$data = array();
			$this->templates->load('t_connexion', 'v_connexion', $data);
		}
		
		else if($this->session->userdata('statut') != 'comptable')
		{
			$this->load->helper('url');
			redirect('/c_default/');
		}
		
		else
		{
			// Aiguillage selon l'action demandée 
			// CI a traité l'URL au préalable de sorte à toujours renvoyer l'action "index"
			// même lorsqu'aucune action n'est exprimée
			if ($action == 'index')				// index demandé : on active la fonction accueil du modèle comptable
			{
				$this->load->model('a_comptable');

				// on n'est pas en mode "modification d'une fiche"
				$this->session->unset_userdata('mois');

				$this->a_comptable->accueil();
			}
			elseif ($action == 'ValiderFiches')		// ValiderFiches demandé : on active la fonction ValiderFiches du modèle comptable
			{
				$this->load->model('a_comptable');

				// on n'est pas en mode "modification d'une fiche"
				$this->session->unset_userdata('mois');

				$this->a_comptable->ValiderFiches();
			}
			elseif ($action == 'deconnecter')	// deconnecter demandé : on active la fonction deconnecter du modèle authentif
			{
				$this->load->model('authentif');
				$this->authentif->deconnecter();
			}
			elseif ($action == 'voirFiche')		// voirFiche demandé : on active la fonction voirFiche du modèle authentif
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à consulter)
			
				$this->load->model('a_comptable');

				// obtention du mois de la fiche à modifier qui doit avoir été transmis
				// en second paramètre
				$mois = $params[0];
				// mémorisation du mode modification en cours 
				// on mémorise le mois de la fiche en cours de modification
				$this->session->set_userdata('mois', $mois);
				// obtention de l'id de l'utilisateur à qui appartien la fiche
				$idVisiteur = $params[1];

				$this->a_comptable->voirFiche($idVisiteur, $mois);
			}
			
			
			elseif ($action == 'majForfait') // majFraisForfait demandé : on active la fonction majFraisForfait du modèle utilisateur ...
			{	// TODO : conrôler que l'obtention des données postées ne rend pas d'erreurs
				// TODO : dans la dynamique de l'application, contrôler que l'on vient bien de modFiche
				
				$this->load->model('a_comptable');

				// obtention de l'id du utilisateur et du mois concerné
				$idVisiteur = $this->session->userdata('idUser');
				$mois = $this->session->userdata('mois');

				// obtention des données postées
				$lesFrais = $this->input->post('lesFrais');

				$this->a_comptable->majForfait($idVisiteur, $mois, $lesFrais);

				// ... et on revient en modification de la fiche
				$this->a_comptable->modFiche($idVisiteur, $mois, 'Modification(s) des éléments forfaitisés enregistrée(s) ...');
			}
			
			elseif ($action == 'ajouteFrais') // ajouteLigneFrais demandé : on active la fonction ajouteLigneFrais du modèle utilisateur ...
			{	// TODO : conrôler que l'obtention des données postées ne rend pas d'erreurs
				// TODO : dans la dynamique de l'application, contrôler que l'on vient bien de modFiche
				
				$this->load->model('a_comptable');

				// obtention de l'id du utilisateur et du mois concerné
				$idVisiteur = $this->session->userdata('idUser');
				$mois = $this->session->userdata('mois');

				// obtention des données postées
				$uneLigne = array( 
					'dateFrais' => $this->input->post('dateFrais'),
					'libelle' => $this->input->post('libelle'),
					'montant' => $this->input->post('montant')
				);

				$this->a_comptable->ajouteFrais($idVisiteur, $mois, $uneLigne);

				// ... et on revient en modification de la fiche
				$this->a_comptable->modFiche($idVisiteur, $mois, 'Ligne "Hors forfait" ajoutée ...');				
			}
			elseif ($action == 'supprFrais') // suppprLigneFrais demandé : on active la fonction suppprLigneFrais du modèle utilisateur ...
			{	// TODO : contrôler la validité du second paramètre (mois de la fiche à modifier)
				// TODO : dans la dynamique de l'application, contrôler que l'on vient bien de modFiche
			
				$this->load->model('a_comptable');

				// obtention de l'id du utilisateur et du mois concerné
				$idVisiteur = $this->session->userdata('idUser');
				$mois = $this->session->userdata('mois');
				
				// Quel est l'id de la ligne à supprimer : doit avoir été transmis en second paramètre
				$idLigneFrais = $params[0];
				$this->a_comptable->supprLigneFrais($idVisiteur, $mois, $idLigneFrais);

				// ... et on revient en modification de la fiche
				$this->a_comptable->modFiche($idVisiteur, $mois, 'Ligne "Hors forfait" supprimée ...');				
			}
			
			elseif ($action == 'validFiche')
			{
				$this->load->model('a_comptable');
				
				// obtention de l'id du utilisateur et du mois concerné
				$mois= $params[0];
				$idVisiteur = $params[1];
				
				//retours au menu de validation				
				$this->a_comptable->validFiche($mois, $idVisiteur);
			}
			
			
			elseif ($action == 'commentrefuFiche')
			{
				$this->load->model('a_comptable');
				
				// obtention de l'id du utilisateur et du mois concerné
				$mois = $params[0];
				$idVisiteur = $params[1];
				
				$this->a_comptable->commentrefuFiche($mois, $idVisiteur);
			}
			
			elseif ($action == 'refuFiche')
			{
				$this->load->model('a_comptable');
				
				// obtention de l'id du utilisateur et du mois concerné
				$mois= $params[0];
				$idVisiteur = $params[1];
				$commentaire = $_POST['commentaire'];
				
				// méthode pour valider la fiche de frais
				$this->a_comptable->refuFiche($idVisiteur, $mois, $commentaire);
			}
			
			else if ($action == 'modifMontantFrais')
			{
				$this->load->model('a_comptable');
				
				$idFrais = $params[3];
				$nouveauMontantFrais = $_POST[$idFrais];
				
				$this->a_comptable->modifMontantFrais($nouveauMontantFrais, $idFrais);
			}
			
			else if ($action = 'SuivreFiche')
			{
				$this->load->model('a_comptable');
				
				
			}
			
			else	// dans tous les autres cas, on envoie la vue par défaut pour l'erreur 404
			{
				show_404();
			}
		}
	}
}
