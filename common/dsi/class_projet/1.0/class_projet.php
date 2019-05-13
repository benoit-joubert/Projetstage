<?php
class GestionProjet
{
    var $serveurProjet  = SDELPHINUS_IP;
    var $serveurUser    = 'stats';
    var $serveurPass    = 'stats_password';
    var $serveurName    = 'stats_projets';
    var $serveurType    = 'mysql';
    var $db             = false; // Variable de connexion à la base des projets
    var $ticket_login   = '';
    var $ticket_password= '';
    var $ticket_action  = '';
    
    function __construct()
    {
        $this->GestionProjet();
    }

    function GestionProjet()
    {
        if (SERVEUR_PROD == 'EADM' || SERVEUR_PROD == 'EADM-SECURE')
            $this->serveurProjet = EADMBD_IP;
    }
    
    
    function connexion()
    {
        $dsn	= $this->serveurType . '://' . $this->serveurUser . ':' . $this->serveurPass . '@' . $this->serveurProjet . '/' . $this->serveurName;
    
    	$db 	= DB::connect($dsn, array('debug'=>true));
        
    	if (!DB::isError($db))
    	{
    	    $this->db = $db;
    	}
    	else
    	{
    	    echo 'Erreur lors de la connexion à la base des projets.';
    	}
    }
    
    function deconnexion()
    {
        if ($this->db !== false)
        {
            $this->db->disconnect();
        }
    }
    
    function isConnected()
    {
        return ($this->db !== false);
    }
    
    function getConnexion()
    {
        return $this->db;
    }
    
    function createTicketForApplication($login, $password, $action)
    {
        global $PROJET_ID;
        
        // Si l'on est pas connecté au projet, on se connecte
        if (!$this->isConnected())
            $this->connexion();
        $sessionId = session_id();
        $time = time();
        $ip = substr($_SERVER['REMOTE_ADDR'], 0, 20);
        
        $req =  'insert into ticket (ticket_session, ticket_time, ticket_login, ticket_password, ticket_action, ticket_ip, projet_id) values ('.
                '\''.$sessionId.'\', '.
                $time.', '.
                '\''.$login.'\', '.
                '\''.codeStr('jclefouducommonahahah', $password).'\', '.
                '\''.$action.'\', '.
                '\''.$ip.'\', '.
                '\''.$PROJET_ID.'\' '.
                ')';
        executeReq($this->db, $req);
        $ticketId = mysql_insert_id($this->db->connection);
        return '?action=CONNECT&i='.$ticketId.'&ticket='.md5($sessionId.'_'.$time.'_'.$login.'_'.$password);
    }
    
    function isTicketCorrect($ticketId, $ticketMd5)
    {
        $ticketOk = false;
        if (!$this->isConnected())
            $this->connexion();
        $this->deleteNotValidTicket(); // Effacement des vieux tickets
        
        $req =  'select ticket_id, ticket_session, ticket_time, ticket_login, ticket_password, ticket_action '.
                'from ticket '.
                'where ticket_id=\''.protegeChaine($ticketId).'\' ';
        $res = executeReq($this->db, $req);
        list($ticket_id, $ticket_session, $ticket_time, $ticket_login, $ticket_password, $ticket_action) = $res->fetchRow();
        $correctMd5 = md5($ticket_session.'_'.$ticket_time.'_'.$ticket_login.'_'.decodeStr('jclefouducommonahahah',$ticket_password));
        
        if ($ticketMd5 != '' && $ticketMd5 == $correctMd5)
        {
            $ticketOk = true;
            $this->ticket_login = $ticket_login;
            $this->ticket_password = decodeStr('jclefouducommonahahah',$ticket_password);
            $this->ticket_action = $ticket_action;
        }

        return $ticketOk;
    }
    
    function getTicketLogin()
    {
        return $this->ticket_login;
    }
    
    function getTicketPassword()
    {
        return $this->ticket_password;
    }
    
    function getTicketAction()
    {
        return $this->ticket_action;
    }
    
    function deleteTicket($ticketId)
    {
        // Si l'on est pas connecté au projet, on se connecte
        if (!$this->isConnected())
            $this->connexion();
        
        $req = 'delete from ticket where ticket_id=\''.protegeChaine($ticketId).'\'';
        executeReq($this->db, $req);
        
    }
    
    function getNbVisiteurForProjetId($projetId, $periode = '')
    {
        // Nb de min pour compter le nombre de personne présente sur le site
        $nbMinute = 30;
        
        $nb = 0;
        $req =  'select count(distinct stats_ip) '.
                'from stats '.
                'where projet_id='.$projetId.' ';
        
        if ($periode == 'today') // ceux qui sont venus aujourd'hui
        {
            $minuit = mktime (0, 0, 0, date('m'), date('d'), date('Y')); // Aujourd'hui à minuit
            $req .= 'and stats_time>'.$minuit;
        }
        else // les derniers
        {
            $req .= 'and stats_time>'.(time()-60*$nbMinute);
        }
        $res = executeReq($this->db, $req);
        list($nb) = $res->fetchRow();
        return $nb;
    }
    
    function getUserOrIpConnectedOnApplication($projetId, $periode = '')
    {
        // Nb de min pour compter le nombre de personne présente sur le site
        $nbMinute = 30;
        
        $req =  'select stats_ip, max(stats_time) '.
                'from stats '.
                'where projet_id='.$projetId.' ';
                //'and'
        if ($periode == 'today') // ceux qui sont venus aujourd'hui
        {
            $minuit = mktime (0, 0, 0, date('m'), date('d'), date('Y')); // Aujourd'hui à minuit
            $req .= 'and stats_time>'.$minuit;
        }
        else // les derniers
        {
            $req .= 'and stats_time>'.(time()-60*$nbMinute);
        }
        $req .= ' group by 1 '.
                'order by 2 desc';
        //echo $req;
        $res = executeReq($this->db, $req);
        $tab = array();
        $in = '(';
        while(list($ip, $temps) = $res->fetchRow())
        {
            $tab[$ip] = array(
                            'IP' => $ip,
                            'USER' => '',
                            'DATE' => $temps,
                           );
            if ($in != '(')
                $in .= ',';
            $in .= '\''. $ip .'\'';
        }
        $in .= ')';
        
        $nbTrouve = 0;
        if ($in != '()')
        {
            // on cherche les noms d'utilisateur dans la table de connexion
            $req =  'select distinct connexion_user, connexion_ip '.
                    'from connexion '.
                    'where projet_id='.$projetId.' '.
                    'and connexion_ip in '. $in .' ';
            
            $minuit = mktime (0, 0, 0, date('m'), date('d'), date('Y')); // Aujourd'hui à minuit
            $req .= 'and connexion_date>'.$minuit;
            $req .= ' and connexion_ok=1';
            $req .= ' order by connexion_date';
            $res = executeReq($this->db, $req);
            while(list($user, $ip) = $res->fetchRow())
            {
                if ($tab[$ip]['USER'] != '')
                    $tab[$ip]['USER'] .= ', ';
                $tab[$ip]['USER'] .= $user;
                $nbTrouve++;
            }
            
            // $nbTrouve = 0;
            // Si aucun utilisateur n'est trouvé dans la table de connexion,
            // ça veut dire que l'application n'utilise pas la connexion LDAP mais certainement oracle
            // on cherche donc les utilisateurs dans la table des tickets
            if ($nbTrouve == 0)
            {
                $req =  'select distinct lower(ticket_login), ticket_ip '.
                        'from ticket '.
                        'where projet_id='.$projetId.' '.
                        'and ticket_ip in '. $in .' ';
            
                $minuit = mktime (0, 0, 0, date('m'), date('d'), date('Y')); // Aujourd'hui à minuit
                $req .= 'and ticket_time>'.$minuit;
                //$req .= ' and connexion_ok=1';
                $req .= ' order by ticket_time';
                $res = executeReq($this->db, $req);
                while(list($user, $ip) = $res->fetchRow())
                {
                    if ($tab[$ip]['USER'] != '')
                        $tab[$ip]['USER'] .= ', ';
                    $tab[$ip]['USER'] .= $user;
                }
            }
        }
                
        
        return $tab;
    }
    
    function deleteNotValidTicket()
    {
        // Si l'on est pas connecté au projet, on se connecte
        if (!$this->isConnected())
            $this->connexion();
        
        // validité du ticket => 24 H => 60*60*24
        $req = 'delete from ticket where ticket_time<'.(time()-86400).'';
        executeReq($this->db, $req);
    }
}
?>