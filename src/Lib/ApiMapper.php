<?php
namespace App\Lib;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

class ApiMapper
{
    public static function map($model, $entity)
    {
        $fnName = "map".ucfirst($model);
        return self::$fnName($entity);
    }
    
    public function mapSchool($entity) 
    {
        return ['School' => [
            'OnlineId' => $entity->id,
            'Name' => $entity->name,
            'Url' => $entity->slug,
            'Deleted' => empty($entity->deleted),
            'Modified' => $entity->modified->format('Y-m-d'),
            'Created' => $entity->created->format('Y-m-d')
        ]];
    }
    
    public function mapUser($entity)
    {
        
    }

    public function mapPerson($entity)
    {
        return [$entity->type => [
                "OnlineId" => $entity->id,
                "UserId" => $entity->user_id,
                "GroupId" => $entity->group_id,
                "BarcodeId" => $entity->barcode_id,
                "StudentNumber" => $entity->studentnumber,
                "FirstName" => $entity->firstname,
                "MiddleName" => $entity->prefix,
                "LastName" => $entity->lastname,
                "Url" => $entity->slug,
                "Address" => $entity->address->full_address,
                "City" => $entity->address->city,
                "Zipcode" => $entity->address->zipcode,
                "Deleted" => empty($entity->deleted),
                "Modified" => $entity->modified->format('Y-m-d'),
                "Created" => $entity->created->format('Y-m-d')    
            ]
        ];
    }
    
    public function mapGroup($entity)
    {
        return ['Group' => [
                'OnlineId' => $entity->id,
                'ProjectId' => $entity->project_id,
                'BarcodeId' => $entity->barcode_id,
                'Name' => $entity->name,
                'Url' => $entity->slug,
                'Deleted' => empty($entity->deleted),
                'Modified' => $entity->modified->format('Y-m-d'),
                'Created' => $entity->created->format('Y-m-d'),
            ]
        ];
    }
    
    public function mapProject($entity)
    {
        return ['Project' => [
           'OnlineId' => $entity->id,
           'SchoolId' => $entity->school_id,
           'Name' => $entity->name,
           'Url' => $entity->slug,
           'Deleted' => empty($entity->deleted),
           'Modified' => $entity->modified->format('Y-m-d'),
           'Created' => $entity->created->format('Y-m-d')
        ]];
    }
}