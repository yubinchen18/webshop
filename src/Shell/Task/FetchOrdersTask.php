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
class FetchOrdersTask extends Shell
{
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $this->truncateTables();
        $this->Photos = TableRegistry::get('Photos');
        $this->Products = TableRegistry::get('Products');
        
        ConnectionManager::config('old_application', [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'hoogstraten',
            'password' => '2caKfj7P',
            'database' => 'admin_hoogstraten',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
        ]);
        
        $orders = $this->getOrders();
        $this->saveOrders($orders);
        
//        $this->saveNewPersons();
        
    }
    
    private function truncateTables()
    {
        $this->Orders = TableRegistry::get('Orders');
        $this->Orders->removeBehavior('Deletable');
        $this->Orders->deleteAll(['created > ' => '2015-01-08']);
//        
        $this->Addresses = TableRegistry::get('Addresses');
        $this->Addresses->removeBehavior('Deletable');
        $this->Addresses->deleteAll(['created > ' => '2017-01-08']);
        
        $this->Orderstatuses = TableRegistry::get('OrdersOrderstatuses');
        $this->Orderstatuses->removeBehavior('Deletable');
        $this->Orderstatuses->deleteAll(['created > ' => '2017-01-09']);
//        
//        $this->Users = TableRegistry::get('Users');
//        $this->Users->removeBehavior('Deletable');
//        $this->Users->deleteAll(['created > ' => '2017-01-08']);
//
//        $this->Persons = TableRegistry::get('Persons');
//        $this->Persons->removeBehavior('Deletable');
//        $this->Persons->deleteAll(['created > ' => '2017-01-09']);
//
//        $this->Barcodes = TableRegistry::get('Barcodes');
//        $this->Barcodes->removeBehavior('Deletable');
//        $this->Barcodes->deleteAll(['created > ' => '2017-01-09']);
    }
    
    private function connectOld() 
    {    
        return ConnectionManager::get('old_application');
    }
    
    public function getOrders()
    {
        $this->out('Fetching orders from old application');
        TableRegistry::clear();
        $conn = $this->connectOld();
        $orders = TableRegistry::get('OldOrders', [
           'table' => 'orders',
           'connection' => $conn,
        ]);
        $clients = TableRegistry::get('OldClients',[
            'table' => 'clients',
            'connection' => $conn
        ]);
        $deliveries = TableRegistry::get('OldDeliveries',[
            'table' => 'deliveries',
            'connection' => $conn
        ]);
        $orderlines = TableRegistry::get('OldOrderlines', [
            'table' => 'orderlines',
            'connection' => $conn
        ]);
        $photos = TableRegistry::get('OldPhotos', [
            'table' => 'photos',
            'connection' => $conn
        ]);
        $products = TableRegistry::get('OldProducts', [
            'table' => 'products',
            'connection' => $conn
        ]);
        $users = TableRegistry::get('OldUsers', [
            'table' => 'users',
            'connection' => $conn
        ]);
        $statuses = TableRegistry::get('OldStatuses', [
            'table' => 'orderstatuses',
            'connection' => $conn
        ]);
        
        $orderlines->belongsTo('OldPhotos',['foreignKey' => 'photo_id']);
        $orderlines->belongsTo('OldProducts', ['foreignKey' => 'product_id']);
        $orders->belongsTo('OldClients',['type' => 'INNER', 'foreignKey' => 'client_id']);
        $orders->belongsTo('OldDeliveries',['type' => 'LEFT','foreignKey' => 'delivery_id']);
        $orders->belongsTo('OldUsers',['type' => 'INNER','foreignKey' => 'user_id']);
        $orders->hasMany('OldOrderlines', ['type' => 'INNER', 'foreignKey' => 'order_id']);
        $orders->hasMany('OldStatuses', ['type' => 'INNER', 'foreignKey' => 'order_id']);
        
        $old_orders = $orders
                ->find()
                ->contain(['OldUsers','OldStatuses','OldClients','OldDeliveries','OldOrderlines' => ['OldProducts','OldPhotos']])
                ->where(['OldOrders.created >' => date('Y-m-d',strtotime("-6 months"))]);
        
        $this->out('<info>' . $old_orders->count() . ' orders found</info>');
        return $old_orders->toArray();
    }
    
    public function saveOrders($orders) {        
        $this->Orders = TableRegistry::get('Orders');
        
        $statuses = [
            1 => '6b0ec84f-d27e-11e6-a9f6-00163e5e884d', // new
            2 => '6b0ec8fa-d27e-11e6-a9f6-00163e5e884d', // in behandeling
            4 => '6b0ec786-d27e-11e6-a9f6-00163e5e884d', // verzonden naar klant
            6 => '6b0ec8d9-d27e-11e6-a9f6-00163e5e884d', // Geannuleerd
            9 => '6b0ec6dc-d27e-11e6-a9f6-00163e5e884d', // Gedownload naar Photex
        ];
        
        $new_orders = [];
        $count = $checked = 0;
        foreach($orders as $order) {
            $checked++;
            if(empty($order->old_orderlines)) {
                continue;
            }
            
            //find the user
            $user = $this->Orders->Users->find()
                    ->where(['username' => $order->old_user->username])
                    ->first();
            
            if(empty($user)) {
                $this->err('User not found for order '. $order->id);
                continue;
            }
            
            $delivery = null;
            if(!empty($order->old_delivery)) {
                $delivery = $this->Orders->Deliveryaddresses->find()
                        ->where([
                            'street' => $order->old_delivery->street,
                            'lastname' => $order->old_delivery->lastname,
                            'zipcode' => $order->old_delivery->zipcode,
                            'city' => $order->old_delivery->city
                        ])->first();

                if(empty($delivery)) {
                    $newAddress = [
                        'firstname' => $order->old_delivery->firstname,
                        'prefix' => $order->old_delivery->prefix,
                        'lastname' => $order->old_delivery->lastname,
                        'street' => $order->old_delivery->address,
                        'number' => $order->old_delivery->housenumber,
                        'extension' => null,
                        'zipcode' => $order->old_delivery->zipcode,
                        'city' => $order->old_delivery->city
                    ];
                    $delivery = $this->Orders->Deliveryaddresses->newEntity($newAddress);

                    if(!($delivery = $this->Orders->Deliveryaddresses->save($delivery))) {
                        $this->out('<error>Saving of delivery address failed</error>');
                        die();
                    }
                }
            }
            
            $invoice = $this->Orders->Invoiceaddresses->find()
                    ->where([
                        'street' => $order->old_client->street,
                        'lastname' => $order->old_client->lastname,
                        'zipcode' => $order->old_client->zipcode,
                        'city' => $order->old_client->city
                    ])->first();
            
            if(empty($invoice)) {
                    $newAddress = [
                        'firstname' => $order->old_client->firstname,
                        'prefix' => $order->old_client->prefix,
                        'lastname' => $order->old_client->lastname,
                        'street' => $order->old_client->address,
                        'number' => $order->old_client->housenumber,
                        'extension' => null,
                        'zipcode' => $order->old_client->zipcode,
                        'city' => $order->old_client->city,
                        'email' => $order->old_client->email,
                        'phone' => $order->old_client->phone
                    ];
                $invoice = $this->Orders->Invoiceaddresses->newEntity($newAddress);
                if(!($invoice = $this->Orders->Invoiceaddresses->save($invoice))) {
                    $this->out('<error>Saving of invoice address failed</error>');
                    die();
                }
            }
            
            $exportstatus = [
                'Y' => 'success',
                'Q' => 'queued',
                'N' => 'new',
                'C' => 'cancelled'
            ];
            
            $orderlines = [];
            $totalprice = 0;
            foreach($order->old_orderlines as $line) {
                if(empty($line->old_photo)) {
                    continue;
                }
                
                $photo = $this->Photos->find()->where(['path' => $line->old_photo->path])->first();
                $product = $this->Products->find()->where(['article' => $line->old_product->article_number])->first();
                
                if(empty($photo->id)) {
//                    $this->err("(".$checked.") no photo found : " . $line->old_photo->path);
                    continue;
                }
                
                if(empty($product->id)) {
                    $this->err("(".$checked.") no product found : " . $line->old_product->article_number);
                    continue;
                }
                
                $orderlines[] = [
                        'photo_id' => $photo->id,
                        'product_id' => $product->id,
                        'productname' => $product->name,
                        'price_ex' => $line->price,
                        'vat' => $line->taxrate,
                        'quantity' => $line->quantity,
                        'exported' => $line->exported
                    ];
                
                $totalprice += $line->price;
            }
            
            $count++;
            $new_orders[] = [
                'user_id' => $user->id,
                'orderlines' => $orderlines,
                'deliveryaddress_id' => empty($delivery) ? $invoice->id : $delivery->id,
                'invoiceaddress_id' => $invoice->id,
                'trx_id' => $order->transaction_id,
                'shippingcosts' => $order->shipping_costs,
                'totalprice' => $totalprice,
                'export_status' => $exportstatus[$order->exported],
                'ident' => $order->id,
                'payment_method' => $order->paymentmethod,
                'ideal_status' => $order->ideal_endstate,
                'created' => $order->created->format('Y-m-d H:i:s'),
                'modified' => $order->modified->format('Y-m-d H:i:s')
            ];
        }
        
        $entities = $this->Orders->newEntities($new_orders, ['associated' => ['Invoiceaddresses','Deliveryaddresses','Users','Orderlines']]);
        $s = 0;
        foreach($entities as $entity) {
            if(!$this->Orders->save($entity, ['associated' => ['Invoiceaddresses','Deliveryaddresses','Users','Orderlines']])) {
                print_r($entity); die();
                continue;
            }
            
            if(empty($order->old_statuses[0])) {
                $order->old_statuses[0]['status_id'] = 1;
            }
            
            foreach($order->old_statuses as $status) {
                $statusrecord = [
                    'order_id' => $entity->id,
                    'orderstatus_id' => $statuses[$status['status_id']],
                    'created' => $status['created']->format('Y-m-d H:i:s')
                ];
                $statusEntity = $this->Orders->OrdersOrderstatuses->newEntity($statusrecord);
                if(!$this->Orders->OrdersOrderstatuses->save($statusEntity)) {
                    pr($statusEntity); die();
                }
            }
            $s++;
        }
        
        $this->out('<info>'.$checked . ' Orders checked</info>');
        $this->out('<info>'.$count . ' Orders found</info>');
        $this->out('<info>'.$s . ' Orders saved</info>');
        die();
    }
    
    public function saveNewPersons()
    {
        return;
        $csv = APP . "/Shell/photos.csv";
        $persons = [];
        if (($handle = fopen($csv, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if($data[0] == 'id') {
                    continue;
                }
                
                $address = $person = $group = null;
                if($data[5] != 'NULL') {
                    $person = [
                        'old_id' => $data[5],
                        'type' => 'student',
                        'firstname' => $data[6],
                        'prefix' => $data[7],
                        'lastname' => $data[8],
                        'studentnumber' => $data[9],
                        'slug' => $data[10],
                        'group_id' => $data[13]
                    ];
                    $user = [
                        'username' => $data[10],
                        'password' => $data[12]
                    ];
                    $barcode_type = 'person';
                }
                
                if($data[14] != 'NULL') {
                    $person = [
                        'old_id' => $data[14],
                        'type' => 'staff',
                        'firstname' => $data[15],
                        'prefix' => $data[16],
                        'lastname' => $data[17],
                        'slug' => $data[18],
                    ];
                    $user = [
                        'firstname' => $data[19],
                        'prefix' => $data[20]
                    ];
                    $barcode_type = 'person';
                }
                
                if($data[22] != 'NULL') {
                    $group = [
                        'old_id' => $data[22],
                        'name' => $data[23]
                    ];
                    $barcode_type = 'group';
                }
                
                
                if(empty($persons[$data[2]])) {
                    $persons[$data[2]] = [
                        'Barcode' => [
                            'old_id'  => $data[0],
                            'barcode' => $data[1],
                            'type' => $barcode_type
                        ],
                        'Person' => $person,
                        'User' => $user
                    ];
                }
                $persons[$data[2]]['Photo'][] = [
                    'path' => $data[1],
                    'type' => empty($group) ? 'portrait' : 'group'
                ];
                
                if(count($persons) == 10) {
                    break;
                }
            }
            fclose($handle);
        }

        $this->Persons = TableRegistry::get('Persons');
        $newPersons = [];
        $staffs = [];
        foreach($persons as $student) {
            
            $person = $this->Persons->find()
                        ->where([
                            'group_id' => $this->Persons->Groups->find()->where(['old_id' => $student['Person']['group_id']])->first()->id,
                            'slug' => $student['Person']['slug']
                        ])
                        ->first();
            
            if(!empty($person->id)) {
                continue;
            }
            
            if($student['Person']['type'] == 'staff') {
                $staffs[] = $student;
                continue;
            }
                        
            $newPersons[] = [
                'old_id' => $student['Person']['old_id'],
                'group_id' => $this->Persons->Groups->find()->where(['old_id' => $student['Person']['group_id']])->first()->id,
                'studentnumber' => $student['Person']['studentnumber'],
                'firstname' => $student['Person']['firstname'],
                'prefix' => $student['Person']['prefix'],
                'lastname' => $student['Person']['lastname'],
                'type' => 'student',
                'slug' => strtolower(Text::slug($student['Person']['slug'])),
                'user_id' => $this->Persons->Users->newUser([
                    'username' => $student['User']['username'],
                    'password' => $student['User']['password'],
                ])
            ];
        }
        
        foreach($staffs as $staff) {
            $newPersons[] = [
                'old_id' => $staff['Person']['old_id'],
                'group_id' => $this->Persons->Groups->find()->where(['old_id' => $staff['Person']['group_id']])->first()->id,
                'firstname' => $staff['Person']['firstname'],
                'prefix' => $staff['Person']['prefix'],
                'lastname' => $staff['Person']['lastname'],
                'type' => 'staff',
                'slug' => strtolower(Text::slug($staff['Person']['slug'])),
                'user_id' => $this->Persons->Users->newUser([
                    'username' => $staff['User']['username'],
                    'password' => $staff['User']['password'],
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
