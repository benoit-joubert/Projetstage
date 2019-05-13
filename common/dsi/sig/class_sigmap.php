<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);

define('SIG_MAP_URL_COMMON_JS', 'http://web1.intranet/');
define('SIG_MAP_PATH_COMMON_JS', 'js/sig_porthole');
//define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://starentule.intranet/');
//define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'sigweb/PHP/web/common/sig/class_map/');
define('SIG_MAP_DEBUG_MODE', 0);
define('SIG_MAP_IFRAME_ID', 'iframeMap');
define('SIG_MAP_IFRAME_NAME', 'iframeMap');
define('SIG_MAP_IFRAME_SRC', 'mapframe.php');
define('SIG_MAP_IFRAME_HEIGHT', '800');
define('SIG_MAP_IFRAME_WIDTH', '800');
define('SIG_MAP_IFRAME_TITLE', 'Cadastre');
//define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'r:/sigweb/PHP/common/common.php');
define('SIG_MAP_MAP_GUIDE_LOGIN', 'Anonymous');
define('SIG_MAP_MAP_GUIDE_PASSWORD', '');
define('SIG_MAP_MAP_GUIDE_WEB_LAYOUT', 'Library://DIFFUSION/SIGAIX/CADASTRE.WebLayout');
define('SIG_MAP_MAP_GUIDE_MAP_NAME', 'CADASTRE');
define('SIG_MAP_MAP_GUIDE_LAYER_NAME', 'VR_V_VOIES');
define('SIG_MAP_MAP_GUIDE_SESSION_ID_NAME', 'Library://DIFFUSION/SIGAIX/CARTE/CADASTRE.MapDefinition');
define('SIG_MAP_CROSS_DOMAIN', false);
define('SIG_MAP_WEB_SERVICE_URL', 'ws.php');
define('SIG_MAP_ZOOM_X', '');
define('SIG_MAP_ZOOM_Y', '');
define('SIG_MAP_ZOOM_SCALE', '');
define('SIG_MAP_ZOOM_ACTIVATED', false);
define('SIG_MAP_INTERACTION_SELECTION_JAVASCRIPT_FUNCTION', 'mapInteractionSelection');
define('SIG_MAP_INTERACTION_SELECTION_LAYER_NAME', '');
define('SIG_MAP_INTERACTION_SELECTION_LAYER_VALUES', '');
define('SIG_MAP_INTERACTION_SELECTION_IS_INTERACTIVE', false);
define('SIG_MAP_INTERACTION_POSITION_JAVASCRIPT_FUNCTION', 'mapInteractionPosition');
define('SIG_MAP_INTERACTION_POSITION_IS_INTERACTIVE', false);
define('SIG_MAP_URL_PORTHOLE_SERVER_SOURCE', '');
define('SIG_MAP_MODE_MOUSE_SELECTION', '32');
define('SIG_MAP_MODE_MOUSE_PANORAMIQUE', '1');
define('SIG_MAP_DISPLAY_LOADING_TIME', '4500');

if ($_SERVER['SERVER_NAME'] == 'sigweb.mairie-aixenprovence.fr')
{
    /*
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://sigweb.mairie-aixenprovence.fr/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', 'sigweb.mairie-aixenprovence.fr');
    //define('SIG_MAP_MAP_GUIDE_PATH', 'mapguide2010/mapviewerajax/mapframe.aspx');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapguide2010/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'e:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/MapGuideEnterprise2010/WebServerExtensions/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/MapGuideEnterprise2010/WebServerExtensions/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/MapGuideEnterprise2010/Server/Schema/');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2010);
    */
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://sigweb.mairie-aixenprovence.fr/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', 'sigweb.mairie-aixenprovence.fr');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapserver2012/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'e:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'sigweb/PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/Autodesk Infrastructure Map Server 2012/Schema');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2012);
}
elseif ($_SERVER['SERVER_NAME'] == '192.168.50.3')
{
    /*
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://192.168.50.3/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', '192.168.50.3');
    //define('SIG_MAP_MAP_GUIDE_PATH', 'mapguide2010/mapviewerajax/mapframe.aspx');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapguide2010/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'e:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/MapGuideEnterprise2010/WebServerExtensions/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/MapGuideEnterprise2010/WebServerExtensions/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/MapGuideEnterprise2010/Server/Schema/');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2010);
    */
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://192.168.50.3/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', '192.168.50.3');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapserver2012/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'e:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'sigweb/PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/Autodesk Infrastructure Map Server 2012/Schema');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2012);
}
elseif ($_SERVER['SERVER_NAME'] == '192.168.50.15')
{
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://192.168.50.15/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', '192.168.50.15');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapserver2012/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'e:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'sigweb/PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/Autodesk Infrastructure Map Server 2012/Schema');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2012);
}
elseif ($_SERVER['SERVER_NAME'] == 'szosma.intranet')
{
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://szosma.intranet/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', 'szosma.intranet');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapguide2011/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'r:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'sigweb/PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/MapGuideEnterprise2011/WebServerExtensions/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/MapGuideEnterprise2011/WebServerExtensions/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/MapGuideEnterprise2011/Server/Schema/');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2011);
}
else
{
    /*
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://starentule.intranet/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', 'starentule.intranet');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapguide2011/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'r:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'sigweb/PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/MapGuideEnterprise2011/WebServerExtensions/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/MapGuideEnterprise2011/WebServerExtensions/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/MapGuideEnterprise2011/Server/Schema/');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2011);
    */
    
    define('SIG_MAP_URL_MAP_GUIDE_SERVER', 'http://starentule.intranet/');
    define('SIG_MAP_URL_MAP_GUIDE_SERVER_NAME', 'starentule.intranet');
    define('SIG_MAP_MAP_GUIDE_PATH', 'mapserver2012/mapviewerajax/');
    define('SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE', 'r:/sigweb/PHP/common/common.php');
    define('SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER', 'sigweb/PHP/web/common/sig/class_map/');
    define('SIG_MAP_PATH_VIEWERFILES', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/viewerfiles/');
    define('SIG_MAP_PATH_WEBCONFIG', 'C:/Program Files/Autodesk/Autodesk Infrastructure Web Server Extension 2012/www/webconfig.ini');
    define('SIG_MAP_PATH_SCHEMA_DIRECTORY', 'C:/Program Files/Autodesk/Autodesk Infrastructure Map Server 2012/Schema');
    define('SIG_MAP_MAP_GUIDE_VERSION_YEAR', 2012);
}

/**
 * Classe permettant l'affichage d'une carte et des infos sur une carte (claque...)
 */
class SigMap {
    
    /**
     * Log d'erreur a afficher
     * @var string
     */
    private $_log;
    
    /**
     * Defini si on est en mode debug ou non
     * @var boolean
     */
    private $_debugMode;
    
    /**
     * ID HTML de l'iframe
     * @var string
     */
    private $_iframeId;
    
    /**
     * Name HTML de l'iframe
     * @var string
     */
    private $_iframeName;
    
    /**
     * Src HTML de l'iframe
     * @var string
     */
    private $_iframeSrc;
    
    /**
     * Height HTML de l'iframe
     * @var string
     */
    private $_iframeHeight;
    
    /**
     * Width HTML de l'iframe
     * @var string
     */
    private $_iframeWidth;
    
    /**
     * Title HTML de l'iframe
     * @var string
     */
    private $_iframeTitle;
    
    /**
     * MapGuide - Chemin d'acces sur le fichier common
     * @var string
     */
    private $_mapGuideCommonPathFile;
    
    /**
     * MapGuide - Nom d'utilisateur
     * @var string
     */
    private $_mapGuideLogin;
    
    /**
     * MapGuide - Mot de passe
     * @var string
     */
    private $_mapGuidePassword;
    
    /**
     * MapGuide - WebLayout
     * @var string
     */
    private $_mapGuideWebLayout;
    
    /**
     * MapGuide - MapName
     * @var string
     */
    private $_mapGuideMapName;
    
    /**
     * MapGuide - LayerName
     * @var string
     */
    private $_mapGuideLayerName;
    
    /**
     * MapGuide - Session ID Name
     * @var string
     */
    private $_mapGuideSessionIdName;
    
    /**
     * MapGuide - Session ID 
     * @var string
     */
    private $_mapGuideSessionId;
    
    /**
     * MapGuide - repertoire qui contient les schema
     * @var string
     */
    private $_mapGuideSchemaDirectory;
    
    /**
     * Indique si l'on communique entre des iFrames sur deux nom de domaine different
     * @var boolean
     */
    private $_crossDomain;
    
    /**
     * Contient le path du javascript
     * @var string
     */
    private $_pathCommonJs;
    
    /**
     * Contient l'URL racine du javascript
     * @var string
     */
    private $_urlCommonJs;
    
    /**
     * Contient l'URL racine du nom de server mapguide
     * @var string
     */
    private $_urlMapGuideServer;
    
    /**
     * Contient le nom du repertoire contenant les fichier common sur le serveur mapguide
     * @var string
     */
    private $_pathCommonMapGuideServer;
    
    /**
     * Contient l'URL du serveur source pour l'appelle au javascript porthole
     * @var string
     */
    private $_urlPortholeServerSource;
    
    /**
     * Contient l'URL du web service a appeller pour recuperer les infos
     * @var string
     */
    private $_webServiceUrl;
    
    /**
     * Objet MgUserInformation
     * @var MgUserInformation
     */
    private $_userInfo;
    
    /**
     * Objet MgSiteConnection
     * @var MgSiteConnection
     */
    private $_siteConnection;
    
    /**
     * Objet MgSite
     * @var MgSite
     */
    private $_site;
    
    /**
     * Objet MgResourceIdentifier
     * @var MgResourceIdentifier
     */
    private $_resourceId;
    
    /**
     * Objet MgMap
     * @var MgMap
     */
    private $_map;
    
    /**
     * Variable MgServiceType::ResourceService
     * @var MgServiceType::ResourceService
     */
    private $_resourceService;
    
    /**
     * Tableau contenant les informations des layers
     * @var array
     */
    private $_layers;
    
    /**
     * Defini si on doit activer le zoom
     * @var boolean
     */
    private $_zoom_activated;
    
    /**
     * Defini la position X du zoom
     * @var string
     */
    private $_zoom_x;
    
    /**
     * Defini la position Y du zoom
     * @var string
     */
    private $_zoom_y;
    
    /**
     * Defini l'echelle du zoom
     * @var string
     */
    private $_zoom_scale;
    
    /**
     * Tableau contenant les conditions pour avoir des objet selectionne
     * @var array
     */
    private $_selection_object_condition;
    
    /**
     * Nom de la methode javascript sur l'interaction de selection
     * @var string
     */
    private $_interaction_selection_javascript_function;
    
    /**
     * Nom du claque a verifier pour la selection
     * @var string
     */
    private $_interaction_selection_layer_name;
    
    /**
     * Nom de la valeur a verifier pour la selection
     * @var string / array
     */
    private $_interaction_selection_layer_values;
    
    /**
     * Indique si l'interaction de selection est autorise
     * @var boolean
     */
    private $_interaction_selection_is_interactive;
    
    /**
     * Nom de la methode javascript sur l'interaction de position
     * @var string
     */
    private $_interaction_position_javascript_function;
    
    /**
     * Indique si l'interaction de position est autorise
     * @var boolean
     */
    private $_interaction_position_is_interactive;
    
    /**
     * Contient la liste de toute les point a afficher
     * @var array
     */
    private $_list_point;
    
    /**
     * Contient le code HTML a ajouter dans le HEAD de la page
     * @var string
     */
    private $_htmlHead;
    
    /**
     * Contient le code HTML a ajouter dans le debut du BODY de la page
     * @var string
     */
    private $_htmlBodyStart;
    
    /**
     * Contient le code HTML a ajouter dans la fin du BODY de la page
     * @var string
     */
    private $_htmlBodyEnd;
    
    /**
     * Indique si on est dans une iframe
     * @var boolean
     */
    private $_useIframe;
    
    /**
     * Indique le mode par defaut de la souris
     * @var integer
     */
    private $_defaultModeMouse;
    
    /**
     * Temps d'affichage de l'ecran de chargement
     * @var integer
     */
    private $_display_loading;
    
    /**
     * Image de loading encode en base64
     * @var string
     */
    private $_image_loading_base64;
    
    /**
     * Constructeur
     * @param array - $aParams - tableau de paramettre
     * <ul>
     *  <li>debug_mode - <i>boolean</i> - indique si on est en mode debug ou pas (defaut : false)</li>
     *  <li>iframe_id - <i>string</i> - id de l'iframe (defaut : iframeMap)</li>
     *  <li>iframe_name - <i>string</i> - name de l'iframe (defaut : iframeMap)</li>
     *  <li>iframe_src - <i>string</i> - src de l'iframe (defaut : http://starentule.intranet/sigweb/PHP/web/common/sig/class_map/mapframe.php)</li>
     *  <li>iframe_height - <i>string</i> - height de l'iframe (defaut : 800)</li>
     *  <li>iframe_width - <i>string</i> - width de l'iframe (defaut : 800)</li>
     *  <li>iframe_title - <i>string</i> - title de l'iframe (defaut : Cadastre)</li>
     *  <li>mapguide_common_file - <i>string</i> - MapGuide : localisation du fichier common (defaut : r:/sigweb/PHP/common/common.php)</li>
     *  <li>mapguide_login - <i>string</i> - MapGuide : Nom d'utilisateur de connection (defaut : "Anonymous")</li>
     *  <li>mapguide_password - <i>string</i> - MapGuide : Mot de passe de connection (defaut : "")</li>
     *  <li>mapguide_weblayout - <i>string</i> - MapGuide : WebLayout (defaut : Library://DIFFUSION/SIGAIX/CADASTRE.WebLayout)</li>
     *  <li>mapguide_mapname - <i>string</i> - MapGuide : MapName (defaut : CADASTRE)</li>
     *  <li>mapguide_layername - <i>string</i> - MapGuide : LayerName (defaut : VR_V_VOIES)</li>
     *  <li>use_iframe - <i>boolean</i> - indique si l'on utilise une iframe (defaut : true)</li>
     *  <li>default_mode_mouse - <i>integer</i> - Mode par defaut de la souris (selection=32 (par defaut), panoramique=1)</li>
     * </ul>
     */
    public function __construct($aParams = array()) {
        $this->_init($aParams);
    }
    
    /**
     * Initialise les valeurs par defaut
     * @param array - $aParams - tableau de paramettre
     * <ul>
     *  <li>debug_mode - <i>boolean</i> - indique si on est en mode debug ou pas (defaut : false)</li>
     *  <li>iframe_id - <i>string</i> - id de l'iframe (defaut : iframeMap)</li>
     *  <li>iframe_name - <i>string</i> - name de l'iframe (defaut : iframeMap)</li>
     *  <li>iframe_src - <i>string</i> - src de l'iframe (defaut : http://starentule.intranet/sigweb/PHP/web/common/sig/class_map/mapframe.php)</li>
     *  <li>iframe_height - <i>string</i> - height de l'iframe (defaut : 800)</li>
     *  <li>iframe_width - <i>string</i> - width de l'iframe (defaut : 800)</li>
     *  <li>iframe_title - <i>string</i> - title de l'iframe (defaut : Cadastre)</li>
     *  <li>mapguide_common_file - <i>string</i> - MapGuide : localisation du fichier common (defaut : r:/sigweb/PHP/common/common.php)</li>
     *  <li>mapguide_login - <i>string</i> - MapGuide : Nom d'utilisateur de connection (defaut : "Anonymous")</li>
     *  <li>mapguide_password - <i>string</i> - MapGuide : Mot de passe de connection (defaut : "")</li>
     *  <li>mapguide_weblayout - <i>string</i> - MapGuide : WebLayout (defaut : Library://DIFFUSION/SIGAIX/CADASTRE.WebLayout)</li>
     *  <li>mapguide_mapname - <i>string</i> - MapGuide : MapName (defaut : CADASTRE)</li>
     *  <li>mapguide_layername - <i>string</i> - MapGuide : LayerName (defaut : VR_V_VOIES)</li>
     *  <li>use_iframe - <i>boolean</i> - indique si l'on utilise une iframe (defaut : true)</li>
     *  <li>default_mode_mouse - <i>integer</i> - Mode par defaut de la souris (selection=32 (par defaut), panoramique=1)</li>
     * </ul>
     */
    private function _init($aParams = array()) {
        $this->_log = '';
        
        // Information cote fichier frame
        $this->_urlCommonJs = SIG_MAP_URL_COMMON_JS;
        $this->_pathCommonJs = SIG_MAP_PATH_COMMON_JS;
        
        // Information cote mapguide
        $this->_urlMapGuideServer = SIG_MAP_URL_MAP_GUIDE_SERVER;
        $this->_pathCommonMapGuideServer = SIG_MAP_PATH_COMMON_MAP_GUIDE_SERVER;
        
        $this->_resourceId = null;
        $this->_map = null;
        $this->_resourceService = null;
        
        if (isset($aParams['debug_mode']) == true
            && strlen($aParams['debug_mode']))
        {
            $this->_debugMode = (int)$aParams['debug_mode'];
        } else {
            $this->_debugMode = SIG_MAP_DEBUG_MODE;
        }
        
        // On set le paramettre frame ID
        if (isset($aParams['iframe_id']) == true
            && strlen($aParams['iframe_id']) > 0)
        {
            $this->_iframeId = $aParams['iframe_id'];
        } else {
            $this->_iframeId = SIG_MAP_IFRAME_ID;
        }
        
        // On set le paramettre frame name
        if (isset($aParams['iframe_name']) == true
            && strlen($aParams['iframe_name']) > 0)
        {
            $this->_iframeName = $aParams['iframe_name'];
        } else {
            $this->_iframeName = SIG_MAP_IFRAME_NAME;
        }
        
        // On set le paramettre frame scr
        if (isset($aParams['iframe_src']) == true
            && strlen($aParams['iframe_src']) > 0)
        {
            $this->_iframeSrc = $aParams['iframe_src'];
        } else {
            $this->_iframeSrc = $this->_urlMapGuideServer.$this->_pathCommonMapGuideServer.SIG_MAP_IFRAME_SRC;
        }
        
        // On set le paramettre frame height
        if (isset($aParams['iframe_height']) == true
            && strlen($aParams['iframe_height']) > 0)
        {
            $this->_iframeHeight = $aParams['iframe_height'];
        } else {
            $this->_iframeHeight = SIG_MAP_IFRAME_HEIGHT;
        }
        
        // On set le paramettre frame width
        if (isset($aParams['iframe_width']) == true
            && strlen($aParams['iframe_width']) > 0)
        {
            $this->_iframeWidth = $aParams['iframe_width'];
        } else {
            $this->_iframeWidth = SIG_MAP_IFRAME_WIDTH;
        }
        
        // On set le titre de la frame
        if (isset($aParams['iframe_title']) == true
            && strlen($aParams['iframe_title']) > 0)
        {
            $this->_iframeTitle = $aParams['iframe_title'];
        } else {
            $this->_iframeTitle = SIG_MAP_IFRAME_TITLE;
        }
        
        // MapGuide - Chemin d'acces vers le fichier common
        if (isset($aParams['mapguide_common_file']) == true
            && strlen($aParams['mapguide_common_file']) > 0)
        {
            $this->_mapGuideCommonPathFile = $aParams['mapguide_common_file'];
        } else {
            $this->_mapGuideCommonPathFile = SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE;
        }
        
        // MapGuide - Nom d'utilisateur
        if (isset($aParams['mapguide_login']) == true
            && strlen($aParams['mapguide_login']) > 0)
        {
            $this->_mapGuideLogin = $aParams['mapguide_login'];
        } else {
            $this->_mapGuideLogin = SIG_MAP_MAP_GUIDE_LOGIN;
        }
        
        // MapGuide - Mot de passe
        if (isset($aParams['mapguide_password']) == true
            && strlen($aParams['mapguide_password']) > 0)
        {
            $this->_mapGuidePassword = $aParams['mapguide_password'];
        } else {
            $this->_mapGuidePassword = SIG_MAP_MAP_GUIDE_PASSWORD;
        }
        
        // MapGuide - WebLayout
        if (isset($aParams['mapguide_weblayout']) == true
            && strlen($aParams['mapguide_weblayout']) > 0)
        {
            $this->_mapGuideWebLayout = $aParams['mapguide_weblayout'];
        } else {
            $this->_mapGuideWebLayout = SIG_MAP_MAP_GUIDE_WEB_LAYOUT;
        }
        
        // MapGuide - MapName
        if (isset($aParams['mapguide_mapname']) == true
            && strlen($aParams['mapguide_mapname']) > 0)
        {
            $this->_mapGuideMapName = $aParams['mapguide_mapname'];
        } else {
            $this->_mapGuideMapName = SIG_MAP_MAP_GUIDE_MAP_NAME;
        }
        
        // MapGuide - LayerName
        if (isset($aParams['mapguide_layername']) == true
            && strlen($aParams['mapguide_layername']) > 0)
        {
            $this->_mapGuideLayerName = $aParams['mapguide_layername'];
        } else {
            $this->_mapGuideLayerName = SIG_MAP_MAP_GUIDE_LAYER_NAME;
        }
        
        // MapGuide - WebLayout
        if (isset($aParams['mapguide_session_id_name']) == true
            && strlen($aParams['mapguide_session_id_name']) > 0)
        {
            $this->_mapGuideSessionIdName = $aParams['mapguide_session_id_name'];
        } else {
            $this->_mapGuideSessionIdName = SIG_MAP_MAP_GUIDE_SESSION_ID_NAME;
        }
        
        $this->_mapGuideSessionId = '';
        
        $this->_mapGuideSchemaDirectory = '';
        
        // Indique si la frame principal et la frame de la map sont sur le meme nom de domaine
        if (isset($aParams['cross_domain']) == true
            && is_bool($aParams['cross_domain']) == true)
        {
            $this->_crossDomain = $aParams['cross_domain'];
        } else {
            $this->_crossDomain = SIG_MAP_CROSS_DOMAIN;
        }
        
        // URL de l'appelle au webservice pour recupere les layers et autre informations
        if (isset($aParams['web_service_url']) == true
            && strlen($aParams['web_service_url']) > 0)
        {
            $this->_webServiceUrl = $aParams['web_service_url'];
        } else {
            $this->_webServiceUrl = $this->_urlMapGuideServer.$this->_pathCommonMapGuideServer.SIG_MAP_WEB_SERVICE_URL;
        }
        
        // Information sur les layers si layers un string, en le deserialise
        if (isset($aParams['layers']) == true) {
            if (is_string($aParams['layers']) == true) {
                $this->_layers = unserialize($aParams['layers']);
            } else {
                $this->_layers = $aParams['layers'];
            }
        } else {
            $this->_layers = array();
        }
        
        // Position X du zoom
        if (isset($aParams['zoom_x']) == true
            && strlen($aParams['zoom_x']) > 0)
        {
            $this->_zoom_x = $aParams['zoom_x'];
        } else {
            $this->_zoom_x = SIG_MAP_ZOOM_X;
        }
        
        // Position Y du zoom 
        if (isset($aParams['zoom_y']) == true
            && strlen($aParams['zoom_y']) > 0)
        {
            $this->_zoom_y = $aParams['zoom_y'];
        } else {
            $this->_zoom_y = SIG_MAP_ZOOM_Y;
        }
        
        // Echelle du zoom 
        if (isset($aParams['zoom_scale']) == true
            && strlen($aParams['zoom_scale']) > 0)
        {
            $this->_zoom_scale = $aParams['zoom_scale'];
        } else {
            $this->_zoom_scale = SIG_MAP_ZOOM_SCALE;
        }
        
        // Si la position X, Y et l'echelle sont defini alors on defini le zoom comme actif
        if (is_string($this->_zoom_x) == true
            && strlen($this->_zoom_x) > 0
            && is_string($this->_zoom_y) == true
            && strlen($this->_zoom_y) > 0
            && is_string($this->_zoom_scale) == true
            && strlen($this->_zoom_scale) > 0)
        {
            $this->_zoom_activated = true;
        } else {
            $this->_zoom_activated = SIG_MAP_ZOOM_ACTIVATED;
        }
        
        // condition des objets a selectionnes
        if (isset($aParams['selection_object_condition']) == true) {
            if (is_string($aParams['selection_object_condition']) == true) {
                $this->_selection_object_condition = unserialize($aParams['selection_object_condition']);
            } else {
                $this->_selection_object_condition = $aParams['selection_object_condition'];
            }
        } else {
            $this->_selection_object_condition = array();
        }
        
        // on recupere le nom de la methode javascript pour les interaction sur les selection
        if (isset($aParams['interaction_selection_javascript_function']) == true
            && strlen($aParams['interaction_selection_javascript_function']) > 0)
        {
            $this->_interaction_selection_javascript_function = $aParams['interaction_selection_javascript_function'];
        } else {
            $this->_interaction_selection_javascript_function = SIG_MAP_INTERACTION_SELECTION_JAVASCRIPT_FUNCTION;
        }
        
        // on recupere le nom du claque a verifier pour la selection
        if (isset($aParams['interaction_selection_layer_name']) == true
            && strlen($aParams['interaction_selection_layer_name']) > 0)
        {
            $this->_interaction_selection_layer_name = $aParams['interaction_selection_layer_name'];
        } else {
            $this->_interaction_selection_layer_name = SIG_MAP_INTERACTION_SELECTION_LAYER_NAME;
        }
        
        // on recupere le nom de la valeur a verifier pour la selection
        if (isset($aParams['interaction_selection_layer_values']) == true)
        {
            if (is_array($aParams['interaction_selection_layer_values']) == true
                && count($aParams['interaction_selection_layer_values']) > 0)
            {
                $this->_interaction_selection_layer_values = $aParams['interaction_selection_layer_values'];
            } else {
                $this->_interaction_selection_layer_values = $aParams['interaction_selection_layer_values'];
                
                $data = @unserialize($this->_interaction_selection_layer_values);
                
                if (is_array($data) == true) {
                    $this->_interaction_selection_layer_values = $data;
                }
            }
        } else {
            $this->_interaction_selection_layer_values = SIG_MAP_INTERACTION_SELECTION_LAYER_VALUES;
        }
        
        // on indique si l'interaction sur les selection est autorise
        if (isset($aParams['interaction_selection_is_interactive']) == true
            && $aParams['interaction_selection_is_interactive'] == true)
        {
            $this->_interaction_selection_is_interactive = $aParams['interaction_selection_is_interactive'];
        }
        elseif (isset($aParams['interaction_selection_javascript_function']) == true
            && strlen($aParams['interaction_selection_javascript_function']) > 0
            && isset($aParams['interaction_selection_layer_name']) == true
            && strlen($aParams['interaction_selection_layer_name']) > 0
            && isset($aParams['interaction_selection_layer_values']) == true
            && strlen($aParams['interaction_selection_layer_values']) > 0)
        {
            $this->_interaction_selection_is_interactive = true;
        }
        else
        {
            $this->_interaction_selection_is_interactive = SIG_MAP_INTERACTION_SELECTION_IS_INTERACTIVE;
        }
        
        // on recupere le nom de la methode javascript pour les interaction sur les positions
        if (isset($aParams['interaction_position_javascript_function']) == true
            && strlen($aParams['interaction_position_javascript_function']) > 0)
        {
            $this->_interaction_position_javascript_function = $aParams['interaction_position_javascript_function'];
        } else {
            $this->_interaction_position_javascript_function = SIG_MAP_INTERACTION_POSITION_JAVASCRIPT_FUNCTION;
        }
        
        // on indique si l'interaction sur les position est autorise
        if (isset($aParams['interaction_position_is_interactive']) == true
            && is_bool($aParams['interaction_position_is_interactive']) == true)
        {
            $this->_interaction_position_is_interactive = $aParams['interaction_position_is_interactive'];
        }
        elseif (isset($aParams['interaction_position_javascript_function']) == true
            && strlen($aParams['interaction_position_javascript_function']) > 0)
        {
            $this->_interaction_position_is_interactive = true;
        }
        else
        {
            $this->_interaction_position_is_interactive = SIG_MAP_INTERACTION_POSITION_IS_INTERACTIVE;
        }
        
        // on recuperer la liste des points a afficher
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // TODO : gerer les points
        
        if (isset($aParams['list_point']) == true)
        {
            if (is_array($aParams['list_point']) == true
                && count($aParams['list_point']) > 0)
            {
                $this->_list_point = $aParams['list_point'];
            }
            else
            {
                $this->_list_point = $aParams['list_point'];
        
                $data = @unserialize($this->_list_point);
        
                if (is_array($data) == true) {
                    $this->_list_point = $data;
                }
            }
        } else {
            $this->_list_point = array();
        }
        
        
        
        // URL du serveur source pour le script porthole
        if (isset($aParams['url_porthole_server_source']) == true
            && strlen($aParams['url_porthole_server_source']) > 0)
        {
            $this->_urlPortholeServerSource = $aParams['url_porthole_server_source'];
        } else {
            $this->_urlPortholeServerSource = SIG_MAP_URL_PORTHOLE_SERVER_SOURCE;
        }
        
        // Partie HTML a ajouter dans le corp de la page
        $this->_htmlHead = '';
        $this->_htmlBodyStart = '';
        $this->_htmlBodyEnd = '';
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // TODO : ajouter la definition pour indiquer que ce n'est pas une iframe (utile pour le javascript)
        
        if (isset($aParams['use_iframe']) == true
            && is_bool($aParams['use_iframe']) == true)
        {
            $this->_useIframe = $aParams['use_iframe'];
        }
        else
        {
            $this->_useIframe = true;
        }
        
        if (isset($aParams['default_mode_mouse']) == true
            && strlen($aParams['default_mode_mouse']) > 0)
        {
            $this->_defaultModeMouse = $aParams['default_mode_mouse'];
        } else {
            $this->_defaultModeMouse = SIG_MAP_MODE_MOUSE_SELECTION;
        }
        
        if (isset($aParams['display_loading']) == true
            && strlen($aParams['display_loading']) > 0)
        {
            $this->_display_loading = $aParams['display_loading'];
        } else {
            $this->_display_loading = '';
        }
        
        $this->_image_loading_base64 = 'data:image/gif;base64,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';
        
    }
    
    /**
     * Getter pour recupere les informations d'une variable de la classe et renvoi les informations
     * @param string - $key - nom de la variable de la classe
     * @return mixed - retour la valeur de la cle
     */
    public function get($key = '') {
        $retour = null;
        
        if (strlen($key) > 0
            && isset($this->$key) == true)
        {
            $retour = $this->$key;
        }
        
        return $retour;
    }
    
    /**
     * Setter pour mettre a jour les information d'une variable de classe
     * @param string - $key - nom de la variable de classe
     * @param mixed - $value - valeur a remplir
     * @return boolean - retourne TRUE si mise a jour c'est bien passe
     */
    public function set($key = '', $value = null) {
        $retour = false;
        
        if (strlen($key) > 0
            && isset($this->$key) == true)
        {
            $this->$key = $value;
            $retour = true;
        }
        
        return $retour;
    }
    
    /**
     * Ajoute tu texte au log
     * @param string $log
     */
    private function _addLog($text = '') {
        
        if (is_string($text) == true
            && strlen($text) > 0)
        {
            $this->_log .= $text."\n";
        }
        
        if ($this->_debugMode == 1) {
            echo $text."\n";
        }
        
    }
    
    /**
     * Methode qui verifie que la methode a appeller existe et l'appelle
     * @param array - $aParams - tableau de paramettre
     * @return mixed - retourne la valeur retourne par la methode appelle
     */
    public function dispatchWs($aParams = array()) {
        $retour = false;
        
        if (isset($aParams['method']) == true
            && strlen($aParams['method']) > 0
            && preg_match('/^_.*/', $aParams['method']) == 0
            && method_exists($this, $aParams['method']) == true
                //method_exists ( mixed $object , string $method_name )
            )
        {
            $retour = $this->$aParams['method']($aParams);
        }
        
        return $retour;
    }
    
    /**
     * Verifier si l'on se trouve sur un serveur MapGuide
     * @param array - $aParams - tableau de paramettre
     * @return boolean - retour TRUE si l'on est sur un serveur MapGuide
     */
    private function _isMapGuideServer($aParams = array()) {
        $retour = false;
        
        if (isset($_SERVER['SERVER_NAME']) == true
            && strlen($_SERVER['SERVER_NAME']) > 0
            && $_SERVER['SERVER_NAME'] == SIG_MAP_URL_MAP_GUIDE_SERVER_NAME)
            //&& $_SERVER['SERVER_NAME'] == 'starentule.intranet')
        {
            $retour = true;
        }
        else
        {
            // Si on n'est pas sur le serveur mapguide on stock le nom du server
            $this->_urlPortholeServerSource = 'http://'.$_SERVER['SERVER_NAME'].'/'.$this->_pathCommonJs.'/';
            
        }
        
        return $retour;
    }
    
    /**
     * On verifi su on est dans le cas l'on est sur plusieur nom de domaine HTTP
     * @param array - $aParams - tableau de paramettre
     */
    private function _isCrossDomain($aParams = array()) {
        $retour = false;
        
        if (isset($this->_crossDomain) == true
            && is_bool($this->_crossDomain) == true)
        {
            $retour = $this->_crossDomain;
        }
        
        return $retour;
    }
    
    /**
     * Retour un tableau php contenant les paramettres de configurations
     * @param array - $aParams - tableau de paramettre
     * @return array - tableau contenant toute les informations de configuration
     */
    private function _getConfigParams($aParams = array()) {
        $retour = array();
        
        if ($this->_debugMode == true)
        {
            $retour['debug_mode'] = $this->_debugMode;
        }
        
        if (strlen($this->_iframeId) > 0
            && $this->_iframeId != SIG_MAP_IFRAME_ID)
        {
            $retour['iframe_id'] = $this->_iframeId;
        }
        
        if (strlen($this->_iframeName) > 0
            && $this->_iframeName != SIG_MAP_IFRAME_NAME)
        {
            $retour['iframe_name'] = $this->_iframeName;
        }
        
        if (strlen($this->_iframeSrc) > 0
            && $this->_iframeSrc != $this->_urlMapGuideServer.$this->_pathCommonMapGuideServer.SIG_MAP_IFRAME_SRC)
        {
            $retour['iframe_src'] = $this->_iframeSrc;
        }
        
        if (strlen($this->_iframeHeight) > 0
            && $this->_iframeHeight != SIG_MAP_IFRAME_HEIGHT)
        {
            $retour['iframe_height'] = $this->_iframeHeight;
        }
        
        if (strlen($this->_iframeWidth) > 0
            && $this->_iframeWidth != SIG_MAP_IFRAME_WIDTH)
        {
            $retour['iframe_width'] = $this->_iframeWidth;
        }
        
        if (strlen($this->_iframeTitle) > 0
            && $this->_iframeTitle != SIG_MAP_IFRAME_TITLE)
        {
            $retour['iframe_title'] = $this->_iframeTitle;
        }
        
        if (strlen($this->_mapGuideCommonPathFile) > 0
            && $this->_mapGuideCommonPathFile != SIG_MAP_MAP_GUIDE_COMMON_PATH_FILE)
        {
            $retour['mapguide_common_file'] = $this->_mapGuideCommonPathFile;
        }
        
        if (strlen($this->_mapGuideLogin) > 0
            && $this->_mapGuideLogin != SIG_MAP_MAP_GUIDE_LOGIN)
        {
            $retour['mapguide_login'] = $this->_mapGuideLogin;
        }
        
        if (strlen($this->_mapGuidePassword) > 0
            && $this->_mapGuidePassword != SIG_MAP_MAP_GUIDE_PASSWORD)
        {
            $retour['mapguide_password'] = $this->_mapGuidePassword;
        }
        
        if (strlen($this->_mapGuideWebLayout) > 0
            && $this->_mapGuideWebLayout != SIG_MAP_MAP_GUIDE_WEB_LAYOUT)
        {
            $retour['mapguide_weblayout'] = $this->_mapGuideWebLayout;
        }
        
        if (strlen($this->_mapGuideMapName) > 0
            && $this->_mapGuideMapName != SIG_MAP_MAP_GUIDE_MAP_NAME)
        {
            $retour['mapguide_mapname'] = $this->_mapGuideMapName;
        }
        
        if (strlen($this->_mapGuideLayerName) > 0
            && $this->_mapGuideLayerName != SIG_MAP_MAP_GUIDE_LAYER_NAME)
        {
            $retour['mapguide_layername'] = $this->_mapGuideLayerName;
        }
        
        if (strlen($this->_mapGuideSessionIdName) > 0
            && $this->_mapGuideSessionIdName != SIG_MAP_MAP_GUIDE_SESSION_ID_NAME)
        {
            $retour['mapguide_session_id_name'] = $this->_mapGuideSessionIdName;
        }
        
        if (strlen($this->_webServiceUrl) > 0) {
            $retour['web_service_url'] = $this->_webServiceUrl;
        }
        
        if (is_array($this->_layers) == true
            && count($this->_layers) > 0)
        {
            $retour['layers'] = urlencode(serialize($this->_layers));
        }
        
        if (strlen($this->_zoom_x) > 0
            && $this->_zoom_x != SIG_MAP_ZOOM_X)
        {
            $retour['zoom_x'] = $this->_zoom_x;
        }
        
        if (strlen($this->_zoom_y) > 0
            && $this->_zoom_y != SIG_MAP_ZOOM_Y)
        {
            $retour['zoom_y'] = $this->_zoom_y;
        }
        
        if (strlen($this->_zoom_scale) > 0
            && $this->_zoom_scale != SIG_MAP_ZOOM_SCALE)
        {
            $retour['zoom_scale'] = $this->_zoom_scale;
        }
        
        if (is_array($this->_selection_object_condition) == true
            && count($this->_selection_object_condition) > 0)
        {
            $retour['selection_object_condition'] = urlencode(serialize($this->_selection_object_condition));
        }
        
        if (strlen($this->_interaction_selection_is_interactive) > 0
            && $this->_interaction_selection_is_interactive != SIG_MAP_INTERACTION_SELECTION_IS_INTERACTIVE)
        {
            $retour['interaction_selection_is_interactive'] = $this->_interaction_selection_is_interactive;
        }
        
        if (strlen($this->_interaction_selection_javascript_function) > 0
            && $this->_interaction_selection_javascript_function != SIG_MAP_INTERACTION_SELECTION_JAVASCRIPT_FUNCTION)
        {
            $retour['interaction_selection_javascript_function'] = $this->_interaction_selection_javascript_function;
        }
        
        if (strlen($this->_interaction_selection_layer_name) > 0)
        {
            $retour['interaction_selection_layer_name'] = $this->_interaction_selection_layer_name;
        }
        
        if (is_array($this->_interaction_selection_layer_values) == true
            && count($this->_interaction_selection_layer_values) > 0)
        {
            $retour['interaction_selection_layer_values'] = urlencode(serialize($this->_interaction_selection_layer_values));
        }
        elseif (strlen($this->_interaction_selection_layer_values) > 0)
        {
            $retour['interaction_selection_layer_values'] = $this->_interaction_selection_layer_values;
        }
        
        if (strlen($this->_interaction_position_is_interactive) > 0
            && $this->_interaction_position_is_interactive != SIG_MAP_INTERACTION_POSITION_IS_INTERACTIVE)
        {
            $retour['interaction_position_is_interactive'] = $this->_interaction_position_is_interactive;
        }
        
        if (strlen($this->_interaction_position_javascript_function) > 0
            && $this->_interaction_position_javascript_function != SIG_MAP_INTERACTION_POSITION_JAVASCRIPT_FUNCTION)
        {
            $retour['interaction_position_javascript_function'] = $this->_interaction_position_javascript_function;
        }
        
        if (is_array($this->_list_point) == true)
        {
            if (count($this->_list_point) > 0)
            {
                $retour['list_point'] = urlencode(serialize($this->_list_point));
            }
        }
        elseif (strlen($this->_list_point) > 0)
        {
            $retour['list_point'] = $this->_list_point;
        }
        
        if (strlen($this->_urlPortholeServerSource) > 0
            && $this->_urlPortholeServerSource != SIG_MAP_URL_PORTHOLE_SERVER_SOURCE)
        {
            $retour['url_porthole_server_source'] = $this->_urlPortholeServerSource;
        }
        
        if (strlen($this->_defaultModeMouse) > 0
            && $this->_defaultModeMouse != SIG_MAP_MODE_MOUSE_SELECTION)
        {
            $retour['default_mode_mouse'] = $this->_defaultModeMouse;
        }
        
        if (strlen($this->_display_loading) > 0)
        {
            $retour['display_loading'] = $this->_display_loading;
        }
        
        return $retour;
    }
    
    /**
     * Retourne le code HTML pour afficher la map, si on n'est pas sur un serveur MapGuide
     * @param array - $aParams - tableau de paramettre
     * <ul>
     *  <li>array - params - tableau contenant les paramettres a ajouter a l'url (cle : cle du paramettre, valeur : valeur du paramettre)</li>
     * </ul>
     * @return string - retourne le code HTML de l'iframe a afficher
     */
    private function _getHtmlOutMapGuideServer($aParams = array()) {
        $retour = '';
        
        $src = $this->_iframeSrc;
        
        // on ajoute à l'url les paramttre de configuration
        $configParams = $this->_getConfigParams();
        if (isset($configParams) == true
                && is_array($configParams) == true
                && count($configParams) > 0)
        {
            $parametter = '';
            foreach ($configParams as $paramKey => $paramValue) {
                if (strlen($parametter) > 0) {
                    $parametter .= '&';
                } else {
                    $parametter .= '?';
                }
                $parametter .= $paramKey.'='.$paramValue;
            }
            $src .= $parametter;
        }
        
        // on ajoute les paramettre fourni dans l'appel a la methode
        if (isset($aParams['params']) == true
            && is_array($aParams['params']) == true
            && count($aParams['params']) > 0)
        {
            $parametter = '';
            foreach ($aParams['params'] as $paramKey => $paramValue) {
                if (strlen($parametter) > 0) {
                    $parametter .= '&';
                } else {
                    $parametter .= '?';
                }
                $parametter .= $paramKey.'='.$paramValue;
            }
            $src .= $parametter;
        }
        
        $retour .= '<iframe';
        $retour .= ' id="'.$this->_iframeId.'"';
        $retour .= ' name="'.$this->_iframeName.'"';
        $retour .= ' src="'.$src.'"';
        $retour .= ' height="'.$this->_iframeHeight.'"';
        $retour .= ' width="'.$this->_iframeWidth.'"';
        $retour .= '></iframe>'."\n";
        
        $retour .= '<script type="text/javascript" src="'.$this->_urlCommonJs.$this->_pathCommonJs.'/porthole.min.js"></script>';
        $retour .= '<script type="text/javascript">';
        
        
        $retour .= '
        
        var currentScale = null;
        
        /**
        * On va gerer les fonction multiple dans le window.onload
        */
        if (typeof addLoadEvent != \'function\')
        {
            function addLoadEvent(func)
            {
                var oldonload = window.onload;
                if (typeof window.onload != \'function\')
                {
                    window.onload = func;
                }
                else
                {
                    window.onload = function()
                    {
                        if (oldonload)
                        {
                            oldonload();
                        }
                        func();
                    }
                }
            }
        }
        ';
        
        if ($this->_iframeName != 'iframeMap')
        {
            $prefixFunction = $this->_iframeName;
        }
        else
        {
            $prefixFunction = '';
        }
        
        
        $retour .= '
        /**
         * fonction que l\'on appelle lors d\'une modification sur la carte
         * @params MessageEvent - messageEvent - classe contenant les message de l\'evenement
         *  <ul>
         *    <li>origin : Protocole et domainr d\'origine du message</li>
         *    <li>data : Message</li>
         *    <li>source : Objet proxy window, utiliser pour poster la reponse</li>
         *  </ul>
         */
        function portholeListener(messageEvent) {
            
            if (messageEvent.data != "")
            {
                var data = eval (messageEvent.data);
                
                if (typeof(data.fonction) != "undefined"
                    && typeof(eval(data.fonction)) == "function"
                    && typeof(data.commande) != "undefined"
                    && data.commande != "")
                {
                    eval(data.commande);
                    data = null;
                }
        ';
        
        
        
        // si on a des interactions on met en place
        if ($this->_interaction_selection_is_interactive == true
            || $this->_interaction_position_is_interactive == true)
        {
            if ($this->_interaction_selection_is_interactive == true)
            {
                $retour .= '
                    if (data != null
                        && typeof '.$this->_interaction_selection_javascript_function.' == \'function\')
                    {
                        if (typeof(data) != "undefined"
                            && typeof(data[0].x) == "undefined"
                            && typeof(data[0].y) == "undefined"
                            && typeof(data[0].scale) == "undefined")
                        {
                            '.$this->_interaction_selection_javascript_function.'(data);
                        }
                    }
                ';
            }
            
            if ($this->_interaction_position_is_interactive == true)
            {
                $retour .= '
                    if (data != null
                        && typeof '.$this->_interaction_position_javascript_function.' == \'function\')
                    {
                        if (typeof(data[0].x) != "undefined"
                            && typeof(data[0].y) != "undefined"
                            && typeof(data[0].scale) != "undefined")
                        {
                            '.$this->_interaction_position_javascript_function.'(data);
                        }
                    }
                ';
            }
            
        }
        
        $retour .= '
                //messageEvent.origin: Protocol and domain origin of the message
                //messageEvent.data: Message itself
                //messageEvent.source: Window proxy object, useful to post a response
            }
        }
        
        ';
        
        
        $retour .= '
        var '.$prefixFunction.'windowProxy;
        addLoadEvent(function() {
            // Create a proxy window to send to and receive
            // messages from the iFrame
            '.$prefixFunction.'windowProxy = new Porthole.WindowProxy(\''.$this->_urlMapGuideServer.$this->_pathCommonMapGuideServer.'/proxy.html\', \''.$this->_iframeName.'\');
            ';
        
            if ($this->_interaction_selection_is_interactive == true
                    || $this->_interaction_position_is_interactive == true)
            {
                $retour .= '
                // Register an event handler to receive messages;
                '.$prefixFunction.'windowProxy.addEventListener(portholeListener);
                ';
            }
        
        $retour .= '
        });
        
        ';
        
        
        $retour .= '
        function DigitizePoint(symbole, color, group, layer, mode)
        {
            '. //var fonction = "DigitizePoint(\'Cible_carre\',\'BA2F1F\',\'Localisation\',\'Point\', \'1\')";
            'var fonction = "DigitizePoint(\'" + symbole + "\',\'" + color + "\',\'" + group + "\',\'" + layer + "\', \'" + mode + "\')";
            '.$prefixFunction.'windowProxy.postMessage(fonction);
        }
        
        ';
        
        $retour .= '
        function serialize (mixed_value) {
            // Returns a string representation of variable (which can later be unserialized)  
            // 
            // version: 1109.2015
            // discuss at: http://phpjs.org/functions/serialize    // +   original by: Arpad Ray (mailto:arpad@php.net)
            // +   improved by: Dino
            // +   bugfixed by: Andrej Pavlovic
            // +   bugfixed by: Garagoth
            // +      input by: DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html)    // +   bugfixed by: Russell Walker (http://www.nbill.co.uk/)
            // +   bugfixed by: Jamie Beck (http://www.terabit.ca/)
            // +      input by: Martin (http://www.erlenwiese.de/)
            // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
            // +   improved by: Le Torbi (http://www.letorbi.de/)    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
            // +   bugfixed by: Ben (http://benblume.co.uk/)
            // -    depends on: utf8_encode
            // %          note: We feel the main purpose of this function should be to ease the transport of data between php & js
            // %          note: Aiming for PHP-compatibility, we have to translate objects to arrays    // *     example 1: serialize([\'Kevin\', \'van\', \'Zonneveld\']);
            // *     returns 1: \'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}\'
            // *     example 2: serialize({firstName: \'Kevin\', midName: \'van\', surName: \'Zonneveld\'});
            // *     returns 2: \'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}\'
            var _utf8Size = function (str) {
                var size = 0,
                    i = 0,
                    l = str.length,
                    code = \'\';
                for (i = 0; i < l; i++) {
                    code = str.charCodeAt(i);
                    if (code < 0x0080) {
                        size += 1;
                    } else if (code < 0x0800) {
                        size += 2;
                    } else {
                        size += 3;
                    }
                }
                return size;
            };
            var _getType = function (inp) {
                var type = typeof inp,
                    match;
                var key; 
                if (type === \'object\' && !inp) {
                    return \'null\';
                }
                if (type === "object") {
                    if (!inp.constructor) {
                        return \'object\';
                    }
                    var cons = inp.constructor.toString();
                    match = cons.match(/(\w+)\(/);
                    if (match) {
                        cons = match[1].toLowerCase();
                    }
                    var types = ["boolean", "number", "string", "array"];
                    for (key in types) {
                        if (cons == types[key]) {
                            type = types[key];
                            break;
                        }
                    }
                }
                return type;
            };
            var type = _getType(mixed_value);
            var val, ktype = \'\'; 
            switch (type) {
            case "function":
                val = "";
                break;
            case "boolean":
                val = "b:" + (mixed_value ? "1" : "0");
                break;
            case "number":
                val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
                break;
            case "string":
                val = "s:" + _utf8Size(mixed_value) + ":\"" + mixed_value + "\"";
                break;
            case "array":
            case "object":
                val = "a";
                    /*
                    if (type == "object") {
                        var objname = mixed_value.constructor.toString().match(/(\w+)\(\)/);
                        if (objname == undefined) {
                            return;
                        }
                        objname[1] = this.serialize(objname[1]);
                        val = "O" + objname[1].substring(1, objname[1].length - 1);
                    }
                    */
                var count = 0;
                var vals = "";
                var okey;        var key;
                for (key in mixed_value) {
                    if (mixed_value.hasOwnProperty(key)) {
                        ktype = _getType(mixed_value[key]);
                        if (ktype === "function") {
                            continue;
                        }
         
                        okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
                        vals += this.serialize(okey) + this.serialize(mixed_value[key]);
                        count++;
                    }
                }
                val += ":" + count + ":{" + vals + "}";
                break;    case "undefined":
                // Fall-through
            default:
                // if the JS object has a property which contains a null value, the string cannot be unserialized by PHP
                val = "N";
                break;
            }
            if (type !== "object" && type !== "array") {
                val += ";";
            }
            return val;
        }
        
        function unserialize (data) {
            // http://kevin.vanzonneveld.net
            // +     original by: Arpad Ray (mailto:arpad@php.net)
            // +     improved by: Pedro Tainha (http://www.pedrotainha.com)
            // +     bugfixed by: dptr1988
            // +      revised by: d3x
            // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
            // +        input by: Brett Zamir (http://brett-zamir.me)
            // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
            // +     improved by: Chris
            // +     improved by: James
            // +        input by: Martin (http://www.erlenwiese.de/)
            // +     bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
            // +     improved by: Le Torbi
            // +     input by: kilops
            // +     bugfixed by: Brett Zamir (http://brett-zamir.me)
            // +      input by: Jaroslaw Czarniak
            // %            note: We feel the main purpose of this function should be to ease the transport of data between php & js
            // %            note: Aiming for PHP-compatibility, we have to translate objects to arrays
            // *       example 1: unserialize(\'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}\');
            // *       returns 1: [\'Kevin\', \'van\', \'Zonneveld\']
            // *       example 2: unserialize(\'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}\');
            // *       returns 2: {firstName: \'Kevin\', midName: \'van\', surName: \'Zonneveld\'}
            var that = this,
                utf8Overhead = function (chr) {
                    // http://phpjs.org/functions/unserialize:571#comment_95906
                    var code = chr.charCodeAt(0);
                    if (code < 0x0080) {
                        return 0;
                    }
                    if (code < 0x0800) {
                        return 1;
                    }
                    return 2;
                },
                error = function (type, msg, filename, line) {
                    throw new that.window[type](msg, filename, line);
                },
                read_until = function (data, offset, stopchr) {
                    var i = 2, buf = [], chr = data.slice(offset, offset + 1);
        
                    while (chr != stopchr) {
                        if ((i + offset) > data.length) {
                            error(\'Error\', \'Invalid\');
                        }
                        buf.push(chr);
                        chr = data.slice(offset + (i - 1), offset + i);
                        i += 1;
                    }
                    return [buf.length, buf.join(\'\')];
                },
                read_chrs = function (data, offset, length) {
                    var i, chr, buf;
        
                    buf = [];
                    for (i = 0; i < length; i++) {
                        chr = data.slice(offset + (i - 1), offset + i);
                        buf.push(chr);
                        length -= utf8Overhead(chr);
                    }
                    return [buf.length, buf.join(\'\')];
                },
                _unserialize = function (data, offset) {
                    var dtype, dataoffset, keyandchrs, keys, 
                        readdata, readData, ccount, stringlength, 
                        i, key, kprops, kchrs, vprops, vchrs, value,
                        chrs = 0, 
                        typeconvert = function (x) {
                            return x;
                        };
        
                    if (!offset) {
                        offset = 0;
                    }
                    dtype = (data.slice(offset, offset + 1)).toLowerCase();
        
                    dataoffset = offset + 2;
        
                    switch (dtype) {
                        case \'i\':
                            typeconvert = function (x) {
                                return parseInt(x, 10);
                            };
                            readData = read_until(data, dataoffset, \';\');
                            chrs = readData[0];
                            readdata = readData[1];
                            dataoffset += chrs + 1;
                            break;
                        case \'b\':
                            typeconvert = function (x) {
                                return parseInt(x, 10) !== 0;
                            };
                            readData = read_until(data, dataoffset, \';\');
                            chrs = readData[0];
                            readdata = readData[1];
                            dataoffset += chrs + 1;
                            break;
                        case \'d\':
                            typeconvert = function (x) {
                                return parseFloat(x);
                            };
                            readData = read_until(data, dataoffset, \';\');
                            chrs = readData[0];
                            readdata = readData[1];
                            dataoffset += chrs + 1;
                            break;
                        case \'n\':
                            readdata = null;
                            break;
                        case \'s\':
                            ccount = read_until(data, dataoffset, \':\');
                            chrs = ccount[0];
                            stringlength = ccount[1];
                            dataoffset += chrs + 2;
        
                            readData = read_chrs(data, dataoffset + 1, parseInt(stringlength, 10));
                            chrs = readData[0];
                            readdata = readData[1];
                            dataoffset += chrs + 2;
                            if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
                                error(\'SyntaxError\', \'String length mismatch\');
                            }
                            break;
                        case \'a\':
                            readdata = {};
        
                            keyandchrs = read_until(data, dataoffset, \':\');
                            chrs = keyandchrs[0];
                            keys = keyandchrs[1];
                            dataoffset += chrs + 2;
        
                            for (i = 0; i < parseInt(keys, 10); i++) {
                                kprops = _unserialize(data, dataoffset);
                                kchrs = kprops[1];
                                key = kprops[2];
                                dataoffset += kchrs;
        
                                vprops = _unserialize(data, dataoffset);
                                vchrs = vprops[1];
                                value = vprops[2];
                                dataoffset += vchrs;
        
                                readdata[key] = value;
                            }
        
                            dataoffset += 1;
                            break;
                        default:
                            error(\'SyntaxError\', \'Unknown / Unhandled data type(s): \' + dtype);
                            break;
                    }
                    return [dtype, dataoffset - offset, typeconvert(readdata)];
                }
            ;
        
            return _unserialize((data + \'\'), 0)[2];
        }
        
        function checkParam(param)
        {
            param = (typeof param == \'undefined\') ? \'\' : param;
            return param;
        }
        
        function addLayer(layerDefinition, layerName, layerLegend, groupId, groupName)
        {
            layerDefinition = checkParam(layerDefinition);
            layerName = checkParam(layerName);
            layerLegend = checkParam(layerLegend);
            groupId = checkParam(groupId);
            groupName = checkParam(groupName);
            
            var fonction = "addLayer(\'"
                + layerDefinition + "\', \'"
                + layerName + "\', \'"
                + layerLegend + "\', \'"
                + groupId + "\', \'"
                + groupName + "\')";
            '.$prefixFunction.'windowProxy.postMessage(fonction);
        }
        
        function createLayer(featureClass, featureName, geometry, layerId, layerName, groupId, groupName, minScale, maxScale, layers)
        {
            // on verifi tout les paramettres
            featureClass = checkParam(featureClass);
            featureName = checkParam(featureName);
            geometry = checkParam(geometry);
            layerId = checkParam(layerId);
            layerName = checkParam(layerName);
            groupId = checkParam(groupId);
            groupName = checkParam(groupName);
            minScale = checkParam(minScale);
            maxScale = checkParam(maxScale);
            layers = checkParam(layers);
            layers = serialize(layers);
            layers = escape(layers);
            layers = encodeURI(layers);
            
            var fonction = "createLayer(\'"
                + featureClass + "\', \'"
                + featureName + "\', \'"
                + geometry + "\', \'"
                + layerId + "\', \'"
                + layerName + "\', \'"
                + groupId + "\', \'"
                + groupName + "\', \'"
                + minScale + "\', \'"
                + maxScale + "\', \'"
                + layers + "\')";
            '.$prefixFunction.'windowProxy.postMessage(fonction);
        }
        
        function editLayer(layerDefinition, layerName, layerLegend, layerGroupName, layerGroupLegend, layers, filter)
        {
            // on verifi tout les paramettres
            layerDefinition = checkParam(layerDefinition);
            layerName = checkParam(layerName);
            layerLegend = checkParam(layerLegend);
            layerGroupName = checkParam(layerGroupName);
            layerGroupLegend = checkParam(layerGroupLegend);
            layers = checkParam(layers);
            layers = serialize(layers);
            layers = escape(layers);
            layers = encodeURI(layers);
            filter = checkParam(filter);
            filter = filter.replace(/\'/g, "\\\\\'");
            
            var fonction = "editLayer(\'"
                + layerDefinition + "\', \'"
                + layerName + "\', \'"
                + layerLegend + "\', \'"
                + layerGroupName + "\', \'"
                + layerGroupLegend + "\', \'"
                + layers + "\', \'"
                + filter + "\')";
            '.$prefixFunction.'windowProxy.postMessage(fonction);
        }
        
        function toggleVisibility(layerName)
        {
            layerName = checkParam(layerName);
            
            var fonction = "ChangeLayerVisibility( \'"+ layerName +"\')";
            '.$prefixFunction.'windowProxy.postMessage(fonction);
        }
        
        function doRefresh()
        {
            var fonction = "iframeMap.Refresh()";
            '.$prefixFunction.'windowProxy.postMessage(fonction);
        }
        
        function getScalesLocal()
        {
            return currentScale;
        }
        
        function getScalesLocalRetour(scale)
        {
            currentScale = scale;
        }
        
        
        function sleep(milliseconds)
        {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++)
            {
                if ((new Date().getTime() - start) > milliseconds)
                {
                    break;
                }
            }
        }
        
        ';
        
        $retour .= '</script>';
        
        return $retour;
    }
    
    /**
     * Retourne le code HTML pour afficher la map, si on est sur un serveur MapGuide
     * @param array - $aParams - tableau de paramettre
     * @return string - retourne la page HTML a afficher
     */
    private function _getHtmlOnMapGuideServer($aParams = array()) {
        $retour = '';
        
        // MapGuide
        if ($this->_getMapGuideInstance($aParams) == true) {
            
            $layerOption = $this->_getMapGuideLayerOption($aParams);
            
            $javascriptZoomXY = $this->_getMapGuideJavascriptZoomXY($aParams);
            
            $javascriptSelection = $this->_getMapGuideJavascriptSelection($aParams);
            
            $javascriptDataSelection = $this->_getMapGuideJavascriptDataSelection($aParams);
            if (strlen($javascriptDataSelection) == 0) {
                $javascriptDataSelection = '""';
            }
            
            $javascriptDrawPoints = $this->_getMapGuideJavascriptDrawPoints($aParams);
            
            $url = $this->_urlMapGuideServer.SIG_MAP_MAP_GUIDE_PATH.'?SESSION='.$this->_mapGuideSessionId;
            
            $url .= '&WEBLAYOUT='.$this->_mapGuideWebLayout;
            //$url .= '&MAPDEFINITION='.$this->_mapGuideSessionIdName;
            
            //$url .= '&TYPE=HTML&SHOWLEGEND=1&SHOWPROP=0&INFOWIDTH=90&LOCALE=fr&HLTGT=2&HLTGTNAME=&SHOWSLIDER=1';
            
            /*
            &TYPE=HTML
            &SHOWLEGEND=1
            &SHOWPROP=0
            &INFOWIDTH=90
            &LOCALE=fr
            &HLTGT=2
            &HLTGTNAME=
            &SHOWSLIDER=1
            */
            
            if (strlen($this->_mapGuideLogin) > 0
                && $this->_mapGuideLogin == SIG_MAP_MAP_GUIDE_LOGIN)
            {
                $url .= '&USERNAME='.$this->_mapGuideLogin.'&PWD=';
            }
            
            if ($this->_useIframe == true)
            {
                $prefixParentJavascript = 'parent.';
            }
            else
            {
                $prefixParentJavascript = '';
            }
            
            // si on n'a pas defini de temps de chargement, on verifi si on doit en mettre un
            if (strlen($this->_display_loading) == 0)
            {
                if (
                        ($this->_zoom_activated == true)
                        ||
                        (is_string($this->_selection_object_condition) == true
                                && strlen($this->_selection_object_condition) > 0)
                        ||
                        (is_array($this->_selection_object_condition) == true
                                && count($this->_selection_object_condition) > 0)
                        ||
                        (is_string($this->_list_point) == true
                                && strlen($this->_list_point) > 0)
                        ||
                        (is_array($this->_list_point) == true
                                && count($this->_list_point) > 0)
                )
                {
                    $this->_display_loading = SIG_MAP_DISPLAY_LOADING_TIME;
                }
            }
            
            $retour .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
            <title>'.$this->_iframeTitle.'</title>
            
            <style type="text/css">
                * {
                    border: 0px;
                    margin: 0px;
                    padding: 0px;
                }
            </style>
            
            <script type="text/javascript" src="'.$this->_urlMapGuideServer.$this->_pathCommonMapGuideServer.'jquery.min.js"></script>
            <script type="text/javascript" src="'.$this->_urlMapGuideServer.$this->_pathCommonMapGuideServer.'porthole.min.js"></script>
            <script type="text/javascript" src="'.$this->_urlMapGuideServer.$this->_pathCommonMapGuideServer.'jquery.json-2.3.min.js"></script>
            
            <script language="javascript">
            
            ';
            
            if (strlen($this->_urlPortholeServerSource) > 0) {
                $retour .= '
                
                function portholeListener(messageEvent) {
                    if (messageEvent.data != "")
                    {
                        var data = eval (messageEvent.data);
                        
                    }
                    
                    //messageEvent.origin: Protocol and domain origin of the message
                    //messageEvent.data: Message itself
                    //messageEvent.source: Window proxy object, useful to post a response
                    
                }
                
                var windowProxy;
                window.onload=function(){
                    // Create a proxy window to send to and receive
                    // messages from the parent
                    windowProxy = new Porthole.WindowProxy(\''.$this->_urlPortholeServerSource.'proxy.html\');
                    
                    // Register an event handler to receive messages;
                    /*
                    windowProxy.addEventListener(function(event) {
                        // handle event
                    });
                    */
                    windowProxy.addEventListener(portholeListener);
                };
                ';
            }
            
            $retour .= '
            setTimeout("OnPageLoad()",3000);
            setTimeout("displayLoadingMap()",'.$this->_display_loading.');
            
            var intIntervalTime = 1000;
            var curentSelection = "";
            
            var iframe = null;
            var iframeMap = null;
            var frameOption = null;
            
            var xmlSelection;
            var xmlSelectionNew = "";
            
            var layersArray = Array();
            
            /**
             * Supprimer les espaces devant et derriere une string
             */
            function TrimString(responseString) {
                responseString = responseString.replace( /^\s+/g, "" );
                return responseString.replace( /\s+$/g, "" );
            }
            
            /**
             * Si jamais les variable iframe et iframeMap ne sont pas configurer, on les recupere
             */
            function getIframe() {
                
                if (iframe == null) {
                    iframe = document.getElementById("framemap");
                }
                
                if (iframeMap == null) {
                    iframeMap = iframe.contentWindow.GetMapFrame();
                }
            }
            
            /**
             * Recupere l\'objet pour faire les appels AJAX
             */
            function getXhr() {
                var xhr = null;
                if(window.XMLHttpRequest) { // Firefox et autres
                    xhr = new XMLHttpRequest();
                } else if(window.ActiveXObject) { // Internet Explorer
                    try {
                        xhr = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        xhr = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                } else { // XMLHttpRequest non supporté par le navigateur
                    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
                    xhr = false;
                }
                return xhr;
            }
            
            /**
             * Selection et zoom sur un objet
             * @params string - reqParams - paramettre de la requete pour recuperer les informations de la selection
             */
            function SelectAndZoom(reqParams) 
            {
                if (reqParams.length > 0)
                {
                    var reqHandler = getXhr();
                    if (reqHandler != false)
                    {
                        reqHandler.open("POST", "'.$this->_webServiceUrl.'", false);
                        reqHandler.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        
                        reqHandler.send(reqParams);
                        selectionXml = reqHandler.responseText;
                        
                        getIframe();
                        
                        iframeMap.SetSelectionXML(TrimString(selectionXml));
                        iframeMap.ZoomSelection();
                    }
                }
            }
            
            /**
             * Zoom sur la carte
             * @params int - x - Position X du zoom
             * @params int - y - Position Y du zoom
             * @params int - scale - Echelle du zoom
             * @params int - refresh - rafraichi la carte
             */
            function ZoomToViewLocal(x, y, scale, refresh) {
                getIframe();
                iframe.contentWindow.ZoomToView(x,y,scale,refresh);
            }
            
            /**
             * selection et zoom sur un objet
             */
            function GetCdruruFromSelectionXml(reqParams)
            {
                var selectionXml = "";
                /*if (reqParams.length > 0) {
                
                    var reqHandler = getXhr();
                    
                    if (reqHandler != false)
                    {
                        reqHandler.open("POST", "mapcdrurufromselectionxml.php", false);
                        reqHandler.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        
                        reqHandler.send(reqParams);
                        selectionXml = reqHandler.responseText;
                    }
                }*/
                
                return selectionXml;
            }
            
            function GetDataFromSelectionXml(reqParams)
            {
                var retour = "";
                if (reqParams.length > 0) {
                
                    var reqHandler = getXhr();
                    
                    if (reqHandler != false)
                    {
                        //reqHandler.open("POST", "mapcdrurufromselectionxml.php", false);
                        reqHandler.open("POST", "'.$this->_webServiceUrl.'", false);
                        reqHandler.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        
                        reqHandler.send(reqParams);
                        retour = reqHandler.responseText;
                    }
                }
                
                return retour;
            }
            
            function setLayersArray()
            {
                getIframe();
                frameOption = iframeMap.GetLegendCtrl().thisFrame.legendUiFrame;
                //var layerMap = iframeMap.GetLegendCtrl().thisFrame.legendUiFrame.layerMap;
                var layerMap = frameOption.layerMap;
                
                layersArray = Array();
                for (var key in layerMap.items)
                {
                    if (layerMap.items[key].name.length > 0) {
                        layersArray[layerMap.items[key].name] = key;
                    }
                }
            }
            
            function setModePanoramique()
            {
                iframeMap.ExecuteMapAction(1);
            }
            
            /**
             * Change la visibilite d\'un calque
             */
            function ChangeLayerVisibility(layerName) {
                getIframe();
                setLayersArray();
                
                if ( typeof( layersArray[layerName] ) != "undefined" ) {
                    frameOption.ChangeVisibility(layersArray[layerName]);
                }
            }
            
            /**
             * Change le fait de rendre selectionnable un calque ou non
             */
            function ChangeLayerSelectability(layersArray, layerName, selectabilityFlag) {
                //selectabilityFlag : 0=toggle,1=selectable,2=unselectable
                //javascript:ChangeSelectability(objectId,selectabilityFlag)
                if ( typeof( layersArray[layerName] ) != "undefined" ) {
                    frameOption.ChangeSelectability(layersArray[layerName], selectabilityFlag);
                }
                
            }
            
            
            /**
             * Configure les Option des claques
             */
            function SetLayerOption() {
                getIframe();
                
                setLayersArray();
                
'.$layerOption.'
            }
            
            /**
             * Selectionne un objet sur la carte
             */
            function SetSelection() {
                getIframe();
                ';
            
                if (strlen($javascriptSelection) > 0)
                {
                    $retour .= '
                var reqParams = "'.$javascriptSelection.'";
                
                SelectAndZoom(reqParams);
                
                xmlSelection = iframeMap.selectionToXml();
                
                ';
                
                
                if (isset($this->_layers['SCALE']) == true
                    && is_numeric($this->_layers['SCALE']) == true
                    && strlen($this->_layers['SCALE']) > 0)
                {
                    $retour .= '                iframeMap.ZoomToScale('.$this->_layers['SCALE'].');'."\n";
                }
                
                
                $retour .= '
                // setInterval( checkSelection, intIntervalTime );
                    ';
                }
                $retour .= '
            }
            
            function setZoom() {
                '.$javascriptZoomXY.'
            }
            
            /**
             * verifi si la selection a change
             */
            function checkSelection() {
                var xmlSelectionTempo = iframeMap.selectionToXml();
                var textToDisplay = "";
                if (xmlSelection != xmlSelectionTempo)
                {
                    if (xmlSelectionNew != xmlSelectionTempo)
                    {
                        xmlSelectionNew = xmlSelectionTempo;
                        
                        ';
                        
                        if (strlen($this->_urlPortholeServerSource) > 0)
                        {
                            $retour .= 'windowProxy.postMessage(GetSelectionXmlLocal());';
                        }
                        else
                        {
                            $retour .= 'var data = GetSelectionXmlLocal();';
                            
                            if ($this->_interaction_selection_is_interactive == true)
                            {
                                $retour .= '
                                    //data = $.toJSON(data);
                                    if (typeof '.$prefixParentJavascript.$this->_interaction_selection_javascript_function.' == \'function\'
                                        && typeof(data) != "undefined"
                                        && typeof(data[0]) != "undefined")
                                    {
                                        if (typeof(data[0].x) == "undefined"
                                            && typeof(data[0].y) == "undefined"
                                            && typeof(data[0].scale) == "undefined")
                                        {
                                            '.$prefixParentJavascript.$this->_interaction_selection_javascript_function.'(data);
                                        }
                                    }
                                ';
                            }
                            
                        }
                        
                        $retour .= '
                    }
                    
                }
                else if (xmlSelectionNew.length > 0)
                {
                    //alert("test 1");
                    xmlSelectionNew = "";
                    
                    ';
                    
                    if (strlen($this->_urlPortholeServerSource) > 0)
                    {
                        $retour .= 'windowProxy.postMessage("");';
                    }
                    
                    $retour .= '
                }
            }
            
            function SetInteraction() {
                ';
                
                if ($this->_interaction_selection_is_interactive) {
                    $retour .= 'setInterval( checkSelection, intIntervalTime );';
                }
                
                
                $retour .= '
            }
            
            function replacer(key, value) {
                if (typeof value === \'number\' && !isFinite(value)) {
                    return String(value);
                }
                return value;
            }
            
            function getXYScale(e) {
                
                getIframe();
                var texte = "";
                var point = iframeMap.ScreenToMapUnits((e.clientX - iframeMap.mapPosX), e.clientY);
                var curScale = iframeMap.GetScale();
                
                //
                
                //parent.setNewSelectionMap(point.X, point.Y, curScale);
                var data = new Array();
                data["x"] = point.X;
                data["y"] = point.Y;
                data["scale"] = curScale;
                
                var data = "[{\"x\":"+point.X+",\"y\":"+point.Y+",\"scale\":"+curScale+"}]";
                
                var data = [{
                    x : point.X,
                    y : point.Y,
                    scale : curScale
                }];
                
                //alert("x : " + data["x"] + "\n" + "y : " + data["y"] + "\n" + "scale : " + data["scale"] + "\n");
                
                //alert($.toJSON(data));
                //alert(JSON.stringify(data, replacer));
                //windowProxy.postMessage(json_encode(data));
                //windowProxy.postMessage("test");
                //windowProxy.postMessage($.toJSON(encodeComponent(data)));
                
                ';
                
                if (strlen($this->_urlPortholeServerSource) > 0)
                {
                    $retour .= '
                
                    windowProxy.postMessage($.toJSON(data));
                    ';
                }
                else
                {
                    if ($this->_interaction_selection_is_interactive == true)
                    {
                        $retour .= '
                            if (typeof '.$prefixParentJavascript.$this->_interaction_selection_javascript_function.' == \'function\')
                            {
                                if (typeof(data[0].x) == "undefined"
                                    && typeof(data[0].y) == "undefined"
                                    && typeof(data[0].scale) == "undefined")
                                {
                                    '.$prefixParentJavascript.$this->_interaction_selection_javascript_function.'(data);
                                }
                            }
                        ';
                    }
                    
                    if ($this->_interaction_position_is_interactive == true)
                    {
                        $retour .= '
                            if (typeof '.$prefixParentJavascript.$this->_interaction_position_javascript_function.' == \'function\')
                            {
                                if (typeof(data[0].x) != "undefined"
                                    && typeof(data[0].y) != "undefined"
                                    && typeof(data[0].scale) != "undefined")
                                {
                                    '.$prefixParentJavascript.$this->_interaction_position_javascript_function.'(data);
                                }
                            }
                        ';
                    }
                }
                
                
                $retour .= '
                //windowProxy.postMessage(data);
                
                iframeMap.UpdateMapActionCursor(0);
            }
            
            function setDrawPoint()
            {
                '.$javascriptDrawPoints.'
            }
            
            /**
             * A lancer au chargement de la page
             */
            function OnPageLoad()
            {
                getIframe();
                
                // On configure les options de calque
                SetLayerOption();
                
                // On zoom
                setZoom();
                
                // On selectionne l\'objet;
                SetSelection();
                
                SetInteraction();
                
                $(iframeMap).click(function(e)
                {
                    getXYScale(e);
                });
                
                setDrawPoint();
                
                ';
                
                if ($this->_defaultModeMouse != SIG_MAP_MODE_MOUSE_SELECTION)
                {
                    $retour .= 'iframeMap.ExecuteMapAction('.$this->_defaultModeMouse.');';
                }
                
                $retour .= '
            }
            
            /**
             * encode du texte pour le rajouter dans une URL
             */
            function encodeComponent(str) {
                op = /\(/g; cp = /\)/g;
                return encodeURIComponent(str).replace(op, "%28").replace(cp, "%29");
            }
            
            /**
             * recupere le CDRURU de la selection courante
             */
            function GetSelectionXmlLocal() {
                getIframe();
                
                var selectionXML =  iframeMap.selectionToXml();
                
                /*
                var reqParams = "SESSION='.$this->_mapGuideSessionId.'";
                reqParams += "&MAPNAME='.$this->_mapGuideMapName.'";
                reqParams += "&LAYERNAME='.$this->_mapGuideLayerName.'";
                reqParams += "&SELECTIONXML="+encodeComponent(selectionXML);
                */
                
                var reqParams = '.$javascriptDataSelection.';
                
                //var cdruru = TrimString(GetCdruruFromSelectionXml(reqParams));
                var retour = TrimString(GetDataFromSelectionXml(reqParams));
                return retour;
            }
            
            ////////////////////////////////////////////////////////
            function DigitizePointLocal(form)
            {
                /*
                var handler = new iframeMap.Point(form.x.value, form.y.value);
                getIframe();
                iframeMap.DigitizePoint(handler);
                iframeMap.Refresh();
                */
                DigitizePoint(\'Cible_carre\',\'BA2F1F\',\'Localisation\',\'Point\', \'1\');
                
            }
            
            function DigitizePoint(symb, symbcolor, groupe, lay, mode)
            {
                getIframe();
                document.f1.symbole.value = symb;
                document.f1.symbcouleur.value = symbcolor;
                document.f1.grp.value = groupe;
                document.f1.calque.value = lay;
                document.f1.mod.value = mode;
                iframeMap.DigitizePoint(OnPointDigitized);
            }
            
            function DigitizePointV2(symb, symbcolor, groupe, lay, mode, x, y)
            {
                getIframe();
                document.f1.symbole.value = symb;
                document.f1.symbcouleur.value = symbcolor;
                document.f1.grp.value = groupe;
                document.f1.calque.value = lay;
                document.f1.mod.value = mode;
                iframeMap.DigitizePoint(OnPointDigitizedV2(x, y));
            }
            
            function DigitizePointV3(symb, symbcolor, groupe, lay, mode, x, y)
            {
                getIframe();
                iframeMap.DigitizePoint(OnPointDigitizedV3(symb, symbcolor, groupe, lay, mode, x, y));
            }
            
            function OnPointDigitized(point)
            {
                getIframe();
                var iframeForm = iframe.contentWindow.GetFormFrame();
                var symb = document.f1.symbole.value;
                var symbcolor = document.f1.symbcouleur.value;
                var groupe = document.f1.grp.value;
                var lay = document.f1.calque.value;
                var mode = document.f1.mod.value;
                var params = new Array(
                    "x0", point.X,
                    "y0", point.Y,
                    "SESSION", "'.$this->_mapGuideSessionId.'",
                    "MAPNAME", iframeMap.GetMapName(),
                    "SYMB", symb,
                    "SYMB_COLOR", symbcolor,
                    "GROUPNAME", groupe,
                    "LAYERNAME", lay,
                    "MODE", mode
                );
                
                if(mode == "2")
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("../../PHP/digitizing_features/draw_point_texte.php", params, "scriptFrame");
                    iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPointTexte", params, "scriptFrame");
                }
                else
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("../../PHP/digitizing_features/draw_point.php", params, "scriptFrame");
                    iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPoint", params, "scriptFrame");
                    //iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPoint", params, "framemap");
                    
                }
                
                if(mode == "1")
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("http://starentule.intranet/sigweb/PHP/INTRANET/Objets_Sous_Point.php", params, "newFrame");
                    //iframeForm.Submit("'.$this->_webServiceUrl.'?method=objetsSousPoint", params, "newFrame");
                }
            }
            
            function OnPointDigitizedV2(x, y)
            {
                getIframe();
                var iframeForm = iframe.contentWindow.GetFormFrame();
                var symb = document.f1.symbole.value;
                var symbcolor = document.f1.symbcouleur.value;
                var groupe = document.f1.grp.value;
                var lay = document.f1.calque.value;
                var mode = document.f1.mod.value;
                var params = new Array(
                    "x0", x,
                    "y0", y,
                    "SESSION", "'.$this->_mapGuideSessionId.'",
                    "MAPNAME", iframeMap.GetMapName(),
                    "SYMB", symb,
                    "SYMB_COLOR", symbcolor,
                    "GROUPNAME", groupe,
                    "LAYERNAME", lay,
                    "MODE", mode
                );
                
                if(mode == "2")
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("../../PHP/digitizing_features/draw_point_texte.php", params, "scriptFrame");
                    iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPointTexte", params, "scriptFrame");
                }
                else
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("../../PHP/digitizing_features/draw_point.php", params, "scriptFrame");
                    iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPoint", params, "scriptFrame");
                    //iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPoint", params, "framemap");
                    
                }
                
                if(mode == "1")
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("http://starentule.intranet/sigweb/PHP/INTRANET/Objets_Sous_Point.php", params, "newFrame");
                    //iframeForm.Submit("'.$this->_webServiceUrl.'?method=objetsSousPoint", params, "newFrame");
                }
            }
            
            function OnPointDigitizedV3(symb, symbcolor, groupe, lay, mode, x, y)
            {
                getIframe();
                var iframeForm = iframe.contentWindow.GetFormFrame();
                
                var params = new Array(
                    "x0", x,
                    "y0", y,
                    "SESSION", "'.$this->_mapGuideSessionId.'",
                    "MAPNAME", iframeMap.GetMapName(),
                    "SYMB", symb,
                    "SYMB_COLOR", symbcolor,
                    "GROUPNAME", groupe,
                    "LAYERNAME", lay,
                    "MODE", mode
                );
                
                if(mode == "2")
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("../../PHP/digitizing_features/draw_point_texte.php", params, "scriptFrame");
                    //iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPointTexte", params, "scriptFrame");
                }
                else
                {
                    iframeForm.Submit("'.$this->_webServiceUrl.'?method=drawPoint", params, "scriptFrame");
                }
                
                if(mode == "1")
                {
                    // TODO : gerer le cas :
                    //iframeForm.Submit("http://starentule.intranet/sigweb/PHP/INTRANET/Objets_Sous_Point.php", params, "newFrame");
                    //iframeForm.Submit("'.$this->_webServiceUrl.'?method=objetsSousPoint", params, "newFrame");
                }
            }
            
            function ClearPoint()
            {
                getIframe();
                var iframeForm = iframe.contentWindow.GetFormFrame();
                var params = new Array(
                    "SESSION", iframeMap.GetSessionId(),
                    "MAPNAME", iframeMap.GetMapName()
                );
                // TODO : gerer le cas :
                //iframeForm.Submit("http://starentule.intranet/sigweb/PHP/Digitizing_features/clear_points.php", params, "scriptFrame");
                iframeForm.Submit("'.$this->_webServiceUrl.'", params, "scriptFrame");
            }
            
            function serialize (mixed_value) {
                // Returns a string representation of variable (which can later be unserialized)  
                // 
                // version: 1109.2015
                // discuss at: http://phpjs.org/functions/serialize    // +   original by: Arpad Ray (mailto:arpad@php.net)
                // +   improved by: Dino
                // +   bugfixed by: Andrej Pavlovic
                // +   bugfixed by: Garagoth
                // +      input by: DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html)    // +   bugfixed by: Russell Walker (http://www.nbill.co.uk/)
                // +   bugfixed by: Jamie Beck (http://www.terabit.ca/)
                // +      input by: Martin (http://www.erlenwiese.de/)
                // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
                // +   improved by: Le Torbi (http://www.letorbi.de/)    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net/)
                // +   bugfixed by: Ben (http://benblume.co.uk/)
                // -    depends on: utf8_encode
                // %          note: We feel the main purpose of this function should be to ease the transport of data between php & js
                // %          note: Aiming for PHP-compatibility, we have to translate objects to arrays    // *     example 1: serialize([\'Kevin\', \'van\', \'Zonneveld\']);
                // *     returns 1: \'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}\'
                // *     example 2: serialize({firstName: \'Kevin\', midName: \'van\', surName: \'Zonneveld\'});
                // *     returns 2: \'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}\'
                var _utf8Size = function (str) {
                    var size = 0,
                        i = 0,
                        l = str.length,
                        code = \'\';
                    for (i = 0; i < l; i++) {
                        code = str.charCodeAt(i);
                        if (code < 0x0080) {
                            size += 1;
                        } else if (code < 0x0800) {
                            size += 2;
                        } else {
                            size += 3;
                        }
                    }
                    return size;
                };
                var _getType = function (inp) {
                    var type = typeof inp,
                        match;
                    var key; 
                    if (type === \'object\' && !inp) {
                        return \'null\';
                    }
                    if (type === "object") {
                        if (!inp.constructor) {
                            return \'object\';
                        }
                        var cons = inp.constructor.toString();
                        match = cons.match(/(\w+)\(/);
                        if (match) {
                            cons = match[1].toLowerCase();
                        }
                        var types = ["boolean", "number", "string", "array"];
                        for (key in types) {
                            if (cons == types[key]) {
                                type = types[key];
                                break;
                            }
                        }
                    }
                    return type;
                };
                var type = _getType(mixed_value);
                var val, ktype = \'\'; 
                switch (type) {
                case "function":
                    val = "";
                    break;
                case "boolean":
                    val = "b:" + (mixed_value ? "1" : "0");
                    break;
                case "number":
                    val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
                    break;
                case "string":
                    val = "s:" + _utf8Size(mixed_value) + ":\"" + mixed_value + "\"";
                    break;
                case "array":
                case "object":
                    val = "a";
                        /*
                        if (type == "object") {
                            var objname = mixed_value.constructor.toString().match(/(\w+)\(\)/);
                            if (objname == undefined) {
                                return;
                            }
                            objname[1] = this.serialize(objname[1]);
                            val = "O" + objname[1].substring(1, objname[1].length - 1);
                        }
                        */
                    var count = 0;
                    var vals = "";
                    var okey;        var key;
                    for (key in mixed_value) {
                        if (mixed_value.hasOwnProperty(key)) {
                            ktype = _getType(mixed_value[key]);
                            if (ktype === "function") {
                                continue;
                            }
             
                            okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
                            vals += this.serialize(okey) + this.serialize(mixed_value[key]);
                            count++;
                        }
                    }
                    val += ":" + count + ":{" + vals + "}";
                    break;    case "undefined":
                    // Fall-through
                default:
                    // if the JS object has a property which contains a null value, the string cannot be unserialized by PHP
                    val = "N";
                    break;
                }
                if (type !== "object" && type !== "array") {
                    val += ";";
                }
                return val;
            }
            
            function unserialize (data) {
                // http://kevin.vanzonneveld.net
                // +     original by: Arpad Ray (mailto:arpad@php.net)
                // +     improved by: Pedro Tainha (http://www.pedrotainha.com)
                // +     bugfixed by: dptr1988
                // +      revised by: d3x
                // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +        input by: Brett Zamir (http://brett-zamir.me)
                // +     improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +     improved by: Chris
                // +     improved by: James
                // +        input by: Martin (http://www.erlenwiese.de/)
                // +     bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +     improved by: Le Torbi
                // +     input by: kilops
                // +     bugfixed by: Brett Zamir (http://brett-zamir.me)
                // +      input by: Jaroslaw Czarniak
                // %            note: We feel the main purpose of this function should be to ease the transport of data between php & js
                // %            note: Aiming for PHP-compatibility, we have to translate objects to arrays
                // *       example 1: unserialize(\'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}\');
                // *       returns 1: [\'Kevin\', \'van\', \'Zonneveld\']
                // *       example 2: unserialize(\'a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}\');
                // *       returns 2: {firstName: \'Kevin\', midName: \'van\', surName: \'Zonneveld\'}
                var that = this,
                    utf8Overhead = function (chr) {
                        // http://phpjs.org/functions/unserialize:571#comment_95906
                        var code = chr.charCodeAt(0);
                        if (code < 0x0080) {
                            return 0;
                        }
                        if (code < 0x0800) {
                            return 1;
                        }
                        return 2;
                    },
                    error = function (type, msg, filename, line) {
                        throw new that.window[type](msg, filename, line);
                    },
                    read_until = function (data, offset, stopchr) {
                        var i = 2, buf = [], chr = data.slice(offset, offset + 1);
            
                        while (chr != stopchr) {
                            if ((i + offset) > data.length) {
                                error(\'Error\', \'Invalid\');
                            }
                            buf.push(chr);
                            chr = data.slice(offset + (i - 1), offset + i);
                            i += 1;
                        }
                        return [buf.length, buf.join(\'\')];
                    },
                    read_chrs = function (data, offset, length) {
                        var i, chr, buf;
            
                        buf = [];
                        for (i = 0; i < length; i++) {
                            chr = data.slice(offset + (i - 1), offset + i);
                            buf.push(chr);
                            length -= utf8Overhead(chr);
                        }
                        return [buf.length, buf.join(\'\')];
                    },
                    _unserialize = function (data, offset) {
                        var dtype, dataoffset, keyandchrs, keys, 
                            readdata, readData, ccount, stringlength, 
                            i, key, kprops, kchrs, vprops, vchrs, value,
                            chrs = 0, 
                            typeconvert = function (x) {
                                return x;
                            };
            
                        if (!offset) {
                            offset = 0;
                        }
                        dtype = (data.slice(offset, offset + 1)).toLowerCase();
            
                        dataoffset = offset + 2;
            
                        switch (dtype) {
                            case \'i\':
                                typeconvert = function (x) {
                                    return parseInt(x, 10);
                                };
                                readData = read_until(data, dataoffset, \';\');
                                chrs = readData[0];
                                readdata = readData[1];
                                dataoffset += chrs + 1;
                                break;
                            case \'b\':
                                typeconvert = function (x) {
                                    return parseInt(x, 10) !== 0;
                                };
                                readData = read_until(data, dataoffset, \';\');
                                chrs = readData[0];
                                readdata = readData[1];
                                dataoffset += chrs + 1;
                                break;
                            case \'d\':
                                typeconvert = function (x) {
                                    return parseFloat(x);
                                };
                                readData = read_until(data, dataoffset, \';\');
                                chrs = readData[0];
                                readdata = readData[1];
                                dataoffset += chrs + 1;
                                break;
                            case \'n\':
                                readdata = null;
                                break;
                            case \'s\':
                                ccount = read_until(data, dataoffset, \':\');
                                chrs = ccount[0];
                                stringlength = ccount[1];
                                dataoffset += chrs + 2;
            
                                readData = read_chrs(data, dataoffset + 1, parseInt(stringlength, 10));
                                chrs = readData[0];
                                readdata = readData[1];
                                dataoffset += chrs + 2;
                                if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
                                    error(\'SyntaxError\', \'String length mismatch\');
                                }
                                break;
                            case \'a\':
                                readdata = {};
            
                                keyandchrs = read_until(data, dataoffset, \':\');
                                chrs = keyandchrs[0];
                                keys = keyandchrs[1];
                                dataoffset += chrs + 2;
            
                                for (i = 0; i < parseInt(keys, 10); i++) {
                                    kprops = _unserialize(data, dataoffset);
                                    kchrs = kprops[1];
                                    key = kprops[2];
                                    dataoffset += kchrs;
            
                                    vprops = _unserialize(data, dataoffset);
                                    vchrs = vprops[1];
                                    value = vprops[2];
                                    dataoffset += vchrs;
            
                                    readdata[key] = value;
                                }
            
                                dataoffset += 1;
                                break;
                            default:
                                error(\'SyntaxError\', \'Unknown / Unhandled data type(s): \' + dtype);
                                break;
                        }
                        return [dtype, dataoffset - offset, typeconvert(readdata)];
                    }
                ;
            
                return _unserialize((data + \'\'), 0)[2];
            }
            
            
            function checkParam(param)
            {
                param = (typeof param == \'undefined\') ? \'\' : param;
                return param;
            }
            
            function addLayer(layerDefinition, layerName, layerLegend, groupId, groupName)
            {
                layerDefinition = checkParam(layerDefinition);
                layerName = checkParam(layerName);
                layerLegend = checkParam(layerLegend);
                groupId = checkParam(groupId);
                groupName = checkParam(groupName);
            
                getIframe();
                var iframeForm = iframe.contentWindow.GetFormFrame();
                
                var params = new Array();
                var url = "'.$this->_webServiceUrl.'?method=addLayer";
                
                // SESSION
                //url += "&SESSION='.$this->_mapGuideSessionId.'";
                params.push("SESSION", "'.$this->_mapGuideSessionId.'");
                
                // MAPNAME
                //url += "&MAPNAME=" + iframeMap.GetMapName();
                params.push("MAPNAME", iframeMap.GetMapName());
                
                // LAYER_DEFINITION
                //url += "&LAYER_DEFINITION=" + layerDefinition;
                params.push("LAYER_DEFINITION", layerDefinition);
                
                // LAYER_NAME
                //url += "&LAYER_NAME=" + layerName;
                params.push("LAYER_NAME", layerName);
                
                // LAYER_LEGEND
                //url += "&LAYER_NAME=" + layerName;
                params.push("LAYER_LEGEND", layerLegend);
                
                // GROUP_ID
                //url += "&GROUP_ID=" + groupId;
                params.push("GROUP_ID", groupId);
                
                // GROUP_NAME
                //url += "&GROUP_NAME=" + groupName;
                params.push("GROUP_NAME", groupName);
                
                
                iframeForm.Submit(url, params, "scriptFrame");
            }
            
            
            function createLayer(featureClass, featureName, geometry, layerId, layerName, groupId, groupName, minScale, maxScale, layers)
            {
                // on verifi tout les paramettres
                featureClass = checkParam(featureClass);
                featureName = checkParam(featureName);
                geometry = checkParam(geometry);
                layerId = checkParam(layerId);
                layerName = checkParam(layerName);
                groupId = checkParam(groupId);
                groupName = checkParam(groupName);
                minScale = checkParam(minScale);
                maxScale = checkParam(maxScale);
                
                layers = checkParam(layers);
            ';
            
            if ($this->_useIframe == true)
            {
                $retour .= '
                    layers = unescape(layers);
                ';
            }
            else
            {
                $retour .= '
                    layers = serialize(layers);
                    layers = escape(layers);
                    layers = encodeURI(layers);
                ';
            }
            
            $retour .= '
                //layers = checkParam(layers);
                //layers = unescape(layers);
                
                //layers = checkParam(layers);
                //layers = serialize(layers);
                //layers = escape(layers);
                //layers = encodeURI(layers);
                
                getIframe();
                var iframeForm = iframe.contentWindow.GetFormFrame();
                /*
                var symb = document.f1.symbole.value;
                var symbcolor = document.f1.symbcouleur.value;
                var groupe = document.f1.grp.value;
                var lay = document.f1.calque.value;
                var mode = document.f1.mod.value;
                var params = new Array(
                    "x0", point.X,
                    "y0", point.Y,
                    "SESSION", "'.$this->_mapGuideSessionId.'",
                    "MAPNAME", iframeMap.GetMapName(),
                    "SYMB", symb,
                    "SYMB_COLOR", symbcolor,
                    "GROUPNAME", groupe,
                    "LAYERNAME", lay,
                    "MODE", mode
                );
                */
                
                /*
                var params = new Array(
                    "SESSION", "'.$this->_mapGuideSessionId.'",
                    "MAPNAME", iframeMap.GetMapName()
                );
                */
                
                
                var params = new Array(
                    "SESSION",
                    "MAPNAME",
                    "FEATURE_CLASS",
                    "FEATURE_NAME",
                    "GEOMETRY",
                    "LAYER_ID",
                    "LAYER_NAME",
                    "GROUP_ID",
                    "GROUP_NAME",
                    "MIN_SCALE",
                    "MAX_SCALE",
                    "AREA", new Array(
                        "LABEL",
                        "FILTER",
                        "COLOR"
                    )
                );
                
                /*
                SESSION
                MAPNAME
                FEATURE_CLASS
                FEATURE_NAME
                GEOMETRY
                LAYER_ID
                LAYER_NAME
                GROUP_ID
                GROUP_NAME
                MIN_SCALE
                MAX_SCALE
                AREA
                    LABEL
                    FILTER
                    COLOR
                */
                
                var params = new Array();
                var url = "'.$this->_webServiceUrl.'?method=createLayer";
                
                // SESSION
                //url += "&SESSION='.$this->_mapGuideSessionId.'";
                params.push("SESSION", "'.$this->_mapGuideSessionId.'");
                
                // MAPNAME
                //url += "&MAPNAME=" + iframeMap.GetMapName();
                params.push("MAPNAME", iframeMap.GetMapName());
                
                // FEATURE_CLASS
                //url += "&FEATURE_CLASS=" + featureClass;
                params.push("FEATURE_CLASS", featureClass);
                
                // FEATURE_NAME
                //url += "&FEATURE_NAME=" + featureName;
                params.push("FEATURE_NAME", featureName);
                
                // GEOMETRY
                //url += "&GEOMETRY=" + geometry;
                params.push("GEOMETRY", geometry);
                
                // LAYER_ID
                //url += "&LAYER_ID=" + layerId;
                params.push("LAYER_ID", layerId);
                
                // LAYER_NAME
                //url += "&LAYER_NAME=" + layerName;
                params.push("LAYER_NAME", layerName);
                
                // GROUP_ID
                //url += "&GROUP_ID=" + groupId;
                params.push("GROUP_ID", groupId);
                
                // GROUP_NAME
                //url += "&GROUP_NAME=" + groupName;
                params.push("GROUP_NAME", groupName);
                
                // MIN_SCALE
                //url += "&MIN_SCALE=" + minScale;
                params.push("MIN_SCALE", minScale);
                
                // MAX_SCALE
                //url += "&MAX_SCALE=" + maxScale;
                params.push("MAX_SCALE", maxScale);
                
                // LAYERS
                //url += "&LAYERS=" + layers;
                params.push("LAYERS", layers);
                
                iframeForm.Submit(url, params, "scriptFrame");
            }
            
            function editLayer(layerDefinition, layerName, layerLegend, layerGroupName, layerGroupLegend, layers, filter)
            {
                // on verifi tout les paramettres
                layerDefinition = checkParam(layerDefinition);
                layerName = checkParam(layerName);
                layerLegend = checkParam(layerLegend);
                layerGroupName = checkParam(layerGroupName);
                layerGroupLegend = checkParam(layerGroupLegend);
                layers = unescape(layers);
                filter = checkParam(filter);
                
                getIframe();
                var iframeForm = iframe.contentWindow.GetFormFrame();
                
                var params = new Array();
                var url = "'.$this->_webServiceUrl.'?method=editLayer";
                
                // SESSION
                //url += "&SESSION='.$this->_mapGuideSessionId.'";
                params.push("SESSION", "'.$this->_mapGuideSessionId.'");
                
                // MAPNAME
                //url += "&MAPNAME=" + iframeMap.GetMapName();
                params.push("MAPNAME", iframeMap.GetMapName());
                
                // LAYER_DEFINITION
                //url += "&LAYER_DEFINITION=" + layerDefinition;
                params.push("LAYER_DEFINITION", layerDefinition);
                
                // LAYER_NAME
                //url += "&LAYER_NAME=" + layerName;
                params.push("LAYER_NAME", layerName);
                
                // LAYER_LEGEND
                //url += "&LAYER_LEGEND=" + layerLegend;
                params.push("LAYER_LEGEND", layerLegend);
                
                // LAYER_GROUP_NAME
                //url += "&LAYER_GROUP_NAME=" + layerGroupName;
                params.push("LAYER_GROUP_NAME", layerGroupName);
                
                // LAYER_GROUP_LEGEND
                //url += "&LAYER_GROUP_LEGEND=" + layerGroupLegend;
                params.push("LAYER_GROUP_LEGEND", layerGroupLegend);
                
                // LAYERS
                //url += "&LAYERS=" + layers;
                params.push("LAYERS", layers);
                
                // FILTER
                url += "&FILTER=" + filter;
                params.push("FILTER", filter);
                
                iframeForm.Submit(url, params, "scriptFrame");
            }
            
            function getScalesLocal()
            {
                getIframe();
                var scale = iframeMap.GetScale();
                
                var data = {
                    "fonction": "getScalesLocalRetour",
                    "commande": "getScalesLocalRetour(" + scale + ");"
                };
                ';
            
            if (strlen($this->_urlPortholeServerSource) > 0)
            {
                $retour .= 'windowProxy.postMessage(data);';
            }
            else
            {
                $retour .= '';
            }
                
            $retour .= '
                
            }
            
            
            function loadGetScalesLocal()
            {
                setInterval("getScalesLocal()", 1000);
            }
            
            setTimeout("loadGetScalesLocal()",3000);
            
            
            ////////////////////////////////////////////////////////
            
            </script>
            ';
            
            if (strlen($this->_htmlHead) > 0)
            {
                $retour .= $this->_htmlHead;
            }
            
            $retour .= '
            </head>
            <body>
            ';
            
            if (strlen($this->_htmlBodyStart) > 0)
            {
                $retour .= $this->_htmlBodyStart;
            }
            
            $retour .= '
            <form name="f1" method="get" action="#">
            
            <!--
            x : <input type="text" name="x" value="1898043.412589625" /><br />
            y : <input type="text" name="y" value="3150579.1961250002" /><br />
            -->
            <input type="hidden" name="symbole" value="" />
            <input type="hidden" name="symbcouleur" value="" />
            <input type="hidden" name="grp" value="" />
            <input type="hidden" name="calque" value="" />
            <input type="hidden" name="mod" value="" />
            
            <!--
            <input type="button"
                value="digitizePointLocal"
                '.
                ' onclick="javascript:DigitizePointLocal(f1)"'.
                //' onclick="javascript:DigitizePoint(\'Cible_carre\',\'BA2F1F\',\'Localisation\',\'Point\', \'1\')"'.
                '
            /><br />
            <br />
            -->
            </form>
            ';
            
            // si on n'a pas defini de temps de chargement, on verifi si on doit en mettre un
            if (strlen($this->_display_loading) == 0)
            {
                if (
                    ($this->_zoom_activated == true)
                    ||
                    (is_string($this->_selection_object_condition) == true
                            && strlen($this->_selection_object_condition) > 0)
                    ||
                    (is_array($this->_selection_object_condition) == true
                            && count($this->_selection_object_condition) > 0)
                    ||
                    (is_string($this->_list_point) == true
                            && strlen($this->_list_point) > 0)
                    ||
                    (is_array($this->_list_point) == true
                            && count($this->_list_point) > 0)
                    )
                {
                    $this->_display_loading = SIG_MAP_DISPLAY_LOADING_TIME;
                }
            }
            
            if (strlen($this->_display_loading) > 0)
            {
                $retour .= '<div';
                $retour .= ' id="div_loading_iframe_map_'.$this->_iframeId.'"';
                $retour .= ' style="';
                $retour .= 'width:'.($this->_iframeWidth).'px;';
                $retour .= 'height:'.($this->_iframeHeight).'px;';
                $retour .= 'border:0px;';
                $retour .= 'padding:0px;';
                $retour .= 'margin:0px;';
                $retour .= 'z-index: 10;';
                $retour .= 'position: absolute;';
                $retour .= 'background: #F2F2F2 url('.$this->_image_loading_base64.') no-repeat center center;';
                $retour .= '"';
                $retour .= '>';
                $retour .= '</div>';
            }
            
            $retour .= '<iframe';
            $retour .= ' id="framemap"';
            $retour .= ' src="'.$url.'"';
            $retour .= ' height="'.$this->_iframeHeight.'"';
            $retour .= ' width="'.$this->_iframeWidth.'"';
            $retour .= '></iframe>'."\n";
            
            if (strlen($this->_display_loading) > 0)
            {
                $retour .= '<script type="text/javascript">';
                $retour .= '
                function displayLoadingMap()
                {
                    //var div_iframe_map_'.$this->_iframeId.' = document.getElementById("div_iframe_map_'.$this->_iframeId.'");
                    var div_loading_iframe_map_'.$this->_iframeId.' = document.getElementById("div_loading_iframe_map_'.$this->_iframeId.'");
                    
                    //div_iframe_map_'.$this->_iframeId.'.style.display = "inline";
                    div_loading_iframe_map_'.$this->_iframeId.'.style.display = "none";
                }';
                $retour .= '</script>';
            }
            
            if (strlen($this->_htmlBodyEnd) > 0)
            {
                $retour .= $this->_htmlBodyEnd;
            }
            
            $retour .= '
            </body>
            </html>';
        }
        
        return $retour;
    }
    
    /**
     * Methode qui cree l'instance MapGuide qui va etre utiliser
     * @param array - $aParams - tableau de paramettre
     * @return boolean - retour TRUE si la creation de l'instance MapGuide c'est bien passe
     */
    private function _getMapGuideInstance($aParams = array()) {
        $retour = false;
        
        // on inclus le fichier common de MapGuide
        if (strlen($this->_mapGuideCommonPathFile) > 0
            && file_exists($this->_mapGuideCommonPathFile) == true)
        {
            
            require_once($this->_mapGuideCommonPathFile);
            
            // On cree la connection
            try
            {
                // Initialize the Web Extensions
                MgInitializeWebTier (SIG_MAP_PATH_WEBCONFIG);
            
                // Connect to the site server and create a session
                $this->_userInfo = new MgUserInformation($this->_mapGuideLogin, $this->_mapGuidePassword);
            
                $this->_siteConnection = new MgSiteConnection();
                $this->_siteConnection->Open($this->_userInfo);
            
                $this->_site = $this->_siteConnection->GetSite();
                
                $this->_mapGuideSessionId = $this->_site->CreateSession();
                $this->_userInfo->SetMgSessionId($this->_mapGuideSessionId);
                
                $this->_mapGuideSchemaDirectory = SIG_MAP_PATH_SCHEMA_DIRECTORY;
                
                $retour = true;
            }
            catch (MgUserNotFoundException $e)
            {
                $this->_addLog('[MapGuide] Utilisateur non trouver');
            }
            catch (MgAuthenticationFailedException $e)
            {
                $this->_addLog('[MapGuide] Authentification impossible');
            }
            catch (MgInvalidPasswordException $e)
            {
                $this->_addLog('[MapGuide] Probleme sur le mot de passe');
            }
            catch (MgException $e)
            {
                $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
                $this->_addLog('<pre>GetDetails : '.print_r($e->GetDetails(), 1).'</pre>');
                $this->_addLog('<pre>GetExceptionMessage : '.print_r($e->GetExceptionMessage(), 1).'</pre>');
                $this->_addLog('<pre>GetStackTrace : '.print_r($e->GetStackTrace(), 1).'</pre>');
            }
            
        }
        
        return $retour;
    }
    
    /**
     * Methode qui cree le MgMap de MapGuide qui va etre utilise
     * @param array - $aParams - tableau de paramettre
     * @return boolean - retour TRUE si la creation du MgMap MapGuide c'est bien passe
     */
    private function _getMapGuideMapCreation($aParams = array()) {
        $retour = false;
        try {
            $this->_resourceId = new MgResourceIdentifier($this->_mapGuideSessionIdName);
            $this->_map = new MgMap($this->_siteConnection);
            $this->_resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
            $this->_map->Create($this->_resourceService, $this->_resourceId, $this->_mapGuideMapName);
            $retour  = true;
        }
        catch (MgInvalidRepositoryTypeException $e)
        {
            $this->_addLog('[MapGuide] Depot Invalide');
        }
        catch (MgException $e)
        {
            $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
            $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
        }
        
        return $retour;
    }
    
    /**
     * Methode qui recupere les options des calque a configurer en javascript sur la page
     * @param array - $aParams - tableau de paramettre
     * @return string - retourne le code javascript a ajouter pour configurer les calques
     */
    private function _getMapGuideLayerOption($aParams = array()) {
        $retour = '';
        $prefixJavascript = '                ';
        
        try
        {
            if (is_array($this->_layers) == true
                && count($this->_layers) > 0)
            {
                
                if (is_null($this->_map) == true) {
                    $this->_getMapGuideMapCreation($aParams);
                }
                
                if (is_null($this->_resourceService) == true) {
                    echo 'line : '.__LINE__."\n";
                    die();
                }
                
                $layers = $this->_map->GetLayers();
                
                for ($i=0; $i < $layers->GetCount() ; $i++)
                {
                    $layer = $layers->GetItem($i);
                    
                    $objectId = $layer->GetObjectId();
                    $nameLayer = $layer->GetName();
                    $visible = $layer->GetVisible();
                    $selectable = $layer->GetSelectable();
                    
                    if (strlen($nameLayer) > 0) {
                        
                        // Gestion des visibilite : javascript:ChangeVisibility(objectId);
                        if (isset($this->_layers[$nameLayer]['VISIBLE']) == true
                            && is_bool($this->_layers[$nameLayer]['VISIBLE']) == true
                            && $this->_layers[$nameLayer]['VISIBLE'] != $visible
                            )
                        {
                            // Cas ou le layer est defini dans la liste
                            $retour .= $prefixJavascript.'ChangeLayerVisibility("'.$nameLayer.'");'."\n";
                        }
                        elseif (isset($this->_layers['*']['VISIBLE']) == true
                            && is_bool($this->_layers['*']['VISIBLE']) == true
                            && $this->_layers[$nameLayer]['VISIBLE'] != $visible)
                        {
                            // Cas ou l'on a mis "*" dans la liste
                            $retour .= $prefixJavascript.'ChangeLayerVisibility("'.$nameLayer.'");'."\n";
                        }
                    
                        // Faire la gestion des layer selectionnable sur le meme principe que les visibles
                        //  selectabilityFlag : 0=toggle,1=selectable,2=unselectable
                        //  javascript:ChangeSelectability(objectId,selectabilityFlag)
                        if (isset($this->_layers[$nameLayer]['SELECTABLE']) == true
                                && is_bool($this->_layers[$nameLayer]['SELECTABLE']) == true
                        )
                        {
                            // Cas ou le layer est defini dans la liste
                            if ($this->_layers[$nameLayer]['SELECTABLE'] == true) {
                                $selectabilityFlag = 1;
                            } else {
                                $selectabilityFlag = 2;
                            }
                            $retour .= $prefixJavascript.'ChangeLayerSelectability(layersArray, "'.$nameLayer.'", '.$selectabilityFlag.');'."\n";
                        }
                        elseif (isset($this->_layers['*']['SELECTABLE']) == true
                                && is_bool($this->_layers['*']['SELECTABLE']) == true
                        )
                        {
                            // Cas ou l'on a mis "*" dans la liste
                            if ($this->_layers['*']['SELECTABLE'] == true) {
                                $selectabilityFlag = 1;
                            } else {
                                $selectabilityFlag = 2;
                            }
                            $retour .= $prefixJavascript.'ChangeLayerSelectability(layersArray, "'.$nameLayer.'", '.$selectabilityFlag.');'."\n";
                        }
                    }                   
                }
                
                $retour = $prefixJavascript.'/**********************************/'."\n"
                        .$prefixJavascript.'/*** Partie Autogenerer - Debut ***/'."\n"
                        .$prefixJavascript.'/**                              **/'."\n"
                        ."\n"
                        .$retour
                        ."\n"
                        .$prefixJavascript.'/**                            **/'."\n"
                        .$prefixJavascript.'/*** Partie Autogenerer - Fin ***/'."\n"
                        .$prefixJavascript.'/********************************/'."\n";
                
            }
        }
        catch (MgException $e)
        {
            $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
            $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
        }
        
        return $retour;
    }
    
    /**
     * Methode qui recupere le code javascript a afficher sur la page pour faire un zoom X/Y
     * @param array - $aParams - tableau de paramettre
     * @return string - code javascript a ajouter sur la page pour faire un zoom X/Y
     */
    private function _getMapGuideJavascriptZoomXY($aParams = array()) {
        $retour = '';
        
        if ($this->_zoom_activated == true
            && strlen($this->_zoom_x) > 0
            && strlen($this->_zoom_y) > 0
            && strlen($this->_zoom_scale) > 0)
        {
            $retour = 'ZoomToViewLocal('
                        .$this->_zoom_x.', ' // position X
                        .$this->_zoom_y.', ' // position Y
                        .$this->_zoom_scale.', ' // echelle
                        .'1);'; // refresh
        }
        
        return $retour;
    }
    
    /**
     * Methode qui recupere le code javascript a afficher faire une selection
     * @param array - $aParams - tableau de paramettre
     * @return string - code javascript a ajouter sur la page pour faire une selection
     */
    private function _getMapGuideJavascriptSelection($aParams = array()) {
        $retour = '';
    
        if (is_array($this->_selection_object_condition) == true
            && count($this->_selection_object_condition) > 0)
        {
            $retour = 'method=mapSelectionXml'
                    .'&SESSION='.$this->_mapGuideSessionId
                    .'&MAPNAME='.$this->_mapGuideMapName;
            
            foreach ($this->_selection_object_condition as $key => $value)
            {
                
                $retour .= '&LAYERNAME='.$key;
                $retour .= '&PROPERTIES_LIST='.urlencode(serialize($value));
            }
        }
    
        return $retour;
    }
    
    /**
     * Methode qui recupere le code javascript a afficher pour faire une selection
     * @param array - $aParams - tableau de paramettre
     * @return string - code javascript a ajouter sur la page pour faire une selection
     */
    private function _getMapGuideJavascriptDataSelection($aParams = array()) {
        $retour = '';
    
        if ($this->_interaction_selection_is_interactive == true)
        {
            $layerValues = $this->_interaction_selection_layer_values;
            if (is_array($layerValues) == true) {
                $layerValues = serialize($layerValues);
                $layerValues = str_replace('"', '\"', $layerValues);
            }
            
            $retour = '"method=mapDataFromSelectionXml'
            .'&SESSION='.$this->_mapGuideSessionId
            .'&MAPNAME='.$this->_mapGuideMapName
            .'&LAYERNAME='.$this->_interaction_selection_layer_name
            .'&LAYERVALUE='.$layerValues
            .'&SELECTIONXML="+encodeComponent(selectionXML)';
        }
    
        return $retour;
    }
    
    /**
     * Methode qui recupere le code javascript a afficher pour afficher les points
     * @param array - $aParams - tableau de paramettre
     * @return string - code javascript a ajouter sur la page pour afficher les points
     */
    private function _getMapGuideJavascriptDrawPoints($aParams = array()) {
        
        $retour = '';
        
        if (is_array($this->_list_point) == true
            && isset($this->_list_point['SYMBOLE']) == true
            && strlen($this->_list_point['SYMBOLE']) > 0
            && isset($this->_list_point['COLOR']) == true
            && strlen($this->_list_point['COLOR']) > 0
            && isset($this->_list_point['GROUP']) == true
            && strlen($this->_list_point['GROUP']) > 0
            && isset($this->_list_point['LAYER']) == true
            && strlen($this->_list_point['LAYER']) > 0
            && isset($this->_list_point['MODE']) == true
            && strlen($this->_list_point['MODE']) > 0
            && isset($this->_list_point['POINT']) == true
            && is_array($this->_list_point['POINT']) == true
            && count($this->_list_point['POINT']) > 0)
        {
            $time = 500;
            foreach ($this->_list_point['POINT'] as $point)
            {
        
                if (isset($point['X']) == true
                    && strlen($point['X']) > 0
                    && isset($point['Y']) == true
                    && strlen($point['Y']) > 0)
                {
                    $retour .= '                '
                    .'setTimeout("'
                    .'DigitizePointV3(\''
                    .$this->_list_point['SYMBOLE'].'\',\''
                    .$this->_list_point['COLOR'].'\',\''
                    .$this->_list_point['GROUP'].'\',\''
                    .$this->_list_point['LAYER'].'\', \''
                    .$this->_list_point['MODE'].'\', \''
                    .$point['X'].'\', \''
                    .$point['Y'].'\')'
                    .'", '.$time.')'
                    .';'
                    ."\n";
                    $time = $time+500;
                }
            }
        }
        
        return $retour;
        
        ///////////////////////////////////////////////////////////////////
        
        $retour = '';
        
        if (is_array($this->_list_point) == true
            && count($this->_list_point) > 0)
        {
            $time = 500;
            foreach ($this->_list_point as $point)
            {
                
                if (isset($point['SYMBOLE']) == true
                    && strlen($point['SYMBOLE']) > 0
                    && isset($point['COLOR']) == true
                    && strlen($point['COLOR']) > 0
                    && isset($point['GROUP']) == true
                    && strlen($point['GROUP']) > 0
                    && isset($point['LAYER']) == true
                    && strlen($point['LAYER']) > 0
                    && isset($point['MODE']) == true
                    && strlen($point['MODE']) > 0
                    && isset($point['X']) == true
                    && strlen($point['X']) > 0
                    && isset($point['Y']) == true
                    && strlen($point['Y']) > 0)
                {
                    $retour .= '                '
                        .'setTimeout("'
                        .'DigitizePointV3(\''
                        .$point['SYMBOLE'].'\',\''
                        .$point['COLOR'].'\',\''
                        .$point['GROUP'].'\',\''
                        .$point['LAYER'].'\', \''
                        .$point['MODE'].'\', \''
                        .$point['X'].'\', \''
                        .$point['Y'].'\')'
                        .'", '.$time.')'
                        .';'
                        ."\n";
                    $time = $time+500;
                }
            }
        }
        
        return $retour;
    }
    
    /**
     * Retourne le code HTML a afficher
     * @param array - $aParams - tableau de paramettre
     */
    public function draw($aParams = array()) {
        
        if ($this->_isMapGuideServer($aParams) == true) {
            return $this->_getHtmlOnMapGuideServer($aParams);
        } else {
            return $this->_getHtmlOutMapGuideServer($aParams);
        }
        
    }
    
    /**
     * Retourne le tableau PHP contenant les layers, si on n'est pas sur un serveur MapGuide
     * @param array - $aParams - tableau de paramettre
     * <ul>
     *  <li>array - params - tableau contenant les paramettres a ajouter a l'url (cle : cle du paramettre, valeur : valeur du paramettre)</li>
     * </ul>
     * @return mixed - Retourne un tableau contenant la liste des layers avec ses informations, sinon retour FALSE
     *  <ul>
     *    <li>
     *      Nom du layer
     *      <ul>
     *        <li>boolean - VISIBLE - Layer visible ou non</li>
     *        <li>boolean - SELECTABLE - Layer selectionnable ou non</li>
     *        <li>string - OBJECT_ID - Identifiant du layer</li>
     *        <li>boolean - DISPLAY_IN_LEGEND - Layer visible dans la legende ou non</li>
     *        <li>boolean - EXPAND_IN_LEGEND - Layer depliable dans la legende ou non</li>
     *        <li>string - LEGEND_LABEL - Nom du layer dans la legende</li>
     *        <li>string - FEATURE_GEOMETRY_NAME - Nom du champs geometrie</li>
     *        <li>integer - LAYER_TYPE - Type de layer (1 = Dynamic, 2 = BaseMap. Pour plus de detail voir dans la doc MapGuide la classe "MgLayerType")</li>
     *        <li>string - FEATURE_SOURCE_ID - Identifiant du FeatureSource</li>
     *        <li>string - FEATURE_CLASS_NAME - Nom de la Feature (voir de la table) associer au layer</li>
     *        <li>string - FILTER - Indique le filtre du layer</li>
     *      </ul>
     *    </li>
     *  </ul>
     */
    private function _getLayersOutMapGuideServer($aParams = array()) {
        
        if (class_exists('Snoopy') == false) {
            require_once(SNOOPY_PATH.'/Snoopy.class.php');
        }
        
        $snoopy = new Snoopy();
        $url = $this->_webServiceUrl;
        
        // on ajoute à l'url les paramttre de configuration
        $configParams = $this->_getConfigParams();
        if (isset($configParams) == true
                && is_array($configParams) == true
                && count($configParams) > 0)
        {
            $parametter = '?method=getlayers';
            foreach ($configParams as $paramKey => $paramValue) {
                if (strlen($parametter) > 0) {
                    $parametter .= '&';
                } else {
                    $parametter .= '?';
                }
                $parametter .= $paramKey.'='.$paramValue;
            }
            $url .= $parametter;
        }
        
        
        if ($snoopy->fetch($url) == true) {
            return @unserialize($snoopy->results);
        }
    }
    
    /**
     * Methode qui retour la liste des tous les layer avec les informations correspondante
     * @param array - $aParams - tableau de paramettre
     * @return mixed - Retourne un tableau contenant la liste des layers avec ses informations, sinon retour FALSE
     *  <ul>
     *    <li>
     *      Nom du layer
     *      <ul>
     *        <li>boolean - VISIBLE - Layer visible ou non</li>
     *        <li>boolean - SELECTABLE - Layer selectionnable ou non</li>
     *        <li>string - OBJECT_ID - Identifiant du layer</li>
     *        <li>boolean - DISPLAY_IN_LEGEND - Layer visible dans la legende ou non</li>
     *        <li>boolean - EXPAND_IN_LEGEND - Layer depliable dans la legende ou non</li>
     *        <li>string - LEGEND_LABEL - Nom du layer dans la legende</li>
     *        <li>string - FEATURE_GEOMETRY_NAME - Nom du champs geometrie</li>
     *        <li>integer - LAYER_TYPE - Type de layer (1 = Dynamic, 2 = BaseMap. Pour plus de detail voir dans la doc MapGuide la classe "MgLayerType")</li>
     *        <li>string - FEATURE_SOURCE_ID - Identifiant du FeatureSource</li>
     *        <li>string - FEATURE_CLASS_NAME - Nom de la Feature (voir de la table) associer au layer</li>
     *        <li>string - FILTER - Indique le filtre du layer</li>
     *      </ul>
     *    </li>
     *  </ul>
     */
    private function _getLayersOnMapGuideServer($aParams = array()) {
        
        $retour = false;
        
        if ($this->_getMapGuideInstance($aParams) == true
            && $this->_getMapGuideMapCreation($aParams))
        {
            try
            {
                $layers = $this->_map->GetLayers();
                $retour = array();
                for ($i=0; $i < $layers->GetCount() ; $i++)
                {
                    $layer = $layers->GetItem($i);
                    
                    $tempo = array(
                        'VISIBLE' => $layer->GetVisible(),
                        'SELECTABLE' => $layer->GetSelectable(),
                        'OBJECT_ID' => $layer->GetObjectId(),
                        'DISPLAY_IN_LEGEND' => $layer->GetDisplayInLegend(),
                        'EXPAND_IN_LEGEND' => $layer->GetExpandInLegend(),
                        'LEGEND_LABEL' => utf8_decode($layer->GetLegendLabel()),
                        'FEATURE_GEOMETRY_NAME' => $layer->GetFeatureGeometryName(),
                        'LAYER_TYPE' => $layer->GetLayerType(),
                        'FEATURE_SOURCE_ID' => $layer->GetFeatureSourceId(),
                        'FEATURE_CLASS_NAME' => $layer->GetFeatureClassName(),
                        //'FILTER' => $layer->GetFilter(),
                    );
                    
                    if (SIG_MAP_MAP_GUIDE_VERSION_YEAR > 2010)
                    {
                        $tempo['FILTER'] = $layer->GetFilter();
                    }
                    
                    
                    $retour[$layer->GetName()] = $tempo;
                }
            }
            catch (MgException $e)
            {
                $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
            }
        }
        
        $retour = serialize($retour);
        
        return $retour;
    }
    
    /**
     * Methode qui retourne les Layers disponible sur une map
     * @param array - $aParams - tableau de paramettre
     * @return array - retourne un tableau de layers 
     */
    public function getLayers($aParams = array()) {
        if ($this->_isMapGuideServer($aParams) == true) {
            return $this->_getLayersOnMapGuideServer($aParams);
        } else {
            return $this->_getLayersOutMapGuideServer($aParams);
        }
    }
    
    /**
     * Methode qui set les informations des layers
     * @param array - $aParams - tableau de paramettre contenant les informations des layers.<br />
     *  Pour appliquer des valeur a tout les layers, mettre "*" en nom de cle.<br />
     *  Pour forcer l'echelle d'affichage, il faut remplir une cle "SCALE"
     *  <ul>
     *    <li>
     *      SCALE - string - echelle a forcer<br />
     *      et<br />
     *      <i>Nom du layer</i> - array :
     *      <ul>
     *        <li>boolean - VISIBLE - Layer visible ou non</li>
     *        <li>boolean - SELECTABLE - Layer selectionnable ou non</li>
     *        <li>string - OBJECT_ID - Identifiant du layer</li>
     *        <li>boolean - DISPLAY_IN_LEGEND - Layer visible dans la legende ou non</li>
     *        <li>boolean - EXPAND_IN_LEGEND - Layer depliable dans la legende ou non</li>
     *        <li>string - LEGEND_LABEL - Nom du layer dans la legende</li>
     *        <li>string - FEATURE_GEOMETRY_NAME - Nom du champs geometrie</li>
     *        <li>integer - LAYER_TYPE - Type de layer (1 = Dynamic, 2 = BaseMap. Pour plus de detail voir dans la doc MapGuide la classe "MgLayerType")</li>
     *        <li>string - FEATURE_SOURCE_ID - Identifiant du FeatureSource</li>
     *        <li>string - FEATURE_CLASS_NAME - Nom de la Feature (voir de la table) associer au layer</li>
     *        <li>string - FILTER - Indique le filtre du layer</li>
     *      </ul>
     *    </li>
     *  </ul>
     * @return boolean - retourne TRUE si tout c'est bien passe
     */
    public function setLayers($aParams = array()) {
        $retour = false;
        
        if (is_array($aParams) == true) {
            $this->_layers = $aParams;
        }
        
        return $retour;
    }
    
    /**
     * Methode qui set le zoom avec le X, Y et l'echelle
     * @param array - $aParams - talbeau de paramettre
     *  <ul>
     *    <li>string - X - Position X</li>
     *    <li>string - Y - Position Y</li>
     *    <li>string - SCALE - Echelle</li>
     *  </ul>
     * @return boolean - retourne TRUE si le zoom est bien pris en compte
     */
    public function setZoomXY($aParams = array()) {
        $retour = false;
        
        if (isset($aParams['X']) == true
            && strlen($aParams['X']) > 0
            && isset($aParams['Y']) == true
            && strlen($aParams['Y']) > 0
            && isset($aParams['SCALE']) == true
            && strlen($aParams['SCALE']) > 0)
        {
            // Position X du zoom
            $this->_zoom_x = $aParams['X'];
            
            // Position Y du zoom
            $this->_zoom_y = $aParams['Y'];
            
            // Echelle du zoom
            $this->_zoom_scale = $aParams['SCALE'];
            
            // On defini le zoom comme actif
            $this->_zoom_activated = true;
            $retour = true;
        }
        
        return $retour;
    }
    
    /**
     * Methode qui ajouter un element dans une selection
     * @param unknown_type $classDef
     * @param unknown_type $properties
     * @param string - $key -Cle de la valeur a selectionner
     * @param string - $value - Valeur a selectionner
     */
    private function _mapSelectionXmlPropertiesAdd(&$layer, &$featureClass, &$classDef, &$selection, $key = '', $value = '')
    {
        if ($layer != null
            && $featureClass != null
            && $classDef != null
            && $selection != null
            && is_string($key) == true
            && strlen($key) > 0
            && strlen($value) > 0)
        {
            try
            {
                $properties = new MgPropertyCollection();
                
                switch($classDef->GetProperties()->GetItem($key)->GetDataType())
                {
                    case MgPropertyType::Boolean :
                        $properties->Add(new MgBooleanProperty($key, $value));
                        break;
                
                    case MgPropertyType::Byte :
                        $properties->Add(new MgByteProperty($key, $value));
                        break;
                
                    case MgPropertyType::Single :
                        $properties->Add(new MgSingleProperty($key, $value));
                        break;
                
                    case MgPropertyType::Double :
                        $properties->Add(new MgDoubleProperty($key, $value));
                        break;
                
                    case MgPropertyType::Int16 :
                        $properties->Add(new MgInt16Property($key, $value));
                        break;
                
                    case MgPropertyType::Int32 :
                        $properties->Add(new MgInt32Property($key, $value));
                        break;
                
                    case MgPropertyType::Int64 :
                        $properties->Add(new MgInt64Property($key, $value));
                        break;
                
                    case MgPropertyType::String :
                        $properties->Add(new MgStringProperty($key, $value));
                        break;
                
                    case MgPropertyType::DateTime :
                        $properties->Add(new MgDateTimeProperty($key, $value));
                        break;
                
                    case MgPropertyType::Null :
                    case MgPropertyType::Blob :
                    case MgPropertyType::Clob :
                    case MgPropertyType::Feature :
                    case MgPropertyType::Geometry :
                    case MgPropertyType::Raster :
                        break;
                }
                
                $selection->AddFeatureIds($layer, $featureClass, $properties);
            }
            catch (MgException $e)
            {
                $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
            }
        }
    }
    
    /**
     * Recupere le XML d'une selection
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - SESSION - Identifiant de la session MapGuide</li>
     *    <li>string - PROPERTIES_LIST - Liste des proprietes MapGuide a remonter</li>
     *    <li>string - MAPNAME - Nom de la carte MapGuide</li>
     *    <li>string - LAYERNAME - Nom du calque MapGuide</li>
     *  </ul>
     * @return mixed - retourne un XML contenant la selection MapGuide, sinon retourne false en cas d'erreur
     */
    public function mapSelectionXml($aParams) {
        $retour = false;
        
        if ($this->_getMapGuideInstance($aParams) == true) {
        
            try {
            
                $sessionID = $aParams['SESSION'];
                if (is_string($aParams['PROPERTIES_LIST']) == true) {
                    $propertiesList = unserialize($aParams['PROPERTIES_LIST']);
                } else {
                    $propertiesList = $aParams['PROPERTIES_LIST'];
                }
                $mapName = $aParams['MAPNAME'];
                $layerName = $aParams['LAYERNAME'];
            
            
                //$site = new MgSiteConnection();
                $this->_siteConnection;
            
                $this->_siteConnection->Open(new MgUserInformation($sessionID));
            
                $resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
                $featureService = $this->_siteConnection->CreateService(MgServiceType::FeatureService);
            
                $map = new MgMap();
                $map->Open($resourceService, $mapName);
                $layer = $map->GetLayers()->GetItem($layerName);
                $resId = new MgResourceIdentifier($layer->GetFeatureSourceId());
                $featureClass = $layer->GetFeatureClassName();
                $schemaAndClass = explode(":", $featureClass);
                $classDef = $featureService->GetClassDefinition($resId, $schemaAndClass[0], $schemaAndClass[1]);
                
                $selection = new MgSelection($map);
                /*
                echo '<pre>';
                print_r(array(get_class_methods($selection)));
                echo '</pre>';
                */
                foreach ($propertiesList as $key => $value)
                {
                    if (is_array($value) == true
                            && count($value) > 0)
                    {
                        // on est dans le cas ou l'on a plusieur ID pour une meme cle
                        foreach ($value as $v)
                        {
                            if (strlen($v) > 0)
                            {
                                /*$properties = new MgPropertyCollection();
                                $this->_mapSelectionXmlPropertiesAdd($classDef, $properties, $key, $v);
                                $selection->AddFeatureIds($layer, $featureClass, $properties);*/
                                
                                $this->_mapSelectionXmlPropertiesAdd($layer, $featureClass, $classDef, $selection, $key, $v);
                            }
                        }
                    }
                    elseif (strlen($value) > 0)
                    {
                        /*$properties = new MgPropertyCollection();
                        $this->_mapSelectionXmlPropertiesAdd($classDef, $properties, $key, $value);
                        $selection->AddFeatureIds($layer, $featureClass, $properties);*/
                                
                        $this->_mapSelectionXmlPropertiesAdd($layer, $featureClass, $classDef, $selection, $key, $value);
                    }
                    
                }
                
                
            
                //return $selection->ToXml();
                ob_start();
                header('Content-Type: text/xml');
                echo $selection->ToXml();
                
                $retour = ob_get_clean();
            }
            catch (MgException $e)
            {
                $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                $this->_addLog('<pre>GetDetails : '.print_r($e->GetDetails(), 1).'</pre>');
                $this->_addLog('<pre>GetExceptionMessage : '.print_r($e->GetExceptionMessage(), 1).'</pre>');
                $this->_addLog('<pre>GetStackTrace : '.print_r($e->GetStackTrace(), 1).'</pre>');
                $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
            }
        
        }
        
        return $retour;
    }
    
    /**
     * Recupere la valeur d'une propriete mapguide
     * @param unknown_type $featureReader
     * @param unknown_type $name
     * @return string - retourne la valeur de la propriete
     */
    private function _getFeaturePropertyValue($featureReader, $name) {
        $value = '';
        
        try {
            if ($featureReader->IsNull($name) == false)
            {
            
                $propertyType = $featureReader->GetPropertyType($name);
                switch($propertyType)
                {
                    case MgPropertyType::Null :
                        break;
                    
                    case MgPropertyType::Boolean :
                        $value = $featureReader->GetBoolean($name);
                        break;
            
                    case MgPropertyType::Byte :
                        $value = $featureReader->GetByte($name);
                        break;
            
                    case MgPropertyType::Single :
                        $value = $featureReader->GetSingle($name);
                        break;
            
                    case MgPropertyType::Double :
                        $value = $featureReader->GetDouble($name);
                        break;
            
                    case MgPropertyType::Int16 :
                        $value = $featureReader->GetInt16($name);
                        break;
            
                    case MgPropertyType::Int32 :
                        $value = $featureReader->GetInt32($name);
                        break;
            
                    case MgPropertyType::Int64 :
                        $value = $featureReader->GetInt64($name);
                        break;
            
                    case MgPropertyType::String :
                        $value = $featureReader->GetString($name);
                        break;
            
                    case MgPropertyType::DateTime :
                        $value = $featureReader->GetDateTime($name);
                        break;
                    
                    case MgPropertyType::Blob :
                        break;
                    
                    case MgPropertyType::Clob :
                        break;
                    
                    case MgPropertyType::Feature :
                        $value = $featureReader->GetFeatureObject($name);
                        if ($value == null)
                        {
                            $value = '';
                        }
                        break;
                        
                    case MgPropertyType::Geometry :
                        $value = $featureReader->GetGeometry($name);
                        if ($value == null)
                        {
                            $value = '';
                        }
                        break;
                        
                    case MgPropertyType::Raster :
                        $value = $featureReader->GetRaster($name);
                        break;
                        
                    default:
                        $value = '[unsupported data type]';
                        break;
                }
            }
        }
        catch (MgException $e)
        {
            $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
            $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
        }
        
        return $value;
    }
    
    /**
     * Methode qui recupere les informations d'une selection
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - SESSION - Identifiant de la session MapGuide</li>
     *    <li>string - SELECTIONXML - XML MapGuide contenant la selection</li>
     *    <li>string - MAPNAME - Nom de la carte MapGuide</li>
     *    <li>string - LAYERNAME - Nom du calque MapGuide sur lequel on veut remonte les informations</li>
     *    <li>string - LAYERVALUE - Nom du ou des valeur a retourner. s'il y a plusieurs valeur alors c'est un tableau serialize</li>
     *  </ul>
     * @return mixed - retour une string contenant un tableau JSON. sinon renvoi false
     */
    public function mapDataFromSelectionXml($aParams = array()) {
        $retour = false;
        
        if ($this->_getMapGuideInstance($aParams) == true)
        {
            try
            {
                $sessionID = $aParams['SESSION'];
                $selectionText = $aParams['SELECTIONXML'];
                $mapName = $aParams['MAPNAME'];
                $layerName = $aParams['LAYERNAME'];
                
                $data = @unserialize($aParams['LAYERVALUE']);
                
                if (is_array($data) == true) {
                    $layerValue = $data;
                } else {
                    $layerValue = array($aParams['LAYERVALUE']);
                }
                
                $this->_siteConnection;
                $this->_siteConnection->Open(new MgUserInformation($sessionID));
                
                $resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
                $featureService = $this->_siteConnection->CreateService(MgServiceType::FeatureService);
                
                $map = new MgMap();
                $map->Open($resourceService, $mapName);
                
                $selection = new MgSelection($map, $selectionText);
                $queryOptions = new MgFeatureQueryOptions();
                
                $layer = $selection->GetLayers()->GetItem(0);
                
                
                
                if (is_array($layerValue) == true
                    && count($layerValue) > 0
                    && $layer->GetName() == $layerName)
                {
                    $layerClassName = $layer->GetFeatureClassName();
                
                    $selectionString = $selection->GenerateFilter($layer, $layerClassName);
                    $layerFeatureId = $layer->GetFeatureSourceId();
                    $layerFeatureResource = new MgResourceIdentifier($layerFeatureId);
                    $queryOptions->SetFilter($selectionString);
                    $featureReader = $featureService->SelectFeatures($layerFeatureResource, $layerClassName, $queryOptions);
                    $retour = array();
                    $i = 0;
                    while ($featureReader->ReadNext())
                    {
                        foreach ($layerValue as $key => $value) {
                            $retour[$i][$value] = $this->_getFeaturePropertyValue($featureReader, $value);
                        }
                        $i++;
                    }
                    
                    $retour = json_encode($retour);
                }
            }
            catch (MgException $e)
            {
                $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                $this->_addLog('<pre>GetDetails : '.print_r($e->GetDetails(), 1).'</pre>');
                $this->_addLog('<pre>GetExceptionMessage : '.print_r($e->GetExceptionMessage(), 1).'</pre>');
                $this->_addLog('<pre>GetStackTrace : '.print_r($e->GetStackTrace(), 1).'</pre>');
                $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
            }
        }
        
        return $retour;
    }
    
    /**
     * Recuperer les propriete d'un calque
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - LAYER - Nom du calque</li>
     *  </ul>
     * @return mixed - Retourne un tableau contenant la liste des proprietes du claque , sinon retour FALSE
     *  <ul>
     *    <li>
     *      Nom de la propriete
     *      <ul>
     *        <li>integer - DATA_TYPE - Type de donnee</li>
     *        <li>integer - LENGTH - Taille</li>
     *        <li>integer - PRECISION - </li>
     *        <li>integer - SCALE - </li>
     *        <li>boolean - IS_AUTOGENERATED - Valeur autogenerer ou non</li>
     *        <li>string - DEFAULT_VALUE - valeur par defaut</li>
     *        <li>boolean - NULLABLE - valeur peut être null ou non</li>
     *        <li>boolean - READ_ONLY - valeur en lecture seul on non</li>
     *        <li>integer - PROPERTY_TYPE - type de propriete</li>
     *        <li>string - DESCRIPTION - description</li>
     *        <li>string - QUALIFIED_NAME - Nom du champ en base de donnee correspondant a la propriete</li>
     *        <li>string - NAME - Nom de la propriete</li>
     *      </ul>
     *    </li>
     *  </ul>
     */
    private function _getLayerPropertiesOnMapGuideServer($aParams = array()) {
        $retour = false;
        
        if ($this->_getMapGuideInstance($aParams) == true) {
            if (is_null($this->_map) == true) {
                $continu = $this->_getMapGuideMapCreation($aParams);
            } else {
                $continu = true;
            }
            if ($continu == true) {
                try
                {
                    $layerName = $aParams['LAYER']; // Parcels
                    
                    $this->_siteConnection->Open(new MgUserInformation($this->_mapGuideSessionId));
                    
                    $resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
                    $featureService = $this->_siteConnection->CreateService(MgServiceType::FeatureService);
                    $layer = $this->_map->GetLayers()->GetItem($layerName);
                    
                    $resId = new MgResourceIdentifier($layer->GetFeatureSourceId());
                    $featureClass = $layer->GetFeatureClassName();
                    $schemaAndClass = explode(":", $featureClass);
                    $classDef = $featureService->GetClassDefinition($resId, $schemaAndClass[0], $schemaAndClass[1]);
            
                    $properties = new MgPropertyCollection();
                    
                    $retour = array();
                    $listMethod = array(
                        'DATA_TYPE' => 'getdatatype',
                        'LENGTH' => 'getlength',
                        'PRECISION' => 'getprecision',
                        'SCALE' => 'getscale',
                        'IS_AUTOGENERATED' => 'isautogenerated',
                        'DEFAULT_VALUE' => 'getdefaultvalue',
                        'NULLABLE' => 'getnullable',
                        'READ_ONLY' => 'getreadonly',
                        'PROPERTY_TYPE' => 'getpropertytype', // MgPropertyDefinition::GetPropertyType (file:///U:/MAPGUIDE2011/Help/index.htm)
                        /*
                        static const int 	AssociationProperty = 103
                         	Type name for an association property definition.
                        static const int 	DataProperty = 100
                         	Type name for a data property definition. See MgDataPropertyDefinition.
                        static const int 	GeometricProperty = 102
                         	Type name for a geometric property definition. See MgGeometricPropertyDefinition.
                        static const int 	ObjectProperty = 101
                         	Type name for an object property definition. See MgObjectPropertyDefinition.
                        static const int 	RasterProperty = 104
                        */
                        
                        'DESCRIPTION' => 'getdescription',
                        'QUALIFIED_NAME' => 'getqualifiedname',
                        'NAME' => 'getname',
                    );
            
                    for ($i=0; $i < $classDef->GetProperties()->GetCount(); $i++)
                    {
                        $property = $classDef->GetProperties()->GetItem($i);
                        
                        
                        
                        if (get_class($property) == 'mgdatapropertydefinition')
                        {
                            $listMethodArray = $listMethod;
                        }
                        else
                        {
                            $listMethodArray = array();
                        }
                        
                        foreach ($listMethodArray as $keyName => $method)
                        {
                            $retour[$property->GetName()][$keyName] = call_user_func(array($property, $method));
                        }
                    }
                    
                    $retour = serialize($retour);
                }
                catch (MgException $e)
                {
                    $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                    //$this->_addLog('<pre>'.print_r(get_class_methods($e), 1).'</pre>');
                    //$this->_addLog('Message : '.$e->getMessage().'<br />');
                    $this->_addLog('Details :<br />'.$e->getDetails().'<br />');
                    $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
                }
            }
        }
        
        return $retour;
    }
    
    /**
     * Recuperer les propriete d'un calque
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - LAYER - Nom du calque</li>
     *  </ul>
     * @return mixed - Retourne un tableau contenant la liste des proprietes du claque , sinon retour FALSE
     *  <ul>
     *    <li>
     *      Nom de la propriete
     *      <ul>
     *        <li>integer - DATA_TYPE - Type de donnee</li>
     *        <li>integer - LENGTH - Taille</li>
     *        <li>integer - PRECISION - </li>
     *        <li>integer - SCALE - </li>
     *        <li>boolean - IS_AUTOGENERATED - Valeur autogenerer ou non</li>
     *        <li>string - DEFAULT_VALUE - valeur par defaut</li>
     *        <li>boolean - NULLABLE - valeur peut être null ou non</li>
     *        <li>boolean - READ_ONLY - valeur en lecture seul on non</li>
     *        <li>integer - PROPERTY_TYPE - type de propriete</li>
     *        <li>string - DESCRIPTION - description</li>
     *        <li>string - QUALIFIED_NAME - Nom du champ en base de donnee correspondant a la propriete</li>
     *        <li>string - NAME - Nom de la propriete</li>
     *      </ul>
     *    </li>
     *  </ul>
     */
    private function _getLayerPropertiesOutMapGuideServer($aParams = array()) {
        $retour = false;
        
        if (class_exists('Snoopy') == false) {
            require_once(SNOOPY_PATH.'/Snoopy.class.php');
        }
    
        $snoopy = new Snoopy();
        $url = $this->_webServiceUrl;
    
        // on ajoute à l'url les paramttre de configuration
        $configParams = $this->_getConfigParams();
        if (isset($configParams) == true
            && is_array($configParams) == true
            && count($configParams) > 0)
        {
            $parametter = '?method=getLayerProperties';
            foreach ($configParams as $paramKey => $paramValue) {
                if (strlen($parametter) > 0) {
                    $parametter .= '&';
                } else {
                    $parametter .= '?';
                }
                $parametter .= $paramKey.'='.$paramValue;
            }
            $url .= $parametter;
        }
        
        if (preg_match('/\?/', $url) == 0) {
            $url .= '?';
        } else {
            $url .= '&';
        }
        
        if (isset($aParams['LAYER']) == true
            && strlen($aParams['LAYER']) > 0)
        {
            $url .= 'LAYER='.$aParams['LAYER'];
        }
        
        if ($snoopy->fetch($url) == true) {
            //print_r(unserialize($snoopy->results));
            $retour = unserialize($snoopy->results);
        }
    
        return $retour;
    }
    
    /**
     * Recuperer les propriete d'un calque
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - LAYER - Nom du calque</li>
     *  </ul>
     * @return mixed - Retourne un tableau contenant la liste des proprietes du claque , sinon retour FALSE
     *  <ul>
     *    <li>
     *      Nom de la propriete
     *      <ul>
     *        <li>integer - DATA_TYPE - Type de donnee</li>
     *        <li>integer - LENGTH - Taille</li>
     *        <li>integer - PRECISION - </li>
     *        <li>integer - SCALE - </li>
     *        <li>boolean - IS_AUTOGENERATED - Valeur autogenerer ou non</li>
     *        <li>string - DEFAULT_VALUE - valeur par defaut</li>
     *        <li>boolean - NULLABLE - valeur peut être null ou non</li>
     *        <li>boolean - READ_ONLY - valeur en lecture seul on non</li>
     *        <li>integer - PROPERTY_TYPE - type de propriete</li>
     *        <li>string - DESCRIPTION - description</li>
     *        <li>string - QUALIFIED_NAME - Nom du champ en base de donnee correspondant a la propriete</li>
     *        <li>string - NAME - Nom de la propriete</li>
     *      </ul>
     *    </li>
     *  </ul>
     */
    public function getLayerProperties($aParams = array()) {
        if ($this->_isMapGuideServer($aParams) == true) {
            return $this->_getLayerPropertiesOnMapGuideServer($aParams);
        } else {
            return $this->_getLayerPropertiesOutMapGuideServer($aParams);
        }
    }
    
    /**
     * Permet de setter une selection
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>
     *      string - nom du calque
     *      <ul>
     *        <li>string - condition SQL</li>
     *      </ul>
     *    </li>
     *  </ul>
     */
    public function setSelection($aParams = array()) {
        $retour = false;
        
        if (is_array($aParams) == true
            && count($aParams) > 0)
        {
            $this->_selection_object_condition = $aParams;
        }
        
        return $retour;
    }
    
    /**
     * Permet l'activation des interactions sur les selection entre la map et la page web 
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - JAVASCRIPT_FUNCTION - Nom de la fonction javascript a appeller si une interaction est faite sur la page</li>
     *    <li>string - SELECTION_LAYER_NAME - Nom du calque a verifier</li>
     *    <li>mixed - SELECTION_LAYER_VALUES - Valeur(s) a retourner :
     *      <ul>
     *        <li>si string - nom du champs a retourner</li>
     *        <li>si array - tableau contenant la liste de tout les champs a retourner</li>
     *      </ul>
     *    </li>
     *    <li>string - IS_INTERACTIVE - indique si on rend interactive au nom l'echange de donnee</li>
     *  </ul>
     * @return boolan - indique si l'on est dans le cas d'une carte interactive de selection ou non
     */
    public function setInteractionSelection($aParams = array()) {
        
        // on recupere le nom de la methode javascript
        if (isset($aParams['JAVASCRIPT_FUNCTION']) == true
            && strlen($aParams['JAVASCRIPT_FUNCTION']) > 0)
        {
            $this->_interaction_selection_javascript_function = $aParams['JAVASCRIPT_FUNCTION'];
        } else {
            $this->_interaction_selection_javascript_function = SIG_MAP_INTERACTION_SELECTION_JAVASCRIPT_FUNCTION;
        }
        
        // on recupere le nom du claque a verifier pour la selection
        if (isset($aParams['SELECTION_LAYER_NAME']) == true
            && strlen($aParams['SELECTION_LAYER_NAME']) > 0)
        {
            $this->_interaction_selection_layer_name = $aParams['SELECTION_LAYER_NAME'];
        } else {
            $this->_interaction_selection_layer_name = '';
        }
        
        // on recupere le nom de la valeur a verifier pour la selection
        if (isset($aParams['SELECTION_LAYER_VALUES']) == true)
        {
            if (is_array($aParams['SELECTION_LAYER_VALUES']) == true)
            {
                $this->_interaction_selection_layer_values = $aParams['SELECTION_LAYER_VALUES'];
            } else {
                $this->_interaction_selection_layer_values = $aParams['SELECTION_LAYER_VALUES'];
            }
        } else {
            $this->_interaction_selection_layer_values = '';
        }
        
        // on indique si l'interaction est autorise
        if (isset($aParams['IS_INTERACTIVE']) == true
            && is_bool($aParams['IS_INTERACTIVE']) == true)
        {
            $this->_interaction_selection_is_interactive = $aParams['IS_INTERACTIVE'];
        }
        elseif (isset($aParams['JAVASCRIPT_FUNCTION']) == true
            && strlen($aParams['JAVASCRIPT_FUNCTION']) > 0
            && isset($aParams['SELECTION_LAYER_NAME']) == true
            && strlen($aParams['SELECTION_LAYER_NAME']) > 0
            && isset($aParams['SELECTION_LAYER_VALUES']) == true
            && strlen($aParams['SELECTION_LAYER_VALUES']) > 0)
        {
            $this->_interaction_selection_is_interactive = true;
        }
        else
        {
            $this->_interaction_selection_is_interactive = false;
        }
        
        return $this->_interaction_selection_is_interactive;
    }
    
    /**
     * Permet l'activation des interactions sur les selection entre la map et la page web
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - JAVASCRIPT_FUNCTION - Nom de la fonction javascript a appeller si une interaction est faite sur la page</li>
     *    <li>string - IS_INTERACTIVE - indique si on rend interactive au nom l'echange de donnee</li>
     *  </ul>
     * @return boolan - indique si l'on est dans le cas d'une carte interactive de position ou non
     */
    public function setInteractionPosition($aParams = array()) {
        // on recupere le nom de la methode javascript
        if (isset($aParams['JAVASCRIPT_FUNCTION']) == true
            && strlen($aParams['JAVASCRIPT_FUNCTION']) > 0)
        {
            $this->_interaction_position_javascript_function = $aParams['JAVASCRIPT_FUNCTION'];
        } else {
            $this->_interaction_position_javascript_function = SIG_MAP_INTERACTION_POSITION_JAVASCRIPT_FUNCTION;
        }
        
        // on indique si l'interaction est autorise
        if (isset($aParams['IS_INTERACTIVE']) == true
            && is_bool($aParams['IS_INTERACTIVE']) == true)
        {
            $this->_interaction_position_is_interactive = $aParams['IS_INTERACTIVE'];
        }
        elseif (isset($aParams['JAVASCRIPT_FUNCTION']) == true
            && strlen($aParams['JAVASCRIPT_FUNCTION']) > 0)
        {
            $this->_interaction_position_is_interactive = true;
        }
        else
        {
            $this->_interaction_position_is_interactive = SIG_MAP_INTERACTION_POSITION_IS_INTERACTIVE;
        }
        
        return $this->_interaction_position_is_interactive;
    }
    
    /**
     * Methode qui permet d'afficher depuis le "scriptFrame" un point
     * @param array - $aParams - tableau de paramettre
     */
    public function drawPoint($aParams = array()) {
        
        if ($this->_getMapGuideInstance($aParams) == true)
        {
            // Get the parameters passed in from the task pane
            // Recuperation des paramettre passes dans la frame principal
            if (isset($aParams['x0']) == true && strlen($aParams['x0']) > 0)
            {
                $x0 = $aParams['x0'];
            } else {
                $x0 = '';
            }
            
            if (isset($aParams['y0']) == true && strlen($aParams['y0']) > 0)
            {
                $y0 = $aParams['y0'];
            } else {
                $y0 = '';
            }
            
            if (isset($aParams['LOCALE']) == true && strlen($aParams['LOCALE']) > 0)
            {
                $locale = $aParams['LOCALE'];
            } else {
                $locale = '';
            }
            
            if (isset($aParams['SESSION']) == true && strlen($aParams['SESSION']) > 0)
            {
                $sessionId = $aParams['SESSION'];
            } else {
                $sessionId = '';
            }
            
            if (isset($aParams['MAPNAME']) == true && strlen($aParams['MAPNAME']) > 0)
            {
                $mapName = $aParams['MAPNAME'];
            } else {
                $mapName = '';
            }
            
            if (isset($aParams['SYMB']) == true && strlen($aParams['SYMB']) > 0)
            {
                $symbolName = $aParams['SYMB'];
            } else {
                $symbolName = '';
            }
            
            if (isset($aParams['SYMB_COLOR']) == true && strlen($aParams['SYMB_COLOR']) > 0)
            {
                $symbColor = $aParams['SYMB_COLOR'];
            } else {
                $symbColor = '';
            }
            
            if (isset($aParams['LAYERNAME']) == true && strlen($aParams['LAYERNAME']) > 0)
            {
                $layerName = $aParams['LAYERNAME'];
            } else {
                $layerName = '';
            }
            
            if (isset($aParams['LAYERNAME']) == true && strlen($aParams['LAYERNAME']) > 0)
            {
                $layerLegendLabel = $aParams['LAYERNAME'];
            } else {
                $layerLegendLabel = '';
            }
            
            if (isset($aParams['GROUPNAME']) == true && strlen($aParams['GROUPNAME']) > 0)
            {
                $groupName = $aParams['GROUPNAME'];
            } else {
                $groupName = '';
            }
            
            if (isset($aParams['GROUPNAME']) == true && strlen($aParams['GROUPNAME']) > 0)
            {
                $groupLegendLabel = $aParams['GROUPNAME'];
            } else {
                $groupLegendLabel = '';
            }
            
            if (isset($aParams['MODE']) == true && strlen($aParams['MODE']) > 0)
            {
                $mode = $aParams['MODE'];
            } else {
                $mode = '';
            }
            
            $addToHtmlHead = '';
            
            try
            {
                // --------------------------------------------------//
                $this->_userInfo = new MgUserInformation($sessionId);
                $this->_siteConnection = new MgSiteConnection();
                $this->_siteConnection->Open($this->_userInfo);
                
                $resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
                $featureService = $this->_siteConnection->CreateService(MgServiceType::FeatureService);
                
                //---------------------------------------------------//
                // Open the map
                $map = new MgMap();
                $map->Open($resourceService, $mapName);
                
                //---------------------------------------------------//
                // Does the temporary feature source already exist?
                // If not, create it
                $featureSourceName = "Session:$sessionId//TemporaryPoints.FeatureSource";
                $resourceIdentifier = new MgResourceIdentifier($featureSourceName);
                
                $featureSourceExists = $this->_DoesResourceExist($resourceIdentifier, $resourceService);
                
                /*
                if ($featureSourceExists && $mode == "1")
                {
                    $resourceService->DeleteResource($resourceIdentifier);
                    $resourceIdentifier = new MgResourceIdentifier($featureSourceName);
                    $featureSourceExists = $this->_DoesResourceExist($resourceIdentifier, $resourceService);
                }
                */
                
                if ($featureSourceExists == false)
                {
                    // Create a temporary feature source to draw the point on
                    
                    // Create a feature class definition for the new feature
                    // source
                    $classDefinition = new MgClassDefinition();
                    $classDefinition->SetName($layerName);
                    $classDefinition->SetDescription($layerName.' to display.');
                    $geometryPropertyName = "SHPGEOM";
                    $classDefinition->SetDefaultGeometryPropertyName( $geometryPropertyName);
                    
                    // Create an identify property
                    $identityProperty = new MgDataPropertyDefinition("KEY");
                    $identityProperty->SetDataType(MgPropertyType::Int32);
                    $identityProperty->SetAutoGeneration(true);
                    $identityProperty->SetReadOnly(true);
                    // Add the identity property to the class definition
                    $classDefinition->GetIdentityProperties()->Add($identityProperty);
                    $classDefinition->GetProperties()->Add($identityProperty);
                    
                    // Create a name property
                    $nameProperty = new MgDataPropertyDefinition("NAME");
                    $nameProperty->SetDataType(MgPropertyType::String);
                    // Add the name property to the class definition
                    $classDefinition->GetProperties()->Add($nameProperty);
                    
                    // Create a geometry property
                    $geometryProperty = new MgGeometricPropertyDefinition($geometryPropertyName);
                    //if Point
                    $geometryProperty->SetGeometryTypes(MgFeatureGeometricType::Point);
                    // Add the geometry property to the class definition
                    $classDefinition->GetProperties()->Add($geometryProperty);
                    
                    // Create a feature schema
                    //if Point
                    $featureSchema = new MgFeatureSchema("SHP_Schema", "Point schema");
                    // Add the feature schema to the class definition
                    $featureSchema->GetClasses()->Add($classDefinition);
                    
                    // Create the feature source
                    $wkt = $map->GetMapSRS();
                    $sdfParams = new MgCreateSdfParams("spatial context", $wkt, $featureSchema);
                    $featureService->CreateFeatureSource($resourceIdentifier, $sdfParams);
                }
                
                // Add the point to the feature source
                $batchPropertyCollection = new MgBatchPropertyCollection();
                //if Point
                $propertyCollection = $this->_MakePoint($layerName, $x0, $y0);
                $batchPropertyCollection->Add($propertyCollection);
                
                // Add the batch property collection to the feature source
                $cmd = new MgInsertFeatures($layerName, $batchPropertyCollection);
                $featureCommandCollection = new MgFeatureCommandCollection();
                $featureCommandCollection->Add($cmd);
                
                // Execute the "add" commands
                $featureService->UpdateFeatures($resourceIdentifier, $featureCommandCollection, false);
                
                //---------------------------------------------------//
                $layerExists = $this->_DoesLayerExist($layerName, $map);
                if ($layerExists == false)
                {
                    
                    // Create a new layer which uses that feature source
                    //if Point -> ligne 234
                    // Create a point rule to stylize the point
                    $ruleLegendLabel = 'trees';
                    $filter = '';
                    $label = 'Meuh';
                    
                    // Create a mark symbol
                    $resourceId = 'Library://SYMBOLES/SYMB_LOCALISATION.SymbolLibrary';
                    //    $symbolName = 'Cible_noire';
                    $width = '35';  // unit = points
                    $height = '35'; // unit = points
                    $color = $symbColor;
                    $markSymbol = $this->_CreateMarkSymbol($resourceId, $symbolName, $width, $height, $color);
                    
                    // Create a text symbol
                    $text = 'ICI';
                    $fontHeight= '50';
                    $foregroundColor = 'FF000000';
                    $textSymbol = $this->_CreateTextSymbol($text, $fontHeight, $foregroundColor);
                    
                    $pointRule = $this->_CreatePointRule($ruleLegendLabel, $filter, $textSymbol, $markSymbol);
                    
                    // Create a point type style
                    $pointTypeStyle = $this->_CreatePointTypeStyle($pointRule);
                    
                    // Create a scale range
                    $minScale = '0';
                    $maxScale = '100000000';
                    $pointScaleRange = $this->_CreateScaleRange($minScale, $maxScale, $pointTypeStyle);
                    
                    // Create the layer definiton
                    $featureName = 'SHP_Schema:'.$layerName;
                    $geometry = 'SHPGEOM';
                    $layerDefinition = $this->_CreateLayerDefinition($featureSourceName, $featureName, $geometry, $pointScaleRange);
                    
                    //---------------------------------------------------//
                    // Add the layer to the map
                    $newLayer = $this->_add_layer_definition_to_map($layerDefinition, $layerName, $layerLegendLabel, $sessionId, $resourceService, $map);
                    
                    // Add the layer to a layer group
                    $this->_add_layer_to_group($newLayer, $groupName, $groupLegendLabel, $map);
                }
                
                // --------------------------------------------------//
                // Turn on the visibility of this layer.
                // (If the layer does not already exist in the map, it will be visible by default when it is added.
                // But if the user has already run this script, he or she may have set the layer to be invisible.)
                $layerCollection = $map->GetLayers();
                if ($layerCollection->Contains($layerName))
                {
                    $pointsLayer =$layerCollection->GetItem($layerName);
                    $pointsLayer->SetVisible(true);
                }
                
                $groupCollection = $map->GetLayerGroups();
                if ($groupCollection->Contains($groupName))
                {
                    $analysisGroup =$groupCollection->GetItem($groupName);
                    $analysisGroup->SetVisible(true);
                }
                
                //---------------------------------------------------//
                //  Save the map back to the session repository
                $sessionIdName = "Session:$sessionId//$mapName.Map";
                $sessionResourceID = new MgResourceIdentifier($sessionIdName);
                $sessionResourceID->Validate();
                $map->Save($resourceService, $sessionResourceID);
                
                //---------------------------------------------------//
                
            }
            catch (MgException $e)
            {
                $addToHtmlHead .= "<script language=\"javascript\" type=\"text/javascript\"> \n";
                $addToHtmlHead .= '    alert( Erreur ' . $e->GetMessage() . ' ); \n';
                $addToHtmlHead .= "</script> \n";
            }
            
            /*
            <!--
            //  Copyright (C) 2004-2007 by Autodesk, Inc.
            //
            //  This library is free software; you can redistribute it and/or
            //  modify it under the terms of version 2.1 of the GNU Lesser
            //  General Public License as published by the Free Software Foundation.
            //
            //  This library is distributed in the hope that it will be useful,
            //  but WITHOUT ANY WARRANTY; without even the implied warranty of
            //  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
            //  Lesser General Public License for more details.
            //
            //  You should have received a copy of the GNU Lesser General Public
            //  License along with this library; if not, write to the Free Software
            //  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
            -->
            */
            
            $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
            <html>
            
            <head>
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <title>Dessine un point</title>
            
            <meta http-equiv="content-style-type" content="text/css">
            <meta http-equiv="content-script-type" content="text/javascript">
            
            <script language="javascript" type="text/javascript">
            var map;
            // recharge la carte apres un temps d\'attente
            function reload()
            {
                // false = fenetre courante
                popup = false;
                var mapName = "'.$mapName.'";
                // si le viewerAjax est utilise
                if (parent.mapFrame) {
                    setTimeout("parent.mapFrame.Refresh()",500);
                    setTimeout("parent.parent.SetLayerOption()",1500);
                    // si Fusion est utilise
                } else {
                    map = GetParent().Fusion.getMapByName(mapName);
                    
                    window.setTimeout("loadMap()",300);
                }
            }
            
            function GetParent()
            {
                if (popup) {
                    return opener;
                }
                else if (parent.Fusion) {
                    return parent;
                }
                else if (parent.parent.Fusion) {
                    return parent.parent;
                }
                return null;
            }
            
            // recharge la carte pour Fusion exclusivement
            function loadMap()
            {
                map.reloadMap();
            }
            
            </script>
            
            '.$addToHtmlHead.'
            
            </head>
            
            <body onload ="reload()" >
            </body>
            </html>';
        } else {
            $html = '';
        }
        
        echo $html;    
    }
    
    /**
     * Methode qui marque un point
     * @param string - $name - nom du point
     * @param numeric - $x0 - position X du point
     * @param numeric - $y0 - position Y du point
     * @return MgPropertyCollection
     */
    private function _MakePoint($name, $x0, $y0)
    {
        $propertyCollection = new MgPropertyCollection();
        $nameProperty = new MgStringProperty('NAME', $name);
        $propertyCollection->Add($nameProperty);
    
        $wktReaderWriter = new MgWktReaderWriter();
        $agfReaderWriter = new MgAgfReaderWriter();
    
        $geometry = $wktReaderWriter->Read('POINT XY ('.$x0.' '.$y0.')');
        $geometryByteReader = $agfReaderWriter->Write($geometry);
        $geometryProperty = new MgGeometryProperty('SHPGEOM', $geometryByteReader);
        $propertyCollection->Add($geometryProperty);
        return $propertyCollection;
    }
    
    private function _DoesResourceExist($resourceIdentifier, $resourceService)
    // Returns true if the resource already exists, or false otherwise
    {
        try 
        {
          $resourceService->GetResourceContent($resourceIdentifier);
        }
        catch (MgResourceNotFoundException $e)
        {
          return false;
        }   
        
        return true;
    }
    
    /**
     * Methode qui verifi si un layer existe
     * @param string - $layerName - nom du calque
     * @param MgMap - $map - objet MgMap
     * @return boolean - retour TRUE si le calque existe deja, sinon retourne false
     */
    private function _DoesLayerExist($layerName, $map)
    {
        $layerCollection = $map->GetLayers();
        
        if ( $layerCollection->Contains($layerName) ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Ajoute la definition du claque (XML) dans la map
     * @param string - $layerDefinition
     * @param string - $layerName
     * @param string - $layerLegendLabel
     * @param string - $sessionId
     * @param ResourceService - $resourceService
     * @param MgMap - $map
     * @return NULL|MgLayer
     */
    private function _add_layer_definition_to_map($layerDefinition, $layerName, $layerLegendLabel, $sessionId, $resourceService, &$map)
    {
        //global $schemaDirectory;
        libxml_use_internal_errors(true);
        // Validate the XML.
        $domDocument = new DOMDocument;
        $domDocument->loadXML($layerDefinition);
        
        // on recherche le nom du xsd dans la definition du layer
        $fileXsd = '';
        $searchNode = $domDocument->getElementsByTagName( "LayerDefinition" );
        foreach( $searchNode as $searchNode )
        {
            $fileXsd = $searchNode->getAttribute('xsi:noNamespaceSchemaLocation');
        }
        
        $schemaDirectory2 = str_replace('\\', '/', $this->_mapGuideSchemaDirectory);
        
        if (strlen($fileXsd) > 0)
        {
            $schemaDirectory2 .= '/'.$fileXsd;
        }
        elseif (SIG_MAP_MAP_GUIDE_VERSION_YEAR == 2012)
        {
            $schemaDirectory2 .= '/LayerDefinition-2.3.0.xsd';
        }
        else
        {
            $schemaDirectory2 .= 'LayerDefinition-1.3.0.xsd';
        }
        
        if (! $domDocument->schemaValidate($schemaDirectory2) ) // $schemaDirectory is defined in common.php
        {
            echo "ERROR: (Fonction: add_layer_definition_to_map) Le nouveau document XML est invalide.<BR>\n.";
            echo $schemaDirectory2 . "<BR>\n.";
            return NULL;
        }
    
        // Save the new layer definition to the session repository
        $byteSource = new MgByteSource($layerDefinition, strlen($layerDefinition));
        $byteSource->SetMimeType(MgMimeType::Xml);
        $resourceID = new MgResourceIdentifier("Session:$sessionId//$layerName.LayerDefinition");
        $resourceService->SetResource($resourceID, $byteSource->GetReader(), null);
    
        $newLayer = $this->_add_layer_resource_to_map($resourceID, $resourceService, $layerName, $layerLegendLabel, $map);
        
        return $newLayer;
    }
    
    /**
     * Ajouter un claque a un groupe de calque, si besoin on cree le group de calque
     * @param MgLayer - $layer - Objet MgLayer
     * @param string - $layerGroupName - Nom du goupe de calque
     * @param string - $layerGroupLegendLabel - label de la legend du groupe de calque
     * @param MgMap - $map - Objet MgMap
     * @return void
     */
    private function _add_layer_to_group($layer, $layerGroupName, $layerGroupLegendLabel, &$map)
    {
    
        // Get the layer group
        $layerGroupCollection = $map->GetLayerGroups();
        if ($layerGroupCollection->Contains($layerGroupName))
        {
            $layerGroup = $layerGroupCollection->GetItem($layerGroupName);
        }
        else
        {
            // It does not exist, so create it
            $layerGroup = new MgLayerGroup($layerGroupName);
            $layerGroup->SetVisible(true);
            $layerGroup->SetDisplayInLegend(true);
            $layerGroup->SetLegendLabel($layerGroupLegendLabel);
            $layerGroupCollection->Add($layerGroup);
        }
    
        // Add the layer to the group
        $layer->SetGroup($layerGroup);
        $layer->ForceRefresh();
    }
    
    /**
     * Ajoute la definition du calque
     * @param MgResourceIdentifier - $layerResourceID
     * @param integer - $resourceService - resource service
     * @param string - $layerName - Nom du calque
     * @param string - $layerLegendLabel - label de la legend
     * @param MgMap - $map - Objet MgMap
     * @return MgLayer
     */
    private function _add_layer_resource_to_map($layerResourceID, $resourceService, $layerName, $layerLegendLabel, &$map)
    {
        $newLayer = new MgLayer($layerResourceID, $resourceService);
    
        // Add the new layer to the map's layer collection
        $newLayer->SetName($layerName);
        $newLayer->SetVisible(true);
        $newLayer->SetSelectable(true);
        $newLayer->SetLegendLabel($layerLegendLabel);
        $newLayer->SetDisplayInLegend(true);
        $layerCollection = $map->GetLayers();
        if (! $layerCollection->Contains($layerName) )
        {
            // Insert the new layer at position 0 so it is at the top
            // of the drawing order
            $layerCollection->Insert(0, $newLayer);
        }
    
        return $newLayer;
    }
    
    /**
     * Cree le Area Rule
     * @param string - $legendLabel - label de la legend
     * @param string - $filterText - filtre
     * @param string - $foreGroundColor - code couleur de la couleur de fond
     * @return string
     */
    private function _CreateAreaRule($legendLabel, $filterText, $foreGroundColor)
    {
        $areaRule = file_get_contents(SIG_MAP_PATH_VIEWERFILES."arearule.templ");
        $areaRule = sprintf($areaRule, $legendLabel, $filterText, $foreGroundColor);
        return $areaRule;
    }
    
    /**
     * Cree le AreaTypeStyle.
     * @param string - $areaRules - utiliser _CreateAreaRule() pour le creer
     * @return string
     */
    private function _CreateAreaTypeStyle($areaRules)
    {
        $style = file_get_contents(SIG_MAP_PATH_VIEWERFILES."areatypestyle.templ");
        $style = sprintf($style, $areaRules);
        return $style;
    }
    
    /**
     * Cree le line rule
     * @param string - $legendLabel - label de la legend
     * @param string - $filter - filtre
     * @param string - $color - code couleur de la ligne
     * @return string
     */
    private function _CreateLineRule($legendLabel, $filter, $color)
    {
        $lineRule = file_get_contents(SIG_MAP_PATH_VIEWERFILES."linerule.templ");
        $lineRule = sprintf($lineRule, $legendLabel, $filter, $color);
        return $lineRule;
    }
    
    /**
     * Cree le LineTypeStyle
     * @param string - $lineRules - utiliser _CreateLineRule() pour le creer
     * @return string
     */
    private function _CreateLineTypeStyle($lineRules)
    {
        $lineStyle = file_get_contents(SIG_MAP_PATH_VIEWERFILES."linetypestyle.templ");
        $lineStyle = sprintf($lineStyle, $lineRules);
        return $lineStyle;
    }
    
    /**
     * Cree un symbole de marque
     * @param string - $resourceId - Identifiant de la resource a utiliser
     * @param string - $symbolName - nom du symbole
     * @param string - $width - largeur du symbole
     * @param string - $height - hauteur du symbole
     * @param string - $color - code couleur pour la couleur du symbole
     * @return string
     */
    private function _CreateMarkSymbol($resourceId, $symbolName, $width, $height, $color)
    {
        $markSymbol = file_get_contents(SIG_MAP_PATH_VIEWERFILES."marksymbol.templ");
        $markSymbol = sprintf($markSymbol, $width, $height, $resourceId, $symbolName, $color);
        return $markSymbol;
    }
    
    /**
     * Cree le symbole du texte
     * @param string - $text - string pour le texte
     * @param string - $fontHeight - taille de la police
     * @param string - $foregroundColor - couleur de fond de la police
     * @return string
     */
    private function _CreateTextSymbol($text, $fontHeight, $foregroundColor)
    {
        $textSymbol = file_get_contents(SIG_MAP_PATH_VIEWERFILES."textsymbol.templ");
        $textSymbol = sprintf($textSymbol, $fontHeight, $fontHeight, $text, $foregroundColor);
        return $textSymbol;
    }
    
    /**
     * Cree le PointRule
     * @param string - $legendLabel - string pour le label de la legend
     * @param string - $filter - string pour le filtre
     * @param string - $label - utiliser _CreateTextSymbol() pour le creer
     * @param string - $pointSym - symbolisation de point, utiliser _CreateMarkSymbol() pour le creer
     * @return string
     */
    private function _CreatePointRule($legendLabel, $filter, $label, $pointSym)
    {
        $pointRule = file_get_contents(SIG_MAP_PATH_VIEWERFILES."pointrule.templ");
        $pointRule = sprintf($pointRule, $legendLabel, $filter, $label, $pointSym);
        return $pointRule;
    }
    
    /**
     * Cree le PointTypeStyle
     * @param string - $pointRule - utiliser _CreatePointRules() pour le definir
     * @return string
     */
    private function _CreatePointTypeStyle($pointRule)
    {
        $pointTypeStyle = file_get_contents(SIG_MAP_PATH_VIEWERFILES."pointtypestyle.templ");
        $pointTypeStyle = sprintf($pointTypeStyle, $pointRule);
        return $pointTypeStyle;
    }
    
    /**
     * Cree le ScaleRange
     * @param string - $minScale - echelle minimum
     * @param string - $maxScale - echelle maximum
     * @param string - $typeStyle - utiliser _CreateAreaTypeStyle(), _CreateLineTypeStyle() ou _CreatePointTypeStyle()
     * @return string
     */
    private function _CreateScaleRange($minScale, $maxScale, $typeStyle)
    {
        $scaleRange = file_get_contents(SIG_MAP_PATH_VIEWERFILES."scalerange.templ");
        $scaleRange = sprintf($scaleRange, $minScale, $maxScale, $typeStyle);
        return $scaleRange;
    }
    
    /**
     * Cree une definition de calque
     * @param string - $resourceId - Identifiant de resource pour le nouveau calque
     * @param string - $featureClass - nom de la feature class
     * @param string - $geometry - nom de la geometry
     * @param string - $featureClassRange - utiliser _CreateScaleRange() pour le definir
     * @return string
     */
    private function _CreateLayerDefinition($resourceId, $featureClass, $geometry, $featureClassRange)
    {
        $layerDef = file_get_contents(SIG_MAP_PATH_VIEWERFILES."layerdefinition.templ");
        $layerDef = sprintf($layerDef, $resourceId, $featureClass, $geometry, $featureClassRange);
        return $layerDef;
    }
    
    /**
     * Permet e definir l'affichage de point sur le serveur MapGuide
     * @param array - $aParams - tableau contenant les informations sur les points
     *  <ul>
     *    <li>SYMBOLE - string - Nom du symbole a utiliser (ex: Cible_carre, Cible_noire, Point1, Point2, Point3, Point4, Point5, Point6, Point7</li>
     *    <li>COLOR - string - Couleur du symbole (ex: BA2F1F)
     *    <li>GROUP - string - Groupe du calque ou l'on va afficher le point (ex: Localisation)</li>
     *    <li>LAYER - string - Claque ou l'on va afficher le point (ex: Point)</li>
     *    <li>MODE - string - Indique si l'on affiche un point (1) ou du texte (2). Ne fonctionne pour l'instant que pour des points (ex: 1)
     *    <li>
     *        POINT - array - Tableau contenant une liste de tableau contenant chaque point a afficher
     *        <ul>
     *            <li>X - string - Position X du point a afficher (ex: 1898043.412589625)</li>
     *            <li>Y - string - Position Y du point a afficher (ex: 3150579.1961250002)</li>
     *        </ul>
     *    </li>
     *  </ul>
     * @return boolean - retourne TRUE si tout c'est bien passe
     */
     private function _setDrawPointsOnMapGuideServer($aParams = array())
    {
        $retour = false;
        if (is_array($aParams) == true
            && count($aParams) > 0)
        {
            $this->_list_point = $aParams;
            $retour = true;
        }
        
        return $retour;
    }
    
    /**
     * Permet e definir l'affichage de point or du serveur MapGuide
     * @param array - $aParams - tableau contenant les informations sur les points
     *  <ul>
     *    <li>SYMBOLE - string - Nom du symbole a utiliser (ex: Cible_carre, Cible_noire, Point1, Point2, Point3, Point4, Point5, Point6, Point7</li>
     *    <li>COLOR - string - Couleur du symbole (ex: BA2F1F)
     *    <li>GROUP - string - Groupe du calque ou l'on va afficher le point (ex: Localisation)</li>
     *    <li>LAYER - string - Claque ou l'on va afficher le point (ex: Point)</li>
     *    <li>MODE - string - Indique si l'on affiche un point (1) ou du texte (2). Ne fonctionne pour l'instant que pour des points (ex: 1)
     *    <li>
     *        POINT - array - Tableau contenant une liste de tableau contenant chaque point a afficher
     *        <ul>
     *            <li>X - string - Position X du point a afficher (ex: 1898043.412589625)</li>
     *            <li>Y - string - Position Y du point a afficher (ex: 3150579.1961250002)</li>
     *        </ul>
     *    </li>
     *  </ul>
     * @return boolean - retourne TRUE si tout c'est bien passe
     */
    private function _setDrawPointsOutMapGuideServer($aParams = array())
    {
        $retour = false;
        if (is_array($aParams) == true
            && count($aParams) > 0)
        {
            $this->_list_point = $aParams;
            $retour = true;
        }
        
        return $retour;
    }
    
    /**
     * Permet de definir l'affichage de point
     * @param array - $aParams - tableau contenant les informations sur les points
     *  <ul>
     *    <li>SYMBOLE - string - Nom du symbole a utiliser (ex: Cible_carre, Cible_noire, Point1, Point2, Point3, Point4, Point5, Point6, Point7</li>
     *    <li>COLOR - string - Couleur du symbole (ex: BA2F1F)
     *    <li>GROUP - string - Groupe du calque ou l'on va afficher le point (ex: Localisation)</li>
     *    <li>LAYER - string - Claque ou l'on va afficher le point (ex: Point)</li>
     *    <li>MODE - string - Indique si l'on affiche un point (1) ou du texte (2). Ne fonctionne pour l'instant que pour des points (ex: 1)
     *    <li>
     *        POINT - array - Tableau contenant une liste de tableau contenant chaque point a afficher
     *        <ul>
     *            <li>X - string - Position X du point a afficher (ex: 1898043.412589625)</li>
     *            <li>Y - string - Position Y du point a afficher (ex: 3150579.1961250002)</li>
     *        </ul>
     *    </li>
     *  </ul>
     * @return boolean - retourne TRUE si tout c'est bien passe
     */
    public function setDrawPoints($aParams = array())
    {
        if ($this->_isMapGuideServer($aParams) == true) {
            return $this->_setDrawPointsOnMapGuideServer($aParams);
        } else {
            return $this->_setDrawPointsOutMapGuideServer($aParams);
        }
    }
    
    /**
     * Methode qui ajouter un calque
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - SESSION - Identifiant de la session MapGuide</li>
     *    <li>string - MAPNAME - Nom de la carte MapGuide</li>
     *    <li>string - LAYER_DEFINITION - adresse du LayerDefinition</li>
     *    <li>string - LAYER_NAME - Nom du calque ou l'on veut afficher le filtre</li>
     *    <li>string - LAYER_LEGEND - Nom du calque ou l'on veut afficher le filtre</li>
     *    <li>string - GROUP_ID - Identifiant du groupe ou l'on veut afficher le nouveau calque</li>
     *    <li>string - GROUP_NAME - Nom du groupe ou l'on veut afficher le nouveau calque</li>
     *  </ul>
     * @return mixed - retour une string contenant un tableau JSON. sinon renvoi false
     */
    public function addLayer($aParams = array())
    {
        $retour = false;
        $this->_debugMode = 1;
        
        if ($this->_getMapGuideInstance($aParams) == true)
        {
            try
            {
                // Initialize
                if (isset($aParams['SESSION']) == true && strlen($aParams['SESSION']) > 0) {
                    $sessionId = $aParams['SESSION'];
                } else {
                    $sessionId = '';
                }
                
                if (isset($aParams['MAPNAME']) == true && strlen($aParams['MAPNAME']) > 0) {
                    $mapName = $aParams['MAPNAME'];
                } else {
                    $mapName = '';
                }
                
                if (isset($aParams['LAYER_DEFINITION']) == true && strlen($aParams['LAYER_DEFINITION']) > 0) {
                    $layerDefinition = $aParams['LAYER_DEFINITION'];
                } else {
                    $layerDefinition = '';
                }
                
                if (isset($aParams['LAYER_NAME']) == true && strlen($aParams['LAYER_NAME']) > 0) {
                    $layerName = $aParams['LAYER_NAME'];
                } else {
                    $layerName = '';
                }
                
                if (isset($aParams['LAYER_LEGEND']) == true && strlen($aParams['LAYER_LEGEND']) > 0) {
                    $layerLegendLabel = $aParams['LAYER_LEGEND'];
                } else {
                    $layerLegendLabel = '';
                }
                
                if (isset($aParams['GROUP_ID']) == true && strlen($aParams['GROUP_ID']) > 0) {
                    $groupId = $aParams['GROUP_ID'];
                } else {
                    $groupId = '';
                }
                
                if (isset($aParams['GROUP_NAME']) == true && strlen($aParams['GROUP_NAME']) > 0) {
                    $groupName = $aParams['GROUP_NAME'];
                } else {
                    $groupName = '';
                }
                
                
                // recuperation de la session
                $this->_userInfo = new MgUserInformation($sessionId);
                $this->_siteConnection = new MgSiteConnection();
                $this->_siteConnection->Open($this->_userInfo);
                
                $resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
                $featureService = $this->_siteConnection->CreateService(MgServiceType::FeatureService);
                
                // Open the map
                $map = new MgMap();
                $map->Open($resourceService, $mapName);
                
                $resourceID = new MgResourceIdentifier($layerDefinition);
                
                $newLayer = $this->_add_layer_resource_to_map($resourceID, $resourceService, $layerName, $layerLegendLabel, $map);
                
                
                $this->_add_layer_to_group(
                        $newLayer,
                        $groupId,
                        $groupName,
                        $map
                );
                
                //---------------------------------------------------//
                // Turn off the "Recently Built" themed layer (if it exists) so it does not hide this layer.
                /*$layerCollection = $map->GetLayers();
                if ($layerCollection->Contains('RecentlyBuilt'))
                {
                    $recentlyBuiltLayer = $layerCollection->GetItem('RecentlyBuilt');
                    $recentlyBuiltLayer->SetVisible(false);
                }*/
                
                // --------------------------------------------------//
                // Turn on the visibility of this layer.
                // (If the layer does not already exist in the map, it will be visible by default when it is added.
                // But if the user has already run this script, he or she may have set the layer to be invisible.)
                /*$layerCollection = $map->GetLayers();
                if ($layerCollection->Contains($layerId))
                {
                    $squareFootageLayer = $layerCollection->GetItem($layerId);
                    $squareFootageLayer->SetVisible(true);
                }*/
                
                //---------------------------------------------------//
                //  Save the map back to the session repository
                //$sessionIdName = "Session:$sessionId//$mapName.Map";
                $sessionIdName = 'Session:'.$sessionId.'//'.$mapName.'.Map';
                $sessionResourceID = new MgResourceIdentifier($sessionIdName);
                $sessionResourceID->Validate();
                $map->Save($resourceService, $sessionResourceID);
                
                
                $retour = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
                <html>
                    <head>
                        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
                        <meta http-equiv="content-script-type" content="text/javascript">
                        <meta http-equiv="content-style-type" content="text/css">
                        <script language="javascript" type="text/javascript">
                        function OnPageLoad()
                        {
                            parent.mapFrame.Refresh();
                            //parent.mapFrame.ZoomToScale(9999);
                        }
                        </script>
                    </head>
                    <body onLoad="OnPageLoad()">
                    </body>
                </html>
                ';
                
            }
            catch (MgException $e)
            {
                $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
            }
        }
        
        return $retour;
    }
    
    /**
     * Methode qui recupere les informations d'une selection
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - SESSION - Identifiant de la session MapGuide</li>
     *    <li>string - MAPNAME - Nom de la carte MapGuide</li>
     *    <li>string - FEATURE_CLASS - Feature classe a utiliser (ex: Library://DATA_SOURCES/PDV_VEGETATIONS_SDF.FeatureSource)</li>
     *    <li>string - FEATURE_NAME - Nom de la feature a utiliser (ex: Schema:PDV_VEGETATIONS)</li>
     *    <li>string - GEOMETRY - Nom du champs geometry a utiliser</li>
     *    <li>string - LAYER_ID - Identifiant du calque ou l'on veut afficher le filtre</li>
     *    <li>string - LAYER_NAME - Nom du calque ou l'on veut afficher le filtre</li>
     *    <li>string - GROUP_ID - Identifiant du groupe ou l'on veut afficher le nouveau calque</li>
     *    <li>string - GROUP_NAME - Nom du groupe ou l'on veut afficher le nouveau calque</li>
     *    <li>string - MIN_SCALE - echelle minimum</li>
     *    <li>string - MAX_SCALE - echelle maximum</li>
     *    <li>mixed - LAYERS - tableau serialize ou non contenant les couche a afficher
     *      <ul> 
     *        <li>
     *          array - AREA - tableau contenant la liste des roles a appliquer
     *          <ul>
     *            <li>string - LABEL - Label du filtre</li>
     *            <li>string - FILTER - filtre a appliquer</li>
     *            <li>string - COLOR - couleur de fond a utiliser</li>
     *          </ul>
     *        </li>
     *        <li>
     *          array - LINE - tableau contenant la liste des roles a appliquer
     *          <ul>
     *            <li>string - LABEL - Label du filtre</li>
     *            <li>string - FILTER - filtre a appliquer</li>
     *            <li>string - COLOR - couleur de fond a utiliser</li>
     *          </ul>
     *        </li>
     *        <li>
     *          array - POINT - tableau contenant la liste des roles a appliquer
     *          <ul>
     *            <li>string - LABEL - Label du filtre</li>
     *            <li>string - FILTER - filtre a appliquer</li>
     *            <li>string - COLOR - couleur de fond a utiliser</li>
     *          </ul>
     *        </li>
     *      </ul>
     *    </li>
     *  </ul>
     * @return mixed - retour une string contenant un tableau JSON. sinon renvoi false
     */
    public function createLayer($aParams = array())
    {
        $retour = false;
        $this->_debugMode = 1;
    
        if ($this->_getMapGuideInstance($aParams) == true)
        {
            try
            {
                // Initialize
                if (isset($aParams['SESSION']) == true && strlen($aParams['SESSION']) > 0) {
                    $sessionId = $aParams['SESSION'];
                } else {
                    $sessionId = '';
                }
                
                if (isset($aParams['MAPNAME']) == true && strlen($aParams['MAPNAME']) > 0) {
                    $mapName = $aParams['MAPNAME'];
                } else {
                    $mapName = '';
                }
                
                if (isset($aParams['FEATURE_CLASS']) == true && strlen($aParams['FEATURE_CLASS']) > 0) {
                    $featureClass = $aParams['FEATURE_CLASS'];
                } else {
                    $featureClass = '';
                }
                
                if (isset($aParams['FEATURE_NAME']) == true && strlen($aParams['FEATURE_NAME']) > 0) {
                    $featureName = $aParams['FEATURE_NAME'];
                } else {
                    $featureName = '';
                }
                
                if (isset($aParams['GEOMETRY']) == true && strlen($aParams['GEOMETRY']) > 0) {
                    $geometry = $aParams['GEOMETRY'];
                } else {
                    $geometry = '';
                }
                
                if (isset($aParams['LAYER_ID']) == true && strlen($aParams['LAYER_ID']) > 0) {
                    $layerId = $aParams['LAYER_ID'];
                } else {
                    $layerId = '';
                }
                
                if (isset($aParams['LAYER_NAME']) == true && strlen($aParams['LAYER_NAME']) > 0) {
                    $layerName = $aParams['LAYER_NAME'];
                } else {
                    $layerName = '';
                }
                
                if (isset($aParams['GROUP_ID']) == true && strlen($aParams['GROUP_ID']) > 0) {
                    $groupId = $aParams['GROUP_ID'];
                } else {
                    $groupId = '';
                }
                
                if (isset($aParams['GROUP_NAME']) == true && strlen($aParams['GROUP_NAME']) > 0) {
                    $groupName = $aParams['GROUP_NAME'];
                } else {
                    $groupName = '';
                }
                
                if (isset($aParams['MIN_SCALE']) == true && strlen($aParams['MIN_SCALE']) > 0) {
                    $minScale = $aParams['MIN_SCALE'];
                } else {
                    $minScale = '';
                }
                
                if (isset($aParams['MAX_SCALE']) == true && strlen($aParams['MAX_SCALE']) > 0) {
                    $maxScale = $aParams['MAX_SCALE'];
                } else {
                    $maxScale = '';
                }
                
                if (isset($aParams['LAYERS']) == true)
                {
                    if (is_string($aParams['LAYERS']) == true)
                    {
                        $layers = urldecode($aParams['LAYERS']);
                        $layers = @unserialize($layers);
                        if ($layers == false)
                        {
                            $layers = urldecode(urldecode($aParams['LAYERS']));
                            $layers = @unserialize($layers);
                        }
                    }
                    elseif (is_array($aParams['LAYERS']) == true)
                    {
                        $layers = $aParams['LAYERS'];
                    }
                    else
                    {
                        $layers = array();
                    }
                } else {
                    $layers = array();
                }
                
                // recuperation de la session
                $this->_userInfo = new MgUserInformation($sessionId);
                $this->_siteConnection = new MgSiteConnection();
                $this->_siteConnection->Open($this->_userInfo);
    
                $resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
                $featureService = $this->_siteConnection->CreateService(MgServiceType::FeatureService);
    
                //---------------------------------------------------//
                // Open the map
                $map = new MgMap();
                $map->Open($resourceService, $mapName);
    
                // ...
                //---------------------------------------------------//
                // Create a new layer
    
    
                /// Create three area rules for three different
                // scale ranges.
                
                $dataTypeStyle = '';
                
                // cas d'une zone
                if (isset($layers['AREA']) == true
                    && is_array($layers['AREA']) == true
                    && count($layers['AREA']) > 0)
                {
                    //$dataTypeStyle = $this->_createLayerArea($aParams);
                    $dataTypeStyle = $this->_createLayerArea($layers);
                }
                elseif (isset($layers['LINE']) == true
                    && is_array($layers['LINE']) == true
                    && count($layers['LINE']) > 0)
                {
                    $dataTypeStyle = $this->_createLayerLine($layers);
                }
                elseif (isset($layers['POINT']) == true
                    && is_array($layers['POINT']) == true
                    && count($layers['POINT']) > 0)
                {
                    $dataTypeStyle = $this->_createLayerPoint($layers);
                }
                
                // Create a scale range.
                $areaScaleRange = $this->_CreateScaleRange(
                    $minScale,
                    $maxScale,
                    $dataTypeStyle
                );
    
                // Create the layer definiton.
                $layerDefinition = $this->_CreateLayerDefinition(
                    $featureClass,
                    $featureName,
                    $geometry,
                    $areaScaleRange
                );
    
                //---------------------------------------------------//
                // ...
    
                // Add the layer to the map
                $newLayer = $this->_add_layer_definition_to_map(
                    $layerDefinition,
                    $layerId,
                    $layerName,
                    $sessionId,
                    $resourceService,
                    $map
                );
                $this->_add_layer_to_group(
                    $newLayer,
                    $groupId,
                    $groupName,
                    $map
                );
    
                //---------------------------------------------------//
                // Turn off the "Recently Built" themed layer (if it exists) so it does not hide this layer.
                $layerCollection = $map->GetLayers();
                if ($layerCollection->Contains('RecentlyBuilt'))
                {
                    $recentlyBuiltLayer = $layerCollection->GetItem('RecentlyBuilt');
                    $recentlyBuiltLayer->SetVisible(false);
                }
    
                // --------------------------------------------------//
                // Turn on the visibility of this layer.
                // (If the layer does not already exist in the map, it will be visible by default when it is added.
                // But if the user has already run this script, he or she may have set the layer to be invisible.)
                $layerCollection = $map->GetLayers();
                if ($layerCollection->Contains($layerId))
                {
                    $squareFootageLayer = $layerCollection->GetItem($layerId);
                    $squareFootageLayer->SetVisible(true);
                }
    
                //---------------------------------------------------//
                //  Save the map back to the session repository
                //$sessionIdName = "Session:$sessionId//$mapName.Map";
                $sessionIdName = 'Session:'.$sessionId.'//'.$mapName.'.Map';
                $sessionResourceID = new MgResourceIdentifier($sessionIdName);
                $sessionResourceID->Validate();
                $map->Save($resourceService, $sessionResourceID);
    
                //---------------------------------------------------//
                
                $retour = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
                <html>
                    <head>
                        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
                        <meta http-equiv="content-script-type" content="text/javascript">
                        <meta http-equiv="content-style-type" content="text/css">
                        <script language="javascript" type="text/javascript">
                            function OnPageLoad()
                            {
                                parent.mapFrame.Refresh();
                                //parent.mapFrame.ZoomToScale(9999);
                            }
                        </script>
                    </head>
                    <body onLoad="OnPageLoad()">
                    </body>
                </html>
                ';
            }
            catch (MgException $e)
            {
                $this->_addLog('[MapGuide] Une erreur est apparu lors de la connection sur le serveur');
                $this->_addLog('<pre>'.print_r($e, 1).'</pre>');
            }
        }
    
        return $retour;
    }
    
    /**
     * Methode qui cree un calque de zone
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>
     *      array - AREA - tableau contenant la liste des roles a appliquer
     *      <ul>
     *        <li>string - LABEL - Label du filtre</li>
     *        <li>string - FILTER - filtre a appliquer</li>
     *        <li>string - COLOR - couleur de fond a utiliser</li>
     *      </ul>
     *    </li>
     *  </ul>
     * @return string - XML de creation d'une claque de zone
     */
    private function _createLayerArea($aParams = array())
    {
        $areaTypeStyle = '';
        
        if (isset($aParams['AREA']) == true
            && is_array($aParams['AREA']) == true
            && count($aParams['AREA']) > 0)
        {
        
            $areaRules = '';
            
            foreach ($aParams['AREA'] as $key => $rule)
            {
                if (isset($rule['LABEL']) == true
                    && strlen($rule['LABEL']) > 0
                    && isset($rule['FILTER']) == true
                    && strlen($rule['FILTER']) > 0
                    && isset($rule['COLOR']) == true
                    && strlen($rule['COLOR']) > 0)
                {
                    $areaRules .= $this->_CreateAreaRule(
                            $rule['LABEL'],
                            $rule['FILTER'],
                            $rule['COLOR']
                    );
                }
            }
            
            // Create an area type style.
            $areaTypeStyle = $this->_CreateAreaTypeStyle($areaRules);
        
        }
        
        return $areaTypeStyle;
    }
    
    /**
     * Methode qui cree un calque de ligne
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>
     *      array - LINE - tableau contenant la liste des roles a appliquer
     *      <ul>
     *        <li>string - LABEL - Label du filtre</li>
     *        <li>string - FILTER - filtre a appliquer</li>
     *        <li>string - COLOR - couleur de fond a utiliser</li>
     *      </ul>
     *    </li>
     *  </ul>
     * @return string - XML de creation d'un calque de ligne
     */
    private function _createLayerLine($aParams = array())
    {
        $lineTypeStyle = '';
        
        if (isset($aParams['LINE']) == true
            && is_array($aParams['LINE']) == true
            && count($aParams['LINE']) > 0)
        {
        
            $lineRules = '';
            
            foreach ($aParams['LINE'] as $key => $rule)
            {
                if (isset($rule['LABEL']) == true
                    && strlen($rule['LABEL']) > 0
                    && isset($rule['FILTER']) == true
                    && strlen($rule['FILTER']) > 0
                    && isset($rule['COLOR']) == true
                    && strlen($rule['COLOR']) > 0)
                {
                    $lineRules .= $this->_CreateLineRule(
                        $rule['LABEL'],
                        $rule['FILTER'],
                        $rule['COLOR']
                    );
                }
            }
            
            // Create a line type style.
            $lineTypeStyle = $this->_CreateLineTypeStyle($lineRules);
        
        }
        
        return $lineTypeStyle;
    }
    
    /**
     * Methode qui cree un calque de point
     * @param array - $aParams - tableau de paramettre
     *  <ul> 
     *    <li>
     *      array - POINT - tableau contenant la liste des roles a appliquer
     *      <ul>
     *        <li>string - LABEL - Label du filtre</li>
     *        <li>string - FILTER - filtre a appliquer</li>
     *        <li>string - COLOR - couleur de fond a utiliser</li>
     *      </ul>
     *    </li>
     *  </ul>
     * @param array - $aParams - XML de creation d'un calque de point
     */
    private function _createLayerPoint($aParams = array())
    {
        $pointTypeStyle = '';
        
        if (isset($aParams['POINT']) == true
            && is_array($aParams['POINT']) == true
            && count($aParams['POINT']) > 0)
        {
            $pointRule = '';
            
            foreach ($aParams['POINT'] as $key => $rule)
            {
                
                if (isset($rule['RESOURCE_ID']) == true
                    && strlen($rule['RESOURCE_ID']) > 0
                    && isset($rule['SYMBOL_NAME']) == true
                    && strlen($rule['SYMBOL_NAME']) > 0
                    && isset($rule['WIDTH']) == true
                    && strlen($rule['WIDTH']) > 0
                    && isset($rule['HEIGHT']) == true
                    && strlen($rule['HEIGHT']) > 0
                    && isset($rule['SYMB_COLOR']) == true
                    && strlen($rule['SYMB_COLOR']) > 0
                    && isset($rule['TEXT']) == true
                    && strlen($rule['TEXT']) > 0
                    && isset($rule['FONT_HEIGHT']) == true
                    && strlen($rule['FONT_HEIGHT']) > 0
                    && isset($rule['FOREGROUND_COLOR']) == true
                    && strlen($rule['FOREGROUND_COLOR']) > 0
                    && isset($rule['RULE_LEGEND_LABEL']) == true
                    //&& strlen($rule['RULE_LEGEND_LABEL']) > 0
                    && isset($rule['FILTER']) == true
                    //&& strlen($rule['FILTER']) > 0
                    )
                {
                    // creation du symbole
                    $markSymbol = $this->_CreateMarkSymbol(
                        $rule['RESOURCE_ID'],
                        $rule['SYMBOL_NAME'],
                        $rule['WIDTH'],
                        $rule['HEIGHT'],
                        $rule['SYMB_COLOR']
                    );
                    
                    // creation du text
                    $textSymbol = $this->_CreateTextSymbol(
                        $rule['TEXT'],
                        $rule['FONT_HEIGHT'],
                        $rule['FOREGROUND_COLOR']
                    );
                    
                    // creation du point
                    $pointRule .= $this->_CreatePointRule(
                        $rule['RULE_LEGEND_LABEL'],
                        $rule['FILTER'],
                        $textSymbol,
                        $markSymbol
                    );
                }
            }
            
            // Create a point type style
            $pointTypeStyle = $this->_CreatePointTypeStyle($pointRule);
        }
        
        return $pointTypeStyle;   
    }
    
    /**
     * Methode qui permet l'edition de calque
     * @param array - $aParams - tableau de paramettre
     *  <ul>
     *    <li>string - SESSION - Identifiant de la session MapGuide</li>
     *    <li>string - MAPNAME - Nom de la carte MapGuide</li>
     *    <li>string - LAYER_DEFINITION - Layer Definition a utiliser (ex: Library://DIFFUSION/MODELES_DIFFUSION/CALQUE/PDV_VR_VOIES_TXT.LayerDefinition)</li>
     *    <li>string - LAYER_NAME - Nom du layer a utiliser (ex: PDV_VR_VOIES_TXT)</li>
     *    <li>string - LAYER_LEGEND - Nom du calque a utiliser dans la legende</li>
     *    <li>string - LAYER_GROUP_NAME - Nom du groupe du calque a utiliser</li>
     *    <li>string - LAYER_GROUP_LEGEND - Nom du groupe du calque a utiliser dans la legend</li>
     *    <li>mixed  - LAYERS - tableau serialize ou non contenant les couche a afficher
     *      <ul> 
     *        <li>
     *          array - AREA - tableau contenant la liste des roles a appliquer
     *          <ul>
     *            <li>array - FILTER - tableau contenant la liste des filtre de recherche</li>
     *            <li>array - VALUE - tableau contenant la liste de valeur a utiliser</li>
     *          </ul>
     *        </li>
     *        <li>
     *          array - LINE - tableau contenant la liste des roles a appliquer
     *          <ul>
     *            <li>array - FILTER - tableau contenant la liste des filtre de recherche</li>
     *            <li>array - VALUE - tableau contenant la liste de valeur a utiliser</li>
     *          </ul>
     *        </li>
     *        <li>
     *          array - POINT - tableau contenant la liste des roles a appliquer
     *          <ul>
     *            <li>array - FILTER - tableau contenant la liste des filtre de recherche</li>
     *            <li>array - VALUE - tableau contenant la liste de valeur a utiliser</li>
     *          </ul>
     *        </li>
     *      </ul>
     *    </li>
     *  </ul>
     */
    //public function createLayer($aParams = array())
    public function editLayer($aParams = array())
    {
        $retour = '';
        
        if ($this->_getMapGuideInstance($aParams) == true)
        {
            
            try
            {
                // Initialize
                if (isset($aParams['SESSION']) == true && strlen($aParams['SESSION']) > 0) {
                    $sessionId = $aParams['SESSION'];
                } else {
                    $sessionId = '';
                }
                
                if (isset($aParams['MAPNAME']) == true && strlen($aParams['MAPNAME']) > 0) {
                    $mapName = $aParams['MAPNAME'];
                } else {
                    $mapName = '';
                }
                
                if (isset($aParams['LAYER_DEFINITION']) == true && strlen($aParams['LAYER_DEFINITION']) > 0) {
                    $layerDef = $aParams['LAYER_DEFINITION'];
                } else {
                    $layerDef = '';
                }
                
                if (isset($aParams['LAYER_NAME']) == true && strlen($aParams['LAYER_NAME']) > 0) {
                    $layerName = $aParams['LAYER_NAME'];
                } else {
                    $layerName = '';
                }
                
                if (isset($aParams['LAYER_LEGEND']) == true && strlen($aParams['LAYER_LEGEND']) > 0) {
                    $layerLegendLabel = $aParams['LAYER_LEGEND'];
                } else {
                    $layerLegendLabel = '';
                }
                
                if (isset($aParams['LAYER_GROUP_NAME']) == true && strlen($aParams['LAYER_GROUP_NAME']) > 0) {
                    $layerGroupName = $aParams['LAYER_GROUP_NAME'];
                } else {
                    $layerGroupName = '';
                }
                
                if (isset($aParams['LAYER_GROUP_LEGEND']) == true && strlen($aParams['LAYER_GROUP_LEGEND']) > 0) {
                    $layerGroupLegendLabel = $aParams['LAYER_GROUP_LEGEND'];
                } else {
                    $layerGroupLegendLabel = '';
                }
                
                if (isset($aParams['LAYERS']) == true)
                {
                    if (is_string($aParams['LAYERS']) == true)
                    {
                        $layers = urldecode($aParams['LAYERS']);
                        $layers = @unserialize($layers);
                        if ($layers == false)
                        {
                            $layers = urldecode(urldecode($aParams['LAYERS']));
                            $layers = @unserialize($layers);
                        }
                    }
                    elseif (is_array($aParams['LAYERS']) == true)
                    {
                        $layers = $aParams['LAYERS'];
                    }
                    else
                    {
                        $layers = array();
                    }
                } else {
                    $layers = array();
                }
                
                if (isset($aParams['FILTER']) == true && strlen($aParams['FILTER']) > 0) {
                    $filterLayer = $aParams['FILTER'];
                } else {
                    $filterLayer = '';
                }
                
                // recuperation de la session
                $this->_userInfo = new MgUserInformation($sessionId);
                $this->_siteConnection = new MgSiteConnection();
                $this->_siteConnection->Open($this->_userInfo);
                
                $resourceService = $this->_siteConnection->CreateService(MgServiceType::ResourceService);
                
                
                //---------------------------------------------------//
                // Open the map
                $map = new MgMap();
                $map->Open($resourceService, $mapName);
                
                // ...
                // --------------------------------------------------//
                // Load a layer from XML, and use the DOM to change it
            
                // Load the prototype layer definition into
                // a PHP DOM object.
                
                $resourceID = new MgResourceIdentifier($layerDef);
                $rd = $resourceService->GetResourceContent($resourceID);
                $layerDefinitionXml = $rd->tostring();
                //return '<html><body><script language="javascript" type="text/javascript">alert("'.$layerDefinitionXml.'");</script></body></html>';
                
                
                //$domDocument = DOMDocument::load('RecentlyBuilt.LayerDefinition');
                $domDocument = DOMDocument::loadXML($layerDefinitionXml);
                if ($domDocument == NULL)
                {
                    $retour .= 'The layer definition \''.$layerDef.'\' could not be found.<BR>'."\n";
                }
                else
                {
                    
                    // On applique le filtre du layer
                    // on cherche d'abord si une balise filter existe
                    /*
                    //LayerDefinition/VectorLayerDefinition/Filter
                    */
                    if (strlen($filterLayer) > 0)
                    {
                        $xpath = new DOMXPath($domDocument);
                        $nodesFilterLayer = $xpath->query('//LayerDefinition/VectorLayerDefinition/Filter');
                        
                        if ($nodesFilterLayer->length == 0)
                        {
                            // La balise filtre n'existe pas, on ajoute une balise Filter
                            $nodesVectorLayerDefinition = $xpath->query('//LayerDefinition/VectorLayerDefinition');
                            if ($nodesVectorLayerDefinition->length == 1)
                            {
                                $n = $domDocument->createElement('Filter', $filterLayer);
                                // on recupere le noeud ou se trouve geometry
                                $nodesGeometryLayer = $xpath->query('//LayerDefinition/VectorLayerDefinition/Geometry');
                                
                                // on insert le noeud "Filter" juste devant le noeud "Geometry"
                                $nodesVectorLayerDefinition->item(0)->insertBefore($n, $nodesGeometryLayer->item(0));
                            }
                        }
                        elseif ($nodesFilterLayer->length == 1)
                        {
                            $nodesFilterLayer->item(0)->nodeValue = $filterLayer;
                        }
                    }
                    
                    
                    $confLayer = array(
                        'AREA' => '//AreaRule',
                        'LINE' => '//PointRule',
                        'POINT' => '//LineRule',
                    );
                    
                    $alert = '';
                    
                    foreach ($confLayer as $typeLayers => $queryValue)
                    {
                        
                        if (isset($layers[$typeLayers]) == true
                            && is_array($layers[$typeLayers]) == true
                            && count($layers[$typeLayers]) > 0)
                        {
                            
                            
                            // Change the filter
                            $xpath = new DOMXPath($domDocument);
                            
                            // On choisi le type de rule
                            $query = $queryValue;
                            
                            // Get a list of all the <AreaRule><Filter> elements in
                            // the XML.
                            $nodes = $xpath->query($query);
                            
                            foreach ($nodes as $node)
                            {
                                // on verifi les filtres
                                foreach ($layers[$typeLayers] as $layer)
                                {
                                    $filterValid = false;
                                    
                                    if (isset($layer['FILTER']) == true
                                        && is_array($layer['FILTER']) == true
                                        && count($layer['FILTER']) > 0)
                                    {
                                        foreach ($layer['FILTER'] as $filter)
                                        {
                                            $filterCount = count($filter);
                                            $filterOk = 0;
                                            $filterKo = 0;
                                            
                                            foreach ($filter as $filterKey => $filterValue)
                                            {
                                                
                                                if ($node->getElementsByTagName($filterKey)->item(0)->nodeValue != null
                                                    && $node->getElementsByTagName($filterKey)->item(0)->nodeValue == $filterValue)
                                                {
                                                    $filterOk++;
                                                }
                                                else
                                                {
                                                    $filterKo++;
                                                }
                                            }
                                            
                                            if ($filterCount > 0
                                                && $filterCount == $filterOk)
                                            {
                                                $filterValid = true;
                                            }
                                        }
                                    }
                                    
                                    // on applique les modifications
                                    if ($filterValid == true)
                                    {
                                        
                                        if (isset($layer['VALUE']) == true
                                            && is_array($layer['VALUE']) == true
                                            && count($layer['VALUE']) > 0)
                                        {
                                            foreach ($layer['VALUE'] as $layerValue)
                                            {
                                                
                                                foreach ($layerValue as $key => $value)
                                                {
                                                    if ($node->getElementsByTagName($key)->item(0)->nodeValue != null)
                                                    {
                                                        $node->getElementsByTagName($key)->item(0)->nodeValue = $value;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    // --------------------------------------------------//
                    // ...
                
                    // Add the layer to the map
                    $layerDefinition = $domDocument->saveXML();
                    //$newLayer = add_layer_definition_to_map($layerDefinition, "RecentlyBuilt", "Built after 1980", $sessionId, $resourceService, $map);
                    $newLayer = $this->_add_layer_definition_to_map($layerDefinition, $layerName.'_TEMPO', $layerLegendLabel, $sessionId, $resourceService, $map);
                    $this->_add_layer_to_group($newLayer, $layerGroupName, $layerGroupLegendLabel, $map);
                    
                    // --------------------------------------------------//
                    // Turn off the "Square Footage" themed layer (if it
                    // exists) so it does not hide this layer.
                    $layerCollection = $map->GetLayers();
                    if ($layerCollection->Contains($layerName))
                    {
                        $squareFootageLayer = $layerCollection->GetItem($layerName);
                        $squareFootageLayer->SetVisible(false);
                    }
                
                    // --------------------------------------------------//
                    // Turn on the visibility of this layer.
                    // (If the layer does not already exist in the map, it will be visible by default when it is added.
                    // But if the user has already run this script, he or she may have set the layer to be invisible.)
                    $layerCollection = $map->GetLayers();
                    if ($layerCollection->Contains($layerName.'_TEMPO'))
                    {
                        $recentlyBuiltLayer = $layerCollection->GetItem($layerName.'_TEMPO');
                        //$recentlyBuiltLayer->SetVisible(true);
                        $recentlyBuiltLayer->SetVisible(true);
                    }
                
                    // --------------------------------------------------//
                    //  Save the map back to the session repository
                    $sessionIdName = "Session:$sessionId//$mapName.Map";
                    $sessionResourceID = new MgResourceIdentifier($sessionIdName);
                    $sessionResourceID->Validate();
                    $map->Save($resourceService, $sessionResourceID);
                
                    // --------------------------------------------------//
                    
                    $retour = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
                    <html>
                        <head>
                            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
                            <meta http-equiv="content-script-type" content="text/javascript">
                            <meta http-equiv="content-style-type" content="text/css">
                            <script language="javascript" type="text/javascript">
                                function OnPageLoad()
                                {
                                    '.$alert.'
                                    parent.mapFrame.Refresh();
                                    //parent.mapFrame.ZoomToScale(9999);
                                }
                            </script>
                        </head>
                        <body onLoad="OnPageLoad()">
                        </body>
                    </html>
                    ';
                }
            
            }
            catch (MgException $e)
            {
                $retour = "<script language=\"javascript\" type=\"text/javascript\"> \n";
                $message = $e->GetMessage();
                $message = str_replace("\n", " ", $message);
                $retour .= "    alert(\" " . $message . " \"); \n";
                $retour .= "</script> \n";
            }
        }
        
        return $retour;
    }
    
    public function setHtmlHead($text = '')
    {
        if (strlen($text) > 0)
        {
            $this->_htmlHead = $text;
        }
    }
    
    public function setHtmlBodyStart($text = '')
    {
        if (strlen($text) > 0)
        {
            $this->_htmlBodyStart = $text;
        }
    }
    
    public function setHtmlBodyEnd($text = '')
    {
        if (strlen($text) > 0)
        {
            $this->_htmlBodyEnd = $text;
        }
    }
}

?>