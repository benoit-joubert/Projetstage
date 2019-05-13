<?php

/** 
 * Classe représentant la table `ARRP_DEMANDES_VOIES`
 * @version 1.3
 */
class ArrpDemandesVoies
{
	var $db;
	// Déclaration des variables représentant les colonnes de la table
	var $idDemVoie = false;
	var $idDemande = false;
	var $cdruru = false;
	var $libelleVoie = false;

	/** 
	 * Fonction qui met à jour la variable $idDemVoie
	 * représentant la colonne `ID_DEM_VOIE` de la table `ARRP_DEMANDES_VOIES`
	 */
	function setIdDemVoie($v)
	{
		$this->idDemVoie = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $idDemande
	 * représentant la colonne `ID_DEMANDE` de la table `ARRP_DEMANDES_VOIES`
	 */
	function setIdDemande($v)
	{
		$this->idDemande = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $cdruru
	 * représentant la colonne `CDRURU` de la table `ARRP_DEMANDES_VOIES`
	 */
	function setCdruru($v)
	{
		$this->cdruru = $v;
	}

	/** 
	 * Fonction qui met à jour la variable $libelleVoie
	 * représentant la colonne `LIBELLE_VOIE` de la table `ARRP_DEMANDES_VOIES`
	 */
	function setLibelleVoie($v)
	{
		$this->libelleVoie = $v;
	}

	/** 
	 * Retourne la valeur de la variable $idDemVoie
	 * Cette variable représentante la colonne `ID_DEM_VOIE` de la table `ARRP_DEMANDES_VOIES`
	 * @return mixed
	 */
	function getIdDemVoie()
	{
		return $this->idDemVoie;
	}

	/** 
	 * Retourne la valeur de la variable $idDemande
	 * Cette variable représentante la colonne `ID_DEMANDE` de la table `ARRP_DEMANDES_VOIES`
	 * @return mixed
	 */
	function getIdDemande()
	{
		return $this->idDemande;
	}

	/** 
	 * Retourne la valeur de la variable $cdruru
	 * Cette variable représentante la colonne `CDRURU` de la table `ARRP_DEMANDES_VOIES`
	 * @return mixed
	 */
	function getCdruru()
	{
		return $this->cdruru;
	}

	/** 
	 * Retourne la valeur de la variable $libelleVoie
	 * Cette variable représentante la colonne `LIBELLE_VOIE` de la table `ARRP_DEMANDES_VOIES`
	 * @return mixed
	 */
	function getLibelleVoie()
	{
		return $this->libelleVoie;
	}

	/** 
	 * @param DB $db connexion à la base de données
	 */
	function ArrpDemandesVoies($db)
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
		if ($this->getIdDemVoie() == '')
			die('Exécution impossible car le champs OBLIGATOIRE `ID_DEM_VOIE` n\'a pas de valeur!');
	}

	/** 
	 * Insère l'élément en base
	 * @return DB résultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_DEMANDES_VOIES '.
		       '('.
				'ID_DEM_VOIE, '.
				'ID_DEMANDE, '.
				'CDRURU, '.
				'LIBELLE_VOIE, '.
				') '.
		       'values ('.
				($this->idDemVoie != '' ? '\''. protegeChaineOracle($this->getIdDemVoie()) .'\', ':'NULL, ').
				($this->idDemande != '' ? '\''. protegeChaineOracle($this->getIdDemande()) .'\', ':'NULL, ').
				($this->cdruru != '' ? '\''. protegeChaineOracle($this->getCdruru()) .'\', ':'NULL, ').
				($this->libelleVoie != '' ? '\''. protegeChaineOracle($this->getLibelleVoie()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_DEMANDES_VOIES set '.
		       'ID_DEMANDE='. ($this->idDemande != '' ? '\''. protegeChaineOracle($this->getIdDemande()) .'\' ':'NULL ').
		       ', CDRURU='. ($this->cdruru != '' ? '\''. protegeChaineOracle($this->getCdruru()) .'\' ':'NULL ').
		       ', LIBELLE_VOIE='. ($this->libelleVoie != '' ? '\''. protegeChaineOracle($this->getLibelleVoie()) .'\' ':'NULL ').
		       'WHERE ID_DEM_VOIE=\''. protegeChaineOracle($this->getIdDemVoie()) .'\' '.
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
		$req = 'delete from ARRP_DEMANDES_VOIES '.
		       'WHERE ID_DEM_VOIE=\''. protegeChaineOracle($this->getIdDemVoie()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * Récupère 1 seul élément correspondant à une ligne de la table
	 * @param Array $where tableau indexé contenant la clause where de la requete<br>
	 * Exemple: $where = array('ID_DEM_VOIE' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT ID_DEM_VOIE, ID_DEMANDE, CDRURU, LIBELLE_VOIE '.
		       'FROM ARRP_DEMANDES_VOIES ';
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
		while(list($ID_DEM_VOIE, $ID_DEMANDE, $CDRURU, $LIBELLE_VOIE) = $res->fetchRow())
		{
			$this->setIdDemVoie($ID_DEM_VOIE);
			$this->setIdDemande($ID_DEMANDE);
			$this->setCdruru($CDRURU);
			$this->setLibelleVoie($LIBELLE_VOIE);
		}
	}

	/** 
	 * Fonction qui affiche la liste des méthodes de la classe ArrpDemandesVoies
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpDemandesVoies</b> : <br>';
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