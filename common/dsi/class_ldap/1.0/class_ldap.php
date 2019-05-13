<?php
class Ldap
{
    var $serveurLdap    = array('ldaps://10.128.4.42','ldaps://10.128.4.4');
    var $listServeurLdap = '';
    var $db             = false; // Variable de connexion à la base ldap
    var $options = array(
                            'LDAP_OPT_PROTOCOL_VERSION' => 3
                         );
    var $lastRequete = '';
    var $lastFiltre = '';
    var $chaineLogin = ''; // chaine de connexion (nom d'utilisateur ou url complete LDAP)
    var $password = ''; // mot de passe de l'utilisateur
    var $logicielId = ''; // identifiant du logiciel auquel l'utilisateur souhaite accéder
    var $errorMessage = ''; // message d'erreur
    var $userInfo = array();
    var $agentLoginListe = ''; // liste des agents dans le cas où il y a plusieurs choix
    var $isMultipleChoix = false;
    
    function __construct($chaineLogin, $password, $logicielId)
    {
        $this->Ldap($chaineLogin, $password, $logicielId);
    }

    function Ldap($chaineLogin, $password, $logicielId)
    {
        $this->chaineLogin      = strtolower($chaineLogin);
        $this->password         = $password;
        $this->logicielId       = $logicielId;
        $this->errorMessage     = '';
        $this->isChoixMultiple  = false;
        $this->connect();
        $this->setOption();
    }
    
    function getErrorMessage()
    {
        return $this->errorMessage;
    }
    
    function connecteAgent()
    {
        global $PROJET_ID, $dbLog;
        $result = $this->doConnexion();
        if (isset($dbLog))
        {
            $ip = '';
            if (isset($_SERVER['REMOTE_ADDR']))
                $ip = substr($_SERVER['REMOTE_ADDR'], 0, 20);
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ip = substr($_SERVER['HTTP_X_FORWARDED_FOR'], 0, 20);
            $req =  'insert into connexion '.
                    '(projet_id, connexion_user, connexion_password, connexion_cle, connexion_date, connexion_ok, connexion_user_url_ldap, connexion_ip) '.
                    'values ('.
                    $PROJET_ID.', '.
                    '\''.protegeChaine($this->chaineLogin).'\', '.
                    '\''.protegeChaine(codeStr('jclefouducommonahahah', $this->password)).'\', '.
                    '\''.protegeChaine($this->logicielId).'\', '.
                    time().', '.
                    ($result ? '1':'0').', '.
                    ($result ? '\''.protegeChaine($this->userInfo['domain_name']).'\',':'NULL,').
                    '\''.protegeChaine($ip).'\''.
                    ')';
            executeReq($dbLog, $req);
        }
        return $result;
    }
    
    function doConnexion()
    {
//        $this->errorMessage =   'Impossible de contacter le<br>serveur d\'authentification via LDAPS ('.$this->serveurLdap.') depuis le serveur <strong>'.SERVEUR_PROD.'</strong> !<br><br>'.
//                                            'Veuillez contacter le Service Réseau au <strong>90.44</strong><br>en indiquant ce message d\'erreur !<br><br>'.
//                                            'Merci.';
//                return false;
        // Vérification si l'on a un user ou une url LDAP
        if (strtolower(substr($this->chaineLogin, 0, 3)) == 'cn=')
        {
            // on est en présence d'une url;
            $tAgent = array();
            $tAgent[] = array('domain_name' => $this->chaineLogin);
        }
        else
        {
            // Récupération de tous les agents avec ce login
            $tAgent = $this->getAllUserWithThisLoginName($this->chaineLogin);
        }
        
        if (count($tAgent) == 1) // on a un seul agent
        {
            // construction de l'url ldap de l'agent
            $ldapUrl = strtolower($tAgent[0]['domain_name']);
            
            if ($this->isPasswordCorrect($ldapUrl, $this->password) == true) // Le mot de passe est bon
            {
                // Récupération des infos sur l'utilisateur
                $t = $this->recherche($ldapUrl, 'objectclass=user');
                list($agent) = $this->getAgentFromLdapEntry($t);
                $this->userInfo = $agent;
                $this->disconnect();
                
                // Vérification si l'utilisateur a le droit d'accéder au logiciel en question
                if ($this->logicielId == 'NO_KEY' || in_array($this->logicielId, $this->userInfo['description']))
                {
                    // 'NO_KEY' => pas de clé, donc on teste juste si l'utilisateur a tapé le bon login / password
                    return true; // l'utilisateur a le droit d'accéder au logiciel
                }
                else // L'utilisateur n'a pas le droit d'accéder à ce logiciel
                {
                    $this->errorMessage =   'Désolé, Vous n\'êtes pas autorisé à utiliser ce logiciel!<br>'.
                                            'Veuillez contacter le Service Informatique!<br>Merci.';
                    return false;
                }
            }
            else // mot de passe incorrect
            {
                // Vérification si le compte n'est pas vérouillé
                $t = $this->recherche($ldapUrl, 'objectclass=user');
                $agent = array();
                list($agent) = $this->getAgentFromLdapEntry($t);
                if (isset($agent['compte_verouille']) && $agent['compte_verouille'] == 'yes')
                    $this->errorMessage =   'Ce compte est verrouillé suite à plusieurs tentatives de connexion!<br>'.
                                            'Veuillez contacter le Service Informatique au <strong>94.42</strong> en indiquant que votre <strong>compte est verrouillé</strong>!<br>'.
                                            'Merci.';
                else
                    $this->errorMessage =   'Mot de passe (associé au compte Novell) incorrect !!';
                $this->disconnect();
                return false;
            }
        }
        else 
        {
            if (count($tAgent) == 0) // Aucun agent n'a été trouvé
            {
                // on n'a pas trouvé d'agent...
                // on vérifie si le probleme vient du serveur (serveur injoignable) ou si l'agent n'est vraiment pas trouvé dans la base LDAP
                $tAgentTest = $this->getAllUserWithThisLoginName('marinjc');
                
                if (count($tAgentTest) == 1)
                    $this->errorMessage =   'Agent introuvable, vérifiez votre nom d\'utilisateur!';
                else // si marinjc n'est pas trouvé, cela veut dire que le serveur n'est pas joignable.
                    $this->errorMessage =   'Impossible de contacter les<br>serveurs d\'authentification via LDAPS ('.$this->listServeurLdap.') depuis le serveur <strong>'.SERVEUR_PROD.'</strong> !<br><br>'.
                                            'Veuillez contacter l\'informatique au <strong>94.42</strong><br>en indiquant ce message d\'erreur !<br><br>'.
                                            'Merci.';
                return false;
            }
            else // plusieurs agents correspondent au nom d'utilisateur tapé
            {
                $this->isChoixMultiple = true;
                $this->errorMessage =   'Veuillez sélectionner votre profil ci dessus!<br>';
                $this->agentLoginListe = '<select name="agent_login">';
                foreach($tAgent as $v)
                {
                    $this->agentLoginListe .= '<option value="'.$v['domain_name'].'">'.$v['nom_prenom'].'</option>';
                }
                $this->agentLoginListe .= '</select>';
                return false;
            }
        }
        
        return true;
    }
    function getAgentLoginListe()
    {
        return $this->agentLoginListe;
    }
    
    function connect()
    {
        if (!$this->isConnected()){
            $this->listServeurLdap = '';
            //$this->db = ldap_connect ($this->serveurLdap);
            $ServeurOK = 0;
            foreach($this->serveurLdap as $s){
                $this->listServeurLdap .= ($this->listServeurLdap == '' ? '' : ', ') . $s; //Mesage en cas d'échec de tous les serveurs
                if($ServeurOK == 0){
                    $this->db = ldap_connect ($s);
                    if ($this->db){
                        //on verifie si l'annuaire LDAP est bien accessible
                        $tAgentTest = $this->getAllUserWithThisLoginName('marinjc');
                        if(count($tAgentTest) == 1){//Annuaire LDAP OK
                            $ServeurOK = 1;
                        }
                    }
                }
            }
        }
    }
    
    function isConnected()
    {
        if ($this->db)
            return true;
        else
            return false;
    }
    
    function setOption()
    {
        if ($this->isConnected())
        {
            foreach ($this->options as $k => $v)
            {
                @ldap_set_option ($this->db, $k, $v);
            }
        }
    }
    
    function recherche($base_dn = '', $filter = '')
    {
        $tab = array();
        $this->lastRequete = $base_dn;
        $this->lastFiltre = $filter;
        $res = @ldap_search($this->db, $base_dn, $filter);
        $tab = @ldap_get_entries ($this->db, $res);
        return $tab;
    }
    
    /**
     * Récupère le tableau brut de pomme provenant de LDAP
     * et le transforme en un tableau normal et compréhensible
     */
    function getAgentFromLdapEntry($ldapEntry = array())
    {
        $tab = array();
        if (gettype($ldapEntry) == 'array')
        {
            foreach($ldapEntry as $k => $v)
            {
                if (is_array($v) && count($v) > 1)
                {
                    $tab[] = array(
                                    'domain_name'           => isset($v["dn"]) ? $v["dn"]:'',
                                    'compte_verouille'      => isset($v['lockedbyintruder']) && $v['lockedbyintruder'][0] == 'TRUE' ? 'yes':'no',
                                    'login'                 => isset($v["cn"]) ? $this->getElement($v["cn"], 'string'):'',
                                    'nom'                   => isset($v["sn"]) ? $this->getElement($v["sn"], 'string'):'',
                                    'prenom'                => isset($v["givenname"]) ? $this->getElement($v["givenname"], 'string'):'',
                                    'nom_prenom'             => isset($v["fullname"]) ? $this->getElement($v["fullname"], 'string'):'',
                                    //'matricule'             => isset($v["generationqualifier"][0]) ? $v["generationqualifier"][0]:'',
                                    'matricule'             => isset($v["generationqualifier"]) ? $this->getElement($v["generationqualifier"], 'string'):'',
                                    'telephone'             => isset($v["telephonenumber"]) ? $this->getElement($v["telephonenumber"]):array(),
                                    'email'                 => isset($v["mail"]) ? $this->getElement($v["mail"]):'',
                                    //'groupe_member_ship'    => isset($v["groupmembership"]) ? $v["groupmembership"]:array(),
                                    'groupe_member_ship'    => isset($v['groupmembership']) ? $this->getElement($v["groupmembership"]):array(),
                                    'description'           => isset($v['description']) ? $this->getElement($v['description']):array(),
                                    'uid'                   => isset($v['uid']) ? $this->getElement($v['uid']):array(),
                                    'password_expiration'   => isset($v["passwordexpirationtime"]) ? $this->convertDateToSec($this->getElement($v["passwordexpirationtime"])):'',
                                    'password_interval'     => isset($v["passwordexpirationinterval"]) ? $this->convertSecToPeriode($this->getElement($v["passwordexpirationinterval"], 'string')):'',
                                    'login_max_simultaneous' => isset($v["loginmaximumsimultaneous"]) ? $this->getElement($v["loginmaximumsimultaneous"], 'string'):'0',
                                    'login_grace_remaining' => isset($v["logingraceremaining"]) ? $this->getElement($v["logingraceremaining"], 'string'):'',
                                    'login_grace_limit' => isset($v["logingracelimit"]) ? $this->getElement($v["logingracelimit"], 'string'):'',
                                    
                                    'adresse_ip'            => isset($v['networkaddress']) ? $this->getElement($v['networkaddress'], 'adresse_ip'):array(),
                                   );
                }
                $k = '';
            }
        }
        return $tab;
    }
    
    function decodeNetworkAdress($networkAdress)
    {
        $addy = $networkAdress;//info[$i]["networkaddress"][$j];
        $bit = 0;
        $theip = "";
        for ( $k = 2; $k < 6; $k++ )
        {
              $theip = $theip.($bit ? "." : "") . ord(substr($addy, $k, 1));
              $bit = 1;
        }
        return $theip;
    }
    
    function getElement($tabFromLdap, $format = 'array')
    {
        $tab = array();
        if (isset($tabFromLdap['count']) && $tabFromLdap['count'] > 0)
        {
            for($i=0; $i < $tabFromLdap['count']; $i++)
            {
                if ($format == 'adresse_ip')
                    $tab[] = $this->decodeNetworkAdress(utf8_decode($tabFromLdap[$i]));
                else
                    $tab[] = utf8_decode($tabFromLdap[$i]);
            }
        }
        
        if ($format == 'string' && count($tab) == 1)
            $tab = $tab[0];

        return $tab;
    }
    
    function convertDateToSec($chDate) // 20070321094632Z
    {
        $chDate = trim($chDate[0]);
        //echo $chDate;
        $now = time();
        $annee = substr($chDate,0,4);
        $mois = substr($chDate,4,2);
        $jour = substr($chDate,6,2);
        $heure = substr($chDate,8,2) + 1; // car l'heure retarde d'une heure
        $min = substr($chDate,10,2);
        $sec = substr($chDate,12,2);
        $passwordSec = mktime ($heure, $min, $sec, $mois, $jour, $annee);
        
        $difference = $passwordSec - $now;
        
        // Ajout
        $ch = '';
        $mois = intval($difference/(86400*30));
        $jour = intval(($difference - ($mois*86400*30))/86400);
        $heure = intval(($difference - ($mois*86400*30) - ($jour*86400))/3600);
        $min = intval(($difference - ($mois*86400*30) - ($jour*86400) - ($heure*3600))/60);

        //$ch = '['.$difference.']';
        if ($mois > 0)      $ch .= $mois.' mois, ';
        //if ($ch != '')      $ch .= ', ';
        if ($jour > 0)      $ch .= $jour.' jour'.($jour > 1 ? 's':'').', ';
        //if ($ch != '')      $ch .= ' et ';
        if ($heure > 0)     $ch .= $heure.' heure'.($heure > 1 ? 's':'').' et ';
        if ($min > 0)     $ch .= $min.' minute'.($min > 1 ? 's':'');
//        if ($ch == '')      $ch = $chDate.'#'.$annee.'#'.$mois.'#'.$jour.'#'.$heure.'#'.$min.'#'.$sec.'#'.$difference;
//        if ($ch == '')      $ch = $chDate.'#'.date('YmdHis', $passwordSec).'#'.$difference;
        return $ch;
        return $difference;
    }

    function convertSecToPeriode($difference) // 7776000
    {
        //$difference = $passwordSec - $now;
        
        // Ajout
        $ch = '';
        $mois = intval($difference/(86400*30));
        $jour = intval(($difference - ($mois*86400*30))/86400);
        $heure = intval(($difference - ($mois*86400*30) - ($jour*86400))/3600);
        $min = intval(($difference - ($mois*86400*30) - ($jour*86400) - ($heure*3600))/60);

        //$ch = '['.$difference.']';
        if ($mois > 0)      $ch .= $mois.' mois';
        if ($jour > 0 || $heure > 0 || $min > 0)
            $ch .= ', ';
        if ($jour > 0)      $ch .= $jour.' jour'.($jour > 1 ? 's':'').', ';
        //if ($ch != '')      $ch .= ' et ';
        if ($heure > 0)     $ch .= $heure.' heure'.($heure > 1 ? 's':'').' et ';
        if ($min > 0)     $ch .= $min.' minute'.($min > 1 ? 's':'');
//        if ($ch == '')      $ch = $chDate.'#'.$annee.'#'.$mois.'#'.$jour.'#'.$heure.'#'.$min.'#'.$sec.'#'.$difference;
//        if ($ch == '')      $ch = $chDate.'#'.date('YmdHis', $passwordSec).'#'.$difference;
        return $ch;
    }
    
    
    /**
     * Renvoie un tableau contentant pour les utilisateurs ayant $loginName comme nom d'utilisateur
     * Non sensible à la casse
     */
    function getAllUserWithThisLoginName($loginName)
    {
        $t = array();
        $t = $this->recherche('o=aix', 'cn='.$loginName);
        $t = $this->getAgentFromLdapEntry($t);
        return $t;
    }
    
    function getXML($tab)
    {
        $serializer_options = array (
                                       'addDecl' => TRUE,
                                       'encoding' => 'ISO-8859-15',
                                       'indent' => '    ',
                                       'rootName' => 'ldap_result',
                                       'defaultTagName' => 'item',
                                    );
        $Serializer = new XML_Serializer($serializer_options); 
        $status = $Serializer->serialize(array(
                                                'requete' => $this->lastRequete,
                                                'filtre' => $this->lastFiltre,
                                                'results' => $tab,
                                                )
                                        );
        if (PEAR::isError($status))
        {
            die($status->getMessage());
        } 

        return $Serializer->getSerializedData();
    }
    
    /**
     * Renvoi TRUE si le password correspond à l'utilisateur
     * sinon renvoi FALSE
     */
    function isPasswordCorrect($base_dn = '', $password = '')
    {
        $res = @ldap_bind($this->db, $base_dn, $password);
        return $res;
    }
    
    /**
     * Déconnecte de la session LDAP
     */
    function disconnect()
    {
        if ($this->isConnected())
            $this->db = ldap_unbind ($this->db);
    }
}
?>