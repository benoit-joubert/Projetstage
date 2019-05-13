<?php

/** 
 * Classe représentant la table `ARRP_VOIES`
 * @version 1.3
 */
class ArrpVoies
{
	var $db;
	// Déclaration des variables représentant les colonnes de la table
	var $cdruru = false;
	var $codeCom = false;
	var $rue = false;

	/** 
	 * Fonction qui met à jour la variable $cdruru
	 * représentant la colonne `CDRURU` de la table `ARRP_VOIES`
	 */
	function setCdruru($v)
	{
		$this->cdruru = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $codeCom
	 * représentant la colonne `CODE_COM` de la table `ARRP_VOIES`
	 */
	function setCodeCom($v)
	{
		$this->codeCom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $rue
	 * représentant la colonne `RUE` de la table `ARRP_VOIES`
	 */
	function setRue($v)
	{
		$this->rue = $v;
	}

	/** 
	 * Retourne la valeur de la variable $cdruru
	 * Cette variable représentante la colonne `CDRURU` de la table `ARRP_VOIES`
	 * @return mixed
	 */
	function getCdruru()
	{
		return $this->cdruru;
	}

	/** 
	 * Retourne la valeur de la variable $codeCom
	 * Cette variable représentante la colonne `CODE_COM` de la table `ARRP_VOIES`
	 * @return mixed
	 */
	function getCodeCom()
	{
		return $this->codeCom;
	}

	/** 
	 * Retourne la valeur de la variable $rue
	 * Cette variable représentante la colonne `RUE` de la table `ARRP_VOIES`
	 * @return mixed
	 */
	function getRue()
	{
		return $this->rue;
	}

	/** 
	 * @param DB $db connexion à la base de données
	 */
	function ArrpVoies($db)
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
		if ($this->getCdruru() == '')
			die('Exécution impossible car le champs OBLIGATOIRE `CDRURU` n\'a pas de valeur!');
	}

	/** 
	 * Insère l'élément en base
	 * @return DB résultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_VOIES '.
		       '('.
				'CDRURU, '.
				'CODE_COM, '.
				'RUE, '.
				') '.
		       'values ('.
				($this->cdruru != '' ? '\''. protegeChaineOracle($this->getCdruru()) .'\', ':'NULL, ').
				($this->codeCom != '' ? '\''. protegeChaineOracle($this->getCodeCom()) .'\', ':'NULL, ').
				($this->rue != '' ? '\''. protegeChaineOracle($this->getRue()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_VOIES set '.
		       'CODE_COM='. ($this->codeCom != '' ? '\''. protegeChaineOracle($this->getCodeCom()) .'\' ':'NULL ').
		       ', RUE='. ($this->rue != '' ? '\''. protegeChaineOracle($this->getRue()) .'\' ':'NULL ').
		       'WHERE CDRURU=\''. protegeChaineOracle($this->getCdruru()) .'\' '.
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
		$req = 'delete from ARRP_VOIES '.
		       'WHERE CDRURU=\''. protegeChaineOracle($this->getCdruru()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Récupère 1 seul élément correspondant à une ligne de la table
	 * @param Array $where tableau indexé contenant la clause where de la requete<br>
	 * Exemple: $where = array('CDRURU' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT CDRURU, CODE_COM, RUE '.
		       'FROM ARRP_VOIES ';
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
		while(list($CDRURU, $CODE_COM, $RUE) = $res->fetchRow())
		{
			$this->setCdruru($CDRURU);
			$this->setCodeCom($CODE_COM);
			$this->setRue($RUE);
		}
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ArrpVoies
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpVoies</b> : <br>';
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