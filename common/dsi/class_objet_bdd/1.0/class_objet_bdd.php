<?php

/*
    Class qui va g�n�rer des objets PHP � partir d'une base de donn�e
    Chaque table sera un objet
*/
 
class ObjetBdd
{
    var $db;
    var $tables = array();
    var $version = '1.3';
    var $base = ''; // mysql ou oracle
    
    function __construct($db)
    {
        $this->ObjetBdd($db);
    }

    function ObjetBdd($db)
    {
        set_time_limit(600);
        //$this->db = $db;
        $this->setBase($db);
    }
    
    function setBase($db)
    {
        if (substr($db->dbsyntax, 0, 5) == 'mysql')
            $this->base = 'mysql';
        else if ($db->dbsyntax == 'oci8')
            $this->base = 'oracle';
        else
            die('base de donn�es ['.$db->dbsyntax.'] non reconnu');
        $this->db = $db;
    }
    
    function setAllTables()
    {
        if ($this->base == 'mysql')
            $req = 'show tables';
        else
            $req =  'select object_name, object_type '.
                    'from user_objects '.
                    'where object_type in (\'TABLE\',\'VIEW\',\'MATERIALIZED VIEW\')';
        $res = executeReq($this->db, $req);
        $this->tables = array();
        while(list($t) = $res->fetchRow())
        {
            $this->tables[] = $t;
        }
    }
    
    function setTables($tabTable)
    {
        $this->tables = array();
        foreach($tabTable as $v)
            $this->tables[] = $v;
    }
    
    function compressPHPFile($fichier)
    {
        global $PROD;
        if ($PROD == 0)
            return;
        //print_jc($_SERVER);
        $nouveauFichier = $fichier.'.min';
    
        $command = 'php -d short_open_tag=On -w '.$fichier.' >> '.$nouveauFichier;
    
        if (file_exists($nouveauFichier))
            unlink($nouveauFichier);
        syscall($command); // compression
        
        unlink($fichier); // suppression ancien fichier
        rename($nouveauFichier, $fichier); // remplacement par le fichier compresse
        
        //echo $fichier;
        //exit;
    }
    
    function setAllObjetsForTables($isFileAllReadyExists = false)
    {
        global $DATA_PATH;
        $rep = $DATA_PATH . '/objet_bdd';
        $old_umsak = umask();
        umask(002);
        if (!is_dir($rep))
            mkdir($rep);
        
        $repFichier = $rep .'/'. $this->base;
        
        if (!is_dir($repFichier))
            mkdir($repFichier);
    
        if ($isFileAllReadyExists)
        {
            $chClass = "\n".'// Inclusion des classes '. $this->base ."\n";
        }
        else
        {
            $chClass =  '<?php'."\n".
                        '// Inclusion des classes '. $this->base ."\n";
        }
        
        foreach($this->tables as $tableName)
        {
            // G�n�ration de la class �quivalent � 1 ligne de la table
            $file = $repFichier .'/'. $this->getNameForFile($tableName) .'.php';
            $f = fopen($file, 'w+');
            if ($f)
            {
                $ch = $this->getClassForTable($tableName);
                fwrite($f, $ch);
                fclose($f);
                $this->compressPHPFile($file);
//                chmod($file, 0664);
                $chClass .= 'require_once($DATA_PATH . \'/objet_bdd/'. $this->base .'/'. $this->getNameForFile($tableName) .'.php\');'."\n";
            }
            else
            {
                echo '<font color=red>Impossible de cr�er le fichier '. $file .'</font>';
            }
            
            // G�n�ration de la class �quivalent � plusieurs objet de la classe pr�c�dente
            $file = $repFichier .'/liste_'. $this->getNameForFile($tableName) .'.php';
            $f = fopen($file, 'w+');
            if ($f)
            {
                $ch = $this->getClassForListeObjet($tableName);
                fwrite($f, $ch);
                fclose($f);
                $this->compressPHPFile($file);
//                chmod($file, 0664);
                $chClass .= 'require_once($DATA_PATH . \'/objet_bdd/'. $this->base .'/liste_'. $this->getNameForFile($tableName) .'.php\');'."\n";
            }
            else
            {
                echo '<font color=red>Impossible de cr�er le fichier '. $file .'</font>';
            }
            //break;
            
        }
        
        $file = $rep .'/all_classes.php';
        if ($isFileAllReadyExists)
        {
            $f = fopen($file, 'r');
            $chFichierExistant = fread ($f, filesize($rep .'/all_classes.php'));
            fclose($f);
            
            $chFichierExistant = str_replace(   '$ALL_CLASSE_LOADED = 1;',
                                                $chClass.'$ALL_CLASSE_LOADED = 1;',
                                                $chFichierExistant);
            
            $f = fopen($file, 'w+');
            fwrite($f, $chFichierExistant);
            fclose($f);
        }
        else
        {
            $chClass .=  '$ALL_CLASSE_LOADED = 1;'."\n";
            $chClass .=  '?>';
            
            $f = fopen($file, 'w+');
            fwrite($f, $chClass);
            fclose($f);
        }
        
        $this->compressPHPFile($file);
        umask($old_umsak);
//        chmod($rep .'/all_classes.php', 0664);
        
        
//        $res = executeReq($this->db, 'show tables');
//        $this->tables = array();
//        while(list($t) = $res->fetchRow())
//        {
//            $this->tables[] = $t;
//        }
    }
    
    function getNameForClass($tableName)
    {
        $t = explode('_', strtolower($tableName));
        foreach ($t as $k => $v)
        {
            $t[$k] = ucfirst($v);
        }
        $ch = implode('',$t);
        return $ch;
    }
    
    function getNameForFile($tableName)
    {
        return strtolower($tableName);
    }
    
    function getNameForColonne($colonne)
    {
        $t = explode('_', strtolower($colonne));
        
        foreach ($t as $k => $v)
        {
            $t[$k] = ucfirst($v);
        }
        $t[0] = strtolower($t[0]);
        $ch = implode('',$t);
        return $ch;
    }
    
    function getClassForTable($tableName)
    {
        $table = array();
        $primaryKey = array();
        $ch =   '<?php'."\n"."\n".
                '/** '."\n".
                //' * Classe repr�sentant la table `'. $tableName .'` de la base `'. $this->db->_db .'`. '."\n".
                ' * Classe repr�sentant la table `'. $tableName .'`'."\n".
                //' * @package ObjetBdd' ."\n".
                ' * @version '. $this->version ."\n".
                ' */'."\n";
        $ch .=  'class '. $this->getNameForClass($tableName) ."\n".
                '{'."\n";
        
        // R�cup�ration des colonnes de la table
//        if ($this->base == 'mysql')
//            $req = 'show fields from '. $tableName;
//        else
//            $req =  'select column_name, data_type, nullable, nullable, data_default, data_length '.
//                    'from user_tab_columns '.
//                    'where TABLE_NAME=\''. $tableName .'\' order by column_id';
//
//        $res = executeReq($this->db, $req);
//        while(list($field, $type, $null, $key, $default, $extra) = $res->fetchRow())
//        {
//            if ($this->base == 'oracle')
//            {
//                $req2 = 'select user_constraints.constraint_name,user_cons_columns.column_name, user_constraints.constraint_type '.
//                        'from user_constraints, user_cons_columns '.
//                        'where user_constraints.OWNER=user_cons_columns.OWNER '.
//                        'and user_constraints.TABLE_NAME=user_cons_columns.TABLE_NAME '.
//                        'and user_constraints.constraint_type=\'P\' '.
//                        'and user_constraints.TABLE_NAME=\''. $tableName .'\' '.
//                        'and user_cons_columns.column_name=\''. $field .'\' ';
//                
//                $res2 = executeReq($this->db, $req2);
//                $key = '';
//                while(list($constraint_name, $column_name, $constraint_type) = $res2->fetchRow())
//                {
//                    $key = 'PRI';
//                    //print_r($constraint_name.$column_name.$constraint_type);
//                }
//            }
//            $table[$field] = array(
//                                    'FIELD' => $field,
//                                    'TYPE' => $type,
//                                    'NULL' => ($null == 'Y' ? 'YES':'NO'),
//                                    'KEY' => $key,
//                                    'DEFAULT' => $default,
//                                    'EXTRA' => $extra,
//                                    'VAR' => $this->getNameForColonne($field)
//                                   );
//            if ($key == 'PRI')
//                $primaryKey[] = $field;
//        }
        
        list($table, $primaryKey) = $this->getAllChampsForTableName($tableName);
        
//        print_r($primaryKey);
//        print_r($table);

        $ch .= "\t".'var $db;'."\n";
        
        // D�claration des variables
        $ch .= "\t".'// D�claration des variables repr�sentant les colonnes de la table'."\n";
        foreach($table as $colonne => $v)
        {
            $ch .= "\t".'var $'. $v['VAR'] .' = false;'."\n";
        }
        
        // D�claration des modificateurs
        //$ch .= "\n\t".'// D�claration des modificateurs'."\n";
        foreach($table as $colonne => $v)
        {
            $ch .= "\n\t".'/** '."\n".
                "\t".' * Fonction qui met � jour la variable $'. $v['VAR'] ."\n".
                "\t".' * repr�sentant la colonne `'. $colonne .'` de la table `'. $tableName ."`\n".
                "\t".' */'."\n";
            $ch .=  "\t".'function set'. ucfirst($v['VAR']) .'($v)'."\n".
                    "\t".'{'."\n".
                    "\t"."\t".'$this->'. $v['VAR'] .' = $v;'."\n".
                    "\t".'}'."\n";
        }
        
        // D�claration des accesseurs
        //$ch .= "\n\t".'// D�claration des accesseurs'."\n";
        foreach($table as $colonne => $v)
        {
            $ch .= "\n\t".'/** '."\n".
                "\t".' * Retourne la valeur de la variable $'. $v['VAR'] ."\n".
                "\t".' * Cette variable repr�sentante la colonne `'. $colonne .'` de la table `'. $tableName ."`\n".
                "\t".' * @return mixed'."\n".
                "\t".' */'."\n";
            $ch .=  "\t".'function get'. ucfirst($v['VAR']) .'()'."\n".
                    "\t".'{'."\n".
                    "\t"."\t".'return $this->'. $v['VAR'] .';'."\n".
                    "\t".'}'."\n";
        }
        
        // D�claration du constructeur
        //$ch .= "\n\t".'// constructeur'."\n";
        $ch .= "\n\t".'/** '."\n".
                "\t".' * @param DB $db connexion � la base de donn�es'."\n".
                "\t".' */'."\n";
        $ch .=  "\t".'function '. $this->getNameForClass($tableName) .'($db)'."\n".
                "\t".'{'."\n".
                "\t"."\t".'return $this->db = $db;'."\n".
                "\t".'}'."\n";
        
        // Fonction V�rification des champs NOT NULL
        //$ch .= "\n\t".'// Fonction qui v�rifie si les champs NOT NULL ont bien une valeur'."\n";
        $ch .= "\n\t".'/** '."\n".
                "\t".' * V�rifie si les champs NOT NULL ont bien une valeur'."\n".
                "\t".' * G�n�re un die en cas d\'erreur'."\n".
                "\t".' */'."\n";
        $ch .=  "\t".'function verifChampsNotNull()'."\n".
                "\t".'{'."\n";
        foreach($table as $colonne => $v)
        {
            if ($v['NULL'] == '') // NO ?
            {
                $ch .=  "\t"."\t".'if ($this->get'. ucfirst($v['VAR']) .'() == \'\')'."\n".
                        "\t"."\t"."\t".'die(\'Ex�cution impossible car le champs OBLIGATOIRE `'. $colonne .'` n\\\'a pas de valeur!\');'."\n";
            }
        }
        $ch .= "\t".'}'."\n";
        
        // Fonction V�rification des champs PRIMARY KEY
        //$ch .= "\n\t".'// Fonction qui v�rifie si les champs PRIMARY KEY ont bien une valeur'."\n";
        $ch .= "\n\t".'/** '."\n".
                "\t".' * V�rifie si les champs qui doivent �tre des cl�s primaires ont bien une valeur'."\n".
                "\t".' * G�n�re un die en cas d\'erreur'."\n".
                "\t".' */'."\n";
        $ch .=  "\t".'function verifChampsPrimaryKey()'."\n".
                "\t".'{'."\n";
        foreach($table as $colonne => $v)
        {
            if (substr_count($v['EXTRA'], 'auto_increment') == 0 && $v['KEY'] == 'PRI')
            {
                $ch .=  "\t"."\t".'if ($this->get'. ucfirst($v['VAR']) .'() == \'\')'."\n".
                        "\t"."\t"."\t".'die(\'Ex�cution impossible car le champs OBLIGATOIRE `'. $colonne .'` n\\\'a pas de valeur!\');'."\n";
            }
        }
        $ch .= "\t".'}'."\n";
        
        
        // Insert
        //$ch .= "\n\t".'// Insertion nouvel �l�ment'."\n";
        $ch .= "\n\t".'/** '."\n".
                "\t".' * Ins�re l\'�l�ment en base'."\n".
                "\t".' * @return DB r�sultat de l\'insertion'."\n".
                "\t".' */'."\n";
        $ch .=  "\t".'function insert()'."\n".
                "\t".'{'."\n";
        $ch .=  "\t"."\t".'$this->verifChampsPrimaryKey();'."\n";
        $ch .=  "\t"."\t".'$req = \'insert into '. $tableName .' \'.'."\n".
                "\t"."\t".'       \'(\'.'."\n";
        $chInsert = '';
        foreach($table as $colonne => $v)
        {
            if (substr_count($v['EXTRA'], 'auto_increment') == 0)
            {
                //if ($chInsert != '')
                    //$chInsert .= ', ';
                //$chInsert .= "\t"."\t"."\t"."\t".'($this->'.$v['VAR'].' != false ? \''.$colonne.', \':\'\').'."\n";
                $chInsert .= "\t"."\t"."\t"."\t".'\''.$colonne.', \'.'."\n";
            }
        }
        $ch .= $chInsert ."\t"."\t"."\t"."\t".'\') \'.'."\n";
        
        $ch .= "\t"."\t".'       \'values (\'.'."\n";    
        
        $chInsert = '';
        foreach($table as $colonne => $v)
        {
            if (substr_count($v['EXTRA'], 'auto_increment') == 0)
            {
//                if ($chInsert != '')
//                    $chInsert .= "\t"."\t".'       \', ';
//                else
//                    $chInsert .= "\t"."\t".'       \'';
                //$chInsert .= "\t"."\t"."\t"."\t".'($this->'.$v['VAR'].' != false ? \'\\\'\'. protegeChaine($this->get'. ucfirst($v['VAR']) .'()) .\'\\\', \':\'\').'."\n";
                //$chInsert .= "\t"."\t"."\t"."\t".'($this->'.$v['VAR'].' !== false ? \'\\\'\'. protegeChaine($this->get'. ucfirst($v['VAR']) .'()) .\'\\\', \':\'NULL, \').'."\n";
                $chInsert .=    "\t"."\t"."\t"."\t".'($this->'.$v['VAR'].' != \'\' ? \'\\\'\'. '.
                                ($this->base == 'oracle' ? 'protegeChaineOracle':'protegeChaine').
                                '($this->get'. ucfirst($v['VAR']) .'()) .\'\\\', \':\'NULL, \').'."\n";
                //$chInsert .= '\\\'\'. protegeChaine($this->get'. ucfirst($v['VAR']) .'()) .\'\\\' \'.'."\n";
            }
        }
        $ch .= $chInsert;
        $ch .= "\t"."\t".'       \')\';'."\n";    
        $ch .= "\t"."\t".'$req = str_replace(\', )\', \')\', $req);'."\n";
        $ch .= "\t"."\t".'$res = executeReq($this->db, $req);'."\n";
        $ch .= "\t"."\t".'return $res;'."\n";

        $ch .= "\t".'}'."\n";
        // Fin Insert
        
        
        // Update
        $ch .= "\n\t".'/** '."\n".
                "\t".' * Met � jour tous les champs de la ligne dans la table'."\n".
                "\t".' * @return DB r�sultat de l\'update'."\n".
                "\t".' */'."\n";
        //$ch .= "\n\t".'// Mise � jour �l�ment'."\n";
        $ch .=  "\t".'function update()'."\n".
                "\t".'{'."\n";
        
        $ch .=  "\t"."\t".'$this->verifChampsNotNull();'."\n";
        $ch .=  "\t"."\t".'$req = \'update '. $tableName .' set \'.'."\n".

        $chUpdate = '';
        foreach($table as $colonne => $v)
        {
            if ($v['KEY'] != 'PRI')
            {
                if ($chUpdate != '')
                    $chUpdate .= "\t"."\t".'       \', ';
                else
                    $chUpdate .= "\t"."\t".'       \'';
                //$chUpdate .= $colonne .'=\\\'\'. protegeChaine($this->get'. ucfirst($v['VAR']) .'()) .\'\\\' \'.'."\n";
                //$chUpdate .= $colonne .'=\'. protegeChaine($this->get'. ucfirst($v['VAR']) .'()) .\'\\\' \'.'."\n";
                $chUpdate .=    $colonne .'=\'. ($this->'.$v['VAR'].' != \'\' ? \'\\\'\'. '.
                                ($this->base == 'oracle' ? 'protegeChaineOracle':'protegeChaine').
                                '($this->get'. ucfirst($v['VAR']) .'()) .\'\\\' \':\'NULL \').'."\n";
            }
        }
        $ch .= $chUpdate;
        
        $where = '';
        foreach($table as $colonne => $v)
        {
            if ($v['KEY'] == 'PRI')
            {
                if ($where != '')
                    $where .= "\t"."\t".'       \'AND ';
                else
                    $where .= "\t"."\t".'       \'WHERE ';
                 $where .=   $colonne .'=\\\'\'. '.
                            ($this->base == 'oracle' ? 'protegeChaineOracle':'protegeChaine').
                            '($this->get'. ucfirst($v['VAR']) .'()) .\'\\\' \'.'."\n";
            }
        }
        $ch .= $where;
        $ch .= "\t"."\t".'       \'\';'."\n";
        
        $ch .= "\t"."\t".'$res = executeReq($this->db, $req);'."\n";
        $ch .= "\t"."\t".'return $res;'."\n";
        $ch .= "\t".'}'."\n";
        // Fin Update
        
        // Delete
        $ch .= "\n\t".'/** '."\n".
                "\t".' * Supprime la ligne'."\n".
                "\t".' * @return DB r�sultat de la suppression'."\n".
                "\t".' */'."\n";
        //$ch .= "\n\t".'// Suppression �l�ment'."\n";
        $ch .=  "\t".'function delete()'."\n".
                "\t".'{'."\n";
        
        $ch .=  "\t"."\t".'$this->verifChampsNotNull();'."\n";
        $ch .=  "\t"."\t".'$req = \'delete from '. $tableName .' \'.'."\n".

        $where = '';
        foreach($table as $colonne => $v)
        {
            if ($v['KEY'] == 'PRI')
            {
                if ($where != '')
                    $where .= "\t"."\t".'       \'AND ';
                else
                    $where .= "\t"."\t".'       \'WHERE ';
                $where .=   $colonne .'=\\\'\'. '.
                            ($this->base == 'oracle' ? 'protegeChaineOracle':'protegeChaine').
                            '($this->get'. ucfirst($v['VAR']) .'()) .\'\\\' \'.'."\n";
            }
        }
        $ch .= $where;
        $ch .= "\t"."\t".'       \'\';'."\n";
        
        $ch .= "\t"."\t".'$res = executeReq($this->db, $req);'."\n";
        $ch .= "\t"."\t".'return $res;'."\n";
        $ch .= "\t".'}'."\n";
        // Fin Delete
        
        // Select
        $ch .= "\n\t".'/** '."\n".
                "\t".' * R�cup�re 1 seul �l�ment correspondant � une ligne de la table'."\n".
                "\t".' * @param Array $where tableau index� contenant la clause where de la requete<br>'."\n";
        foreach($table as $colonne => $v)
        {
            $ch .= "\t".' * Exemple: $where = array(\''. $colonne .'\' => \'4\')'."\n".
                "\t".' */'."\n";
            break;
        }
        
        //$ch .= "\n\t".'// R�cup�ration d\'un �l�ment'."\n";
        $ch .=  "\t".'function select($where = array())'."\n".
                "\t".'{'."\n";
        
        $ch .=  "\t"."\t".'$req = \'SELECT ';
        
        $chSelect = '';
        foreach($table as $colonne => $v)
        {
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= $colonne;
        }
        $ch .= $chSelect .' \'.'."\n";
        $ch .= "\t"."\t".'       \'FROM '. $tableName .' \';'."\n";
        
        $ch .= "\t"."\t".'$chWhere = \'\';'."\n";
        $ch .= "\t"."\t".'foreach($where as $k => $v)'."\n";
        $ch .= "\t"."\t".'{'."\n";
        $ch .= "\t"."\t"."\t".'if ($chWhere != \'\')'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chWhere .= \'AND \';'."\n";
        $ch .= "\t"."\t"."\t".'else'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chWhere .= \'WHERE \';'."\n";
        $ch .=  "\t"."\t"."\t".'$chWhere .= $k .\'=\\\'\'. '.
                ($this->base == 'oracle' ? 'protegeChaineOracle':'protegeChaine').
                '($v) .\'\\\' \';'."\n";
        $ch .= "\t"."\t".'}'."\n";
        $ch .= "\t"."\t".'$req .= $chWhere;'."\n";
        
        $ch .= "\t"."\t".'$res = executeReq($this->db, $req);'."\n";
        
        $ch .= "\t"."\t".'while(list(';
        $chSelect = '';
        foreach($table as $colonne => $v)
        {
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= '$'. $colonne;
        }
        $ch .= $chSelect .') = $res->fetchRow())'."\n";
        $ch .= "\t"."\t".'{'."\n";
        foreach($table as $colonne => $v)
        {
            $ch .= "\t"."\t"."\t".'$this->set'. ucfirst($v['VAR']) .'($'. $colonne .');'."\n";
        }
        $ch .= "\t"."\t".'}'."\n";
        
        $ch .= "\t".'}'."\n";
        
        // Fin Select
        
        
        // Fonction Help qui permet d'avoir la liste des m�thodes
        $ch .= "\n\t".'/** '."\n".
            "\t".' * Fonction qui affiche la liste des m�thodes de la classe '.$this->getNameForClass($tableName)."\n".
            "\t".' */'."\n";
        $ch .=  "\t".'function help()'."\n".
                "\t".'{'."\n".
                "\t"."\t".'$tab = get_class_methods($this);'."\n".
                "\t"."\t".'echo \'<br>Liste des fonctions de la classe <b>'.$this->getNameForClass($tableName).'</b> : <br>\';'."\n".
                "\t"."\t".'foreach($tab as $methodeName)'."\n".
                "\t"."\t".'{'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'set\', \'<font color=red>set</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'get\', \'<font color=green>get</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'select\', \'<font color=#E45000>select</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'update\', \'<font color=#E45000>update</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'delete\', \'<font color=#E45000>delete</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'insert\', \'<font color=#E45000>insert</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'echo \'function \'. $methodeName.\'(...)<br>\';'."\n".
                "\t"."\t".'}'."\n".
                "\t".'}'."\n";
        // fin fonction Help
        
        $ch .=  '}'."\n"."\n";
        $ch .=  '?>';
        return $ch;
    }
    
    function getAllChampsForTableName($tableName)
    {
        // R�cup�ration des colonnes de la table
        if ($this->base == 'mysql')
            $req = 'show fields from '. $tableName;
        else
            $req =  'select column_name, data_type, nullable, nullable, data_default, data_length '.
                    'from user_tab_columns '.
                    'where TABLE_NAME=\''. $tableName .'\' order by column_id';
//        if ($tableName == 'ERP_ERP')
//            echo $req;
        $res = executeReq($this->db, $req);
        $table = array();
        $primaryKey = array();
        while(list($field, $type, $null, $key, $default, $extra) = $res->fetchRow())
        {
            if ($type == 'SDO_GEOMETRY')
                continue;
            if ($type == 'ST_GEOMETRY')
                continue;
            if ($this->base == 'oracle')
            {
                
//                select user_constraints.constraint_name,user_cons_columns.column_name, user_constraints.constraint_type
//                from user_constraints, user_cons_columns
//                where user_constraints.OWNER=user_cons_columns.OWNER
//                and user_constraints.CONSTRAINT_NAME=user_cons_columns.CONSTRAINT_NAME
//                and user_constraints.TABLE_NAME=user_cons_columns.TABLE_NAME
//                and user_constraints.constraint_type='P'
//                and user_constraints.TABLE_NAME='ERP_ERP'
//                and user_cons_columns.column_name='ID_NATURE'
//                
//                select user_constraints.constraint_name, user_constraints.constraint_type
//                from user_constraints
//                where TABLE_NAME='ERP_ERP'

                
                $req2 = 'select user_constraints.constraint_name,user_cons_columns.column_name, user_constraints.constraint_type '.
                        'from user_constraints, user_cons_columns '.
                        'where user_constraints.OWNER=user_cons_columns.OWNER '.
                        'and user_constraints.CONSTRAINT_NAME=user_cons_columns.CONSTRAINT_NAME '.
                        'and user_constraints.TABLE_NAME=user_cons_columns.TABLE_NAME '.
                        'and user_constraints.constraint_type=\'P\' '.
                        'and user_constraints.TABLE_NAME=\''. $tableName .'\' '.
                        'and user_cons_columns.column_name=\''. $field .'\' ';
                
//                if ($tableName == 'ERP_ERP')
//                    echo $req2;
                $res2 = executeReq($this->db, $req2);
                $key = '';
                while(list($constraint_name, $column_name, $constraint_type) = $res2->fetchRow())
                {
                    //if ($constraint_type)
//                    echo "[$constraint_name, $column_name, $constraint_type] ";
                    $key = 'PRI';
                    //print_r($constraint_name.$column_name.$constraint_type);
                }
            }
            $table[$field] = array(
                                    'FIELD' => $field,
                                    'TYPE' => $type,
                                    'NULL' => ($null == 'Y' ? 'YES':'NO'),
                                    'KEY' => $key,
                                    'DEFAULT' => $default,
                                    'EXTRA' => $extra,
                                    'VAR' => $this->getNameForColonne($field)
                                   );
            if ($key == 'PRI')
                $primaryKey[] = $field;
        }
//        print_jc($table);
        return array($table, $primaryKey);
    }
    
    function getClassForListeObjet($tableName)
    {
        $table = array();
        $ch =   '<?php'."\n"."\n".
                '/** '."\n".
                ' * Classe repr�sentant une liste d\'objet de type '. $this->getNameForClass($tableName) ."\n".
                ' * @version '. $this->version ."\n".
                ' */'."\n";
//        $ch =   '<?php'."\n"."\n".
//                '/** '."\n".
//                ' * NE PAS MODIFIER, Fichier g�n�r� automatiquement par class_objet_bdd. '."\n".
//                ' * Ce fichier repr�sente plusieurs objet de la class `'. $this->getNameForClass($tableName) .'`.'."\n".
//                ' */'."\n"."\n";

        $ch .=  'class '. $this->getNameForClass('liste_'.$tableName) ."\n".
                '{'."\n";
        
        $ch .= "\t".'var $db;'."\n";
        $ch .= "\t".'var $nb = 0;'."\n";
        $ch .= "\t".'var $liste = array();'."\n";
        
        list($table, $primaryKey) = $this->getAllChampsForTableName($tableName);
        
//        // R�cup�ration des colonnes de la table
//        if ($this->base == 'mysql')
//            $req = 'show fields from '. $tableName;
//        else
//            $req =  'select column_name, data_type, data_length, data_precision, nullable, data_default '.
//                    'from user_tab_columns '.
//                    'where TABLE_NAME=\''. $tableName .'\' order by column_id';
//
//        $res = executeReq($this->db, $req);
//        while(list($field, $type, $null, $key, $default, $extra) = $res->fetchRow())
//        {
//            $table[$field] = array(
//                                    'FIELD' => $field,
//                                    'TYPE' => $type,
//                                    'NULL' => $null,
//                                    'KEY' => $key,
//                                    'DEFAULT' => $default,
//                                    'EXTRA' => $extra,
//                                    'VAR' => $this->getNameForColonne($field)
//                                   );
//        }

        // Fonction qui ajoute un objet dans la liste
        $ch .= "\n\t".'// Fonction qui ajoute un objet dans la liste'."\n";
        $ch .=  "\t".'function add($v)'."\n".
                "\t".'{'."\n".
                "\t"."\t".'$this->liste[] = $v;'."\n".
                "\t".'}'."\n";
        
        // Fonction qui renvoie un objet de la liste
        $ch .= "\n\t".'// Fonction qui renvoie un objet de la liste'."\n";
        $ch .=  "\t".'function get($i)'."\n".
                "\t".'{'."\n".
                "\t"."\t".'return $this->liste[$i];'."\n".
                "\t".'}'."\n";
        
        // Fonction qui renvoie le nombre d'objet dans la liste
        $ch .= "\n\t".'// Fonction qui renvoie le nombre d\'objet dans la liste'."\n";
        $ch .=  "\t".'function size()'."\n".
                "\t".'{'."\n".
                "\t"."\t".'return $this->nb;'."\n".
                "\t".'}'."\n";
        
        // D�claration du constructeur
        $ch .= "\n\t".'// constructeur'."\n";
        $ch .=  "\t".'function '. $this->getNameForClass('liste_'.$tableName) .'($db)'."\n".
                "\t".'{'."\n".
                "\t"."\t".'return $this->db = $db;'."\n".
                //"\t"."\t".'return $this->liste = array();'."\n".
                //"\t"."\t".'if (count($where) > 0)'."\n".
                //"\t"."\t"."\t".'$this->select($where);'."\n".
                "\t".'}'."\n";
        
        // Select
        $ch .= "\n\t".'// R�cup�ration de plusieurs objet'."\n";
        $ch .=  "\t".'function select($where = array(), $orderBy = array())'."\n".
                "\t".'{'."\n";
        
        $ch .=  "\t"."\t".'$req = \'SELECT ';
        
        $chSelect = '';
        foreach($table as $colonne => $v)
        {
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= $colonne;
        }
        $ch .= $chSelect .' \'.'."\n";
        $ch .= "\t"."\t".'       \'FROM '. $tableName .' \';'."\n";
        
        $ch .= "\t\t".'if (is_array($where))'."\n";
        $ch .= "\t\t".'{'."\n";
        
        // WHERE
        $ch .= "\t"."\t"."\t".'$chWhere = \'\';'."\n";
        $ch .= "\t"."\t"."\t".'foreach($where as $k => $v)'."\n";
        $ch .= "\t"."\t"."\t".'{'."\n";
        $ch .= "\t"."\t"."\t"."\t".'if ($chWhere != \'\')'."\n";
        $ch .= "\t"."\t"."\t"."\t"."\t".'$chWhere .= \'AND \';'."\n";
        $ch .= "\t"."\t"."\t"."\t".'else'."\n";
        $ch .= "\t"."\t"."\t"."\t"."\t".'$chWhere .= \'WHERE \';'."\n";
        $ch .=  "\t"."\t"."\t"."\t".'$chWhere .= $k .\'=\\\'\'. '.
                ($this->base == 'oracle' ? 'protegeChaineOracle':'protegeChaine').
                '($v) .\'\\\' \';'."\n";
        $ch .= "\t"."\t"."\t".'}'."\n";
        $ch .= "\t"."\t"."\t".'$req .= $chWhere;'."\n";
        
        $ch .= "\t\t".'}'."\n";
        $ch .= "\t\t".'else'."\n";
        $ch .= "\t\t".'{'."\n";
        $ch .= "\t"."\t"."\t".'$req .= $where;'."\n";
        $ch .= "\t\t".'}'."\n";
        // ORDER BY
        $ch .= "\t"."\t".'$chOrderBy = \'\';'."\n";
        $ch .= "\t"."\t".'foreach($orderBy as $k => $v)'."\n";
        $ch .= "\t"."\t".'{'."\n";
        $ch .= "\t"."\t"."\t".'if ($chOrderBy != \'\')'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chOrderBy .= \', \';'."\n";
        $ch .= "\t"."\t"."\t".'else'."\n";
        $ch .= "\t"."\t"."\t"."\t".'$chOrderBy .= \'ORDER BY \';'."\n";
        $ch .= "\t"."\t"."\t".'$chOrderBy .= $k .\' \'. $v .\' \';'."\n";
        $ch .= "\t"."\t".'}'."\n";
        $ch .= "\t"."\t".'$req .= $chOrderBy;'."\n";
        
        $ch .= "\t"."\t".'$res = executeReq($this->db, $req);'."\n";
        
        $ch .= "\t"."\t".'while(list(';
        $chSelect = '';
        foreach($table as $colonne => $v)
        {
            if ($chSelect != '')
                $chSelect .= ', ';
            $chSelect .= '$'. $colonne;
        }
        $ch .= $chSelect .') = $res->fetchRow())'."\n";
        $ch .= "\t"."\t".'{'."\n";
        $ch .= "\t"."\t"."\t".'$obj = new '. $this->getNameForClass($tableName) .'($this->db);'."\n";
        
        foreach($table as $colonne => $v)
        {
            $ch .= "\t"."\t"."\t".'$obj->set'. ucfirst($v['VAR']) .'($'. $colonne .');'."\n";
        }
        $ch .= "\t"."\t"."\t".'$this->add($obj);'."\n";
        
        $ch .= "\t"."\t".'}'."\n";
        $ch .= "\t"."\t".'$this->nb = count($this->liste);'."\n";
        $ch .= "\t".'}'."\n";
        
        // Fin Select
        
        // Fonction Help qui permet d'avoir la liste des m�thodes
        $ch .= "\n\t".'/** '."\n".
            "\t".' * Fonction qui affiche la liste des m�thodes de la classe '.$this->getNameForClass('liste_'.$tableName)."\n".
            "\t".' */'."\n";
        $ch .=  "\t".'function help()'."\n".
                "\t".'{'."\n".
                "\t"."\t".'$tab = get_class_methods($this);'."\n".
                "\t"."\t".'echo \'<br>Liste des fonctions de la classe <b>'.$this->getNameForClass('liste_'.$tableName).'</b> : <br>\';'."\n".
                "\t"."\t".'foreach($tab as $methodeName)'."\n".
                "\t"."\t".'{'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'set\', \'<font color=red>set</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'get\', \'<font color=green>get</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'select\', \'<font color=#E45000>select</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'update\', \'<font color=#E45000>update</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'delete\', \'<font color=#E45000>delete</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'$methodeName = str_replace(\'insert\', \'<font color=#E45000>insert</font>\', $methodeName);'."\n".
                "\t"."\t"."\t".'echo \'function \'. $methodeName.\'(...)<br>\';'."\n".
                "\t"."\t".'}'."\n".
                "\t".'}'."\n";
        // fin fonction Help
        
        $ch .=  '}'."\n"."\n";
        $ch .=  '?>';
        return $ch;
    }
}

?>