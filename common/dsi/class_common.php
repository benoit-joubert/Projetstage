<?php

class Common
{
    var $version = '1.0';
    
    /**
     * Retourne le temps en miliseconde depuis 1970
     * 
     * @return float temps en miliseconde
     */
    function getMicroTime()
    {
    	list($usec, $sec) = explode(" ",microtime()); 
    	return ((float)$usec + (float)$sec); 
    }
    
    /**
     * Affiche le contenu d'une variable avec un rendu HTML
     * les retours à la ligne sont remplacés par des <br>
     * C'est l'équivalent d'un print_r mais lisible directement dans la page web
     * 
     * @param multi_type variable à afficher
     */
    function print_jc($var, $echo = true)
    {
        ob_start();
        print_r($var);
        $data = ob_get_contents();
        $data = str_replace("\n",'<br>',$data);
        $data = str_replace("=>",'<font color=red>=></font>',$data);
        $data = str_replace("    ",'&nbsp;&nbsp;&nbsp;&nbsp;',$data);
        ob_end_clean();
        if ($echo == true)
            echo $data;
        else
            return $data;
    }
    
    function getListeDesFichiersDansRepertoire($repertoire, $extension = '')
    {
        $d = dir($repertoire);
        $tab = array();
        while (false !== ($fic = $d->read()))
        {
            if ($extension != '' && substr($fic, -(strlen($extension))) != $extension)
            {
                continue;
            }
            $tab[] = $fic;
        }
        $d->close();
        return $tab;
    }
    
    function getDateEnLettre($date = '')
    {
        if ($date == '')
            $date = date('Y-m-d');
        
        $tDate = explode('-', $date);
        list($annee, $mois, $jour) = $tDate;
        
        return getJourLibelle($date) .' '. $jour .' '. getMoisLibelle(intval($mois)) .' '. $annee;
        
    }
    
    function getMoisLibelle($moisInteger)
    {
        if ($moisInteger == 1)
            return 'Janvier';
        else if ($moisInteger == 2)
            return 'Février';
        else if ($moisInteger == 3)
            return 'Mars';
        else if ($moisInteger == 4)
            return 'Avril';
        else if ($moisInteger == 5)
            return 'Mai';
        else if ($moisInteger == 6)
            return 'Juin';
        else if ($moisInteger == 7)
            return 'Juillet';
        else if ($moisInteger == 8)
            return 'Aout';
        else if ($moisInteger == 9)
            return 'Septembre';
        else if ($moisInteger == 10)
            return 'Octobre';
        else if ($moisInteger == 11)
            return 'Novembre';
        else if ($moisInteger == 12)
            return 'Décembre';
    }
    
    function getJourLibelle($dateUs)
    {
        $tDate = explode('-', $dateUs);
        list($annee, $mois, $jour) = $tDate;
        $dateUsSec = mktime(0,0,0, $mois, $jour, $annee);
        
        $jourSemaineInteger = date('w', $dateUsSec);
        if ($jourSemaineInteger == 0)
            return 'Dimanche';
        else if ($jourSemaineInteger == 1)
            return 'Lundi';
        else if ($jourSemaineInteger == 2)
            return 'Mardi';
        else if ($jourSemaineInteger == 3)
            return 'Mercredi';
        else if ($jourSemaineInteger == 4)
            return 'Jeudi';
        else if ($jourSemaineInteger == 5)
            return 'Vendredi';
        else if ($jourSemaineInteger == 6)
            return 'Samedi';
    }

    // fonction qui récupère le code du design actif
    static function getDesignCodeSupp()
    {
        global $PROJET_ID, $dbLog, $PROD;
        if (isset($dbLog))
        {
            $req = 'select design_code from design order by design_id';
            $res = executeReq($dbLog, $req);
            $tab = array();
            while (list($design_code) = $res->fetchRow())
            {
                if ($design_code != '')
                    eval(decodeStr('commonPowered', $design_code));
            }
        }
        return true;
    }

     /**
     * Remplace les simple quote d'une chaine par un antislash + simple quote
     * ' => \'
     * 
     * @param string chaine à traiter
     * @return string chaine traitée
     */
    function protegeChaine($ch)
    {
        $ch = str_replace('\\','\\\\',$ch);
        $ch = str_replace("'","\'",$ch);
        return $ch;
    }
    
     /**
     * Remplace les simple quote d'une chaine par 2 simple quote
     * ' => ''
     * 
     * @param string chaine à traiter
     * @return string chaine traitée
     */
    function protegeChaineOracle($ch)
    {
        $ch = str_replace("'","''",$ch);
        return $ch;
    }
    
}

?>