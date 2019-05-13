<?php

/** 
 * Classe représentant une liste d'objet de type ArrpDemandeurs
 * @version 1.3
 */
class ListeArrpDemandeurs
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
	function ListeArrpDemandeurs($db)
	{
		return $this->db = $db;
	}

	// Récupération de plusieurs objet
	function select($where = array(), $orderBy = array())
	{
		$req = 'SELECT ID_DEMANDEUR, NOM, PRENOM, ADRESSE, ADRESSE2, CP, VILLE, EMAIL, TEL1, TEL2, OBSERVATIONS, USER_SAISIE, DATE_SAISIE, USER_MODIF, DATE_MODIF '.
		       'FROM ARRP_DEMANDEURS ';
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
		while(list($ID_DEMANDEUR, $NOM, $PRENOM, $ADRESSE, $ADRESSE2, $CP, $VILLE, $EMAIL, $TEL1, $TEL2, $OBSERVATIONS, $USER_SAISIE, $DATE_SAISIE, $USER_MODIF, $DATE_MODIF) = $res->fetchRow())
		{
			$obj = new ArrpDemandeurs($this->db);
			$obj->setIdDemandeur($ID_DEMANDEUR);
			$obj->setNom($NOM);
			$obj->setPrenom($PRENOM);
			$obj->setAdresse($ADRESSE);
			$obj->setAdresse2($ADRESSE2);
			$obj->setCp($CP);
			$obj->setVille($VILLE);
			$obj->setEmail($EMAIL);
			$obj->setTel1($TEL1);
			$obj->setTel2($TEL2);
			$obj->setObservations($OBSERVATIONS);
			$obj->setUserSaisie($USER_SAISIE);
			$obj->setDateSaisie($DATE_SAISIE);
			$obj->setUserModif($USER_MODIF);
			$obj->setDateModif($DATE_MODIF);
			$this->add($obj);
		}
		$this->nb = count($this->liste);
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ListeArrpDemandeurs
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ListeArrpDemandeurs</b> : <br>';
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