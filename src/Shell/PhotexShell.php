<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
/**
 * Photex shell command.
 */
class PhotexShell extends Shell
{
    public $tasks = ['ExportPhotex'];
    
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

        return $parser;
    }
    
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Orders');
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() 
    {
        $this->ExportPhotex->find_waiting_orders();
        $this->ExportPhotex->process_queue();
        $this->ExportPhotex->final_check();
        
        //cronjob?
//        $data = [];
//        foreach( $this->ExportPhotex->data as $key => $value ) {
//            $data[] = [
//                'key' =>  $key,
//                'value' => $value
//            ];
//	}
//	
//        $data[] = [
//            'key' => 'cronjobs.photex.duration',
//            'value' => (round(microtime(true) - $start,3)*1000)
//        ];

//        XseedingMonitor::sendData($data);
    }
}
