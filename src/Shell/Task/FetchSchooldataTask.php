<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use PDO;
/**
 * FetchSchooldata shell task.
 */
class FetchSchooldataTask extends Shell
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
        
        $schools = $this->getSchools();
        $this->saveSchools($schools);
        
        foreach($schools as $school) {
            $projects = $this->getProjectsAndGroups($school);
            $this->saveProjects($projects);
            
            foreach($projects as $project) {
                $persons = $this->getPersons($project);
                $this->savePersons($persons);
            }
        }
    }
    
    private function truncateTables()
    {
        $this->Barcodes = TableRegistry::get('Barcodes');
        $this->Barcodes->removeBehavior('Deletable');
        $this->Barcodes->deleteAll(['created > ' => '2016-11-30']);
        
        $this->Schools = TableRegistry::get('Schools');
        $this->Schools->removeBehavior('Deletable');
        $this->Schools->deleteAll(['created > ' => '2016-11-30']);
        
        $this->Projects = TableRegistry::get('Projects');
        $this->Projects->removeBehavior('Deletable');
        $this->Projects->deleteAll(['created > ' => '2016-11-30']);
        
        $this->Groups = TableRegistry::get('Groups');
        $this->Groups->removeBehavior('Deletable');
        $this->Groups->deleteAll(['created > ' => '2016-11-30']);
        
        $this->Persons = TableRegistry::get('Persons');
        $this->Persons->removeBehavior('Deletable');
        $this->Persons->deleteAll(['created > ' => '2016-11-30']);
    }
    
    private function connectOld() {
        
        return ConnectionManager::get('old_application');
    }
    
    public function getSchools()
    {
        $this->out('Fetching schools from old application');
        $conn = $this->connectOld();
        return $conn->query('SELECT * '
                . 'FROM `schools` '
                . 'WHERE (`deleted` IS NULL '
                . 'OR `deleted` = 0) '
                . 'AND `email` NOT IN ("roel@xseeding.nl","berry@xseeding.nl","info@xseeding.nl")')->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProjectsAndGroups($school) {
        $this->out('Fetching projects and groups for '. $school['name']);
        $conn = $this->connectOld();
        
        return $conn->query('SELECT '
                . '`Projects`.`id` AS `Projects__id`, '
                . '`Projects`.`name` AS `Projects__name`, '
                . '`Projects`.`school_id` AS `Projects__school_id`, '
                . '`Projects`.`url` AS `Projects__url`, '
                . '`Projects`.`grouptext` AS `Projects__grouptext`, '
                . '`Groups`.`name` AS `Groups__name`, '
                . '`Groups`.`id` AS `Groups__id`, '
                . '`Groups`.`url` AS `Groups__url` '
                . 'FROM `projects` `Projects` '
                . 'INNER JOIN `groups` `Groups` ON `Groups`.`project_id` = `Projects`.`id` '
                . 'AND `Groups`.`deleted` = 0 '
                . 'WHERE `Projects`.`school_id` = '. $school['id'].' '
                . 'AND `Projects`.`deleted` = 0 '
                . 'AND `Projects`.`modified` > "2016-01-01" '
                . 'ORDER BY `Projects`.`school_id`')->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPersons($project) {
        
        $this->out('Fetching persons for group #' . $project['Groups__id']);
        
        $conn = $this->connectOld();
        
        $result['students'] = $conn->query('SELECT `students`.*, `users`.`username`,`users`.`real_pass` '
                . 'FROM `students` '
                . 'INNER JOIN `users` ON `students`.`user_id` = `users`.`id`'
                . 'WHERE `group_id` = ' . $project['Groups__id'].' '
                . 'AND `students`.`deleted` = 0')->fetchAll(PDO::FETCH_ASSOC);
        
        $result['staffs'] = $conn->query('SELECT `staffs`.*, `users`.`username`,`users`.`real_pass` '
                . 'FROM `staffs` '
                . 'INNER JOIN `users` ON `staffs`.`user_id` = `users`.`id`'
                . 'WHERE `group_id` = ' . $project['Groups__id'].' '
                . 'AND `staffs`.`deleted` = 0')->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public function saveSchools($schools) {        
        $this->Schools = TableRegistry::get('Schools');
        
        foreach($schools as $school) {
            $new_schools[] = [
                'name' => $school['name'],
                'slug' => strtolower(Text::slug($school['name'])),
                'old_id' => $school['id'],
                'contact' => [
                    'first_name' => $school['firstname'],
                    'prefix' => $school['prefix'],
                    'last_name' => !empty($school['lastname']) ? $school['lastname'] : ' ',
                    'phone' => $school['phone'],
                    'email' => $school['email'],
                ],
                'visitaddress' => [
                    'firstname' => $school['firstname'],
                    'prefix' => $school['prefix'],
                    'lastname' => !empty($school['lastname']) ? $school['lastname'] : ' ',
                    'street' => $school['visit_address'],
                    'number' => $school['visit_address_nr'],
                    'extension' => $school['visit_address_nr_ext'],
                    'zipcode' => $school['visit_zipcode'],
                    'city' => $school['visit_city'],
                ],
                'mailaddress' => [
                    'firstname' => $school['firstname'],
                    'prefix' => $school['prefix'],
                    'lastname' => !empty($school['lastname']) ? $school['lastname'] : ' ',
                    'street' => $school['mail_address'],
                    'number' => $school['mail_address_nr'],
                    'extension' => $school['mail_address_nr_ext'],
                    'zipcode' => $school['mail_zipcode'],
                    'city' => $school['mail_city'],
                ]
            ];
        }
        
        $entities = $this->Schools->newEntities($new_schools, ['associated' => ['Visitaddresses','Mailaddresses','Contacts']]);
        $s = 0;
        foreach($entities as $entity) {
            if(!$this->Schools->save($entity, ['associated' => ['Visitaddresses','Mailaddresses','Contacts']])) {
                pr($entity);
                continue;
            }
            $s++;
        }
        
        $this->out('<info>'.$s . ' Schools saved</info>');
    }
    
    private function saveProjects($projects)
    {
        if(empty($projects)) {
            return;
        }
        $this->Projects = TableRegistry::get('Projects');
        
        $newProjects = [];
        $projectcount = 0;
        $count = 0;
        foreach($projects as $project) {
                       
            if(!array_key_exists($project['Projects__id'], $newProjects)) {
                $projectcount++;
                $newProjects[$project['Projects__id']] = [
                    'school_id' => $this->Projects->Schools->find()->where(['old_id' => $project['Projects__school_id']])->first()['id'],
                    'name' => ucfirst($project['Projects__name']),
                    'grouptext' => $project['Projects__grouptext'],
                    'slug' => strtolower(Text::slug($project['Projects__name']))
                ];
            }
            
            $newProjects[$project['Projects__id']]['groups'][] = [
                        'old_id' => $project['Groups__id'],
                        'name' => $project['Groups__name'],
                        'slug' => strtolower(Text::slug($project['Groups__name'])),
                    ];
            $count++;
        }
        sort($newProjects);

        $entities = $this->Projects->newEntities($newProjects, ['associated' => ['Groups']]);
        foreach($entities as $entity) {
            if(!$this->Projects->save($entity, ['associated' => ['Groups']])) {
                pr($entity);
                continue;
            }
        }
        
        $this->out('<info>'.$projectcount . ' projects saved with '. $count .' groups</info>');
    }

    public function savePersons($persons)
    {
        $this->Persons = TableRegistry::get('Persons');
        $newPersons = [];
        foreach($persons['students'] as $student) {
            $newPersons[] = [
                'old_id' => $student['id'],
                'group_id' => $this->Persons->Groups->find()->where(['old_id' => $student['group_id']])->first()->id,
                'studentnumber' => $student['studentnumber'],
                'firstname' => $student['firstname'],
                'prefix' => $student['prefix'],
                'lastname' => $student['lastname'],
                'email' => $student['email'],
                'type' => 'student',
                'slug' => strtolower(Text::slug($student['url'])),
                'user_id' => $this->Persons->Users->newUser([
                    'username' => $student['username'],
                    'password' => $student['real_pass'],
                ])
            ];
        }
        
        foreach($persons['staffs'] as $staff) {
            $newPersons[] = [
                'old_id' => $staff['id'],
                'group_id' => $this->Persons->Groups->find()->where(['old_id' => $staff['group_id']])->first()->id,
                'studentnumber' => null,
                'firstname' => $staff['firstname'],
                'prefix' => $staff['prefix'],
                'lastname' => $staff['lastname'],
                'type' => 'staff',
                'slug' => strtolower(Text::slug($staff['url'])),
                'user_id' => $this->Persons->Users->newUser([
                    'username' => $staff['username'],
                    'password' => $staff['real_pass'],
                ])
            ];
        }
        
        $entities = $this->Persons->newEntities($newPersons);
        foreach($entities as $entity) {
            if(!$this->Persons->save($entity)) {
                pr($entity);
                continue;
            }
        }
        
        $this->out('<info>'.count($entities) . ' persons saved</info>');
    }
    
}
