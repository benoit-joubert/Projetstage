<?
/***************************************************************
	Nom de la classe:	dbOdbc
	Auteur:				Adinani Daniel
	Version:			2.0
	Date mise à jour:	16/09/2003

	Cette classe permet de se connecter à une source de données OBDC et
	d'y exécuter des instruction SQL (SELECT, UPDATE, INSERT, DELETE...)
	si la source de données le permet.
***************************************************************

** Function dbObdc(Strig user,String pwd, String dns) **
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
	Si assos='nom': Les colonnes de la ligne retournée seront référencées par	le nom des champs(sensible à la casse) dans le SELECT.

** Fonction fetchRowN(Objet curs,Integer numligne, String assos) **
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

	Class dbOdbc {
		var $conn;
		var $curs;
		var $status;
		function dbOdbc ($vuser="",$vpasswd="",$vdns="") {
			global $db_user, $db_passwd, $dns;
			if ($vdns!="") $dns=$vdns;
			if ($vuser!="") $db_user=$vuser;
			if ($vpasswd!="") $db_passwd=$vpasswd;
			$this->conn = @odbc_connect($dns,$db_user,$db_passwd,SQL_CUR_USE_DRIVER) or die("Impossible de se connecter à la base de données $dns");
			//$this->conn = @odbc_connect($dns,$user,$passwd,SQL_CUR_USE_ODBC);
			$this->status = $this->conn?true:false;
		}//function

		function query ($txtsql){
			//var_dump($txtsql);
			if (!($this->status))
				return false;
			$this->curs=@odbc_exec($this->conn,$txtsql);
			return $this->curs;
		}//function

		function fetch($curs=false,$assos="num"){
			$tabData = array();
			if($curs != false)
				$this->curs=$curs;
			if (!(@odbc_fetch_into($this->curs,$tabData))) {
				return false;
			}//if
			if ($assos=="nom"){
				$j=$this->getNbChamps();
				for ($i=1;$i<=$j;$i++){
					$tmp[$this->getNomChamps($i)]=$tabData[$i-1];
				}//for
			$tabData=$tmp;
			}//if
			return $tabData;
		}//function

		function fetchRowN($curs=false,$numligne,$assos="num"){
		//Reourne la ligne N° $numligne
			$tabData = array();
			if($curs)
				$this->curs=$curs;
			if (!($this->curs)){
				return false;
			}//if
			if(!(@odbc_fetch_into($this->curs,$numligne,$tabData))){
				return false;
			}//if
			if ($assos=="nom"){
				$j=$this->getNbChamps();
				for ($i=1;$i<=$j;$i++){
					$tmp[$this->getNomChamps($i)]=$tabData[$i-1];
				}//for
			unset($tabData);
			$tabData=$tmp;
			}//if
			return $tabData;
		}//function

		function getNbChamps($curs=false){
		// Retourne le nombre de colonnes
			if($curs != false)
				$this->curs=$curs;
			if ($this->curs){
				return @odbc_num_fields($this->curs);
			}//if
			return false;
		}//function

		function getNomChamps($curs=false,$numcol) {
		//Retourne le nom des champs
			if($curs != false)
				$this->curs=$curs;
			if ($this->curs) {
				return @odbc_field_name($this->curs,$numcol);
			}//if
			return false;
		}//function

		function getTypeChamps($curs=false,$numcol) {
		//Retourne le nom des champs
			if($curs != false)
				$this->curs=$curs;
			if ($this->curs) {
				return @odbc_field_type($this->curs,$numcol);
			}//if
			return false;
		}//function

		function getSizeChamps($curs=false,$numcol) {
		//Retourne le nom des champs
			if($curs != false)
				$this->curs=$curs;
			if ($this->curs) {
				return @odbc_field_len($this->curs,$numcol);
			}//if
			return false;
		}//function

		function close() {
			if (!(@odbc_close($this->conn))) {
				return false;
			}//if
			return true;
		}//function
		function close_all(){
			@odbc_close_all();
			return true;
		}
	}// Class
?>