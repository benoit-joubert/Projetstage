<?php

?>
<html lang="FR">
<head>
    <title>Recommand�</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div id="menu">
        <ul id="onglets">
            <li class="active"><a href="index.php">Recommand�</a></li>
            <li><a href="recherche.php"> Recherche </a></li>
        </ul>
    </div>
    <div id="form_donneesreco">
        <form method="post" action="?">
            <input id="nom" type="text" placeholder="Nom" required>
            <input id="type" type ="text" placeholder="type" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>
    <div id="bastableau">
        <button id="pdf">Convertir en PDF</button>
        <button id="print">Imprimer</button>
    </div>
</body>
</html>
