<?php

error_reporting(E_ALL & ~E_WARNING);

$WINDOWS_PATH   = $_SERVER['SystemRoot'];

$HOME_WEB       = 'C:/web';
$APACHE_MAIL    = 'MarinJC@mairie-aixenprovence.fr';

if (isset($_SERVER['USERNAME']) && $_SERVER['USERNAME'] != '')
    $APACHE_MAIL    = $_SERVER['USERNAME'].'@mairie-aixenprovence.fr';

configureAllVariables();

//print_r($VARIABLES);

//$HOME_APACHE    = $HOME_WEB;
//$HOME_PHP       = $HOME_WEB.'/php5';
//$HOME_MYSQL     = $HOME_WEB.'/mysql';
//$HOME_SITES     = $HOME_WEB.'/sites';
//$APACHE_PORT    = '80';

function getReponse()
{
    $choix = '';
    fscanf(STDIN, "%s\n", $choix);
    return $choix;
}

$continuer = true;
echo '**********************************************'."\n";
echo '* GESTION BASE MYSQL By MarinJC version 2019 *'."\n";
echo '**********************************************'."\n";
echo "\n";
echo ' PROJECT_DATA_PATH = ['.$PROJECT_DATA_PATH."]\n";
echo ' PROJECT_HOME_PATH = ['.$PROJECT_HOME_PATH."]\n";
echo ' PROJECT_NAME = ['.$PROJECT_NAME."]\n\n";

foreach($VARIABLES as $k => $tab)
{
	$i=1;
	foreach($tab as $v)
	{
		echo ' '.strtoupper($k).' #'.$i.' => ['.$v['HOST'].' : '.$v['USERNAME'].' @ '.$v['PASSWORD'].' (Base = '.$v['DATABASE'].') ]'."\n";
		$i++;
	}
//	echo '';
}

//echo '  PROD = ['.$MYSQL_PROD_HOST.' @ '.$MYSQL_PROD_USERNAME.' : '.$MYSQL_PROD_PASSWORD.' ('.$MYSQL_PROD_DATABASE.') ]'."\n";

while($continuer === true)
{
    echo "\n";
    echo "---------- Configuration du projet [".$PROJECT_NAME."] ---------- \n";

    // Choix 1
    if (count($VARIABLES['local']) == 1)
	    echo ' 1) Creer la Base de donnee locale ['.$VARIABLES['local'][0]['DATABASE'].'] + Creer l\'utilisateur MySql ['.$VARIABLES['local'][0]['USERNAME'].']'."\n";
	else if (count($VARIABLES['local']) > 1)
	{

		echo ' 1) Creer les Bases de donnees locales [';
		$i=0;
		foreach($VARIABLES['local'] as $v)
		{
			if ($i>0)
				echo ', ';
			echo $v['DATABASE'];
			$i++;
		}
		echo '] + Creer l\'utilisateur MySql ['.$MYSQL_LOCAL_USERNAME.']'."\n";
	}
	else
	{
		echo '1) connexion.php incorrect...'."\n";
	}

	// Choix 2
	if (count($VARIABLES['prod']) > 0)
	{
	    echo ' 2) Recuperer les donnees de PROD et inserer en LOCAL :'."\n";
	
		$i=0;
		foreach($VARIABLES['prod'] as $v)
		{
			echo '     ['.$v['HOST'] .' > '. $v['DATABASE'].'] => ';
			echo '['.$VARIABLES['local'][$i]['HOST'] .' > '. $VARIABLES['local'][$i]['DATABASE'].']'."\n";
			$i++;
		}
	}
	else
	{
		echo '2) connexion.php incorrect...'."\n";
	}

    //echo ' 2) Recuperer les donnees de PROD ('.$MYSQL_PROD_HOST.' > '.$MYSQL_PROD_DATABASE.') et les inserer en local ('.$MYSQL_LOCAL_HOST.' > '.$MYSQL_LOCAL_DATABASE.').'."\n";
    //echo ' 3) Grant user on usearch'."\n";
    echo ' 3) Quitter'."\n\n";
    echo 'Tapez le numero de votre choix : ';
    $reponse = getReponse();
    
    if ($reponse == '1')
        createDatabaseAndUser();
    else if ($reponse == '2')
        dumpProdAndInsertLocal();
    else if ($reponse == '3')
        $continuer = false;
    else
        echo 'Reponse incorrecte'."\n";
}

foreach($VARIABLES['prod'] as $k => $v)
{
	if (file_exists('gestion-bdd-importer-donnees-en-local-'.$k.'.bat'))
		unlink('gestion-bdd-importer-donnees-en-local-'.$k.'.bat');

	if (file_exists('dump_prod_'.$k.'.sql'))
		unlink('dump_prod_'.$k.'.sql');
}

function dumpProdAndInsertLocal()
{
	global $MYSQL_LOCAL_HOST, $MYSQL_LOCAL_DATABASE, $MYSQL_LOCAL_USERNAME, $MYSQL_LOCAL_PASSWORD,
    		$MYSQL_PROD_HOST, $MYSQL_PROD_DATABASE, $MYSQL_PROD_USERNAME, $MYSQL_PROD_PASSWORD, $PROJECT_DATA_PATH;
    global $VARIABLES;

    foreach($VARIABLES['prod'] as $k => $v)
	{
		$MYSQL_PROD_HOST = $v['HOST'];
		$MYSQL_PROD_DATABASE = $v['DATABASE'];
		$MYSQL_PROD_USERNAME = $v['USERNAME'];
		$MYSQL_PROD_PASSWORD = $v['PASSWORD'];

		$MYSQL_LOCAL_HOST = $VARIABLES['local'][$k]['HOST'];
		$MYSQL_LOCAL_DATABASE = $VARIABLES['local'][$k]['DATABASE'];
		$MYSQL_LOCAL_USERNAME = $VARIABLES['local'][$k]['USERNAME'];
		$MYSQL_LOCAL_PASSWORD = $VARIABLES['local'][$k]['PASSWORD'];

		if ($MYSQL_PROD_HOST == 'SDELPHINUS_IP')
	    	$MYSQL_PROD_HOST = 'sdelphinus.intranet';
	    if ($MYSQL_PROD_HOST == 'EADM_SECUREBD_IP')
	    	$MYSQL_PROD_HOST = '192.168.50.200';
	    if ($MYSQL_PROD_HOST == 'EADMBD_IP')
	    	$MYSQL_PROD_HOST = '192.168.50.6';
	    if ($MYSQL_PROD_HOST == 'SARRAKISBD_IP')
	    	$MYSQL_PROD_HOST = '10.128.4.232';

		if ($MYSQL_PROD_HOST != '' && $MYSQL_PROD_DATABASE != '' && $MYSQL_PROD_USERNAME != '' && $MYSQL_PROD_PASSWORD != '')
		{
			echo 'Dump des donnees de PROD ['.$MYSQL_PROD_HOST.' > '.$MYSQL_PROD_DATABASE.'] => ';
			
			$command = 'mysqldump --user=dumpuser --password=man2dumpuser4mysql --host='.$MYSQL_PROD_HOST.' --complete-insert --add-drop-table --extended-insert=true --databases '.$MYSQL_PROD_DATABASE.' --default-character-set=latin1 > dump_prod_'.$k.'.sql';


			echo exec($command);
			echo "OK\n";

			if ($MYSQL_LOCAL_HOST != '' && $MYSQL_LOCAL_DATABASE != '' && $MYSQL_LOCAL_USERNAME != '' && $MYSQL_LOCAL_PASSWORD != '')
			{
				echo 'Insertion des donnees en LOCAL ['.$MYSQL_LOCAL_HOST.' > '.$MYSQL_LOCAL_DATABASE.'] => ';
				$command = '';
				if ($MYSQL_LOCAL_DATABASE != $MYSQL_PROD_DATABASE)
				{
					// on a pas le nom de BDD
					$command = 'php -r "file_put_contents(\'dump_prod_'.$k.'.sql\', str_replace(array(\'CREATE DATABASE\',\'USE `\'),array(\'# CREATE DATABASE\',\'# USE `\'),file_get_contents(\'dump_prod_'.$k.'.sql\')));"'."\n";
				}
				$command .= 'mysql -u '.$MYSQL_LOCAL_USERNAME.' -p'.$MYSQL_LOCAL_PASSWORD.' -v '.$MYSQL_LOCAL_DATABASE.' < dump_prod_'.$k.'.sql';

				//exec($command);
				file_put_contents('gestion-bdd-importer-donnees-en-local-'.$k.'.bat', '@echo off'."\n".'color 0A'."\n".'cls'."\n".$command."\n".'exit');
				//echo $PROJECT_DATA_PATH.'sql\\gestion-bdd-importer-donnees-en-local.bat';
				exec('cmd.exe /c START '.$PROJECT_DATA_PATH.'/sql/gestion-bdd-importer-donnees-en-local-'.$k.'.bat');
				echo "OK\n";
				
				/*for($i=1;$i<10;$i++)
				{
					echo 'Waiting '.(10-$i).'...'."\n";
					sleep(1);
				}*/
				

				/*if (file_exists('gestion-bdd-importer-donnees-en-local.bat'))
					unlink('gestion-bdd-importer-donnees-en-local.bat');

				if (file_exists('dump_prod.sql'))
					unlink('dump_prod.sql');*/

				if (file_exists('../objet_bdd/all_classes.php'))
				{
					echo 'Supprimer le fichier objet_bdd/all_classes.php ? (y/n)'."\n";
				    $reponse = getReponse();
				    if ($reponse != 'y')
				        return;
				    echo 'Suppression du fichier objet_bdd/all_classes.php => ';
				    if (unlink('../objet_bdd/all_classes.php'))
				    {
				    	echo 'OK'."\n";
				    }
				    else
				    {
						echo 'ERREUR'."\n";
				    }
				    
				}
			}
			else
			{
				echo 'Impossible de trouver les infos de connexion a la base de donnee mysql locale'."\n";
			}
		}
		else
		{
			echo 'Impossible de trouver les infos de connexion a la base de donnee mysql de prod'."\n";
		}
	}
}

function createDatabaseAndUser()
{
	global $VARIABLES;
	foreach($VARIABLES['local'] as $v)
	{
		$MYSQL_LOCAL_DATABASE = $v['DATABASE'];
		$MYSQL_LOCAL_USERNAME = $v['USERNAME'];
		$MYSQL_LOCAL_PASSWORD = $v['PASSWORD'];
		if ($MYSQL_LOCAL_DATABASE != '' && $MYSQL_LOCAL_USERNAME != '' && $MYSQL_LOCAL_PASSWORD != '')
		{
			echo "\n".'Verification si la base de donnees ['.$MYSQL_LOCAL_DATABASE.'] existe => ';
			
			$baseDeDonneExiste = false;
	    	$mysqli = new mysqli('127.0.0.1', 'root', 'man2mysql', $MYSQL_LOCAL_DATABASE);
	    	if (substr_count($mysqli->connect_error, 'Unknown database ') > 0)
	    	{
	    		// base de donnée non créé, on la créé
	    		echo 'ERREUR'."\n";
	    		echo 'Creation BDD ['.$MYSQL_LOCAL_DATABASE.'] => ';
	    		$mysqli = new mysqli('127.0.0.1', 'root', 'man2mysql');
	    	
	    		if ($mysqli->query('create database `'.$MYSQL_LOCAL_DATABASE.'`'))
	    		{
	    			echo 'OK'."\n";
	    			$baseDeDonneExiste = true;
	    		}
	    		else
	    		{
	    			echo 'ERREUR : '.$mysqli->error."\n";
	    		}
	    		//$
	    	}
	    	else if ($mysqli->connect_error != '')
	    	{
	    		echo 'ERREUR : '.$mysqli->error."\n";
	    		echo 'Erreur non repertorie : '.$mysqli->connect_error."\n";
	    	}
	    	else
	    	{
	    		echo 'OK'."\n";
	    		$baseDeDonneExiste = true;
	    	}

	    	if ($baseDeDonneExiste === true)
	    	{
	    		// création du GRANT user
	    		echo 'Verification si le user ['.$MYSQL_LOCAL_USERNAME.'] est bien cree pour la BDD ['.$MYSQL_LOCAL_DATABASE.'] => ';
	    		$mysqli = new mysqli('127.0.0.1', $MYSQL_LOCAL_USERNAME, $MYSQL_LOCAL_PASSWORD, $MYSQL_LOCAL_DATABASE);

	    		if ($mysqli->connect_errno == '1045' || $mysqli->connect_errno == '1044') // access denied
	    		{
	    			echo 'ERREUR'."\n";
	    			echo 'Creation USER ['.$MYSQL_LOCAL_USERNAME.'/'.$MYSQL_LOCAL_PASSWORD.'] => ';
	    			$mysqli = new mysqli('127.0.0.1', 'root', 'man2mysql');
	    	
		    		if ($mysqli->query('grant all privileges on `'.$MYSQL_LOCAL_DATABASE.'`.* to `'.$MYSQL_LOCAL_USERNAME.'` identified by \''.$MYSQL_LOCAL_PASSWORD.'\''))
		    		{
		    			echo 'OK'."\n";
		    			$mysqli->query('flush privileges');
		    		}
		    		else
		    		{
		    			echo 'ERREUR : '.$mysqli->error."\n";
		    		}

		    		
		    		GrantOnAutresBases($MYSQL_LOCAL_DATABASE, $MYSQL_LOCAL_USERNAME, $MYSQL_LOCAL_PASSWORD);
				    //echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}
				else
				{
					if ($mysqli->connect_errno != '')
					{
						// autre erreur ?
						echo $mysqli->connect_errno;
					}
					else
					{
						echo 'OK'."\n";
						GrantOnAutresBases($MYSQL_LOCAL_DATABASE, $MYSQL_LOCAL_USERNAME, $MYSQL_LOCAL_PASSWORD);
					}
				}
	    	}

			//print_r($mysqli);
			/*catch (Exception $e)
			{
	    		echo 'Exception recue : ',  $e->getMessage(), "\n";
	    		print_r($e);
			}*/
			echo "\n";
		}
		else
		{
			echo 'Impossible de trouver les infos de connexion a la base de donnee mysql'."\n";
		}
	}
}

function GrantOnAutresBases($MYSQL_LOCAL_DATABASE, $MYSQL_LOCAL_USERNAME, $MYSQL_LOCAL_PASSWORD)
{
	// grant on Usearch ?
	$mysqli = new mysqli('127.0.0.1', 'root', 'man2mysql');
	if ($MYSQL_LOCAL_DATABASE != 'usearch')
	{
		echo 'Autoriser le user `'.$MYSQL_LOCAL_USERNAME.'` sur la base `usearch` ? (y = OUI)'."\n";
	    $reponse = getReponse();
	    if ($reponse == 'y')
	    {
	    	echo 'Grant `'.$MYSQL_LOCAL_USERNAME.'` sur la base `usearch` => ';
	    	if ($mysqli->query('grant all privileges on `usearch`.* to `'.$MYSQL_LOCAL_USERNAME.'` identified by \''.$MYSQL_LOCAL_PASSWORD.'\''))
    		{
    			echo 'OK'."\n";
    			$mysqli->query('flush privileges');
    		}
    		else
    		{
    			echo 'ERREUR : '.$mysqli->error."\n";
    		}
	    }
	}

	// grant on gpi ?
	if ($MYSQL_LOCAL_DATABASE != 'gpi')
	{
		echo 'Autoriser le user `'.$MYSQL_LOCAL_USERNAME.'` sur la base `gpi` ? (y = OUI)'."\n";
	    $reponse = getReponse();
	    if ($reponse == 'y')
	    {
	    	echo 'Grant `'.$MYSQL_LOCAL_USERNAME.'` sur la base `gpi` => ';
	    	if ($mysqli->query('grant all privileges on `gpi`.* to `'.$MYSQL_LOCAL_USERNAME.'` identified by \''.$MYSQL_LOCAL_PASSWORD.'\''))
    		{
    			echo 'OK'."\n";
    			$mysqli->query('flush privileges');
    		}
    		else
    		{
    			echo 'ERREUR : '.$mysqli->error."\n";
    		}
	    }
	}

	// grant on stats_projets ?
	if ($MYSQL_LOCAL_DATABASE != 'stats_projets')
	{
		echo 'Autoriser le user `'.$MYSQL_LOCAL_USERNAME.'` sur la base `stats_projets` ? (y = OUI)'."\n";
	    $reponse = getReponse();
	    if ($reponse == 'y')
	    {
	    	echo 'Grant `'.$MYSQL_LOCAL_USERNAME.'` sur la base `stats_projets` => ';
	    	if ($mysqli->query('grant all privileges on `stats_projets`.* to `'.$MYSQL_LOCAL_USERNAME.'` identified by \''.$MYSQL_LOCAL_PASSWORD.'\''))
    		{
    			echo 'OK'."\n";
    			$mysqli->query('flush privileges');
    		}
    		else
    		{
    			echo 'ERREUR : '.$mysqli->error."\n";
    		}
	    }
	}
}
function configureAllVariables()
{
    global $PROJECT_HOME_PATH, $PROJECT_DATA_PATH, $PROJECT_NAME, 
    		$MYSQL_LOCAL_HOST, $MYSQL_LOCAL_DATABASE, $MYSQL_LOCAL_USERNAME, $MYSQL_LOCAL_PASSWORD,
    		$MYSQL_PROD_HOST, $MYSQL_PROD_DATABASE, $MYSQL_PROD_USERNAME, $MYSQL_PROD_PASSWORD,
    		$VARIABLES;
    $PROJECT_HOME_PATH = str_replace('\\data\\sql\\','',$_SERVER['currentpath']);
    $PROJECT_DATA_PATH = $PROJECT_HOME_PATH.'\\data\\';
    $PROJECT_NAME = basename($PROJECT_HOME_PATH);

    $contentFileConnexion = file_get_contents($PROJECT_DATA_PATH.'\\connexion.php');

    //print_r($contentFileConnexion);
    $MYSQL_LOCAL_DATABASE = '';
    $MYSQL_LOCAL_USERNAME = '';
    $MYSQL_LOCAL_PASSWORD = '';

    $MYSQL_PROD_DATABASE = '';
    $MYSQL_PROD_USERNAME = '';
    $MYSQL_PROD_PASSWORD = '';
    $VARIABLES = array(
    					'prod' => array(),
    					'local' => array(),
					);
/*
$dbHost	= 'localhost';
	    $dbUser	= 'gfibot';
	    $dbPass	= 'gfibot_pwd';
	    $dbName	= 'gfibot';
	    $dbType = 'mysql
*/
    preg_match_all(
                        '#'.
                        '\$dbHost[ \t]*= \'?([^\']*)\'?;'.
                        '.*\$dbUser.*= \'(.*)\';'.
                        '.*\$dbPass.*= \'(.*)\';'.
                        '.*\$dbName.*= \'(.*)\';'.
                        '.*\$dbType.*= \'(.*)\';'.
                        '#Us', $contentFileConnexion, $tabMatch, PREG_SET_ORDER);
    //print_r($tabMatch);
	foreach($tabMatch as $v)
    {
    	if (($v[1] == '127.0.0.1' || $v[1] == 'localhost') && substr($v[5], 0, 5) == 'mysql')
    	{
    		// on est en présence d'une info de connexion mysql sur une base locale
    		$VARIABLES['local'][] = array(
											'HOST' => $v[1],
											'USERNAME' => $v[2],
											'PASSWORD' => $v[3],
											'DATABASE' => $v[4],
											'DEBUG' => $v[0],
										);
    		if ($MYSQL_LOCAL_HOST == '')
    		{
    			$MYSQL_LOCAL_HOST = $v[1];
    			$MYSQL_LOCAL_USERNAME = $v[2];
    			$MYSQL_LOCAL_PASSWORD = $v[3];
    			$MYSQL_LOCAL_DATABASE = $v[4];
    		}
    	}
    	if ($v[1] != '127.0.0.1' && $v[1] != 'localhost' && substr($v[5], 0, 5) == 'mysql')
    	{
    		// si ce n'est pas local, c'est la PROD

    		$VARIABLES['prod'][] = array(
											'HOST' => $v[1],
											'USERNAME' => $v[2],
											'PASSWORD' => $v[3],
											'DATABASE' => $v[4],
											'DEBUG' => $v[0],
										);
    		if ($MYSQL_PROD_HOST == '')
    		{
	    		$MYSQL_PROD_HOST = $v[1];
				$MYSQL_PROD_USERNAME = $v[2];
				$MYSQL_PROD_PASSWORD = $v[3];
				$MYSQL_PROD_DATABASE = $v[4];
			}
    	}
    }
    
    
        /*$tabPost = array();
        foreach($tabMatch as $v)
        {
            $tabPost[$v[1]] = $v[3];
        }*/

    /*
    $HOME_APACHE    = $HOME_WEB;
    $HOME_PHP       = $HOME_WEB.'/php5';
    $HOME_MYSQL     = $HOME_WEB.'/mysql';
    $HOME_SITES     = $HOME_WEB.'/sites';
    $APACHE_PORT    = '80';*/
}

function installApache()
{
    global $HOME_WEB, $HOME_APACHE, $APACHE_PORT;
    verifSiSiteDirectoryExist();
    echo 'Installation d\'Apache dans le repertoire : '. $HOME_WEB."/Apache24/\n";
    echo 'Etes vous sur ? (y/n)'."\n";
    $reponse = getReponse();
    if ($reponse != 'y')
        return;
    echo 'Installation d\'apache en cours... Veuillez patientez SVP...'."\n";
    $fichier = 'httpd-2.4.12-win32-VC11.zip';
    unzip($fichier,$HOME_WEB.'/');
    //exec('msiexec /i apache_2.0.61-win32-x86-no_ssl.msi /passive ALLUSERS=1 INSTALLDIR="'. str_replace(':/',':\\',$HOME_APACHE) .'" SERVERADMIN="admin@localhost" SERVERNAME="localhost" SERVERDOMAIN="localhost" SERVERPORT="'. $APACHE_PORT .'"');
    echo 'Installation d\'apache terminee'."\n";
}

function insertLigneApres($filename, $chaine, $ligne)
{
    str_replace_fichier($filename, $chaine, $chaine."\r\n".$ligne, false);
    echo "Ajout : $ligne\n";
}

function str_replace_fichier($filename, $chaine, $chaineRemplacement, $verbose = true, $verifChaine = true)
{
    // Assurons nous que le fichier est accessible en écriture
    if (is_writable($filename))
    {
        // Lit un fichier, et le place dans une chaîne
        $handle = fopen ($filename, "r");
        $contents = fread ($handle, filesize ($filename));
        fclose($handle);
        
        // Vérification si la chaine n'est pas déjà dans le fichier
        if ($verifChaine && substr_count($contents, $chaineRemplacement) > 0)
        {
            echo 'ERREUR ['.str_replace(array("\n","\r"), '', $chaineRemplacement).'] deja present'."\n";
            return;
        }
        
        // Remplacement dans la chaine
        $contents = str_replace($chaine, $chaineRemplacement, $contents);
        
        // Réécriture dans le fichier
        if (!$handle = fopen($filename, 'w'))
        {
             echo "Impossible d'ouvrir le fichier ($filename)\n";
             return;
        }
        
        if (fwrite($handle, $contents) === FALSE)
        {
           echo "Impossible d'ecrire dans le fichier ($filename)\n";
           return;
        }
        fclose($handle);
        if ($verbose)
            echo "Modif : $chaineRemplacement\n";
    }
    else
    {
        echo "ERREUR: Le fichier $filename n'est pas accessible en ecriture.\n";
        return;
    }
}

function unzip($file, $path='', $effacer_zip=false)
{/*Méthode qui permet de décompresser un fichier zip $file dans un répertoire de destination $path
  et qui retourne un tableau contenant la liste des fichiers extraits
  Si $effacer_zip est égal à true, on efface le fichier zip d'origine $file*/
	
	$tab_liste_fichiers = array(); //Initialisation

	$zip = zip_open($file);

	if ($zip)
	{
		while ($zip_entry = zip_read($zip)) //Pour chaque fichier contenu dans le fichier zip
		{
			if (zip_entry_filesize($zip_entry) > 0)
			{
				$complete_path = $path.dirname(zip_entry_name($zip_entry));

				/*On supprime les éventuels caractères spéciaux et majuscules*/
				$nom_fichier = basename(zip_entry_name($zip_entry));
				$nom_fichier = strtr($nom_fichier,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
				$nom_fichier = strtolower($nom_fichier);
				$nom_fichier = ereg_replace('[^a-zA-Z0-9._]','-',$nom_fichier);
                //echo basename(zip_entry_name($zip_entry))."\n";
                
				/*On ajoute le nom du fichier dans le tableau*/
				array_push($tab_liste_fichiers,$nom_fichier);

				//$complete_name = $path.'/'.$nom_fichier; //Nom et chemin de destination
				$complete_name = $complete_path .'/'. $nom_fichier; //Nom et chemin de destination
                echo 'decompressing... '. $complete_name ."\n";
                
				if(!file_exists($complete_path))
				{
					$tmp = '';
					foreach(explode('/',$complete_path) AS $k)
					{
						$tmp .= $k.'/';

						if(!file_exists($tmp))
						{ mkdir($tmp, 0755); }
					}
				}

				/*On extrait le fichier*/
				if (zip_entry_open($zip, $zip_entry, "r"))
				{
					$fd = fopen($complete_name, 'w');

					fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));

					fclose($fd);
					zip_entry_close($zip_entry);
				}
			}
		}

		zip_close($zip);

		/*On efface éventuellement le fichier zip d'origine*/
		if ($effacer_zip === true)
		unlink($file);
	}

	return $tab_liste_fichiers;
}

echo "\n\n";

?>