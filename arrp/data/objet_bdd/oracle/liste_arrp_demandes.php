<?php

/** 
 * Classe représentant une liste d'objet de type ArrpDemandes
 * @version 1.3
 */
class ListeArrpDemandes
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
	function ListeArrpDemandes($db)
	{
		return $this->db = $db;
	}

	// Récupération de plusieurs objet
	function select($where = array(), $orderBy = array())
	{
		$req = 'SELECT ID_DEMANDE, ID_DEMANDEUR, CONTACT, REFERENCE, DATE_DEMANDE, DATE_REPONSE, STATUT_DEMANDE, STATUT_AEP, STATUT_EU, OBSERVATIONS, ID_SIGNATAIRE, URL_CARTE, ID_ATTESTANT, ID_INTERLOCUTEUR, USER_SAISIE, DATE_SAISIE, USER_MODIF, DATE_MODIF, CODE_COM '.
		       'FROM ARRP_DEMANDES ';
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
		while(list($ID_DEMANDE, $ID_DEMANDEUR, $CONTACT, $REFERENCE, $DATE_DEMANDE, $DATE_REPONSE, $STATUT_DEMANDE, $STATUT_AEP, $STATUT_EU, $OBSERVATIONS, $ID_SIGNATAIRE, $URL_CARTE, $ID_ATTESTANT, $ID_INTERLOCUTEUR, $USER_SAISIE, $DATE_SAISIE, $USER_MODIF, $DATE_MODIF, $CODE_COM) = $res->fetchRow())
		{
			$obj = new ArrpDemandes($this->db);
			$obj->setIdDemande($ID_DEMANDE);
			$obj->setIdDemandeur($ID_DEMANDEUR);
			$obj->setContact($CONTACT);
			$obj->setReference($REFERENCE);
			$obj->setDateDemande($DATE_DEMANDE);
			$obj->setDateReponse($DATE_REPONSE);
			$obj->setStatutDemande($STATUT_DEMANDE);
			$obj->setStatutAep($STATUT_AEP);
			$obj->setStatutEu($STATUT_EU);
			$obj->setObservations($OBSERVATIONS);
			$obj->setIdSignataire($ID_SIGNATAIRE);
			$obj->setUrlCarte($URL_CARTE);
			$obj->setIdAttestant($ID_ATTESTANT);
			$obj->setIdInterlocuteur($ID_INTERLOCUTEUR);
			$obj->setUserSaisie($USER_SAISIE);
			$obj->setDateSaisie($DATE_SAISIE);
			$obj->setUserModif($USER_MODIF);
			$obj->setDateModif($DATE_MODIF);
			$obj->setCodeCom($CODE_COM);
			$this->add($obj);
		}
		$this->nb = count($this->liste);
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ListeArrpDemandes
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ListeArrpDemandes</b> : <br>';
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