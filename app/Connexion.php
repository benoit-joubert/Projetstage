<?php

class Connexion {

    private $user = 'GEOPC_RECOMMANDEES';
    private $password = 'test';
    private $host = 'sdiadem-cluster.intranet/SIGTEST';
    private $connected;

    public function __construct() {

        $this->connected = oci_connect(
            $this->user,
            $this->password,
            $this->host
        );
    }

    public function sqlRequest($tableName, $rownum, ...$fields) {

        // SELECT PART
        $sqlRequest = 'SELECT ';
        foreach ($fields as $field) {
            $sqlRequest .= $field . ', ';
        }
        $sqlRequest = substr($sqlRequest, 0,-2);

        // FROM PART
        $sqlRequest .= ' FROM ' . $tableName;

        // ROWNUM PART
        if ($rownum != '') $sqlRequest .= ' WHERE ROWNUM <= ' . $rownum;

        return $sqlRequest;
    }

    public function getElements($tableName, $rownum, ...$fields) {

        $stid = oci_parse($this->connected,$this->sqlRequest($tableName, $rownum, ...$fields));
        oci_execute($stid);

        $result = array();
        $count = 0;

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            foreach ($fields as $field) {
                if (isset($row[$field])) $result[$count][$field] = $row[$field];
            }
            ++$count;
        }

        return json_encode($result);
    }
}