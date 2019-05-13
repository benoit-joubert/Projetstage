<?php

class SigMapApi
{
	var $_db = null;
	var $_retourType = null;
    var $_retour = null;
    var $_excludeCat = array();
    var $_idElec = '53';
    var $_anneeDecoupage = '2014';
    var $_nbCandidat = 10;
    var $_tour = 1;
    var $_bureau = null;

	function __construct($aParams = array())
	{
		if (isset($aParams['db']) == true)
		{
			$this->_db = $aParams['db'];
		}

		if (isset($aParams['retour_type']) == true)
		{
			$this->_retourType = $aParams['retour_type'];
		}

		if (isset($aParams['retour']) == true)
		{
			$this->_retour = $aParams['retour'];
		}

		if (isset($aParams['id_elec']) == true)
		{
			$this->_idElec = $aParams['id_elec'];
		}

		if (isset($aParams['tour']) == true)
		{
			$this->_tour = $aParams['tour'];
		}

		if (isset($aParams['bureau']) == true)
		{
			$this->_bureau = $aParams['bureau'];
		}
		

		if ($this->_idElec == '54')
		{
			$this->_nbCandidat = 2;
		}



		if (isset($aParams['annee_decoupage']) == true)
		{
			$this->_anneeDecoupage = $aParams['annee_decoupage'];
		}

		$this->_excludeCat = array(
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0207000000' ),
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0107000000' ),
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0201000000' ),
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0102000000' ),
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0604000000' ),
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0403000000' ),
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0209000000' ),
			array( 'key' => 'NOMENCL_NIVEAU2', 'value' => '0208000000' ),
		);
	}

	function retour($aParams = array(), $data = null)
	{
		if ($this->_retourType == 'json')
		{
			$data = json_encode($data);
		}

		if ($this->_retour == 'echo')
		{
			echo $data;
		}
		else
		{
			return $data;
		}

	}

	function getPositionValue($position = '')
	{
		return floatval(str_replace(',', '.', $position));
	}

	function encodeTableau($tableau = array())
	{
		if (is_array($tableau) == true
			&& count($tableau) > 0)
		{
			foreach ($tableau as $k => $tempo)
			{
				foreach ($tempo as $key => $value)
				{
					if (is_numeric($value) == true)
					{
						$tableau[$k][$key] = floatval($value);
					}
					elseif (is_string($value) == true)
					{
						$tableau[$k][$key] = utf8_encode($value);
					}
				}
			}
		}

		return $tableau;
	}

	function getLayersQuartier($aParams = array())
	{
		$retour = array();

		$listeChamp = array();

		$listeChamp['select'] = array(
			'CDE_QUARTIER',
			'LIBELLE_QUARTIER',
			'ADRESSE',
			'CODE_POSTAL',
			'VILLE',
			'NUM_QUARTIER',
			'SDO_UTIL.TO_WKTGEOMETRY(GEOMETRY)',
		);

		$listeChamp['retour'] = array(
			'CDE_QUARTIER',
			'LIBELLE_QUARTIER',
			'ADRESSE',
			'CODE_POSTAL',
			'VILLE',
			'NUM_QUARTIER',
			'GEOMETRY',
		);

		$req = 'select '.implode(',', $listeChamp['select']);
		$req .= ' from SIGAIX.SIG_QUARTIERS_ADMINISTRATIFS';
		$req .= ' where ANNEE_DECOUPAGE = \'2015\'';
		$req .= ' order by LIBELLE_QUARTIER asc';

		$res = executeReq($this->_db, $req);

		
		while ($row = $res->fetchRow())
		{
			$tempo = array();

			foreach ($row as $key => $value)
			{
				$tempo[ $listeChamp['retour'][$key] ] = $value;

			}

			$minx = $miny = $maxx = $maxy = null;

			$tempo2 = str_replace('POLYGON ((', '', $tempo['GEOMETRY']);
			$tempo2 = str_replace('))', '', $tempo2);

			$tempo2 = explode(',', $tempo2);

			foreach ($tempo2 as $key => $value)
			{
				$coord = explode(' ', trim($value));
				if ($minx == null)
				{
					$minx = $maxx = $coord[0];
					$miny = $maxy = $coord[1];
				}
				else
				{
					if ($minx > $coord[0])
					{
						$minx = $coord[0];
					}

					if ($maxx < $coord[0])
					{
						$maxx = $coord[0];
					}

					if ($miny > $coord[1])
					{
						$miny = $coord[1];
					}

					if ($maxy < $coord[1])
					{
						$maxy = $coord[1];
					}
				}
			}

			$tempo['EXTENT'] = array(
				floatval($minx),
				floatval($miny),
				floatval($maxx),
				floatval($maxy)
			);

			$retour[] = $tempo;
			//print_jv($tempo);die();
		}

		$retour = $this->encodeTableau($retour);
		return $this->retour($aParams, $retour);
	}

	function getLayers($aParams = array())
	{
		$retour = array();

		$listeChamp = array();

		$listeChamp['select'] = array(
			'ebg.ANNEE_DECOUPAGE',
			'ebg.LIB_NOM_BUREAU',
			'ebg.LIB_NUM_BUREAU',
			'ebg.NUM_BUREAU',
			'ebg.ID_QUARTIER_ADMIN',
			'ebg.LIB_QUARTIER',
			'ebg.CIRCONSCRIPTION',
			'SDO_UTIL.TO_WKTGEOMETRY(ebg.GEOMETRY)',

			'ecrl.ID_ELEC',
			'ecrl.ID_BUREAU',
			/*
			'ecrl.ID_CAND1',
			'ecrl.NOM_CAND1',
			'ecrl.NB_VOIX1',
			'ecrl.ID_CAND2',
			'ecrl.NOM_CAND2',
			'ecrl.NB_VOIX2',
			*/

			'ebr.ID_BUREAU',
			'ebr.ID_ELEC',
			'ebr.NB_INSCRITS',
			'ebr.NB_VOTANTS',
			'ebr.NB_NULS',
			'ebr.NB_EXPRIMES',
			'ebr.NB_EMARGEMENTS',
			'ebr.NB_UN',
			'ebr.NB_DEUX',
			'ebr.NB_TROIS',
			'ebr.NB_QUATRE',
			'ebr.TAG',
			'ebr.NB_PROCURATIONS',
			'ebr.NB_CINQ',
			'ebr.TAG_TEL',
			'ebr.TAG_DIFFUSION',
			'ebr.HEURE_VALID',
			'ebr.HEURE_TEL',
			'ebr.NB_BLANCS',
			'qa.LIBELLE_QUARTIER',
		);

		$listeChamp['retour'] = array(
			'ANNEE_DECOUPAGE',
			'LIB_NOM_BUREAU',
			'LIB_NUM_BUREAU',
			'NUM_BUREAU',
			'ID_QUARTIER_ADMIN',
			'LIB_QUARTIER',
			'CIRCONSCRIPTION',
			'GEOMETRY',

			'ID_ELEC',
			'ID_BUREAU',
			
			/*
			'ID_CAND1',
			'NOM_CAND1',
			'NB_VOIX1',
			'ID_CAND2',
			'NOM_CAND2',
			'NB_VOIX2',
			*/

			'ID_BUREAU',
			'ID_ELEC',
			'NB_INSCRITS',
			'NB_VOTANTS',
			'NB_NULS',
			'NB_EXPRIMES',
			'NB_EMARGEMENTS',
			'NB_UN',
			'NB_DEUX',
			'NB_TROIS',
			'NB_QUATRE',
			'TAG',
			'NB_PROCURATIONS',
			'NB_CINQ',
			'TAG_TEL',
			'TAG_DIFFUSION',
			'HEURE_VALID',
			'HEURE_TEL',
			'NB_BLANCS',
			'LIBELLE_QUARTIER',
		);


		for ($i=1; $i <= $this->_nbCandidat; $i++)
		{
			$listeChamp['select'][] = 'ecrl.ID_CAND'.$i;
			$listeChamp['select'][] = 'ecrl.NOM_CAND'.$i;
			$listeChamp['select'][] = 'ecrl.NB_VOIX'.$i;

			$listeChamp['retour'][] = 'ID_CAND'.$i;
			$listeChamp['retour'][] = 'NOM_CAND'.$i;
			$listeChamp['retour'][] = 'NB_VOIX'.$i;
		}

		$req = 'select '.implode(',', $listeChamp['select']);
		$req .= ' from EL_BUREAUX_GLOBAL ebg';
		$req .= ' left join EL_CANDIDATS_RES_LIST ecrl';
		$req .= ' on (ebg.NUM_BUREAU = ecrl.ID_BUREAU)';

		$req .= ' left join EL_BUREAUX_RES ebr';
		$req .= ' on (ebg.NUM_BUREAU = ebr.ID_BUREAU)';

		$req .= ' left join SIGAIX.SIG_QUARTIERS_ADMINISTRATIFS qa';
		$req .= ' on (ebg.ID_QUARTIER_ADMIN = qa.CDE_QUARTIER)';
		
		$req .= ' where ebg.ANNEE_DECOUPAGE = \''.$this->_anneeDecoupage.'\'';
		$req .= ' and ecrl.ID_ELEC = \''.$this->_idElec.'\'';
		$req .= ' and ebr.ID_ELEC = \''.$this->_idElec.'\'';
		$req .= ' and qa.ANNEE_DECOUPAGE = \'2015\'';
		
		$res = executeReq($this->_db, $req);print_jv($req);die();

		$calculChamp = array(
			'VOTANTS',
			'NULS',
			'EXPRIMES',
			'EMARGEMENTS',
		);

		while ($row = $res->fetchRow())
		{
			$tempo = array();

			foreach ($row as $key => $value)
			{
				$tempo[ $listeChamp['retour'][$key] ] = $value;

			}

			// debug de nom
			/*
			if (preg_match('/CHUISANO/', $tempo['NOM_CAND9']) > 0)
			{
				$tempo['NOM_CAND9'] = utf8_decode('CHUISANO Noël');
			}*/

			// ajout de champ calculer
			$total = 0;

			$compteCandidat = array();

			for ($i=1; $i <= $this->_nbCandidat; $i++)
			{
				if ($tempo['NB_VOIX'.$i] == null)
				{
					$tempo['NB_VOIX'.$i] = 0;
				}
				$total = $total + $tempo['NB_VOIX'.$i];
				$compteCandidat[$i] = $tempo['NB_VOIX'.$i];
			}

			$total = $tempo['NB_EXPRIMES'];

			for ($i=1; $i <= $this->_nbCandidat; $i++)
			{
				if ($total == 0)
				{
					$tempo['POURCENTAGE_CAND'.$i] = 0;
				}
				else
				{
					$tempo['POURCENTAGE_CAND'.$i] = (($tempo['NB_VOIX'.$i] * 100) / $total);
				}

				if ($tempo['ID_CAND'.$i] == '498')
				{
					$tempo['NOM_CAND'.$i] = utf8_decode('CHUISANO Noël');
				}
			}

			foreach ($calculChamp as $value)
			{
				if ($value == 'EXPRIMES')
				{
					$cleCalcul = 'VOTANTS';
				}
				else
				{
					$cleCalcul = 'INSCRITS';
				}

				if ($tempo['NB_'.$cleCalcul] == 0)
				{
					$tempo['POURCENTAGE_'.$value] = 0;
				}
				else
				{
					$tempo['POURCENTAGE_'.$value] = (($tempo['NB_'.$value] * 100) / $tempo['NB_'.$cleCalcul]);
				}
			}

			if ($this->_tour == 1)
			{
				arsort($compteCandidat);
				
				$tempo2 = $tempo;
				$idCompte = 1;

				foreach ($compteCandidat as $key => $value)
				{
					
					$tempo['ID_CAND'.$idCompte] = $tempo2['ID_CAND'.$key];
    				$tempo['NOM_CAND'.$idCompte] = $tempo2['NOM_CAND'.$key];
    				$tempo['NB_VOIX'.$idCompte] = $tempo2['NB_VOIX'.$key];
    				$tempo['POURCENTAGE_CAND'.$idCompte] = $tempo2['POURCENTAGE_CAND'.$key];

					$idCompte++;
				}
			}

			// reinitialise tout a zero si
			if ($tempo['TAG_DIFFUSION'] == 0)
			{	
				foreach ($calculChamp as $key => $value)
				{
					$tempo['NB_'.$value] = 0;
					$tempo['POURCENTAGE_'.$value] = 0;
				}


				$listeZeroC = array(
					'ID_CAND',
    				'NOM_CAND',
    				'NB_VOIX',
    				'POURCENTAGE_CAND',
				);

				for ($i=1; $i <= $this->_nbCandidat; $i++)
				{
					foreach ($listeZeroC as $key => $value)
					{
						$tempo[$value.$i] = 0;
					}
				}
			}


			$retour[] = $tempo;

			if ($tempo['NUM_BUREAU'] == '71')
			{
				print_jv($tempo);die();
			}
		}

		$retour = $this->encodeTableau($retour);
		return $this->retour($aParams, $retour);
	}



	function getLayersGeometry($aParams = array())
	{
		// recuperation des informations et definitions des valeur par defaut
		$retour = array();

		$listeChamp = array();

		$listeChamp['select'] = array(
			'IDPARC',
			//'NDEP',
			//'NCOM',
			//'NPSEC',
			//'NSEC',
			//'NFEUIL',
			//'NPAR',
			//'LABX',
			//'LABY',
			'SDO_UTIL.TO_WKTGEOMETRY(GEOMETRY)',
			// 'ENTITYID',
			// 'VERSIONNUMBER',
			// 'LOCKID',
			// 'SUPF',
		);

		$listeChamp['retour'] = array(
			'IDPARC',
			// 'NDEP',
			// 'NCOM',
			// 'NPSEC',
			// 'NSEC',
			// 'NFEUIL',
			// 'NPAR',
			// 'LABX',
			// 'LABY',
			'GEOMETRY',
			// 'ENTITYID',
			// 'VERSIONNUMBER',
			// 'LOCKID',
			// 'SUPF',
		);

		$req = 'select '.implode(',', $listeChamp['select']);
		$req .= ' from SIGAIX.PARCELLE_C_S';

		if (isset($aParams['id_parc']) == true)
		{
			$req .= ' where IDPARC in (\''.implode("','", $aParams['id_parc']).'\')';
		}

		$res = executeReq($this->_db, $req);

		if (DB::isError($this->_db))
		{
			print_jv($this->_db->getDebugInfo());
			die();
		}
		else
		{
			$compte = 0;
			while ($row = $res->fetchRow())
			// if ($row = $res->fetchRow())
			{
				$tempo = array();

				foreach ($row as $key => $value)
				{
					$tempo[ $listeChamp['retour'][$key] ] = $value;
				}

				$retour[] = $tempo;
				//print_jv($tempo);die();
				$compte++;
			}
			
		}

		
		$retour = $this->encodeTableau($retour);
		return $this->retour($aParams, $retour);

	}

	function getLayersPoint($aParams = array())
	{
		$retour = array();

		$listeChamp = array();

		$listeChamp['select'] = array(
			'ID_DEM_PARC',
			'adp.ID_DEMANDE',
			'ID_PARC',
			'LABX',
			'LABY',
			'ad.ID_DEMANDEUR',
			'CONTACT',
			'REFERENCE',
			'DATE_DEMANDE',
			'DATE_REPONSE',
			'STATUT_DEMANDE',
			'STATUT_AEP',
			'STATUT_EU',
			'ad.OBSERVATIONS',
			'ID_SIGNATAIRE',
			'URL_CARTE',
			'ID_ATTESTANT',
			'ID_INTERLOCUTEUR',
			'NOM',
			'PRENOM',
			'ADRESSE',
			'ADRESSE2',
			'CP',
			'VILLE',
			'EMAIL',
			'TEL1',
			'TEL2',
			'ad2.OBSERVATIONS',
		);

		$listeChamp['retour'] = array(
			array('key' => 'ID_DEM_PARC', 'type' => 'string'),
			array('key' => 'ID_DEMANDE', 'type' => 'string'),
			array('key' => 'ID_PARC', 'type' => 'string'),
			array('key' => 'LABX', 'type' => 'numeric'),
			array('key' => 'LABY', 'type' => 'numeric'),
			array('key' => 'ID_DEMANDEUR', 'type' => 'string'),
			array('key' => 'CONTACT', 'type' => 'string'),
			array('key' => 'REFERENCE', 'type' => 'string'),
			array('key' => 'DATE_DEMANDE', 'type' => 'string'),
			array('key' => 'DATE_REPONSE', 'type' => 'string'),
			array('key' => 'STATUT_DEMANDE', 'type' => 'string'),
			array('key' => 'STATUT_AEP', 'type' => 'string'),
			array('key' => 'STATUT_EU', 'type' => 'string'),
			array('key' => 'OBSERVATIONS', 'type' => 'string'),
			array('key' => 'ID_SIGNATAIRE', 'type' => 'string'),
			array('key' => 'URL_CARTE', 'type' => 'string'),
			array('key' => 'ID_ATTESTANT', 'type' => 'string'),
			array('key' => 'ID_INTERLOCUTEUR', 'type' => 'string'),
			array('key' => 'NOM', 'type' => 'string'),
			array('key' => 'PRENOM', 'type' => 'string'),
			array('key' => 'DENOMINATION', 'type' => 'string'),
			array('key' => 'ADRESSE2', 'type' => 'string'),
			array('key' => 'CP', 'type' => 'string'),
			array('key' => 'VILLE', 'type' => 'string'),
			array('key' => 'EMAIL', 'type' => 'string'),
			array('key' => 'TEL1', 'type' => 'string'),
			array('key' => 'TEL2', 'type' => 'string'),
			array('key' => 'OBSERVATIONS', 'type' => 'string'),
		);

		$req = 'select '.implode(',', $listeChamp['select']);
		$req .= ' from ARRP_DEMANDES_PARCELLES adp';
		$req .= ' left join ARRP_DEMANDES ad';
		$req .= ' on (adp.ID_DEMANDE = ad.ID_DEMANDE)';
		$req .= ' left join ARRP_DEMANDEURS ad2';
		$req .= ' on (ad.ID_DEMANDEUR = ad2.ID_DEMANDEUR)';

		if (isset($aParams['id_parc']) == true)
		{
			$req .= ' where ID_PARC in (\''.implode("','", $aParams['id_parc']).'\')';
		}

		if (isset($aParams['not_id_parc']) == true)
		{
			$req .= ' where ID_PARC not in (\''.implode("','", $aParams['not_id_parc']).'\')';
		}

		$res = executeReq($this->_db, $req);

		if (DB::isError($this->_db))
		{
			print_jv($this->_db->getDebugInfo());
			die();
		}
		else
		{
			$compte = 0;
			while ($row = $res->fetchRow())
			// if ($row = $res->fetchRow())
			{
				$tempo = array();

				foreach ($row as $key => $value)
				{
					if ($listeChamp['retour'][$key]['type'] == 'numeric')
					{
						$tempo[ $listeChamp['retour'][$key]['key'] ] = str_replace(',', '.', $value);
					}
					else
					{
						$tempo[ $listeChamp['retour'][$key]['key'] ] = $value;
					}
				}

				$retour[] = $tempo;
				//print_jv($tempo);die();
				$compte++;
			}
			
		}

		
		$retour = $this->encodeTableau($retour);
		return $this->retour($aParams, $retour);

		//PARCELLE_C_S

		// 'SDO_UTIL.TO_WKTGEOMETRY(GEOMETRY)',

		$req = 'select id_equipement, id_adr_location, nomencl_niveau2, nomencl_niveau3, nomencl_niveau4, libelle_affichage, nom_equipement, t.x x,t.y y';
		$req .= ' from equipements.eqp_v_eqp_niv2_geom_p';
		$req .= ', table(sdo_util.getvertices(geometry)) t';
		$req .= ' where 1=1';

		if (count($this->_excludeCat) > 0)
		{
			foreach ($this->_excludeCat as $value)
			{
				$req .= ' and '.$value['key'].' <> \''.$value['value'].'\'';
			}
		}

		$res = executeReq($this->_db, $req);

		$iconListe = $this->getIcons();

		while (list($id_equipement, $id_adr_location, $nomencl_niveau2, $nomencl_niveau3, $nomencl_niveau4, $libelle_affichage, $nom_equipement, $x, $y) = $res->fetchRow())
		{

		    if (isset($iconListe[$nomencl_niveau4]) == true)
		    {
		        $icon = $iconListe[$nomencl_niveau4]['icon'];
		        $puce = $iconListe[$nomencl_niveau4]['puce'];
		    }
		    elseif (isset($iconListe[$nomencl_niveau3]) == true)
		    {
		        $icon = $iconListe[$nomencl_niveau3]['icon'];
		        $puce = $iconListe[$nomencl_niveau3]['puce'];
		    }
			elseif (isset($iconListe[$nomencl_niveau2]) == true)
		    {
		        $icon = $iconListe[$nomencl_niveau2]['icon'];
		        $puce = $iconListe[$nomencl_niveau2]['puce'];
		    }
		    else
		    {
		        $icon = 'mapshtml/puces/vierge-gris.png';
		        $puce = 'mapshtml/puces/vierge-gris.png';
		        //continue;
		    }

		    $retour[ $nomencl_niveau2 ][] = array(
		        'x' => $this->getPositionValue( $x ),
		        'y' => $this->getPositionValue( $y ),
		        'libelle_affichage' => $libelle_affichage,
		        'nom_equipement' => $nom_equipement,
		        'nomencl_niveau2' => $nomencl_niveau2,
		        'nomencl_niveau3' => $nomencl_niveau3,
		        'nomencl_niveau4' => $nomencl_niveau4,
		        'icon' => $icon,
		        'puce' => $puce,
		    );
		}

		$retour = $this->encodeTableau($retour);
		
		return $this->retour($aParams, $retour);
	}

	function getLayersMenu($aParams = array())
	{
		// recuperation des informations et definitions des valeur par defaut
		$retour = array();

		$req = 'select nomencl_niveau2';
		$req .= ' from equipements.eqp_v_eqp_niv2_geom_p';
		$req .= ' where 1=1';

		if (count($this->_excludeCat) > 0)
		{
			foreach ($this->_excludeCat as $value)
			{
				$req .= ' and '.$value['key'].' <> \''.$value['value'].'\'';
			}
		}

		$res = executeReq($this->_db, $req);

		$iconListe = $this->getIcons();

		while (list($nomencl_niveau2) = $res->fetchRow())
		{
			if (isset($iconListe[$nomencl_niveau2]) == true)
		    {
		        $icon = $iconListe[$nomencl_niveau2]['icon'];
		        $titre = $iconListe[$nomencl_niveau2]['titre'];
		        //continue;
		    }
		    else
		    {
		        $icon = 'mapshtml/puces/vierge-gris.png';
		        $titre = 'N/A';
		        //continue;
		    }

		    $retour[ $nomencl_niveau2 ] = array(
		        'nomencl_niveau2' => $nomencl_niveau2,
		        'icon' => $icon,
		        'titre' => $titre,
		    );
		}
		
		return $this->retour($aParams, $retour);
	}

	function getRecherche($aParams = array())
	{
		if (isset($aParams['word']) == true
			&& strlen($aParams['word']) > 0
			&& isset($aParams['type']) == true)
		{
			if ($aParams['type'] == 'adresse')
			{
				return $this->getRechercheAdresse($aParams);
			}
			elseif ($aParams['type'] == 'equipement')
			{
				return $this->getRechercheEquipement($aParams);
			}
			else
			{
				return $this->retour(
					$aParams,
					array(
						'count' => 0,
						'data' => array(),
					)
				);
			}
		}
		else
		{
			return $this->retour(
				$aParams,
				array(
					'count' => 0,
					'data' => array(),
				)
			);
		}
	}
	
	function getRechercheAdresse($aParams = array())
	{
		// recuperation des informations et definitions des valeur par defaut
		$retour = array();

		if (isset($aParams['no_coordonne']) == true
			&& $aParams['no_coordonne'] == true)
		{
			$coordonne = false;
		}
		else
		{
			$coordonne = true;
		}
		$coordonne = false;

		if (isset($aParams['word']) == true
			&& $aParams['word'] == true)
		{
			$words = str_replace("'", ' ', $aParams['word']);
			$words = explode(' ', $words);
		}
		else
		{
			$words = array();
		}

		if (isset($aParams['page']) == true
			&& $aParams['page'] == true)
		{
			$page = $aParams['page'];
		}
		else
		{
			$page = 1;
		}

		if (isset($aParams['limit']) == true
			&& $aParams['limit'] == true)
		{
			$limit = $aParams['limit'];
		}
		else
		{
			$limit = 10;
		}

		/*
		$listeChamp = array(
			'ID_ADR_LOCATION',
			'ADR_NUM_VOIRIE',
			'ADRESSE',
			//'ADRESSE2',
			'CDPSRU',
			'LCOMRU',
		);

		$listeChampRecherche = array(
			'ADR_NUM_VOIRIE',
			'ADRESSE',
			//'ADRESSE2',
			'CDPSRU',
			'LCOMRU',
		);
		*/
	
		$listeChamp = array(
			'ADR_NUM_VOIRIE',
			'LIB_CODE_TYPE_RUE',
			'ADR_NVOI_SUFFIXE',
			'PREFIX',
			'LBILIERS',
			'CDPSRU',
			'LCOMRU',
			'ID_NUM_VOIRIE_ADR',
			'COORD_X',
			'COORD_y',
		);

		$listeChampRecherche = array(
			'ADR_NUM_VOIRIE',
			'LIB_CODE_TYPE_RUE',
			'ADR_NVOI_SUFFIXE',
			'PREFIX',
			'LBILIERS',
			'CDPSRU',
			'LCOMRU',
		);

		$req = 'select '.implode(', ', $listeChamp);

		if ($coordonne == true)
		{
			$req .= ', t.x x,t.y y';
		}
			;
		// $req .= ' from sigaix.V_ADR_ADRESSE_PRINC'; //';
		$req .= ' from sigaix.ADR_V_NUM_VOIRIE'; //';

		if ($coordonne == true)
		{
			$req .= ', table(sdo_util.getvertices(geometry)) t';
		}


		$where = '';
		
		if (count($words) > 0)
		{
			$req .= ' where (';

			foreach ($words as $k => $word)
			{
				if (strlen($where) > 0)
				{
					$where .= ' AND ';
				}

				$where .= '(';
				$where2 = '';
			
				foreach ($listeChampRecherche as $key => $value)
				{
					if (strlen($where2) > 0)
					{
						$where2 .= ' OR ';
					}

					$where2 .= 'UPPER('.$value.') like \'%'.strtoupper( protegeChaineOracle( supprimeAccent( $word ) ) ).'%\'';
				}

				$where .= $where2;

				$where .= ')';
			}
		}

		$req .= $where;

		$req .= ') ';

		//$sWhere .= 'UPPER('.$aColumns[$i].') LIKE \'%'.strtoupper($_GET['sSearch']).'%\' OR ';

		$req .= ' group by '.implode(', ', $listeChamp);
		if ($coordonne == true)
		{
			$req .= ', x, y';
		}

		$req .= ' order by '.implode(', ', $listeChamp);

		if ($coordonne == true)
		{
			$req .= ', x, y';
		}

		$reqCompte = 'select count(*) as compte from ('.$req.')';
		$res = executeReq($this->_db, $reqCompte);

		
		$req .= ' limit ';

		$req .= (($page-1) * $limit) + 1;

		$req .= ', '.$limit;
		$req = getReqOracleLimitWidthMySqlLimit($req);
		$compte = 0;

		//if ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		if (list($compte) = $res->fetchRow())
		{
			$compte = $compte;
		}

		$res = executeReq($this->_db, $req);

		$iconListe = $this->getIcons();

		//while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		while (list($adr_num_voirie, $adr_nvoi_suffixe, $lib_code_type_rue, $prefix, $lbiliers, $cdpsru, $lcomru, $id_num_voirie_adr, $coord_x, $coord_y) = $res->fetchRow())
		{//print_jv($row);die();

			$adr1 = '';

			if (strlen($adr_num_voirie) > 0
				&& $adr_num_voirie != '0') {
				$adr1 .= $adr_num_voirie;
			}

			if (strlen($adr_nvoi_suffixe) > 0) {
				$adr1 .= ' '.$adr_nvoi_suffixe;
			}
			
			if (strlen($lib_code_type_rue) > 0) {
				$adr1 .= ' '.$lib_code_type_rue;
			}

			if (strlen($prefix) > 0) {
				$adr1 .= ' '.$prefix;
			}

			if (strlen($lbiliers) > 0) {

				if (substr($prefix, -1, 1) != "'")
				{
					$adr1 .= ' ';
				}
				$adr1 .= $lbiliers;
			}

			$adr2 = $cdpsru.' '.$lcomru;

			$tempo = array(
				'id_num_voirie_adr' => $id_num_voirie_adr,
				'adr_num_voirie' => $adr_num_voirie,
				'adr_nvoi_suffixe' => $adr_nvoi_suffixe,
				'lib_code_type_rue' => $lib_code_type_rue,
				'prefix' => $prefix,
				'lbiliers' => $lbiliers,
				'cdpsru' => $cdpsru,
				'lcomru' => $lcomru,
				'adr1' => $adr1,
				'adr2' => $adr2,
				'x' => $this->getPositionValue( $coord_x ),
		        'y' => $this->getPositionValue( $coord_y ),
				'icon' => 'mapshtml/puces/vierge-gris.png',
		        'puce' => 'mapshtml/puces/vierge-gris.png',
			);

			foreach ($tempo as $key => $value)
			{
				if (is_string($value) == true)
				{
					$tempo[$key] = utf8_encode($value);
				}
			}


			/*
			foreach ($listeChamp as $key => $value)
			{
				$tempo[strtolower($value)] = $row[strtolower($value)];
			}
			*/

			/*$tempo = array(
				'id_adr_location' => $row['id_adr_location'],
				'adr_num_voirie' => $row['adr_num_voirie'],
				'adresse' => $row['adresse'],
				'cdpsru' => $row['cdpsru'],
				'lcomru' => $row['lcomru'],
			);*/

			/*if ($coordonne == true)
			{
				$tempo['x'] = $row['x'];
				$tempo['y'] = $row['y'];
			}*/

			$retour[] = $tempo;
		}

		$retour = array(
			'count' => $compte,
			'data' => $retour,
		);

		return $this->retour($aParams, $retour);
	}
	
	function getRechercheEquipement($aParams = array())
	{
		// recuperation des informations et definitions des valeur par defaut
		$retour = array();

		if (isset($aParams['no_coordonne']) == true
			&& $aParams['no_coordonne'] == true)
		{
			$coordonne = false;
		}
		else
		{
			$coordonne = true;
		}
		//$coordonne = false;

		if (isset($aParams['word']) == true
			&& $aParams['word'] == true)
		{
			$words = explode(' ', $aParams['word']);
		}
		else
		{
			$words = array();
		}

		if (isset($aParams['page']) == true
			&& $aParams['page'] == true)
		{
			$page = $aParams['page'];
		}
		else
		{
			$page = 1;
		}

		if (isset($aParams['limit']) == true
			&& $aParams['limit'] == true)
		{
			$limit = $aParams['limit'];
		}
		else
		{
			$limit = 10;
		}

		/*
		$listeChamp = array(
			'ID_ADR_LOCATION',
			'ADR_NUM_VOIRIE',
			'ADRESSE',
			//'ADRESSE2',
			'CDPSRU',
			'LCOMRU',
		);

		$listeChampRecherche = array(
			'ADR_NUM_VOIRIE',
			'ADRESSE',
			//'ADRESSE2',
			'CDPSRU',
			'LCOMRU',
		);
		*/
	
		
		$listeChamp = array(
			'ID_EQUIPEMENT',
			'ID_ADR_LOCATION',
			'NOMENCL_NIVEAU2',
			'NOMENCL_NIVEAU3',
			'NOMENCL_NIVEAU4',
			'LIBELLE_AFFICHAGE',
			'NOM_EQUIPEMENT',
		);

		$listeChampRecherche = array(
			'LIBELLE_AFFICHAGE',
			'NOM_EQUIPEMENT',
		);

		$req = 'select '.implode(', ', $listeChamp);

		if ($coordonne == true)
		{
			$req .= ', t.x x,t.y y';
		}
			;
		// $req .= ' from sigaix.V_ADR_ADRESSE_PRINC'; //';
		$req .= ' from equipements.eqp_v_eqp_niv2_geom_p'; //';

		if ($coordonne == true)
		{
			$req .= ', table(sdo_util.getvertices(geometry)) t';
		}


		$req .= ' where 1=1 ';
		
		if (count($words) > 0)
		{
			$where = ' and (';
			$isFirst = true;


			foreach ($words as $k => $word)
			{
				if ($isFirst == true)
				{
					$isFirst = false;
				}
				else
				{
					$where .= ' AND ';
				}

				$where .= '(';
				$where2 = '';
			
				foreach ($listeChampRecherche as $key => $value)
				{
					if (strlen($where2) > 0)
					{
						$where2 .= ' OR ';
					}

					$where2 .= 'UPPER('.$value.') like \'%'.strtoupper( protegeChaineOracle( supprimeAccent( $word ) ) ).'%\'';
				}

				$where .= $where2;

				$where .= ')';
			}
		}

		$req .= $where;

		if (count($this->_excludeCat) > 0)
		{
			foreach ($this->_excludeCat as $value)
			{
				$req .= ' and '.$value['key'].' <> \''.$value['value'].'\'';
			}
		}

		$req .= ') ';

		//$sWhere .= 'UPPER('.$aColumns[$i].') LIKE \'%'.strtoupper($_GET['sSearch']).'%\' OR ';

		$req .= ' group by '.implode(', ', $listeChamp);
		if ($coordonne == true)
		{
			$req .= ', x, y';
		}

		$req .= ' order by '.implode(', ', $listeChamp);

		if ($coordonne == true)
		{
			$req .= ', x, y';
		}

		$reqCompte = 'select count(*) as compte from ('.$req.')';
		$res = executeReq($this->_db, $reqCompte);

		
		$req .= ' limit ';

		$req .= (($page-1) * $limit) + 1;

		$req .= ', '.$limit;
		$req = getReqOracleLimitWidthMySqlLimit($req);
		$compte = 0;

		//if ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		if (list($compte) = $res->fetchRow())
		{
			$compte = $compte;
		}

		$res = executeReq($this->_db, $req);

		$iconListe = $this->getIcons();

		// while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC))
		


		while (list($id_equipement, $id_adr_location, $nomencl_niveau2, $nomencl_niveau3, $nomencl_niveau4, $libelle_affichage, $nom_equipement, $x, $y) = $res->fetchRow())
		{//print_jv($row);die();

			//$tempo = $row;
			//unset($tempo['limit#xxx']);
			
			$tempo = array(
				'id_equipement' => $id_equipement,
				'id_adr_location' => $id_adr_location,
				'nomencl_niveau2' => $nomencl_niveau2,
				'nomencl_niveau3' => $nomencl_niveau3,
				'nomencl_niveau4' => $nomencl_niveau4,
				'libelle_affichage' => $libelle_affichage,
				'nom_equipement' => $nom_equipement,
				'x' => $this->getPositionValue( $x ),
		        'y' => $this->getPositionValue( $y ),
			);

			$iconListe = $this->getIcons();

			if (isset($iconListe[$nomencl_niveau4]) == true)
		    {
		        $tempo['icon'] = $iconListe[$nomencl_niveau4]['icon'];
		        $tempo['puce'] = $iconListe[$nomencl_niveau4]['puce'];
		    }
		    elseif (isset($iconListe[$nomencl_niveau3]) == true)
		    {
		        $tempo['icon'] = $iconListe[$nomencl_niveau3]['icon'];
		        $tempo['puce'] = $iconListe[$nomencl_niveau3]['puce'];
		    }
			elseif (isset($iconListe[$nomencl_niveau2]) == true)
		    {
		        $tempo['icon'] = $iconListe[$nomencl_niveau2]['icon'];
		        $tempo['puce'] = $iconListe[$nomencl_niveau2]['puce'];
		    }
		    else
		    {
		        $tempo['icon'] = 'mapshtml/puces/vierge-gris.png';
		        $tempo['puce'] = 'mapshtml/puces/vierge-gris.png';
		    }

			/*
			$adr1 = '';

			if (strlen($row['adr_num_voirie']) > 0
				&& $row['adr_num_voirie'] != '0') {
				$adr1 .= $row['adr_num_voirie'];
			}

			if (strlen($row['adr_nvoi_suffixe']) > 0) {
				$adr1 .= ' '.$row['adr_nvoi_suffixe'];
			}
			
			if (strlen($row['lib_code_type_rue']) > 0) {
				$adr1 .= ' '.$row['lib_code_type_rue'];
			}

			if (strlen($row['prefix']) > 0) {
				$adr1 .= ' '.$row['prefix'];
			}

			if (strlen($row['lbiliers']) > 0) {

				if (substr($row['prefix'], -1, 1) != "'")
				{
					$adr1 .= ' ';
				}
				$adr1 .= $row['lbiliers'];
			}

			$adr2 = $row['cdpsru'].' '.$row['lcomru'];

			$tempo = array(
				'id_num_voirie_adr' => $row['id_num_voirie_adr'],
				'adr_num_voirie' => $row['adr_num_voirie'],
				'adr_nvoi_suffixe' => $row['adr_nvoi_suffixe'],
				'lib_code_type_rue' => $row['lib_code_type_rue'],
				'prefix' => $row['prefix'],
				'lbiliers' => $row['lbiliers'],
				'cdpsru' => $row['cdpsru'],
				'lcomru' => $row['lcomru'],
				'adr1' => $adr1,
				'adr2' => $adr2,
				'x' => $row['coord_x'],
				'y' => $row['coord_y'],
			);*/

			foreach ($tempo as $key => $value)
			{
				if (is_string($value) == true)
				{
					$tempo[$key] = utf8_encode($value);
				}

			}


			/*
			foreach ($listeChamp as $key => $value)
			{
				$tempo[strtolower($value)] = $row[strtolower($value)];
			}
			*/

			/*$tempo = array(
				'id_adr_location' => $row['id_adr_location'],
				'adr_num_voirie' => $row['adr_num_voirie'],
				'adresse' => $row['adresse'],
				'cdpsru' => $row['cdpsru'],
				'lcomru' => $row['lcomru'],
			);*/

			/*if ($coordonne == true)
			{
				$tempo['x'] = $row['x'];
				$tempo['y'] = $row['y'];
			}*/

			$retour[] = $tempo;
		}

		$retour = array(
			'count' => $compte,
			'data' => $retour,
		);

		return $this->retour($aParams, $retour);
	}

	function getIcons($aParams = array())
	{
		/*
		$iconListe = array(
			'0101000000' => array(
				'titre' => 'EQUIPEMENT ADMINISTRATIF',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101010100' => array(
				'titre' => '"PREFECTURE, SOUS-PREFECTURE"',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101010300' => array(
				'titre' => 'DDE',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101011300' => array(
				'titre' => 'DRAC',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101011800' => array(
				'titre' => 'HOTEL DES IMPOTS',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101011900' => array(
				'titre' => 'TRESORERIE',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101012600' => array(
				'titre' => 'RECTORAT',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101012700' => array(
				'titre' => 'INSPECTION ACADEMIQUE',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101020200' => array(
				'titre' => 'CHAMBRE DEPARTEMENTALE DE L\'AGRICULTURE',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101020400' => array(
				'titre' => 'CHAMBRE DEPARTEMENTALE DE COMMERCE ET D\'INDUSTRIE',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0101030100' => array(
				'titre' => 'COMMISSARIAT DE POLICE NATIONALE',
				'icon' => 'mapshtml/picto_grand/securite.png',
			),
			'0101030200' => array(
				'titre' => 'POLICE MUNICIPALE',
				'icon' => 'mapshtml/picto_grand/securite.png',
			),
			'0101030400' => array(
				'titre' => 'BRIGADE DE GENDARMERIE',
				'icon' => 'mapshtml/picto_grand/securite.png',
			),
			'0101040300' => array(
				'titre' => 'STRUCTURES INTERCOMMUNALES ET ASSOCIATIONS',
				'icon' => 'mapshtml/picto_grand/asso.png',
			),
			'0101040400' => array(
				'titre' => 'MAIRIE',
				'icon' => 'mapshtml/picto_grand/mairie.png',
			),
			'0101050300' => array(
				'titre' => 'CASERNE/CENTRE D\'INCENDIE ET DE SECOURS',
				'icon' => 'mapshtml/picto_grand/securite.png',
			),
			'0101060100' => array(
				'titre' => 'ASSEDIC',
				'icon' => 'mapshtml/picto_grand/poleemploi.png',
			),
			'0101060200' => array(
				'titre' => 'CAF',
				'icon' => 'mapshtml/picto_grand/caf.png',
			),
			'0101060300' => array(
				'titre' => 'CPAM',
				'icon' => 'mapshtml/picto_grand/cpam.png',
			),
			'0101060400' => array(
				'titre' => 'ANPE',
				'icon' => 'mapshtml/picto_grand/poleemploi.png',
			),
			'0101060600' => array(
				'titre' => 'MISSION LOCALE ET PAIO',
				'icon' => 'mapshtml/picto_grand/asso.png',
			),
			'0101080400' => array(
				'titre' => 'BUREAU DE POSTE',
				'icon' => 'mapshtml/picto_grand/laposte.png',
			),
			'0101100000' => array(
				'titre' => 'AIRES D\'ACCUEIL DES GENS DU VOYAGE',
				'icon' => 'mapshtml/picto_grand/caravane.png',
			),
			'0101110200' => array(
				'titre' => 'DECHETTERIE OU DECHETERIE',
				'icon' => 'mapshtml/picto_grand/decheterie.png',
			),
			'0102000000' => array(
				'titre' => 'JUSTICE',
				'icon' => 'mapshtml/picto_grand/justice.png',
			),
			'0102010300' => array(
				'titre' => 'JURIDICTION ADMINISTRATIVE SPECIALISEE',
				'icon' => 'mapshtml/picto_grand/justice.png',
			),
			'0102020100' => array(
				'titre' => 'TRIBUNAL DE GRANDE INSTANCE',
				'icon' => 'mapshtml/picto_grand/justice.png',
			),
			'0102020200' => array(
				'titre' => 'TRIBUNAL D\'INSTANCE',
				'icon' => 'mapshtml/picto_grand/justice.png',
			),
			'0102020400' => array(
				'titre' => 'COUR D\'APPEL',
				'icon' => 'mapshtml/picto_grand/justice.png',
			),
			'0102020500' => array(
				'titre' => 'JURIDICTION CIVILE SPECIALISEE',
				'icon' => 'mapshtml/picto_grand/justice.png',
			),
			'0102030100' => array(
				'titre' => 'MAISON DE JUSTICE ET DU DROIT',
				'icon' => 'mapshtml/picto_grand/autresservices.png',
			),
			'0102040100' => array(
				'titre' => 'MAISON D\'ARRET',
				'icon' => 'mapshtml/picto_grand/prison.png',
			),
			'0103000000' => array(
				'titre' => 'HOPITAL',
				'icon' => 'mapshtml/picto_grand/hopital.png',
			),
			'0103010100' => array(
				'titre' => 'HOPITAL',
				'icon' => 'mapshtml/picto_grand/hopital.png',
			),
			'0103010200' => array(
				'titre' => 'HOPITAL SPECIALISE',
				'icon' => 'mapshtml/picto_grand/hopital.png',
			),
			'0103010400' => array(
				'titre' => 'CLINIQUE',
				'icon' => 'mapshtml/picto_grand/hopital.png',
			),
			'0103010500' => array(
				'titre' => 'MATERNITE',
				'icon' => 'mapshtml/picto_grand/maternite.png',
			),
			'0103020000' => array(
				'titre' => 'EQUIPEMENT MEDICAL',
				'icon' => 'mapshtml/picto_grand/medicale.png',
			),
			'0103020100' => array(
				'titre' => 'DISPENSAIRE',
				'icon' => 'mapshtml/picto_grand/hopital.png',
			),
			'0103020400' => array(
				'titre' => 'ETABLISSEMENT THERMAL',
				'icon' => 'mapshtml/picto_grand/thermes.png',
			),
			'0104000000' => array(
				'titre' => 'EQUIPEMENT SOCIAL ET D\'ANIMATION',
				'icon' => 'mapshtml/picto_grand/loisirs.png',
			),
			'0104010100' => array(
				'titre' => 'CENTRE AERE ET CLSH',
				'icon' => 'mapshtml/picto_grand/enfance.png',
			),
			'0104010200' => array(
				'titre' => 'CRECHE',
				'icon' => 'mapshtml/picto_grand/enfance.png',
			),
			'0104020100' => array(
				'titre' => 'CENTRE SOCIAL',
				'icon' => 'mapshtml/picto_grand/loisirs.png',
			),
			'0104020400' => array(
				'titre' => 'MAISON DE LA JEUNESSE ET DE LA CULTURE',
				'icon' => 'mapshtml/picto_grand/loisirs.png',
			),
			'0104030000' => array(
				'titre' => 'EQUIPEMENT POUR HANDICAPES',
				'icon' => 'mapshtml/picto_grand/handicap.png',
			),
			'0104040000' => array(
				'titre' => 'EQUIPEMENT POUR PERSONNES AGEES',
				'icon' => 'mapshtml/picto_grand/seniors.png',
			),
			'0104040100' => array(
				'titre' => 'CENTRE D\'ACCUEIL DE JOUR',
				'icon' => 'mapshtml/picto_grand/seniors.png',
			),
			'0104040200' => array(
				'titre' => 'ETABLISSEMENT D\'HEBERGEMENT POUR PERSONNES AGEES',
				'icon' => 'mapshtml/picto_grand/seniors.png',
			),
			'0104050000' => array(
				'titre' => 'AUTRE ETABLISSEMENT D\'ACCUEIL SOCIAL',
				'icon' => 'mapshtml/picto_grand/sociale.png',
			),
			'0104050100' => array(
				'titre' => 'ETABLISSEMENT ET CENTRE D\'HEBERGEMENT POUR ADULTES ET FAMILLES EN DIFFICULTES',
				'icon' => 'mapshtml/picto_grand/sociale.png',
			),
			'0104050200' => array(
				'titre' => 'AUTRE ETABLISSEMENT SOCIAL D\'HEBERGEMENT  ET D\'ACCUEIL (SAUF AIRE DE STATION NOMADE 218)',
				'icon' => 'mapshtml/picto_grand/sociale.png',
			),
			'0104050300' => array(
				'titre' => 'AUTRES ETABLISSEMENT MEDICO-SOCIAL - CENTRE DE SOIN (ETABLISSEMENT ADDICTIF)',
				'icon' => 'mapshtml/picto_grand/sociale.png',
			),
			'0104050400' => array(
				'titre' => 'HEBERGEMENT POUR ETUDIANT -CITE U',
				'icon' => 'mapshtml/picto_grand/etudiant.png',
			),
			'0104050500' => array(
				'titre' => 'RESTAURANT POUR ETUDIANT - RESTO U',
				'icon' => 'mapshtml/picto_grand/etudiant.png',
			),
			'0105000000' => array(
				'titre' => 'EQUIPEMENT SPORTIF ET DE LOISIRS',
				'icon' => 'mapshtml/picto_grand/sport.png',
			),
			'0105010000' => array(
				'titre' => 'EQUIPEMENT DE SPORT',
				'icon' => 'mapshtml/picto_grand/sport.png',
			),
			'0105010100' => array(
				'titre' => 'BASSIN DE NATATION',
				'icon' => 'mapshtml/picto_grand/piscine.png',
			),
			'0105010300' => array(
				'titre' => 'COURT DE TENNIS',
				'icon' => 'mapshtml/picto_grand/tennis.png',
			),
			'0105010600' => array(
				'titre' => 'EQUIPEMENT EQUESTRE',
				'icon' => 'mapshtml/picto_grand/equitation.png',
			),
			'0105010800' => array(
				'titre' => 'PARCOURS DE GOLF',
				'icon' => 'mapshtml/picto_grand/golf.png',
			),
			'0105011000' => array(
				'titre' => 'PLATEAU EPS',
				'icon' => 'mapshtml/picto_grand/sport.png',
			),
			'0105011100' => array(
				'titre' => 'SALLE DE COMBAT',
				'icon' => 'mapshtml/picto_grand/combat.png',
			),
			'0105011200' => array(
				'titre' => 'SALLE MULTISPORTS',
				'icon' => 'mapshtml/picto_grand/gymnase.png',
			),
			'0105011300' => array(
				'titre' => 'SALLE OU TERRAIN SPECIALISE',
				'icon' => 'mapshtml/picto_grand/sport.png',
			),
			'0105011700' => array(
				'titre' => 'TERRAIN DE GRANDS JEUX = STADE',
				'icon' => 'mapshtml/picto_grand/stades.png',
			),
			'0105011800' => array(
				'titre' => 'DIVERS EQUIPEMENTS DE NATURE',
				'icon' => 'mapshtml/picto_grand/sport.png',
			),
			'0105020300' => array(
				'titre' => 'CASINO',
				'icon' => 'mapshtml/picto_grand/casino.png',
			),
			'0105030000' => array(
				'titre' => 'AUTRE EQUIPEMENT',
				'icon' => 'mapshtml/picto_grand/sport.png',
			),
			'0105030100' => array(
				'titre' => 'BOWLING',
				'icon' => 'mapshtml/picto_grand/bowling.png',
			),
			'0105030200' => array(
				'titre' => 'CIRCUIT / PISTE DE SPORTS MECANIQUES',
				'icon' => 'mapshtml/picto_grand/circuit.png',
			),
			'0106000000' => array(
				'titre' => 'EQUIPEMENT D\'ENSEIGNEMENT',
				'icon' => 'mapshtml/picto_grand/enseignement.png',
			),
			'0106010000' => array(
				'titre' => 'ENSEIGNEMENT PRIMAIRE',
				'icon' => 'mapshtml/picto_grand/ecole.png',
			),
			'0106010100' => array(
				'titre' => 'ECOLE MATERNELLE',
				'icon' => 'mapshtml/picto_grand/ecole.png',
			),
			'0106010400' => array(
				'titre' => 'ECOLE ELEMENTAIRE',
				'icon' => 'mapshtml/picto_grand/ecole.png',
			),
			'0106020100' => array(
				'titre' => 'COLLEGE',
				'icon' => 'mapshtml/picto_grand/lycee.png',
			),
			'0106020300' => array(
				'titre' => 'LYCEE',
				'icon' => 'mapshtml/picto_grand/lycee.png',
			),
			'0106030000' => array(
				'titre' => 'ENSEIGNEMENT SUPERIEUR',
				'icon' => 'mapshtml/picto_grand/fac.png',
			),
			'0106030100' => array(
				'titre' => 'UNIVERSITE',
				'icon' => 'mapshtml/picto_grand/fac.png',
			),
			'0106030200' => array(
				'titre' => 'IUT',
				'icon' => 'mapshtml/picto_grand/fac.png',
			),
			'0106030300' => array(
				'titre' => 'IUFM',
				'icon' => 'mapshtml/picto_grand/fac.png',
			),
			'0106030600' => array(
				'titre' => 'GRANDE ECOLE',
				'icon' => 'mapshtml/picto_grand/fac.png',
			),
			'0106030700' => array(
				'titre' => 'ECOLE SPECIALISEE',
				'icon' => 'mapshtml/picto_grand/fac.png',
			),
			'0106040000' => array(
				'titre' => 'FORMATION PROFESSIONNELLE ET CONTINUE',
				'icon' => 'mapshtml/picto_grand/enseignement.png',
			),
			'0106040200' => array(
				'titre' => 'CFA',
				'icon' => 'mapshtml/picto_grand/enseignement.png',
			),
			'0106040500' => array(
				'titre' => 'ETABLISSEMENT DE FORMATION SPECIALISE',
				'icon' => 'mapshtml/picto_grand/enseignement.png',
			),
			'0107000000' => array(
				'titre' => 'EQUIPEMENT CULTUEL',
				'icon' => 'mapshtml/picto_grand/culte.png',
			),
			'0107010000' => array(
				'titre' => 'LIEU DE CULTE',
				'icon' => 'mapshtml/picto_grand/culte.png',
			),
			'0107010100' => array(
				'titre' => 'LIEU DE CULTE CATHOLIQUE',
				'icon' => 'mapshtml/picto_grand/eglise.png',
			),
			'0107010300' => array(
				'titre' => 'LIEU DE CULTE ISRAELITE',
				'icon' => 'mapshtml/picto_grand/synagogue.png',
			),
			'0107010400' => array(
				'titre' => 'AUTRE LIEU DE CULTE',
				'icon' => 'mapshtml/picto_grand/culte.png',
			),
			'0107020000' => array(
				'titre' => 'SERVICE RELIGIEUX',
				'icon' => 'mapshtml/picto_grand/culte.png',
			),
			'0107020100' => array(
				'titre' => 'ETABLISSEMENT D\'ENSEIGNEMENT RELIGIEUX',
				'icon' => 'mapshtml/picto_grand/enseignement_culte.png',
			),
			'0107030100' => array(
				'titre' => 'CIMETIERE',
				'icon' => 'mapshtml/picto_grand/cimetiere.png',
			),
			'0108000000' => array(
				'titre' => 'CULTURE',
				'icon' => 'mapshtml/picto_grand/culturel.png',
			),
			'0108010000' => array(
				'titre' => 'CENTRE CULTUREL',
				'icon' => 'mapshtml/picto_grand/culturel.png',
			),
			'0108010200' => array(
				'titre' => 'CENTRE CULTUREL',
				'icon' => 'mapshtml/picto_grand/culturel.png',
			),
			'0108020500' => array(
				'titre' => 'BIBLIOTHEQUE',
				'icon' => 'mapshtml/picto_grand/bibliotheque.png',
			),
			'0108020700' => array(
				'titre' => 'DISCOTHEQUE',
				'icon' => 'mapshtml/picto_grand/bibliotheque.png',
			),
			'0108030200' => array(
				'titre' => 'MUSEE',
				'icon' => 'mapshtml/picto_grand/musees.png',
			),
			'0108030300' => array(
				'titre' => 'ARCHIVE',
				'icon' => 'mapshtml/picto_grand/musees.png',
			),
			'0108050300' => array(
				'titre' => 'SALLE DE THEATRE',
				'icon' => 'mapshtml/picto_grand/theatres.png',
			),
			'0108050400' => array(
				'titre' => 'SALLE DE CINEMA',
				'icon' => 'mapshtml/picto_grand/cinema.png',
			),
			'0108050600' => array(
				'titre' => 'SALLE DE DANSE',
				'icon' => 'mapshtml/picto_grand/danse.png',
			),
			'0108050900' => array(
				'titre' => 'AUDITORIUM',
				'icon' => 'mapshtml/picto_grand/auditorium.png',
			),
			'0108051100' => array(
				'titre' => '"PARC OU SALLE EXPO (INFRASTRUCTURES) : PARC EXPO, BAT EXPO, FOIRE, FOIRE EXPO"',
				'icon' => 'mapshtml/picto_grand/spectacle.png',
			),
			'0108051300' => array(
				'titre' => '"AUTRE SALLE (SALLE POLYVALENTE, SALLE MUNICIPALE….)"',
				'icon' => 'mapshtml/picto_grand/spectacle.png',
			),
			'0108070000' => array(
				'titre' => 'EQUIPEMENT DE FORMATION ARTISTIQUE',
				'icon' => 'mapshtml/picto_grand/art.png',
			),
			'0108070100' => array(
				'titre' => 'CONSERVATOIRE',
				'icon' => 'mapshtml/picto_grand/conservatoire.png',
			),
			'0108070200' => array(
				'titre' => 'ECOLE SPECIALISEE ARTISTIQUE',
				'icon' => 'mapshtml/picto_grand/art.png',
			),
			'0201000000' => array(
				'titre' => 'IMMEUBLE DE BUREAUX', // 'IMMEUBLE DE BUREAUX = BATIMENT DE BUREAUX',
				'icon' => 'mapshtml/picto_grand/bureau.png',
			),
			'0206000000' => array(
				'titre' => 'JARDIN PUBLIC',
				'icon' => 'mapshtml/picto_grand/parc.png',
			),
			'0206030100' => array(
				'titre' => 'JARDIN PUBLIC = ESPACE VERT PUBLIC',
				'icon' => 'mapshtml/picto_grand/parc.png',
			),
			'0207000000' => array(
				'titre' => 'COMMERCE',
				'icon' => 'mapshtml/picto_grand/commerce.png',
			),
			'0207020100' => array(
				'titre' => 'RESTAURANT',
				'icon' => 'mapshtml/picto_grand/resto.png',
			),
			'0207020300' => array(
				'titre' => 'HOTEL = BATIMENT HOTELIER',
				'icon' => 'mapshtml/picto_grand/hotels.png',
			),
			'0207020800' => array(
				'titre' => 'CANTINE',
				'icon' => 'mapshtml/picto_grand/resto.png',
			),
			'0207030000' => array(
				'titre' => 'BATIMENT COMMERCIAL = EQUIPEMENT DE DISTRIBUTION DE BIENS',
				'icon' => 'mapshtml/picto_grand/commerce.png',
			),
			'0207031200' => array(
				'titre' => 'BOUTIQUE',
				'icon' => 'mapshtml/picto_grand/commerce.png',
			),
			'0208000000' => array(
				'titre' => 'EQUIPEMENT DE PRODUCTION', // 'EQUIPEMENT DE PRODUCTION = BATIMENT INDUSTRIEL',
				'icon' => 'mapshtml/picto_grand/usine.png',
			),
			'0209000000' => array(
				'titre' => 'CENTRE VETERINAIRE',
				'icon' => 'mapshtml/picto_grand/veto.png',
			),
			'0209010000' => array(
				'titre' => 'CENTRE VETERINAIRE',
				'icon' => 'mapshtml/picto_grand/veto.png',
			),
			'0403000000' => array(
				'titre' => 'GARE', // 'GARE = GARE DE CHEMIN DE FER',
				'icon' => 'mapshtml/picto_grand/gare.png',
			),
			'0503000000' => array(
				'titre' => 'PARKING DE SURFACE',
				'icon' => 'mapshtml/picto_grand/parking.png',
			),
			'0503010000' => array(
				'titre' => 'PARKING DE SURFACE',
				'icon' => 'mapshtml/picto_grand/parking.png',
			),
			'0503040100' => array(
				'titre' => 'PARKING ENTERRE',
				'icon' => 'mapshtml/picto_grand/parking.png',
			),
			'0503040300' => array(
				'titre' => 'PARKING A NIVEAU',
				'icon' => 'mapshtml/picto_grand/parking.png',
			),
			'0503050000' => array(
				'titre' => 'PARKING D\'ECHANGE',
				'icon' => 'mapshtml/picto_grand/parking.png',
			),
			'0604000000' => array(
				'titre' => 'AERODROME',
				'icon' => 'mapshtml/picto_grand/aerodrome.png',
			),
		);*/
		
		$iconListe = array(
			'0101000000' => array(
				'titre' => 'ADMINISTRATIF', // 'EQUIPEMENT ADMINISTRATIF',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101010100' => array(
				'titre' => '"PREFECTURE, SOUS-PREFECTURE"',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101010300' => array(
				'titre' => 'DDE',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101011300' => array(
				'titre' => 'DRAC',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101011800' => array(
				'titre' => 'HOTEL DES IMPOTS',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101011900' => array(
				'titre' => 'TRESORERIE',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101012600' => array(
				'titre' => 'RECTORAT',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101012700' => array(
				'titre' => 'INSPECTION ACADEMIQUE',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101020200' => array(
				'titre' => 'CHAMBRE DEPARTEMENTALE DE L\'AGRICULTURE',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101020400' => array(
				'titre' => 'CHAMBRE DEPARTEMENTALE DE COMMERCE ET D\'INDUSTRIE',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101030100' => array(
				'titre' => 'COMMISSARIAT DE POLICE NATIONALE',
				'icon' => 'mapshtml/picto_petit/securite.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0101030200' => array(
				'titre' => 'POLICE MUNICIPALE',
				'icon' => 'mapshtml/picto_petit/securite.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0101030400' => array(
				'titre' => 'BRIGADE DE GENDARMERIE',
				'icon' => 'mapshtml/picto_petit/securite.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0101040300' => array(
				'titre' => 'STRUCTURES INTERCOMMUNALES ET ASSOCIATIONS',
				'icon' => 'mapshtml/picto_petit/asso.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101040400' => array(
				'titre' => 'MAIRIE',
				'icon' => 'mapshtml/picto_petit/mairie.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101050300' => array(
				'titre' => 'CASERNE/CENTRE D\'INCENDIE ET DE SECOURS',
				'icon' => 'mapshtml/picto_petit/securite.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0101060100' => array(
				'titre' => 'ASSEDIC',
				'icon' => 'mapshtml/picto_petit/poleemploi.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101060200' => array(
				'titre' => 'CAF',
				'icon' => 'mapshtml/picto_petit/caf.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101060300' => array(
				'titre' => 'CPAM',
				'icon' => 'mapshtml/picto_petit/cpam.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101060400' => array(
				'titre' => 'ANPE',
				'icon' => 'mapshtml/picto_petit/poleemploi.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101060600' => array(
				'titre' => 'MISSION LOCALE ET PAIO',
				'icon' => 'mapshtml/picto_petit/asso.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0101080400' => array(
				'titre' => 'BUREAU DE POSTE',
				'icon' => 'mapshtml/picto_petit/laposte.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0101100000' => array(
				'titre' => 'AIRES D\'ACCUEIL DES GENS DU VOYAGE',
				'icon' => 'mapshtml/picto_petit/caravane.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0101110200' => array(
				'titre' => 'DECHETTERIE OU DECHETERIE',
				'icon' => 'mapshtml/picto_petit/decheterie.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0102000000' => array(
				'titre' => 'JUSTICE',
				'icon' => 'mapshtml/picto_petit/justice.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0102010300' => array(
				'titre' => 'JURIDICTION ADMINISTRATIVE SPECIALISEE',
				'icon' => 'mapshtml/picto_petit/justice.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0102020100' => array(
				'titre' => 'TRIBUNAL DE GRANDE INSTANCE',
				'icon' => 'mapshtml/picto_petit/justice.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0102020200' => array(
				'titre' => 'TRIBUNAL D\'INSTANCE',
				'icon' => 'mapshtml/picto_petit/justice.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0102020400' => array(
				'titre' => 'COUR D\'APPEL',
				'icon' => 'mapshtml/picto_petit/justice.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0102020500' => array(
				'titre' => 'JURIDICTION CIVILE SPECIALISEE',
				'icon' => 'mapshtml/picto_petit/justice.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0102030100' => array(
				'titre' => 'MAISON DE JUSTICE ET DU DROIT',
				'icon' => 'mapshtml/picto_petit/autresservices.png',
				'puce' => 'mapshtml/puces/puce_rouge_small10.png',
			),
			'0102040100' => array(
				'titre' => 'MAISON D\'ARRET',
				'icon' => 'mapshtml/picto_petit/prison.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103000000' => array(
				'titre' => 'SANTE', // 'HOPITAL',
				'icon' => 'mapshtml/picto_petit/hopital.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103010100' => array(
				'titre' => 'SANTE', // 'HOPITAL',
				'icon' => 'mapshtml/picto_petit/hopital.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103010200' => array(
				'titre' => 'HOPITAL SPECIALISE',
				'icon' => 'mapshtml/picto_petit/hopital.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103010400' => array(
				'titre' => 'CLINIQUE',
				'icon' => 'mapshtml/picto_petit/hopital.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103010500' => array(
				'titre' => 'MATERNITE',
				'icon' => 'mapshtml/picto_petit/maternite.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103020000' => array(
				'titre' => 'EQUIPEMENT MEDICAL',
				'icon' => 'mapshtml/picto_petit/medicale.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103020100' => array(
				'titre' => 'DISPENSAIRE',
				'icon' => 'mapshtml/picto_petit/hopital.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0103020400' => array(
				'titre' => 'ETABLISSEMENT THERMAL',
				'icon' => 'mapshtml/picto_petit/thermes.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0104000000' => array(
				'titre' => 'SOCIAL ET D\'ANIMATION', // 'EQUIPEMENT SOCIAL ET D\'ANIMATION',
				'icon' => 'mapshtml/picto_petit/loisirs.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104010100' => array(
				'titre' => 'CENTRE AERE ET CLSH',
				'icon' => 'mapshtml/picto_petit/enfance.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104010200' => array(
				'titre' => 'CRECHE',
				'icon' => 'mapshtml/picto_petit/enfance.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104020100' => array(
				'titre' => 'CENTRE SOCIAL',
				'icon' => 'mapshtml/picto_petit/loisirs.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104020400' => array(
				'titre' => 'MAISON DE LA JEUNESSE ET DE LA CULTURE',
				'icon' => 'mapshtml/picto_petit/loisirs.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104030000' => array(
				'titre' => 'EQUIPEMENT POUR HANDICAPES',
				'icon' => 'mapshtml/picto_petit/handicap.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0104040000' => array(
				'titre' => 'EQUIPEMENT POUR PERSONNES AGEES',
				'icon' => 'mapshtml/picto_petit/seniors.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104040100' => array(
				'titre' => 'CENTRE D\'ACCUEIL DE JOUR',
				'icon' => 'mapshtml/picto_petit/seniors.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104040200' => array(
				'titre' => 'ETABLISSEMENT D\'HEBERGEMENT POUR PERSONNES AGEES',
				'icon' => 'mapshtml/picto_petit/seniors.png',
				'puce' => 'mapshtml/puces/puce_violette_small10.png',
			),
			'0104050000' => array(
				'titre' => 'AUTRE ETABLISSEMENT D\'ACCUEIL SOCIAL',
				'icon' => 'mapshtml/picto_petit/sociale.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0104050100' => array(
				'titre' => 'ETABLISSEMENT ET CENTRE D\'HEBERGEMENT POUR ADULTES ET FAMILLES EN DIFFICULTES',
				'icon' => 'mapshtml/picto_petit/sociale.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0104050200' => array(
				'titre' => 'AUTRE ETABLISSEMENT SOCIAL D\'HEBERGEMENT  ET D\'ACCUEIL (SAUF AIRE DE STATION NOMADE 218)',
				'icon' => 'mapshtml/picto_petit/sociale.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0104050300' => array(
				'titre' => 'AUTRES ETABLISSEMENT MEDICO-SOCIAL - CENTRE DE SOIN (ETABLISSEMENT ADDICTIF)',
				'icon' => 'mapshtml/picto_petit/sociale.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0104050400' => array(
				'titre' => 'HEBERGEMENT POUR ETUDIANT -CITE U',
				'icon' => 'mapshtml/picto_petit/etudiant.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0104050500' => array(
				'titre' => 'RESTAURANT POUR ETUDIANT - RESTO U',
				'icon' => 'mapshtml/picto_petit/etudiant.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0105000000' => array(
				'titre' => 'SPORTIF ET DE LOISIRS', // 'EQUIPEMENT SPORTIF ET DE LOISIRS',
				'icon' => 'mapshtml/picto_petit/sport.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105010000' => array(
				'titre' => 'EQUIPEMENT DE SPORT',
				'icon' => 'mapshtml/picto_petit/sport.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105010100' => array(
				'titre' => 'BASSIN DE NATATION',
				'icon' => 'mapshtml/picto_petit/piscine.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105010300' => array(
				'titre' => 'COURT DE TENNIS',
				'icon' => 'mapshtml/picto_petit/tennis.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105010600' => array(
				'titre' => 'EQUIPEMENT EQUESTRE',
				'icon' => 'mapshtml/picto_petit/equitation.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105010800' => array(
				'titre' => 'PARCOURS DE GOLF',
				'icon' => 'mapshtml/picto_petit/golf.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105011000' => array(
				'titre' => 'PLATEAU EPS',
				'icon' => 'mapshtml/picto_petit/sport.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105011100' => array(
				'titre' => 'SALLE DE COMBAT',
				'icon' => 'mapshtml/picto_petit/combat.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105011200' => array(
				'titre' => 'SALLE MULTISPORTS',
				'icon' => 'mapshtml/picto_petit/gymnase.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105011300' => array(
				'titre' => 'SALLE OU TERRAIN SPECIALISE',
				'icon' => 'mapshtml/picto_petit/sport.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105011700' => array(
				'titre' => 'TERRAIN DE GRANDS JEUX = STADE',
				'icon' => 'mapshtml/picto_petit/stades.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105011800' => array(
				'titre' => 'DIVERS EQUIPEMENTS DE NATURE',
				'icon' => 'mapshtml/picto_petit/sport.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105020300' => array(
				'titre' => 'CASINO',
				'icon' => 'mapshtml/picto_petit/casino.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105030000' => array(
				'titre' => 'AUTRE EQUIPEMENT',
				'icon' => 'mapshtml/picto_petit/sport.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105030100' => array(
				'titre' => 'BOWLING',
				'icon' => 'mapshtml/picto_petit/bowling.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0105030200' => array(
				'titre' => 'CIRCUIT / PISTE DE SPORTS MECANIQUES',
				'icon' => 'mapshtml/picto_petit/circuit.png',
				'puce' => 'mapshtml/puces/puce_verte_small10.png',
			),
			'0106000000' => array(
				'titre' => 'ENSEIGNEMENT', // 'EQUIPEMENT D\'ENSEIGNEMENT',
				'icon' => 'mapshtml/picto_petit/enseignement.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106010000' => array(
				'titre' => 'ENSEIGNEMENT PRIMAIRE',
				'icon' => 'mapshtml/picto_petit/ecole.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106010100' => array(
				'titre' => 'ECOLE MATERNELLE',
				'icon' => 'mapshtml/picto_petit/ecole.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106010400' => array(
				'titre' => 'ECOLE ELEMENTAIRE',
				'icon' => 'mapshtml/picto_petit/ecole.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106020100' => array(
				'titre' => 'COLLEGE',
				'icon' => 'mapshtml/picto_petit/lycee.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106020300' => array(
				'titre' => 'LYCEE',
				'icon' => 'mapshtml/picto_petit/lycee.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106030000' => array(
				'titre' => 'ENSEIGNEMENT SUPERIEUR',
				'icon' => 'mapshtml/picto_petit/fac.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106030100' => array(
				'titre' => 'UNIVERSITE',
				'icon' => 'mapshtml/picto_petit/fac.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106030200' => array(
				'titre' => 'IUT',
				'icon' => 'mapshtml/picto_petit/fac.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106030300' => array(
				'titre' => 'IUFM',
				'icon' => 'mapshtml/picto_petit/fac.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106030600' => array(
				'titre' => 'GRANDE ECOLE',
				'icon' => 'mapshtml/picto_petit/fac.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106030700' => array(
				'titre' => 'ECOLE SPECIALISEE',
				'icon' => 'mapshtml/picto_petit/fac.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106040000' => array(
				'titre' => 'FORMATION PROFESSIONNELLE ET CONTINUE',
				'icon' => 'mapshtml/picto_petit/enseignement.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106040200' => array(
				'titre' => 'CFA',
				'icon' => 'mapshtml/picto_petit/enseignement.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0106040500' => array(
				'titre' => 'ETABLISSEMENT DE FORMATION SPECIALISE',
				'icon' => 'mapshtml/picto_petit/enseignement.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0107000000' => array(
				'titre' => 'EQUIPEMENT CULTUEL',
				'icon' => 'mapshtml/picto_petit/culte.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0107010000' => array(
				'titre' => 'LIEU DE CULTE',
				'icon' => 'mapshtml/picto_petit/culte.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0107010100' => array(
				'titre' => 'LIEU DE CULTE CATHOLIQUE',
				'icon' => 'mapshtml/picto_petit/eglise.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0107010300' => array(
				'titre' => 'LIEU DE CULTE ISRAELITE',
				'icon' => 'mapshtml/picto_petit/synagogue.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0107010400' => array(
				'titre' => 'AUTRE LIEU DE CULTE',
				'icon' => 'mapshtml/picto_petit/culte.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0107020000' => array(
				'titre' => 'SERVICE RELIGIEUX',
				'icon' => 'mapshtml/picto_petit/culte.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0107020100' => array(
				'titre' => 'ETABLISSEMENT D\'ENSEIGNEMENT RELIGIEUX',
				'icon' => 'mapshtml/picto_petit/enseignement_culte.png',
				'puce' => 'mapshtml/puces/puce_bleue_small10.png',
			),
			'0107030100' => array(
				'titre' => 'CIMETIERE',
				'icon' => 'mapshtml/picto_petit/cimetiere.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0108000000' => array(
				'titre' => 'CULTURE',
				'icon' => 'mapshtml/picto_petit/culturel.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108010000' => array(
				'titre' => 'CENTRE CULTUREL',
				'icon' => 'mapshtml/picto_petit/culturel.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108010200' => array(
				'titre' => 'CENTRE CULTUREL',
				'icon' => 'mapshtml/picto_petit/culturel.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108020500' => array(
				'titre' => 'BIBLIOTHEQUE',
				'icon' => 'mapshtml/picto_petit/bibliotheque.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108020700' => array(
				'titre' => 'DISCOTHEQUE',
				'icon' => 'mapshtml/picto_petit/bibliotheque.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108030200' => array(
				'titre' => 'MUSEE',
				'icon' => 'mapshtml/picto_petit/musees.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108030300' => array(
				'titre' => 'ARCHIVE',
				'icon' => 'mapshtml/picto_petit/musees.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108050300' => array(
				'titre' => 'SALLE DE THEATRE',
				'icon' => 'mapshtml/picto_petit/theatres.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108050400' => array(
				'titre' => 'SALLE DE CINEMA',
				'icon' => 'mapshtml/picto_petit/cinema.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108050600' => array(
				'titre' => 'SALLE DE DANSE',
				'icon' => 'mapshtml/picto_petit/danse.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108050900' => array(
				'titre' => 'AUDITORIUM',
				'icon' => 'mapshtml/picto_petit/auditorium.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108051100' => array(
				'titre' => '"PARC OU SALLE EXPO (INFRASTRUCTURES) : PARC EXPO, BAT EXPO, FOIRE, FOIRE EXPO"',
				'icon' => 'mapshtml/picto_petit/spectacle.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108051300' => array(
				'titre' => '"AUTRE SALLE (SALLE POLYVALENTE, SALLE MUNICIPALEÃ¢â‚¬Â¦.)"',
				'icon' => 'mapshtml/picto_petit/spectacle.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108070000' => array(
				'titre' => 'EQUIPEMENT DE FORMATION ARTISTIQUE',
				'icon' => 'mapshtml/picto_petit/art.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108070100' => array(
				'titre' => 'CONSERVATOIRE',
				'icon' => 'mapshtml/picto_petit/conservatoire.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0108070200' => array(
				'titre' => 'ECOLE SPECIALISEE ARTISTIQUE',
				'icon' => 'mapshtml/picto_petit/art.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0201000000' => array(
				'titre' => 'IMMEUBLE DE BUREAUX',
				'icon' => 'mapshtml/picto_petit/bureau.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0206000000' => array(
				'titre' => 'PARC ET JARDIN', // 'JARDIN PUBLIC',
				'icon' => 'mapshtml/picto_petit/parc.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0206030100' => array(
				'titre' => 'JARDIN PUBLIC = ESPACE VERT PUBLIC',
				'icon' => 'mapshtml/picto_petit/parc.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0207000000' => array(
				'titre' => 'COMMERCE',
				'icon' => 'mapshtml/picto_petit/commerce.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0207020100' => array(
				'titre' => 'RESTAURANT',
				'icon' => 'mapshtml/picto_petit/resto.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0207020300' => array(
				'titre' => 'HOTEL = BATIMENT HOTELIER',
				'icon' => 'mapshtml/picto_petit/hotels.png',
				'puce' => 'mapshtml/puces/puce_orange_small10.png',
			),
			'0207020800' => array(
				'titre' => 'CANTINE',
				'icon' => 'mapshtml/picto_petit/resto.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0207030000' => array(
				'titre' => 'BATIMENT COMMERCIAL = EQUIPEMENT DE DISTRIBUTION DE BIENS',
				'icon' => 'mapshtml/picto_petit/commerce.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0207031200' => array(
				'titre' => 'BOUTIQUE',
				'icon' => 'mapshtml/picto_petit/commerce.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0208000000' => array(
				'titre' => 'EQUIPEMENT DE PRODUCTION',
				'icon' => 'mapshtml/picto_petit/usine.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0209000000' => array(
				'titre' => 'CENTRE VETERINAIRE',
				'icon' => 'mapshtml/picto_petit/veto.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0209010000' => array(
				'titre' => 'CENTRE VETERINAIRE',
				'icon' => 'mapshtml/picto_petit/veto.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0403000000' => array(
				'titre' => 'GARE',
				'icon' => 'mapshtml/picto_petit/gare.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0503000000' => array(
				'titre' => 'PARKING', // 'PARKING DE SURFACE',
				'icon' => 'mapshtml/picto_petit/parking.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0503010000' => array(
				'titre' => 'PARKING DE SURFACE',
				'icon' => 'mapshtml/picto_petit/parking.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0503040100' => array(
				'titre' => 'PARKING ENTERRE',
				'icon' => 'mapshtml/picto_petit/parking.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0503040300' => array(
				'titre' => 'PARKING A NIVEAU',
				'icon' => 'mapshtml/picto_petit/parking.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0503050000' => array(
				'titre' => 'PARKING D\'ECHANGE',
				'icon' => 'mapshtml/picto_petit/parking.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
			'0604000000' => array(
				'titre' => 'AERODROME',
				'icon' => 'mapshtml/picto_petit/aerodrome.png',
				'puce' => 'mapshtml/puces/puce_bleue_claire_small10.png',
			),
		);
		
		foreach ($iconListe as $key => $value)
		{
			$value['icon'] = str_replace('picto_grand', 'picto_petit', $value['icon']);
			$value['puce'] = $value['icon'];
			$iconListe[$key] = $value;
		}
		
		return $iconListe;
	}

	function getPointById($aParams = array())
	{
		$retour = array();

		$req = 'select id_equipement, id_adr_location, nomencl_niveau2, nomencl_niveau3, nomencl_niveau4, libelle_affichage, nom_equipement, t.x x,t.y y';
	    $req .= ' from equipements.eqp_v_eqp_niv2_geom_p';
	    $req .= ', table(sdo_util.getvertices(geometry)) t';

	    $req .= ' where 1=1 ';
	    
	    if (isset($aParams['liste_id']) == true
	    	&& is_array($aParams['liste_id']) == true
	    	&& count($aParams['liste_id']) > 0)
	    {
	    	$req .= ' and (';
	    	$isFirst = true;
	    	foreach ($aParams['liste_id'] as $key => $value)
	    	{
	    		if ($isFirst == true)
	    		{
	    			$isFirst = false;
	    		}
	    		else
	    		{
	    			$req .= ' or ';
	    		}

	    		$req .= ' (id_adr_location = '.$value.')';
	    		//$req .= '(id_equipement = '.$value.')';
		        
		        /*
		        if (isset($aParams['type']) == true
		            && strlen($aParams['type']) > 0
		            && isset($listeCalque[$info['type']]) == true)
		        {
		            $reqCondition .= ' and NOMENCL_NIVEAU2 = \''.$listeCalque[$info['type']]['id'].'\'';
		        }
		        */
		        
		        //$reqCondition .= ')';
	    	}
	    	$req .= ') ';
	    }

	    //$req = $req.$reqCondition;

	    if (count($this->_excludeCat) > 0)
		{
			foreach ($this->_excludeCat as $value)
			{
				$req .= ' and '.$value['key'].' <> \''.$value['value'].'\'';
			}
		}


	    
	    /*
	    if (strlen($idAdrLocation) > 0)
	    {
	        $req .= ' id_adr_location in ('.$idAdrLocation.')';
	    }
	    */
	    
	    $res = executeReq($this->_db, $req);

	    $iconListe = $this->getIcons();
	    
	    while (list($id_equipement, $id_adr_location, $nomencl_niveau2, $nomencl_niveau3, $nomencl_niveau4, $libelle_affichage, $nom_equipement, $x, $y) = $res->fetchRow())
	    {

	    	if (isset($iconListe[$nomencl_niveau4]) == true)
		    {
		        $icon = $iconListe[$nomencl_niveau4]['icon'];
		        $puce = $iconListe[$nomencl_niveau4]['puce'];
		    }
		    elseif (isset($iconListe[$nomencl_niveau3]) == true)
		    {
		        $icon = $iconListe[$nomencl_niveau3]['icon'];
		        $puce = $iconListe[$nomencl_niveau3]['puce'];
		    }
			elseif (isset($iconListe[$nomencl_niveau2]) == true)
		    {
		        $icon = $iconListe[$nomencl_niveau2]['icon'];
		        $puce = $iconListe[$nomencl_niveau2]['puce'];
		    }
		    else
		    {
		        $icon = 'mapshtml/puces/vierge-gris.png';
		        $puce = 'mapshtml/puces/vierge-gris.png';
		        //continue;
		    }
	        
	        $retour[$id_equipement] = array(
	            'id_equipement' => $id_equipement,
	            'id_adr_location' => $id_adr_location,
	            'nomencl_niveau2' => $nomencl_niveau2,
		        'nomencl_niveau3' => $nomencl_niveau3,
		        'nomencl_niveau4' => $nomencl_niveau4,
	            'libelle_affichage' => $libelle_affichage,
	            'nom_equipement' => $nom_equipement,
				'x' => $this->getPositionValue( $x ),
		        'y' => $this->getPositionValue( $y ),
		        'icon' => $icon,
		        'puce' => $puce,
	        );
	        
	        /*
	        $listeIdEquipementJson[] = array(
	            'x' => $x,
	            'y' => $y,
	            'libelle_affichage' => $libelle_affichage,
	            'nom_equipement' => $nom_equipement,
	        );
	        */
	    }

	    return $retour;
	}
}

?>