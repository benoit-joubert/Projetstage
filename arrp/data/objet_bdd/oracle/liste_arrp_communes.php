<?php

/** 
 * Classe représentant une liste d'objet de type ArrpCommunes
 * @version 1.3
 */
class ListeArrpCommunes
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
	function ListeArrpCommunes($db)
	{
		return $this->db = $db;
	}

	// Récupération de plusieurs objet
	function select($where = array(), $orderBy = array())
	{
		$req = 'SELECT CODE_COM, LIB_COMMUNE, MODE_GEST_VOIE, MODE_GEST_PARC, LAST_NUM_VOIE, CODE_POSTAL, LIB_COMMUNE_MIN, FORMAT_PARC '.
		       'FROM ARRP_COMMUNES ';
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
		while(list($CODE_COM, $LIB_COMMUNE, $MODE_GEST_VOIE, $MODE_GEST_PARC, $LAST_NUM_VOIE, $CODE_POSTAL, $LIB_COMMUNE_MIN, $FORMAT_PARC) = $res->fetchRow())
		{
			$obj = new ArrpCommunes($this->db);
			$obj->setCodeCom($CODE_COM);
			$obj->setLibCommune($LIB_COMMUNE);
			$obj->setModeGestVoie($MODE_GEST_VOIE);
			$obj->setModeGestParc($MODE_GEST_PARC);
			$obj->setLastNumVoie($LAST_NUM_VOIE);
			$obj->setCodePostal($CODE_POSTAL);
			$obj->setLibCommuneMin($LIB_COMMUNE_MIN);
			$obj->setFormatParc($FORMAT_PARC);
			$this->add($obj);
		}
		$this->nb = count($this->liste);
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ListeArrpCommunes
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ListeArrpCommunes</b> : <br>';
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