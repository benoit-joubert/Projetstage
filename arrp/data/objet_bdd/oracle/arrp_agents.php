<?php

/** 
 * Classe représentant la table `ARRP_AGENTS`
 * @version 1.3
 */
class ArrpAgents
{
	var $db;
	// Déclaration des variables représentant les colonnes de la table
	var $idAgent = false;
	var $typeAgent = false;
	var $agent = false;
	var $qualite = false;
	var $qualite2 = false;
	var $tel = false;
	var $email = false;
	var $actif = false;
	var $fax = false;
	var $isDefault = false;

	/** 
	 * Fonction qui met à jour la variable $idAgent
	 * représentant la colonne `ID_AGENT` de la table `ARRP_AGENTS`
	 */
	function setIdAgent($v)
	{
		$this->idAgent = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $typeAgent
	 * représentant la colonne `TYPE_AGENT` de la table `ARRP_AGENTS`
	 */
	function setTypeAgent($v)
	{
		$this->typeAgent = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $agent
	 * représentant la colonne `AGENT` de la table `ARRP_AGENTS`
	 */
	function setAgent($v)
	{
		$this->agent = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $qualite
	 * représentant la colonne `QUALITE` de la table `ARRP_AGENTS`
	 */
	function setQualite($v)
	{
		$this->qualite = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $qualite2
	 * représentant la colonne `QUALITE2` de la table `ARRP_AGENTS`
	 */
	function setQualite2($v)
	{
		$this->qualite2 = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $tel
	 * représentant la colonne `TEL` de la table `ARRP_AGENTS`
	 */
	function setTel($v)
	{
		$this->tel = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $email
	 * représentant la colonne `EMAIL` de la table `ARRP_AGENTS`
	 */
	function setEmail($v)
	{
		$this->email = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $actif
	 * représentant la colonne `ACTIF` de la table `ARRP_AGENTS`
	 */
	function setActif($v)
	{
		$this->actif = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $fax
	 * représentant la colonne `FAX` de la table `ARRP_AGENTS`
	 */
	function setFax($v)
	{
		$this->fax = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $isDefault
	 * représentant la colonne `IS_DEFAULT` de la table `ARRP_AGENTS`
	 */
	function setIsDefault($v)
	{
		$this->isDefault = $v;
	}

	/** 
	 * Retourne la valeur de la variable $idAgent
	 * Cette variable représentante la colonne `ID_AGENT` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getIdAgent()
	{
		return $this->idAgent;
	}

	/** 
	 * Retourne la valeur de la variable $typeAgent
	 * Cette variable représentante la colonne `TYPE_AGENT` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getTypeAgent()
	{
		return $this->typeAgent;
	}

	/** 
	 * Retourne la valeur de la variable $agent
	 * Cette variable représentante la colonne `AGENT` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getAgent()
	{
		return $this->agent;
	}

	/** 
	 * Retourne la valeur de la variable $qualite
	 * Cette variable représentante la colonne `QUALITE` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getQualite()
	{
		return $this->qualite;
	}

	/** 
	 * Retourne la valeur de la variable $qualite2
	 * Cette variable représentante la colonne `QUALITE2` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getQualite2()
	{
		return $this->qualite2;
	}

	/** 
	 * Retourne la valeur de la variable $tel
	 * Cette variable représentante la colonne `TEL` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getTel()
	{
		return $this->tel;
	}

	/** 
	 * Retourne la valeur de la variable $email
	 * Cette variable représentante la colonne `EMAIL` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getEmail()
	{
		return $this->email;
	}

	/** 
	 * Retourne la valeur de la variable $actif
	 * Cette variable représentante la colonne `ACTIF` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getActif()
	{
		return $this->actif;
	}

	/** 
	 * Retourne la valeur de la variable $fax
	 * Cette variable représentante la colonne `FAX` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getFax()
	{
		return $this->fax;
	}

	/** 
	 * Retourne la valeur de la variable $isDefault
	 * Cette variable représentante la colonne `IS_DEFAULT` de la table `ARRP_AGENTS`
	 * @return mixed
	 */
	function getIsDefault()
	{
		return $this->isDefault;
	}

	/** 
	 * @param DB $db connexion à la base de données
	 */
	function ArrpAgents($db)
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
		if ($this->getIdAgent() == '')
			die('Exécution impossible car le champs OBLIGATOIRE `ID_AGENT` n\'a pas de valeur!');
	}

	/** 
	 * Insère l'élément en base
	 * @return DB résultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_AGENTS '.
		       '('.
				'ID_AGENT, '.
				'TYPE_AGENT, '.
				'AGENT, '.
				'QUALITE, '.
				'QUALITE2, '.
				'TEL, '.
				'EMAIL, '.
				'ACTIF, '.
				'FAX, '.
				'IS_DEFAULT, '.
				') '.
		       'values ('.
				($this->idAgent != '' ? '\''. protegeChaineOracle($this->getIdAgent()) .'\', ':'NULL, ').
				($this->typeAgent != '' ? '\''. protegeChaineOracle($this->getTypeAgent()) .'\', ':'NULL, ').
				($this->agent != '' ? '\''. protegeChaineOracle($this->getAgent()) .'\', ':'NULL, ').
				($this->qualite != '' ? '\''. protegeChaineOracle($this->getQualite()) .'\', ':'NULL, ').
				($this->qualite2 != '' ? '\''. protegeChaineOracle($this->getQualite2()) .'\', ':'NULL, ').
				($this->tel != '' ? '\''. protegeChaineOracle($this->getTel()) .'\', ':'NULL, ').
				($this->email != '' ? '\''. protegeChaineOracle($this->getEmail()) .'\', ':'NULL, ').
				($this->actif != '' ? '\''. protegeChaineOracle($this->getActif()) .'\', ':'NULL, ').
				($this->fax != '' ? '\''. protegeChaineOracle($this->getFax()) .'\', ':'NULL, ').
				($this->isDefault != '' ? '\''. protegeChaineOracle($this->getIsDefault()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_AGENTS set '.
		       'TYPE_AGENT='. ($this->typeAgent != '' ? '\''. protegeChaineOracle($this->getTypeAgent()) .'\' ':'NULL ').
		       ', AGENT='. ($this->agent != '' ? '\''. protegeChaineOracle($this->getAgent()) .'\' ':'NULL ').
		       ', QUALITE='. ($this->qualite != '' ? '\''. protegeChaineOracle($this->getQualite()) .'\' ':'NULL ').
		       ', QUALITE2='. ($this->qualite2 != '' ? '\''. protegeChaineOracle($this->getQualite2()) .'\' ':'NULL ').
		       ', TEL='. ($this->tel != '' ? '\''. protegeChaineOracle($this->getTel()) .'\' ':'NULL ').
		       ', EMAIL='. ($this->email != '' ? '\''. protegeChaineOracle($this->getEmail()) .'\' ':'NULL ').
		       ', ACTIF='. ($this->actif != '' ? '\''. protegeChaineOracle($this->getActif()) .'\' ':'NULL ').
		       ', FAX='. ($this->fax != '' ? '\''. protegeChaineOracle($this->getFax()) .'\' ':'NULL ').
		       ', IS_DEFAULT='. ($this->isDefault != '' ? '\''. protegeChaineOracle($this->getIsDefault()) .'\' ':'NULL ').
		       'WHERE ID_AGENT=\''. protegeChaineOracle($this->getIdAgent()) .'\' '.
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
		$req = 'delete from ARRP_AGENTS '.
		       'WHERE ID_AGENT=\''. protegeChaineOracle($this->getIdAgent()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Récupère 1 seul élément correspondant à une ligne de la table
	 * @param Array $where tableau indexé contenant la clause where de la requete<br>
	 * Exemple: $where = array('ID_AGENT' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT ID_AGENT, TYPE_AGENT, AGENT, QUALITE, QUALITE2, TEL, EMAIL, ACTIF, FAX, IS_DEFAULT '.
		       'FROM ARRP_AGENTS ';
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
		while(list($ID_AGENT, $TYPE_AGENT, $AGENT, $QUALITE, $QUALITE2, $TEL, $EMAIL, $ACTIF, $FAX, $IS_DEFAULT) = $res->fetchRow())
		{
			$this->setIdAgent($ID_AGENT);
			$this->setTypeAgent($TYPE_AGENT);
			$this->setAgent($AGENT);
			$this->setQualite($QUALITE);
			$this->setQualite2($QUALITE2);
			$this->setTel($TEL);
			$this->setEmail($EMAIL);
			$this->setActif($ACTIF);
			$this->setFax($FAX);
			$this->setIsDefault($IS_DEFAULT);
		}
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ArrpAgents
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpAgents</b> : <br>';
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