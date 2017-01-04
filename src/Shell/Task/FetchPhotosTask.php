<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use PDO;
use phpseclib\Net\SSH2;
use phpseclib\Net\SCP;
use Cake\Filesystem\Folder;
use Cake\Utility\Inflector;

/**
 * FetchPhotos shell task.
 */
class FetchPhotosTask extends Shell
{

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $this->truncateTables();
        
        ConnectionManager::config('old_application', [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'admin_hoogstrate',
            'password' => '2caKfj7P',
            'database' => 'admin_hoogstraten',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
        ]);
        
        $this->getNewBarcodes();
    }
    
    private function connectOld() 
    {
        return ConnectionManager::get('old_application');
    }
    
    private function truncateTables()
    {
        $this->Photos = TableRegistry::get('Photos');
        $this->Photos->removeBehavior('Deletable');
        $this->Photos->deleteAll(['created > ' => '2016-11-30']);
    }
    
    private function getNewBarcodes()
    {
        $this->Barcodes = TableRegistry::get('Barcodes');
        $barcodes = $this->Barcodes->find();
        
        foreach($barcodes as $barcode) {
            $photos = $this->parseResults($this->fetchOldData($barcode, $barcode->type));
            if(!$this->savePhotos($photos, $barcode)) {
                $this->out('<error>Saving of photos for barcode #' . $barcode->id . " failed</error>");
            } else {
                $this->out('<info>Photos saved for barcode #' . $barcode->id . "</info>");
            }
        }
    }
    
    private function fetchOldData($barcode, $type)
    {
        $this->out('Fetching photos for barcode ' . $barcode->barcode . " (".$type.")");
        $conn = $this->connectOld();

        $contain = ($type == 'group' ? 'Groups' : 'Persons');
        
        $barcode = $this->Barcodes->find()
                    ->where(['Barcodes.id' => $barcode->id])
                    ->contain([$contain])
                    ->first();
        if(empty($barcode->person->old_id) && $type == 'person') {
            return false;
        }

        if(empty($barcode->group->old_id) && $type == 'group') {
            return false;
        }
            
        switch($type) {
            case "person":
            $table = $barcode->person->type == 'student' ? 'students' : 'staffs';
            
            return $conn->query('SELECT '
                    . '`Photos`.`id` AS `Photos__id`, '
                    . '`Photos`.`path` AS `Photos__path`, '
                    . '`Photos`.`photo_type` AS `Photos__type`, '
                    . '`Persons`.`id` AS `Person__id`, '
                    . '`Persons`.`url` AS `Person__slug`, '
                    . '`Groups`.`id` AS `Group__id`, '
                    . '`Groups`.`url` AS `Group__slug`, '
                    . '`Projects`.`id` AS `Project__id`, '
                    . '`Projects`.`url` AS `Project__slug`, '
                    . '`Schools`.`id` AS `School__id`, '
                    . '`Schools`.`url` AS `School__slug` '
                    . 'FROM `photos` `Photos` '
                    . 'INNER JOIN `barcodes` `Barcodes` ON `Photos`.`barcode_id` = `Barcodes`.`id` '
                    . 'INNER JOIN `'.$table.'` `Persons` ON `Persons`.`barcode_id` = `Barcodes`.`id` '
                    . 'INNER JOIN `groups` `Groups` ON `Groups`.`id` = `Persons`.`group_id` '
                    . 'INNER JOIN `projects` `Projects` ON `Projects`.`id` = `Groups`.`project_id` '
                    . 'INNER JOIN `schools` `Schools` ON `Schools`.`id` = `Projects`.`school_id` '
                    . 'WHERE `Barcodes`.`id` = ('
                    . ' SELECT `barcode_id` '
                    . ' FROM `'.$table.'` `Persons` '
                    . ' WHERE `Persons`.`id` = ' . $barcode->person->old_id . ''
                    . ') '
                    . 'ORDER BY `Photos`.`created`'
                    )->fetchAll(PDO::FETCH_ASSOC);
                break;
            
            case "group":                
                return $conn->query('SELECT '
                    . '`Photos`.`id` AS `Photos__id`, '
                    . '`Photos`.`path` AS `Photos__path`, '
                    . '`Photos`.`photo_type` AS `Photos__type`, '
                    . '`Groups`.`id` AS `Group__id`, '
                    . '`Groups`.`url` AS `Group__slug`, '
                    . '`Projects`.`id` AS `Project__id`, '
                    . '`Projects`.`url` AS `Project__slug`, '
                    . '`Schools`.`id` AS `School__id`, '
                    . '`Schools`.`url` AS `School__slug` '
                    . 'FROM `photos` `Photos` '
                    . 'INNER JOIN `barcodes` `Barcodes` ON `Photos`.`barcode_id` = `Barcodes`.`id` '
                    . 'INNER JOIN `groups` `Groups` ON `Groups`.`barcode_id` = `Barcodes`.`id` '
                    . 'INNER JOIN `projects` `Projects` ON `Projects`.`id` = `Groups`.`project_id` '
                    . 'INNER JOIN `schools` `Schools` ON `Schools`.`id` = `Projects`.`school_id` '
                    . 'WHERE `Barcodes`.`id` = ('
                    . ' SELECT `barcode_id` '
                    . ' FROM `groups` `Groups` '
                    . ' WHERE `Groups`.`id` = ' . $barcode->group->old_id . ''
                    . ') '
                    . 'ORDER BY `Photos`.`created`'
                    )->fetchAll(PDO::FETCH_ASSOC);
                break;
        }
    }
    
    private function parseResults($results)
    {
        if($results === false) {
            return [];
        }
        $parsed = [];
        foreach($results as $key => $value) {
            foreach($value as $k => $v) {
                $named = explode("__",$k);
                $parsed[$key][$named[0]][$named[1]] = $v;
            }
        }
        $results = null;
        return $parsed;
    }
    
    private function savePhotos($photos,$barcode)
    {
        if(empty($photos[0])) {
            return false;
        }
        if(!empty($photos[0]['Person'])) {
            $this->out('<info>Download photos for ' . $photos[0]['Person']['slug'] . "</info>");
        } else {
            $this->out('<info>Download photos for group ' . $photos[0]['Group']['slug']."</info>");
        }
        
        $remote_folder = "/var/www/vhosts/hoogstratenfotografie.nl/httpdocs/app/userphotos";
        $local_folder = $this->Barcodes->Photos->getPath($barcode->id);
        $photoData = [];
        
        foreach($photos as $photo) {
            $remote_path = $remote_folder . "/"
                    . $photo['School']['id']."_".$photo['School']['slug']."/"
                    . $photo['Project']['id']."_".$photo['Project']['slug']."/"
                    . $photo['Group']['id']."_".$photo['Group']['slug']."/";
            
            if($barcode->type !== 'group') {
                    $remote_path .= $photo['Person']['id']."_".$photo['Person']['slug']."/";
            }
            
            $remote_path .= $photo['Photos']['path'];
            
            $local_path = $local_folder . "/". $photo['Photos']['path'];
            
            $dir = new Folder();
            if(!$dir->create($local_folder, 777)) {
                die('Could not create local dir');
            }
            
            $ssh = new SSH2('bestellen.hoogstratenfotografie.nl');
            if(!$ssh->login('hoogstraten', 'sy74NdLHGw')) {
                die('SSH login failed');
            }
            
            $scp = new SCP($ssh);
            if(!$scp->get($remote_path, $local_path)) {
                $this->out('<error>Photo download mislukt ('. $photo['Photos']['path'].")</error>");
            }
            
            $pic = new \Imagick($local_path);
            $this->Photos->autoRotateImage($pic);
            $photoData[] = [
                'path' => $photo['Photos']['path'],
                'type' => $photo['Photos']['type'],
                'barcode_id' => $barcode->id
            ];
        }
        
        $entities = $this->Barcodes->Photos->newEntities($photoData);
        foreach($entities as $entity) {
            if(!$this->Barcodes->Photos->save($entity)) {
                pr($entity);
                continue;
            }
        }
        
        return true;
    }
}
