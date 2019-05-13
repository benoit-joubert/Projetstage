<?php

/** 
 * Classe repr�sentant la table `ticket`
 * @version 1.3
 */
class SupportDsiTicket
{
	var $db;
	// D�claration des variables repr�sentant les colonnes de la table
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
	 * Fonction qui met � jour la variable $ticketId
	 * repr�sentant la colonne `ticket_id` de la table `ticket`
	 */
	function setTicketId($v)
	{
		$this->ticketId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $logicielId
	 * repr�sentant la colonne `logiciel_id` de la table `ticket`
	 */
	function setLogicielId($v)
	{
		$this->logicielId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $materielId
	 * repr�sentant la colonne `materiel_id` de la table `ticket`
	 */
	function setMaterielId($v)
	{
		$this->materielId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $projetId
	 * repr�sentant la colonne `projet_id` de la table `ticket`
	 */
	function setProjetId($v)
	{
		$this->projetId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketDescription
	 * repr�sentant la colonne `ticket_description` de la table `ticket`
	 */
	function setTicketDescription($v)
	{
		$this->ticketDescription = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketScreenshot
	 * repr�sentant la colonne `ticket_screenshot` de la table `ticket`
	 */
	function setTicketScreenshot($v)
	{
		$this->ticketScreenshot = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketCreationTime
	 * repr�sentant la colonne `ticket_creation_time` de la table `ticket`
	 */
	function setTicketCreationTime($v)
	{
		$this->ticketCreationTime = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketEcheanceTime
	 * repr�sentant la colonne `ticket_echeance_time` de la table `ticket`
	 */
	function setTicketEcheanceTime($v)
	{
		$this->ticketEcheanceTime = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketResolutionTime
	 * repr�sentant la colonne `ticket_resolution_time` de la table `ticket`
	 */
	function setTicketResolutionTime($v)
	{
		$this->ticketResolutionTime = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketIsUrgent
	 * repr�sentant la colonne `ticket_is_urgent` de la table `ticket`
	 */
	function setTicketIsUrgent($v)
	{
		$this->ticketIsUrgent = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketUserMatricule
	 * repr�sentant la colonne `ticket_user_matricule` de la table `ticket`
	 */
	function setTicketUserMatricule($v)
	{
		$this->ticketUserMatricule = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketUserNom
	 * repr�sentant la colonne `ticket_user_nom` de la table `ticket`
	 */
	function setTicketUserNom($v)
	{
		$this->ticketUserNom = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketUserPrenom
	 * repr�sentant la colonne `ticket_user_prenom` de la table `ticket`
	 */
	function setTicketUserPrenom($v)
	{
		$this->ticketUserPrenom = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketUserEmail
	 * repr�sentant la colonne `ticket_user_email` de la table `ticket`
	 */
	function setTicketUserEmail($v)
	{
		$this->ticketUserEmail = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketUserTelephone
	 * repr�sentant la colonne `ticket_user_telephone` de la table `ticket`
	 */
	function setTicketUserTelephone($v)
	{
		$this->ticketUserTelephone = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $reponseId
	 * repr�sentant la colonne `reponse_id` de la table `ticket`
	 */
	function setReponseId($v)
	{
		$this->reponseId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $userIdAffectation
	 * repr�sentant la colonne `user_id_affectation` de la table `ticket`
	 */
	function setUserIdAffectation($v)
	{
		$this->userIdAffectation = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $userIdAffectationAuteur
	 * repr�sentant la colonne `user_id_affectation_auteur` de la table `ticket`
	 */
	function setUserIdAffectationAuteur($v)
	{
		$this->userIdAffectationAuteur = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $userIdCreation
	 * repr�sentant la colonne `user_id_creation` de la table `ticket`
	 */
	function setUserIdCreation($v)
	{
		$this->userIdCreation = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $serviceId
	 * repr�sentant la colonne `service_id` de la table `ticket`
	 */
	function setServiceId($v)
	{
		$this->serviceId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $etatId
	 * repr�sentant la colonne `etat_id` de la table `ticket`
	 */
	function setEtatId($v)
	{
		$this->etatId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $problemeId
	 * repr�sentant la colonne `probleme_id` de la table `ticket`
	 */
	function setProblemeId($v)
	{
		$this->problemeId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketSendMail
	 * repr�sentant la colonne `ticket_send_mail` de la table `ticket`
	 */
	function setTicketSendMail($v)
	{
		$this->ticketSendMail = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketDescriptionLive
	 * repr�sentant la colonne `ticket_description_live` de la table `ticket`
	 */
	function setTicketDescriptionLive($v)
	{
		$this->ticketDescriptionLive = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketIdParent
	 * repr�sentant la colonne `ticket_id_parent` de la table `ticket`
	 */
	function setTicketIdParent($v)
	{
		$this->ticketIdParent = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketBatimentId
	 * repr�sentant la colonne `ticket_batiment_id` de la table `ticket`
	 */
	function setTicketBatimentId($v)
	{
		$this->ticketBatimentId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketAgentMotdir
	 * repr�sentant la colonne `ticket_agent_motdir` de la table `ticket`
	 */
	function setTicketAgentMotdir($v)
	{
		$this->ticketAgentMotdir = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ticketUserServiceId
	 * repr�sentant la colonne `ticket_user_service_id` de la table `ticket`
	 */
	function setTicketUserServiceId($v)
	{
		$this->ticketUserServiceId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $typeClotureId
	 * repr�sentant la colonne `type_cloture_id` de la table `ticket`
	 */
	function setTypeClotureId($v)
	{
		$this->typeClotureId = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $destinataireId
	 * repr�sentant la colonne `destinataire_id` de la table `ticket`
	 */
	function setDestinataireId($v)
	{
		$this->destinataireId = $v;
	}

	/** 
	 * Retourne la valeur de la variable $ticketId
	 * Cette variable repr�sentante la colonne `ticket_id` de la table `ticket`
	 * @return mixed
	 */
	function getTicketId()
	{
		return $this->ticketId;
	}

	/** 
	 * Retourne la valeur de la variable $logicielId
	 * Cette variable repr�sentante la colonne `logiciel_id` de la table `ticket`
	 * @return mixed
	 */
	function getLogicielId()
	{
		return $this->logicielId;
	}

	/** 
	 * Retourne la valeur de la variable $materielId
	 * Cette variable repr�sentante la colonne `materiel_id` de la table `ticket`
	 * @return mixed
	 */
	function getMaterielId()
	{
		return $this->materielId;
	}

	/** 
	 * Retourne la valeur de la variable $projetId
	 * Cette variable repr�sentante la colonne `projet_id` de la table `ticket`
	 * @return mixed
	 */
	function getProjetId()
	{
		return $this->projetId;
	}

	/** 
	 * Retourne la valeur de la variable $ticketDescription
	 * Cette variable repr�sentante la colonne `ticket_description` de la table `ticket`
	 * @return mixed
	 */
	function getTicketDescription()
	{
		return $this->ticketDescription;
	}

	/** 
	 * Retourne la valeur de la variable $ticketScreenshot
	 * Cette variable repr�sentante la colonne `ticket_screenshot` de la table `ticket`
	 * @return mixed
	 */
	function getTicketScreenshot()
	{
		return $this->ticketScreenshot;
	}

	/** 
	 * Retourne la valeur de la variable $ticketCreationTime
	 * Cette variable repr�sentante la colonne `ticket_creation_time` de la table `ticket`
	 * @return mixed
	 */
	function getTicketCreationTime()
	{
		return $this->ticketCreationTime;
	}

	/** 
	 * Retourne la valeur de la variable $ticketEcheanceTime
	 * Cette variable repr�sentante la colonne `ticket_echeance_time` de la table `ticket`
	 * @return mixed
	 */
	function getTicketEcheanceTime()
	{
		return $this->ticketEcheanceTime;
	}

	/** 
	 * Retourne la valeur de la variable $ticketResolutionTime
	 * Cette variable repr�sentante la colonne `ticket_resolution_time` de la table `ticket`
	 * @return mixed
	 */
	function getTicketResolutionTime()
	{
		return $this->ticketResolutionTime;
	}

	/** 
	 * Retourne la valeur de la variable $ticketIsUrgent
	 * Cette variable repr�sentante la colonne `ticket_is_urgent` de la table `ticket`
	 * @return mixed
	 */
	function getTicketIsUrgent()
	{
		return $this->ticketIsUrgent;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserMatricule
	 * Cette variable repr�sentante la colonne `ticket_user_matricule` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserMatricule()
	{
		return $this->ticketUserMatricule;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserNom
	 * Cette variable repr�sentante la colonne `ticket_user_nom` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserNom()
	{
		return $this->ticketUserNom;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserPrenom
	 * Cette variable repr�sentante la colonne `ticket_user_prenom` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserPrenom()
	{
		return $this->ticketUserPrenom;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserEmail
	 * Cette variable repr�sentante la colonne `ticket_user_email` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserEmail()
	{
		return $this->ticketUserEmail;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserTelephone
	 * Cette variable repr�sentante la colonne `ticket_user_telephone` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserTelephone()
	{
		return $this->ticketUserTelephone;
	}

	/** 
	 * Retourne la valeur de la variable $reponseId
	 * Cette variable repr�sentante la colonne `reponse_id` de la table `ticket`
	 * @return mixed
	 */
	function getReponseId()
	{
		return $this->reponseId;
	}

	/** 
	 * Retourne la valeur de la variable $userIdAffectation
	 * Cette variable repr�sentante la colonne `user_id_affectation` de la table `ticket`
	 * @return mixed
	 */
	function getUserIdAffectation()
	{
		return $this->userIdAffectation;
	}

	/** 
	 * Retourne la valeur de la variable $userIdAffectationAuteur
	 * Cette variable repr�sentante la colonne `user_id_affectation_auteur` de la table `ticket`
	 * @return mixed
	 */
	function getUserIdAffectationAuteur()
	{
		return $this->userIdAffectationAuteur;
	}

	/** 
	 * Retourne la valeur de la variable $userIdCreation
	 * Cette variable repr�sentante la colonne `user_id_creation` de la table `ticket`
	 * @return mixed
	 */
	function getUserIdCreation()
	{
		return $this->userIdCreation;
	}

	/** 
	 * Retourne la valeur de la variable $serviceId
	 * Cette variable repr�sentante la colonne `service_id` de la table `ticket`
	 * @return mixed
	 */
	function getServiceId()
	{
		return $this->serviceId;
	}

	/** 
	 * Retourne la valeur de la variable $etatId
	 * Cette variable repr�sentante la colonne `etat_id` de la table `ticket`
	 * @return mixed
	 */
	function getEtatId()
	{
		return $this->etatId;
	}

	/** 
	 * Retourne la valeur de la variable $problemeId
	 * Cette variable repr�sentante la colonne `probleme_id` de la table `ticket`
	 * @return mixed
	 */
	function getProblemeId()
	{
		return $this->problemeId;
	}

	/** 
	 * Retourne la valeur de la variable $ticketSendMail
	 * Cette variable repr�sentante la colonne `ticket_send_mail` de la table `ticket`
	 * @return mixed
	 */
	function getTicketSendMail()
	{
		return $this->ticketSendMail;
	}

	/** 
	 * Retourne la valeur de la variable $ticketDescriptionLive
	 * Cette variable repr�sentante la colonne `ticket_description_live` de la table `ticket`
	 * @return mixed
	 */
	function getTicketDescriptionLive()
	{
		return $this->ticketDescriptionLive;
	}

	/** 
	 * Retourne la valeur de la variable $ticketIdParent
	 * Cette variable repr�sentante la colonne `ticket_id_parent` de la table `ticket`
	 * @return mixed
	 */
	function getTicketIdParent()
	{
		return $this->ticketIdParent;
	}

	/** 
	 * Retourne la valeur de la variable $ticketBatimentId
	 * Cette variable repr�sentante la colonne `ticket_batiment_id` de la table `ticket`
	 * @return mixed
	 */
	function getTicketBatimentId()
	{
		return $this->ticketBatimentId;
	}

	/** 
	 * Retourne la valeur de la variable $ticketAgentMotdir
	 * Cette variable repr�sentante la colonne `ticket_agent_motdir` de la table `ticket`
	 * @return mixed
	 */
	function getTicketAgentMotdir()
	{
		return $this->ticketAgentMotdir;
	}

	/** 
	 * Retourne la valeur de la variable $ticketUserServiceId
	 * Cette variable repr�sentante la colonne `ticket_user_service_id` de la table `ticket`
	 * @return mixed
	 */
	function getTicketUserServiceId()
	{
		return $this->ticketUserServiceId;
	}

	/** 
	 * Retourne la valeur de la variable $typeClotureId
	 * Cette variable repr�sentante la colonne `type_cloture_id` de la table `ticket`
	 * @return mixed
	 */
	function getTypeClotureId()
	{
		return $this->typeClotureId;
	}

	/** 
	 * Retourne la valeur de la variable $destinataireId
	 * Cette variable repr�sentante la colonne `destinataire_id` de la table `ticket`
	 * @return mixed
	 */
	function getDestinataireId()
	{
		return $this->destinataireId;
	}

	/** 
	 * @param DB $db connexion � la base de donn�es
	 */
	function SupportDsiTicket($db)
	{
		return $this->db = $db;
	}

	/** 
	 * V�rifie si les champs NOT NULL ont bien une valeur
	 * G�n�re un die en cas d'erreur
	 */
	function verifChampsNotNull()
	{
	}

	/** 
	 * V�rifie si les champs qui doivent �tre des cl�s primaires ont bien une valeur
	 * G�n�re un die en cas d'erreur
	 */
	function verifChampsPrimaryKey()
	{
		if ($this->getTicketId() == '')
			die('Ex�cution impossible car le champs OBLIGATOIRE `ticket_id` n\'a pas de valeur!');
	}

	/** 
	 * Ins�re l'�l�ment en base
	 * @return DB r�sultat de l'insertion
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
	 * Met � jour tous les champs de la ligne dans la table
	 * @return DB r�sultat de l'update
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
	 * @return DB r�sultat de la suppression
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
	 * R�cup�re 1 seul �l�ment correspondant � une ligne de la table
	 * @param Array $where tableau index� contenant la clause where de la requete<br>
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
	 * Fonction qui affiche la liste des m�thodes de la classe Ticket
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