<?php

namespace App\Lib;

use Cake\Core\Configure;
use Cake\Utility\Security;
use FPDF;




class PDFCardCreator
{
    public function __construct()
    {
        echo (dirname(dirname(dirname(__FILE__)))).DS."vendors".DS."setasign".DS."fpdf".DS."fpdf.php";
    
    
        $pdf = new FPDF( "L", "mm", "A5" );
	$pdf->AddFont( "Code39", "", "code39.php");
	
	$aProcessedGroups = array();
	foreach( $aGroups as $gkey => $aGroup ) :
		if( in_array($aGroup['Group']['id'], $aProcessedGroups ) ) {
			continue;
		}
		$aProcessedGroups[] =  $aGroup['Group']['id'];
		
		if( $aGroup["Staff"]["id"] != "" ) : 
			$pdf->AddPage();
			$pdf->SetAutoPageBreak( true, 1 );
			
			$pdf->SetFont("Code39", "", 8);
			$pdf->setXY( 	65, 	27 );
			$pdf->Cell(		100, 	0, "*" . $aGroup["Staff"]["Barcode"]["barcode"] . "*" );
		
			
			$pdf->SetFont( "Arial", "", 12);
			$pdf->setXY( 	20, 	50 );
			$pdf->MultiCell(	
				90,
				5, 
				iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Staff"]["firstname"] ) . ( $aGroup["Staff"]["prefix"] != "" ? " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Staff"]["prefix"] ) : "" ) . " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Staff"]["lastname"] ) . PHP_EOL .
				( $aGroup["Staff"]["address"] != "" ? iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Staff"]["address"] ) . PHP_EOL : "" ) . 
				( $aGroup["Staff"]["zipcode"] != "" ? iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Staff"]["zipcode"] ) . " ": "" ) . ( $aGroup["Staff"]["city"] != "" ? iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Staff"]["city"] ) : "" ) . PHP_EOL . 
				"KLAS " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Staff"]["Group"]["name"] ) . " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Project"]["School"]["name"] ) . PHP_EOL
			);
		
			$pdf->setXY( 	66.5, 	122.8 );
			$pdf->MultiCell(	
				90,
				5, 
				$aGroup["Staff"]["User"]["username"] . PHP_EOL . 
				$aGroup["Staff"]["User"]["real_pass"] . PHP_EOL
			);
		endif;
		
		foreach( $aGroup["Student"] as $aStudent ) :
			
			$pdf->AddPage();
			$pdf->SetAutoPageBreak( true, 1 );
			
			$pdf->SetFont("Code39", "", 8);
			$pdf->setXY( 	65, 	27 );
			$pdf->Cell(		100, 	0, "*" . $aStudent["Barcode"]["barcode"] . "*" );
		
			
			$pdf->SetFont( "Arial", "", 12);
			$pdf->setXY( 	20, 	50 );
			$pdf->MultiCell(	
				90,
				5, 
				iconv( "UTF-8", "ISO-8859-1//TRANSLIT", 
				"Aan de ouders/verzorgers van" . PHP_EOL .
				$aStudent["firstname"] ) . ( $aStudent["prefix"] != "" ? " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aStudent["prefix"] ) : "" ) . " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aStudent["lastname"] ) . PHP_EOL .
				( $aStudent["address"] != "" ? iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aStudent["address"] ) . PHP_EOL : "" ) . 
				( $aStudent["zipcode"] != "" ? $aStudent["zipcode"] . " ": "" ) . ( $aStudent["city"] != "" ? iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aStudent["city"] ) : "" ) . PHP_EOL . 
				"KLAS " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aStudent["Group"]["name"] ) . " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Project"]["School"]["name"] ) . PHP_EOL
			);
		
//			$pdf->SetFont( "Times", "", 12);
			$pdf->setXY( 	66.5, 	122.8 );
			$pdf->MultiCell(	
				90,
				5, 
				$aStudent["User"]["username"] . PHP_EOL . 
				$aStudent["User"]["real_pass"] . PHP_EOL
			);
	
		endforeach;
	
		$pdf->AddPage();
		$pdf->SetAutoPageBreak( true, 1 );
		
		$pdf->SetFont("Code39", "", 8);
		$pdf->setXY( 	65, 	27 );
		$pdf->Cell(		100, 	0, "*ano_" . $aGroup["Barcode"]["barcode"] . "*" );
	
		
		$pdf->SetFont( "Arial", "", 12);
		$pdf->setXY( 	20, 	50 );
		$pdf->MultiCell(	
			90,
			5, 
			"Anoniem" . PHP_EOL . 
			"KLAS " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Group"]["name"] ) . " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Project"]["School"]["name"] ) . PHP_EOL
		);
	
		$pdf->setXY( 	66.5, 	122.8 );
		$pdf->MultiCell(	
			90,
			5, 
			""
		);
		
		
		
		
		
		$pdf->AddPage();
		$pdf->SetAutoPageBreak( true, 1 );
		
		$pdf->SetFont("Code39", "", 8);
		$pdf->setXY( 	65, 	27 );
		$pdf->Cell(		100, 	0, "*doc_" . $aGroup["Barcode"]["barcode"] . "*" );
	
		
		$pdf->SetFont( "Arial", "", 12);
		$pdf->setXY( 	20, 	50 );
		$pdf->MultiCell(	
			90,
			5, 
			"Docent algemeen" . PHP_EOL . 
			"KLAS " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Group"]["name"] ) . " " . iconv( "UTF-8", "ISO-8859-1//TRANSLIT", $aGroup["Project"]["School"]["name"] ) . PHP_EOL
		);
	
		$pdf->setXY( 	66.5, 	122.8 );
		$pdf->MultiCell(	
			90,
			5, 
			""
		);

	endforeach;

	$pdf->Output();
	die();
    }
}

