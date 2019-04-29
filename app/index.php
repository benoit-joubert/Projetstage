<?php
    require 'Connexion.php';

    $db = new Connexion();
    $listFileType = $db->getElements(array('TYPDOS'), array('TYPDOS'));
    $listRemarks = $db->getElements(array('REMARQUE'), array('REMARQUES')); ?>
<html lang="fr-FR">
<head>
    <title>App. Recommandés</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Application de gestion des recommandés" />
    <meta name="keywords" content="dnsii, mairie, urbanisme, aix-en-provence, recommandés" />

    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="script/script.js"></script>
</head>
<body>
    <div id="registered_form"></div>
    <div id="search_fields"></div>
    <div id="registered_list"></div>

    <script>
        let nbElements = 0;
        let typeTab = 'ajout';
        let clickedFile;
        let registeredList = [];
        let remarkList = <?= $listRemarks; ?>;
        let fileTypeList = <?= $listFileType; ?>;
    </script>
</body>
</html>
