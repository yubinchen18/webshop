<?php
namespace App\Lib;

use PHPExcel_IOFactory;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Cell;
use PHPExcel_Cell_DataType;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

class GroupImporter
{
    private $data;
    private $school_id;
    private $excel;
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
        $this->data = $data;
        $this->school_id = $id;

        $this->Groups = TableRegistry::get('Groups');
        $this->Persons = TableRegistry::get('Persons');
        $this->Users = TableRegistry::get('Users');
        

        //loop throug projects
        foreach($this->data['projects'] as $project) {
            $this->groupsData = $this->Groups->find('list', [
                'keyField' => 'name',
                'valueField' => 'id',
            ])
            ->where(['project_id' => $project['id']])
            ->toArray();

            $excel = $this->checkFile($project['file']);
            if($excel !== false) {
                $this->processFile($excel, $project['id']);
            }
        }
    }

    private function processFile($excel, $project_id)
    {
        foreach ($excel->getWorksheetIterator() as $worksheet) {
            

            $highestRow = $worksheet->getHighestRow();
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $data = [];
            for ($row = 2; $row <= $highestRow; ++ $row) {
                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    $column = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
                    if(in_array($column, $this->columns)) {
                        $data[$column] = $value;
                    }
                }
                $data['barcode_id'] = 'cad7bfdf-3c5f-11e6-8684-3065ec8a4782';

                $password = $this->Users->generateRandom();

                $username =  Inflector::slug(substr($data['lastname'], 0, 5))
                        . Inflector::slug(substr($data['prefix'], 0, 3))
                        . Inflector::slug(substr($data['firstname'], 0, 5));

                $username = $this->Users->checkUsername($username);
                
                $data['user'] = [
                    'username' => $username,
                    'password' => $password,
                    'genuine' => $password,
                    'type' => 'student'
                ];

                $data = $this->processAddress($data);
                $data = $this->getGroupId($data, $project_id);
                $data['slug'] = Inflector::slug($data['firstname'] . $data['prefix'] . $data['lastname']);
                
                $entity = $this->Persons->newEntity($data,[
                    'associated' => ['Users', 'Groups', 'Addresses']
                ]);

                pr($entity);exit;
                $this->Persons->save($entity);
                                 

            }
        }
    }


    private function processAddress($data)
    {
        $address = $data['address'];
        $streets = explode(' ', $address);
        $streetsLength =max(array_keys($streets));

        if(is_numeric($streets[$streetsLength])) {
            $number = $streets[$streetsLength];
            unset($streets[$streetsLength]);
            $street = implode(' ', $streets);            
        }   

        $data['address'] = [
            'street' => (isset($street)) ? $street : '',
            'number' => (isset($number)) ? $number : '',
            'zipcode' => (isset($data['zipcode'])) ? $data['zipcode'] : '',
            'city' => (isset($data['city'])) ? $data['city'] : '',
            'firstname' => (isset($data['firstname'])) ? $data['firstname'] : '',
            'prefix' => (isset($data['prefix'])) ? $data['prefix'] : '',
            'lastname' => (isset($data['lastname'])) ? $data['lastname'] : '',
        ];

        return $data;
    }

    
    private function getGroupId($data, $project_id)
    {
        //existing group
        if(isset($data['group_name'], $this->groupsData[$data['group_name']])) {
            $data['group_id'] = $this->groupsData[$data['group_name']];
            unset($data['group_name']);
            return $data;
        }

        //new group
        $data['group']['name'] = $data['group_name'];
        $data['group']['slug'] = Inflector::slug($data['group_name']);
        $data['group']['project_id'] = $project_id;
        $data['group']['barcode_id'] = 'cad7bfdf-3c5f-11e6-8684-3065ec8a4782';
        return $data;
    }

    private function checkFile($file) {
        if(!empty($file['name']) && !empty($file['type']) && !empty($file['tmp_name'])) {
            $excel = PHPExcel_IOFactory::load($file['tmp_name']);
            return $excel;
        }
        return false;
    }
}
