<?php

/** 
 * Classe repr�sentant la table `ARRP_VOIES`
 * @version 1.3
 */
class ArrpVoies
{
	var $db;
	// D�claration des variables repr�sentant les colonnes de la table
	var $cdruru = false;
	var $codeCom = false;
	var $rue = false;

	/** 
	 * Fonction qui met � jour la variable $cdruru
	 * repr�sentant la colonne `CDRURU` de la table `ARRP_VOIES`
	 */
	function setCdruru($v)
	{
		$this->cdruru = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $codeCom
	 * repr�sentant la colonne `CODE_COM` de la table `ARRP_VOIES`
	 */
	function setCodeCom($v)
	{
		$this->codeCom = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $rue
	 * repr�sentant la colonne `RUE` de la table `ARRP_VOIES`
	 */
	function setRue($v)
	{
		$this->rue = $v;
	}

	/** 
	 * Retourne la valeur de la variable $cdruru
	 * Cette variable repr�sentante la colonne `CDRURU` de la table `ARRP_VOIES`
	 * @return mixed
	 */
	function getCdruru()
	{
		return $this->cdruru;
	}

	/** 
	 * Retourne la valeur de la variable $codeCom
	 * Cette variable repr�sentante la colonne `CODE_COM` de la table `ARRP_VOIES`
	 * @return mixed
	 */
	function getCodeCom()
	{
		return $this->codeCom;
	}

	/** 
	 * Retourne la valeur de la variable $rue
	 * Cette variable repr�sentante la colonne `RUE` de la table `ARRP_VOIES`
	 * @return mixed
	 */
	function getRue()
	{
		return $this->rue;
	}

	/** 
	 * @param DB $db connexion � la base de donn�es
	 */
	function ArrpVoies($db)
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
		if ($this->getCdruru() == '')
			die('Ex�cution impossible car le champs OBLIGATOIRE `CDRURU` n\'a pas de valeur!');
	}

	/** 
	 * Ins�re l'�l�ment en base
	 * @return DB r�sultat de l'insertion
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
	 * Met � jour tous les champs de la ligne dans la table
	 * @return DB r�sultat de l'update
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
	 * @return DB r�sultat de la suppression
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
	 * R�cup�re 1 seul �l�ment correspondant � une ligne de la table
	 * @param Array $where tableau index� contenant la clause where de la requete<br>
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
	 * Fonction qui affiche la liste des m�thodes de la classe ArrpVoies
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