<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
/**
 * Photex shell command.
 */
class SendDownloadlinksShell extends Shell
{
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
        $orders = $this->Orders
                ->find()
                ->contain(['Orderlines.Products'])
                ->matching('Orderlines.Products', function($q) {
                    return $q->where(['product_group' => 'digital']);
                })
                ->matching('OrdersOrderstatuses.Orderstatuses', function($q) {
                    return $q->where(['Orderstatuses.alias' => 'payment_received']);
                })
                ->andWhere(['link_sent' => 0]);
        
        foreach($orders as $order) {
            $this->out('Trying to send link for #'. $order->ident);
            
            if($this->Orders->sendDownloadlink($order)) {
                $patched = $this->Orders->patchEntity($order, ['link_sent' => 1]);
                $this->Orders->save($patched);
                
                $this->out('Link send for order #'. $order->ident);
            }
        }
        
    }
}

