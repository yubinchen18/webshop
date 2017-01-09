<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Event\EventManager;

/**
 * Fiximages shell command.
 */
class NewMigrationShell extends Shell
{

    public $tasks = ['FetchSchooldata','FetchPhotos','FetchOrders'];
    
    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $parser->addOption('environment', [
            'short' => 'e',
            'help' => 'Specify an environment',
            'choices' => [
                'development',
                'dev',
                'staging',
                'production'
            ]
        ]);
        return $parser;
    }
    
    public function main()
    {
        if (empty($this->params['environment'])) {
            $this->error('<error>No environment specified. Use option -e / --environment.</error>');
        }
        
        EventManager::instance()->on(
            'Shell.out',
            function (Event $event, $text) {
                $this->out($text);
            }
        );

        switch ($this->params['environment']) {
            case 'dev':
            case 'development':
                ConnectionManager::drop('default');
                Configure::load('environments/development');
                break;
            case 'staging':
                ConnectionManager::drop('default');
                Configure::load('environments/staging');
                break;
            case 'production':
                //production is default in app.php
                //But load extra configurations
                ConnectionManager::drop('default');
                Configure::load('environments/production');
                break;
        }
        ConnectionManager::config(Configure::consume('Datasources'));
        
        $this->FetchOrders->main();
//        $this->FetchSchooldata->main();
//        $this->FetchPhotos->main();
        $this->out('<info>Finished at ' . date('d-m-Y H:i:s') .'</info>');
    }
}