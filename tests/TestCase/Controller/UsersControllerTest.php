<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.addresses',
        'app.invoices',
        'app.persons',
        'app.groups',
        'app.projects',
        'app.schools',
        'app.contacts',
        'app.visitaddresses',
        'app.deliveryorders',
        'app.deliveryaddresses',
        'app.invoiceorders',
        'app.invoiceaddresses',
        'app.trxes',
        'app.orderlines',
        'app.photex_downloads',
        'app.orderstatuses',
        'app.orders_orderstatuses',
        'app.mailaddresses',
        'app.barcodes',
        'app.photos',
        'app.orders'
    ];
    
    public function setUp()
    {
        parent::setUp();
        
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Photos->baseDir = APP . '..' . DS . 'tests' . DS . 'Fixture';
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    'firstname' => 'Pieter'
                ]
            ]
        ]);
    }
    
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Persons);
        unset($this->Photos);

        parent::tearDown();
    }

    public function testLogin() {
//       $this->post('/', $data)
    }
}
