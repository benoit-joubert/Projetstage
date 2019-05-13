<?php

/** 
 * Classe représentant une liste d'objet de type ArrpAgents
 * @version 1.3
 */
class ListeArrpAgents
{
	var $db;
	var $nb = 0;
	var $liste = array();

	// Fonction qui ajoute un objet dans la liste
	function add($v)
	{
		$this->liste[] = $v;
	}

	// Fonction qui renvoie un objet de la liste
	function get($i)
	{
		return $this->liste[$i];
	}

	// Fonction qui renvoie le nombre d'objet dans la liste
	function size()
	{
		return $this->nb;
	}

	// constructeur
	function ListeArrpAgents($db)
	{
		return $this->db = $db;
	}

	// Récupération de plusieurs objet
	function select($where = array(), $orderBy = array())
	{
		$req = 'SELECT ID_AGENT, TYPE_AGENT, AGENT, QUALITE, QUALITE2, TEL, EMAIL, ACTIF, FAX, IS_DEFAULT '.
		       'FROM ARRP_AGENTS ';
		if (is_array($where))
		{
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
		}
		else
		{
			$req .= $where;
		}
		$chOrderBy = '';
		foreach($orderBy as $k => $v)
		{
			if ($chOrderBy != '')
				$chOrderBy .= ', ';
			else
				$chOrderBy .= 'ORDER BY ';
			$chOrderBy .= $k .' '. $v .' ';
		}
		$req .= $chOrderBy;
		$res = executeReq($this->db, $req);
		while(list($ID_AGENT, $TYPE_AGENT, $AGENT, $QUALITE, $QUALITE2, $TEL, $EMAIL, $ACTIF, $FAX, $IS_DEFAULT) = $res->fetchRow())
		{
			$obj = new ArrpAgents($this->db);
			$obj->setIdAgent($ID_AGENT);
			$obj->setTypeAgent($TYPE_AGENT);
			$obj->setAgent($AGENT);
			$obj->setQualite($QUALITE);
			$obj->setQualite2($QUALITE2);
			$obj->setTel($TEL);
			$obj->setEmail($EMAIL);
			$obj->setActif($ACTIF);
			$obj->setFax($FAX);
			$obj->setIsDefault($IS_DEFAULT);
			$this->add($obj);
		}
		$this->nb = count($this->liste);
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ListeArrpAgents
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ListeArrpAgents</b> : <br>';
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