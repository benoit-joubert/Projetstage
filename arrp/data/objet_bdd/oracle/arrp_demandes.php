<?php

/** 
 * Classe repr�sentant la table `ARRP_DEMANDES`
 * @version 1.3
 */
class ArrpDemandes
{
	var $db;
	// D�claration des variables repr�sentant les colonnes de la table
	var $idDemande = false;
	var $idDemandeur = false;
	var $contact = false;
	var $reference = false;
	var $dateDemande = false;
	var $dateReponse = false;
	var $statutDemande = false;
	var $statutAep = false;
	var $statutEu = false;
	var $observations = false;
	var $idSignataire = false;
	var $urlCarte = false;
	var $idAttestant = false;
	var $idInterlocuteur = false;
	var $userSaisie = false;
	var $dateSaisie = false;
	var $userModif = false;
	var $dateModif = false;
	var $codeCom = false;

	/** 
	 * Fonction qui met � jour la variable $idDemande
	 * repr�sentant la colonne `ID_DEMANDE` de la table `ARRP_DEMANDES`
	 */
	function setIdDemande($v)
	{
		$this->idDemande = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $idDemandeur
	 * repr�sentant la colonne `ID_DEMANDEUR` de la table `ARRP_DEMANDES`
	 */
	function setIdDemandeur($v)
	{
		$this->idDemandeur = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $contact
	 * repr�sentant la colonne `CONTACT` de la table `ARRP_DEMANDES`
	 */
	function setContact($v)
	{
		$this->contact = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $reference
	 * repr�sentant la colonne `REFERENCE` de la table `ARRP_DEMANDES`
	 */
	function setReference($v)
	{
		$this->reference = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $dateDemande
	 * repr�sentant la colonne `DATE_DEMANDE` de la table `ARRP_DEMANDES`
	 */
	function setDateDemande($v)
	{
		$this->dateDemande = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $dateReponse
	 * repr�sentant la colonne `DATE_REPONSE` de la table `ARRP_DEMANDES`
	 */
	function setDateReponse($v)
	{
		$this->dateReponse = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $statutDemande
	 * repr�sentant la colonne `STATUT_DEMANDE` de la table `ARRP_DEMANDES`
	 */
	function setStatutDemande($v)
	{
		$this->statutDemande = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $statutAep
	 * repr�sentant la colonne `STATUT_AEP` de la table `ARRP_DEMANDES`
	 */
	function setStatutAep($v)
	{
		$this->statutAep = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $statutEu
	 * repr�sentant la colonne `STATUT_EU` de la table `ARRP_DEMANDES`
	 */
	function setStatutEu($v)
	{
		$this->statutEu = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $observations
	 * repr�sentant la colonne `OBSERVATIONS` de la table `ARRP_DEMANDES`
	 */
	function setObservations($v)
	{
		$this->observations = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $idSignataire
	 * repr�sentant la colonne `ID_SIGNATAIRE` de la table `ARRP_DEMANDES`
	 */
	function setIdSignataire($v)
	{
		$this->idSignataire = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $urlCarte
	 * repr�sentant la colonne `URL_CARTE` de la table `ARRP_DEMANDES`
	 */
	function setUrlCarte($v)
	{
		$this->urlCarte = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $idAttestant
	 * repr�sentant la colonne `ID_ATTESTANT` de la table `ARRP_DEMANDES`
	 */
	function setIdAttestant($v)
	{
		$this->idAttestant = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $idInterlocuteur
	 * repr�sentant la colonne `ID_INTERLOCUTEUR` de la table `ARRP_DEMANDES`
	 */
	function setIdInterlocuteur($v)
	{
		$this->idInterlocuteur = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $userSaisie
	 * repr�sentant la colonne `USER_SAISIE` de la table `ARRP_DEMANDES`
	 */
	function setUserSaisie($v)
	{
		$this->userSaisie = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $dateSaisie
	 * repr�sentant la colonne `DATE_SAISIE` de la table `ARRP_DEMANDES`
	 */
	function setDateSaisie($v)
	{
		$this->dateSaisie = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $userModif
	 * repr�sentant la colonne `USER_MODIF` de la table `ARRP_DEMANDES`
	 */
	function setUserModif($v)
	{
		$this->userModif = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $dateModif
	 * repr�sentant la colonne `DATE_MODIF` de la table `ARRP_DEMANDES`
	 */
	function setDateModif($v)
	{
		$this->dateModif = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $codeCom
	 * repr�sentant la colonne `CODE_COM` de la table `ARRP_DEMANDES`
	 */
	function setCodeCom($v)
	{
		$this->codeCom = $v;
	}

	/** 
	 * Retourne la valeur de la variable $idDemande
	 * Cette variable repr�sentante la colonne `ID_DEMANDE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getIdDemande()
	{
		return $this->idDemande;
	}

	/** 
	 * Retourne la valeur de la variable $idDemandeur
	 * Cette variable repr�sentante la colonne `ID_DEMANDEUR` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getIdDemandeur()
	{
		return $this->idDemandeur;
	}

	/** 
	 * Retourne la valeur de la variable $contact
	 * Cette variable repr�sentante la colonne `CONTACT` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getContact()
	{
		return $this->contact;
	}

	/** 
	 * Retourne la valeur de la variable $reference
	 * Cette variable repr�sentante la colonne `REFERENCE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getReference()
	{
		return $this->reference;
	}

	/** 
	 * Retourne la valeur de la variable $dateDemande
	 * Cette variable repr�sentante la colonne `DATE_DEMANDE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getDateDemande()
	{
		return $this->dateDemande;
	}

	/** 
	 * Retourne la valeur de la variable $dateReponse
	 * Cette variable repr�sentante la colonne `DATE_REPONSE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getDateReponse()
	{
		return $this->dateReponse;
	}

	/** 
	 * Retourne la valeur de la variable $statutDemande
	 * Cette variable repr�sentante la colonne `STATUT_DEMANDE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getStatutDemande()
	{
		return $this->statutDemande;
	}

	/** 
	 * Retourne la valeur de la variable $statutAep
	 * Cette variable repr�sentante la colonne `STATUT_AEP` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getStatutAep()
	{
		return $this->statutAep;
	}

	/** 
	 * Retourne la valeur de la variable $statutEu
	 * Cette variable repr�sentante la colonne `STATUT_EU` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getStatutEu()
	{
		return $this->statutEu;
	}

	/** 
	 * Retourne la valeur de la variable $observations
	 * Cette variable repr�sentante la colonne `OBSERVATIONS` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getObservations()
	{
		return $this->observations;
	}

	/** 
	 * Retourne la valeur de la variable $idSignataire
	 * Cette variable repr�sentante la colonne `ID_SIGNATAIRE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getIdSignataire()
	{
		return $this->idSignataire;
	}

	/** 
	 * Retourne la valeur de la variable $urlCarte
	 * Cette variable repr�sentante la colonne `URL_CARTE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getUrlCarte()
	{
		return $this->urlCarte;
	}

	/** 
	 * Retourne la valeur de la variable $idAttestant
	 * Cette variable repr�sentante la colonne `ID_ATTESTANT` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getIdAttestant()
	{
		return $this->idAttestant;
	}

	/** 
	 * Retourne la valeur de la variable $idInterlocuteur
	 * Cette variable repr�sentante la colonne `ID_INTERLOCUTEUR` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getIdInterlocuteur()
	{
		return $this->idInterlocuteur;
	}

	/** 
	 * Retourne la valeur de la variable $userSaisie
	 * Cette variable repr�sentante la colonne `USER_SAISIE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getUserSaisie()
	{
		return $this->userSaisie;
	}

	/** 
	 * Retourne la valeur de la variable $dateSaisie
	 * Cette variable repr�sentante la colonne `DATE_SAISIE` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getDateSaisie()
	{
		return $this->dateSaisie;
	}

	/** 
	 * Retourne la valeur de la variable $userModif
	 * Cette variable repr�sentante la colonne `USER_MODIF` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getUserModif()
	{
		return $this->userModif;
	}

	/** 
	 * Retourne la valeur de la variable $dateModif
	 * Cette variable repr�sentante la colonne `DATE_MODIF` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getDateModif()
	{
		return $this->dateModif;
	}

	/** 
	 * Retourne la valeur de la variable $codeCom
	 * Cette variable repr�sentante la colonne `CODE_COM` de la table `ARRP_DEMANDES`
	 * @return mixed
	 */
	function getCodeCom()
	{
		return $this->codeCom;
	}

	/** 
	 * @param DB $db connexion � la base de donn�es
	 */
	function ArrpDemandes($db)
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
		if ($this->getIdDemande() == '')
			die('Ex�cution impossible car le champs OBLIGATOIRE `ID_DEMANDE` n\'a pas de valeur!');
	}

	/** 
	 * Ins�re l'�l�ment en base
	 * @return DB r�sultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_DEMANDES '.
		       '('.
				'ID_DEMANDE, '.
				'ID_DEMANDEUR, '.
				'CONTACT, '.
				'REFERENCE, '.
				'DATE_DEMANDE, '.
				'DATE_REPONSE, '.
				'STATUT_DEMANDE, '.
				'STATUT_AEP, '.
				'STATUT_EU, '.
				'OBSERVATIONS, '.
				'ID_SIGNATAIRE, '.
				'URL_CARTE, '.
				'ID_ATTESTANT, '.
				'ID_INTERLOCUTEUR, '.
				'USER_SAISIE, '.
				'DATE_SAISIE, '.
				'USER_MODIF, '.
				'DATE_MODIF, '.
				'CODE_COM, '.
				') '.
		       'values ('.
				($this->idDemande != '' ? '\''. protegeChaineOracle($this->getIdDemande()) .'\', ':'NULL, ').
				($this->idDemandeur != '' ? '\''. protegeChaineOracle($this->getIdDemandeur()) .'\', ':'NULL, ').
				($this->contact != '' ? '\''. protegeChaineOracle($this->getContact()) .'\', ':'NULL, ').
				($this->reference != '' ? '\''. protegeChaineOracle($this->getReference()) .'\', ':'NULL, ').
				($this->dateDemande != '' ? '\''. protegeChaineOracle($this->getDateDemande()) .'\', ':'NULL, ').
				($this->dateReponse != '' ? '\''. protegeChaineOracle($this->getDateReponse()) .'\', ':'NULL, ').
				($this->statutDemande != '' ? '\''. protegeChaineOracle($this->getStatutDemande()) .'\', ':'NULL, ').
				($this->statutAep != '' ? '\''. protegeChaineOracle($this->getStatutAep()) .'\', ':'NULL, ').
				($this->statutEu != '' ? '\''. protegeChaineOracle($this->getStatutEu()) .'\', ':'NULL, ').
				($this->observations != '' ? '\''. protegeChaineOracle($this->getObservations()) .'\', ':'NULL, ').
				($this->idSignataire != '' ? '\''. protegeChaineOracle($this->getIdSignataire()) .'\', ':'NULL, ').
				($this->urlCarte != '' ? '\''. protegeChaineOracle($this->getUrlCarte()) .'\', ':'NULL, ').
				($this->idAttestant != '' ? '\''. protegeChaineOracle($this->getIdAttestant()) .'\', ':'NULL, ').
				($this->idInterlocuteur != '' ? '\''. protegeChaineOracle($this->getIdInterlocuteur()) .'\', ':'NULL, ').
				($this->userSaisie != '' ? '\''. protegeChaineOracle($this->getUserSaisie()) .'\', ':'NULL, ').
				($this->dateSaisie != '' ? '\''. protegeChaineOracle($this->getDateSaisie()) .'\', ':'NULL, ').
				($this->userModif != '' ? '\''. protegeChaineOracle($this->getUserModif()) .'\', ':'NULL, ').
				($this->dateModif != '' ? '\''. protegeChaineOracle($this->getDateModif()) .'\', ':'NULL, ').
				($this->codeCom != '' ? '\''. protegeChaineOracle($this->getCodeCom()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_DEMANDES set '.
		       'ID_DEMANDEUR='. ($this->idDemandeur != '' ? '\''. protegeChaineOracle($this->getIdDemandeur()) .'\' ':'NULL ').
		       ', CONTACT='. ($this->contact != '' ? '\''. protegeChaineOracle($this->getContact()) .'\' ':'NULL ').
		       ', REFERENCE='. ($this->reference != '' ? '\''. protegeChaineOracle($this->getReference()) .'\' ':'NULL ').
		       ', DATE_DEMANDE='. ($this->dateDemande != '' ? '\''. protegeChaineOracle($this->getDateDemande()) .'\' ':'NULL ').
		       ', DATE_REPONSE='. ($this->dateReponse != '' ? '\''. protegeChaineOracle($this->getDateReponse()) .'\' ':'NULL ').
		       ', STATUT_DEMANDE='. ($this->statutDemande != '' ? '\''. protegeChaineOracle($this->getStatutDemande()) .'\' ':'NULL ').
		       ', STATUT_AEP='. ($this->statutAep != '' ? '\''. protegeChaineOracle($this->getStatutAep()) .'\' ':'NULL ').
		       ', STATUT_EU='. ($this->statutEu != '' ? '\''. protegeChaineOracle($this->getStatutEu()) .'\' ':'NULL ').
		       ', OBSERVATIONS='. ($this->observations != '' ? '\''. protegeChaineOracle($this->getObservations()) .'\' ':'NULL ').
		       ', ID_SIGNATAIRE='. ($this->idSignataire != '' ? '\''. protegeChaineOracle($this->getIdSignataire()) .'\' ':'NULL ').
		       ', URL_CARTE='. ($this->urlCarte != '' ? '\''. protegeChaineOracle($this->getUrlCarte()) .'\' ':'NULL ').
		       ', ID_ATTESTANT='. ($this->idAttestant != '' ? '\''. protegeChaineOracle($this->getIdAttestant()) .'\' ':'NULL ').
		       ', ID_INTERLOCUTEUR='. ($this->idInterlocuteur != '' ? '\''. protegeChaineOracle($this->getIdInterlocuteur()) .'\' ':'NULL ').
		       ', USER_SAISIE='. ($this->userSaisie != '' ? '\''. protegeChaineOracle($this->getUserSaisie()) .'\' ':'NULL ').
		       ', DATE_SAISIE='. ($this->dateSaisie != '' ? '\''. protegeChaineOracle($this->getDateSaisie()) .'\' ':'NULL ').
		       ', USER_MODIF='. ($this->userModif != '' ? '\''. protegeChaineOracle($this->getUserModif()) .'\' ':'NULL ').
		       ', DATE_MODIF='. ($this->dateModif != '' ? '\''. protegeChaineOracle($this->getDateModif()) .'\' ':'NULL ').
		       ', CODE_COM='. ($this->codeCom != '' ? '\''. protegeChaineOracle($this->getCodeCom()) .'\' ':'NULL ').
		       'WHERE ID_DEMANDE=\''. protegeChaineOracle($this->getIdDemande()) .'\' '.
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
		$req = 'delete from ARRP_DEMANDES '.
		       'WHERE ID_DEMANDE=\''. protegeChaineOracle($this->getIdDemande()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * R�cup�re 1 seul �l�ment correspondant � une ligne de la table
	 * @param Array $where tableau index� contenant la clause where de la requete<br>
	 * Exemple: $where = array('ID_DEMANDE' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT ID_DEMANDE, ID_DEMANDEUR, CONTACT, REFERENCE, DATE_DEMANDE, DATE_REPONSE, STATUT_DEMANDE, STATUT_AEP, STATUT_EU, OBSERVATIONS, ID_SIGNATAIRE, URL_CARTE, ID_ATTESTANT, ID_INTERLOCUTEUR, USER_SAISIE, DATE_SAISIE, USER_MODIF, DATE_MODIF, CODE_COM '.
		       'FROM ARRP_DEMANDES ';
		$chWhere = '';
		foreach($where as $k => $v)
		{
			if ($chWhere != '')
				$chWhere .= 'AND ';
			else
				$chWhere .= 'WHERE ';
			$chWhere .= $k .'=\''. protegeChaineOracle($v) .'\' ';
		}
		$req .= $chWhere;
		$res = executeReq($this->db, $req);
		while(list($ID_DEMANDE, $ID_DEMANDEUR, $CONTACT, $REFERENCE, $DATE_DEMANDE, $DATE_REPONSE, $STATUT_DEMANDE, $STATUT_AEP, $STATUT_EU, $OBSERVATIONS, $ID_SIGNATAIRE, $URL_CARTE, $ID_ATTESTANT, $ID_INTERLOCUTEUR, $USER_SAISIE, $DATE_SAISIE, $USER_MODIF, $DATE_MODIF, $CODE_COM) = $res->fetchRow())
		{
			$this->setIdDemande($ID_DEMANDE);
			$this->setIdDemandeur($ID_DEMANDEUR);
			$this->setContact($CONTACT);
			$this->setReference($REFERENCE);
			$this->setDateDemande($DATE_DEMANDE);
			$this->setDateReponse($DATE_REPONSE);
			$this->setStatutDemande($STATUT_DEMANDE);
			$this->setStatutAep($STATUT_AEP);
			$this->setStatutEu($STATUT_EU);
			$this->setObservations($OBSERVATIONS);
			$this->setIdSignataire($ID_SIGNATAIRE);
			$this->setUrlCarte($URL_CARTE);
			$this->setIdAttestant($ID_ATTESTANT);
			$this->setIdInterlocuteur($ID_INTERLOCUTEUR);
			$this->setUserSaisie($USER_SAISIE);
			$this->setDateSaisie($DATE_SAISIE);
			$this->setUserModif($USER_MODIF);
			$this->setDateModif($DATE_MODIF);
			$this->setCodeCom($CODE_COM);
		}
	}

	/** 
	 * Fonction qui affiche la liste des m�thodes de la classe ArrpDemandes
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpDemandes</b> : <br>';
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