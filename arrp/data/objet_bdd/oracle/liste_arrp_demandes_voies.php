<?php

/** 
 * Classe représentant une liste d'objet de type ArrpDemandesVoies
 * @version 1.3
 */
class ListeArrpDemandesVoies
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
	function ListeArrpDemandesVoies($db)
	{
		return $this->db = $db;
	}

	// Récupération de plusieurs objet
	function select($where = array(), $orderBy = array())
	{
		$req = 'SELECT ID_DEM_VOIE, ID_DEMANDE, CDRURU, LIBELLE_VOIE '.
		       'FROM ARRP_DEMANDES_VOIES ';
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
		while(list($ID_DEM_VOIE, $ID_DEMANDE, $CDRURU, $LIBELLE_VOIE) = $res->fetchRow())
		{
			$obj = new ArrpDemandesVoies($this->db);
			$obj->setIdDemVoie($ID_DEM_VOIE);
			$obj->setIdDemande($ID_DEMANDE);
			$obj->setCdruru($CDRURU);
			$obj->setLibelleVoie($LIBELLE_VOIE);
			$this->add($obj);
		}
		$this->nb = count($this->liste);
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ListeArrpDemandesVoies
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ListeArrpDemandesVoies</b> : <br>';
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