<?php

/** 
 * Classe représentant la table `ARRP_USERS`
 * @version 1.3
 */
class ArrpUsers
{
	var $db;
	// Déclaration des variables représentant les colonnes de la table
	var $loginLdap = false;
	var $nom = false;
	var $droit = false;
	var $actif = false;
	var $codeCom = false;
	var $defaultCom = false;
	var $lastLogin = false;

	/** 
	 * Fonction qui met à jour la variable $loginLdap
	 * représentant la colonne `LOGIN_LDAP` de la table `ARRP_USERS`
	 */
	function setLoginLdap($v)
	{
		$this->loginLdap = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $nom
	 * représentant la colonne `NOM` de la table `ARRP_USERS`
	 */
	function setNom($v)
	{
		$this->nom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $droit
	 * représentant la colonne `DROIT` de la table `ARRP_USERS`
	 */
	function setDroit($v)
	{
		$this->droit = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $actif
	 * représentant la colonne `ACTIF` de la table `ARRP_USERS`
	 */
	function setActif($v)
	{
		$this->actif = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $codeCom
	 * représentant la colonne `CODE_COM` de la table `ARRP_USERS`
	 */
	function setCodeCom($v)
	{
		$this->codeCom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $defaultCom
	 * représentant la colonne `DEFAULT_COM` de la table `ARRP_USERS`
	 */
	function setDefaultCom($v)
	{
		$this->defaultCom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $lastLogin
	 * représentant la colonne `LAST_LOGIN` de la table `ARRP_USERS`
	 */
	function setLastLogin($v)
	{
		$this->lastLogin = $v;
	}

	/** 
	 * Retourne la valeur de la variable $loginLdap
	 * Cette variable représentante la colonne `LOGIN_LDAP` de la table `ARRP_USERS`
	 * @return mixed
	 */
	function getLoginLdap()
	{
		return $this->loginLdap;
	}

	/** 
	 * Retourne la valeur de la variable $nom
	 * Cette variable représentante la colonne `NOM` de la table `ARRP_USERS`
	 * @return mixed
	 */
	function getNom()
	{
		return $this->nom;
	}

	/** 
	 * Retourne la valeur de la variable $droit
	 * Cette variable représentante la colonne `DROIT` de la table `ARRP_USERS`
	 * @return mixed
	 */
	function getDroit()
	{
		return $this->droit;
	}

	/** 
	 * Retourne la valeur de la variable $actif
	 * Cette variable représentante la colonne `ACTIF` de la table `ARRP_USERS`
	 * @return mixed
	 */
	function getActif()
	{
		return $this->actif;
	}

	/** 
	 * Retourne la valeur de la variable $codeCom
	 * Cette variable représentante la colonne `CODE_COM` de la table `ARRP_USERS`
	 * @return mixed
	 */
	function getCodeCom()
	{
		return $this->codeCom;
	}

	/** 
	 * Retourne la valeur de la variable $defaultCom
	 * Cette variable représentante la colonne `DEFAULT_COM` de la table `ARRP_USERS`
	 * @return mixed
	 */
	function getDefaultCom()
	{
		return $this->defaultCom;
	}

	/** 
	 * Retourne la valeur de la variable $lastLogin
	 * Cette variable représentante la colonne `LAST_LOGIN` de la table `ARRP_USERS`
	 * @return mixed
	 */
	function getLastLogin()
	{
		return $this->lastLogin;
	}

	/** 
	 * @param DB $db connexion à la base de données
	 */
	function ArrpUsers($db)
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
		if ($this->getLoginLdap() == '')
			die('Exécution impossible car le champs OBLIGATOIRE `LOGIN_LDAP` n\'a pas de valeur!');
	}

	/** 
	 * Insère l'élément en base
	 * @return DB résultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_USERS '.
		       '('.
				'LOGIN_LDAP, '.
				'NOM, '.
				'DROIT, '.
				'ACTIF, '.
				'CODE_COM, '.
				'DEFAULT_COM, '.
				'LAST_LOGIN, '.
				') '.
		       'values ('.
				($this->loginLdap != '' ? '\''. protegeChaineOracle($this->getLoginLdap()) .'\', ':'NULL, ').
				($this->nom != '' ? '\''. protegeChaineOracle($this->getNom()) .'\', ':'NULL, ').
				($this->droit != '' ? '\''. protegeChaineOracle($this->getDroit()) .'\', ':'NULL, ').
				($this->actif != '' ? '\''. protegeChaineOracle($this->getActif()) .'\', ':'NULL, ').
				($this->codeCom != '' ? '\''. protegeChaineOracle($this->getCodeCom()) .'\', ':'NULL, ').
				($this->defaultCom != '' ? '\''. protegeChaineOracle($this->getDefaultCom()) .'\', ':'NULL, ').
				($this->lastLogin != '' ? '\''. protegeChaineOracle($this->getLastLogin()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_USERS set '.
		       'NOM='. ($this->nom != '' ? '\''. protegeChaineOracle($this->getNom()) .'\' ':'NULL ').
		       ', DROIT='. ($this->droit != '' ? '\''. protegeChaineOracle($this->getDroit()) .'\' ':'NULL ').
		       ', ACTIF='. ($this->actif != '' ? '\''. protegeChaineOracle($this->getActif()) .'\' ':'NULL ').
		       ', CODE_COM='. ($this->codeCom != '' ? '\''. protegeChaineOracle($this->getCodeCom()) .'\' ':'NULL ').
		       ', DEFAULT_COM='. ($this->defaultCom != '' ? '\''. protegeChaineOracle($this->getDefaultCom()) .'\' ':'NULL ').
		       ', LAST_LOGIN='. ($this->lastLogin != '' ? '\''. protegeChaineOracle($this->getLastLogin()) .'\' ':'NULL ').
		       'WHERE LOGIN_LDAP=\''. protegeChaineOracle($this->getLoginLdap()) .'\' '.
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
		$req = 'delete from ARRP_USERS '.
		       'WHERE LOGIN_LDAP=\''. protegeChaineOracle($this->getLoginLdap()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Récupère 1 seul élément correspondant à une ligne de la table
	 * @param Array $where tableau indexé contenant la clause where de la requete<br>
	 * Exemple: $where = array('LOGIN_LDAP' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT LOGIN_LDAP, NOM, DROIT, ACTIF, CODE_COM, DEFAULT_COM, LAST_LOGIN '.
		       'FROM ARRP_USERS ';
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
		while(list($LOGIN_LDAP, $NOM, $DROIT, $ACTIF, $CODE_COM, $DEFAULT_COM, $LAST_LOGIN) = $res->fetchRow())
		{
			$this->setLoginLdap($LOGIN_LDAP);
			$this->setNom($NOM);
			$this->setDroit($DROIT);
			$this->setActif($ACTIF);
			$this->setCodeCom($CODE_COM);
			$this->setDefaultCom($DEFAULT_COM);
			$this->setLastLogin($LAST_LOGIN);
		}
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ArrpUsers
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpUsers</b> : <br>';
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