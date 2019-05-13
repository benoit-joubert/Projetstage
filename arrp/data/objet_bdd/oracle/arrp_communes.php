<?php

/** 
 * Classe représentant la table `ARRP_COMMUNES`
 * @version 1.3
 */
class ArrpCommunes
{
	var $db;
	// Déclaration des variables représentant les colonnes de la table
	var $codeCom = false;
	var $libCommune = false;
	var $modeGestVoie = false;
	var $modeGestParc = false;
	var $lastNumVoie = false;
	var $codePostal = false;
	var $libCommuneMin = false;
	var $formatParc = false;

	/** 
	 * Fonction qui met à jour la variable $codeCom
	 * représentant la colonne `CODE_COM` de la table `ARRP_COMMUNES`
	 */
	function setCodeCom($v)
	{
		$this->codeCom = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $libCommune
	 * représentant la colonne `LIB_COMMUNE` de la table `ARRP_COMMUNES`
	 */
	function setLibCommune($v)
	{
		$this->libCommune = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $modeGestVoie
	 * représentant la colonne `MODE_GEST_VOIE` de la table `ARRP_COMMUNES`
	 */
	function setModeGestVoie($v)
	{
		$this->modeGestVoie = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $modeGestParc
	 * représentant la colonne `MODE_GEST_PARC` de la table `ARRP_COMMUNES`
	 */
	function setModeGestParc($v)
	{
		$this->modeGestParc = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $lastNumVoie
	 * représentant la colonne `LAST_NUM_VOIE` de la table `ARRP_COMMUNES`
	 */
	function setLastNumVoie($v)
	{
		$this->lastNumVoie = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $codePostal
	 * représentant la colonne `CODE_POSTAL` de la table `ARRP_COMMUNES`
	 */
	function setCodePostal($v)
	{
		$this->codePostal = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $libCommuneMin
	 * représentant la colonne `LIB_COMMUNE_MIN` de la table `ARRP_COMMUNES`
	 */
	function setLibCommuneMin($v)
	{
		$this->libCommuneMin = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $formatParc
	 * représentant la colonne `FORMAT_PARC` de la table `ARRP_COMMUNES`
	 */
	function setFormatParc($v)
	{
		$this->formatParc = $v;
	}

	/** 
	 * Retourne la valeur de la variable $codeCom
	 * Cette variable représentante la colonne `CODE_COM` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getCodeCom()
	{
		return $this->codeCom;
	}

	/** 
	 * Retourne la valeur de la variable $libCommune
	 * Cette variable représentante la colonne `LIB_COMMUNE` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getLibCommune()
	{
		return $this->libCommune;
	}

	/** 
	 * Retourne la valeur de la variable $modeGestVoie
	 * Cette variable représentante la colonne `MODE_GEST_VOIE` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getModeGestVoie()
	{
		return $this->modeGestVoie;
	}

	/** 
	 * Retourne la valeur de la variable $modeGestParc
	 * Cette variable représentante la colonne `MODE_GEST_PARC` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getModeGestParc()
	{
		return $this->modeGestParc;
	}

	/** 
	 * Retourne la valeur de la variable $lastNumVoie
	 * Cette variable représentante la colonne `LAST_NUM_VOIE` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getLastNumVoie()
	{
		return $this->lastNumVoie;
	}

	/** 
	 * Retourne la valeur de la variable $codePostal
	 * Cette variable représentante la colonne `CODE_POSTAL` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getCodePostal()
	{
		return $this->codePostal;
	}

	/** 
	 * Retourne la valeur de la variable $libCommuneMin
	 * Cette variable représentante la colonne `LIB_COMMUNE_MIN` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getLibCommuneMin()
	{
		return $this->libCommuneMin;
	}

	/** 
	 * Retourne la valeur de la variable $formatParc
	 * Cette variable représentante la colonne `FORMAT_PARC` de la table `ARRP_COMMUNES`
	 * @return mixed
	 */
	function getFormatParc()
	{
		return $this->formatParc;
	}

	/** 
	 * @param DB $db connexion à la base de données
	 */
	function ArrpCommunes($db)
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
		if ($this->getCodeCom() == '')
			die('Exécution impossible car le champs OBLIGATOIRE `CODE_COM` n\'a pas de valeur!');
	}

	/** 
	 * Insère l'élément en base
	 * @return DB résultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_COMMUNES '.
		       '('.
				'CODE_COM, '.
				'LIB_COMMUNE, '.
				'MODE_GEST_VOIE, '.
				'MODE_GEST_PARC, '.
				'LAST_NUM_VOIE, '.
				'CODE_POSTAL, '.
				'LIB_COMMUNE_MIN, '.
				'FORMAT_PARC, '.
				') '.
		       'values ('.
				($this->codeCom != '' ? '\''. protegeChaineOracle($this->getCodeCom()) .'\', ':'NULL, ').
				($this->libCommune != '' ? '\''. protegeChaineOracle($this->getLibCommune()) .'\', ':'NULL, ').
				($this->modeGestVoie != '' ? '\''. protegeChaineOracle($this->getModeGestVoie()) .'\', ':'NULL, ').
				($this->modeGestParc != '' ? '\''. protegeChaineOracle($this->getModeGestParc()) .'\', ':'NULL, ').
				($this->lastNumVoie != '' ? '\''. protegeChaineOracle($this->getLastNumVoie()) .'\', ':'NULL, ').
				($this->codePostal != '' ? '\''. protegeChaineOracle($this->getCodePostal()) .'\', ':'NULL, ').
				($this->libCommuneMin != '' ? '\''. protegeChaineOracle($this->getLibCommuneMin()) .'\', ':'NULL, ').
				($this->formatParc != '' ? '\''. protegeChaineOracle($this->getFormatParc()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_COMMUNES set '.
		       'LIB_COMMUNE='. ($this->libCommune != '' ? '\''. protegeChaineOracle($this->getLibCommune()) .'\' ':'NULL ').
		       ', MODE_GEST_VOIE='. ($this->modeGestVoie != '' ? '\''. protegeChaineOracle($this->getModeGestVoie()) .'\' ':'NULL ').
		       ', MODE_GEST_PARC='. ($this->modeGestParc != '' ? '\''. protegeChaineOracle($this->getModeGestParc()) .'\' ':'NULL ').
		       ', LAST_NUM_VOIE='. ($this->lastNumVoie != '' ? '\''. protegeChaineOracle($this->getLastNumVoie()) .'\' ':'NULL ').
		       ', CODE_POSTAL='. ($this->codePostal != '' ? '\''. protegeChaineOracle($this->getCodePostal()) .'\' ':'NULL ').
		       ', LIB_COMMUNE_MIN='. ($this->libCommuneMin != '' ? '\''. protegeChaineOracle($this->getLibCommuneMin()) .'\' ':'NULL ').
		       ', FORMAT_PARC='. ($this->formatParc != '' ? '\''. protegeChaineOracle($this->getFormatParc()) .'\' ':'NULL ').
		       'WHERE CODE_COM=\''. protegeChaineOracle($this->getCodeCom()) .'\' '.
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
		$req = 'delete from ARRP_COMMUNES '.
		       'WHERE CODE_COM=\''. protegeChaineOracle($this->getCodeCom()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Récupère 1 seul élément correspondant à une ligne de la table
	 * @param Array $where tableau indexé contenant la clause where de la requete<br>
	 * Exemple: $where = array('CODE_COM' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT CODE_COM, LIB_COMMUNE, MODE_GEST_VOIE, MODE_GEST_PARC, LAST_NUM_VOIE, CODE_POSTAL, LIB_COMMUNE_MIN, FORMAT_PARC '.
		       'FROM ARRP_COMMUNES ';
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
		while(list($CODE_COM, $LIB_COMMUNE, $MODE_GEST_VOIE, $MODE_GEST_PARC, $LAST_NUM_VOIE, $CODE_POSTAL, $LIB_COMMUNE_MIN, $FORMAT_PARC) = $res->fetchRow())
		{
			$this->setCodeCom($CODE_COM);
			$this->setLibCommune($LIB_COMMUNE);
			$this->setModeGestVoie($MODE_GEST_VOIE);
			$this->setModeGestParc($MODE_GEST_PARC);
			$this->setLastNumVoie($LAST_NUM_VOIE);
			$this->setCodePostal($CODE_POSTAL);
			$this->setLibCommuneMin($LIB_COMMUNE_MIN);
			$this->setFormatParc($FORMAT_PARC);
		}
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ArrpCommunes
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpCommunes</b> : <br>';
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