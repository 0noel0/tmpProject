<?php 

date_default_timezone_set('America/El_Salvador');
require 'Functions.php';

function getPrototypeInstance(){
    return new Prototype();
}

function asd(){
	getPrototypeInstance()->select("idfoodtruck AS id, nombre, descripcion, logo AS imagen", "foodtruck", "ORDER BY idfoodtruck DESC LIMIT 6");
}

function session($action, $key = null, $value = null){
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	switch($action){
		case "check":
			if(isset($_SESSION["isStarted"])) {
				return true;
			}
			else{
				return false;
			}
		break;
		case "start":
			$_SESSION["isStarted"] = true;
		break;
		case "destroy":
			session_destroy();
		break;
		case "set":
			$_SESSION[$key] = $value;
		break;
		case "get":
			return isset($_SESSION[$key]) ? $_SESSION[$key] : "null";
		break;
		case "getAll":
			return $_SESSION;
		break;
	}
}

function uploadExcel(){
	$currentDir = getcwd();
	$uploadDirectory = "\..\uploads\\";
	$hasError = false;
	$fileExtensions = ['xls','xlsx','xml']; 

	$fileName = $_FILES['file']['name'];
	$fileSize = $_FILES['file']['size'];
	$fileTmpName  = $_FILES['file']['tmp_name'];
	$fileType = $_FILES['file']['type'];
	$one = explode('.',$fileName);
	$two = end($one);
	$fileExtension = strtolower($two);

	$uploadPath = $currentDir . $uploadDirectory . basename($fileName); 

	if (isset($_POST['submit'])) {
	    if (! in_array($fileExtension,$fileExtensions)) {
	        $hasError = true;
	    }
	    if (!$hasError) {
	        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
	        if ($didUpload) {
	            return $uploadPath;
	        } else {
	            return "error";
	        }
	    } else {
	        return "error";
	    }
	}	    
}

function proccessExcel($archiveURL){
	try {
		set_time_limit(360);
		include 'PHPExcel/IOFactory.php';
		include 'ChunkReadFilter.php';

		$inputFileType = PHPExcel_IOFactory::identify($archiveURL);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);

		$chunkFilter = new ChunkReadFilter();
		$objReader->setReadFilter($chunkFilter);
	    $objReader->setReadDataOnly(false);
	    $chunkFilter->setRows(0, 1);

	    $chunkSize = 4250;	    

	    $spreadsheetInfo = $objReader->listWorksheetInfo($archiveURL);
	    $totalRows = $spreadsheetInfo[0]['totalRows'];

		for ($startRow = 3; $startRow <= $totalRows; $startRow += $chunkSize) {

			$chunkFilter->setRows($startRow, $chunkSize);
			$objPHPExcel = $objReader->load($archiveURL);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, false);

			$forCounter = (($startRow-1)+$chunkSize);
			$sheetCounter = count($sheetData);

			for($i = ($startRow-1); $i < ($forCounter > $sheetCounter ? $sheetCounter : $forCounter); $i++){

				//Formating contract_price
				$fcp = round($objPHPExcel->getActiveSheet()->getCell('H'.($i+1))->getValue(), 2);    
				$sheetData[$i][7] = $fcp;

				//Formatting price_expiration
				$UNIX_DATE = ($objPHPExcel->getActiveSheet()->getCell('L'.($i+1))->getValue() - 25569) * 86400;
				$sheetData[$i][11] = gmdate("Y-m-d", $UNIX_DATE);

				//Formating p_uom_sin_iva
				$fpusi = round($objPHPExcel->getActiveSheet()->getCell('N'.($i+1))->getOldCalculatedValue(), 2);    
				$sheetData[$i][13] = $fpusi;

				//Formating p_uom_con_iva
				$fpuci = round($objPHPExcel->getActiveSheet()->getCell('O'.($i+1))->getOldCalculatedValue(), 2);    
				$sheetData[$i][14] = $fpuci;

				//Formating p_individual_sin_iva
				$fpisi = round($objPHPExcel->getActiveSheet()->getCell('P'.($i+1))->getOldCalculatedValue(), 2);    
				$sheetData[$i][15] = $fpisi;

				//Formating p_individual_con_iva
				$fpici = round($objPHPExcel->getActiveSheet()->getCell('Q'.($i+1))->getOldCalculatedValue(), 2);    
				$sheetData[$i][16] = $fpici;

				//Getting Image from Hyperlink
				$imageURL = $objPHPExcel->getActiveSheet()->getCell('AC'.($i+1))->getHyperlink()->getUrl();
				$sheetData[$i][28] = $imageURL;	

				$params = array(
					'cust_id' => $sheetData[$i][0],
					'order_id' => $sheetData[$i][1],
					'catalog_number' => $sheetData[$i][2],
					'description' => $sheetData[$i][3],
					'stock' => ($sheetData[$i][4] == "STOCK" ? 1 : 0),
					'uom' => $sheetData[$i][5],
					'sell_qty' => $sheetData[$i][6],
					'contract_price' => $sheetData[$i][7],
					'cook_division' => $sheetData[$i][8],
					'contract_id' => $sheetData[$i][9],
					'contract_desc' => $sheetData[$i][10],
					'price_expiration' => $sheetData[$i][11],
					'currency' => $sheetData[$i][12],
					'p_uom_sin_iva' => $sheetData[$i][13],
					'p_uom_con_iva' => $sheetData[$i][14],
					'individual_sin_iva' => $sheetData[$i][15],
					'individual_con_iva' => $sheetData[$i][16],
					'precio_lista_vta_min_sin_iva' => $sheetData[$i][17],
					'precio_lista_vta_min_con_iva' => $sheetData[$i][18],
					'vta_minima' => $sheetData[$i][19],
					'mb' => $sheetData[$i][20],
					'fob' => $sheetData[$i][21],
					'iva' => $sheetData[$i][22],
					'gtin' => $sheetData[$i][27],
					'image' => $sheetData[$i][28],
					'family' => $sheetData[$i][29],
					'sub_family_1' => $sheetData[$i][30],
					'sub_family_2' => $sheetData[$i][31]
				);
				getPrototypeInstance()->insert("items", $params);
			}

		    $objPHPExcel->disconnectWorksheets();
		    unset($objPHPExcel, $sheetData);
		    $sheetData = null;
		}
		return true;
	} catch (Exception $e) {
	    return false;
	}
}

?>