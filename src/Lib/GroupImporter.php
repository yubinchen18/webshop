<?php
namespace App\Lib;

use PHPExcel_IOFactory;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Cell;
use PHPExcel_Cell_DataType;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

class GroupImporter
{
    private $data;
    private $school_id;
    private $groupsData;
    private $Groups;
    private $Persons;

    private $columns = [
        'group_name', //will become group_id
        'studentnumber',
        'firstname',
        'prefix',
        'lastname',
        'address',
        'zipcode',
        'city',
        'docent',
    ];
    
    public function __construct($data, $id)
    {
        if (empty($data['project'])) {
            return;
        }
        $this->data = $data;
        $this->school_id = $id;

        $this->Groups = TableRegistry::get('Groups');
        $this->Persons = TableRegistry::get('Persons');
        $this->Users = TableRegistry::get('Users');
        $this->Barcodes = TableRegistry::get('Barcodes');

        $project = $data['project'];
        //loop throug projects
        if (empty($project['id'])) {
            return false;
        }
        $this->groupsData = $this->Groups->find('list', [
            'keyField' => 'name',
            'valueField' => 'id',
        ])
        ->where(['project_id' => $project['id']])
        ->toArray();

        $excel = $this->checkFile($project['file']);
        
        if ($excel !== false) {
            $this->processFile($excel, $project['id']);
        }
    }

    private function processFile($excel, $project_id)
    {
        foreach ($excel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            
            for ($row = 2; $row <= $highestRow; ++ $row) {
                $data = [];
                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                    $value = trim($worksheet->getCellByColumnAndRow($col, $row)->getValue());
                    $column = trim($worksheet->getCellByColumnAndRow($col, 1)->getValue());
                    if (in_array($column, $this->columns)) {
                        $data[$column] = $value;
                    }
                }
                $data['barcode'] = [
                    'barcode' => $this->Barcodes->generateBarcode(''),
                    'type' => 'person'
                ];

                $type = 'student';
                if (!empty($data['docent'])) {
                    $type = 'docent';
                }
                $data['type'] = $type;
                
                $password = $this->Users->generateRandom();

                $username =  Text::slug(substr($data['lastname'], 0, 5))
                        . Text::slug(substr($data['prefix'], 0, 3))
                        . Text::slug(substr($data['firstname'], 0, 5));

                $username = $this->Users->checkUsername($username);
                
                $data['user'] = [
                    'username' => $username,
                    'password' => $password,
                    'genuine' => $password,
                    'type' => 'student'
                ];

                list($address, $data) = $this->processAddress($data);
                unset($data['address']);
                if ($address !== false) {
                    $data['address'] = $address;
                }
                $data = $this->getGroupId($data, $project_id);
                $data['slug'] = Text::slug($data['firstname'] . $data['prefix'] . $data['lastname']);
                $entity = $this->Persons->newEntity($data, [
                    'associated' => ['Users', 'Groups.Barcodes', 'Barcodes', 'Addresses']
                ]);

                $this->Persons->save($entity);
            }
        }
    }

    private function processAddress($data)
    {
        $address = $data['address'];
        $streets = explode(' ', $address);
        $streetsLength =max(array_keys($streets));

        if (empty($address) || empty($data['zipcode']) || empty($data['city'])) {
            unset($data['address']);
            unset($data['zipcode']);
            unset($data['city']);
            return [false, $data];
        }

        if (is_numeric($streets[$streetsLength])) {
            $number = $streets[$streetsLength];
            unset($streets[$streetsLength]);
            $street = implode(' ', $streets);
        }

        $address = [
            'street' => (isset($street)) ? $street : '',
            'number' => (isset($number)) ? $number : '',
            'zipcode' => (isset($data['zipcode'])) ? $data['zipcode'] : '',
            'city' => (isset($data['city'])) ? $data['city'] : '',
            'firstname' => (isset($data['firstname'])) ? $data['firstname'] : '',
            'prefix' => (isset($data['prefix'])) ? $data['prefix'] : '',
            'lastname' => (isset($data['lastname'])) ? $data['lastname'] : '',
        ];

        return [$address, $data];
    }
    
    private function getGroupId($data, $project_id)
    {
        //existing group
        if (isset($this->groupsData[$data['group_name']])) {
            $data['group_id'] = $this->groupsData[$data['group_name']];
            unset($data['group_name']);
            return $data;
        }
        //new group
        $data['group']['name'] = $data['group_name'];
        $data['group']['slug'] = Text::slug($data['group_name']);
        $data['group']['project_id'] = $project_id;
        $data['group']['barcode'] = [
            'barcode' => $this->Barcodes->generateBarcode(),
            'type' => 'group'
        ];
        
        //check if group exists
        $existingGroup = $this->Groups->find()
            ->where([
                'name' => $data['group_name'],
                'slug' =>  Text::slug($data['group_name']),
                'project_id' => $project_id,
            ])
            ->first();
        if ($existingGroup) {
            $data['group_id'] = $existingGroup->id;
            unset($data['group']);
        }
        unset($data['group_name']);
        return $data;
    }

    private function checkFile($file)
    {
        if (!empty($file['name']) && !empty($file['type']) && !empty($file['tmp_name'])) {
            $fileExtension = strtoupper(explode('.',$file['name'])[1]);
            $obj = PHPExcel_IOFactory::createReader($fileExtension);
            if ($fileExtension ==='CSV') {
                $obj->setDelimiter(";");
            }
            $excel = $obj->load($file['tmp_name']);
            return $excel;
        }
        return false;
    }
}
