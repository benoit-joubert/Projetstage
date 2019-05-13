<?php
/***************************************************************
	Nom de la classe:	dbOci
	Auteur:				Adinani Daniel
	Version:			2.0
	Date mise à jour:	16/09/2003

	Cette classe permet de se connecter à base de données ORACLE8 et
	d'y exécuter des instruction SQL (SELECT, UPDATE, INSERT, DELETE...).
***************************************************************

** Function dbOci(Strig user,String pwd, String dns) **
	Constructeur de la classe. Appelé automatiquement lors de la création
	de l'objet, ouvre une connection à la source de données 'dns' en
	utilisant 'user' (l'utilisateur) et 'pwd' (le mot de passe).

** Fonction query(String txtsql) **
	Execute Une requete sur la base de données.
	Retourne un numero identifiant le resultat de la requete si
	l'exécution a réuci ou retourne false dans le cas contraire.
	Pour une requete 'SELECT...' retourne un objet de type tableau
	contenant le resultat du SELECT.

** Fonction fetch (Objet curs, string assos) **
	Retourne la ligne suivant de l'objet 'curs' (curs Objet de
	type tableau).
	Retourne false en cas d'erreur ou si la fin du tableau est ateinte.
	Le parametre 'assos' est facultatif.
	Si 'assos' est absent ou assos='num': Les colonnes de la ligne
	retournée seront référencées par les numeros correspondant à leur
	position dans le SELECT.
	Si assos='nom': Les colonnes de la ligne retournée seront référencées
	par	le nom des champs(sensible à la casse) dans le SELECT.

** Fonction fetchRowN(Objet curs,Integer numligne, String assos) **
	En cours de développement
	Reourne la ligne 'numligne' de l'Objet 'curs'.
	Reourne false si l'objet 'curs' est invalide ou si 'numeligne est
	en dehors du tableau.
	les parametres 'curs' et 'assos' respectent les mêmes principes que
	dans la fonction 'fetch'.
	

** Fonction getNbChamps(Objet curs) **
	Retourne le nombre de colonnes des l'Objet 'curs'.
	Reourne false si l'objet 'curs' n'est pas on objet nvalide.

** Fonction getNomChamps(Objet curs,Integer numcol) **
	Retourne le nom de la colonne correspondant à la position 'numcol'
	dans l'Objet 'curs'.
	Reourne false en cas d'erreur.

** Fonction Close() **
	Ferme la connection.
	Utilisez la fonction PHP 'unset(nomObjet)' pour liberer les ressources
	utilisées par la classe.
***************************************************************/

	Class dbOci {
		var $conn;
		var $curs;
		var $txtsql;
		var $status;

		function dbOci ($vuser="",$vpasswd="",$vdns="") {
			global $db_user, $db_passwd, $dns;
			global $PROD;
			if ($vdns!="") $dns=$vdns;
			if ($vuser!="") $db_user=$vuser;
			if ($vpasswd!="") $db_passwd=$vpasswd;
			$this->conn = @ociLogon($db_user,$db_passwd,$dns);
			$this->status = $this->conn?true:false;
			if(!$this->conn && (isset($PROD) && $PROD==0)){
				$err = OCIError();  // Pour les erreurs oci_connect, aucun paramètre n'est passé
				echo "Impossible de se connecter à la base de données : $dns<br>\n";
				echo '<b>'.htmlentities($err['message']).'</b>';
				die();
			}
		}//function
		
        function msgErreur($curs){
		    global $PROD;
			$err = OCIError($curs);  // Pour les erreurs oci_connect, aucun paramètre n'est passé
			$sqltext=$err["sqltext"];
			if ($err["offset"]) {
		       $sqltext = substr ($err["sqltext"], 0, $err["offset"]) .
			   '<b>*</b>' .
				substr ($err["sqltext"], $err["offset"]);
			}
			if(isset($PROD) && $PROD==0){
			    echo "<b>Erreur Oracle : </b>";
			    echo $sqltext.'<br><b>'.$err['message'].'</b>';
			}
	        die();
		}
		
		function query ($txtsql) {
			$this->txtsql=$txtsql;
			$this->curs=@ociparse($this->conn,$txtsql);
			if (!$this->curs){
				return false;
			}
			if (!(@ociExecute($this->curs))){
				$this->msgErreur($this->curs);
				return false;
			}

			return $this->curs;
		}//function
        
        function fetch($curs,$assos="num") {
			$r = 0;
			$this->curs=$curs;
			if ($assos == 'num'){
				$r = (@ociFetchInto($this->curs,$tabData,OCI_NUM+OCI_RETURN_NULLS) ? 1 : 0);
			}//if
			if ($assos == 'nom'){
				$r = (@ociFetchInto($this->curs,$tabData,OCI_ASSOC+OCI_RETURN_NULLS) ? 1 : 0);
			}//if
			return ($r == 1 ? $tabData : null);
		}//function
		
		function fetchRowN($curs,$numligne,$assos="num"){
		//Reourne la ligne N° $numligne
		//A tester 
			$tabData = array();
			$this->curs=$curs;
			if (!$this->curs){
				return false;
			}//if
			if (@OCIStatementType($this->curs)!="SELECT"){
				return false;
			}//if
			@OciFetch($this->curs,0);
			/*
			if (!($this->query($this->txtsql))){
				return false;
			}
			*/
			$trouve = false;
			$j=0;
			if ($assos == "num"){
				while(@ociFetchInto($this->curs,$tabData,OCI_NUM+OCI_RETURN_NULLS)){
					$j++;
					if ($j == $numligne){
						$trouve=true;
						break;
					}//if
				}//while
			}//if
			if ($assos == "nom"){
				while(@ociFetchInto($this->curs,$tabData,OCI_ASSOC+OCI_RETURN_NULLS)){
					$j++;
					if ($j == $numligne){
						$trouve=true;
						break;
					}//if
				}//while
			}//if
			if ($trouve == true){
				return $tabData;
			}//if
			return false;
		}//function

		function getNbChamps($curs=""){
		// Retourne le nombre de colonnes
			if ($curs!="")
				$this->curs=$curs;
			if ($this->curs){
				return @OCINumCols($this->curs);
			}//if
			return false;
		}//function

		function getNomChamps($curs="",$numcol) {
		// A tester
			if($curs!="")
				$this->curs=$curs;
			if ($this->curs) {
				return @OCIColumnName($this->curs,$numcol);
			}//if
			return false;
		}//function

		function getTypeChamps($curs="",$numcol) {
		// A tester
			if($curs!="")
				$this->curs=$curs;
			if ($this->curs) {
				return @OCIColumnType($this->curs,$numcol);
			}//if
			return false;
		}//function

		function getSizeChamps($curs="",$numcol) {
		// A tester
			if($curs!="")
				$this->curs=$curs;
			if ($this->curs) {
				return @OCIColumnSize($this->curs,$numcol);
			}//if
			return false;
		}//function

		function close() {
			if (!@ociLogOff($this->conn)) {
				return false;
			}//if
			return true;
		}//function
	}// Class
?>