<?php

namespace App\Lib;

use Cake\Core\Configure;
use Cake\Utility\Security;
use FPDF;

class PDFCardCreator
{
    private $pdf;
    private $key;
    private $cacheFolder;
    public $path;
    
    public function __construct($data, array $options = null)
    {
        $fontPath = APP . 'Lib/font';
        if (!defined('FPDF_FONTPATH')) {
            define('FPDF_FONTPATH', $fontPath);
        }
        //Set and create cache path
        $this->cacheFolder = TMP . 'pdf-cache' . DS;
        $this->tmpPackingslipFolder = $this->cacheFolder . 'tmp-packingslips' . DS ;
        $this->createDir($this->cacheFolder);
        $this->createDir($this->tmpPackingslipFolder);
        //Set salt key
        $this->key = Configure::read('EncryptionSalt');
        //Open new PDF file
        $this->pdf = new FPDF("L", "mm", "A5");
        $this->pdf->AddFont("Code39", "", 'code39.php');
    
        
        //Add page for each person in object
        switch (get_class($data)) {
        //Data comes from project page
            case 'App\Model\Entity\Project':
                foreach ($data->groups as $group) {
                //Add card for all persons
                    foreach ($group->persons as $person) {
                        $this->addCard($person);
                    };
                //Add anonymous cards
                    $this->addAlgemeenDocentCard($group);
                    $this->addAnoniemStudentCard($group);
                }
                break;
            case 'App\Model\Entity\Group':
                foreach ($data->persons as $person) {
                    $this->addCard($person);
                };
                //Add anonymous cards
                $this->addAlgemeenDocentCard($data);
                $this->addAnoniemStudentCard($data);
                break;
            case 'App\Model\Entity\Person':
                $this->addCard($data);
                break;
            case 'App\Model\Entity\Order':
                $this->pdf = new FPDF();
                $this->pdf->AddFont("Code39", "", 'code39.php');
                $this->path = $this->tmpPackingslipFolder.str_pad($data->ident, 6, "0", STR_PAD_LEFT).'.pdf';
                $this->addPhotexPakbon($data, $this->path, $options['special']);
                return $this;
        }
        
        // Return output
        return $this->pdf->Output($options['mode'], $options['path']);
        die();
    }
    
    private function addCard($person)
    {
        $this->pdf->AddPage();
        $this->pdf->SetAutoPageBreak(true, 1);

        $this->pdf->SetFont("Code39", "", 8);
        $this->pdf->setXY(65, 27);
        $this->pdf->Cell(100, 0, "*" . $person->barcode->barcode . "*");

        $this->pdf->SetFont("Arial", "", 12);
        $this->pdf->setXY(20, 50);
        $this->pdf->MultiCell(
            90,
            5,
            iconv(
                "UTF-8",
                "ISO-8859-1//TRANSLIT",
                //Aanhef voor studenten
                    (($person->type == 'leerling')? "Aan de ouders/verzorgers van".PHP_EOL : "").
                        
                $person->firstname
            ) . ($person->prefix != "" ?
                    " ".iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->prefix) : "" ).
                    " " . iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->lastname).PHP_EOL.
                (!empty($person->address->street) ?
                    iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->address->street).PHP_EOL : "").
                (!empty($person->address->zipcode) ?
                    iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->address->zipcode) . " ": "").
                (!empty($person->address->city) ?
                    iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->address->city) : "").PHP_EOL.
                "KLAS ".iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->group->name) . " ".
                    iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->group->project->school->name).PHP_EOL
        );

        $this->pdf->setXY(66.5, 122.8);
        $this->pdf->MultiCell(
            90,
            5,
            $person->user->username . PHP_EOL .
                Security::decrypt($person->user->genuine, $this->key) . PHP_EOL
        );
    }
    
    private function addAnoniemStudentCard($group)
    {
        $this->pdf->AddPage();
        $this->pdf->SetAutoPageBreak(true, 1);

        $this->pdf->SetFont("Code39", "", 8);
        $this->pdf->setXY(65, 27);
        $this->pdf->Cell(100, 0, "*ano_" . $group->barcode->barcode . "*");


        $this->pdf->SetFont("Arial", "", 12);
        $this->pdf->setXY(20, 50);
        $this->pdf->MultiCell(
            90,
            5,
            "Anoniem" . PHP_EOL .
                "KLAS " . iconv("UTF-8", "ISO-8859-1//TRANSLIT", $group->name) . " " .
                iconv("UTF-8", "ISO-8859-1//TRANSLIT", $group->project->school->name) . PHP_EOL
        );

        $this->pdf->setXY(66.5, 122.8);
        $this->pdf->MultiCell(
            90,
            5,
            ""
        );
    }
    
    private function addAlgemeenDocentCard($group)
    {
        $this->pdf->AddPage();
        $this->pdf->SetAutoPageBreak(true, 1);

        $this->pdf->SetFont("Code39", "", 8);
        $this->pdf->setXY(65, 27);
        $this->pdf->Cell(100, 0, "*doc_" . $group->barcode->barcode . "*");


        $this->pdf->SetFont("Arial", "", 12);
        $this->pdf->setXY(20, 50);
        $this->pdf->MultiCell(
            90,
            5,
            "Docent algemeen".PHP_EOL.
                "KLAS " . iconv("UTF-8", "ISO-8859-1//TRANSLIT", $group->name)." ".
                    iconv("UTF-8", "ISO-8859-1//TRANSLIT", $group->project->school->name).PHP_EOL
        );

        $this->pdf->setXY(66.5, 122.8);
        $this->pdf->MultiCell(
            90,
            5,
            ""
        );
    }
    
    private function addPhotexPakbon($order, $path, $special = false)
    {
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->setXY(25, 50);
        
        //Header
        if(!empty($order->deliveryaddress)) {
            $this->pdf->MultiCell(	
                100,
                5, 
                $order->deliveryaddress->fullName . PHP_EOL .
                $order->deliveryaddress->fullAddress . PHP_EOL .
                "{$order->deliveryaddress->zipcode} {$order->deliveryaddress->city}" . PHP_EOL
            );
        }
        $this->pdf->Image(WWW_ROOT.DS."img".DS."layout".DS."logo_pakbon.jpg", 140, 10);
        $this->pdf->Line(10, 85, 190, 85);

        //Order summary
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->setXY(10, 100);
        $this->pdf->Cell(150, 0, "Pakbon", 0, 0, "L");
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->setXY(10, 105);
        $this->pdf->Cell(50, 0,	"Ordernummer: " . str_pad($order->ident, 6, "0", STR_PAD_LEFT));
        $this->pdf->SetFont("Code39", "", 8);
        $this->pdf->Cell(70, 0, "*" . str_pad($order->ident, 6, "0", STR_PAD_LEFT) . "*");
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->Cell(60, 0,	"Datum: " . $order->created->format('d-m-Y'), 0, 0, "R");
        $this->pdf->Line(10, 115, 190, 115);

        //Order bodylines
        $this->pdf->SetFont('Arial', 'B', 8);
        $this->pdf->setXY(10, 125);
        $this->pdf->Cell(20, 0,	"Code");
        $this->pdf->Cell(20, 0,	"Aantal");
        $this->pdf->Cell(120, 0, "Product");

        $row = 130;
        $this->pdf->SetFont( 'Arial', '', 8);
        if( $special == true) : 
                $this->pdf->setXY(10, $row);
                $this->pdf->Cell(20, 0,	'');
                $this->pdf->Cell(20, 0,	1);
                $this->pdf->Cell(120, 0, 'Gratis design foto');
                $row += 10;
        endif;
        
        foreach ($order->orderlines as $orderline) : 
            $optionVals = "";
            foreach($orderline->orderline_productoptions as $option) : 
                $optionVals .= " " . $option->productoption_choice->value;
            endforeach;
            $this->pdf->setXY(10, $row);
            $this->pdf->Cell(20, 0, !empty($orderline->product) ? $orderline->product->article : '');
            $this->pdf->Cell(20, 0, $orderline->quantity);
            $this->pdf->Cell(120, 0, !empty($orderline->product) ? $orderline->product->name . $optionVals : '');
            $row += 10;
        endforeach;
        
        $this->pdf->Line(10, 245, 190, 245);

        //Footer
        $this->pdf->SetFont('Arial', '', 8);
        $this->pdf->setXY(10, 255);
        $this->pdf->MultiCell(
            60,
            5, 
            "Hoogstraten fotografie B.V." . PHP_EOL .
            "Lange Haven 133-135" . PHP_EOL .
            "3111 CD Schiedam" . PHP_EOL .
            "www.hoogstratenfotografie.nl" . PHP_EOL
        );
        $this->pdf->setXY(85, 255);
        $this->pdf->MultiCell(	
            60,
            5, 
            "tel: 010 - 4271672" . PHP_EOL .
            "fax: 010 - 2731590" . PHP_EOL .
            "info@hoogstratenfotografie.nl" . PHP_EOL .
            "ING nummer: NL82INGB0000863978" . PHP_EOL
        );
        $this->pdf->setXY(155, 255);
        $this->pdf->MultiCell(	
            60,
            5, 
            "BTW-nr: NL8188818877" . PHP_EOL .
            "KvKnr: 244875300000" . PHP_EOL .
            "IBAN: NL87783666" . PHP_EOL
        );
        $pdf = $this->pdf->Output("F", $path);
    }
    
    private function createDir($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
            $tmpPath = $path;
            $i = 0;
            while (TMP !== $tmpPath) {
                chmod($tmpPath, 0777);
                $tmpPath = dirname($tmpPath) . DS;
                $i++;
                if ($i > 10) {
                    break;
                }
            }
        }
    }
}
