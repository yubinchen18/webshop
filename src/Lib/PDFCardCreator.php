<?php

namespace App\Lib;

use Cake\Core\Configure;
use Cake\Utility\Security;
use FPDF;

class PDFCardCreator
{
    private $pdf;
    private $key;
    
    public function __construct($data)
    {
        $fontPath = APP . 'Lib/font';
        define('FPDF_FONTPATH', $fontPath);
        
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
        }
        
        // Return output
        return $this->pdf->Output();
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
                ($person->address->street != "" ?
                    iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->address->street).PHP_EOL : "").
                ($person->address->zipcode != "" ?
                    iconv("UTF-8", "ISO-8859-1//TRANSLIT", $person->address->zipcode) . " ": "").
                ($person->address->city != "" ?
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
}
