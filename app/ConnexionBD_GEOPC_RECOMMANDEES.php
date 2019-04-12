<?php


class ConnexionBD_GEOPCRECOMMANDEES
{
    private $user = "GEOPC_RECOMMANDEES";
    private $password ="test";
    private $connected;

    public function seConnecter()
    {
        $this->connected = oci_connect($this->user, $this->password, 'sdiadem-cluster.intranet/SIGTEST');
    }

    public function afficherTable()
    {
        $stid = oci_parse($this->connected,'SELECT * FROM T_COMPLETE');
        oci_execute($stid);

        echo "<table border='1'>\n";
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo "<tr>\n";
            foreach ($row as $item) {
                echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";

    }

}