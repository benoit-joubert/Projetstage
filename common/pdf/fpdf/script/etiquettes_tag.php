<?php
//define('FPDF_FONTPATH','../utilitaire/ClassesPHP/pdf/font/');

/****************************************************************************
* Software: Tag Extraction Class                                            *
*               extracts the tags and corresponding text from a string      *
* Version:  1.0                                                             *
* Date:     2005/12/08                                                      *
* Author:   Bintintan Andrei  -- klodoma@ar-sd.net                          *
*                                                                           *
* License:  Free for non-commercial use                                     *
*                                                                           *
* You may use and modify this software as you wish.                         *
* PLEASE REPORT ANY BUGS TO THE AUTHOR. THANK YOU   	                    *
****************************************************************************/

////////////////////////////////////////////////////
// PDF_Label 
//
// Classe afin d'éditer au format PDF des étiquettes
// au format Avery ou personnalisé
//
//
// Copyright (C) 2003 Laurent PASSEBECQ (LPA)
// Basé sur les fonctions de Steve Dillon : steved@mad.scientist.com
//
//-------------------------------------------------------------------
// VERSIONS :
// 1.0  : Initial release
// 1.1  : +	: Added unit in the constructor
//        + : Now Positions start @ (1,1).. then the first image @top-left of a page is (1,1)
//        + : Added in the description of a label : 
//				font-size	: defaut char size (can be changed by calling Set_Char_Size(xx);
//				paper-size	: Size of the paper for this sheet (thanx to Al Canton)
//				metric		: type of unit used in this description
//							  You can define your label properties in inches by setting metric to 'in'
//							  and printing in millimiter by setting unit to 'mm' in constructor.
//			  Added some labels :
//				5160, 5161, 5162, 5163,5164 : thanx to Al Canton : acanton@adams-blake.com
//				8600 						: thanx to Kunal Walia : kunal@u.washington.edu
//        + : Added 3mm to the position of labels to avoid errors 
// 1.2  : + : Added Set_Font_Name method
//        = : Bug of positionning
//        = : Set_Font_Size modified -> Now, just modify the size of the font
//        = : Set_Char_Size renamed to Set_Font_Size
////////////////////////////////////////////////////

/**
 * PDF_Label - PDF label editing
 * @package PDF_Label
 * @author Laurent PASSEBECQ <lpasseb@numericable.fr>
 * @copyright 2003 Laurent PASSEBECQ
**/
class PDF_Label_Tag extends FPDF {

	// Propriétés privées
	var $_Avery_Name	= '';				// Nom du format de l'étiquette
	var $_Margin_Left	= 0;				// Marge de gauche de l'étiquette
	var $_Margin_Top	= 0;				// marge en haut de la page avant la première étiquette
	var $_X_Space 		= 0;				// Espace horizontal entre 2 bandes d'étiquettes
	var $_Y_Space 		= 0;				// Espace vertical entre 2 bandes d'étiquettes
	var $_X_Number 		= 0;				// Nombre d'étiquettes sur la largeur de la page
	var $_Y_Number 		= 0;				// Nombre d'étiquettes sur la hauteur de la page
	var $_Width 		= 0;				// Largeur de chaque étiquette
	var $_Height 		= 0;				// Hauteur de chaque étiquette
	var $_Char_Size		= 10;				// Hauteur des caractères
	var $_Line_Height	= 10;				// Hauteur par défaut d'une ligne
	var $_Metric 		= 'mm';				// Type of metric for labels.. Will help to calculate good values
	var $_Metric_Doc 	= 'mm';				// Type of metric for the document
	var $_Font_Name		= 'Arial';			// Name of the font

	var $_COUNTX = 1;
	var $_COUNTY = 1;

	//Propriétés pour multicelltag
	var $wt_Current_Tag;
	var $wt_FontInfo;//tags font info
	var $wt_DataInfo;//parsed string data info
	var $wt_DataExtraInfo;//data extra INFO


	// Listing of labels size
	var $_Avery_Labels = array (
		'5160'=>array('name'=>'5160',	'paper-size'=>'letter',	'metric'=>'mm',	'marginLeft'=>1.762,	'marginTop'=>10.7,		'NX'=>3,	'NY'=>10,	'SpaceX'=>3.175,	'SpaceY'=>0,	'width'=>66.675,	'height'=>25.4,		'font-size'=>8),
		'5161'=>array('name'=>'5161',	'paper-size'=>'letter',	'metric'=>'mm',	'marginLeft'=>0.967,	'marginTop'=>10.7,		'NX'=>2,	'NY'=>10,	'SpaceX'=>3.967,	'SpaceY'=>0,	'width'=>101.6,		'height'=>25.4,		'font-size'=>8),
		'5162'=>array('name'=>'5162',	'paper-size'=>'letter',	'metric'=>'mm',	'marginLeft'=>0.97,		'marginTop'=>20.224,	'NX'=>2,	'NY'=>7,	'SpaceX'=>4.762,	'SpaceY'=>0,	'width'=>100.807,	'height'=>35.72,	'font-size'=>8),
		'5163'=>array('name'=>'5163',	'paper-size'=>'letter',	'metric'=>'mm',	'marginLeft'=>1.762,	'marginTop'=>10.7, 		'NX'=>2,	'NY'=>5,	'SpaceX'=>3.175,	'SpaceY'=>0,	'width'=>101.6,		'height'=>50.8,		'font-size'=>8),
		'5164'=>array('name'=>'5164',	'paper-size'=>'letter',	'metric'=>'in',	'marginLeft'=>0.148,	'marginTop'=>0.5, 		'NX'=>2,	'NY'=>3,	'SpaceX'=>0.2031,	'SpaceY'=>0,	'width'=>4.0,		'height'=>3.33,		'font-size'=>12),
		'8600'=>array('name'=>'8600',	'paper-size'=>'letter',	'metric'=>'mm',	'marginLeft'=>7.1, 		'marginTop'=>19, 		'NX'=>3, 	'NY'=>10, 	'SpaceX'=>9.5, 		'SpaceY'=>3.1, 	'width'=>66.6, 		'height'=>25.4,		'font-size'=>8),
		'L7163'=>array('name'=>'L7163',	'paper-size'=>'A4',		'metric'=>'mm',	'marginLeft'=>5,		'marginTop'=>15, 		'NX'=>2,	'NY'=>7,	'SpaceX'=>25,		'SpaceY'=>0,	'width'=>99.1,		'height'=>38.1,		'font-size'=>9),
		'4608'=>array('name'=>'4608',	'paper-size'=>'A4',		'metric'=>'mm',	'marginLeft'=>5,		'marginTop'=>5, 		'NX'=>2,	'NY'=>8,	'SpaceX'=>5,		'SpaceY'=>0,	'width'=>104.5,		'height'=>36.5,		'font-size'=>9),
		'4610'=>array('name'=>'4610',	'paper-size'=>'A4',		'metric'=>'mm',	'marginLeft'=>2,		'marginTop'=>2, 		'NX'=>2,	'NY'=>8,	'SpaceX'=>4,		'SpaceY'=>0,	'width'=>101,		'height'=>36.5,		'font-size'=>11),
		'4726'=>array('name'=>'4726',   'paper-size'=>'A4',     'metric'=>'mm', 'marginLeft'=>7,        'marginTop'=>15,        'NX'=>3,    'NY'=>7,    'SpaceX'=>2.5,      'SpaceY'=>0,    'width'=>63.5,      'height'=>38,       'font-size'=>9)
	);

	// convert units (in to mm, mm to in)
	// $src and $dest must be 'in' or 'mm'
	function _Convert_Metric ($value, $src, $dest) {
		if ($src != $dest) {
			$tab['in'] = 39.37008;
			$tab['mm'] = 1000;
			return $value * $tab[$dest] / $tab[$src];
		} else {
			return $value;
		}
	}

	// Give the height for a char size given.
	function _Get_Height_Chars($pt) {
		// Tableau de concordance entre la hauteur des caractères et de l'espacement entre les lignes
		$_Table_Hauteur_Chars = array(6=>2, 7=>2.5, 8=>3, 9=>4, 10=>5, 11=>4.5, 12=>7, 13=>8, 14=>9, 15=>10);
		if (in_array($pt, array_keys($_Table_Hauteur_Chars))) {
			return $_Table_Hauteur_Chars[$pt];
		} else {
			return 100; // There is a prob..
		}
	}

	function _Set_Format($format) {
		$this->_Metric 		= $format['metric'];
		$this->_Avery_Name 	= $format['name'];
		$this->_Margin_Left	= $this->_Convert_Metric ($format['marginLeft'], $this->_Metric, $this->_Metric_Doc);
		$this->_Margin_Top	= $this->_Convert_Metric ($format['marginTop'], $this->_Metric, $this->_Metric_Doc);
		$this->_X_Space 	= $this->_Convert_Metric ($format['SpaceX'], $this->_Metric, $this->_Metric_Doc);
		$this->_Y_Space 	= $this->_Convert_Metric ($format['SpaceY'], $this->_Metric, $this->_Metric_Doc);
		$this->_X_Number 	= $format['NX'];
		$this->_Y_Number 	= $format['NY'];
		$this->_Width 		= $this->_Convert_Metric ($format['width'], $this->_Metric, $this->_Metric_Doc);
		$this->_Height	 	= $this->_Convert_Metric ($format['height'], $this->_Metric, $this->_Metric_Doc);
		$this->Set_Font_Size($format['font-size']);
	}

	function __construct($format, $unit='mm', $posX=1, $posY=1)
	{
	    $this->PDF_Label_Tag($format, $unit, $posX, $posY);
	}

	function PDF_Label_Tag ($format, $unit='mm', $posX=1, $posY=1) {
		if (is_array($format)) {
			// Si c'est un format personnel alors on maj les valeurs
			$Tformat = $format;
		} else {
			// Si c'est un format avery on stocke le nom de ce format selon la norme Avery. 
			// Permettra d'aller récupérer les valeurs dans le tableau _Avery_Labels
			$Tformat = $this->_Avery_Labels[$format];
		}

		parent::FPDF('P', $Tformat['metric'], $Tformat['paper-size']);
		$this->_Set_Format($Tformat);
		$this->Set_Font_Name('Arial');
		$this->SetMargins(0,0); 
		$this->SetAutoPageBreak(false); 

		$this->_Metric_Doc = $unit;
		// Permet de commencer l'impression à l'étiquette désirée dans le cas où la page a déjà servi
		if ($posX > 1) $posX--; else $posX=0;
		if ($posY > 1) $posY--; else $posY=0;
		if ($posX >=  $this->_X_Number) $posX =  $this->_X_Number-1;
		if ($posY >=  $this->_Y_Number) $posY =  $this->_Y_Number-1;
		$this->_COUNTX = $posX;
		$this->_COUNTY = $posY;
	}

	// Méthode qui permet de modifier la taille des caractères
	// Cela modifiera aussi l'espace entre chaque ligne
	function Set_Font_Size($pt) {
		if ($pt > 3) {
			$this->_Char_Size = $pt;
			$this->_Line_Height = $this->_Get_Height_Chars($pt);
			$this->SetFontSize($this->_Char_Size);
		}
	}

	// Method to change font name
	function Set_Font_Name($fontname) {
		if ($fontname != '') {
			$this->_Font_Name = $fontname;
			$this->SetFont($this->_Font_Name);
		}
	}

	// On imprime une étiqette
	function Add_PDF_Label($texte) {
		// We are in a new page, then we must add a page
		if (($this->_COUNTX ==0) and ($this->_COUNTY==0)) {
			$this->AddPage();
		}

		$_PosX = $this->_Margin_Left+($this->_COUNTX*($this->_Width+$this->_X_Space));
		$_PosY = $this->_Margin_Top+($this->_COUNTY*($this->_Height+$this->_Y_Space));
		$this->SetXY($_PosX+3, $_PosY+3);
		//ajout du multicell tag ; ajout du 29/05/2006
	$this->MultiCellTag($this->_Width, $this->_Line_Height, $texte);
		//$this->MultiCell($this->_Width, $this->_Line_Height, $texte);
		$this->_COUNTY++;

		if ($this->_COUNTY == $this->_Y_Number) {
			// Si on est en bas de page, on remonte le 'curseur' de position
			$this->_COUNTX++;
			$this->_COUNTY=0;
		}

		if ($this->_COUNTX == $this->_X_Number) {
			// Si on est en bout de page, alors on repart sur une nouvelle page
			$this->_COUNTX=0;
			$this->_COUNTY=0;
		}
	}

	/****************************************************************************/
	#							Fonctions de Multicelltag

	/****************************************************************************
	* Software: FPDF class extension                                            *
	*           Tag Based Multicell                                             *
	* Version:  1.0                                                             *
	* Date:     2005/12/08                                                      *
	* Author:   Bintintan Andrei  -- klodoma@ar-sd.net                          *
	*                                                                           *
	* License:  Free for non-commercial use                                     *
	*                                                                           *
	* You may use and modify this software as you wish.                         *
	* PLEASE REPORT ANY BUGS TO THE AUTHOR. THANK YOU   	                    *
	****************************************************************************/

	/****************************************************************************/

	function _wt_Reset_Datas(){
		$this->wt_Current_Tag = "";
		$this->wt_DataInfo = array();
		$this->wt_DataExtraInfo = array(
			"LAST_LINE_BR" => "",		//CURRENT LINE BREAK TYPE
			"CURRENT_LINE_BR" => "",	//LAST LINE BREAK TYPE
			"TAB_WIDTH" => 10			//The tab WIDTH IS IN mm
		);

		//if another measure unit is used ... calculate your OWN
		$this->wt_DataExtraInfo["TAB_WIDTH"] *= (72/25.4) / $this->k;
		/*
			$this->wt_FontInfo - do not reset, once read ... is OK!!!
		*/
	}//function _wt_Reset_Datas

	/**
        Sets current tag to specified style
        @param		$tag - tag name
        			$family - text font family
        			$style - text style
        			$size - text size
        			$color - text color
        @return 	nothing
	*/
    function SetStyle($tag,$family,$style,$size,$color)
	{

		if ($tag == "ttags") $this->Error (">> ttags << is reserved TAG Name.");
		if ($tag == "") $this->Error ("Empty TAG Name.");

		//use case insensitive tags
		$tag=trim(strtoupper($tag));
		$this->TagStyle[$tag]['family']=trim($family);
		$this->TagStyle[$tag]['style']=trim($style);
		$this->TagStyle[$tag]['size']=trim($size);
		$this->TagStyle[$tag]['color']=trim($color);
	}//function SetStyle


	/**
        Sets current tag style as the current settings
        	- if the tag name is not in the tag list then de "DEFAULT" tag is saved.
        	This includes a fist call of the function SaveCurrentStyle()
        @param		$tag - tag name
        @return 	nothing
	*/
	function ApplyStyle($tag){

		//use case insensitive tags
		$tag=trim(strtoupper($tag));

		if ($this->wt_Current_Tag == $tag) return;

		if (($tag == "") || (! isset($this->TagStyle[$tag]))) $tag = "DEFAULT";

		$this->wt_Current_Tag = $tag;

		$style = & $this->TagStyle[$tag];

		if (isset($style)){
            $this->SetFont($style['family'], $style['style'], $style['size']);
            //this is textcolor in FPDF format
            if (isset($style['textcolor_fpdf'])) {
            	$this->TextColor = $style['textcolor_fpdf'];
            	$this->ColorFlag=($this->FillColor!=$this->TextColor);
			}else
            {
	            if ($style['color'] <> ""){//if we have a specified color
	            	$temp = explode(",", $style['color']);
					$this->SetTextColor($temp[0], $temp[1], $temp[2]);
				}//fi
			}
			/**/
		}//isset
	}//function ApplyStyle

	/**
		Save the current settings as a tag default style under the DEFAUTLT tag name
        @param		none
        @return 	nothing
	*/
	function SaveCurrentStyle(){
		//*
		$this->TagStyle['DEFAULT']['family'] = $this->FontFamily;;
		$this->TagStyle['DEFAULT']['style'] = $this->FontStyle;
		$this->TagStyle['DEFAULT']['size'] = $this->FontSizePt;
		$this->TagStyle['DEFAULT']['textcolor_fpdf'] = $this->TextColor;
		$this->TagStyle['DEFAULT']['color'] = "";
		/**/
	}//function SaveCurrentStyle

	/**
		Divides $this->wt_DataInfo and returnes a line from this variable
        @param		$w - Width of the text
        @return     $aLine = array() -> contains informations to draw a line
	*/
	function MakeLine($w){

		$aDataInfo = & $this->wt_DataInfo;
		$aExtraInfo = & $this->wt_DataExtraInfo;

		//last line break >> current line break
		$aExtraInfo['LAST_LINE_BR'] = $aExtraInfo['CURRENT_LINE_BR'];
		$aExtraInfo['CURRENT_LINE_BR'] = "";

	    if($w==0)
	        $w=$this->w - $this->rMargin - $this->x;

		$wmax = ($w - 2*$this->cMargin) * 1000;//max width

		$aLine = array();//this will contain the result
		$return_result = false;//if break and return result
		$reset_spaces = false;

		$line_width = 0;//line string width
		$total_chars = 0;//total characters included in the result string
		$space_count = 0;//numer of spaces in the result string
		$fw = & $this->wt_FontInfo;//font info array

		$last_sepch = ""; //last separator character

		foreach ($aDataInfo as $key => $val){

			$s = $val['text'];

			$tag = &$val['tag'];

 			$s_lenght=strlen($s);

	    	#if($s_lenght>0 and $s[$s_lenght-1]=="\n") $s_lenght--;

            $i = 0;//from where is the string remain
            $j = 0;//untill where is the string good to copy -- leave this == 1->> copy at least one character!!!
            $str = "";
            $s_width = 0;	//string width
            $last_sep = -1; //last separator position
            $last_sepwidth = 0;
            $last_sepch_width = 0;
            $ante_last_sep = -1; //ante last separator position
            $spaces = 0;


            //parse the whole string
	        while ($i < $s_lenght){
	        	$c = $s[$i];

   	        	if($c == "\n"){//Explicit line break
   	        		$i++; //ignore/skip this caracter
	        		$aExtraInfo['CURRENT_LINE_BR'] = "BREAK";
	        		$return_result = true;
	        		$reset_spaces = true;
	        		break;
	        	}

				//space
   	        	if($c == " "){
					$space_count++;//increase the number of spaces
					$spaces ++;
	        	}

	        	//	Font Width / Size Array
	        	if (!isset($fw[$tag]) || ($tag == "")){
	        		//if this font was not used untill now,
	        		$this->ApplyStyle($tag);
	        		$fw[$tag]['w'] = $this->CurrentFont['cw'];//width
	        		$fw[$tag]['s'] = $this->FontSize;//size
	        	}

                $char_width = $fw[$tag]['w'][$c] * $fw[$tag]['s'];

	        	//separators
	        	if(is_int(strpos(" ,.:;",$c))){

	        		$ante_last_sep = $last_sep;
	        		$ante_last_sepch = $last_sepch;
	        		$ante_last_sepwidth = $last_sepwidth;
	        		$ante_last_sepch_width = $last_sepch_width;

	        		$last_sep = $i;//last separator position
	        		$last_sepch = $c;//last separator char
	        		$last_sepch_width = $char_width;//last separator char
	        		$last_sepwidth = $s_width;

	        	}

	        	if ($c == "\t"){
	        		$c = $s[$i] = "";
	        		$char_width = $aExtraInfo['TAB_WIDTH'] * 1000;
	        	}


	        	$line_width += $char_width;


				if($line_width > $wmax){//Automatic line break

					$aExtraInfo['CURRENT_LINE_BR'] = "AUTO";

					if ($total_chars == 0) {
						/* This MEANS that the $w (width) is lower than a char width...
							Put $i and $j to 1 ... otherwise infinite while*/
						$i = 1;
						$j = 1;
					}//fi

					if ($last_sep <> -1){
						//we have a separator in this tag!!!
						//untill now there one separator
						if (($last_sepch == $c) && ($last_sepch != " ")){
							/*	this is the last character and it is a separator, if it is a space the leave it...
                                Have to jump back to the las separator... even a space
							*/
							$last_sep = $ante_last_sep;
							$last_sepch = $ante_last_sepch;
							$last_sepwidth = $ante_last_sepwidth;
						}

						if ($last_sepch == " "){
							$j = $last_sep;//just ignore the last space (it is at end of line)
							$i = $last_sep + 1;
							if ( $spaces > 0 ) $spaces --;
							$s_width = $last_sepwidth;
						}else{
							$j = $last_sep + 1;
							$i = $last_sep + 1;
							#$s_width = $last_sepwidth + $fw[$tag]['w'][$last_sepch] * $fw[$tag]['s'];
							$s_width = $last_sepwidth + $last_sepch_width;
						}

					}elseif(count($aLine) > 0){
						//we have elements in the last tag!!!!
						if ($last_sepch == " "){//the last tag ends with a space, have to remove it

							$temp = & $aLine[ count($aLine)-1 ];

							if ($temp['text'][strlen($temp['text'])-1] == " "){

								$temp['text'] = substr($temp['text'], 0, strlen($temp['text']) - 1);
								$temp['width'] -= $fw[ $temp['tag'] ]['w'][" "] * $fw[ $temp['tag'] ]['s'];
								$temp['spaces'] --;

								//imediat return from this function
								break 2;
							}else{
								;//die("should not be!!!");
							}//fi
						}//fi
					}//fi else

	        		$return_result = true;
	        		break;
				}//fi - Auto line break

	        	//increase the string width ONLY when it is added!!!!
	        	$s_width += $char_width;

	        	$i++;
	        	$j = $i;
	        	$total_chars ++;
	        }//while

	        $str = substr($s, 0, $j);

	        $sTmpStr = & $aDataInfo[$key]['text'];
            $sTmpStr = substr($sTmpStr, $i, strlen($sTmpStr));

            if (($sTmpStr == "") || ($sTmpStr === FALSE))//empty
            	array_shift($aDataInfo);

	        if ($val['text'] == $str){
	        }

	        //we have a partial result
            array_push($aLine, array(
	        	'text' => $str,
	        	'tag' => $val['tag'],
	        	'href' => isset($val['href']) ? $val['href']:'',
	        	'width' => $s_width,
	        	'spaces' => $spaces
	        ));

	        if ($return_result) break;//break this for

		}//foreach

		// Check the first and last tag -> if first and last caracters are " " space remove them!!!"

		if ((count($aLine) > 0) && ($aExtraInfo['LAST_LINE_BR'] == "AUTO")){
			//first tag
			$temp = & $aLine[0];
			if ( (strlen($temp['text']) > 0) && ($temp['text'][0] == " ")){
				$temp['text'] = substr($temp['text'], 1, strlen($temp['text']));
				$temp['width'] -= $fw[ $temp['tag'] ]['w'][" "] * $fw[ $temp['tag'] ]['s'];
				$temp['spaces'] --;
			}

			//last tag
			$temp = & $aLine[count($aLine) - 1];
			if ( (strlen($temp['text'])>0) && ($temp['text'][strlen($temp['text'])-1] == " ")){
				$temp['text'] = substr($temp['text'], 0, strlen($temp['text']) - 1);
				$temp['width'] -= $fw[ $temp['tag'] ]['w'][" "] * $fw[ $temp['tag'] ]['s'];
				$temp['spaces'] --;
			}
		}

		if ($reset_spaces){//this is used in case of a "Explicit Line Break"
			//put all spaces to 0 so in case of "J" align there is no space extension
			for ($k=0; $k< count($aLine); $k++) $aLine[$k]['spaces'] = 0;
		}//fi


		return $aLine;
	}//function MakeLine

	/**
		Draws a MultiCell with TAG recognition parameters
        @param		$w - with of the cell
        			$h - height of the cell
        			$pStr - string to be printed
        			$border - border
        			$align	- align
        			$fill - fill

        			These paramaters are the same and have the same behavior as at Multicell function
        @return     nothing
	*/
	function MultiCellTag($w, $h, $pStr, $border=0, $align='L', $fill=0){

		//save the current style settings, this will be the default in case of no style is specified
		$this->SaveCurrentStyle();
		$this->_wt_Reset_Datas();


		$pStr = str_replace("\t", "<ttags>\t</ttags>", $pStr);
		$pStr = str_replace("\r", "", $pStr);

		//initialize the String_TAGS class
		$sWork = new String_TAGS(5);

		//get the string divisions by tags
		$this->wt_DataInfo = $sWork->get_tags($pStr);

		$b = $b1 = $b2 = $b3 = '';//borders

		//save the current X position, we will have to jump back!!!!
		$startX = $this -> GetX();

	    if($border)
	    {
	        if($border==1)
	        {
	            $border = 'LTRB';
	            $b1 = 'LRT';//without the bottom
	            $b2 = 'LR';//without the top and bottom
	            $b3 = 'LRB';//without the top
	        }
	        else
	        {
	            $b2='';
	            if(is_int(strpos($border,'L')))
	                $b2.='L';
	            if(is_int(strpos($border,'R')))
	                $b2.='R';
	            $b1=is_int(strpos($border,'T')) ? $b2 . 'T' : $b2;
	            $b3=is_int(strpos($border,'B')) ? $b2 . 'B' : $b2;
	        }

	        //used if there is only one line
	        $b = '';
	        $b .= is_int(strpos($border,'L')) ? 'L' : "";
	        $b .= is_int(strpos($border,'R')) ? 'R' : "";
	        $b .= is_int(strpos($border,'T')) ? 'T' : "";
	        $b .= is_int(strpos($border,'B')) ? 'B' : "";
	    }

	    $first_line = true;
	    $last_line = !(count($this->wt_DataInfo) > 0);

		while(! $last_line){
			if ($fill == 1){
				//fill in the cell at this point and write after the text without filling
				$this->Cell($w,$h,"",0,0,"",1);
				$this->SetX($startX);//restore the X position
			}

			//make a line
			$str_data = $this->MakeLine($w);

			//check for last line
			$last_line = !(count($this->wt_DataInfo) > 0);

			if ($last_line && ($align == "J")){//do not Justify the Last Line
				$align = "L";
			}

			//outputs a line
			$this->PrintLine($w, $h, $str_data, $align);


			//see what border we draw:
			if($first_line && $last_line){
				//we have only 1 line
				$real_brd = $b;
			}elseif($first_line){
				$real_brd = $b1;
			}elseif($last_line){
				$real_brd = $b3;
			}else{
				$real_brd = $b2;
			}

			if ($first_line) $first_line = false;

			//draw the border and jump to the next line
			$this->SetX($startX);//restore the X
			$this->Cell($w,$h,"",$real_brd,2);
		}//while(! $last_line){

		//APPLY THE DEFAULT STYLE
		$this->ApplyStyle("DEFAULT");

		$this->x=$this->lMargin;
	}//function MultiCellExt



	/**
		This method returns the number of lines that will a text ocupy on the specified width
        @param		$w - with of the cell
        			$pStr - string to be printed
        @return     $nb_lines - number of lines
	*/
	function NbLines($w, $pStr){

		//save the current style settings, this will be the default in case of no style is specified
		$this->SaveCurrentStyle();
		$this->_wt_Reset_Datas();

		$pStr = str_replace("\t", "<ttags>\t</ttags>", $pStr);
		$pStr = str_replace("\r", "", $pStr);

		//initialize the String_TAGS class
		$sWork = new String_TAGS(5);

		//get the string divisions by tags
		$this->wt_DataInfo = $sWork->get_tags($pStr);

	    $first_line = true;
	    $last_line = !(count($this->wt_DataInfo) > 0);
	    $nb_lines = 0;

		while(! $last_line){

			//make a line
			$str_data = $this->MakeLine($w);

			//check for last line
			$last_line = !(count($this->wt_DataInfo) > 0);

			if ($first_line) $first_line = false;

			$nb_lines ++;

		}//while(! $last_line){

		//APPLY THE DEFAULT STYLE
		$this->ApplyStyle("DEFAULT");

		return $nb_lines;

	}//function MultiCellExt


	/**
		Draws a line returned from MakeLine function
        @param		$w - with of the cell
        			$h - height of the cell
        			$aTxt - array from MakeLine
        			$align - text align
        @return     nothing
	*/
	function PrintLine($w, $h, $aTxt, $align='J'){

		if($w==0)
			$w=$this->w-$this->rMargin - $this->x;

		$wmax = $w; //Maximum width

		$total_width = 0;	//the total width of all strings
		$total_spaces = 0;	//the total number of spaces

		$nr = count($aTxt);//number of elements

		for ($i=0; $i<$nr; $i++){
            $total_width += ($aTxt[$i]['width']/1000);
            $total_spaces += $aTxt[$i]['spaces'];
		}

		//default
		$w_first = $this->cMargin;

		switch($align){
			case 'J':
				if ($total_spaces > 0)
					$extra_space = ($wmax - 2 * $this->cMargin - $total_width) / $total_spaces;
				else $extra_space = 0;
				break;
			case 'L':
				break;
			case 'C':
            	$w_first = ($wmax - $total_width) / 2;
				break;
			case 'R':
				$w_first = $wmax - $total_width - $this->cMargin;;
				break;
		}

		// Output the first Cell
		if ($w_first != 0){
			$this->Cell($w_first, $h, "", 0, 0, "L", 0);
		}

		$last_width = $wmax - $w_first;

		foreach ($aTxt as $key => $val){

			//apply current tag style
			$this->ApplyStyle($val['tag']);

			//If > 0 then we will move the current X Position
			$extra_X = 0;

			//string width
			$width = $this->GetStringWidth($val['text']);
			$width = $val['width'] / 1000;

			if ($width == 0) continue;// No width jump over!!!

			if($align=='J'){
				if ($val['spaces'] < 1) $temp_X = 0;
				else $temp_X = $extra_space;

				$this->ws = $temp_X;

				$this->_out(sprintf('%.3f Tw', $temp_X * $this->k));

				$extra_X = $extra_space * $val['spaces'];//increase the extra_X Space

			}else{
				$this->ws = 0;
				$this->_out('0 Tw');
			}//fi

			//Output the Text/Links
			$this->Cell($width, $h, $val['text'], 0, 0, "C", 0, $val['href']);

			$last_width -= $width;//last column width

			if ($extra_X != 0){
				$this -> SetX($this->GetX() + $extra_X);
				$last_width -= $extra_X;
			}//fi

		}

		// Output the Last Cell
		if ($last_width != 0){
			$this->Cell($last_width, $h, "", 0, 0, "", 0);
		}//fi
	}//function PrintLine

	/****************************************************************************/
	#						Fonctions de parametrages de style
	/****************************************************************************/

//*****************************************************************************
//
//	AppelStyle
//		Crée le : 29/05/2006
//		Par : FAUVET Aurélien
//		Dernière édition : 29/05/2006 12:09
//
//	in : 
//		$police-> nom de la police ("arial", "helvetica" ou "times")
//		$taille-> taille de la police
//	out : -
//	description : insere different style pour le multicell
//
//*****************************************************************************
	function AppelStyle($police="arial",$taille=11)
	{ //SetStyle($tag,$family,$style,$size,$color)
	// /!\ nom des balise doivent être inferieur à 6 caracteres
	
	$this->SetStyle("b",$police,"B",$taille,"0,0,0");
	$this->SetStyle("i",$police,"I",$taille,"0,0,0");
	$this->SetStyle("u",$police,"U",$taille,"0,0,0");

	$this->SetStyle("bi",$police,"BI",$taille,"0,0,0");
	$this->SetStyle("ui",$police,"IU",$taille,"0,0,0");
	$this->SetStyle("bu",$police,"BU",$taille,"0,0,0");
	$this->SetStyle("biu",$police,"BIU",$taille,"0,0,0");

	$this->SetStyle("h1",$police,"",($taille+4),"0,0,0");
	$this->SetStyle("h2",$police,"",($taille+2),"0,0,0");

	$this->SetStyle("red",$police,"",$taille,"255,0,0");
	$this->SetStyle("blue",$police,"",$taille,"0,0,255");
	$this->SetStyle("rblue",$police,"",$taille,"65,105,225"); //bleu royal
	$this->SetStyle("green",$police,"",$taille,"0,180,0");
	$this->SetStyle("lime",$police,"",$taille,"0,255,0");
	$this->SetStyle("yell",$police,"",$taille,"255,255,0"); //jaune attention tres flashi
	$this->SetStyle("dyel",$police,"",$taille,"245,230,0"); //jaune (plus sombre)
	$this->SetStyle("vio",$police,"",$taille,"140,0,200"); //violet
	$this->SetStyle("magen",$police,"",$taille,"255,0,255"); //magenta
	$this->SetStyle("turq",$police,"",$taille,"64,224,208"); //turquoise
	$this->SetStyle("orang",$police,"",$taille,"255,165,0");
	$this->SetStyle("gray",$police,"",$taille,"128,128,128");
	$this->SetStyle("white",$police,"",$taille,"255,255,255");
	$this->SetStyle("gold",$police,"",$taille,"255,215,0");
	$this->SetStyle("pink",$police,"",$taille,"255,150,200");
	$this->SetStyle("silv",$police,"",$taille,"200,200,200"); //argent
	$this->SetStyle("brown",$police,"",$taille,"130,80,50");
	$this->SetStyle("salm",$police,"",$taille,"255,180,160"); //saumon
	$this->SetStyle("lblue",$police,"",$taille,"165,200,255"); //bleu clair
	$this->SetStyle("lgree",$police,"",$taille,"144,238,144"); //vert clair
	$this->SetStyle("dred",$police,"",$taille,"180,0,0"); //rouge sombre -> bordeau
	$this->SetStyle("dblue",$police,"",$taille,"0,0,140"); //bleu sombre
	$this->SetStyle("dgree",$police,"",$taille,"0,100,0"); //vert sombre

	$this->SetStyle("arial","arial","",$taille,"0,0,0");
	$this->SetStyle("times","times","",$taille,"0,0,0");
	$this->SetStyle("helv","helvetica","",$taille,"0,0,0");

	$this->SetStyle("small",$police,"",($taille-3),"0,0,0");
	}
}
?>