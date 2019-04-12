<?php
require "ConnexionBD_GEOPC_RECOMMANDEES.php";

$db = new ConnexionBD_GEOPCRECOMMANDEES();
$db->seConnecter();
$db->afficherTable();
