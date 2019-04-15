<?php


class ConnexionBD_GPC_ENTDOS
{
    private $user = "GEOPC_RECOMMANDEES";
    private $password ="test";

    public function seConnecter() {
        if(!oci_connect($this->user,$this->password,'sdiadem-cluster.intranet/SIGTEST')){
            echo "Echec";
        }
        else echo "Connecté";
    }

}