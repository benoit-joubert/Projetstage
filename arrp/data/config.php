<?php
    $GENERAL_URL = (SERVEUR_PROD == 'SARRAKIS2' ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . '/arrp';
    $GENERAL_PATH   = $_SERVER['DOCUMENT_ROOT'] .'/arrp';
    // Construit les variables _PATH et _URL du projet
    genereVarPathUrlForProjet($GENERAL_PATH, $GENERAL_URL);
    
    // Pour les stats (uniquement en production)
    $PROJET_ID =  243;
    
    $FLECHE_RIGHT   = '<font class=s><b>'.htmlentitiesIso('»').'</b>&nbsp;</font>';
    $FLECHE_RIGHT_B = '<font class=r><b>'.htmlentitiesIso('»').'</b>&nbsp;</font>';
    $PLUS           = '<font class=s><b>+</b>&nbsp;</font>';
    $FLECHE_HAUT    = '<font class=s><b>^</b>&nbsp;</font>';

    /* Configuration pour des alertes en cas d'erreur en prod */
    
    define('ALERT_EMAIL', 'adinanid@mairie-aixenprovence.fr'); // Adresse Email du dev
    define('PROJET_CLE_LDAP', 'NO_KEY');
    define('PROJET_NAME', 'arrp'); // Nom du projet
    define('PROJET_AFF_NOM', 'ARRP');
    define('PROJET_AFF_VERSION', '1.0');
    define('PROJET_TITRE', 'Recommandés');
    define('PROJET_AFF_CONTACT_EMAIL', ALERT_EMAIL);
    define('PROJET_AFF_CONTACT_TEL', '94.98');
    define('DUREE_TOKEN',21600); // 6heure

    $NB_ONGLET_MAX = 10;
    $TYPE_DOC_AUTORISE = array('.pdf','.gif','.jpg','.jpeg','.tiff','.png','.bmp','.doc','.xls','.odt','.ods','.axx','.docx','.xlsx');
    $FILE_MAX_SIZE = 20480; //20M
    $FILE_ICONE_MAX_SIZE = 512; //512Ko
    $TAB_STATUT = array(
                            '0'     =>  'A traiter',
                            '1'     =>  'En cours',
                            '5'     =>  'Traitée',
                            //'9'     =>  'Archivée',
                        );
    $TAB_MOIS   = array(
                            '01'    =>  'Janvier',
                            '02'    =>  'Février',
                            '03'    =>  'Mars',
                            '04'    =>  'Avril',
                            '05'    =>  'Mai',
                            '06'    =>  'Juin',
                            '07'    =>  'Juillet',
                            '08'    =>  'Août',
                            '09'    =>  'Septembre',
                            '10'    =>  'Octobre',
                            '11'    =>  'Novembre',
                            '12'    =>  'Décembre',
                        );
    /* Fin de configuration des alertes en cas d'erreur en prod */

    // Définition des fichiers javascript à inclure
    $JAVASCRIPTS = array(
                            $GENERAL_URL.'/javascript/fonctions.js',
                            $GENERAL_URL.'/javascript/autocomplete.js',
                            
                            $GENERAL_URL.'/javascript/jquery/jquery.min.js',
                            $GENERAL_URL.'/javascript/jquery/jquery-ui.js',
                            $GENERAL_URL.'/javascript/autocomplete.js',
                            $GENERAL_URL.'/javascript/jquery.form.min.js',
                            $GENERAL_URL.'/javascript/jquery.dataTables.min.js',
                            //$GENERAL_URL.'/javascript/DataTables-1.10.11/jquery.dataTables.min.js',
                            $GENERAL_URL.'/javascript/datetimepicker/jquery.datetimepicker.js',
                            $GENERAL_URL.'/javascript/bootstrap/js/bootstrap.min.js',
                            $GENERAL_URL.'/javascript/select2/select2.min.js',
                        );

    $CSS_TO_LOAD = array(
                            $GENERAL_URL.'/css/jquery.dataTables.min.css',
                            //$GENERAL_URL.'/librairie/bootstrap-3/css/bootstrap.min.css',
                            $GENERAL_URL.'/css/bootstrap.css',
                            $GENERAL_URL.'/css/bootstrap-responsive.css',
                            $GENERAL_URL.'/javascript/datetimepicker/jquery.datetimepicker.css',
                            $GENERAL_URL.'/javascript/jquery/jquery-ui.min.css',
                            $GENERAL_URL.'/javascript/jquery/jquery-ui.structure.min.css',
                            $GENERAL_URL.'/javascript/jquery/jquery-ui.theme.min.css',

                            $GENERAL_URL.'/javascript/select2/select2.css',
                            $GENERAL_URL.'/style.css',
                        );
                        
    // Définition des pages (module, titre...)
    $PAGES  =   array(
                        '0'     =>array(
                                        'MODULE' => 'accueil',
                                        'TITRE' => 'Application des Recommandés',
                                        'DESCRIPTION' => 'Bienvenue sur la gestion des ARRP',
                                        'IMAGE' => 'default.gif',
                                        //'IMAGE_WIDTH' => '150',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '1'     =>array(
                                        'MODULE' => 'not_autorized',
                                        'TITRE' => 'Accès restreint',
                                        'DESCRIPTION' => 'Accès restreint.',
                                        'IMAGE' => 'connexion.gif',
                                        ),
                        '2'     =>array(
                                        'MODULE' => 'demandeurs',
                                        'TITRE' => 'Demandeurs',
                                        'DESCRIPTION' => 'Demandeurs',
                                        'IMAGE' => 'businessmen_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '201'     =>array(
                                        'MODULE' => 'demandeur_ajout',
                                        'TITRE' => 'Ajout Demandeur',
                                        'DESCRIPTION' => 'Ajout Demandeur.',
                                        'IMAGE' => 'businessmen_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '202'     =>array(
                                        'MODULE' => 'demandeur_ajout_save',
                                        'TITRE' => 'Ajout Demandeur',
                                        'DESCRIPTION' => 'Ajout Demandeur',
                                        'IMAGE' => 'businessmen_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '203'     =>array(
                                        'MODULE' => 'demandeurs_delete',
                                        'TITRE' => 'Suppression Demandeur',
                                        'DESCRIPTION' => 'Suppression Demandeur',
                                        'IMAGE' => 'businessmen_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '210'     =>array(
                                        'MODULE' => 'demandeur_ajax',
                                        'TITRE' => 'Demandeur',
                                        'DESCRIPTION' => 'Demandeur',
                                        'IMAGE' => 'businessmen_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '3'     =>array(
                                        'MODULE' => 'demande',
                                        'TITRE' => 'Demandes',
                                        'DESCRIPTION' => 'Demandes.',
                                        'IMAGE' => 'distribution_eau_reseau_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '301'     =>array(
                                        'MODULE' => 'demande_ajout',
                                        'TITRE' => 'Ajout Demande',
                                        'DESCRIPTION' => 'Ajout Demande',
                                        'IMAGE' => 'distribution_eau_reseau_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '302'     =>array(
                                        'MODULE' => 'demande_ajout_save',
                                        'TITRE' => 'Ajout Demande',
                                        'DESCRIPTION' => 'Ajout Demandes',
                                        'IMAGE' => 'distribution_eau_reseau_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '303'     =>array(
                                        'MODULE' => 'demande_ajout_ajax',
                                        'TITRE' => 'Ajout Demandeur',
                                        'DESCRIPTION' => 'Ajout Demandeur',
                                        'IMAGE' => 'distribution_eau_reseau_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '304'     =>array(
                                        'MODULE' => 'demande_courrier_pdf',
                                        'TITRE' => 'Courrier Demande',
                                        'DESCRIPTION' => 'Courrier demande',
                                        'IMAGE' => 'distribution_eau_reseau_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '305'     =>array(
                                        'MODULE' => 'demande_delete',
                                        'TITRE' => 'Suppression Demande',
                                        'DESCRIPTION' => 'Suppression Demande',
                                        'IMAGE' => 'distribution_eau_reseau_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '310'     =>array(
                                        'MODULE' => 'demande_ajax',
                                        'TITRE' => 'Demandes',
                                        'DESCRIPTION' => 'Demandes',
                                        'IMAGE' => 'distribution_eau_reseau_48.jpg',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '6'     =>array(
                                        'MODULE' => 'carte',
                                        'TITRE' => 'Carte',
                                        'DESCRIPTION' => 'Carte',
                                        'SECURE_ACCESS' => 1,
                                        'IMAGE' => 'earth_location_48.png',
                                        'SECURE_ACCESS' => 1,
                                        'NO_MOOTOOLS' => 1,
                                        ),
                        '601'     =>array(
                                        'MODULE' => 'carte_save',
                                        'TITRE' => 'Carte',
                                        'DESCRIPTION' => 'Carte',
                                        'SECURE_ACCESS' => 1,
                                        'IMAGE' => 'earth_location_48.png',
                                        'SECURE_ACCESS' => 1,
                                        'NO_MOOTOOLS' => 1,
                                        ),
                        '7'     =>array(
                                        'MODULE' => 'carte_public',
                                        'TITRE' => 'Carte',
                                        'DESCRIPTION' => 'Carte',
                                        'SECURE_ACCESS' => 0,
                                        'IMAGE' => 'earth_location_48.png',
                                        'NO_MOOTOOLS' => 1,
                                ),
                        '8'     =>array(
                                        'MODULE' => 'param',
                                        'TITRE' => 'Paramètres',
                                        'DESCRIPTION' => 'Param&egrave;tres',
                                        'IMAGE' => 'gear_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '801'     =>array(
                                        'MODULE' => 'param_agents',
                                        'TITRE' => 'Interlocuteurs',
                                        'DESCRIPTION' => 'Interlocuteurs',
                                        'IMAGE' => 'user_headset_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '80101'     =>array(
                                        'MODULE' => 'param_agents_ajout',
                                        'TITRE' => 'Ajout Interlocuteur',
                                        'DESCRIPTION' => 'Ajout',
                                        'IMAGE' => 'user_headset_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '8010101'     =>array(
                                        'MODULE' => 'param_agents_ajout_save',
                                        'TITRE' => 'Ajout Interlocuteurs',
                                        'DESCRIPTION' => 'Ajout',
                                        'IMAGE' => 'user_headset_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '802'     =>array(
                                        'MODULE' => 'param_agents',
                                        'TITRE' => 'Attestants',
                                        'DESCRIPTION' => 'Attestants',
                                        'IMAGE' => 'user1_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '80201'     =>array(
                                        'MODULE' => 'param_agents_ajout',
                                        'TITRE' => 'Ajout Attestant',
                                        'DESCRIPTION' => 'Ajout',
                                        'IMAGE' => 'user_headset_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '8020101'     =>array(
                                        'MODULE' => 'param_agents_ajout_save',
                                        'TITRE' => 'Ajout Attestants',
                                        'DESCRIPTION' => 'Ajout',
                                        'IMAGE' => 'user_headset_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '803'     =>array(
                                        'MODULE' => 'param_agents',
                                        'TITRE' => 'Signataires',
                                        'DESCRIPTION' => 'Signataires',
                                        'IMAGE' => 'pen_blue_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '80301'     =>array(
                                        'MODULE' => 'param_agents_ajout',
                                        'TITRE' => 'Ajout Signataire',
                                        'DESCRIPTION' => 'Ajout',
                                        'IMAGE' => 'pen_blue_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '8030101'     =>array(
                                        'MODULE' => 'param_agents_ajout_save',
                                        'TITRE' => 'Ajout Signataires',
                                        'DESCRIPTION' => 'Ajout',
                                        'IMAGE' => 'pen_blue_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '804'     =>array(
                                        'MODULE' => 'param_courrier_entete_ajout',
                                        'TITRE' => 'Courrier entete',
                                        'DESCRIPTION' => 'Courrier entete',
                                        'IMAGE' => 'document_new_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                        '80401'     =>array(
                                        'MODULE' => 'param_courrier_entete_ajout_save',
                                        'TITRE' => 'Courrier entete',
                                        'DESCRIPTION' => 'Ajout',
                                        'IMAGE' => 'document_new_48.png',
                                        'SECURE_ACCESS' => 1,
                                        ),
                    );
    // Echapement des caractères spéciaux
    if ( get_magic_quotes_gpc() )
    {
        $_GET       = array_map('supprimeSlash', $_GET);     //array_map applique une fonction (ici stripslashes) sur tous les éléments de ce tableau 
        $_POST      = array_map('supprimeSlash', $_POST);    //et renvoie le tableau modifié
    }
?>