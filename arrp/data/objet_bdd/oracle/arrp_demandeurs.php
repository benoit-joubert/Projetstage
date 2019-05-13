<?php

/** 
 * Classe repr�sentant la table `ARRP_DEMANDEURS`
 * @version 1.3
 */
class ArrpDemandeurs
{
	var $db;
	// D�claration des variables repr�sentant les colonnes de la table
	var $idDemandeur = false;
	var $nom = false;
	var $prenom = false;
	var $adresse = false;
	var $adresse2 = false;
	var $cp = false;
	var $ville = false;
	var $email = false;
	var $tel1 = false;
	var $tel2 = false;
	var $observations = false;
	var $userSaisie = false;
	var $dateSaisie = false;
	var $userModif = false;
	var $dateModif = false;

	/** 
	 * Fonction qui met � jour la variable $idDemandeur
	 * repr�sentant la colonne `ID_DEMANDEUR` de la table `ARRP_DEMANDEURS`
	 */
	function setIdDemandeur($v)
	{
		$this->idDemandeur = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $nom
	 * repr�sentant la colonne `NOM` de la table `ARRP_DEMANDEURS`
	 */
	function setNom($v)
	{
		$this->nom = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $prenom
	 * repr�sentant la colonne `PRENOM` de la table `ARRP_DEMANDEURS`
	 */
	function setPrenom($v)
	{
		$this->prenom = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $adresse
	 * repr�sentant la colonne `ADRESSE` de la table `ARRP_DEMANDEURS`
	 */
	function setAdresse($v)
	{
		$this->adresse = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $adresse2
	 * repr�sentant la colonne `ADRESSE2` de la table `ARRP_DEMANDEURS`
	 */
	function setAdresse2($v)
	{
		$this->adresse2 = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $cp
	 * repr�sentant la colonne `CP` de la table `ARRP_DEMANDEURS`
	 */
	function setCp($v)
	{
		$this->cp = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $ville
	 * repr�sentant la colonne `VILLE` de la table `ARRP_DEMANDEURS`
	 */
	function setVille($v)
	{
		$this->ville = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $email
	 * repr�sentant la colonne `EMAIL` de la table `ARRP_DEMANDEURS`
	 */
	function setEmail($v)
	{
		$this->email = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $tel1
	 * repr�sentant la colonne `TEL1` de la table `ARRP_DEMANDEURS`
	 */
	function setTel1($v)
	{
		$this->tel1 = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $tel2
	 * repr�sentant la colonne `TEL2` de la table `ARRP_DEMANDEURS`
	 */
	function setTel2($v)
	{
		$this->tel2 = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $observations
	 * repr�sentant la colonne `OBSERVATIONS` de la table `ARRP_DEMANDEURS`
	 */
	function setObservations($v)
	{
		$this->observations = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $userSaisie
	 * repr�sentant la colonne `USER_SAISIE` de la table `ARRP_DEMANDEURS`
	 */
	function setUserSaisie($v)
	{
		$this->userSaisie = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $dateSaisie
	 * repr�sentant la colonne `DATE_SAISIE` de la table `ARRP_DEMANDEURS`
	 */
	function setDateSaisie($v)
	{
		$this->dateSaisie = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $userModif
	 * repr�sentant la colonne `USER_MODIF` de la table `ARRP_DEMANDEURS`
	 */
	function setUserModif($v)
	{
		$this->userModif = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $dateModif
	 * repr�sentant la colonne `DATE_MODIF` de la table `ARRP_DEMANDEURS`
	 */
	function setDateModif($v)
	{
		$this->dateModif = $v;
	}

	/** 
	 * Retourne la valeur de la variable $idDemandeur
	 * Cette variable repr�sentante la colonne `ID_DEMANDEUR` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getIdDemandeur()
	{
		return $this->idDemandeur;
	}

	/** 
	 * Retourne la valeur de la variable $nom
	 * Cette variable repr�sentante la colonne `NOM` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getNom()
	{
		return $this->nom;
	}

	/** 
	 * Retourne la valeur de la variable $prenom
	 * Cette variable repr�sentante la colonne `PRENOM` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getPrenom()
	{
		return $this->prenom;
	}

	/** 
	 * Retourne la valeur de la variable $adresse
	 * Cette variable repr�sentante la colonne `ADRESSE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getAdresse()
	{
		return $this->adresse;
	}

	/** 
	 * Retourne la valeur de la variable $adresse2
	 * Cette variable repr�sentante la colonne `ADRESSE2` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getAdresse2()
	{
		return $this->adresse2;
	}

	/** 
	 * Retourne la valeur de la variable $cp
	 * Cette variable repr�sentante la colonne `CP` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getCp()
	{
		return $this->cp;
	}

	/** 
	 * Retourne la valeur de la variable $ville
	 * Cette variable repr�sentante la colonne `VILLE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getVille()
	{
		return $this->ville;
	}

	/** 
	 * Retourne la valeur de la variable $email
	 * Cette variable repr�sentante la colonne `EMAIL` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getEmail()
	{
		return $this->email;
	}

	/** 
	 * Retourne la valeur de la variable $tel1
	 * Cette variable repr�sentante la colonne `TEL1` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getTel1()
	{
		return $this->tel1;
	}

	/** 
	 * Retourne la valeur de la variable $tel2
	 * Cette variable repr�sentante la colonne `TEL2` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getTel2()
	{
		return $this->tel2;
	}

	/** 
	 * Retourne la valeur de la variable $observations
	 * Cette variable repr�sentante la colonne `OBSERVATIONS` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getObservations()
	{
		return $this->observations;
	}

	/** 
	 * Retourne la valeur de la variable $userSaisie
	 * Cette variable repr�sentante la colonne `USER_SAISIE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getUserSaisie()
	{
		return $this->userSaisie;
	}

	/** 
	 * Retourne la valeur de la variable $dateSaisie
	 * Cette variable repr�sentante la colonne `DATE_SAISIE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getDateSaisie()
	{
		return $this->dateSaisie;
	}

	/** 
	 * Retourne la valeur de la variable $userModif
	 * Cette variable repr�sentante la colonne `USER_MODIF` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getUserModif()
	{
		return $this->userModif;
	}

	/** 
	 * Retourne la valeur de la variable $dateModif
	 * Cette variable repr�sentante la colonne `DATE_MODIF` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getDateModif()
	{
		return $this->dateModif;
	}

	/** 
	 * @param DB $db connexion � la base de donn�es
	 */
	function ArrpDemandeurs($db)
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
		if ($this->getIdDemandeur() == '')
			die('Ex�cution impossible car le champs OBLIGATOIRE `ID_DEMANDEUR` n\'a pas de valeur!');
	}

	/** 
	 * Ins�re l'�l�ment en base
	 * @return DB r�sultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_DEMANDEURS '.
		       '('.
				'ID_DEMANDEUR, '.
				'NOM, '.
				'PRENOM, '.
				'ADRESSE, '.
				'ADRESSE2, '.
				'CP, '.
				'VILLE, '.
				'EMAIL, '.
				'TEL1, '.
				'TEL2, '.
				'OBSERVATIONS, '.
				'USER_SAISIE, '.
				'DATE_SAISIE, '.
				'USER_MODIF, '.
				'DATE_MODIF, '.
				') '.
		       'values ('.
				($this->idDemandeur != '' ? '\''. protegeChaineOracle($this->getIdDemandeur()) .'\', ':'NULL, ').
				($this->nom != '' ? '\''. protegeChaineOracle($this->getNom()) .'\', ':'NULL, ').
				($this->prenom != '' ? '\''. protegeChaineOracle($this->getPrenom()) .'\', ':'NULL, ').
				($this->adresse != '' ? '\''. protegeChaineOracle($this->getAdresse()) .'\', ':'NULL, ').
				($this->adresse2 != '' ? '\''. protegeChaineOracle($this->getAdresse2()) .'\', ':'NULL, ').
				($this->cp != '' ? '\''. protegeChaineOracle($this->getCp()) .'\', ':'NULL, ').
				($this->ville != '' ? '\''. protegeChaineOracle($this->getVille()) .'\', ':'NULL, ').
				($this->email != '' ? '\''. protegeChaineOracle($this->getEmail()) .'\', ':'NULL, ').
				($this->tel1 != '' ? '\''. protegeChaineOracle($this->getTel1()) .'\', ':'NULL, ').
				($this->tel2 != '' ? '\''. protegeChaineOracle($this->getTel2()) .'\', ':'NULL, ').
				($this->observations != '' ? '\''. protegeChaineOracle($this->getObservations()) .'\', ':'NULL, ').
				($this->userSaisie != '' ? '\''. protegeChaineOracle($this->getUserSaisie()) .'\', ':'NULL, ').
				($this->dateSaisie != '' ? '\''. protegeChaineOracle($this->getDateSaisie()) .'\', ':'NULL, ').
				($this->userModif != '' ? '\''. protegeChaineOracle($this->getUserModif()) .'\', ':'NULL, ').
				($this->dateModif != '' ? '\''. protegeChaineOracle($this->getDateModif()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_DEMANDEURS set '.
		       'NOM='. ($this->nom != '' ? '\''. protegeChaineOracle($this->getNom()) .'\' ':'NULL ').
		       ', PRENOM='. ($this->prenom != '' ? '\''. protegeChaineOracle($this->getPrenom()) .'\' ':'NULL ').
		       ', ADRESSE='. ($this->adresse != '' ? '\''. protegeChaineOracle($this->getAdresse()) .'\' ':'NULL ').
		       ', ADRESSE2='. ($this->adresse2 != '' ? '\''. protegeChaineOracle($this->getAdresse2()) .'\' ':'NULL ').
		       ', CP='. ($this->cp != '' ? '\''. protegeChaineOracle($this->getCp()) .'\' ':'NULL ').
		       ', VILLE='. ($this->ville != '' ? '\''. protegeChaineOracle($this->getVille()) .'\' ':'NULL ').
		       ', EMAIL='. ($this->email != '' ? '\''. protegeChaineOracle($this->getEmail()) .'\' ':'NULL ').
		       ', TEL1='. ($this->tel1 != '' ? '\''. protegeChaineOracle($this->getTel1()) .'\' ':'NULL ').
		       ', TEL2='. ($this->tel2 != '' ? '\''. protegeChaineOracle($this->getTel2()) .'\' ':'NULL ').
		       ', OBSERVATIONS='. ($this->observations != '' ? '\''. protegeChaineOracle($this->getObservations()) .'\' ':'NULL ').
		       ', USER_SAISIE='. ($this->userSaisie != '' ? '\''. protegeChaineOracle($this->getUserSaisie()) .'\' ':'NULL ').
		       ', DATE_SAISIE='. ($this->dateSaisie != '' ? '\''. protegeChaineOracle($this->getDateSaisie()) .'\' ':'NULL ').
		       ', USER_MODIF='. ($this->userModif != '' ? '\''. protegeChaineOracle($this->getUserModif()) .'\' ':'NULL ').
		       ', DATE_MODIF='. ($this->dateModif != '' ? '\''. protegeChaineOracle($this->getDateModif()) .'\' ':'NULL ').
		       'WHERE ID_DEMANDEUR=\''. protegeChaineOracle($this->getIdDemandeur()) .'\' '.
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
		$req = 'delete from ARRP_DEMANDEURS '.
		       'WHERE ID_DEMANDEUR=\''. protegeChaineOracle($this->getIdDemandeur()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * R�cup�re 1 seul �l�ment correspondant � une ligne de la table
	 * @param Array $where tableau index� contenant la clause where de la requete<br>
	 * Exemple: $where = array('ID_DEMANDEUR' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT ID_DEMANDEUR, NOM, PRENOM, ADRESSE, ADRESSE2, CP, VILLE, EMAIL, TEL1, TEL2, OBSERVATIONS, USER_SAISIE, DATE_SAISIE, USER_MODIF, DATE_MODIF '.
		       'FROM ARRP_DEMANDEURS ';
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
		while(list($ID_DEMANDEUR, $NOM, $PRENOM, $ADRESSE, $ADRESSE2, $CP, $VILLE, $EMAIL, $TEL1, $TEL2, $OBSERVATIONS, $USER_SAISIE, $DATE_SAISIE, $USER_MODIF, $DATE_MODIF) = $res->fetchRow())
		{
			$this->setIdDemandeur($ID_DEMANDEUR);
			$this->setNom($NOM);
			$this->setPrenom($PRENOM);
			$this->setAdresse($ADRESSE);
			$this->setAdresse2($ADRESSE2);
			$this->setCp($CP);
			$this->setVille($VILLE);
			$this->setEmail($EMAIL);
			$this->setTel1($TEL1);
			$this->setTel2($TEL2);
			$this->setObservations($OBSERVATIONS);
			$this->setUserSaisie($USER_SAISIE);
			$this->setDateSaisie($DATE_SAISIE);
			$this->setUserModif($USER_MODIF);
			$this->setDateModif($DATE_MODIF);
		}
	}

	/** 
	 * Fonction qui affiche la liste des m�thodes de la classe ArrpDemandeurs
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpDemandeurs</b> : <br>';
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