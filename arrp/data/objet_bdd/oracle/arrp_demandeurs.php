<?php

/** 
 * Classe représentant la table `ARRP_DEMANDEURS`
 * @version 1.3
 */
class ArrpDemandeurs
{
	var $db;
	// Déclaration des variables représentant les colonnes de la table
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
	 * Fonction qui met à jour la variable $idDemandeur
	 * représentant la colonne `ID_DEMANDEUR` de la table `ARRP_DEMANDEURS`
	 */
	function setIdDemandeur($v)
	{
		$this->idDemandeur = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $nom
	 * représentant la colonne `NOM` de la table `ARRP_DEMANDEURS`
	 */
	function setNom($v)
	{
		$this->nom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $prenom
	 * représentant la colonne `PRENOM` de la table `ARRP_DEMANDEURS`
	 */
	function setPrenom($v)
	{
		$this->prenom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $adresse
	 * représentant la colonne `ADRESSE` de la table `ARRP_DEMANDEURS`
	 */
	function setAdresse($v)
	{
		$this->adresse = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $adresse2
	 * représentant la colonne `ADRESSE2` de la table `ARRP_DEMANDEURS`
	 */
	function setAdresse2($v)
	{
		$this->adresse2 = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $cp
	 * représentant la colonne `CP` de la table `ARRP_DEMANDEURS`
	 */
	function setCp($v)
	{
		$this->cp = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $ville
	 * représentant la colonne `VILLE` de la table `ARRP_DEMANDEURS`
	 */
	function setVille($v)
	{
		$this->ville = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $email
	 * représentant la colonne `EMAIL` de la table `ARRP_DEMANDEURS`
	 */
	function setEmail($v)
	{
		$this->email = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $tel1
	 * représentant la colonne `TEL1` de la table `ARRP_DEMANDEURS`
	 */
	function setTel1($v)
	{
		$this->tel1 = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $tel2
	 * représentant la colonne `TEL2` de la table `ARRP_DEMANDEURS`
	 */
	function setTel2($v)
	{
		$this->tel2 = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $observations
	 * représentant la colonne `OBSERVATIONS` de la table `ARRP_DEMANDEURS`
	 */
	function setObservations($v)
	{
		$this->observations = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $userSaisie
	 * représentant la colonne `USER_SAISIE` de la table `ARRP_DEMANDEURS`
	 */
	function setUserSaisie($v)
	{
		$this->userSaisie = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $dateSaisie
	 * représentant la colonne `DATE_SAISIE` de la table `ARRP_DEMANDEURS`
	 */
	function setDateSaisie($v)
	{
		$this->dateSaisie = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $userModif
	 * représentant la colonne `USER_MODIF` de la table `ARRP_DEMANDEURS`
	 */
	function setUserModif($v)
	{
		$this->userModif = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $dateModif
	 * représentant la colonne `DATE_MODIF` de la table `ARRP_DEMANDEURS`
	 */
	function setDateModif($v)
	{
		$this->dateModif = $v;
	}

	/** 
	 * Retourne la valeur de la variable $idDemandeur
	 * Cette variable représentante la colonne `ID_DEMANDEUR` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getIdDemandeur()
	{
		return $this->idDemandeur;
	}

	/** 
	 * Retourne la valeur de la variable $nom
	 * Cette variable représentante la colonne `NOM` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getNom()
	{
		return $this->nom;
	}

	/** 
	 * Retourne la valeur de la variable $prenom
	 * Cette variable représentante la colonne `PRENOM` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getPrenom()
	{
		return $this->prenom;
	}

	/** 
	 * Retourne la valeur de la variable $adresse
	 * Cette variable représentante la colonne `ADRESSE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getAdresse()
	{
		return $this->adresse;
	}

	/** 
	 * Retourne la valeur de la variable $adresse2
	 * Cette variable représentante la colonne `ADRESSE2` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getAdresse2()
	{
		return $this->adresse2;
	}

	/** 
	 * Retourne la valeur de la variable $cp
	 * Cette variable représentante la colonne `CP` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getCp()
	{
		return $this->cp;
	}

	/** 
	 * Retourne la valeur de la variable $ville
	 * Cette variable représentante la colonne `VILLE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getVille()
	{
		return $this->ville;
	}

	/** 
	 * Retourne la valeur de la variable $email
	 * Cette variable représentante la colonne `EMAIL` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getEmail()
	{
		return $this->email;
	}

	/** 
	 * Retourne la valeur de la variable $tel1
	 * Cette variable représentante la colonne `TEL1` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getTel1()
	{
		return $this->tel1;
	}

	/** 
	 * Retourne la valeur de la variable $tel2
	 * Cette variable représentante la colonne `TEL2` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getTel2()
	{
		return $this->tel2;
	}

	/** 
	 * Retourne la valeur de la variable $observations
	 * Cette variable représentante la colonne `OBSERVATIONS` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getObservations()
	{
		return $this->observations;
	}

	/** 
	 * Retourne la valeur de la variable $userSaisie
	 * Cette variable représentante la colonne `USER_SAISIE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getUserSaisie()
	{
		return $this->userSaisie;
	}

	/** 
	 * Retourne la valeur de la variable $dateSaisie
	 * Cette variable représentante la colonne `DATE_SAISIE` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getDateSaisie()
	{
		return $this->dateSaisie;
	}

	/** 
	 * Retourne la valeur de la variable $userModif
	 * Cette variable représentante la colonne `USER_MODIF` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getUserModif()
	{
		return $this->userModif;
	}

	/** 
	 * Retourne la valeur de la variable $dateModif
	 * Cette variable représentante la colonne `DATE_MODIF` de la table `ARRP_DEMANDEURS`
	 * @return mixed
	 */
	function getDateModif()
	{
		return $this->dateModif;
	}

	/** 
	 * @param DB $db connexion à la base de données
	 */
	function ArrpDemandeurs($db)
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
		if ($this->getIdDemandeur() == '')
			die('Exécution impossible car le champs OBLIGATOIRE `ID_DEMANDEUR` n\'a pas de valeur!');
	}

	/** 
	 * Insère l'élément en base
	 * @return DB résultat de l'insertion
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
	 * Met à jour tous les champs de la ligne dans la table
	 * @return DB résultat de l'update
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
	 * @return DB résultat de la suppression
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
	 * Récupère 1 seul élément correspondant à une ligne de la table
	 * @param Array $where tableau indexé contenant la clause where de la requete<br>
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
	 * Fonction qui affiche la liste des méthodes de la classe ArrpDemandeurs
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