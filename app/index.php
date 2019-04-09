<html lang="FR">
<head>
    <title>Recommandé</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script rel="script" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script rel="script" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script rel="script" src="script/autocompletion.js"></script>
    <script rel="script" src="script/header.js"></script>
</head>
<body>
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
