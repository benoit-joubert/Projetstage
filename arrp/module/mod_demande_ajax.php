<?php

//if (isset($_POST['Page']))
//    $P_Precedente = $_POST['Page'];
//elseif (isset($_GET['Page']))
//    $P_Precedente = $_GET['Page'];
//else
//    $P_Precedente = 0;
//
//$P = $_GET['P'];
//
//$id_etablissement= $_GET['id_etablissement'];
//$page->afficheHeader();

/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */

        $aColumns = array( 'ID_DEMANDE', 
                            'LIB_COMMUNE',
                            'NOM',
                            'REFERENCE',
                            'CONTACT',
                            'DATE_DEMANDE',
                            'LIST_PARCELLE_ABR',
                            'LIB_STATUT_DEMANDE',
                            'ID_DEMANDEUR', 
                        );
                
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = 'ID_DEMANDE';
	
	/* DB table to use */
	$sTable = 'ARRP_V_DEMANDES';
	
    /*
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "WHERE  rowsNumerator BETWEEN :iDisplayStart AND :iDisplayEnd";
    }
	
	
	/*
     * Ordering
     */
      
     
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY ";
         
        //Go over all sorting cols
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            //If need to sort by current col
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                //Add to the order by clause
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ];
                 
                //Determine if it is sorted asc or desc
                if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc") == 0)
                {
                    $sOrder .=" asc, ";
                }else
                {
                    $sOrder .=" desc, ";
                }
            }
        }
        
         
        //Remove the last space / comma
        $sOrder = substr_replace( $sOrder, "", -2 );
         
        //Check if there is an order by clause
        if ( $sOrder == "ORDER BY" )
        {
            /*
            * If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
            * If there is no order by clause there might be bugs in table display.
            * No order by clause means that the db is not responsible for the data ordering,
            * which means that the same row can be displayed in two pages - while
            * another row will not be displayed at all.
            */
            $sOrder = "ORDER BY ".$sIndexColumn;
             
        }
    }
	
	/*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables.
     */
    $sWhere = 'WHERE CODE_COM in(' . $_SESSION[PROJET_NAME]['code_com'] . ')';
    $nWhereGenearalCount = 0;
    if (isset($_GET['sSearch']))
    {
        $sWhereGenearal = $_GET['sSearch'];
    }
    else
    {
        $sWhereGenearal = '';
    }
 
    if ( $_GET['sSearch'] != "" )
    {
        //Set a default where clause in order for the where clause not to fail
        //in cases where there are no searchable cols at all.
        $sWhere .= " AND (";
        for ( $i=0 ; $i<count($aColumns)-1 ; $i++ )
        {
            //If current col has a search param
            if ( $_GET['bSearchable_'.$i] == "true" )
            {
                //Add the search to the where clause
                $sWhere .= "UPPER(" . $aColumns[$i].") LIKE '%".protegeChaineOracle(strtoupper($_GET['sSearch']))."%' OR ";
                $nWhereGenearalCount += 1;
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    $sWhereSpecificArray = array();
    $sWhereSpecificArrayCount = 0;
    
/*
     * SQL queries
     * Get data to display
     */
     //Inner sql - not being fetched by itself.
    $sQueryInner = "SELECT ".implode(', ', $aColumns).", row_number() over (".$sOrder.") rowsNumerator FROM   ".$sTable." ".$sWhere;
    $sQueryFinal = "SELECT ".implode(', ', $aColumns)." FROM (".$sQueryInner.") qry ".$sLimit." ORDER BY rowsNumerator";
     
//     echo $sQueryFinal;
    /* Data set length after filtering */
    $sQueryFinalCount = "SELECT COUNT(*) as \"totalRowsCount\" FROM (".$sQueryInner.") qry";
     
    $iFilteredTotal = 0;
     
    /* Total data set length */
    $sQueryTotalCount = "SELECT COUNT(".$sIndexColumn.") as \"totalRowsCount\" FROM  ".$sTable;
 
    //Create Statments
    $statmntFinal = oci_parse($db->connection, $sQueryFinal);
    $statmntFinalCount = oci_parse($db->connection, $sQueryFinalCount);
    $statmntTotalCount = oci_parse($db->connection, $sQueryTotalCount);
 
    //Bind variables.
    $dsplyStart = isset( $_GET['iDisplayStart'] ) ? $_GET['iDisplayStart'] : 0;
    $dsplyStart += 1;
    if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $dsplyRange = $_GET['iDisplayLength'];
        if ($dsplyRange > (2147483645 - $dsplyStart))
        {
            $dsplyRange = 2147483645;
        }
        else
        {
            $dsplyRange = $dsplyStart +  intval($dsplyRange) -1;
        }
    }
    else
    {
        $dsplyRange = 2147483645;
    }
     
    //Bind variables of number of rows to fetch.
    oci_bind_by_name($statmntFinal, ':iDisplayStart', $dsplyStart);
    oci_bind_by_name($statmntFinal, ':iDisplayEnd', $dsplyRange);
 
    //Execute selects
    oci_execute($statmntTotalCount);
    $iTotal = 0;
    while ($row = oci_fetch_array($statmntTotalCount, OCI_ASSOC))
    {
        $iTotal = $row['totalRowsCount'];
    }
    oci_free_statement($statmntTotalCount);
             
    oci_execute($statmntFinalCount);
    $iFilteredTotal = 0;
    while ($row = oci_fetch_array($statmntFinalCount, OCI_ASSOC))
    {
        $iFilteredTotal = $row['totalRowsCount'];
    }
    oci_free_statement($statmntFinalCount);
     
    
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
        
    oci_execute($statmntFinal);
     
//     print_r ($statmntFinal);
     
//    while ( $aRow = oci_fetch_array($statmntFinal, OCI_ASSOC) )
    while ( $aRow = oci_fetch_array($statmntFinal, OCI_RETURN_NULLS) )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns)-1 ; $i++ )
        {
            if ( $aColumns[$i] != '' ){
                $row[] = utf8_encode($aRow[ $aColumns[$i] ]);
            }elseif ( $aColumns[$i] == ' ' ){
                $row[] = ($aRow[ $aColumns[$i] ]==null) ? ' ' : utf8_encode($aRow[ $aColumns[$i] ]);
            }
        }
        $row[] = '<a href="./index.php?P=301&from=3&demande=' . $aRow[ $aColumns[0]] .'"><img src="./images/edit_24.png" border="0" title="Voir la demande" /></a>'.
                '<a href="./index.php?P=201&demandeur='.$aRow[ $aColumns[count($aColumns)-1] ].'&from=3"><img src="./images/user1_into_24.png" title="Afficher le demandeur"/></a>';
        $output['aaData'][] = $row;
    }
    oci_free_statement($statmntFinal);
	echo json_encode( $output );
//print_r($output);
//$page->afficheFooter();
?>
