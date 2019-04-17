<?php
    require 'Connexion.php';

    $db = new Connexion();
    $listFileType = $db->getElements(array('TYPDOS'), array('TYPDOS'));
    $listRemarks = $db->getElements(array('REMARQUE'), array('REMARQUES'));
    $listRegistered = $db->getElements(array('TYPE_ENVOI', 'DOSSIER', 'DEMANDEUR', 'ADRESSE_1', 'ADRESSE_2', 'ADRESSE_3'), array('T_COMPLETE'), array('ROWNUM <= 100'));
?>
<html lang="fr-FR">
<head>
    <title>App. Recommandés</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Application de gestion des recommandés" />
    <meta name="keywords" content="dnsii, mairie, urbanisme, aix-en-provence, recommandés" />

    <link rel="stylesheet" href="style/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="script/script.js"></script>
</head>
<body>
    <div id="registered_form"></div>
    <div id="search_fields"></div>
    <div id="registered_list"></div>

    <script>
        let registeredList = <?= $listRegistered; ?>;
        let remarkList = <?= $listRemarks; ?>;
        let fileTypeList = <?= $listFileType; ?>;
    </script>
</body>
</html>
