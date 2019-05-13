<?php

/** 
 * Classe représentant la table `ticket`
 * @version 1.3
 */
class SupportDsiTicket
{
	var $db;
	// Déclaration des variables représentant les colonnes de la table
	var $ticketId = false;
	var $logicielId = false;
	var $materielId = false;
	var $projetId = false;
	var $ticketDescription = false;
	var $ticketScreenshot = false;
	var $ticketCreationTime = false;
	var $ticketEcheanceTime = false;
	var $ticketResolutionTime = false;
	var $ticketIsUrgent = false;
	var $ticketUserMatricule = false;
	var $ticketUserNom = false;
	var $ticketUserPrenom = false;
	var $ticketUserEmail = false;
	var $ticketUserTelephone = false;
	var $reponseId = false;
	var $userIdAffectation = false;
	var $userIdAffectationAuteur = false;
	var $userIdCreation = false;
	var $serviceId = false;
	var $etatId = false;
	var $problemeId = false;
	var $ticketSendMail = false;
	var $ticketDescriptionLive = false;
	var $ticketIdParent = false;
	var $ticketBatimentId = false;
	var $ticketAgentMotdir = false;
	var $ticketUserServiceId = false;
	var $typeClotureId = false;
	var $destinataireId = false;

	/** 
	 * Fonction qui met à jour la variable $ticketId
	 * représentant la colonne `ticket_id` de la table `ticket`
	 */
	function setTicketId($v)
	{
		$this->ticketId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $logicielId
	 * représentant la colonne `logiciel_id` de la table `ticket`
	 */
	function setLogicielId($v)
	{
		$this->logicielId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $materielId
	 * représentant la colonne `materiel_id` de la table `ticket`
	 */
	function setMaterielId($v)
	{
		$this->materielId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $projetId
	 * représentant la colonne `projet_id` de la table `ticket`
	 */
	function setProjetId($v)
	{
		$this->projetId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketDescription
	 * représentant la colonne `ticket_description` de la table `ticket`
	 */
	function setTicketDescription($v)
	{
		$this->ticketDescription = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketScreenshot
	 * représentant la colonne `ticket_screenshot` de la table `ticket`
	 */
	function setTicketScreenshot($v)
	{
		$this->ticketScreenshot = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketCreationTime
	 * représentant la colonne `ticket_creation_time` de la table `ticket`
	 */
	function setTicketCreationTime($v)
	{
		$this->ticketCreationTime = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketEcheanceTime
	 * représentant la colonne `ticket_echeance_time` de la table `ticket`
	 */
	function setTicketEcheanceTime($v)
	{
		$this->ticketEcheanceTime = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketResolutionTime
	 * représentant la colonne `ticket_resolution_time` de la table `ticket`
	 */
	function setTicketResolutionTime($v)
	{
		$this->ticketResolutionTime = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketIsUrgent
	 * représentant la colonne `ticket_is_urgent` de la table `ticket`
	 */
	function setTicketIsUrgent($v)
	{
		$this->ticketIsUrgent = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketUserMatricule
	 * représentant la colonne `ticket_user_matricule` de la table `ticket`
	 */
	function setTicketUserMatricule($v)
	{
		$this->ticketUserMatricule = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketUserNom
	 * représentant la colonne `ticket_user_nom` de la table `ticket`
	 */
	function setTicketUserNom($v)
	{
		$this->ticketUserNom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketUserPrenom
	 * représentant la colonne `ticket_user_prenom` de la table `ticket`
	 */
	function setTicketUserPrenom($v)
	{
		$this->ticketUserPrenom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketUserEmail
	 * représentant la colonne `ticket_user_email` de la table `ticket`
	 */
	function setTicketUserEmail($v)
	{
		$this->ticketUserEmail = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketUserTelephone
	 * représentant la colonne `ticket_user_telephone` de la table `ticket`
	 */
	function setTicketUserTelephone($v)
	{
		$this->ticketUserTelephone = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $reponseId
	 * représentant la colonne `reponse_id` de la table `ticket`
	 */
	function setReponseId($v)
	{
		$this->reponseId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $userIdAffectation
	 * représentant la colonne `user_id_affectation` de la table `ticket`
	 */
	function setUserIdAffectation($v)
	{
		$this->userIdAffectation = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $userIdAffectationAuteur
	 * représentant la colonne `user_id_affectation_auteur` de la table `ticket`
	 */
	function setUserIdAffectationAuteur($v)
	{
		$this->userIdAffectationAuteur = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $userIdCreation
	 * représentant la colonne `user_id_creation` de la table `ticket`
	 */
	function setUserIdCreation($v)
	{
		$this->userIdCreation = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $serviceId
	 * représentant la colonne `service_id` de la table `ticket`
	 */
	function setServiceId($v)
	{
		$this->serviceId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $etatId
	 * représentant la colonne `etat_id` de la table `ticket`
	 */
	function setEtatId($v)
	{
		$this->etatId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $problemeId
	 * représentant la colonne `probleme_id` de la table `ticket`
	 */
	function setProblemeId($v)
	{
		$this->problemeId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketSendMail
	 * représentant la colonne `ticket_send_mail` de la table `ticket`
	 */
	function setTicketSendMail($v)
	{
		$this->ticketSendMail = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketDescriptionLive
	 * représentant la colonne `ticket_description_live` de la table `ticket`
	 */
	function setTicketDescriptionLive($v)
	{
		$this->ticketDescriptionLive = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketIdParent
	 * représentant la colonne `ticket_id_parent` de la table `ticket`
	 */
	function setTicketIdParent($v)
	{
		$this->ticketIdParent = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketBatimentId
	 * représentant la colonne `ticket_batiment_id` de la table `ticket`
	 */
	function setTicketBatimentId($v)
	{
		$this->ticketBatimentId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketAgentMotdir
	 * représentant la colonne `ticket_agent_motdir` de la table `ticket`
	 */
	function setTicketAgentMotdir($v)
	{
		$this->ticketAgentMotdir = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ticketUserServiceId
	 * représentant la colonne `ticket_user_service_id` de la table `ticket`
	 */
	function setTicketUserServiceId($v)
	{
		$this->ticketUserServiceId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $typeClotureId
	 * représentant la colonne `type_cloture_id` de la table `ticket`
	 */
	function setTypeClotureId($v)
	{
		$this->typeClotureId = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $destinataireId
	 * représentant la colonne `destinataire_id` de la table `ticket`
	 */
	function setDestinataireId($v)
	{
		$this->destinataireId = $v;
	}

	/** 
	 * Retourne la valeur de la variable $ticketId
	 * Cette variable représentante la colonne `ticket_id` de la table `ticket`
	 * @return mixed
	 */
	function getTicketId()
	{
		return $this->ticketId;
	}

	/** 
	 * Retourne la valeur de la variable $logicielId
	 * Cette variable représentante la colonne `logiciel_id` de la table `ticket`
	 * @return mixed
	 */
	function getLogicielId()
	{
		return $this->logicielId;
	}

	/** 
	 * Retourne la valeur de la variable $materielId
	 * Cette variable représentante la colonne `materiel_id` de la table `ticket`
	 * @return mixed
	 */
	function getMaterielId()
	{
		return $this->materielId;
	}

	/** 
	 * Retourne la valeur de la variable $projetId
	 * Cette variable représentante la colonne `projet_id` de la table `ticket`
	 * @return mixed
	 */
	function getProjetId()
	{
		return $this->projetId;
	}

	/** 
	 * Retourne la valeur de la variable $ticketDescription
	 * Cette variable représentante la colonne `ticket_description` de la table `ticket`
	 * @return mixed
	 */
	function getTicketDescription()
	{
		return $this->ticketDescription;
	}

	/** 
	 * Retourne la valeur de la variable $ticketScreenshot
	 * Cette variable représentante la colonne `ticket_screenshot` de la table `ticket`
	 * @return mixed
	 */
	function getTicketScreenshot()
	{
		return $this->ticketScreenshot;
	}

	/** 
	 * Retourne la valeur de la variable $ticketCreationTime
	 * Cette variable représentante la colonne `ticket_creation_time` de la table `ticket`
	 * @return mixed
	 */
	function getTicketCreationTime()
	{
		return $this->ticketCreationTime;
	}

	/** 
	 * Retourne la valeur de la variable $ticketEcheanceTime
	 * Cette variable représentante la colonne `ticket_echeance_time` de la table `ticket`
	 * @return mixed
	 */
	function getTicketEcheanceTime()
	{
		return $this->ticketEcheanceTime;
	}

	/** 
	 * Retourne la valeur de la variable $ticketResolutionTime
	 * Cette variable représentante la colonne `ticket_resolution_time` de la table `ticket`
	 * @return mixed
	 */
	function getTicketResolutionTime()
	{
		return $this->ticketResolutionTime;
	}

	/** 
	 * Retourne la valeur de la variable $ticketIsUrgent
	 * Cette variable représentante la colonne `ticket_is_urgent` de la table `ticket`
	 * @return mixed
	 */
	function getTicketIsUrgent()
	{
		return $this->ticketIsUrgent;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserMatricule
	 * Cette variable représentante la colonne `ticket_user_matricule` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserMatricule()
	{
		return $this->ticketUserMatricule;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserNom
	 * Cette variable représentante la colonne `ticket_user_nom` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserNom()
	{
		return $this->ticketUserNom;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserPrenom
	 * Cette variable représentante la colonne `ticket_user_prenom` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserPrenom()
	{
		return $this->ticketUserPrenom;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserEmail
	 * Cette variable représentante la colonne `ticket_user_email` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserEmail()
	{
		return $this->ticketUserEmail;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserTelephone
	 * Cette variable représentante la colonne `ticket_user_telephone` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserTelephone()
	{
		return $this->ticketUserTelephone;
	}

	/** 
	 * Retourne la valeur de la variable $reponseId
	 * Cette variable représentante la colonne `reponse_id` de la table `ticket`
	 * @return mixed
	 */
	function getReponseId()
	{
		return $this->reponseId;
	}

	/** 
	 * Retourne la valeur de la variable $userIdAffectation
	 * Cette variable représentante la colonne `user_id_affectation` de la table `ticket`
	 * @return mixed
	 */
	function getUserIdAffectation()
	{
		return $this->userIdAffectation;
	}

	/** 
	 * Retourne la valeur de la variable $userIdAffectationAuteur
	 * Cette variable représentante la colonne `user_id_affectation_auteur` de la table `ticket`
	 * @return mixed
	 */
	function getUserIdAffectationAuteur()
	{
		return $this->userIdAffectationAuteur;
	}

	/** 
	 * Retourne la valeur de la variable $userIdCreation
	 * Cette variable représentante la colonne `user_id_creation` de la table `ticket`
	 * @return mixed
	 */
	function getUserIdCreation()
	{
		return $this->userIdCreation;
	}

	/** 
	 * Retourne la valeur de la variable $serviceId
	 * Cette variable représentante la colonne `service_id` de la table `ticket`
	 * @return mixed
	 */
	function getServiceId()
	{
		return $this->serviceId;
	}

	/** 
	 * Retourne la valeur de la variable $etatId
	 * Cette variable représentante la colonne `etat_id` de la table `ticket`
	 * @return mixed
	 */
	function getEtatId()
	{
		return $this->etatId;
	}

	/** 
	 * Retourne la valeur de la variable $problemeId
	 * Cette variable représentante la colonne `probleme_id` de la table `ticket`
	 * @return mixed
	 */
	function getProblemeId()
	{
		return $this->problemeId;
	}

	/** 
	 * Retourne la valeur de la variable $ticketSendMail
	 * Cette variable représentante la colonne `ticket_send_mail` de la table `ticket`
	 * @return mixed
	 */
	function getTicketSendMail()
	{
		return $this->ticketSendMail;
	}

	/** 
	 * Retourne la valeur de la variable $ticketDescriptionLive
	 * Cette variable représentante la colonne `ticket_description_live` de la table `ticket`
	 * @return mixed
	 */
	function getTicketDescriptionLive()
	{
		return $this->ticketDescriptionLive;
	}

	/** 
	 * Retourne la valeur de la variable $ticketIdParent
	 * Cette variable représentante la colonne `ticket_id_parent` de la table `ticket`
	 * @return mixed
	 */
	function getTicketIdParent()
	{
		return $this->ticketIdParent;
	}

	/** 
	 * Retourne la valeur de la variable $ticketBatimentId
	 * Cette variable représentante la colonne `ticket_batiment_id` de la table `ticket`
	 * @return mixed
	 */
	function getTicketBatimentId()
	{
		return $this->ticketBatimentId;
	}

	/** 
	 * Retourne la valeur de la variable $ticketAgentMotdir
	 * Cette variable représentante la colonne `ticket_agent_motdir` de la table `ticket`
	 * @return mixed
	 */
	function getTicketAgentMotdir()
	{
		return $this->ticketAgentMotdir;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserServiceId
	 * Cette variable représentante la colonne `ticket_user_service_id` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserServiceId()
	{
		return $this->ticketUserServiceId;
	}

	/** 
	 * Retourne la valeur de la variable $typeClotureId
	 * Cette variable représentante la colonne `type_cloture_id` de la table `ticket`
	 * @return mixed
	 */
	function getTypeClotureId()
	{
		return $this->typeClotureId;
	}

	/** 
	 * Retourne la valeur de la variable $destinataireId
	 * Cette variable représentante la colonne `destinataire_id` de la table `ticket`
	 * @return mixed
	 */
	function getDestinataireId()
	{
		return $this->destinataireId;
	}

	/** 
	 * @param DB $db connexion à la base de données
	 */
	function SupportDsiTicket($db)
	{
		return $this->db = $db;
	}

	/** 
	 * Vérifie si les champs NOT NULL ont bien une valeur
	 * Génère un die en cas d'erreur
	 */
	function verifChampsNotNull()
	{
	}

	/** 
	 * Vérifie si les champs qui doivent être des clés primaires ont bien une valeur
	 * Génère un die en cas d'erreur
	 */
	function verifChampsPrimaryKey()
	{
		if ($this->getTicketId() == '')
			die('Exécution impossible car le champs OBLIGATOIRE `ticket_id` n\'a pas de valeur!');
	}

	/** 
	 * Insère l'élément en base
	 * @return DB résultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into supportdsi.ticket '.
		       '('.
				'ticket_id, '.
				'logiciel_id, '.
				'materiel_id, '.
				'projet_id, '.
				'ticket_description, '.
				'ticket_screenshot, '.
				'ticket_creation_time, '.
				'ticket_echeance_time, '.
				'ticket_resolution_time, '.
				'ticket_is_urgent, '.
				'ticket_user_matricule, '.
				'ticket_user_nom, '.
				'ticket_user_prenom, '.
				'ticket_user_email, '.
				'ticket_user_telephone, '.
				'reponse_id, '.
				'user_id_affectation, '.
				'user_id_affectation_auteur, '.
				'user_id_creation, '.
				'service_id, '.
				'etat_id, '.
				'probleme_id, '.
				'ticket_send_mail, '.
				'ticket_description_live, '.
				'ticket_id_parent, '.
				'ticket_batiment_id, '.
				'ticket_agent_motdir, '.
				'ticket_user_service_id, '.
				'type_cloture_id, '.
				'destinataire_id, '.
				') '.
		       'values ('.
				($this->ticketId != '' ? '\''. protegeChaine($this->getTicketId()) .'\', ':'NULL, ').
				($this->logicielId != '' ? '\''. protegeChaine($this->getLogicielId()) .'\', ':'NULL, ').
				($this->materielId != '' ? '\''. protegeChaine($this->getMaterielId()) .'\', ':'NULL, ').
				($this->projetId != '' ? '\''. protegeChaine($this->getProjetId()) .'\', ':'NULL, ').
				($this->ticketDescription != '' ? '\''. protegeChaine($this->getTicketDescription()) .'\', ':'NULL, ').
				($this->ticketScreenshot != '' ? '\''. protegeChaine($this->getTicketScreenshot()) .'\', ':'NULL, ').
				($this->ticketCreationTime != '' ? '\''. protegeChaine($this->getTicketCreationTime()) .'\', ':'NULL, ').
				($this->ticketEcheanceTime != '' ? '\''. protegeChaine($this->getTicketEcheanceTime()) .'\', ':'NULL, ').
				($this->ticketResolutionTime != '' ? '\''. protegeChaine($this->getTicketResolutionTime()) .'\', ':'NULL, ').
				($this->ticketIsUrgent != '' ? '\''. protegeChaine($this->getTicketIsUrgent()) .'\', ':'NULL, ').
				($this->ticketUserMatricule != '' ? '\''. protegeChaine($this->getTicketUserMatricule()) .'\', ':'NULL, ').
				($this->ticketUserNom != '' ? '\''. protegeChaine($this->getTicketUserNom()) .'\', ':'NULL, ').
				($this->ticketUserPrenom != '' ? '\''. protegeChaine($this->getTicketUserPrenom()) .'\', ':'NULL, ').
				($this->ticketUserEmail != '' ? '\''. protegeChaine($this->getTicketUserEmail()) .'\', ':'NULL, ').
				($this->ticketUserTelephone != '' ? '\''. protegeChaine($this->getTicketUserTelephone()) .'\', ':'NULL, ').
				($this->reponseId != '' ? '\''. protegeChaine($this->getReponseId()) .'\', ':'NULL, ').
				($this->userIdAffectation != '' ? '\''. protegeChaine($this->getUserIdAffectation()) .'\', ':'NULL, ').
				($this->userIdAffectationAuteur != '' ? '\''. protegeChaine($this->getUserIdAffectationAuteur()) .'\', ':'NULL, ').
				($this->userIdCreation != '' ? '\''. protegeChaine($this->getUserIdCreation()) .'\', ':'NULL, ').
				($this->serviceId != '' ? '\''. protegeChaine($this->getServiceId()) .'\', ':'NULL, ').
				($this->etatId != '' ? '\''. protegeChaine($this->getEtatId()) .'\', ':'NULL, ').
				($this->problemeId != '' ? '\''. protegeChaine($this->getProblemeId()) .'\', ':'NULL, ').
				($this->ticketSendMail != '' ? '\''. protegeChaine($this->getTicketSendMail()) .'\', ':'NULL, ').
				($this->ticketDescriptionLive != '' ? '\''. protegeChaine($this->getTicketDescriptionLive()) .'\', ':'NULL, ').
				($this->ticketIdParent != '' ? '\''. protegeChaine($this->getTicketIdParent()) .'\', ':'NULL, ').
				($this->ticketBatimentId != '' ? '\''. protegeChaine($this->getTicketBatimentId()) .'\', ':'NULL, ').
				($this->ticketAgentMotdir != '' ? '\''. protegeChaine($this->getTicketAgentMotdir()) .'\', ':'NULL, ').
				($this->ticketUserServiceId != '' ? '\''. protegeChaine($this->getTicketUserServiceId()) .'\', ':'NULL, ').
				($this->typeClotureId != '' ? '\''. protegeChaine($this->getTypeClotureId()) .'\', ':'NULL, ').
				($this->destinataireId != '' ? '\''. protegeChaine($this->getDestinataireId()) .'\', ':'NULL, ').
		       ')';
		$req = str_replace(', )', ')', $req);
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Met à jour tous les champs de la ligne dans la table
	 * @return DB résultat de l'update
	 */
	function update()
	{
		$this->verifChampsNotNull();
		$req = 'update supportdsi.ticket set '.
		       'logiciel_id='. ($this->logicielId != '' ? '\''. protegeChaine($this->getLogicielId()) .'\' ':'NULL ').
		       ', materiel_id='. ($this->materielId != '' ? '\''. protegeChaine($this->getMaterielId()) .'\' ':'NULL ').
		       ', projet_id='. ($this->projetId != '' ? '\''. protegeChaine($this->getProjetId()) .'\' ':'NULL ').
		       ', ticket_description='. ($this->ticketDescription != '' ? '\''. protegeChaine($this->getTicketDescription()) .'\' ':'NULL ').
		       ', ticket_screenshot='. ($this->ticketScreenshot != '' ? '\''. protegeChaine($this->getTicketScreenshot()) .'\' ':'NULL ').
		       ', ticket_creation_time='. ($this->ticketCreationTime != '' ? '\''. protegeChaine($this->getTicketCreationTime()) .'\' ':'NULL ').
		       ', ticket_echeance_time='. ($this->ticketEcheanceTime != '' ? '\''. protegeChaine($this->getTicketEcheanceTime()) .'\' ':'NULL ').
		       ', ticket_resolution_time='. ($this->ticketResolutionTime != '' ? '\''. protegeChaine($this->getTicketResolutionTime()) .'\' ':'NULL ').
		       ', ticket_is_urgent='. ($this->ticketIsUrgent != '' ? '\''. protegeChaine($this->getTicketIsUrgent()) .'\' ':'NULL ').
		       ', ticket_user_matricule='. ($this->ticketUserMatricule != '' ? '\''. protegeChaine($this->getTicketUserMatricule()) .'\' ':'NULL ').
		       ', ticket_user_nom='. ($this->ticketUserNom != '' ? '\''. protegeChaine($this->getTicketUserNom()) .'\' ':'NULL ').
		       ', ticket_user_prenom='. ($this->ticketUserPrenom != '' ? '\''. protegeChaine($this->getTicketUserPrenom()) .'\' ':'NULL ').
		       ', ticket_user_email='. ($this->ticketUserEmail != '' ? '\''. protegeChaine($this->getTicketUserEmail()) .'\' ':'NULL ').
		       ', ticket_user_telephone='. ($this->ticketUserTelephone != '' ? '\''. protegeChaine($this->getTicketUserTelephone()) .'\' ':'NULL ').
		       ', reponse_id='. ($this->reponseId != '' ? '\''. protegeChaine($this->getReponseId()) .'\' ':'NULL ').
		       ', user_id_affectation='. ($this->userIdAffectation != '' ? '\''. protegeChaine($this->getUserIdAffectation()) .'\' ':'NULL ').
		       ', user_id_affectation_auteur='. ($this->userIdAffectationAuteur != '' ? '\''. protegeChaine($this->getUserIdAffectationAuteur()) .'\' ':'NULL ').
		       ', user_id_creation='. ($this->userIdCreation != '' ? '\''. protegeChaine($this->getUserIdCreation()) .'\' ':'NULL ').
		       ', service_id='. ($this->serviceId != '' ? '\''. protegeChaine($this->getServiceId()) .'\' ':'NULL ').
		       ', etat_id='. ($this->etatId != '' ? '\''. protegeChaine($this->getEtatId()) .'\' ':'NULL ').
		       ', probleme_id='. ($this->problemeId != '' ? '\''. protegeChaine($this->getProblemeId()) .'\' ':'NULL ').
		       ', ticket_send_mail='. ($this->ticketSendMail != '' ? '\''. protegeChaine($this->getTicketSendMail()) .'\' ':'NULL ').
		       ', ticket_description_live='. ($this->ticketDescriptionLive != '' ? '\''. protegeChaine($this->getTicketDescriptionLive()) .'\' ':'NULL ').
		       ', ticket_id_parent='. ($this->ticketIdParent != '' ? '\''. protegeChaine($this->getTicketIdParent()) .'\' ':'NULL ').
		       ', ticket_batiment_id='. ($this->ticketBatimentId != '' ? '\''. protegeChaine($this->getTicketBatimentId()) .'\' ':'NULL ').
		       ', ticket_agent_motdir='. ($this->ticketAgentMotdir != '' ? '\''. protegeChaine($this->getTicketAgentMotdir()) .'\' ':'NULL ').
		       ', ticket_user_service_id='. ($this->ticketUserServiceId != '' ? '\''. protegeChaine($this->getTicketUserServiceId()) .'\' ':'NULL ').
		       ', type_cloture_id='. ($this->typeClotureId != '' ? '\''. protegeChaine($this->getTypeClotureId()) .'\' ':'NULL ').
		       ', destinataire_id='. ($this->destinataireId != '' ? '\''. protegeChaine($this->getDestinataireId()) .'\' ':'NULL ').
		       'WHERE ticket_id=\''. protegeChaine($this->getTicketId()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Supprime la ligne
	 * @return DB résultat de la suppression
	 */
	function delete()
	{
		$this->verifChampsNotNull();
		$req = 'delete from supportdsi.ticket '.
		       'WHERE ticket_id=\''. protegeChaine($this->getTicketId()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Récupère 1 seul élément correspondant à une ligne de la table
	 * @param Array $where tableau indexé contenant la clause where de la requete<br>
	 * Exemple: $where = array('ticket_id' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT ticket_id, logiciel_id, materiel_id, projet_id, ticket_description, ticket_screenshot, ticket_creation_time, ticket_echeance_time, ticket_resolution_time, ticket_is_urgent, ticket_user_matricule, ticket_user_nom, ticket_user_prenom, ticket_user_email, ticket_user_telephone, reponse_id, user_id_affectation, user_id_affectation_auteur, user_id_creation, service_id, etat_id, probleme_id, ticket_send_mail, ticket_description_live, ticket_id_parent, ticket_batiment_id, ticket_agent_motdir, ticket_user_service_id, type_cloture_id, destinataire_id '.
		       'FROM ticket ';
		$chWhere = '';
		foreach($where as $k => $v)
		{
			if ($chWhere != '')
				$chWhere .= 'AND ';
			else
				$chWhere .= 'WHERE ';
			$chWhere .= $k .'=\''. protegeChaine($v) .'\' ';
		}
		$req .= $chWhere;
		$res = executeReq($this->db, $req);
		while(list($ticket_id, $logiciel_id, $materiel_id, $projet_id, $ticket_description, $ticket_screenshot, $ticket_creation_time, $ticket_echeance_time, $ticket_resolution_time, $ticket_is_urgent, $ticket_user_matricule, $ticket_user_nom, $ticket_user_prenom, $ticket_user_email, $ticket_user_telephone, $reponse_id, $user_id_affectation, $user_id_affectation_auteur, $user_id_creation, $service_id, $etat_id, $probleme_id, $ticket_send_mail, $ticket_description_live, $ticket_id_parent, $ticket_batiment_id, $ticket_agent_motdir, $ticket_user_service_id, $type_cloture_id, $destinataire_id) = $res->fetchRow())
		{
			$this->setTicketId($ticket_id);
			$this->setLogicielId($logiciel_id);
			$this->setMaterielId($materiel_id);
			$this->setProjetId($projet_id);
			$this->setTicketDescription($ticket_description);
			$this->setTicketScreenshot($ticket_screenshot);
			$this->setTicketCreationTime($ticket_creation_time);
			$this->setTicketEcheanceTime($ticket_echeance_time);
			$this->setTicketResolutionTime($ticket_resolution_time);
			$this->setTicketIsUrgent($ticket_is_urgent);
			$this->setTicketUserMatricule($ticket_user_matricule);
			$this->setTicketUserNom($ticket_user_nom);
			$this->setTicketUserPrenom($ticket_user_prenom);
			$this->setTicketUserEmail($ticket_user_email);
			$this->setTicketUserTelephone($ticket_user_telephone);
			$this->setReponseId($reponse_id);
			$this->setUserIdAffectation($user_id_affectation);
			$this->setUserIdAffectationAuteur($user_id_affectation_auteur);
			$this->setUserIdCreation($user_id_creation);
			$this->setServiceId($service_id);
			$this->setEtatId($etat_id);
			$this->setProblemeId($probleme_id);
			$this->setTicketSendMail($ticket_send_mail);
			$this->setTicketDescriptionLive($ticket_description_live);
			$this->setTicketIdParent($ticket_id_parent);
			$this->setTicketBatimentId($ticket_batiment_id);
			$this->setTicketAgentMotdir($ticket_agent_motdir);
			$this->setTicketUserServiceId($ticket_user_service_id);
			$this->setTypeClotureId($type_cloture_id);
			$this->setDestinataireId($destinataire_id);
		}
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe Ticket
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>Ticket</b> : <br>';
		foreach($tab as $methodeName)
		{
			$methodeName = str_replace('set', '<font color=red>set</font>', $methodeName);
			$methodeName = str_replace('get', '<font color=green>get</font>', $methodeName);
			$methodeName = str_replace('select', '<font color=#E45000>select</font>', $methodeName);
			$methodeName = str_replace('update', '<font color=#E45000>update</font>', $methodeName);
			$methodeName = str_replace('delete', '<font color=#E45000>delete</font>', $methodeName);
			$methodeName = str_replace('insert', '<font color=#E45000>insert</font>', $methodeName);
			echo 'function '. $methodeName.'(...)<br>';
		}
	}
}

?>