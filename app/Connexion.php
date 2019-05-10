<?php

if (isset($_POST['function'])) {

    $function = $_POST['function'];
    $params = $_POST['params'];

    $calledFunction = '$db = new Connexion(); echo $db->' . $_POST['function'] . '(';
    foreach ($params as $param => $value) {
        $calledFunction .= $value . ', ';
    }
    $calledFunction = substr($calledFunction,0,-2);
    $calledFunction .= ');';

    eval($calledFunction);
}

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

    public function sqlRequestView($select, $from, $where = '', $groupBy = '', $orderBy = '', $order = '') {

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
        if ($where != '') {
            $sqlRequest .= ' WHERE ';
            foreach ($where as $item) {
                $sqlRequest .= $item . ' AND ';
            }
            $sqlRequest = substr($sqlRequest, 0, -5);
        }

        //GROUP BY PART
        if ($groupBy != '') {
            $sqlRequest .= ' GROUP BY ';
            foreach ($groupBy as $item) {
                $sqlRequest .= $item . ', ';
            }
            $sqlRequest = substr($sqlRequest, 0, -2);
        }

         //ORDER BY PART
        if($orderBy != '') {
            $sqlRequest .= ' ORDER BY ';
            foreach ($orderBy as $item) {
                $sqlRequest .= $item . ', ';
            }
            $sqlRequest = substr($sqlRequest, 0, -2);
        }

        //ORDER PART
        if ($order != '') $sqlRequest .= ' ' . $order;

        return $sqlRequest;
    }

    public function sqlRequestInsert($into, $elements, $insertedElements){

        //INSERT INTO PART
        $insertRequest = 'INSERT INTO ';
        foreach ($into as $value) {
            $insertRequest .= $value;
        }
        //ELEMENTS PART
        $insertRequest .= '(';
        foreach ($elements as $value){
            $insertRequest .= $value . ', ';
        }
        $insertRequest = substr($insertRequest,0,-2);
        $insertRequest .= ')';

        //INSERTED ELEMENTS PART
        $insertRequest .= ' VALUES (';
        foreach ($insertedElements as $value){
            $insertRequest .= $value . ', ';
        }
        $insertRequest = substr($insertRequest,0,-2);
        $insertRequest .= ')';

        return $insertRequest;
    }

    public function sqlRequestUpdate($from, $element, $updatedElement, $where) {

        //UPDATE PART
        $updateRequest = 'UPDATE ';
        $updateRequest .= $from;

        //SET PART
        $updateRequest .= ' SET ' . $element . ' = ' . $updatedElement;

        //WHERE PART
        $updateRequest .= ' WHERE ' . $where;

        return $updateRequest;
    }

    public function getElements($select, $from, $where = '', $groupBy = '', $orderBy = '', $order = '') {

        $stid = oci_parse($this->connected,$this->sqlRequestView($select, $from, $where, $groupBy, $orderBy, $order));
        oci_execute($stid);

        $result = array();
        $count = 0;

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            foreach ($select as $sel) {
                $result[$count][$sel] = (isset($row[$sel])) ?  $row[$sel] : '';
            }
            ++$count;
        }

        return json_encode($result);
    }

    public function addElement($into,$element,$insertedElements) {

        $stid = oci_parse($this->connected,$this->sqlRequestInsert($into, $element, $insertedElements));
        oci_execute($stid);
    }

    public function updateElement($from, $element, $updatedElement, $json) {

        $json = json_decode($json);
        $cpt = 0;
        foreach ($json as $array){
            $nbe = count($json,COUNT_RECURSIVE);
            if ($nbe > 1) {
                foreach ($array as $filenum) {
                    if ($cpt > 0) {
                        $updatedElement = '(SELECT MAX(NUMERO_ENVOI) FROM T_COMPLETE)';
                    }
                    $where = 'DOSSIER = \'' . $filenum->DOSSIER . '\'';
                    $stid = oci_parse($this->connected, $this->sqlRequestUpdate($from, $element, $updatedElement, $where));
                    oci_execute($stid);
                    ++$cpt;
                }
            }
            else {
                $where = 'DOSSIER = \'' . $array->DOSSIER . '\'' ;
                $stid = oci_parse($this->connected,$this->sqlRequestUpdate($from, $element, $updatedElement, $where));
                oci_execute($stid);
            }
        }
    }
}