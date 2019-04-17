<?php

class Connexion {

    private $user = 'GEOPC_RECOMMANDEES';
    private $password = 'test';
    private $host = 'sdiadem-cluster.intranet/SIGTEST';
    private $connected;
    private $queryArray = [];

    public function __construct() {

        $this->connected = oci_connect(
            $this->user,
            $this->password,
            $this->host
        );
    }

    public function sqlRequest($select, $from, $where ='', $groupby='', $orderby='', $order='') {
        // SELECT PART
        $sqlRequest = 'SELECT ';
        foreach ($select as $item){
            $sqlRequest .= $item. ', ';
        }
        $sqlRequest = substr($sqlRequest,0,-2);
        //FROM PART
        $sqlRequest .= ' FROM ';
        foreach ($from as $item){
            $sqlRequest .= $item. ', ';
        }
        $sqlRequest = substr($sqlRequest,0,-2);
        //WHERE PART
        if ($where !='') {
            $sqlRequest .= ' WHERE ';
            foreach ($where as $item) {
                $sqlRequest .= $item . ' AND ';
            }
            $sqlRequest = substr($sqlRequest, 0, -5);
        }
        //GROUP BY PART
        if ($groupby !='') {
            $sqlRequest .= ' GROUP BY ';
            foreach ($groupby as $item) {
                $sqlRequest .= $item . ', ';
            }
            $sqlRequest = substr($sqlRequest, 0, -2);
        }
         //ORDER BY PART
        if($orderby !='') {
            $sqlRequest .= ' ORDER BY ';
            foreach ($orderby as $item) {
                $sqlRequest .= $item . ', ';
            }
            $sqlRequest = substr($sqlRequest, 0, -2);
        }
        //ORDER PART
        if ($order != '') $sqlRequest .= ' ' . $order;



        return $sqlRequest;
    }

    public function getElements($select, $from, $where ='', $groupby='', $orderby='', $order='') {

        $stid = oci_parse($this->connected,$this->sqlRequest($select, $from, $where, $groupby, $orderby, $order));
        oci_execute($stid);

        $result = array();
        $count = 0;

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            foreach ($select as $sel) {
                if (isset($row[$sel])) $result[$count][$sel] = $row[$sel];
            }
            ++$count;
        }

        return json_encode($result);
    }
}