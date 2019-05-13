<?php

/** 
 * Classe repr�sentant la table `ARRP_DEMANDES_PARCELLES`
 * @version 1.3
 */
class ArrpDemandesParcelles
{
	var $db;
	// D�claration des variables repr�sentant les colonnes de la table
	var $idDemParc = false;
	var $idDemande = false;
	var $idParc = false;
	var $labx = false;
	var $laby = false;
	var $nsec = false;

	/** 
	 * Fonction qui met � jour la variable $idDemParc
	 * repr�sentant la colonne `ID_DEM_PARC` de la table `ARRP_DEMANDES_PARCELLES`
	 */
	function setIdDemParc($v)
	{
		$this->idDemParc = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $idDemande
	 * repr�sentant la colonne `ID_DEMANDE` de la table `ARRP_DEMANDES_PARCELLES`
	 */
	function setIdDemande($v)
	{
		$this->idDemande = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $idParc
	 * repr�sentant la colonne `ID_PARC` de la table `ARRP_DEMANDES_PARCELLES`
	 */
	function setIdParc($v)
	{
		$this->idParc = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $labx
	 * repr�sentant la colonne `LABX` de la table `ARRP_DEMANDES_PARCELLES`
	 */
	function setLabx($v)
	{
		$this->labx = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $laby
	 * repr�sentant la colonne `LABY` de la table `ARRP_DEMANDES_PARCELLES`
	 */
	function setLaby($v)
	{
		$this->laby = $v;
	}

	/** 
	 * Fonction qui met � jour la variable $nsec
	 * repr�sentant la colonne `NSEC` de la table `ARRP_DEMANDES_PARCELLES`
	 */
	function setNsec($v)
	{
		$this->nsec = $v;
	}

	/** 
	 * Retourne la valeur de la variable $idDemParc
	 * Cette variable repr�sentante la colonne `ID_DEM_PARC` de la table `ARRP_DEMANDES_PARCELLES`
	 * @return mixed
	 */
	function getIdDemParc()
	{
		return $this->idDemParc;
	}

	/** 
	 * Retourne la valeur de la variable $idDemande
	 * Cette variable repr�sentante la colonne `ID_DEMANDE` de la table `ARRP_DEMANDES_PARCELLES`
	 * @return mixed
	 */
	function getIdDemande()
	{
		return $this->idDemande;
	}

	/** 
	 * Retourne la valeur de la variable $idParc
	 * Cette variable repr�sentante la colonne `ID_PARC` de la table `ARRP_DEMANDES_PARCELLES`
	 * @return mixed
	 */
	function getIdParc()
	{
		return $this->idParc;
	}

	/** 
	 * Retourne la valeur de la variable $labx
	 * Cette variable repr�sentante la colonne `LABX` de la table `ARRP_DEMANDES_PARCELLES`
	 * @return mixed
	 */
	function getLabx()
	{
		return $this->labx;
	}

	/** 
	 * Retourne la valeur de la variable $laby
	 * Cette variable repr�sentante la colonne `LABY` de la table `ARRP_DEMANDES_PARCELLES`
	 * @return mixed
	 */
	function getLaby()
	{
		return $this->laby;
	}

	/** 
	 * Retourne la valeur de la variable $nsec
	 * Cette variable repr�sentante la colonne `NSEC` de la table `ARRP_DEMANDES_PARCELLES`
	 * @return mixed
	 */
	function getNsec()
	{
		return $this->nsec;
	}

	/** 
	 * @param DB $db connexion � la base de donn�es
	 */
	function ArrpDemandesParcelles($db)
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
		if ($this->getIdDemParc() == '')
			die('Ex�cution impossible car le champs OBLIGATOIRE `ID_DEM_PARC` n\'a pas de valeur!');
	}

	/** 
	 * Ins�re l'�l�ment en base
	 * @return DB r�sultat de l'insertion
	 */
	function insert()
	{
		$this->verifChampsPrimaryKey();
		$req = 'insert into ARRP_DEMANDES_PARCELLES '.
		       '('.
				'ID_DEM_PARC, '.
				'ID_DEMANDE, '.
				'ID_PARC, '.
				'LABX, '.
				'LABY, '.
				'NSEC, '.
				') '.
		       'values ('.
				($this->idDemParc != '' ? '\''. protegeChaineOracle($this->getIdDemParc()) .'\', ':'NULL, ').
				($this->idDemande != '' ? '\''. protegeChaineOracle($this->getIdDemande()) .'\', ':'NULL, ').
				($this->idParc != '' ? '\''. protegeChaineOracle($this->getIdParc()) .'\', ':'NULL, ').
				($this->labx != '' ? '\''. protegeChaineOracle($this->getLabx()) .'\', ':'NULL, ').
				($this->laby != '' ? '\''. protegeChaineOracle($this->getLaby()) .'\', ':'NULL, ').
				($this->nsec != '' ? '\''. protegeChaineOracle($this->getNsec()) .'\', ':'NULL, ').
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
		$req = 'update ARRP_DEMANDES_PARCELLES set '.
		       'ID_DEMANDE='. ($this->idDemande != '' ? '\''. protegeChaineOracle($this->getIdDemande()) .'\' ':'NULL ').
		       ', ID_PARC='. ($this->idParc != '' ? '\''. protegeChaineOracle($this->getIdParc()) .'\' ':'NULL ').
		       ', LABX='. ($this->labx != '' ? '\''. protegeChaineOracle($this->getLabx()) .'\' ':'NULL ').
		       ', LABY='. ($this->laby != '' ? '\''. protegeChaineOracle($this->getLaby()) .'\' ':'NULL ').
		       ', NSEC='. ($this->nsec != '' ? '\''. protegeChaineOracle($this->getNsec()) .'\' ':'NULL ').
		       'WHERE ID_DEM_PARC=\''. protegeChaineOracle($this->getIdDemParc()) .'\' '.
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
		$req = 'delete from ARRP_DEMANDES_PARCELLES '.
		       'WHERE ID_DEM_PARC=\''. protegeChaineOracle($this->getIdDemParc()) .'\' '.
		       '';
		$res = executeReq($this->db, $req);
		return $res;
	}

	/** 
	 * R�cup�re 1 seul �l�ment correspondant � une ligne de la table
	 * @param Array $where tableau index� contenant la clause where de la requete<br>
	 * Exemple: $where = array('ID_DEM_PARC' => '4')
	 */
	function select($where = array())
	{
		$req = 'SELECT ID_DEM_PARC, ID_DEMANDE, ID_PARC, LABX, LABY, NSEC '.
		       'FROM ARRP_DEMANDES_PARCELLES ';
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
		while(list($ID_DEM_PARC, $ID_DEMANDE, $ID_PARC, $LABX, $LABY, $NSEC) = $res->fetchRow())
		{
			$this->setIdDemParc($ID_DEM_PARC);
			$this->setIdDemande($ID_DEMANDE);
			$this->setIdParc($ID_PARC);
			$this->setLabx($LABX);
			$this->setLaby($LABY);
			$this->setNsec($NSEC);
		}
	}

	/** 
	 * Fonction qui affiche la liste des m�thodes de la classe ArrpDemandesParcelles
	 */
	function help()
	{
		$tab = get_class_methods($this);
		echo '<br>Liste des fonctions de la classe <b>ArrpDemandesParcelles</b> : <br>';
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