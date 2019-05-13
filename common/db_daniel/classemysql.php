<?php
/***************************************************************
	Nom de la classe:	dbmysql
	Auteur:				Adinani Daniel
	Version:			2.0
	Date mise � jour:	26/09/2018

	Cette classe permet de se connecter � une source de donn�es MySql et
	d'y ex�cuter des instruction SQL (SELECT, UPDATE, INSERT, DELETE...)
	si la source de donn�es le permet.
***************************************************************

** Function dbmysql(Strig db_user,String db_passwd, String dns, string db_name) **
	Constructeur de la classe. Appel� automatiquement lors de la cr�ation
	de l'objet, ouvre une connection � la source de donn�es 'dns' en
	utilisant 'user' (l'utilisateur) et 'pwd' (le mot de passe)
	et s�lectionne la base dbname.

** Fonction query(String txtsql) **
	Execute Une requete sur la base de donn�es.
	Retourne un numero identifiant le resultat de la requete si
	l'ex�cution a r�uci ou retourne false dans le cas contraire.
	Pour une requete 'SELECT...' retourne un objet de type recordset
	contenant le resultat du SELECT.

** Fonction query(String txtsql) **
	Execute Une requete sur la base de donn�es.
	Retourne un numero identifiant le resultat de la requete si
	l'ex�cution a r�uci ou retourne false dans le cas contraire.
	Pour une requete 'SELECT...' retourne un objet de type recordset
	contenant le resultat du SELECT.

** Fonction setDb (string dbname) **
	Permer de s�lectionne la base 'dbname' dans la connexion courante.
	
** Fonction getNbChamps(Objet curs) **
	Retourne le nombre de colonnes des l'Objet 'curs'.
	Reourne false si l'objet 'curs' n'est pas on objet nvalide.

** Fonction getNomChamps(Objet curs,Integer numcol) **
	Retourne le nom de la colonne correspondant � la position 'numcol'
	dans l'Objet 'curs'.
	Reourne false en cas d'erreur.

** Fonction Close() **
	Ferme la connection.
	Utilisez la fonction PHP 'unset(nomObjet)' pour liberer les ressources
	utilis�es par la classe.
***************************************************************/

	Class DbMySql {
		var $conn;
		var $curs;
		var $status;
		function DbMySql ($vuser="",$vpasswd="",$vdns="",$vdbname="") {
			global $db_user, $db_passwd, $dns, $db_name;
			if ($vdns!="") $dns=$vdns;
			if ($vuser!="") $db_user=$vuser;
			if ($vpasswd!="") $db_passwd=$vpasswd;
			if ($vdbname!="") $db_name=$vdbname;
			$this->conn = @mysqli_connect($dns,$db_user,$db_passwd,$db_name) or die("Impossible de se connecter � la base de donn�es : $dns");
			$this->status = $this->conn?true:false;
			/*
			if($this->status)
				if(!$this->setDb($db_name))
					return false;
			*/
		}//function

		function SetDb($base)
		{
			//Permet de changer de base de donn�es
			if (!@mysqli_select_db($base,$this->conn))
				return false;
			return true;
		}		
		

		function query ($txtsql){
			//var_dump($txtsql);
			if (!($this->status))
				return false;

			$this->curs = $this->conn->query($txtsql);
			return $this->curs;
		}//function

		function fetch($curs=''){
			$tabData = array();
			if($curs != '')
				$this->curs=$curs;
			$tabData = mysqli_fetch_array($this->curs);
			return $tabData;
		}//function


		function getNbligne($curs=''){
		// Retourne le nombre de lignes
			if($curs!='')
				$this->curs=$curs;

			if (!($this->curs))
				return false;

			return @mysqli_num_rows($this->curs);
		}//function

		function getNbChamps($cur=''){
		// Retourne le nombre de colonnes
			if($curs!='')
				$this->curs=$curs;

			if (!($this->curs))
				return false;

			return @mysqli_num_fields($this->curs);
		}//function

		function getNomChamps($curs='',$numcol=0) {
		//Retourne le libell� du champs $numcol
			if($curs!='')
				$this->curs=$curs;

			if (!($this->curs))
				return false;

			return @mysqli_field_name($this->curs,$numcol);
		}//function

		function getTypeChamps($curs='',$numcol=0) {
		//Retourne le libell� du champs $numcol
			if($curs!='')
				$this->curs=$curs;

			if (!($this->curs))
				return false;

			return @mysqli_field_type($this->curs,$numcol);
		}//function

		function getSizeChamps($curs='',$numcol=0) {
		//Retourne le libell� du champs $numcol
			if($curs!='')
				$this->curs=$curs;

			if (!($this->curs))
				return false;

			return @mysqli_field_len($this->curs,$numcol);
		}//function
        function msgErreur(){
		    echo "<b>Erreur Mysql : </b>";
		    echo mysqli_errno($this->conn) . ": " . mysqli_error($this->conn) . "\n";
		}
		function close() {
			if (!(@mysqli_close($this->conn))) {
				return false;
			}//if
			return true;
		}//function

	}// Class
?>