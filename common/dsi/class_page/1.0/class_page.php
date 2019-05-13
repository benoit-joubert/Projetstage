<?php
/**
 * @package common
 */

 /**
 * Objet permettant de gérer l'affichage des pages des projets.
 * 
 * Exemple:
 * <code>
 * <?php
 * 
 * // Cas standard
 * $page = new Page(100); // ici, pour trouver le père d'une page, on divise par 100 le numéro du $P
 * 
 * // on utilise le Tag internet afin de comptabiliser les gens qui viennent sur le site depuis internet
 * $page = new Page(100, 'internet');
 * 
 * ?>
 * </code>
 */
class Page
{
    var $timeDebut;
    var $timeFin;
    var $requeteTemps = 0; // Temps pour executer toutes les requetes de la page (Voir fonction executeReq).
    var $requeteQuantite = 0; // Nombre de requete exécutées dans la page
    var $pageSaut = 10; // Navigation des liens (saut de 10 ou de 100 pour trouver la page parente)
    var $numPageAccueil = 0; // Numéro de la page d'accueil
    //var $designUrl = 'http://img.prod.intranet/design';
    var $designUrl = 'http://design.prod.intranet/design7';
//    var $designUrl = 'http://127.0.0.1/img/design';
//    var $designUrl = 'http://192.168.0.5/img/design';
    var $designColor = 'gris-bleu/1.0';
    var $forceDesign = true; // permet de forcer à utiliser les designs programmés (noel)
    var $messageInformation = array(); // message d'information important à afficher dans un bandeau défilant
    var $afficheMenuApplication = true; // Affiche le menu des applications en haut à droite du site
    var $affichePersonneConnecte = true; // Affiche le nombre de personne connecté sur l'application
    var $statsId = ''; // identifiant de la ligne de stats ajouté
    var $faviconImage = ''; // favicon en image au lieu d'une icone
    var $faviconIco = 'favicon.ico';
    var $designHiver = false;
    var $cssFileName = 'style.css';
    var $activeCalendrier = false; // mettre à true pour charger les javascript pour le calendrier
    var $activeFormCheck = false; // mettre à true pour charger les javascript pour le formcheck
    var $activeSigAdresse = false; // mettre à true pour charger le javascript pour le block SIG adresse
    var $activeBootstrap = false; // mettre à true pour charger bootstrap
    
    // design autorisé en local
    var $designColorsLocal = array(
                                'gris-bleu/1.0',
                                'gris-rose/1.0',
                                'gris-vert/1.0',
                                'gris-vertfonce/1.0',
                                'gris-jaune/1.0',
                                'gris-noel/1.0',
                                'nuit-neige/1.0',
                                'champs-neige/1.0',
                                'gris-violet/1.0',
                                'fournitures/1.0',
                                'noir-argent/1.0',
                                'logement/1.0',
                                'logementweb/1.0',
                                'noir-vert/2.0',
                                'noir-bleu/3.0',
                                'sig/2_0',
                                'nespresso/1.0',
                             );
    // design autorisé en prod
    var $designColorsProd = array(
                                'gris-bleu/1.0',
                                'gris-rose/1.0',
                                'gris-vert/1.0',
                                'gris-vertfonce/1.0',
                                'gris-jaune/1.0',
                                'nuit-neige/1.0',
                                'champs-neige/1.0',
                                'gris-violet/1.0',
                                'fournitures/1.0',
                                'noir-argent/1.0',
                                'logement/1.0',
                                'logementweb/1.0',
                                'noir-vert/2.0',
                                'noir-bleu/3.0',
                                'sig/2_0',
                                'nespresso/1.0',
                             );
    var $designColors = array();
    
     /**
     * Affectation des designs disponible suivant s'il on est en PROD ou en LOCAL
     */
    function setDesignColors()
    {
        global $PROD;
        if ($PROD == 1)
            $this->designColors = $this->designColorsProd;
        else
            $this->designColors = $this->designColorsLocal;
    }
    
    function __construct($saut = 10, $pageTag = '', $newDesignUrl = '')
    {
        $this->Page($saut, $pageTag, $newDesignUrl);
    }
     /**
     * Constructeur de la classe
     * Attention, lors de l'appel de ce constructeur,
     * on loggue en base de stats l'utilisateur
     * 
     * @param int $saut nécessaire pour la pagination (soit 10, soit 100).
     * C'est grace à lui qu'on trouve le père d'une page.
     * @param string $pageTag Tag qui sera utilisé pour les stats
     * @param string $newDesignUrl url du design racine par défaut (pratique pour le dév en local)
     */
    function Page($saut = 10, $pageTag = '', $newDesignUrl = '')
    {
        global $PAGES, $tabSiteEnMaintenance, $PROJET_ID, $P, $DATA_PATH;
        
        if (SERVEUR_PROD == 'EADM')
        {
            $this->designUrl = 'http://192.168.50.5/img/design';
            if (FROM_INTRANET == '1')
                $this->designUrl = 'http://aixbox.mairie-aixenprovence.fr/img/design';
            else
                $this->designUrl = 'http://eadministration.mairie-aixenprovence.fr/img/design';
        }
        else if(SERVEUR_PROD == 'EADM-SECURE')
        {
            //$this->designUrl = 'https://eadm-secure.mairie-aixenprovence.fr/img/design';
            $this->designUrl = '../img/design';
        }
        else if (SERVEUR_PROD == 'SARRAKIS2')
        {
            $this->designUrl = '../img/design';
        }
        else
        {
            $this->designUrl = 'http://web2.intranet/img/design';
        }

        if ($newDesignUrl != '')
            $this->designUrl = $newDesignUrl;

        $this->timeDebut = getMicroTime();
        
        $this->setDesignColors();
        
        // Module de connexion avec LDAP

        $PAGES['C'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_connexion_ldap.php',
                                'TITRE' => 'Acc&egrave;s restreint',
                                'DESCRIPTION' => 'Veuillez vous identifier',
                                'IMAGE' => $this->designUrl.'/connexion/connexion.gif',
                                'IS_COMMON' => 1,
                                'ON_LOAD' => '"javascript:focusOnUserOrPassword();tooltip.init();"',
                                'HEAD_JAVASCRIPT' => '
function focusOnUserOrPassword()
{
    if (document.formconnexion.agent_login.value == \'\')
    {
        document.formconnexion.agent_login.focus();
    }
    else
    {
        document.formconnexion.agent_password.focus();
    }
}
                                ',
                            );
        $PAGES['C_AJAX'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_connexion_ldap_ajax.php',
                                'TITRE' => 'Acc&egrave;s restreint',
                                'DESCRIPTION' => 'Veuillez vous identifier',
                                'IMAGE' => $this->designUrl.'/connexion/connexion.gif',
                                'IS_COMMON' => 1,
                                'ON_LOAD' => '"javascript:focusOnUserOrPassword();tooltip.init();"',
                                //'HEAD_JAVASCRIPT' => '',
                            );
        $PAGES['C_AJAX_REPONSE'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_connexion_ldap_ajax_reponse.php',
                                'TITRE' => 'Acc&egrave;s restreint',
                                'DESCRIPTION' => 'Veuillez vous identifier',
                                'IMAGE' => $this->designUrl.'/connexion/connexion.gif',
                                'IS_COMMON' => 1,
                                //'ON_LOAD' => '"javascript:focusOnUserOrPassword();tooltip.init();"',
                                //'HEAD_JAVASCRIPT' => '',
                            );
        // Module de Droit Insuffisant => en cas de tentative d'Accès à une page dont l'utilisateur n'a pas les droits d'acces
        $PAGES['DI'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_droit_insuffisant.php',
                                'TITRE' => 'Droits insuffisants',
                                'DESCRIPTION' => 'Acc&egrave;s restreint...',
                                'IMAGE' => $this->designUrl.'/maintenance/warning.gif',
                                'IS_COMMON' => 1,
                                //'SECURE_ACCESS' => 1,
                            );

        // Module d'historique
        $PAGES['H'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_historique_projet.php',
                                'TITRE' => 'Historique des mises à jour',
                                'IS_COMMON' => 1,
                                //'SECURE_ACCESS' => 1,
                            );
        // Module des logs utilisateurs
        $PAGES['L'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_logs_affichage.php',
                                'TITRE' => 'Actions des utilisateurs',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 1,
                            );
        // Module maintenance => en cas de mise à jour de site
        $PAGES['M'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_maintenance.php',
                                'TITRE' => 'Maintenance',
                                'DESCRIPTION' => 'Opération de maintenance en cours...',
                                'IMAGE' => $this->designUrl.'/maintenance/warning.gif',
                                'IS_COMMON' => 1,
                                //'SECURE_ACCESS' => 1,
                            );
        // Module Erreur => en cas de tentative d'accès à une page non défini
        $PAGES['E'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_404.php',
                                'TITRE' => 'Page introuvable',
                                'DESCRIPTION' => 'La page demandée est introuvable...',
                                'IMAGE' => $this->designUrl.'/maintenance/warning.gif',
                                'IS_COMMON' => 1,
                                //'SECURE_ACCESS' => 1,
                            );
        // Module Mise à jour => Indique au développeur que son common n'est pas à jour
        $PAGES['CNAJ'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_common_non_a_jour.php',
                                'TITRE' => 'Version du Common obsolète',
//                                'DESCRIPTION' => 'La page demandée est introuvable...',
                                'IMAGE' => $this->designUrl.'/maintenance/warning.gif',
                                'IS_COMMON' => 1,
                                //'SECURE_ACCESS' => 1,
                            );
                            
        // Module message d'Alerte => pour parametrer les messages d'alerte à afficher
        $PAGES['A'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_projet_message.php',
                                'TITRE' => 'Diffusion d\'un message d\'alerte',
                                //'DESCRIPTION' => 'Opération de maintenance en cours...',
                                //'IMAGE' => $this->designUrl.'/maintenance/warning.gif',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 1,
                            );
        $PAGES['AS'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_projet_message_save.php',
                                'TITRE' => 'Maintenance',
                                'DESCRIPTION' => 'Opération de maintenance en cours...',
                                //'IMAGE' => $this->designUrl.'/maintenance/warning.gif',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 1,
                            );
        // Module qui affiche l'architecture d'un projet
        $PAGES['P'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_affichage_architecture.php',
                                'TITRE' => 'Architecture du projet',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 0,
                            );
                            
        $PAGES['G'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_generate_module.php',
                                'TITRE' => 'Génération automatique des modules',
                                //'DESCRIPTION' => 'Opération de maintenance en cours...',
                                //'IMAGE' => $this->designUrl.'/maintenance/warning.gif',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 1,
                            );
        $PAGES['N'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_navigateur_maj.php',
                                'TITRE' => 'Mise à jour de votre navigateur',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 0,
                        );
        
        // Module qui affiche dans un XML le resultat de recherche pour le bloc SIG Adresse
        $PAGES['SIGADRVOIE'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_sig_adresse_voie.php',
                                'TITRE' => 'SIG Adresse voie webservice',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 0,
        );
        
        $PAGES['SIGADRNUMERO'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_sig_adresse_numero.php',
                                'TITRE' => 'SIG Adresse numero webservice',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 0,
        );
        
        $PAGES['SIGADRSOUSADRESSE'] =  array(
                                'MODULE' => COMMON_MODULE_PATH . '/mod_sig_adresse_sous_adresse.php',
                                'TITRE' => 'SIG Adresse sous adresse webservice',
                                'IS_COMMON' => 1,
                                'SECURE_ACCESS' => 0,
        );
        
        if (SERVEUR_PROD == 'SARRAKIS' && defined('SERVEUR_URL_RACINE'))
        {
            $PAGES['C_AJAX']['HTTPS'] = 1;
            $PAGES['C_AJAX_REPONSE']['HTTPS'] = 1;
        }

        if (SERVEUR_PROD == 'LOCAL' && defined('SERVEUR_URL_RACINE'))
        {
            $PAGES['C_AJAX']['HTTPS'] = 1;
            $PAGES['C_AJAX_REPONSE']['HTTPS'] = 1;
        }

        $this->pageSaut = $saut;
        $this->numPageAccueil = 0;
        
        // Vérification si l'on est en mode maintenance
        if (isset($PROJET_ID) && array_key_exists($PROJET_ID, $tabSiteEnMaintenance))
        {
            if ($_SERVER['REMOTE_ADDR'] == $tabSiteEnMaintenance[$PROJET_ID]['IP']) // IP de la personne qui a mis en maintenance le site
            {
                foreach($PAGES as $k => $v)
                {
                    $PAGES[$k]['TITRE'] = '<font color=red>[MAINTENANCE]</font> '. $PAGES[$k]['TITRE'];
                }
            }
            else
                $P = 'M';
        }
        
        // Récupération du message local au site
        $fichierMessage = $DATA_PATH.'/config_message.php';
        if (file_exists($fichierMessage))
            @include($fichierMessage);
        if (!isset($tabSiteMessage))
            $tabSiteMessage = array();
        $this->messageInformation = $tabSiteMessage;
        
        // Récupération du message général à tous les sites intranet
        $fichierMessage = COMMON_PATH.'/data/config_message.php';
        if (file_exists($fichierMessage))
            @include($fichierMessage);
        if (!isset($tabSiteMessageGeneral))
            $tabSiteMessageGeneral = array();
        if (isset($tabSiteMessageGeneral['MESSAGE']) &&
            $tabSiteMessageGeneral['MESSAGE'] != '' &&
            isset($tabSiteMessageGeneral['DATE']) &&
            time() < $tabSiteMessageGeneral['DATE'])
            $this->messageInformation = $tabSiteMessageGeneral;
        
        // Fin du mode maintenance
        if (SERVEUR_PROD == 'SSARGAS')
        {
            // serveur isolé des autres, pas de connexion à la base des projets
            $this->setMenuApplication(false);
            $this->setPersonneConnecte(false);
            $this->designUrl = 'http://sigweb.mairie-aixenprovence.fr/img/design';
        }
        else
        {
            if (SERVEUR_PROD == 'LOCAL')
            {
                $this->setMenuApplication(false);
                $this->setPersonneConnecte(false);
                
                // Utilisation de la fonction d'erreur personnalisée pour le dev local
//                 echo $PROJET_ID; //
                 /*if (in_array($PROJET_ID, array(138,69)))
                    set_error_handler("errorHandlerByJC");*/
                
            }            
            $designCodeSupp = Common::getDesignCodeSupp();
            $stats_id = logPage($pageTag);
            $this->statsId = $stats_id;
        }
    }
    
    /**
     * Défini le numéro de la page d'accueil du site
     * 
     * @param int numéro de la page représentant la page d'accueil du site
     * 
     */
    function setNumPageAccueil($v)
    {
        $this->numPageAccueil = $v;
    }
    
    /**
     * Défini le nom du fichier CSS par défaut à charger
     * 
     * @param string $nomFichierCSS nom du fichier css à charger à partir de GENERAL_URL
     */
    function setCssFileName($nomFichierCSS)
    {
        $this->cssFileName = $nomFichierCSS;
    }
    
    
    /**
     * Active ou non les scripts pour afficher des calendriers sur la page
     * 
     * @param boolean $active indique si oui ou non on veut le calendrier sur la page (design V3 uniquement)
     */
    function setCalendrier($active)
    {
        $this->activeCalendrier = $active;
    }
    
    /**
     * Active ou non les scripts pour activer le formcheck sur la page
     *
     * @param boolean $active indique si oui ou non on veut pouvoir utiliser le formcheck sur la page (design V3 uniquement)
     */
    function setFormCheck($active)
    {
        $this->activeFormCheck = $active;
    }
    
    /**
     * Active ou non bootstrap
     *
     * @param boolean $active indique si oui ou non on souhaite activer bootstrap
     */
    function setBootstrap($active)
    {
        $this->activeBootstrap = $active;
    }
    
    /**
     * Défini l'image à mettre en favicon
     * 
     * @param string url de l'image à mettre en favicon
     * 
     */
    function setFaviconImage($v)
    {
        $this->faviconImage = $v;
    }
    
    
    /**
     * Indique si oui (true) ou non (false) on souhaite afficher le menu des applications en haut à droite de chaque site
     * 
     * @param boolean Affiche le menu (=true) ou non (=false)
     * 
     */
    function setMenuApplication($bool)
    {
        $this->afficheMenuApplication = $bool;
    }
    
    /**
     * Indique si oui (true) ou non (false) on souhaite afficher les personnes connectés sur l'application
     * 
     * @param boolean Affiche les personnes (=true) ou non (=false)
     * 
     */
    function setPersonneConnecte($bool)
    {
        $this->affichePersonneConnecte = $bool;
    }
    
    /**
     * Active ou non les scripts pour afficher les bloque SIG adresse
     * 
     * @param boolean $active indique si oui ou non on veut afficher le bloque adresse SIG (design V3 uniquement)
     */
    function setSigAdresse($active)
    {
        $this->activeSigAdresse = $active;
        $this->setFormCheck(true);
    }
    
    
    /**
     * Défini le design à appliquer au site
     * 
     * Exemple:
     * <code>
     * <?php
     * 
     * $page = new Page(100);
     * $page->setDesign('gris-jaune/1.0');
     * 
     * ?>
     * </code>
     * @param string design à appliquer
     * @link getAllDesign
     * 
     */
    function setDesign($designCh)
    {
        if (in_array($designCh, $this->designColors))
            $this->designColor = $designCh;
        else
            die('design '.$designCh.' non utilisable en production! Veuillez l\'enlever SVP!');
    }
    
    private function activeDesignHiver()
    {
        $this->designHiver = true;
    }
    
    /**
     * Renvoie tout les designs que l'ont peut utiliser en production
     * 
     * @return array liste des designs que l'on peut passer à la fonction setDesign
     * @see function setDesign
     * 
     */
    function getAllDesign()
    {
        return $this->designColors;
    }
    
    /**
     * Renvoie l'url du design en cours
     * 
     * @return string design url
     * 
     */
    function getDesignUrl()
    {
        return $this->designUrl .'/'. $this->designColor;
    }
    
    /**
     * Force le chargement de certains designs
     * Par exemple pour noel, on charge le design de noel
     */
    private function chargeDesignForce()
    {
        $sec = time();
        $mois = date('m', $sec);
        $jour = date('d', $sec);
        
        $nbVersion2 = substr_count($this->designColor, '/2.0');
        $nbVersion2 += substr_count($this->designColor, '/2_0');
        if ($nbVersion2 == 0)
        {
            // Champs Neige => Décembre (01 => 14) et Janvier
            if ($mois == 1 || $mois == 12)
                $this->designColor = 'champs-neige/1.0'; // on charge le design du nouvel an
    
            // Design de noel
            // Après le 14/12 et avant le 01/01
            if ($jour > 14 && $mois == 12)
                $this->designColor = 'gris-noel/1.0'; // on charge le design de noel
        }
    }
    
    /**
     *
     * Affiche le Header d'une page
     * 
     */
    function afficheHeader()
    {
        $nbVersion2 = substr_count($this->designColor, '/2.0');
        $nbVersion2 += substr_count($this->designColor, '/2_0');
        $nbVersion3 = substr_count($this->designColor, '/3.0');
        $nbVersion4 = substr_count($this->designColor, '/4.0');
        
        if ($nbVersion2 == 1)
            $this->afficheHeaderVersion2_0();
        else if ($nbVersion3 == 1)
            $this->afficheHeaderVersion3_0();
        else if ($nbVersion4 == 1)
            $this->afficheHeaderVersion4_0();
        else
            $this->afficheHeaderVersion1_0();
        // on charge le design version 1.0
        
    }

    /**
     *
     * Affiche le Footer d'une page
     * 
     */
    function afficheFooter()
    {
        $nbVersion2 = substr_count($this->designColor, '/2.0');
        $nbVersion2 += substr_count($this->designColor, '/2_0');
        $nbVersion3 = substr_count($this->designColor, '/3.0');
        $nbVersion4 = substr_count($this->designColor, '/4.0');
        
        if ($nbVersion2 == 1)
            $this->afficheFooterVersion2_0();
        else if ($nbVersion3 == 1)
            $this->afficheFooterVersion3_0();
        else if ($nbVersion4 == 1)
            $this->afficheFooterVersion4_0();
        else
            $this->afficheFooterVersion1_0();
    }
    
    /**
     *
     * Affiche le Footer d'une page en version 1.0
     * 
     */
    private function afficheFooterVersion1_0()
    {
        global $PAGES, $P, $PROD;
        
        if ( !isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {

        echo '</td>';
        echo '<td class="tdOmbreD"></td>';
        echo '</td></tr>';
        echo '<tr>
                    <td colspan="3">
                        <table cellpadding="0" cellspacing="0" border="0">
    		                <tr>
    		                    <td id="boitesTdOmbreBG">&nbsp;</td>
    	                        <td id="boitesTdOmbreB">&nbsp;</td>
    	                        <td id="boitesTdOmbreBD">&nbsp;</td>
    		                </tr>
    		            </table>
                    </td>
                </tr>';
        echo '</table>';
        $this->timeFin = getMicroTime();
        $t = number_format($this->timeFin - $this->timeDebut, 3, '.', ' ');
        echo '<div id="footer">';
        echo    'Génération de la page : <font color=#008000><b>'. $t .'</b></font> sec.'.
			    ' | Nombre de requêtes SQL : <font color=#008000><b>'. $this->requeteQuantite .'</b></font>';
        if (defined('PROJET_AFF_CONTACT_EMAIL') && PROJET_AFF_CONTACT_EMAIL != '' && defined('PROJET_SERVICE') && PROJET_SERVICE != '')
        {

            echo '<br><a href="mailto:'. PROJET_AFF_CONTACT_EMAIL .'">Contactez le '.PROJET_SERVICE.'</a>';
            echo '<br>© '.date('Y').' Direction des Systèmes Informatiques';
            
            echo '<br><a href="mailto:'. ALERT_EMAIL .'">Contactez la DSI</a></div>';
        }
        else
        {
            echo '<br>© '.date('Y').' Direction des Systèmes Informatiques';
            echo '<br><a href="mailto:'. ALERT_EMAIL .'">Contactez la DSI</a>';
        }
        
        /*
        if (date('Y') == '2011' && date('m') == '1')
        {
            echo '<br><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="550" height="150">
        <param name="movie" value="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf">
        <param name="quality" value="high">
        <embed src="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="550" height="150"></embed></object>';
        }
        */
        echo '</div>';
        
//        if ($PROD == 1)
//        {
//            echo '<script language="JavaScript">'."\r\n";
//            echo 'var s=\'<img src="http://projets.prod.intranet/index.php?P=13\';'."\r\n";
//            echo 'if(parseFloat(navigator.appVersion)>=4)'."\r\n";
//            echo '{'."\r\n";
//            echo 's += \'&ew=\' + screen.width + \'&eh=\' + screen.height;'."\r\n";
//            echo '}'."\r\n";
//            echo 's += \'">\';'."\r\n";
//            echo 'document.writeln(s);'."\r\n";
//            echo '</script>'."\r\n";
//        }
        
        }
        echo '</body>'.
        '</html>';
    }
    
    /**
     *
     * Affiche le Header d'une page en version 1.0
     * 
     */
    private function afficheHeaderVersion1_0()
    {
        global $PAGES, $P, $GENERAL_URL, $IMAGE_URL, $MODULE_PATH, $JAVASCRIPTS, $ONGLETS, $PROJET_ID, $gestionProjet, $PROD, $CSS_TO_LOAD;
        if ($this->forceDesign)
            $this->chargeDesignForce(); // Charge le design forcé
        echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" type="image/x-icon" href="'.$GENERAL_URL.'/favicon.ico" />
<title>'.$PAGES[$P]["TITRE"].'</title>
<link href="'. $this->designUrl .'/js/thickbox/thickbox.css" rel="stylesheet" type="text/css">
<link href="'. $this->getDesignUrl() .'/styles.css" rel="stylesheet" type="text/css">'."\r\n";

if (isset($_SERVER['HTTP_USER_AGENT']) && substr_count($_SERVER['HTTP_USER_AGENT'], 'Firefox') > 0) // Hack Firefox
    echo '<link href="'. $this->getDesignUrl() .'/firefox.css" rel="stylesheet" type="text/css">'."\r\n";

if (isset($PAGES[$P]['DONT_LOAD_CSS_SITE']) && $PAGES[$P]['DONT_LOAD_CSS_SITE'] != '' && $PAGES[$P]['DONT_LOAD_CSS_SITE'] == '1')
{
    // pas de chargement du css
}
else
{
    // chargement du css
    echo '<link href="'.$GENERAL_URL.'/'. $this->cssFileName .'" rel="stylesheet" type="text/css">'."\r\n";
}

if (isset($CSS_TO_LOAD))
{
    foreach($CSS_TO_LOAD as $v)
        echo '<link href="'.$v.'" rel="stylesheet" type="text/css">'."\r\n";
}

if (isset($JAVASCRIPTS))
{
    foreach($JAVASCRIPTS as $v)
        echo '<script type="text/javascript" src="'.$v.'"></SCRIPT>'."\r\n";
    $t = array_map('basename', $JAVASCRIPTS);
    if (!in_array('title.js', $t))
        echo '<script type="text/javascript" src="'.$this->designUrl.'/js/title.js"></SCRIPT>'."\r\n";
}
if ($P == 'C_AJAX') // connexion ldap
    echo '<script type="text/javascript" src="'.$this->designUrl.'/js/connexion.js"></SCRIPT>'."\r\n";

//echo '<script type="text/javascript" src="'.$this->designUrl.'/js/thickbox/jquery-latest.js"></SCRIPT>'."\r\n";
//echo '<script type="text/javascript" src="'.$this->designUrl.'/js/thickbox/thickbox.js"></SCRIPT>'."\r\n";

if (isset($PAGES[$P]['HEAD_JAVASCRIPT']) && $PAGES[$P]['HEAD_JAVASCRIPT'] != '')
{
    echo '<script type="text/javascript">'."\r\n";
    echo $PAGES[$P]['HEAD_JAVASCRIPT']."\r\n";
    echo '</script>'."\r\n";
}

echo '</head>'."\r\n";
echo '<body';

if ( isset($PAGES[$P]['ON_LOAD']) )
    echo ' onload=' . $PAGES[$P]['ON_LOAD'];

if (isset($PAGES[$P]['ON_BLUR']))
    echo ' onblur=' . $PAGES[$P]['ON_BLUR'];

if ( isset($PAGES[$P]['HEADER_NO_SPACE']) && $PAGES[$P]['HEADER_NO_SPACE'] == 1)
    echo ' style="margin:0; padding:0;"';

$projetNom = '';
$projetVersion = '';
if (defined('PROJET_AFF_NOM') && PROJET_AFF_NOM != '')
    $projetNom = PROJET_AFF_NOM;
if (defined('PROJET_AFF_VERSION') && PROJET_AFF_VERSION != '')
    $projetVersion = PROJET_AFF_VERSION;
//if (defined('PROJET_VERSION') && PROJET_VERSION != ''){
//    $projetVersionEcran = '<a href = index.php?P='.PROJET_VERSION.' target=blank>'.$projetVersion.'</a>';
//    }else{
//    $projetVersionEcran =$projetVersion;
//    }
echo ' leftmargin=0 topmargin=0 marginwidth=0 marginheight=0>';
    
$ch = '';
if ( !isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
{
    
// Vérification si un message important à afficher existe...
if (isset($this->messageInformation['DATE']) && time()<$this->messageInformation['DATE'])
{
    // il existe un message et la date de fin de ce message n'est pas dépassé
    $color = 'red';
    if (isset($this->messageInformation['COLOR']) && $this->messageInformation['COLOR'] != '')
        $color = $this->messageInformation['COLOR'];
    echo    '<div style="z-index:1000;position:absolute;top:50px;left:25px;width:755px;height:12px;background-color:'.$color.';" id="zonePushLoggeeFRT">'.
                '<marquee class="menuHaut" behavior="scroll" DIRECTION="left" height="12px" style="font-size:13px;color:black;" onmouseover="javascript:scroller1.stop()" onmouseout="javascript:scroller1.start()" id="scroller1" SCROLLDELAY="150" SCROLLAMOUT="1" bgcolor="'.$color.'">'.
                    '<b>'. $this->messageInformation['MESSAGE'] .'</b>'.
                '</marquee>'.
            '</div>';
}

echo '        <div id="Container">
            <div id="logo">'.$projetNom.' <a title="Cliquez ici pour consulter l\'historique des mises à jour" href="index.php?P=H"><span class="version">V</span> <span class="numversion">'.$projetVersion.'</span></a><br>'.date('H\Hi').'</div>
            <div id="menu"></div>
        </div>
        <div id="data">';

        $continuer = true;
        $num = $P;
        $titre = $description = '';
        $image = $GENERAL_URL.'/images/default.gif'; // Image par défaut
        $imageWidth = 48;
        while ($continuer)
        {
            //echo ' ['.$num.'] ';
            $param = "";
            if ($ch == '')
            {
                $ch = "<i>" . $PAGES[$num]['TITRE'] . "</i>";
                $titre = $PAGES[$num]['TITRE'];
                if (isset($PAGES[$num]['DESCRIPTION']))
                    $description = $PAGES[$num]['DESCRIPTION'];
                if (isset($PAGES[$num]['IMAGE']))
                {
                    if (basename($PAGES[$num]['IMAGE']) != $PAGES[$num]['IMAGE']) // Image en prod
                        $image = $PAGES[$num]['IMAGE'];
                    else
                        $image = $GENERAL_URL.'/images/'.$PAGES[$num]['IMAGE']; // Image en local au projet
				    $imageWidth = (isset($PAGES[$num]['IMAGE_WIDTH']) && $PAGES[$num]['IMAGE_WIDTH'] != '') ? $PAGES[$num]['IMAGE_WIDTH']:$imageWidth;
                }
            }
            else
            {
                $variablesLien = '';
                if (isset($PAGES[$num]['VARIABLES']) && is_array($PAGES[$num]['VARIABLES']))
                {
                    foreach($PAGES[$num]['VARIABLES'] as $nomVariable)
                    {
                        eval('global $' . $nomVariable . ';');
                        eval('$'.'value = $' . $nomVariable . ';');
                        if ($value != '')
                        $variablesLien .= '&'.$nomVariable.'='.$value;
                    }
                }
                $ch = "<a class=\"navigation\" href=\"index.php?P=" . $num .$variablesLien. "\">" . $PAGES[$num]["TITRE"] . "</a>" . " > " . $ch;
            }
            if (is_numeric($num) && $num == 0 || is_numeric($num) && $num == $this->numPageAccueil) // Si l'on est sur le numéro de la page d'accueil => Arret
            {
                $continuer = false;
                //echo 'A';
            }
            else
            {
                if (is_numeric($num))
                {
                    $num = intval($num/$this->pageSaut);
                    //echo 'B';
                }
                else
                {
                    $num = $this->numPageAccueil;
                    //echo 'C';
                }
            }
        }
        
        if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
        {
            //echo $_SESSION[PROJET_NAME]['agent_ldap']['login'];
            if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','cattierl','torrentf','bonoc','adinanid','paulp','villaj')))
                $isDevInformatique = true;
            else
                $isDevInformatique = false;
            if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','fitzailos','villaj','cattierl','filliardl','boublenzai','bonoc','adinanid','paulp')))
                $isUserGrantedToModifyMessage = true;
            else
                $isUserGrantedToModifyMessage = false;
            
            if ($isUserGrantedToModifyMessage == false) // on récupère la valeur mis en dur pour des agents admin du site
                $isUserGrantedToModifyMessage = getUserCanModifyAlerteMessage();

            $chDeco = '<tr>'.
                        '<td align=right height=50 colspan="3">'.
                            '<a href="index.php">Accueil</a>'.
                            ($isDevInformatique ? '&nbsp;<a href="index.php?P=L">|</a>&nbsp;':'&nbsp;|&nbsp;').
                            ($isUserGrantedToModifyMessage ? '<a href="index.php?P=A">Message</a>&nbsp;|&nbsp;':'').
                            '<a href="index.php?action=logout">Déconnexion&nbsp;<img align="absbottom" src="'. $this->designUrl .'/'. $this->designColor .'/close.gif" border="0"></a>'.
                        '</td>'.
                      '</tr>';
        }
        else
        {
            $chDeco = '<tr><td align=right height=50 colspan="3"></td></tr>';
        }
        $linkSupportDSI = $this->getLinkToSupportDSI();
        
        $ch = '<table id="tabDroite" cellpadding="0" cellspacing="0">'.$chDeco.'
                <tr>
                    <td id="tdHautAnalyse" colspan="3"> 
                        <div id="divHautAnalyse">
                            <div id="zoneTitre">
                                <a href="index.php"><img border="0" id="imgTitre" width="'. $imageWidth .'" height="48" class="imgT" src="'.$image.'" title="Cliquez ici pour revenir à l\'accueil"></a>
                                <div id="TitreAnalyse">'.$titre.$linkSupportDSI.'</div>
                                <div id="SousTitreAnalyse">'.$description.'</div>
                            </div>
                            <div id="divRecap2">
                                <div id="divRecap3">
                                    <div id="divRecap">'.$ch.'</div>
                                </div>
                            </div>';
        if (defined('PROJET_DGA') && PROJET_DGA != '')
        {
            $ch .= '<div id="organigramme">';
            $ch .= '<span class="dga">'.PROJET_DGA.'</span>';
            if (defined('PROJET_DIRECTION') && PROJET_DIRECTION != '')
                $ch .= '<span class="direction">'.PROJET_DIRECTION.'</span>';
            if (defined('PROJET_SERVICE') && PROJET_SERVICE != '')
                $ch .= '<span class="service">'.PROJET_SERVICE.'</span>';
            $ch .= '</div>';
        }
        
        // Affichage de la liste des sites accéssibles par l'utilisateur
        if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1 && $this->afficheMenuApplication == true)
        {
            
            $select = '<select onchange="javascript:if (this.value != \'\'){window.location=this.value;}" name="menuapp">';
            //$select .= '<option value="">Sélectionnez un site...</option>';
            $nb = 0;
            if (isset($_SESSION[PROJET_NAME]['application_user']))
            {
                foreach($_SESSION[PROJET_NAME]['application_user'] as $k => $tabProjet)
                {
                    $select .= '<option value="">:: '.$k.'</option>';
                    $projetIdCourant = '';
                    $i = 0;
                    foreach($tabProjet as $v)
                    {
                        if ($projetIdCourant != $v['PROJET_ID'])
                        {
                            $colorFond = $i%2 == 0 ? '#FFFFFF':'#EEEEEE';
                            $colorTxt = $i%2 == 0 ? '#C23104':'#0435C2';
                            $i++;
                            $projetIdCourant = $v['PROJET_ID'];
                        }
                        
                        $select .= '<option style="background-color:'.$colorFond.';color:'.$colorTxt.';" value="'.$v['PROJET_URL'].'">'.$v['PROJET_LIBELLE'].'</option>';
                        $nb++;
                    }
                }
                $select .= '</select>';
            }
            if ($nb > 1)
            {
                $ch .= '<div id="applicationmenu">'. $select .'</div>';
            }
        }
        
        // Affichage du nombre de personne connecté sur le site
        if ($PROD == 1 && isset($PROJET_ID) && $PROJET_ID != '' && isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1 && $this->affichePersonneConnecte == true)
        {
            if (!$gestionProjet->isConnected())
                $gestionProjet->connexion();

            if ($gestionProjet->isConnected())
            {
                $nbVisiteur = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID);
                $nbVisiteurToday = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID, 'today');

                // Chaine contenant le détail des visiteurs actuellement sur le site
                $tabVisiteur = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID);
                $chVisiteur = '';
                $nbMaxAffichage = 15;
                $i = 0;
                foreach($tabVisiteur as $k => $v)
                {
                    if ($i == $nbMaxAffichage)
                    {
                        $chVisiteur .= '<br>...';
                        break;
                    }
                    if ($chVisiteur != '')
                        $chVisiteur .= '<br>';
                    if ($v['USER'] == '')
                        $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'].'</strong>';
                    else
                        $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                    $chVisiteur .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                    $i++;
                }
                if ($chVisiteur != '')
                    $chVisiteur = '<br>'.$chVisiteur;
                
                // Chaine contenant le détail des visiteurs d'aujourd'hui
                $tabVisiteurToday = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID, 'today');
                $chVisiteurToday = '';
                $i = 0;
                foreach($tabVisiteurToday as $k => $v)
                {
                    if ($i == $nbMaxAffichage)
                    {
                        $chVisiteurToday .= '<br>...';
                        break;
                    }
                    if ($chVisiteurToday != '')
                        $chVisiteurToday .= '<br>';
                    if ($v['USER'] == '')
                        $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'] .'</strong>';
                    else
                        $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                    $chVisiteurToday .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                    $i++;
                }
                if ($chVisiteurToday != '')
                    $chVisiteurToday = '<br>'.$chVisiteurToday;
    
                $ch .=  '<div id="visiteurs">'.
                        '<table align=right><tr>'.
                        '<td><img align=absbottom src="'. $this->designUrl . '/pagination/users2.gif"></td>'.
                        '<td>&nbsp;<a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont <strong>actuellement présentes</strong> sur cette application'.$chVisiteur.'">'.$nbVisiteur.'</a>&nbsp;'.
                        '/'.
                        '&nbsp;<a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont venu sur cette application <strong>aujourd\'hui</strong>'.$chVisiteurToday.'">'.$nbVisiteurToday.'</a>'.
                        '</td>'.
                        '</tr></table>'.
                        '</div>';
            }
        }
        
        // Affichage des onglets
        if (isset($ONGLETS))
        {
            $ch .= '<table id="tabOnglets" class="tabOnglets" cellpadding="0" cellspacing="0">'.
                    '<tr>';
            $nb = count($ONGLETS);
            $maxOnglet=6;
            for($i=0; $i<$maxOnglet-$nb; $i++)
            {
                $ch .=     '<td class="tdOnglets">'.
                            '<div class="Onglet" onclick="" style="display: none;">No-Name</div>'.
                        '</td>';
            }
            foreach($ONGLETS as $v)
            {
                $ch .=     '<td class="tdOnglets">'.
                            '<div '.((isset($v['TITLE']) && $v['TITLE'] != '') ? 'title="'.$v['TITLE'].'"':'').' class="'.($v['ACTIF'] == true ? 'OngletSelected':'Onglet').'" onclick="javascript:document.location.href=\''.$v['LINK'].'\';">'.$v['TXT'].'</div>'.
                        '</td>';
            }
            $ch .=         '</tr>'.
                    '</table>';
        }
                           
    $ch .= '            </div>
                    </td>
                </tr>
                <tr>
                    <td class="tdOmbreG"></td>
                    <td class="tdContenu"><br>';
}
        echo $ch;
    }
    
    /**
     *
     * Affiche le Header d'une page en version 2.0
     * 
     */
    private function afficheHeaderVersion2_0()
    {
        global $PAGES, $P, $GENERAL_URL, $IMAGE_URL, $MODULE_PATH, $JAVASCRIPTS, $ONGLETS, $PROJET_ID, $gestionProjet, $DATA_PATH, $BOUTTONS, $MENU, $CSS_TO_LOAD, $RSS, $PROD, $MOOTOOLS_1_5;
        if (!isset($PAGES[$P]['NO_DOCTYPE']) || (isset($PAGES[$P]['NO_DOCTYPE']) && $PAGES[$P]['NO_DOCTYPE']== 0))
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\r\n";
        
        
        echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />'."\r\n";

if (defined('META_DESCRIPTION') && META_DESCRIPTION != '')
{
    echo '<meta name="description" content="'.META_DESCRIPTION.'" />'."\r\n";
}

echo '<link rel="shortcut icon" type="image/x-icon" href="'.$GENERAL_URL.'/favicon.ico" />'."\r\n";

if ($this->faviconImage != '')
    echo '<link rel="icon" type="image/gif" href="'. $this->faviconImage .'" />'."\r\n";

echo '<title>'.$PAGES[$P]["TITRE"].'</title>'."\r\n";
//echo '<link href="'. $this->getDesignUrl() .'/css/template.css" rel="stylesheet" type="text/css">'."\r\n";

if (isset($RSS))
{
    foreach($RSS as $v)
        echo '<link rel="alternate" type="application/rss+xml" title="'.$v['TITLE'].'" href="'.$v['HREF'].'" />'."\r\n";
}

if ($this->designHiver == true)
    echo '<link href="'. $this->getDesignUrl() .'/css/styles_hiver.css" rel="stylesheet" type="text/css">'."\r\n";
else
    echo '<link href="'. $this->getDesignUrl() .'/css/styles.css" rel="stylesheet" type="text/css">'."\r\n";


echo '<link href="'.$GENERAL_URL.'/'. $this->cssFileName .'" rel="stylesheet" type="text/css">'."\r\n";

if (isset($CSS_TO_LOAD))
{
    foreach($CSS_TO_LOAD as $v)
        echo '<link href="'.$v.'" rel="stylesheet" type="text/css">'."\r\n";
}

$t = array();
if (isset($JAVASCRIPTS))
{
    $t = array_map('basename', $JAVASCRIPTS);
}

if (!in_array('mootools.js', $t) && !isset($PAGES[$P]['NO_MOOTOOLS']) || (isset($PAGES[$P]['NO_MOOTOOLS']) && $PAGES[$P]['NO_MOOTOOLS']== 0))
{
//    echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools-1.2.1-core.js"></SCRIPT>'."\r\n";
    
    /*
    if (defined(SERVEUR_PROD) && SERVEUR_PROD == 'EADM')
    {
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-core-1.4.5-full-compat-yc.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-more-1.4.0.1.js"></SCRIPT>'."\r\n";
    }*/
    if (isset($MOOTOOLS_1_5) && $MOOTOOLS_1_5 == 1)
    {
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-core-1.5.1.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-more-1.5.1.js"></SCRIPT>'."\r\n";
    }
    else
    {
        echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools-1.2.1-core-yc.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools-1.2-more.js"></SCRIPT>'."\r\n";
    }
    
    
    
    echo '<script type="text/javascript" src="'.$this->designUrl.'/js/scrollspy.js"></SCRIPT>'."\r\n";
//    echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools.js"></SCRIPT>'."\r\n";
    
}


if (isset($JAVASCRIPTS))
{
    foreach($JAVASCRIPTS as $v)
        echo '<script type="text/javascript" src="'.$v.'"></SCRIPT>'."\r\n";
    $t = array_map('basename', $JAVASCRIPTS);
}

if (!in_array('title.js', $t))
    echo '<script type="text/javascript" src="'.$this->designUrl.'/js/title.js"></SCRIPT>'."\r\n";
?>

<!--[if IE 7]>
<link href="<?=$this->getDesignUrl()?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>
<link href="<?=$this->getDesignUrl()?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?
    echo '<link href="'. $this->getDesignUrl() .'/css/rounded.css" rel="stylesheet" type="text/css">'."\r\n";
    //echo '<link href="'. $this->getDesignUrl() .'/js/jscalendar-1.0/calendar-green.css" rel="stylesheet" type="text/css">'."\r\n";
    
    if (!isset($PAGES[$P]['NO_MENU']) || (isset($PAGES[$P]['NO_MENU']) && $PAGES[$P]['NO_MENU'] == 0))
    {
        if (!isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {
            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/menu.js"></SCRIPT>'."\r\n";
            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/fat.js"></SCRIPT>'."\r\n";
            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/index.js"></SCRIPT>'."\r\n";
            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/fonctions.js"></SCRIPT>'."\r\n";
            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/chrome.js"></SCRIPT>'."\r\n";
        }
    }
    
    if (!isset($PAGES[$P]['NO_CALENDAR']) || (isset($PAGES[$P]['NO_CALENDAR']) && $PAGES[$P]['NO_CALENDAR'] == 0))
    {
        echo '<link href="'. $this->getDesignUrl() .'/js/jscalendar-1.0/calendar-jc.css" rel="stylesheet" type="text/css">'."\r\n";
        echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/jscalendar-1.0/calendar.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/jscalendar-1.0/lang/calendar-fr.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/jscalendar-1.0/calendar-setup.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/jscalendar-1.0/calendar_functions.js"></SCRIPT>'."\r\n";
    }
if ($P == 'C_AJAX') // connexion ldap
    echo '<script type="text/javascript" src="'.$this->designUrl.'/js/connexion.js"></SCRIPT>'."\r\n";

if ($this->activeSigAdresse == true)
{
    echo '<script type="text/javascript" src="'.JS_SIG_ADRESSE_URL.'/sig_adresse_autocomplete.js"></script>'."\r\n";
}

if (isset($PAGES[$P]['HEAD_JAVASCRIPT']) && $PAGES[$P]['HEAD_JAVASCRIPT'] != '')
{
    echo '<script type="text/javascript">'."\r\n";
    echo $PAGES[$P]['HEAD_JAVASCRIPT']."\r\n";
    echo '</script>'."\r\n";
}

echo '</head>'."\r\n";
echo '<body';

if ( isset($PAGES[$P]['ON_LOAD']) )
    echo ' onload=' . $PAGES[$P]['ON_LOAD'];
    
if (isset($PAGES[$P]['ON_BLUR']))
    echo ' onblur=' . $PAGES[$P]['ON_BLUR'];

if ( isset($PAGES[$P]['HEADER_NO_SPACE']) && $PAGES[$P]['HEADER_NO_SPACE'] == 1)
    echo ' style="margin:0; padding:0;"';

$projetNom = '';
$projetVersion = '';
if (defined('PROJET_AFF_NOM') && PROJET_AFF_NOM != '')
    $projetNom = PROJET_AFF_NOM;
if (defined('PROJET_AFF_VERSION') && PROJET_AFF_VERSION != '')
    $projetVersion = PROJET_AFF_VERSION;

echo ' >'."\r\n";

if ( !isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
{
    
    echo '<a href="#top" id="gototop" class="no-click no-print">Haut de page</a>';
    echo '<a name="top"></a>';
    echo '<script type="text/javascript">';
    echo "window.addEvent('domready',function() {
	/* smooth */
	new SmoothScroll({duration:500});
	
	/* link management */
	$('gototop').set('opacity','0').setStyle('display','block');
	
	/* scrollspy instance */
	var ss = new ScrollSpy({
		min: 200,
		onEnter: function(position,state,enters) {
			$('gototop').fade('in');
		},
		onLeave: function(position,state,leaves) {
			$('gototop').fade('out');
		},
		container: window
	});
});";
    echo '</script>';
    
    // Vérification si un message important à afficher existe...
    if (isset($this->messageInformation['DATE']) && time()<$this->messageInformation['DATE'])
    {
        $color = 'red';
        if (isset($this->messageInformation['COLOR']) && $this->messageInformation['COLOR'] != '')
            $color = $this->messageInformation['COLOR'];
        
        // il existe un message et la date de fin de ce message n'est pas dépassé
        echo    '<div style="z-index:100;position:absolute;top:90px;left:10px;width:98%;height:20px;background-color:'.$color.';" id="zonePushLoggeeFRT">'.
                    '<marquee class="menuHaut" behavior="scroll" DIRECTION="left" height="20px" style="font-size:14px;color:#000000;" onmouseover="javascript:scroller1.stop()" onmouseout="javascript:scroller1.start()" id="scroller1" SCROLLDELAY="150" SCROLLAMOUT="1" bgcolor="'.$color.'">'.
                        '<b>'. $this->messageInformation['MESSAGE'] .'</b>'.
                    '</marquee>'.
                '</div>';
    }
    
    
    //echo '<div id="wrapper">
    //	<div id="header">
    //			<div id="joomla"><a href="index.php"><img border="0" id="imgTitre" width="'. $imageWidth .'" height="48" class="imgT" src="'.$image.'" title="Cliquez ici pour revenir à l\'accueil"></a>Gest-Asso<!--<img src="images/header_text.png" alt="Joomla! Logo" />--></div>
    //	</div>
    //	<div id="menu">'. $ch .'</div>
    //</div><br/><div id="wrapper_contenu"><div id="contenu">';
    
    $version = 'Version ';
    if (file_exists($DATA_PATH.'/revision.php'))
    {
        include($DATA_PATH.'/revision.php');
        $version .= number_format($revision, 0, '', '.');
    }
    else
        if (SERVEUR_PROD == 'SMAGELLAN'){
            $version = '';
        }else{
            $version .= '?? => Vous devez être en local';
        }
       //$version .= '?? => Vous devez être en local';
    
    $divApplication = '';
    
    if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
    {
        //echo $_SESSION[PROJET_NAME]['agent_ldap']['login'];
        if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','cattierl','torrentf','bonoc','adinanid','paulp','villaj')))
            $isDevInformatique = true;
        else
            $isDevInformatique = false;
        if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','fitzailos','villaj','cattierl','filliardl','boublenzai','bonoc','adinanid','paulp')))
            $isUserGrantedToModifyMessage = true;
        else
            $isUserGrantedToModifyMessage = false;
        
        if ($isUserGrantedToModifyMessage == false) // on récupère la valeur mis en dur pour des agents admin du site
            $isUserGrantedToModifyMessage = getUserCanModifyAlerteMessage();

        
        $chDeco = ($isDevInformatique ? '<a href="index.php?P=L">Logs</a>&nbsp;|&nbsp;':'').
                  ($isUserGrantedToModifyMessage ? '<a href="index.php?P=A">Message</a>&nbsp;|&nbsp;':'');
        
        
        
        // Affichage de la liste des sites accéssibles par l'utilisateur
        if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1 && $this->afficheMenuApplication == true)
        {
            // version SELECT standard
            $select = '<select onchange="javascript:if (this.value != \'\'){window.location=this.value;}" name="menuapp">';
            $nb = 0;
            if (isset($_SESSION[PROJET_NAME]['application_user']))
            {
                foreach($_SESSION[PROJET_NAME]['application_user'] as $k => $tabProjet)
                {
                    $select .= '<option value="">:: '.$k.'</option>';
                    $projetIdCourant = '';
                    $i = 0;
                    
                    // tri du tableau des projets
                    $tabTemp = array();
                    foreach($tabProjet as $k => $v)
                    {
                        $tabTemp[$k] = $v['PROJET_LIBELLE'];
                    }
                    asort($tabTemp);
                    $newTab = array();
                    foreach($tabTemp as $k => $v)
                    {
                        $newTab[] = $tabProjet[$k];
                    }
                    $tabProjet = $newTab;
                    foreach($tabProjet as $v)
                    {
                        if ($projetIdCourant != $v['PROJET_ID'])
                        {
                            $colorFond = $i%2 == 0 ? '#D1EFBB':'#FFFFDD';
                            $colorTxt = $i%2 == 0 ? '#2F2F2F':'#2F2F2F';
                            $i++;
                            $projetIdCourant = $v['PROJET_ID'];
                        }
                        
                        $select .= '<option style="background-color:'.$colorFond.';color:'.$colorTxt.';" value="'.$v['PROJET_URL'].'">'.$v['PROJET_LIBELLE'].'</option>';
                        $nb++;
                    }
                }
                $select .= '</select>';
            }
            // FIN version SELECT standard
            
            // version avec survol de souris
            $select = '';
            $nb = 0;
            if (isset($_SESSION[PROJET_NAME]['application_user']))
            {
                foreach($_SESSION[PROJET_NAME]['application_user'] as $k => $tabProjet)
                {
                    $select .= '<div class="chromestyle" id="chromemenu">
                                    <ul>
                                        <li><a href="#" rel="dropmenu1">'.$k.'</a></li>
                                    </ul>
                                </div><div id="dropmenu1" class="dropmenudiv">';
                    $projetIdCourant = '';
                    $i = 0;
                    
                    // tri du tableau des projets
                    $tabTemp = array();
                    foreach($tabProjet as $k => $v)
                    {
                        $tabTemp[$k] = $v['PROJET_LIBELLE'];
                    }
                    asort($tabTemp);
                    $newTab = array();
                    foreach($tabTemp as $k => $v)
                    {
                        $newTab[] = $tabProjet[$k];
                    }
                    $tabProjet = $newTab;
//                    print_jc($tabProjet);
                    foreach($tabProjet as $v)
                    {
                        if ($projetIdCourant != $v['PROJET_ID'])
                        {
                            $colorFond = $i%2 == 0 ? '#D1EFBB':'#FFFFDD';
                            $colorTxt = $i%2 == 0 ? '#2F2F2F':'#2F2F2F';
                            $i++;
                            $projetIdCourant = $v['PROJET_ID'];
                        }
                        
                        $select .= '<a class="v'.($i%2).'" href="'.$v['PROJET_URL'].'">'.$v['PROJET_LIBELLE'].'</a>';
                        $nb++;
                    }
                }
                $select .= '</div>';
            }
            // FIN version avec survol de souris
            
            if ($nb > 1)
            {
                $divApplication .= '<span class="applicationmenu">'. $select .'</span>';
                $divApplication .= '<script type="text/javascript">
                                    cssdropdown.startchrome("chromemenu");
                                    </script>';
            }
        }
    }
    else
    {
        $chDeco = '';
    }
    
    $linkSupportDSI = $this->getLinkToSupportDSI();
    
    echo '<div id="border-top">'."\r\n".
    		"\t".'<div>'."\r\n".
    			"\t"."\t".'<div>'."\r\n".
    				"\t"."\t"."\t".'<span class="version">'.$chDeco.'<a href="index.php?P=H">'. $version .'</a></span>'."\r\n".
    				"\t"."\t"."\t".'<span class="title">'.(defined('PROJET_TITRE') ? PROJET_TITRE:'No PROJET_TITRE defined').$linkSupportDSI.'</span>'."\r\n".
    			"\t"."\t".'</div>'."\r\n".
    		"\t".'</div>'."\r\n".
    	'</div>'."\r\n";
    
    // Texte à droite (déconnexion, users connectés...)
    echo '<div id="header-box">'."\r\n";
    echo "\t".'<!-- Texte à droite, user connectés / bouton déconnexion -->'."\r\n".
    		"\t".'<div id="module-status">'."\r\n";
    			//'<span class="preview"><a href="http://10.128.10.221/joomla/" target="_blank">Prévisualiser</a></span>'.
    			//'<a href="index.php?option=com_messages"><span class="no-unread-messages">0</span></a>'.
    
    
    echo $divApplication;
    
    // Affichage du nombre de personne connecté sur le site
    if ($PROD == 1 && isset($PROJET_ID) && $PROJET_ID != '' && $this->affichePersonneConnecte == true)
    {
        if (!$gestionProjet->isConnected())
            $gestionProjet->connexion();
    
        if ($gestionProjet->isConnected())
        {
            $nbVisiteur = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID);
            $nbVisiteurToday = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID, 'today');
    
            // Chaine contenant le détail des visiteurs actuellement sur le site
            $tabVisiteur = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID);
            $chVisiteur = '';
            $nbMaxAffichage = 15;
            $i = 0;
            foreach($tabVisiteur as $k => $v)
            {
                if ($i == $nbMaxAffichage)
                {
                    $chVisiteur .= '<br>...';
                    break;
                }
                if ($chVisiteur != '')
                    $chVisiteur .= '<br>';
                if ($v['USER'] == '')
                    $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'].'</strong>';
                else
                    $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                $chVisiteur .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                $i++;
            }
            if ($chVisiteur != '')
                $chVisiteur = '<br>'.$chVisiteur;
            
            // Chaine contenant le détail des visiteurs d'aujourd'hui
            $tabVisiteurToday = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID, 'today');
            $chVisiteurToday = '';
            $i = 0;
            foreach($tabVisiteurToday as $k => $v)
            {
                if ($i == $nbMaxAffichage)
                {
                    $chVisiteurToday .= '<br>...';
                    break;
                }
                if ($chVisiteurToday != '')
                    $chVisiteurToday .= '<br>';
                if ($v['USER'] == '')
                    $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'] .'</strong>';
                else
                    $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                $chVisiteurToday .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                $i++;
            }
            if ($chVisiteurToday != '')
                $chVisiteurToday = '<br>'.$chVisiteurToday;
    
            echo        "\t"."\t".'<span class="loggedin-users"><a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont <strong>actuellement présentes</strong> sur cette application'.$chVisiteur.'">'.$nbVisiteur.'</a>'.
                        ' / '.
                        '<a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont venu sur cette application <strong>aujourd\'hui</strong>'.$chVisiteurToday.'">'.$nbVisiteurToday.'</a></span>'."\r\n";
               //echo '<span class="loggedin-users">185</span>';
        }
    }
    
    
    if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
    {
        echo    "\t"."\t".'<span class="logout"><a title="Se <strong>déconnecter</strong> de l\'application" href="index.php?action=logout">Déconnexion</a></span>'."\r\n";
    }
    echo    "\t".'</div>'."\r\n";
    echo "\t".'<!-- Fin Texte à droite, user connectés / bouton déconnexion -->'."\n\n";
    
    // menu
    if (isset($MENU) && count($MENU)>0 )
    {
        echo "\t".'<!-- Menu avec survol -->'."\r\n";
        echo "\t".'<div id="module-menu">'."\r\n".
        	    "\t"."\t".'<ul id="menu" >'."\r\n";
        foreach($MENU as $menuHaut)
        {
            echo "\t"."\t"."\t".'<li class="node"><a'.
            (isset($menuHaut['LIEN']) && strlen($menuHaut['LIEN']) > 0 ? ' href="'. $menuHaut['LIEN'] .'"':'').
            (isset($menuHaut['TITLE']) && strlen($menuHaut['TITLE']) > 0 ? ' title="'. $menuHaut['TITLE'] .'"':'').
            (isset($menuHaut['TARGET']) && strlen($menuHaut['TARGET']) > 0 ? ' target="'. $menuHaut['TARGET'] .'"':'').
            '>'. $menuHaut['LIBELLE'] .'</a>'."\r\n";
            
            // vérification s'il existe un sousmenu
            $sousMenu = isset($menuHaut['SMENU']) ? $menuHaut['SMENU']:array();
            
            echo "\t"."\t"."\t"."\t".'<ul>'."\r\n";
            foreach($sousMenu as $menu)
            {
                
                
                if (isset($menu['SEPARATEUR']) && $menu['SEPARATEUR'] == 1)
                    echo "\t"."\t"."\t"."\t"."\t".'<li class="separator"><span></span></li>'."\r\n";
                else
                {
                    // vérification s'il existe un sous sousmenu
                    $sousSousMenu = isset($menu['SMENU']) ? $menu['SMENU']:array();
                    
                    echo "\t"."\t"."\t"."\t"."\t".'<li'.
                    (count($sousSousMenu)>0 ? ' class="node"':'').
                    '><a '.
                    (isset($menu['CLASS']) && strlen($menu['CLASS']) > 0 ? ' class="'. $menu['CLASS'] .'"':'').
                    (isset($menu['TITLE']) && strlen($menu['TITLE']) > 0 ? ' title="'. $menu['TITLE'] .'"':'').
                    (isset($menu['TARGET']) && strlen($menu['TARGET']) > 0 ? ' target="'. $menu['TARGET'] .'"':'').
                    ' href="'.$menu['LIEN'].'">'.$menu['LIBELLE'].'</a>'."\r\n";
                    
                    if (count($sousSousMenu) > 0)
                    {
                        echo "\t"."\t"."\t"."\t"."\t"."\t".'<ul>'."\r\n";
                        foreach($sousSousMenu as $ssmenu)
                        {
                            if (isset($ssmenu['SEPARATEUR']) && $ssmenu['SEPARATEUR'] == 1)
                                echo "\t"."\t"."\t"."\t"."\t".'<li class="separator"><span></span></li>'."\r\n";
                            else
                                echo "\t"."\t"."\t"."\t"."\t".'<li><a '.
                                    (isset($ssmenu['CLASS']) && strlen($ssmenu['CLASS']) > 0 ? ' class="'. $ssmenu['CLASS'] .'"':'').
                                    (isset($ssmenu['TITLE']) && strlen($ssmenu['TITLE']) > 0 ? ' title="'. $ssmenu['TITLE'] .'"':'').
                                    (isset($ssmenu['TARGET']) && strlen($ssmenu['TARGET']) > 0 ? ' target="'. $ssmenu['TARGET'] .'"':'').
                                    ' href="'.$ssmenu['LIEN'].'">'.$ssmenu['LIBELLE'].'</a></li>'."\r\n";
                        }
                        echo "\t"."\t"."\t"."\t"."\t"."\t".'</ul>'."\r\n";
                    }
                    echo '</li>'."\r\n";
                }
            }
            echo "\t"."\t"."\t"."\t".'</ul>'."\r\n";
            
            echo "\t"."\t"."\t".'</li>'."\r\n";
        }
        
        echo         "\t"."\t".'</ul>'."\r\n".
        		"\t".'</div>'."\r\n";
        
        echo "\t".'<!-- Fin Menu avec survol -->'."\n\n";
    }
    else
    {
        echo "\t".'<!-- Menu avec survol -->'."\r\n";
        echo "\t".'<div id="module-menu">'."\r\n".
        	    "\t"."\t".'<ul id="menu" >'."\r\n";
        echo         "\t"."\t".'</ul>'."\r\n".
        		"\t".'</div>'."\r\n";
    }
       
    
    echo    "\t".'<div class="clr"></div>'."\r\n";
    
    // Fin du div id="header-box"
    echo '</div>'."\r\n";
    
    
    // Définition du titre de la page, l'image
    $ch = '';
    $continuer = true;
    $num = $P;
    $titre = $description = '';
    $image = $GENERAL_URL.'/images/default.gif'; // Image par défaut
    $imageWidth = 48;
    while ($continuer)
    {
        //echo ' ['.$num.'] ';
        $param = "";
        if ($ch == '')
        {
            $ch = "" . $PAGES[$num]['TITRE'] . "";
            $titre = $PAGES[$num]['TITRE'];
            if (isset($PAGES[$num]['DESCRIPTION']))
                $description = $PAGES[$num]['DESCRIPTION'];
            if (isset($PAGES[$num]['IMAGE']))
            {
                if (basename($PAGES[$num]['IMAGE']) != $PAGES[$num]['IMAGE']) // Image en prod
                    $image = $PAGES[$num]['IMAGE'];
                else
                    $image = $GENERAL_URL.'/images/'.$PAGES[$num]['IMAGE']; // Image en local au projet
    		    $imageWidth = (isset($PAGES[$num]['IMAGE_WIDTH']) && $PAGES[$num]['IMAGE_WIDTH'] != '') ? $PAGES[$num]['IMAGE_WIDTH']:$imageWidth;
            }
        }
        else
        {
            $variablesLien = '';
            if (isset($PAGES[$num]['VARIABLES']) && is_array($PAGES[$num]['VARIABLES']))
            {
                foreach($PAGES[$num]['VARIABLES'] as $nomVariable)
                {
                    eval('global $' . $nomVariable . ';');
                    eval('$'.'value = $' . $nomVariable . ';');
                    if ($value != '')
                    $variablesLien .= '&'.$nomVariable.'='.$value;
                }
            }
            
            if (isset($PAGES[$num]['URL_REWRITING']) && $PAGES[$num]['URL_REWRITING'] != '')
            {
                $link = $PAGES[$num]['URL_REWRITING'];
            }
            else
                $link = 'index.php?P=' . $num . $variablesLien;
            $ch = "<a class=\"navigation\" href=\"". $link ."\">" . $PAGES[$num]["TITRE"] . "</a>" . " <span class='navigation'>></span> " . $ch;
        }
        if (is_numeric($num) && $num == 0 || is_numeric($num) && $num == $this->numPageAccueil) // Si l'on est sur le numéro de la page d'accueil => Arret
        {
            $continuer = false;
            //echo 'A';
        }
        else
        {
            if (is_numeric($num))
            {
                $num = intval($num/$this->pageSaut);
                //echo 'B';
            }
            else
            {
                $num = $this->numPageAccueil;
                //echo 'C';
            }
        }
    }
    echo    '<div id="content-box">'."\r\n".
                "\t".'<div class="border">'."\r\n".
                    "\t"."\t".'<div class="padding">'."\r\n";
    if (!isset($PAGES[$P]['NO_NAVIGATION_BAR']) || (isset($PAGES[$P]['NO_NAVIGATION_BAR']) && $PAGES[$P]['NO_NAVIGATION_BAR']== 0))
    {
        echo                    "\t"."\t"."\t".'<div id="toolbar-box">'."\r\n".
                                "\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
        						    "\t"."\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
        							    "\t"."\t"."\t"."\t"."\t"."\t".'<div class="t"></div>'."\r\n".
        						    "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
                                "\t"."\t"."\t"."\t".'</div>'."\r\n".
                                "\t"."\t"."\t"."\t".'<div class="m">'."\r\n";
    
        
        // On affiche les boutons (de droite)
        if (isset($BOUTTONS) && count($BOUTTONS) > 0)
        {
            echo    "\t"."\t"."\t"."\t"."\t".'<div class="toolbar" id="toolbar">'."\r\n".
                        "\t"."\t"."\t"."\t"."\t"."\t".'<table class="toolbar"><tr>'."\r\n";
            
            foreach($BOUTTONS as $v)
            {
                echo    "\t"."\t"."\t"."\t"."\t"."\t"."\t".'<td class="button" id="toolbar-cancel">'.
                        '<a ';
                
                if (isset($v['HREF']) && $v['HREF'] != '')
                    echo 'href="'.$v['HREF'].'" ';
                
                if (isset($v['ACTION']) && $v['ACTION'] != '')
                    echo 'onclick="'.$v['ACTION'].'" ';
                    
                if (isset($v['ID']) && $v['ID'] != '')
                    echo 'id="'.$v['ID'].'" ';
                
                if (isset($v['CLASS']) && $v['CLASS'] != '')
                    echo 'class="'.$v['CLASS'].'" ';
                    
                if (isset($v['ACTION']) && $v['ACTION'] != '' && ((!isset($v['HREF']) || (isset($v['HREF']) && $v['HREF'] == ''))))
                    echo 'href="#" ';
                    
                if (isset($v['TARGET']) && $v['TARGET'] != '')
                    echo 'target="'.$v['TARGET'].'" ';
    
                echo 'class="toolbar" title="'.$v['TITLE'].'">'.
                               '<span class="icon-32-cancel" style="background-image: url('.$v['IMG'].');"></span>'.
                                $v['TXT'].
                            '</a>'.
                        '</td>'."\r\n";
            }
            echo "\t"."\t"."\t"."\t"."\t"."\t".'</tr></table>'."\r\n".
                "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n";
        }
    
        // Affichage du titre de la page
        echo "\t"."\t"."\t"."\t"."\t".'<div class="header" style="background-image: url('.$image.');">'.
                $ch.
             '</div>'."\r\n";
    
        echo "\t"."\t"."\t"."\t"."\t".'<div class="clr"></div>'."\r\n";
        
        echo "\t"."\t"."\t"."\t".'</div>'."\r\n".
             "\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
            "\t"."\t"."\t"."\t"."\t"."\t".'<div class="b"></div>'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t".'<div class="clr"></div>'."\r\n";
    }
    
        //"\t"."\t".'</div>'."\r\n".
        //"\t".'</div>'."\r\n".
    	//    '</div>'."\r\n";
    	    
    echo    //"\t"."\t"."\t".'<div id="element-box">'."\r\n".
            //"\t"."\t"."\t"."\t".'<div class="border">'."\r\n".
            //"\t"."\t"."\t"."\t"."\t".'<div class="padding">'."\r\n".
            "\t"."\t"."\t".'<div id="element-box">'."\r\n".
            "\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
            "\t"."\t"."\t"."\t"."\t"."\t".'<div class="t"></div>'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'<div class="m" >'."\r\n";
}
    }
    
    /**
     *
     * Affiche le Footer d'une page en version 2.0
     * 
     */
    private function afficheFooterVersion2_0()
    {
        
        global $PAGES, $P, $PROD, $tabTempsDesPages;
        $this->timeFin = getMicroTime();
        $t = number_format($this->timeFin - $this->timeDebut, 3, '.', ' ');
        
        $infosSurExecutionTime = '';
        if (isset($tabTempsDesPages) && isset($tabTempsDesPages['common_start']))
        {
            $t = number_format($this->timeFin - $tabTempsDesPages['common_start'], 3, '.', ' ');
            
            if (isset($tabTempsDesPages['common_modules_end']))
            {
                $infosSurExecutionTime .=    'Inclusion des modules du common : '.
                                            '<font color=#008000><b>'.
                                            number_format($tabTempsDesPages['common_modules_end'] - $tabTempsDesPages['common_modules_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_stats_connexion_end']))
            {
                $infosSurExecutionTime .=    '<br>Connexion a la base de logs du common : '.
                                            '<font color=#008000><b>'.
                                            number_format($tabTempsDesPages['common_stats_connexion_end'] - $tabTempsDesPages['common_stats_connexion_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_end']))
            {
                $infosSurExecutionTime .=    '<br>Temps total du common : '.
                                            '<font color=#008000><b>'.
                                            number_format($tabTempsDesPages['common_end'] - $tabTempsDesPages['common_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_end']))
            {
                $infosSurExecutionTime .=    '<br>Temps de génération de la page du projet : '.
                                            '<font color=#008000><b>'.
                                            number_format($this->timeFin - $tabTempsDesPages['common_end'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_start']))
            {
                $infosSurExecutionTime .=    '<br>Temps total de la page complète : '.
                                            '<font color=#008000><b>'.
                                            number_format($this->timeFin - $tabTempsDesPages['common_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            
        }
        
        if ( !isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {
        echo    "\t"."\t"."\t"."\t"."\t".'<div class="clr"></div>'."\r\n".
                "\t"."\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
        		"\t"."\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
        		"\t"."\t"."\t"."\t"."\t"."\t".'<div class="b"></div>'."\r\n".
        		"\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t".'<div class="clr"></div>'."\r\n".
        		"\t"."\t".'</div>'."\r\n".
        		"\t"."\t".'<div class="clr"></div>'."\r\n".
        		"\t".'</div>'."\r\n".
        	    '</div>'."\r\n";
        	
        

echo    '<div id="border-bottom"><div><div></div></div></div>'."\r\n".
	    '<div id="footer">'."\r\n".
		    "\t".'<p class="copyright">'.
			    '© '.date('Y').' Direction des Systèmes Informatiques | Génération de la page : '.
			    ($infosSurExecutionTime != '' ? '<a href="#" title="'.$infosSurExecutionTime.'">':'').
			    '<font color=#008000><b>'. $t .'</b></font>'.
			    ($infosSurExecutionTime != '' ? '</a>':'').
			    ' sec.'.
			    ' | Nombre de requêtes SQL : <font color=#008000><b>'. $this->requeteQuantite .'</b></font> ';

/*
if (date('Y') == '2011' && date('m') == '1')
{
    echo '<br><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="550" height="150">
<param name="movie" value="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf">
<param name="quality" value="high">
<embed src="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="550" height="150"></embed></object>';
}
*/
			    //' | Temps d\'exécution des requêtes SQL : <font color=#008000><b>'. number_format($this->requeteTemps, 3, '.', ' ') .'</b></font> sec.'.
echo 			'</p>'."\r\n".
	    '</div>'."\r\n";
//if ($PROD == 1)
//{
//    echo '<script language="JavaScript">'."\r\n";
//    echo 'var s=\'<img src="http://projets.prod.intranet/index.php?P=13\';'."\r\n";
//    echo 'if(parseFloat(navigator.appVersion)>=4)'."\r\n";
//    echo '{'."\r\n";
//    echo 's += \'&ew=\' + screen.width + \'&eh=\' + screen.height;'."\r\n";
//    echo '}'."\r\n";
//    echo 's += \'">\';'."\r\n";
//    echo 'document.writeln(s);'."\r\n";
//    echo '</script>'."\r\n";
//}
        }
        echo    ''.
            '</body>'.
            '</html>';
    }

    
    function getLinkToSupportDSI()
    {
        global $PROJET_ID;
        if ($PROJET_ID != '')
            $linkSupportDSI = '&nbsp;&nbsp;<a title="Vous rencontrez un <b>problème sur ce logiciel</b> ?<br><br><b>Cliquez ici</b> pour demander de l\'aide au <b>support informatique</b>." href="http://web2.intranet/supportdsi/nouveau-ticket-'.$PROJET_ID.'.html" target="_blank">'.
            '<img src="'. $this->designUrl .'/js/support_dsi_32.png" align="absmiddle" border="0">'.
            '</a>';
        else
            $linkSupportDSI = '';
        return $linkSupportDSI;
    }
    /**
     *
     * Affiche le Header d'une page en version 3.0
     * 
     */
    private function afficheHeaderVersion3_0()
    {
        global $PAGES, $P, $GENERAL_URL, $IMAGE_URL, $MODULE_PATH, $JAVASCRIPTS, $ONGLETS, $PROJET_ID, $gestionProjet, $DATA_PATH, $BOUTTONS, $MENU, $CSS_TO_LOAD, $RSS, $PROD, $MOOTOOLS_1_5;
        if (!isset($PAGES[$P]['NO_DOCTYPE']) || (isset($PAGES[$P]['NO_DOCTYPE']) && $PAGES[$P]['NO_DOCTYPE']== 0))
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\r\n";
        
        
        echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />'."\r\n";

if (defined('META_DESCRIPTION') && META_DESCRIPTION != '')
{
    echo '<meta name="description" content="'.META_DESCRIPTION.'" />'."\r\n";
}

echo '<link rel="shortcut icon" type="image/x-icon" href="'.$GENERAL_URL.'/favicon.ico" />'."\r\n";

if ($this->faviconImage != '')
    echo '<link rel="icon" type="image/gif" href="'. $this->faviconImage .'" />'."\r\n";

echo '<title>'.$PAGES[$P]["TITRE"].'</title>'."\r\n";

if (isset($RSS))
{
    foreach($RSS as $v)
        echo '<link rel="alternate" type="application/rss+xml" title="'.$v['TITLE'].'" href="'.$v['HREF'].'" />'."\r\n";
}

if ($this->designHiver == true)
    echo '<link href="'. $this->getDesignUrl() .'/css/styles_hiver.css" rel="stylesheet" type="text/css">'."\r\n";
else
    echo '<link href="'. $this->getDesignUrl() .'/css/styles.css" rel="stylesheet" type="text/css">'."\r\n";


echo '<link href="'.$GENERAL_URL.'/'. $this->cssFileName .'" rel="stylesheet" type="text/css">'."\r\n";

if (isset($CSS_TO_LOAD))
{
    foreach($CSS_TO_LOAD as $v)
        echo '<link href="'.$v.'" rel="stylesheet" type="text/css">'."\r\n";
}

$t = array();
if (isset($JAVASCRIPTS))
{
    $t = array_map('basename', $JAVASCRIPTS);
}

if (!in_array('mootools.js', $t) && !isset($PAGES[$P]['NO_MOOTOOLS']) || (isset($PAGES[$P]['NO_MOOTOOLS']) && $PAGES[$P]['NO_MOOTOOLS']== 0))
{
//    echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools-1.2.1-core.js"></SCRIPT>'."\r\n";
    
//     echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools-core.js"></SCRIPT>'."\r\n";
//     echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools-more.js"></SCRIPT>'."\r\n";
    if (isset($MOOTOOLS_1_5) && $MOOTOOLS_1_5 == 1)
    {
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-core-1.5.1.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-more-1.5.1.js"></SCRIPT>'."\r\n";
    }
    else
    {
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-core-1.4.5-full-compat-yc.js"></SCRIPT>'."\r\n";
        echo '<script type="text/javascript" src="'. JS_MOOTOOLS_URL .'/mootools-more-1.4.0.1.js"></SCRIPT>'."\r\n";
    }
    echo '<script type="text/javascript" src="'.$this->designUrl.'/js/scrollspy.js"></SCRIPT>'."\r\n";
//    echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/mootools.js"></SCRIPT>'."\r\n";
    
}


if (isset($JAVASCRIPTS))
{
    foreach($JAVASCRIPTS as $v)
        echo '<script type="text/javascript" src="'.$v.'"></SCRIPT>'."\r\n";
    $t = array_map('basename', $JAVASCRIPTS);
}

if (!in_array('title.js', $t))
    echo '<script type="text/javascript" src="'.$this->designUrl.'/js/title.js"></SCRIPT>'."\r\n";
?>

<!--[if IE 7]>
<link href="<?=$this->getDesignUrl()?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lte IE 6]>
<link href="<?=$this->getDesignUrl()?>/css/ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->

<?
//    echo '<link href="'. $this->getDesignUrl() .'/css/rounded.css" rel="stylesheet" type="text/css">'."\r\n";
    //echo '<link href="'. $this->getDesignUrl() .'/js/jscalendar-1.0/calendar-green.css" rel="stylesheet" type="text/css">'."\r\n";
    
    if (!isset($PAGES[$P]['NO_MENU']) || (isset($PAGES[$P]['NO_MENU']) && $PAGES[$P]['NO_MENU'] == 0))
    {
        if (!isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {
//            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/menu.js"></SCRIPT>'."\r\n";
//            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/fat.js"></SCRIPT>'."\r\n";
//            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/index.js"></SCRIPT>'."\r\n";
//            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/fonctions.js"></SCRIPT>'."\r\n";
            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/chrome.js"></SCRIPT>'."\r\n";
        }
    }
    
    
    if ($this->activeCalendrier == true)
    {
        // inclusion du calendrier 
        echo '  <script src="'.JS_CALENDAR_URL.'/src/js/jscal2.js"></script>
                <script src="'.JS_CALENDAR_URL.'/src/js/lang/fr.js"></script>
                <link rel="stylesheet" type="text/css" href="'.JS_CALENDAR_URL.'/src/css/jscal2.css" />
                <link rel="stylesheet" type="text/css" href="'.JS_CALENDAR_URL.'/src/css/border-radius.css" />
                <link rel="stylesheet" type="text/css" href="'.JS_CALENDAR_URL.'/src/css/gold/gold.css" />';
    }
    
    if ($this->activeFormCheck == true)
    {
        // inclusion du formcheck
        echo '  <script src="'.JS_FORMCHECK_URL.'/lang/fr.js"></script>
        <script src="'.JS_FORMCHECK_URL.'/formcheck.js"></script>
        <link rel="stylesheet" type="text/css" href="'.JS_FORMCHECK_URL.'/theme/red/formcheck.css" />';
    }
    

if ($P == 'C_AJAX') // connexion ldap
    echo '<script type="text/javascript" src="'.$this->designUrl.'/js/connexion.js"></SCRIPT>'."\r\n";

if ($this->activeSigAdresse == true)
{
    echo '<script type="text/javascript" src="'.JS_SIG_ADRESSE_URL.'/sig_adresse_autocomplete.js"></script>'."\r\n";
}

if (isset($PAGES[$P]['HEAD_JAVASCRIPT']) && $PAGES[$P]['HEAD_JAVASCRIPT'] != '')
{
    echo '<script type="text/javascript">'."\r\n";
    echo $PAGES[$P]['HEAD_JAVASCRIPT']."\r\n";
    echo '</script>'."\r\n";
}

echo '</head>'."\r\n";
echo '<body';

if ( isset($PAGES[$P]['ON_LOAD']) )
    echo ' onload=' . $PAGES[$P]['ON_LOAD'];
    
if (isset($PAGES[$P]['ON_BLUR']))
    echo ' onblur=' . $PAGES[$P]['ON_BLUR'];

if ( isset($PAGES[$P]['HEADER_NO_SPACE']) && $PAGES[$P]['HEADER_NO_SPACE'] == 1)
    echo ' style="margin:0; padding:0;"';

$projetNom = '';
$projetVersion = '';
if (defined('PROJET_AFF_NOM') && PROJET_AFF_NOM != '')
    $projetNom = PROJET_AFF_NOM;
if (defined('PROJET_AFF_VERSION') && PROJET_AFF_VERSION != '')
    $projetVersion = PROJET_AFF_VERSION;

echo ' >'."\r\n";

if ( !isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
{
    
//    echo '<a href="#top" id="gototop" class="no-click no-print">Haut de page</a>';
//    echo '<a name="top"></a>';
//    echo '<script type="text/javascript">';
//    echo "window.addEvent('domready',function() {
//	/* smooth */
//	new SmoothScroll({duration:500});
//	
//	/* link management */
//	$('gototop').set('opacity','0').setStyle('display','block');
//	
//	/* scrollspy instance */
//	var ss = new ScrollSpy({
//		min: 200,
//		onEnter: function(position,state,enters) {
//			$('gototop').fade('in');
//		},
//		onLeave: function(position,state,leaves) {
//			$('gototop').fade('out');
//		},
//		container: window
//	});
//});";
//    echo '</script>';
    
    // Vérification si un message important à afficher existe...
    if (isset($this->messageInformation['DATE']) && time()<$this->messageInformation['DATE'])
    {
        $color = 'red';
        if (isset($this->messageInformation['COLOR']) && $this->messageInformation['COLOR'] != '')
            $color = $this->messageInformation['COLOR'];
        
        // il existe un message et la date de fin de ce message n'est pas dépassé
        echo    '<div style="z-index:100;position:absolute;top:90px;left:10px;width:98%;height:20px;background-color:'.$color.';" id="zonePushLoggeeFRT">'.
                    '<marquee class="menuHaut" behavior="scroll" DIRECTION="left" height="20px" style="font-size:14px;color:#000000;" onmouseover="javascript:scroller1.stop()" onmouseout="javascript:scroller1.start()" id="scroller1" SCROLLDELAY="150" SCROLLAMOUT="1" bgcolor="'.$color.'">'.
                        '<b>'. $this->messageInformation['MESSAGE'] .'</b>'.
                    '</marquee>'.
                '</div>';
    }
    
    
    //echo '<div id="wrapper">
    //	<div id="header">
    //			<div id="joomla"><a href="index.php"><img border="0" id="imgTitre" width="'. $imageWidth .'" height="48" class="imgT" src="'.$image.'" title="Cliquez ici pour revenir à l\'accueil"></a>Gest-Asso<!--<img src="images/header_text.png" alt="Joomla! Logo" />--></div>
    //	</div>
    //	<div id="menu">'. $ch .'</div>
    //</div><br/><div id="wrapper_contenu"><div id="contenu">';
    
    $version = 'Version ';
    if (file_exists($DATA_PATH.'/revision.php'))
    {
        include($DATA_PATH.'/revision.php');
        $version .= number_format($revision, 0, '', '.');
    }
    else
        if (SERVEUR_PROD == 'SMAGELLAN'){
            $version = '';
        }else{
            $version .= '?? => Vous devez être en local';
        }
       //$version .= '?? => Vous devez être en local';
    
    $divApplication = '';
    
    if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
    {
        //echo $_SESSION[PROJET_NAME]['agent_ldap']['login'];
        if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','cattierl','torrentf','bonoc','adinanid','paulp','villaj')))
            $isDevInformatique = true;
        else
            $isDevInformatique = false;
        if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','fitzailos','villaj','cattierl','filliardl','boublenzai','bonoc','adinanid','paulp')))
            $isUserGrantedToModifyMessage = true;
        else
            $isUserGrantedToModifyMessage = false;
        
        if ($isUserGrantedToModifyMessage == false) // on récupère la valeur mis en dur pour des agents admin du site
            $isUserGrantedToModifyMessage = getUserCanModifyAlerteMessage();

        $chDeco = ($isDevInformatique ? '<a href="index.php?P=L">Logs</a>&nbsp;|&nbsp;':'').
                  ($isUserGrantedToModifyMessage ? '<a href="index.php?P=A">Message</a>&nbsp;|&nbsp;':'');
        
        
        
        // Affichage de la liste des sites accéssibles par l'utilisateur
        if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1 && $this->afficheMenuApplication == true)
        {
            // version SELECT standard
            $select = '<select onchange="javascript:if (this.value != \'\'){window.location=this.value;}" name="menuapp">';
            $nb = 0;
            if (isset($_SESSION[PROJET_NAME]['application_user']))
            {
                foreach($_SESSION[PROJET_NAME]['application_user'] as $k => $tabProjet)
                {
                    $select .= '<option value="">:: '.$k.'</option>';
                    $projetIdCourant = '';
                    $i = 0;
                    
                    // tri du tableau des projets
                    $tabTemp = array();
                    foreach($tabProjet as $k => $v)
                    {
                        $tabTemp[$k] = $v['PROJET_LIBELLE'];
                    }
                    asort($tabTemp);
                    $newTab = array();
                    foreach($tabTemp as $k => $v)
                    {
                        $newTab[] = $tabProjet[$k];
                    }
                    $tabProjet = $newTab;
                    foreach($tabProjet as $v)
                    {
                        if ($projetIdCourant != $v['PROJET_ID'])
                        {
                            $colorFond = $i%2 == 0 ? '#D1EFBB':'#FFFFDD';
                            $colorTxt = $i%2 == 0 ? '#2F2F2F':'#2F2F2F';
                            $i++;
                            $projetIdCourant = $v['PROJET_ID'];
                        }
                        
                        $select .= '<option style="background-color:'.$colorFond.';color:'.$colorTxt.';" value="'.$v['PROJET_URL'].'">'.$v['PROJET_LIBELLE'].'</option>';
                        $nb++;
                    }
                }
                $select .= '</select>';
            }
            // FIN version SELECT standard
            
            // version avec survol de souris
            $select = '';
            $nb = 0;
            if (isset($_SESSION[PROJET_NAME]['application_user']))
            {
                foreach($_SESSION[PROJET_NAME]['application_user'] as $k => $tabProjet)
                {
                    $select .= '<div class="chromestyle" id="chromemenu">
                                    <ul>
                                        <li><a href="#" rel="dropmenu1">'.$k.'</a></li>
                                    </ul>
                                </div><div id="dropmenu1" class="dropmenudiv">';
                    $projetIdCourant = '';
                    $i = 0;
                    
                    // tri du tableau des projets
                    $tabTemp = array();
                    foreach($tabProjet as $k => $v)
                    {
                        $tabTemp[$k] = $v['PROJET_LIBELLE'];
                    }
                    asort($tabTemp);
                    $newTab = array();
                    foreach($tabTemp as $k => $v)
                    {
                        $newTab[] = $tabProjet[$k];
                    }
                    $tabProjet = $newTab;
//                    print_jc($tabProjet);
                    foreach($tabProjet as $v)
                    {
                        if ($projetIdCourant != $v['PROJET_ID'])
                        {
                            $colorFond = $i%2 == 0 ? '#D1EFBB':'#FFFFDD';
                            $colorTxt = $i%2 == 0 ? '#2F2F2F':'#2F2F2F';
                            $i++;
                            $projetIdCourant = $v['PROJET_ID'];
                        }
                        
                        $select .= '<a class="v'.($i%2).'" href="'.$v['PROJET_URL'].'">'.$v['PROJET_LIBELLE'].'</a>';
                        $nb++;
                    }
                }
                $select .= '</div>';
            }
            // FIN version avec survol de souris
            
            if ($nb > 1)
            {
                $divApplication .= '<span class="applicationmenu">'. $select .'</span>';
                $divApplication .= '<script type="text/javascript">
                                    cssdropdown.startchrome("chromemenu");
                                    </script>';
            }
        }
    }
    else
    {
        $chDeco = '';
    }
    
//    <div id="border-top" class="h_blue">
//		<span class="logo"><a href="http://www.joomla.org" target="_blank"><img src="templates/bluestork/images/logo.png" alt="Joomla!" /></a></span>
//		<span class="title"><a href="index.php">JC Administration</a></span>
//	</div>
	
    $linkSupportDSI = $this->getLinkToSupportDSI();
    
	//class="version" à la place du logo
    echo '<div id="border-top" class="h_blue">'."\r\n".
			"\t".'<span class="txtlogo">'.$chDeco.'<a href="index.php?P=H">'. $version .'</a></span>'."\r\n".
//		    "\t".'<span class="logo"><a href="http://www.intranet" target="_blank"><img src="'.$this->getDesignUrl().'/images/logo.png" /></a></span>'."\r\n".
            (defined('PROJET_LOGO') ? "\t".'<span class="logo">'.PROJET_LOGO.'</span>'."\r\n":'').
			"\t".'<span class="title"><a href="index.php">'.(defined('PROJET_TITRE') ? PROJET_TITRE:'No PROJET_TITRE defined').$linkSupportDSI.'</a></span>'."\r\n".
    	'</div>'."\r\n";
    
    // Texte à droite (déconnexion, users connectés...)
    echo '<div id="header-box">'."\r\n";
    echo "\t".'<!-- Texte à droite, user connectés / bouton déconnexion -->'."\r\n".
    		"\t".'<div id="module-status">'."\r\n";
    			//'<span class="preview"><a href="http://10.128.10.221/joomla/" target="_blank">Prévisualiser</a></span>'.
    			//'<a href="index.php?option=com_messages"><span class="no-unread-messages">0</span></a>'.
    
    
    echo $divApplication;
    
    // Affichage du nombre de personne connecté sur le site
    if (isset($PROJET_ID) && $PROJET_ID != '' && $this->affichePersonneConnecte == true)
    {
        if (!$gestionProjet->isConnected())
            $gestionProjet->connexion();
    
        if ($gestionProjet->isConnected())
        {
//            echo '<span class="loggedin-users">(0) Site</span><span class="backloggedin-users">(1) Administration</span><span class="no-unread-messages"><a href="/joomla/administrator/index.php?option=com_messages">Aucun message</a></span>
//			<span class="viewsite"><a href="http://127.0.0.1/joomla/" target="_blank">Voir le site</a></span><span class="logout"><a href="/joomla/administrator/index.php?option=com_login&amp;task=logout&amp;69e5eb3f76d130c1b0de9bd584cd6f15=1">Déconnexion</a></span>';
            $nbVisiteur = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID);
            $nbVisiteurToday = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID, 'today');
    
            // Chaine contenant le détail des visiteurs actuellement sur le site
            $tabVisiteur = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID);
            $chVisiteur = '';
            $nbMaxAffichage = 15;
            $i = 0;
            foreach($tabVisiteur as $k => $v)
            {
                if ($i == $nbMaxAffichage)
                {
                    $chVisiteur .= '<br>...';
                    break;
                }
                if ($chVisiteur != '')
                    $chVisiteur .= '<br>';
                if ($v['USER'] == '')
                    $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'].'</strong>';
                else
                    $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                $chVisiteur .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                $i++;
            }
            if ($chVisiteur != '')
                $chVisiteur = '<br>'.$chVisiteur;
            
            // Chaine contenant le détail des visiteurs d'aujourd'hui
            $tabVisiteurToday = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID, 'today');
            $chVisiteurToday = '';
            $i = 0;
            foreach($tabVisiteurToday as $k => $v)
            {
                if ($i == $nbMaxAffichage)
                {
                    $chVisiteurToday .= '<br>...';
                    break;
                }
                if ($chVisiteurToday != '')
                    $chVisiteurToday .= '<br>';
                if ($v['USER'] == '')
                    $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'] .'</strong>';
                else
                    $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                $chVisiteurToday .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                $i++;
            }
            if ($chVisiteurToday != '')
                $chVisiteurToday = '<br>'.$chVisiteurToday;
    
            echo        "\t"."\t".'<span class="loggedin-users"><a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont <strong>actuellement présentes</strong> sur cette application'.$chVisiteur.'">'.$nbVisiteur.'</a>'.
                        ' / '.
                        '<a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont venu sur cette application <strong>aujourd\'hui</strong>'.$chVisiteurToday.'">'.$nbVisiteurToday.'</a></span>'."\r\n";
               //echo '<span class="loggedin-users">185</span>';
        }
        
        
    }
    
    if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
    {
        // Récupération des messages
        echo '<span class="no-unread-messages"><a title="Vous avez aucun message non lu envoyé par les applications" href="index.php">Aucun message</a></span>';
        
        echo    "\t"."\t".'<span class="logout"><a title="Se <strong>déconnecter</strong> de l\'application" href="index.php?action=logout">Déconnexion</a></span>'."\r\n";
    }
    echo    "\t".'</div>'."\r\n";
    echo "\t".'<!-- Fin Texte à droite, user connectés / bouton déconnexion -->'."\n\n";
    
    // menu
    if (isset($MENU) && count($MENU)>0 )
    {
        echo "\t".'<!-- Menu avec survol -->'."\r\n";
        echo "\t".'<div id="module-menu">'."\r\n".
        	    "\t"."\t".'<ul id="menu" >'."\r\n";
        foreach($MENU as $menuHaut)
        {
            echo "\t"."\t"."\t".'<li class="node"><a'.
            (isset($menuHaut['LIEN']) && strlen($menuHaut['LIEN']) > 0 ? ' href="'. $menuHaut['LIEN'] .'"':'').
            (isset($menuHaut['TITLE']) && strlen($menuHaut['TITLE']) > 0 ? ' title="'. $menuHaut['TITLE'] .'"':'').
            (isset($menuHaut['TARGET']) && strlen($menuHaut['TARGET']) > 0 ? ' target="'. $menuHaut['TARGET'] .'"':'').
            '>'. $menuHaut['LIBELLE'] .'</a>'."\r\n";
            
            // vérification s'il existe un sousmenu
            $sousMenu = isset($menuHaut['SMENU']) ? $menuHaut['SMENU']:array();
            
            echo "\t"."\t"."\t"."\t".'<ul>'."\r\n";
            foreach($sousMenu as $menu)
            {
                
                
                if (isset($menu['SEPARATEUR']) && $menu['SEPARATEUR'] == 1)
                    echo "\t"."\t"."\t"."\t"."\t".'<li class="separator"><span></span></li>'."\r\n";
                else
                {
                    // vérification s'il existe un sous sousmenu
                    $sousSousMenu = isset($menu['SMENU']) ? $menu['SMENU']:array();
                    
                    echo "\t"."\t"."\t"."\t"."\t".'<li'.
                    (count($sousSousMenu)>0 ? ' class="node"':'').
                    '><a '.
                    (isset($menu['CLASS']) && strlen($menu['CLASS']) > 0 ? ' class="'. $menu['CLASS'] .'"':'').
                    (isset($menu['TITLE']) && strlen($menu['TITLE']) > 0 ? ' title="'. $menu['TITLE'] .'"':'').
                    (isset($menu['TARGET']) && strlen($menu['TARGET']) > 0 ? ' target="'. $menu['TARGET'] .'"':'').
                    ' href="'.$menu['LIEN'].'">'.$menu['LIBELLE'].'</a>'."\r\n";
                    
                    if (count($sousSousMenu) > 0)
                    {
                        echo "\t"."\t"."\t"."\t"."\t"."\t".'<ul>'."\r\n";
                        foreach($sousSousMenu as $ssmenu)
                        {
                            if (isset($ssmenu['SEPARATEUR']) && $ssmenu['SEPARATEUR'] == 1)
                                echo "\t"."\t"."\t"."\t"."\t".'<li class="separator"><span></span></li>'."\r\n";
                            else
                                echo "\t"."\t"."\t"."\t"."\t".'<li><a '.
                                    (isset($ssmenu['CLASS']) && strlen($ssmenu['CLASS']) > 0 ? ' class="'. $ssmenu['CLASS'] .'"':'').
                                    (isset($ssmenu['TITLE']) && strlen($ssmenu['TITLE']) > 0 ? ' title="'. $ssmenu['TITLE'] .'"':'').
                                    (isset($ssmenu['TARGET']) && strlen($ssmenu['TARGET']) > 0 ? ' target="'. $ssmenu['TARGET'] .'"':'').
                                    ' href="'.$ssmenu['LIEN'].'">'.$ssmenu['LIBELLE'].'</a></li>'."\r\n";
                        }
                        echo "\t"."\t"."\t"."\t"."\t"."\t".'</ul>'."\r\n";
                    }
                    echo '</li>'."\r\n";
                }
            }
            echo "\t"."\t"."\t"."\t".'</ul>'."\r\n";
            
            echo "\t"."\t"."\t".'</li>'."\r\n";
        }
        
        echo         "\t"."\t".'</ul>'."\r\n".
        		"\t".'</div>'."\r\n";
        
        echo "\t".'<!-- Fin Menu avec survol -->'."\n\n";
    }
    else
    {
        echo "\t".'<!-- Menu avec survol -->'."\r\n";
        echo "\t".'<div id="module-menu">'."\r\n".
        	    "\t"."\t".'<ul id="menu" >'."\r\n";
        echo         "\t"."\t".'</ul>'."\r\n".
        		"\t".'</div>'."\r\n";
    }
       
    
    echo    "\t".'<div class="clr"></div>'."\r\n";
    
    // Fin du div id="header-box"
    echo '</div>'."\r\n";
    
    
    // Définition du titre de la page, l'image
    $ch = '';
    $continuer = true;
    $num = $P;
    $titre = $description = '';
    $image = $GENERAL_URL.'/images/default.gif'; // Image par défaut
    $imageWidth = 48;
    while ($continuer)
    {
        //echo ' ['.$num.'] ';
        $param = "";
        if ($ch == '')
        {
            $ch = "" . $PAGES[$num]['TITRE'] . "";
            $titre = $PAGES[$num]['TITRE'];
            if (isset($PAGES[$num]['DESCRIPTION']))
                $description = $PAGES[$num]['DESCRIPTION'];
            if (isset($PAGES[$num]['IMAGE']))
            {
                if (basename($PAGES[$num]['IMAGE']) != $PAGES[$num]['IMAGE']) // Image en prod
                    $image = $PAGES[$num]['IMAGE'];
                else
                    $image = $GENERAL_URL.'/images/'.$PAGES[$num]['IMAGE']; // Image en local au projet
    		    $imageWidth = (isset($PAGES[$num]['IMAGE_WIDTH']) && $PAGES[$num]['IMAGE_WIDTH'] != '') ? $PAGES[$num]['IMAGE_WIDTH']:$imageWidth;
            }
        }
        else
        {
            $variablesLien = '';
            if (isset($PAGES[$num]['VARIABLES']) && is_array($PAGES[$num]['VARIABLES']))
            {
                foreach($PAGES[$num]['VARIABLES'] as $nomVariable)
                {
                    eval('global $' . $nomVariable . ';');
                    eval('$'.'value = $' . $nomVariable . ';');
                    if ($value != '')
                    $variablesLien .= '&'.$nomVariable.'='.$value;
                }
            }
            
            if (isset($PAGES[$num]['URL_REWRITING']) && $PAGES[$num]['URL_REWRITING'] != '')
            {
                $link = $PAGES[$num]['URL_REWRITING'];
            }
            else
                $link = 'index.php?P=' . $num . $variablesLien;
            $ch = "<a class=\"navigation\" href=\"". $link ."\">" . $PAGES[$num]["TITRE"] . "</a>" . " <span class='navigation'>></span> " . $ch;
        }
        if (is_numeric($num) && $num == 0 || is_numeric($num) && $num == $this->numPageAccueil) // Si l'on est sur le numéro de la page d'accueil => Arret
        {
            $continuer = false;
            //echo 'A';
        }
        else
        {
            if (is_numeric($num))
            {
                $num = intval($num/$this->pageSaut);
                //echo 'B';
            }
            else
            {
                $num = $this->numPageAccueil;
                //echo 'C';
            }
        }
    }
    echo    '<div id="content-box">'."\r\n".
                "\t".'<div class="border">'."\r\n".
                    "\t"."\t".'<div class="padding">'."\r\n";
    if (!isset($PAGES[$P]['NO_NAVIGATION_BAR']) || (isset($PAGES[$P]['NO_NAVIGATION_BAR']) && $PAGES[$P]['NO_NAVIGATION_BAR']== 0))
    {
        echo                    "\t"."\t"."\t".'<div id="toolbar-box">'."\r\n".
                                "\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
        						    "\t"."\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
        							    "\t"."\t"."\t"."\t"."\t"."\t".'<div class="t"></div>'."\r\n".
        						    "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
                                "\t"."\t"."\t"."\t".'</div>'."\r\n".
                                "\t"."\t"."\t"."\t".'<div class="m">'."\r\n";
    
        
        // On affiche les boutons (de droite)
        if (isset($BOUTTONS) && count($BOUTTONS) > 0)
        {
            echo    "\t"."\t"."\t"."\t"."\t".'<div class="toolbar-list" id="toolbar">'."\r\n".
                    "\t"."\t"."\t"."\t"."\t"."\t".'<ul>'."\r\n";
//                        "\t"."\t"."\t"."\t"."\t"."\t".'<table class="toolbar"><tr>'."\r\n";
            
            foreach($BOUTTONS as $v)
            {
//                echo    "\t"."\t"."\t"."\t"."\t"."\t"."\t".'<td class="button" id="toolbar-cancel">'.
                echo    "\t"."\t"."\t"."\t"."\t"."\t"."\t".'<li class="button">'.
                        '<a ';
                
                if (isset($v['HREF']) && $v['HREF'] != '')
                    echo 'href="'.$v['HREF'].'" ';
                
                if (isset($v['ACTION']) && $v['ACTION'] != '')
                    echo 'onclick="'.$v['ACTION'].'" ';
                    
                if (isset($v['ID']) && $v['ID'] != '')
                    echo 'id="'.$v['ID'].'" ';
                
                if (isset($v['CLASS']) && $v['CLASS'] != '')
                    echo 'class="'.$v['CLASS'].'" ';
                    
                if (isset($v['ACTION']) && $v['ACTION'] != '' && ((!isset($v['HREF']) || (isset($v['HREF']) && $v['HREF'] == ''))))
                    echo 'href="#" ';
                    
                if (isset($v['TARGET']) && $v['TARGET'] != '')
                    echo 'target="'.$v['TARGET'].'" ';
    
                echo 'class="toolbar" title="'.$v['TITLE'].'">'.
                               '<span class="icon-32-cancel" style="background-image: url('.$v['IMG'].');"></span>'.
                                $v['TXT'].
                            '</a>'.
                        '</li>'."\r\n";
            }
            echo "\t"."\t"."\t"."\t"."\t"."\t".'</ul>'."\r\n".
                "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n";
        }
    
        // Affichage du titre de la pageclass="pagetitle 
        echo "\t"."\t"."\t"."\t"."\t".'<div class="pagetitle" style="background-image: url('.$image.');">'.
                $ch.
             '</div>'."\r\n";
    
        echo "\t"."\t"."\t"."\t"."\t".'<div class="clr"></div>'."\r\n";
        
        echo "\t"."\t"."\t"."\t".'</div>'."\r\n".
             "\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
            "\t"."\t"."\t"."\t"."\t"."\t".'<div class="b"></div>'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t".'<div class="clr"></div>'."\r\n";
    }
    
        //"\t"."\t".'</div>'."\r\n".
        //"\t".'</div>'."\r\n".
    	//    '</div>'."\r\n";
    	    
    echo    //"\t"."\t"."\t".'<div id="element-box">'."\r\n".
            //"\t"."\t"."\t"."\t".'<div class="border">'."\r\n".
            //"\t"."\t"."\t"."\t"."\t".'<div class="padding">'."\r\n".
            "\t"."\t"."\t".'<div id="element-box">'."\r\n".
            "\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
            "\t"."\t"."\t"."\t"."\t"."\t".'<div class="t"></div>'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'<div class="m" >'."\r\n";
}
    }
    
    /**
     *
     * Affiche le Footer d'une page en version 3.0
     * 
     */
    private function afficheFooterVersion3_0()
    {
        global $PAGES, $P, $PROD, $tabTempsDesPages;
        $this->timeFin = getMicroTime();
        $t = number_format($this->timeFin - $this->timeDebut, 3, '.', ' ');
        
        $infosSurExecutionTime = '';
        if (isset($tabTempsDesPages) && isset($tabTempsDesPages['common_start']))
        {
            $t = number_format($this->timeFin - $tabTempsDesPages['common_start'], 3, '.', ' ');
            
            if (isset($tabTempsDesPages['common_modules_end']))
            {
                $infosSurExecutionTime .=    'Inclusion des modules du common : '.
                                            '<font color=#0B55C4><b>'.
                                            number_format($tabTempsDesPages['common_modules_end'] - $tabTempsDesPages['common_modules_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_stats_connexion_end']))
            {
                $infosSurExecutionTime .=    '<br>Connexion a la base de logs du common : '.
                                            '<font color=#0B55C4><b>'.
                                            number_format($tabTempsDesPages['common_stats_connexion_end'] - $tabTempsDesPages['common_stats_connexion_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_end']))
            {
                $infosSurExecutionTime .=    '<br>Temps total du common : '.
                                            '<font color=#0B55C4><b>'.
                                            number_format($tabTempsDesPages['common_end'] - $tabTempsDesPages['common_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_end']))
            {
                $infosSurExecutionTime .=    '<br>Temps de génération de la page du projet : '.
                                            '<font color=#0B55C4><b>'.
                                            number_format($this->timeFin - $tabTempsDesPages['common_end'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_start']))
            {
                $infosSurExecutionTime .=    '<br>Temps total de la page complète : '.
                                            '<font color=#0B55C4><b>'.
                                            number_format($this->timeFin - $tabTempsDesPages['common_start'], 3, '.', ' ').
                                            '</b></font> sec.';
            }
            
        }
        
        if ( !isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {
        echo    "\t"."\t"."\t"."\t"."\t".'<div class="clr"></div>'."\r\n".
                "\t"."\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
        		"\t"."\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
        		"\t"."\t"."\t"."\t"."\t"."\t".'<div class="b"></div>'."\r\n".
        		"\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t".'</div>'."\r\n".
        		"\t"."\t"."\t".'<div class="clr"></div>'."\r\n".
        		"\t"."\t".'</div>'."\r\n".
        		"\t"."\t".'<div class="clr"></div>'."\r\n".
        		"\t".'</div>'."\r\n".
        	    '</div>'."\r\n";
        	
        

echo    '<div id="border-bottom"><div><div></div></div></div>'."\r\n".
	    '<div id="footer">'."\r\n".
		    "\t".'<p class="copyright">'.
			    '© '.date('Y').' Direction des Systèmes Informatiques | Génération de la page : '.
			    ($infosSurExecutionTime != '' ? '<a href="#" title="'.$infosSurExecutionTime.'">':'').
			    '<font color=#0B55C4><b>'. $t .'</b></font>'.
			    ($infosSurExecutionTime != '' ? '</a>':'').
			    ' sec.'.
			    ' | Nombre de requêtes SQL : <font color=#0B55C4><b>'. $this->requeteQuantite .'</b></font> ';

/*
if (date('Y') == '2011' && date('m') == '1')
{
    echo '<br><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="550" height="150">
<param name="movie" value="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf">
<param name="quality" value="high">
<embed src="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="550" height="150"></embed></object>';
}
*/
			    //' | Temps d\'exécution des requêtes SQL : <font color=#008000><b>'. number_format($this->requeteTemps, 3, '.', ' ') .'</b></font> sec.'.
echo 			'</p>'."\r\n".
	    '</div>'."\r\n";
//if ($PROD == 1)
//{
//    echo '<script language="JavaScript">'."\r\n";
//    echo 'var s=\'<img src="http://projets.prod.intranet/index.php?P=13\';'."\r\n";
//    echo 'if(parseFloat(navigator.appVersion)>=4)'."\r\n";
//    echo '{'."\r\n";
//    echo 's += \'&ew=\' + screen.width + \'&eh=\' + screen.height;'."\r\n";
//    echo '}'."\r\n";
//    echo 's += \'">\';'."\r\n";
//    echo 'document.writeln(s);'."\r\n";
//    echo '</script>'."\r\n";
//}
        }
        echo    ''.
            '</body>'.
            '</html>';
    }
    
    /**
     *
     * Affiche le Header d'une page en version 3.0
     *
     */
    private function afficheHeaderVersion4_0()
    {
        global $PAGES, $P, $GENERAL_URL, $IMAGE_URL, $MODULE_PATH, $JAVASCRIPTS, $ONGLETS, $PROJET_ID, $gestionProjet, $DATA_PATH, $BOUTTONS, $MENU, $CSS_TO_LOAD, $RSS, $PROD;
        
        if ($this->activeBootstrap == true)
            $PAGES[$P]['HEADER_FOOTER_NO_SPACE'] = 1;
        
        if (!isset($PAGES[$P]['NO_DOCTYPE']) || (isset($PAGES[$P]['NO_DOCTYPE']) && $PAGES[$P]['NO_DOCTYPE']== 0))
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\r\n";
    
    
        echo '<html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />'."\r\n";
        
        if (defined('META_DESCRIPTION') && META_DESCRIPTION != '')
        {
            echo '<meta name="description" content="'.META_DESCRIPTION.'" />'."\r\n";
        }
    
        echo '<link rel="shortcut icon" type="image/x-icon" href="'.$GENERAL_URL.'/'.$this->faviconIco.'" />'."\r\n";
    
        if ($this->faviconImage != '')
            echo '<link rel="icon" type="image/gif" href="'. $this->faviconImage .'" />'."\r\n";

        echo '<title>'.$PAGES[$P]["TITRE"].'</title>'."\r\n";

        if (isset($RSS))
        {
            foreach($RSS as $v)
                echo '<link rel="alternate" type="application/rss+xml" title="'.$v['TITLE'].'" href="'.$v['HREF'].'" />'."\r\n";
        }

        if ($this->activeBootstrap == false)
        {
            if ($this->designHiver == true)
                echo '<link href="'. $this->getDesignUrl() .'/css/styles_hiver.css" rel="stylesheet" type="text/css">'."\r\n";
            else
                echo '<link href="'. $this->getDesignUrl() .'/css/styles.css" rel="stylesheet" type="text/css">'."\r\n";
        }
        
        if ($this->activeBootstrap == true)
        {
            echo '<link href="'.JS_BOOTSTRAP_URL.'/css/bootstrap.min.css" rel="stylesheet" type="text/css">'."\r\n";
            echo '<link href="'.JS_BOOTSTRAP_URL.'/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">'."\r\n";
        }
        
        echo '<link href="'.$GENERAL_URL.'/'. $this->cssFileName .'" rel="stylesheet" type="text/css">'."\r\n";

        if (isset($CSS_TO_LOAD))
        {
            foreach($CSS_TO_LOAD as $v)
                echo '<link href="'.$v.'" rel="stylesheet" type="text/css">'."\r\n";
        }

        //         echo '  <link href="'.JS_JQUERY_UI_URL.'/css/bleu4_0/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css">
        //echo '  <link href="'.JS_JQUERY_UI_URL.'/css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
//         echo '  <link href="'.JS_JQUERY_UI_URL.'/css/redmond/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css">
//                 <script type="text/javascript" src="'.JS_JQUERY_UI_URL.'/js/jquery-1.7.2.min.js"></SCRIPT>
//                 <script type="text/javascript" src="'.JS_JQUERY_UI_URL.'/js/jquery-ui-1.10.0.custom.min.js"></SCRIPT>';
        echo '  <link href="'.JS_JQUERY_UI_URL.'/css/redmond/jquery-ui.custom.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="'.JS_JQUERY_UI_URL.'/js/jquery.js"></SCRIPT>
        <script type="text/javascript" src="'.JS_JQUERY_UI_URL.'/js/jquery-ui.custom.min.js"></SCRIPT>';
        
        $t = array();
        if (isset($JAVASCRIPTS))
        {
            $t = array_map('basename', $JAVASCRIPTS);
        }
        if ($this->activeBootstrap == true)
        {
            echo '<script type="text/javascript" src="'.JS_BOOTSTRAP_URL.'/js/bootstrap.min.js"></SCRIPT>'."\r\n";
        }
        
        if (isset($JAVASCRIPTS))
        {
            foreach($JAVASCRIPTS as $v)
                echo '<script type="text/javascript" src="'.$v.'"></SCRIPT>'."\r\n";
            $t = array_map('basename', $JAVASCRIPTS);
        }
    
        if ($this->activeBootstrap == false)
        {
            if (!in_array('title.js', $t))
                echo '<script type="text/javascript" src="'.$this->designUrl.'/js/title.js"></SCRIPT>'."\r\n";
        }
        
        if (!isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {
            ?>
        
            <!--[if IE 7]>
            <link href="<?=$this->getDesignUrl()?>/css/ie7.css" rel="stylesheet" type="text/css" />
            <![endif]-->
            
            <!--[if lte IE 6]>
            <link href="<?=$this->getDesignUrl()?>/css/ie6.css" rel="stylesheet" type="text/css" />
            <![endif]-->
        
            <?
        }    
        if (!isset($PAGES[$P]['NO_MENU']) || (isset($PAGES[$P]['NO_MENU']) && $PAGES[$P]['NO_MENU'] == 0))
        {
            if (!isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
            {
                //            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/menu.js"></SCRIPT>'."\r\n";
                //            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/fat.js"></SCRIPT>'."\r\n";
                //            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/index.js"></SCRIPT>'."\r\n";
                //            echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/fonctions.js"></SCRIPT>'."\r\n";
                echo '<script type="text/javascript" src="'. $this->getDesignUrl() .'/js/chrome.js"></SCRIPT>'."\r\n";
            }
        }
    
    
        if ($this->activeCalendrier == true)
        {
            // inclusion du calendrier
            echo '  <script src="'.JS_CALENDAR_URL.'/src/js/jscal2.js"></script>
            <script src="'.JS_CALENDAR_URL.'/src/js/lang/fr.js"></script>
            <link rel="stylesheet" type="text/css" href="'.JS_CALENDAR_URL.'/src/css/jscal2.css" />
            <link rel="stylesheet" type="text/css" href="'.JS_CALENDAR_URL.'/src/css/border-radius.css" />
            <link rel="stylesheet" type="text/css" href="'.JS_CALENDAR_URL.'/src/css/gold/gold.css" />';
        }
        
        if ($this->activeFormCheck == true)
        {
            // inclusion du formcheck = validation engine jquery
            echo '  <script src="'.JS_JQUERY_UI_URL.'/addon/validation-engine/js/languages/jquery.validationEngine-fr.js" charset="utf-8"></script>
            <script src="'.JS_JQUERY_UI_URL.'/addon/validation-engine/js/jquery.validationEngine.js" charset="utf-8"></script>
            <link rel="stylesheet" type="text/css" href="'.JS_JQUERY_UI_URL.'/addon/validation-engine/css/validationEngine.jquery.css" />';
        }
        
    
        if ($P == 'C_AJAX') // connexion ldap
            echo '<script type="text/javascript" src="'.$this->designUrl.'/js/connexion.js"></SCRIPT>'."\r\n";
        
        if ($this->activeSigAdresse == true)
        {
            echo '<script type="text/javascript" src="'.JS_SIG_ADRESSE_URL.'/sig_adresse_autocomplete.js"></script>'."\r\n";
        }
        
        if (isset($PAGES[$P]['HEAD_JAVASCRIPT']) && $PAGES[$P]['HEAD_JAVASCRIPT'] != '')
        {
            echo '<script type="text/javascript">'."\r\n";
            echo $PAGES[$P]['HEAD_JAVASCRIPT']."\r\n";
            echo '</script>'."\r\n";
        }
        
        echo '</head>'."\r\n";
        echo '<body';
        
        if ( isset($PAGES[$P]['ON_LOAD']) )
            echo ' onload=' . $PAGES[$P]['ON_LOAD'];
        
        if (isset($PAGES[$P]['ON_BLUR']))
            echo ' onblur=' . $PAGES[$P]['ON_BLUR'];
        
        if ( isset($PAGES[$P]['HEADER_NO_SPACE']) && $PAGES[$P]['HEADER_NO_SPACE'] == 1)
            echo ' style="margin:0; padding:0;"';
        
        $projetNom = '';
        $projetVersion = '';
        if (defined('PROJET_AFF_NOM') && PROJET_AFF_NOM != '')
            $projetNom = PROJET_AFF_NOM;
        if (defined('PROJET_AFF_VERSION') && PROJET_AFF_VERSION != '')
            $projetVersion = PROJET_AFF_VERSION;
        
        echo ' >'."\r\n";
    
//         echo $this->activeBootstrap;
        if (!isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {
//             echo 'here';
            // Vérification si un message important à afficher existe...
            if (isset($this->messageInformation['DATE']) && time()<$this->messageInformation['DATE'])
            {
                $color = 'red';
                if (isset($this->messageInformation['COLOR']) && $this->messageInformation['COLOR'] != '')
                    $color = $this->messageInformation['COLOR'];
                
                // il existe un message et la date de fin de ce message n'est pas dépassé
                echo    '<div style="z-index:100;position:absolute;top:90px;left:10px;width:98%;height:20px;background-color:'.$color.';" id="zonePushLoggeeFRT">'.
                        '<marquee class="menuHaut" behavior="scroll" DIRECTION="left" height="20px" style="font-size:14px;color:#000000;" onmouseover="javascript:scroller1.stop()" onmouseout="javascript:scroller1.start()" id="scroller1" SCROLLDELAY="150" SCROLLAMOUT="1" bgcolor="'.$color.'">'.
                        '<b>'. $this->messageInformation['MESSAGE'] .'</b>'.
                        '</marquee>'.
                        '</div>';
            }
        
            $version = 'Version ';
            if (file_exists($DATA_PATH.'/revision.php'))
            {
                include($DATA_PATH.'/revision.php');
                $version .= number_format($revision, 0, '', '.');
            }
            else
            {
                if (SERVEUR_PROD == 'SMAGELLAN')
                {
                    $version = '';
                }
                else
                {
                    $version .= '?? => Vous devez être en local';
                }
            }
            
            $divApplication = '';
        
            if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
            {
                //echo $_SESSION[PROJET_NAME]['agent_ldap']['login'];
                if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','cattierl','torrentf','bonoc','adinanid','paulp','villaj')))
                    $isDevInformatique = true;
                else
                    $isDevInformatique = false;
                if (isset($_SESSION[PROJET_NAME]['agent_ldap']['login']) && in_array(strtolower($_SESSION[PROJET_NAME]['agent_ldap']['login']),array('marinjc','kempffe','fitzailos','villaj','cattierl','filliardl','boublenzai','bonoc','adinanid','paulp')))
                    $isUserGrantedToModifyMessage = true;
                else
                    $isUserGrantedToModifyMessage = false;
                
                if ($isUserGrantedToModifyMessage == false) // on récupère la valeur mis en dur pour des agents admin du site
                    $isUserGrantedToModifyMessage = getUserCanModifyAlerteMessage();
                
                $chDeco = ($isDevInformatique ? '<a href="index.php?P=L">Logs</a>&nbsp;|&nbsp;':'').
                ($isUserGrantedToModifyMessage ? '<a href="index.php?P=A">Message</a>&nbsp;|&nbsp;':'');
            
            
                //$this->afficheMenuApplication = true;
                // Affichage de la liste des sites accéssibles par l'utilisateur
                if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1 && $this->afficheMenuApplication == true)
                {
                    // version SELECT standard
                    $select = '<select onchange="javascript:if (this.value != \'\'){window.location=this.value;}" name="menuapp">';
                    $nb = 0;
                    if (isset($_SESSION[PROJET_NAME]['application_user']))
                    {
                        foreach($_SESSION[PROJET_NAME]['application_user'] as $k => $tabProjet)
                        {
                            $select .= '<option value="">:: '.$k.'</option>';
                            $projetIdCourant = '';
                            $i = 0;
                            
                            // tri du tableau des projets
                            $tabTemp = array();
                            foreach($tabProjet as $k => $v)
                            {
                                $tabTemp[$k] = $v['PROJET_LIBELLE'];
                            }
                            asort($tabTemp);
                            $newTab = array();
                            foreach($tabTemp as $k => $v)
                            {
                                $newTab[] = $tabProjet[$k];
                            }
                            $tabProjet = $newTab;
                            foreach($tabProjet as $v)
                            {
                                if ($projetIdCourant != $v['PROJET_ID'])
                                {
                                    $colorFond = $i%2 == 0 ? '#D1EFBB':'#FFFFDD';
                                    $colorTxt = $i%2 == 0 ? '#2F2F2F':'#2F2F2F';
                                    $i++;
                                    $projetIdCourant = $v['PROJET_ID'];
                                }
                                
                                $select .= '<option style="background-color:'.$colorFond.';color:'.$colorTxt.';" value="'.$v['PROJET_URL'].'">'.$v['PROJET_LIBELLE'].'</option>';
                                $nb++;
                            }
                        }
                        $select .= '</select>';
                    }
                    // FIN version SELECT standard
            
                    // version avec survol de souris
                    $select = '';
                    $nb = 0;
                    if (isset($_SESSION[PROJET_NAME]['application_user']))
                    {
                        foreach($_SESSION[PROJET_NAME]['application_user'] as $k => $tabProjet)
                        {
                            $select .= '<div class="chromestyle" id="chromemenu">
                            <ul>
                            <li><a href="#" rel="dropmenu1">'.$k.'</a></li>
                            </ul>
                            </div><div id="dropmenu1" class="dropmenudiv">';
                            $projetIdCourant = '';
                            $i = 0;
                            // tri du tableau des projets
                            $tabTemp = array();
                            foreach($tabProjet as $k => $v)
                            {
                                $tabTemp[$k] = $v['PROJET_LIBELLE'];
                            }
                            asort($tabTemp);
                            $newTab = array();
                            foreach($tabTemp as $k => $v)
                            {
                                $newTab[] = $tabProjet[$k];
                            }
                            $tabProjet = $newTab;
                            //                    print_jc($tabProjet);
                            foreach($tabProjet as $v)
                            {
                                if ($projetIdCourant != $v['PROJET_ID'])
                                {
                                    $colorFond = $i%2 == 0 ? '#D1EFBB':'#FFFFDD';
                                    $colorTxt = $i%2 == 0 ? '#2F2F2F':'#2F2F2F';
                                    $i++;
                                    $projetIdCourant = $v['PROJET_ID'];
                                }
                                
                                $select .= '<a class="v'.($i%2).'" href="'.$v['PROJET_URL'].'">'.$v['PROJET_LIBELLE'].'</a>';
                                $nb++;
                            }
                        }
                        $select .= '</div>';
                    }
                    // FIN version avec survol de souris
                    
                    if ($nb > 1)
                    {
                        $divApplication .= '<span class="applicationmenu">'. $select .'</span>';
                        $divApplication .= '<script type="text/javascript">
                        cssdropdown.startchrome("chromemenu");
                        </script>';
                    }
                }
            }
            else
            {
                $chDeco = '';
            }
        
            //class="version" à la place du logo
            echo '<div id="border-top" class="h_blue">'."\r\n".
            "\t".'<span class="txtlogo">'.$chDeco.'<a href="index.php?P=H">'. $version .'</a></span>'."\r\n".
            //		    "\t".'<span class="logo"><a href="http://www.intranet" target="_blank"><img src="'.$this->getDesignUrl().'/images/logo.png" /></a></span>'."\r\n".
            (defined('PROJET_LOGO') ? "\t".'<span class="logo">'.PROJET_LOGO.'</span>'."\r\n":'').
            "\t".'<span class="title"><a href="index.php">'.(defined('PROJET_TITRE') ? PROJET_TITRE:'No PROJET_TITRE defined').'</a></span>'."\r\n".
            '</div>'."\r\n";
            
            // Texte à droite (déconnexion, users connectés...)
            echo '<div id="header-box">'."\r\n";
            echo "\t".'<!-- Texte à droite, user connectés / bouton déconnexion -->'."\r\n".
            "\t".'<div id="module-status">'."\r\n";
            //'<span class="preview"><a href="http://10.128.10.221/joomla/" target="_blank">Prévisualiser</a></span>'.
            //'<a href="index.php?option=com_messages"><span class="no-unread-messages">0</span></a>'.
        
        
            echo $divApplication;
            
            // Affichage du nombre de personne connecté sur le site
            if (isset($PROJET_ID) && $PROJET_ID != '' && $this->affichePersonneConnecte == true)
            {
                if (!$gestionProjet->isConnected())
                    $gestionProjet->connexion();
            
                if ($gestionProjet->isConnected())
                {
                    //            echo '<span class="loggedin-users">(0) Site</span><span class="backloggedin-users">(1) Administration</span><span class="no-unread-messages"><a href="/joomla/administrator/index.php?option=com_messages">Aucun message</a></span>
                    //			<span class="viewsite"><a href="http://127.0.0.1/joomla/" target="_blank">Voir le site</a></span><span class="logout"><a href="/joomla/administrator/index.php?option=com_login&amp;task=logout&amp;69e5eb3f76d130c1b0de9bd584cd6f15=1">Déconnexion</a></span>';
                    $nbVisiteur = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID);
                    $nbVisiteurToday = $gestionProjet->getNbVisiteurForProjetId($PROJET_ID, 'today');
                    
                    // Chaine contenant le détail des visiteurs actuellement sur le site
                    $tabVisiteur = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID);
                    $chVisiteur = '';
                    $nbMaxAffichage = 15;
                    $i = 0;
                    foreach($tabVisiteur as $k => $v)
                    {
                        if ($i == $nbMaxAffichage)
                        {
                            $chVisiteur .= '<br>...';
                            break;
                        }
                        if ($chVisiteur != '')
                            $chVisiteur .= '<br>';
                        if ($v['USER'] == '')
                            $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'].'</strong>';
                        else
                            $chVisiteur .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                        $chVisiteur .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                        $i++;
                    }
                    if ($chVisiteur != '')
                        $chVisiteur = '<br>'.$chVisiteur;
                    
                    // Chaine contenant le détail des visiteurs d'aujourd'hui
                    $tabVisiteurToday = $gestionProjet->getUserOrIpConnectedOnApplication($PROJET_ID, 'today');
                    $chVisiteurToday = '';
                    $i = 0;
                    foreach($tabVisiteurToday as $k => $v)
                    {
                        if ($i == $nbMaxAffichage)
                        {
                            $chVisiteurToday .= '<br>...';
                            break;
                        }
                        if ($chVisiteurToday != '')
                            $chVisiteurToday .= '<br>';
                        if ($v['USER'] == '')
                            $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/workplace2.gif>&nbsp;<strong>'. $v['IP'] .'</strong>';
                        else
                            $chVisiteurToday .= '<img align=absbottom src='. $this->designUrl . '/pagination/user1.gif>&nbsp;<strong>'. $v['USER'] .'</strong> ('. $v['IP'] .')';
                        $chVisiteurToday .= ' à '. date('H\hi \e\t s \s\e\c.', $v['DATE']);
                        $i++;
                    }
                    if ($chVisiteurToday != '')
                        $chVisiteurToday = '<br>'.$chVisiteurToday;
                    
                    echo        "\t"."\t".'<span class="loggedin-users"><a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont <strong>actuellement présentes</strong> sur cette application'.$chVisiteur.'">'.$nbVisiteur.'</a>'.
                    ' / '.
                    '<a href="#" title="Ce chiffre représente le <strong>nombre de personnes</strong> qui sont venu sur cette application <strong>aujourd\'hui</strong>'.$chVisiteurToday.'">'.$nbVisiteurToday.'</a></span>'."\r\n";
                    //echo '<span class="loggedin-users">185</span>';
                }
            }
        
            if (isset($_SESSION[PROJET_NAME]['authentified']) && $_SESSION[PROJET_NAME]['authentified'] == 1)
            {
                // Récupération des messages
                echo '<span class="no-unread-messages"><a title="Vous avez aucun message non lu envoyé par les applications" href="index.php">Aucun message</a></span>';
                
                echo    "\t"."\t".'<span class="logout"><a title="Se <strong>déconnecter</strong> de l\'application" href="index.php?action=logout">Déconnexion</a></span>'."\r\n";
            }
            
            echo    "\t".'</div>'."\r\n";
            echo "\t".'<!-- Fin Texte à droite, user connectés / bouton déconnexion -->'."\n\n";
            
            // menu
            if (isset($MENU) && count($MENU)>0 )
            {
                echo "\t".'<!-- Menu avec survol -->'."\r\n";
                echo "\t".'<div id="module-menu">'."\r\n".
                "\t"."\t".'<ul id="menu" >'."\r\n";
                foreach($MENU as $menuHaut)
                {
                    echo "\t"."\t"."\t".'<li class="node"><a'.
                    (isset($menuHaut['LIEN']) && strlen($menuHaut['LIEN']) > 0 ? ' href="'. $menuHaut['LIEN'] .'"':'').
                    (isset($menuHaut['TITLE']) && strlen($menuHaut['TITLE']) > 0 ? ' title="'. $menuHaut['TITLE'] .'"':'').
                    (isset($menuHaut['TARGET']) && strlen($menuHaut['TARGET']) > 0 ? ' target="'. $menuHaut['TARGET'] .'"':'').
                    '>'. $menuHaut['LIBELLE'] .'</a>'."\r\n";
        
                    // vérification s'il existe un sousmenu
                    $sousMenu = isset($menuHaut['SMENU']) ? $menuHaut['SMENU']:array();
                    
                    echo "\t"."\t"."\t"."\t".'<ul>'."\r\n";
                    foreach($sousMenu as $menu)
                    {
                        if (isset($menu['SEPARATEUR']) && $menu['SEPARATEUR'] == 1)
                            echo "\t"."\t"."\t"."\t"."\t".'<li class="separator"><span></span></li>'."\r\n";
                        else
                        {
                            // vérification s'il existe un sous sousmenu
                            $sousSousMenu = isset($menu['SMENU']) ? $menu['SMENU']:array();
                            
                            echo "\t"."\t"."\t"."\t"."\t".'<li'.
                            (count($sousSousMenu)>0 ? ' class="node"':'').
                            '><a '.
                            (isset($menu['CLASS']) && strlen($menu['CLASS']) > 0 ? ' class="'. $menu['CLASS'] .'"':'').
                            (isset($menu['TITLE']) && strlen($menu['TITLE']) > 0 ? ' title="'. $menu['TITLE'] .'"':'').
                            (isset($menu['TARGET']) && strlen($menu['TARGET']) > 0 ? ' target="'. $menu['TARGET'] .'"':'').
                            ' href="'.$menu['LIEN'].'">'.$menu['LIBELLE'].'</a>'."\r\n";
                            
                            if (count($sousSousMenu) > 0)
                            {
                                echo "\t"."\t"."\t"."\t"."\t"."\t".'<ul>'."\r\n";
                                foreach($sousSousMenu as $ssmenu)
                                {
                                    if (isset($ssmenu['SEPARATEUR']) && $ssmenu['SEPARATEUR'] == 1)
                                    echo "\t"."\t"."\t"."\t"."\t".'<li class="separator"><span></span></li>'."\r\n";
                                    else
                                    echo "\t"."\t"."\t"."\t"."\t".'<li><a '.
                                    (isset($ssmenu['CLASS']) && strlen($ssmenu['CLASS']) > 0 ? ' class="'. $ssmenu['CLASS'] .'"':'').
                                    (isset($ssmenu['TITLE']) && strlen($ssmenu['TITLE']) > 0 ? ' title="'. $ssmenu['TITLE'] .'"':'').
                                    (isset($ssmenu['TARGET']) && strlen($ssmenu['TARGET']) > 0 ? ' target="'. $ssmenu['TARGET'] .'"':'').
                                    ' href="'.$ssmenu['LIEN'].'">'.$ssmenu['LIBELLE'].'</a></li>'."\r\n";
                                }
                                echo "\t"."\t"."\t"."\t"."\t"."\t".'</ul>'."\r\n";
                            }
                            echo '</li>'."\r\n";
                        }
                    }
                    echo "\t"."\t"."\t"."\t".'</ul>'."\r\n";
                    
                    echo "\t"."\t"."\t".'</li>'."\r\n";
                }
            
                echo         "\t"."\t".'</ul>'."\r\n".
                "\t".'</div>'."\r\n";
                
                echo "\t".'<!-- Fin Menu avec survol -->'."\n\n";
            }
            else
            {
                echo "\t".'<!-- Menu avec survol -->'."\r\n";
                echo "\t".'<div id="module-menu">'."\r\n".
                "\t"."\t".'<ul id="menu" >'."\r\n";
                echo         "\t"."\t".'</ul>'."\r\n".
                "\t".'</div>'."\r\n";
            }
        
        
            echo    "\t".'<div class="clr"></div>'."\r\n";
            
            // Fin du div id="header-box"
            echo '</div>'."\r\n";
    
            // Définition du titre de la page, l'image
            $ch = '';
            $continuer = true;
            $num = $P;
            $titre = $description = '';
            $image = $GENERAL_URL.'/images/default.gif'; // Image par défaut
            $imageWidth = 48;
            while ($continuer)
            {
                //echo ' ['.$num.'] ';
                $param = "";
                if ($ch == '')
                {
                    $ch = "" . $PAGES[$num]['TITRE'] . "";
                    $titre = $PAGES[$num]['TITRE'];
                    if (isset($PAGES[$num]['DESCRIPTION']))
                        $description = $PAGES[$num]['DESCRIPTION'];
                    if (isset($PAGES[$num]['IMAGE']))
                    {
                        if (basename($PAGES[$num]['IMAGE']) != $PAGES[$num]['IMAGE']) // Image en prod
                            $image = $PAGES[$num]['IMAGE'];
                        else
                            $image = $GENERAL_URL.'/images/'.$PAGES[$num]['IMAGE']; // Image en local au projet
                        $imageWidth = (isset($PAGES[$num]['IMAGE_WIDTH']) && $PAGES[$num]['IMAGE_WIDTH'] != '') ? $PAGES[$num]['IMAGE_WIDTH']:$imageWidth;
                    }
                }
                else
                {
                    $variablesLien = '';
                    if (isset($PAGES[$num]['VARIABLES']) && is_array($PAGES[$num]['VARIABLES']))
                    {
                        foreach($PAGES[$num]['VARIABLES'] as $nomVariable)
                        {
                            eval('global $' . $nomVariable . ';');
                            eval('$'.'value = $' . $nomVariable . ';');
                            if ($value != '')
                                $variablesLien .= '&'.$nomVariable.'='.$value;
                        }
                    }
                    
                    if (isset($PAGES[$num]['URL_REWRITING']) && $PAGES[$num]['URL_REWRITING'] != '')
                    {
                        $link = $PAGES[$num]['URL_REWRITING'];
                    }
                    else
                        $link = 'index.php?P=' . $num . $variablesLien;
                    $ch = "<a class=\"navigation\" href=\"". $link ."\">" . $PAGES[$num]["TITRE"] . "</a>" . " <span class='navigation'>></span> " . $ch;
                }
                if (is_numeric($num) && $num == 0 || is_numeric($num) && $num == $this->numPageAccueil) // Si l'on est sur le numéro de la page d'accueil => Arret
                {
                    $continuer = false;
                    //echo 'A';
                }
                else
                {
                    if (is_numeric($num))
                    {
                        $num = intval($num/$this->pageSaut);
                        //echo 'B';
                    }
                    else
                    {
                        $num = $this->numPageAccueil;
                        //echo 'C';
                    }
                }
            }
            
            echo    '<div id="content-box">'."\r\n".
            "\t".'<div class="border">'."\r\n".
            "\t"."\t".'<div class="padding">'."\r\n";
            
            if (!isset($PAGES[$P]['NO_NAVIGATION_BAR']) || (isset($PAGES[$P]['NO_NAVIGATION_BAR']) && $PAGES[$P]['NO_NAVIGATION_BAR']== 0))
            {
                echo                    "\t"."\t"."\t".'<div id="toolbar-box">'."\r\n".
                "\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
                "\t"."\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
                "\t"."\t"."\t"."\t"."\t"."\t".'<div class="t"></div>'."\r\n".
                "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
                "\t"."\t"."\t"."\t".'</div>'."\r\n".
                "\t"."\t"."\t"."\t".'<div class="m">'."\r\n";
            
            
                // On affiche les boutons (de droite)
                if (isset($BOUTTONS) && count($BOUTTONS) > 0)
                {
                    echo    "\t"."\t"."\t"."\t"."\t".'<div class="toolbar-list" id="toolbar">'."\r\n".
                    "\t"."\t"."\t"."\t"."\t"."\t".'<ul>'."\r\n";
                    //                        "\t"."\t"."\t"."\t"."\t"."\t".'<table class="toolbar"><tr>'."\r\n";
                    
                    foreach($BOUTTONS as $v)
                    {
                        //                echo    "\t"."\t"."\t"."\t"."\t"."\t"."\t".'<td class="button" id="toolbar-cancel">'.
                        echo    "\t"."\t"."\t"."\t"."\t"."\t"."\t".'<li class="button">'.
                        '<a ';
                        
                        if (isset($v['HREF']) && $v['HREF'] != '')
                        echo 'href="'.$v['HREF'].'" ';
                        
                        if (isset($v['ACTION']) && $v['ACTION'] != '')
                        echo 'onclick="'.$v['ACTION'].'" ';
                        
                        if (isset($v['ID']) && $v['ID'] != '')
                        echo 'id="'.$v['ID'].'" ';
                        
                        if (isset($v['CLASS']) && $v['CLASS'] != '')
                        echo 'class="'.$v['CLASS'].'" ';
                        
                        if (isset($v['ACTION']) && $v['ACTION'] != '' && ((!isset($v['HREF']) || (isset($v['HREF']) && $v['HREF'] == ''))))
                        echo 'href="#" ';
                        
                        if (isset($v['TARGET']) && $v['TARGET'] != '')
                        echo 'target="'.$v['TARGET'].'" ';
                        
                        echo 'class="toolbar" title="'.$v['TITLE'].'">'.
                        '<span class="icon-32-cancel" style="background-image: url('.$v['IMG'].');"></span>'.
                        $v['TXT'].
                        '</a>'.
                        '</li>'."\r\n";
                    }
                    echo "\t"."\t"."\t"."\t"."\t"."\t".'</ul>'."\r\n".
                    "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n";
                }
            
                // Affichage du titre de la pageclass="pagetitle
                echo "\t"."\t"."\t"."\t"."\t".'<div class="pagetitle" style="background-image: url('.$image.');">'.
                $ch.
                '</div>'."\r\n";
                
                echo "\t"."\t"."\t"."\t"."\t".'<div class="clr"></div>'."\r\n";
                
                echo "\t"."\t"."\t"."\t".'</div>'."\r\n".
                "\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
                "\t"."\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
                "\t"."\t"."\t"."\t"."\t"."\t".'<div class="b"></div>'."\r\n".
                "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
                "\t"."\t"."\t"."\t".'</div>'."\r\n".
                "\t"."\t"."\t".'</div>'."\r\n".
                "\t"."\t"."\t".'<div class="clr"></div>'."\r\n";
            }
            
            //"\t"."\t".'</div>'."\r\n".
            //"\t".'</div>'."\r\n".
            //    '</div>'."\r\n";
            
            echo    //"\t"."\t"."\t".'<div id="element-box">'."\r\n".
            //"\t"."\t"."\t"."\t".'<div class="border">'."\r\n".
            //"\t"."\t"."\t"."\t"."\t".'<div class="padding">'."\r\n".
            "\t"."\t"."\t".'<div id="element-box">'."\r\n".
            "\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'<div class="t">'."\r\n".
            "\t"."\t"."\t"."\t"."\t"."\t".'<div class="t"></div>'."\r\n".
            "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'</div>'."\r\n".
            "\t"."\t"."\t"."\t".'<div class="m" >'."\r\n";
        }
    }
    
    /**
     *
     * Affiche le Footer d'une page en version 3.0
     *
     */
    private function afficheFooterVersion4_0()
    {
        
        global $PAGES, $P, $PROD, $tabTempsDesPages;
        $this->timeFin = getMicroTime();
        $t = number_format($this->timeFin - $this->timeDebut, 3, '.', ' ');
    
        $infosSurExecutionTime = '';
        if (isset($tabTempsDesPages) && isset($tabTempsDesPages['common_start']))
        {
            $t = number_format($this->timeFin - $tabTempsDesPages['common_start'], 3, '.', ' ');
    
            if (isset($tabTempsDesPages['common_modules_end']))
            {
                $infosSurExecutionTime .=    'Inclusion des modules du common : '.
                        '<font color=#0B55C4><b>'.
                        number_format($tabTempsDesPages['common_modules_end'] - $tabTempsDesPages['common_modules_start'], 3, '.', ' ').
                        '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_stats_connexion_end']))
            {
                $infosSurExecutionTime .=    '<br>Connexion a la base de logs du common : '.
                        '<font color=#0B55C4><b>'.
                        number_format($tabTempsDesPages['common_stats_connexion_end'] - $tabTempsDesPages['common_stats_connexion_start'], 3, '.', ' ').
                        '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_end']))
            {
                $infosSurExecutionTime .=    '<br>Temps total du common : '.
                        '<font color=#0B55C4><b>'.
                        number_format($tabTempsDesPages['common_end'] - $tabTempsDesPages['common_start'], 3, '.', ' ').
                        '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_end']))
            {
                $infosSurExecutionTime .=    '<br>Temps de g&eacute;n&eacute;ration de la page du projet : '.
                        '<font color=#0B55C4><b>'.
                        number_format($this->timeFin - $tabTempsDesPages['common_end'], 3, '.', ' ').
                        '</b></font> sec.';
            }
            if (isset($tabTempsDesPages['common_start']))
            {
                $infosSurExecutionTime .=    '<br>Temps total de la page compl&egrave;te : '.
                        '<font color=#0B55C4><b>'.
                        number_format($this->timeFin - $tabTempsDesPages['common_start'], 3, '.', ' ').
                        '</b></font> sec.';
            }
    
        }
    
        if (!isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) || (isset($PAGES[$P]['HEADER_FOOTER_NO_SPACE']) && $PAGES[$P]['HEADER_FOOTER_NO_SPACE']== 0))
        {
            echo    "\t"."\t"."\t"."\t"."\t".'<div class="clr"></div>'."\r\n".
                    "\t"."\t"."\t"."\t".'</div>'."\r\n".
                    "\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
                    "\t"."\t"."\t"."\t"."\t".'<div class="b">'."\r\n".
                    "\t"."\t"."\t"."\t"."\t"."\t".'<div class="b"></div>'."\r\n".
                    "\t"."\t"."\t"."\t"."\t".'</div>'."\r\n".
                    "\t"."\t"."\t"."\t".'</div>'."\r\n".
                    "\t"."\t"."\t".'</div>'."\r\n".
                    "\t"."\t"."\t".'<div class="clr"></div>'."\r\n".
                    "\t"."\t".'</div>'."\r\n".
                    "\t"."\t".'<div class="clr"></div>'."\r\n".
                    "\t".'</div>'."\r\n".
                    '</div>'."\r\n";
    
    
    
            echo    '<div id="border-bottom"><div><div></div></div></div>'."\r\n".
                    '<div id="footer">'."\r\n".
                    "\t".'<p class="copyright">'.
                    htmlentitiesIso('© '.date('Y').' Direction des Systèmes Informatiques | Génération de la page : ').
                    ($infosSurExecutionTime != '' ? '<a href="#" title="'.$infosSurExecutionTime.'">':'').
                    '<font color=#0B55C4><b>'. $t .'</b></font>'.
                    ($infosSurExecutionTime != '' ? '</a>':'').
                    ' sec.'.
                    ' | Nombre de requ&ecirc;tes SQL : <font color=#0B55C4><b>'. $this->requeteQuantite .'</b></font> ';
    
            /*
             if (date('Y') == '2011' && date('m') == '1')
             {
            echo '<br><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="550" height="150">
            <param name="movie" value="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf">
            <param name="quality" value="high">
            <embed src="http://web1.intranet/actualites/IMG/swf/anim_bonne_annee_2011.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="550" height="150"></embed></object>';
            }
            */
            //' | Temps d\'exécution des requêtes SQL : <font color=#008000><b>'. number_format($this->requeteTemps, 3, '.', ' ') .'</b></font> sec.'.
            echo 			'</p>'."\r\n".
                    '</div>'."\r\n";
            //if ($PROD == 1)
                //{
                //    echo '<script language="JavaScript">'."\r\n";
                //    echo 'var s=\'<img src="http://projets.prod.intranet/index.php?P=13\';'."\r\n";
                //    echo 'if(parseFloat(navigator.appVersion)>=4)'."\r\n";
                //    echo '{'."\r\n";
                //    echo 's += \'&ew=\' + screen.width + \'&eh=\' + screen.height;'."\r\n";
                //    echo '}'."\r\n";
                //    echo 's += \'">\';'."\r\n";
                //    echo 'document.writeln(s);'."\r\n";
                //    echo '</script>'."\r\n";
                //}
        }
        echo    ''.
                '</body>'.
                '</html>';
    }
}

?>