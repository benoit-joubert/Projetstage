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

    public function sqlRequestDelete($from, $where) {
        //DELETE FROM PART
        $deleteRequest = 'DELETE FROM ';
        foreach ($from as $value){
            $deleteRequest .= $value;
        }

        //WHERE PART
        $deleteRequest .= ' WHERE ';
        foreach ($where as $value) {
            $deleteRequest .= $value . ' AND ';
        }
        $deleteRequest = substr($deleteRequest,0,-5);

        return $deleteRequest;
    }

    public function getElements($select, $from, $where ='', $groupBy='', $orderBy='', $order='') {

        $stid = oci_parse($this->connected,$this->sqlRequestView($select, $from, $where, $groupBy, $orderBy, $order));
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

    public function addElement($into,$element,$insertedElements) {
        $stid = oci_parse($this->connected,$this->sqlRequestInsert($into, $element, $insertedElements));
        oci_execute($stid);
    }
}