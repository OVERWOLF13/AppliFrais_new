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
		
		//si l'utilisateur n'est pas un comptable, on renvoie sur le controlleur c_default
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

				// envoie de la vue accueil du utilisateur
				$this->templates->load('t_comptable', 'v_comAccueil');
			}
			
			
			elseif ($action == 'ValiderFiches')		// ValiderFiches demandé : on active la fonction ValiderFiches du modèle comptable
			{
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				//on va chercher les fiches à valider
				$data['ValiderFiches'] = $this->a_comptable->getFichesCom();
				
				//on affiche la vue en passant les fiches à valider
				$this->templates->load('t_comptable', 'v_comValidFiche', $data);

				// on n'est pas en mode "modification d'une fiche"
				$this->session->unset_userdata('mois');
			}
			
			elseif ($action == 'deconnecter')	// deconnecter demandé : on active la fonction deconnecter du modèle authentif
			{
				//charge le modèle authentif
				$this->load->model('authentif');
				
				//va cherche la fonction deconnecter dans le modèle
				$this->authentif->deconnecter();
			}
			
			elseif ($action == 'voirFiche')		// voirFiche demandé : on visualise la fiche avec possibilité d'actualiser les montants des frais
			{
				//charge le modèle a_comptable
				$this->load->model('a_comptable');

				// obtention du mois de la fiche à modifier qui doit avoir été transmis en second paramètre
				$mois = $params[0];
				
				// mémorisation du mode modification en cours on mémorise le mois de la fiche en cours de modification
				$this->session->set_userdata('mois', $mois);
				
				// obtention de l'id de l'utilisateur à qui appartien la fiche
				$idVisiteur = $params[1];
				
				//On passe les différents paramètres nécessaires à la vue
				
				//le mois de la fiche
				$data['mois'] = $mois;
				
				//l'id du visiteur
				$data['idVisiteur'] = $idVisiteur;
				
				//l'année de la fiche
				$data['numAnnee'] = substr( $mois,0,4);
				
				//le mois de la fiche
				$data['numMois'] = substr( $mois,4,2);
				
				//les frais hors forfais
				$data['lesFraisHorsForfait'] = $this->a_comptable->getLesLignesHorsForfait($idVisiteur,$mois);
				
				//les frais forfaitisés
				$data['lesFraisForfait'] = $this->a_comptable->getLesLignesForfait($idVisiteur,$mois);
				
				
				//affiche la vue
				$this->templates->load('t_comptable', 'v.comVoirListeFrais', $data);
			}
			
			elseif ($action == 'validFiche') //action validFiche demandé : on passe la fiche à l'état validé, et on retourne à la vue permettant de valider ou refuser des fiches
			{
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				// obtention de l'id du utilisateur
				$mois= $params[0];
				
				// obtention de l'id du visiteur
				$idVisiteur = $params[1];
				
				//on valide la fiche
				$data = $this->a_comptable->validFiche($mois, $idVisiteur);
				
				//On récupère les fiches à valider et la notification
				
				//les fiches à valider
				$data['ValiderFiches'] = $this->a_comptable->getFichesCom();
				
				//une notification
				$data['notify'] = "La fiche a bien été validée";
				
				//on affiche la vue
				$this->templates->load('t_comptable', 'v_comValidFiche', $data);
			}
			
			
			elseif ($action == 'commentRefuFiche') //action commentrefu : passe à la vue pour commenter la fiche de frais, tout en conservant les données de la fiche concernée
			{
				//obtention du mois de la fiche
				$mois = $params[0];
				
				//obtention de l'id du visiteur
				$idVisiteur = $params[1];
				
				//On passe les données nécessaires à la vue
				
				//Le mois de la fiche
				$data['mois'] = $mois;
				
				//l'id du visiteur
				$data['idVisiteur'] = $idVisiteur;
				
				//on affiche la vue
				$this->templates->load('t_comptable', 'v_comCommenterRefus', $data);
			}
			
			elseif ($action == 'refuFiche') //action refuFiche demandé : on passe la fiche à l'état refusé, et on retourne à la vue permettant de valider ou refuser des fiches
			{
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				//obtention du mois de la fiche
				$mois= $params[0];
				
				//obtention de l'id du visiteur
				$idVisiteur = $params[1];
				
				// obtention du commentaire de refus
				$commentaire = $_POST['commentaire'];
				
				// méthode pour valider la fiche de frais
				$this->a_comptable->refuFiche($idVisiteur, $mois, $commentaire);
				
				//On passe les données nécessaires à la vue
				
				//Les fiches à valider
				$data['ValiderFiches'] = $this->a_comptable->getFichesCom();
				
				//une notification
				$data['notify'] = "La fiche a bien été refusée";
				
				$this->templates->load('t_comptable', 'v_comValidFiche', $data);
			}
			
			else if ($action == 'modifMontantFrais') //action modifMontantFrais demandé : on modifie le montant du frais
			{
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				//obtention du mois de la fiche
				$mois = $params[0];
				
				//obtention de l'id du visiteur
				$idVisiteur = $params[1];
				
				//obtention de l'id du frais
				$idFrais = $params[2];
				
				//obtention du nouveau montant du frais
				$nouveauMontantFrais = $_POST[$idFrais];
				
				//modifie le montant du frais sur la fiche
				$this->a_comptable->modifMontantFrais($mois, $idVisiteur, $nouveauMontantFrais, $idFrais);
				
				//On passe les données nécessaires à la vue
				
				//une notification
				$data['notify'] = "Le montant du frais a bien été modifié";
				
				//le mois de la fiche
				$data['mois'] = $mois;
				
				//l'id du visiteur
				$data['idVisiteur'] = $params[1];
				
				//l'année de la fiche
				$data['numAnnee'] = substr( $mois,0,4);
				
				//le mois de la fiche
				$data['numMois'] = substr( $mois,4,2);
				
				//les frais hors forfait
				$data['lesFraisHorsForfait'] = $this->a_comptable->getLesLignesHorsForfait($idVisiteur,$mois);
				
				//les frais forfaitisés
				$data['lesFraisForfait'] = $this->a_comptable->getLesLignesForfait($idVisiteur,$mois);
				
				
				//on affiche la vue
				$this->templates->load('t_comptable', 'v.comVoirListeFrais', $data);
				
			}
			
			else if ($action == 'SuivreFiches') //action SuivreFiches demandé : permet d'obtenir les fiches à suivre
			{
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				//on va chercher les fiches à suivre
				$data['LesFichesASuivre'] = $this->a_comptable->SuivreFiches();
				
				//on affiche la vue
				$this->templates->load('t_comptable', 'v_comSuivreFiches', $data);
			}
			
			else if ($action == 'confirmChangeEtat') //action SuivreFiches demandé : on affiche une synthèse de la fiche de frais, avec demande de confirmation de changement d'état
			{
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				// obtention du mois de la fiche
				$mois = $params[0];
				
				// obtention de l'id du visiteur
				$idVisiteur = $params[1];
				
				//obtention de l'action a exécuter en cas de validation du changement d'état
				$nouvelEtat = $params[2];
				
				//On passe les données nécessaires à la vue
				
				//L'état à actualiser en cas d'acceptation
				$data['nouvelEtat'] = $nouvelEtat;
				
				//le mois de la fiche
				$data['mois'] = $mois;
				
				//l'id du visiteur
				$data['idVisiteur'] = $idVisiteur;
				
				//l'année de la fiche
				$data['numAnnee'] = substr( $mois,0,4);
				
				//le mois de la fiche
				$data['numMois'] = substr( $mois,4,2);
				
				//les frais hors forfait
				$data['lesFraisHorsForfait'] = $this->a_comptable->getLesLignesHorsForfait($idVisiteur,$mois);
				
				//les frais forfaitisés
				$data['lesFraisForfait'] = $this->a_comptable->getLesLignesForfait($idVisiteur,$mois);
				
				//on affiche la vue
				$this->templates->load('t_comptable', 'v_comConfirmChangeEtat', $data);
			}
			
			else if($action == 'mettreEnPaiement') //action mettreEnPaiementdemandé : met la fiche en paiement
			{
				//récupération de la réponse à la demande de confirmation de mise en paiement
				$confirmation = $_POST['confirmation'];
				
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				//si la réponse est oui
				if($confirmation == 'Oui')
				{
					//on récupère le mois
					$mois = $params[0];
					
					//on récupère l'id du visiteur
					$idVisiteur = $params[1];
					
					//on la met en paiement
					$this->a_comptable->mettreEnPaiement($mois, $idVisiteur);
					
					//On passe les donnéees nécessaires à la vue
					
					//on met une notification
					$data['notify'] = "La fiche a bien été mise en paiement";
					
					//on récupère les fiche à suivre
					$data['LesFichesASuivre'] = $this->a_comptable->SuivreFiches();
					
					//on affiche la vue
					$this->templates->load('t_comptable', 'v_comSuivreFiches', $data);
				}
				
				//si la réponse est non
				else
				{
					//on récupère les fiche à suivre
					$data['LesFichesASuivre'] = $this->a_comptable->SuivreFiches();
					
					//on affiche la vue
					$this->templates->load('t_comptable', 'v_comSuivreFiches', $data);
				}
			}
			
			else if($action == 'rembourse')
			{
				//récupération de la réponse à la demande de confirmation de remboursement
				$confirmation = $_POST['confirmation'];
				
				//on charge le modèle a_comptable
				$this->load->model('a_comptable');
				
				//si la réponse est oui
				if($confirmation == 'Oui')
				{
					//on récupère le mois et l'id du visiteur
					$mois = $params[0];
					$idVisiteur = $params[1];
					
					//on passe la fiche à l'état remboursée
					$this->a_comptable->rembourse($mois, $idVisiteur);
					
					//on met une notification
					$data['notify'] = "La fiche a bien été mise en paiement";
					
					//on récupère les fiches à suivres
					$data['LesFichesASuivre'] = $this->a_comptable->SuivreFiches();
					
					//on affiche la vue
					$this->templates->load('t_comptable', 'v_comSuivreFiches', $data);
				}
				
				else
				{
					//on récupère les fiche à suivre
					$data['LesFichesASuivre'] = $this->a_comptable->SuivreFiches();
					
					//on affiche la vue
					$this->templates->load('t_comptable', 'v_comSuivreFiches', $data);
				}
			}
			
			else	// dans tous les autres cas, on envoie la vue par défaut pour l'erreur 404
			{
				show_404();
			}
		}
	}
}
