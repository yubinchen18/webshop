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
        $entity = $entity->school;
        return ['School' => [
            'OnlineId' => $entity->id,
            'Name' => $entity->name,
            'Url' => $entity->slug,
            'Deleted' => !empty($entity->deleted),
            'Modified' => $entity->modified->format('Y-m-d H:i:s'),
            'Created' => $entity->created->format('Y-m-d H:i:s')
        ]];
    }
    
    public function mapUser($entity)
    {
        $entity = $entity->user;
        return ['User' => [
            'OnlineId' => $entity->id,
            'Username' => $entity->username,
            'Password' => $entity->genuine,
            'Name' => $entity->fullname,
            'UserType' => $entity->type,
            'Modified' => $entity->modified->format('Y-m-d H:i:s'),
            'Created' => $entity->created->format('Y-m-d H:i:s')
        ]];
    }
    
    public function mapBarcode($entity) 
    {
        $entity = $entity->barcode;
        return ['Barcode' => [
            'OnlineId' => $entity->id,
            'Barcode' => $entity->barcode,
            'BarcodeType' => $entity->type,
            'Deleted' => !empty($entity->deleted),
            'Modified' => $entity->modified->format('Y-m-d H:i:s'),
            'Created' => $entity->created->format('Y-m-d H:i:s')
        ]];
    }

    public function mapPerson($entity)
    {
        $entity = $entity->person;
        return [ucfirst($entity->type) => [
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
                "Deleted" => !empty($entity->deleted),
                "Modified" => $entity->modified->format('Y-m-d H:i:s'),
                "Created" => $entity->created->format('Y-m-d H:i:s')    
            ]
        ];
    }
    
    public function mapGroup($entity)
    {
        $entity = $entity->group;
        return ['Group' => [
                'OnlineId' => $entity->id,
                'ProjectId' => $entity->project_id,
                'BarcodeId' => $entity->barcode_id,
                'Name' => $entity->name,
                'Url' => $entity->slug,
                'Deleted' => !empty($entity->deleted),
                'Modified' => $entity->modified->format('Y-m-d H:i:s'),
                'Created' => $entity->created->format('Y-m-d H:i:s'),
            ]
        ];
    }
    
    public function mapProject($entity)
    {
        $entity = $entity->project;
        return ['Project' => [
           'OnlineId' => $entity->id,
           'SchoolId' => $entity->school_id,
           'Name' => $entity->name,
           'Url' => $entity->slug,
           'Deleted' => !empty($entity->deleted),
           'Modified' => $entity->modified->format('Y-m-d H:i:s'),
           'Created' => $entity->created->format('Y-m-d H:i:s')
        ]];
    }
}