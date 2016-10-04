<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

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
        'app.persons',
        'app.groups',
        'app.schools',
        'app.barcodes',
        'app.photos',
        'app.projects'
    ];
    
    public function setUp()
    {
        parent::setUp();
        
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Users = TableRegistry::get('Users');
        $this->Photos->baseDir = APP . '..' . DS . 'tests' . DS . 'Fixture';
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
    
    public function testLoginGetPortraits()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    'username' => 'person',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
            ]
        ]);
        
        $this->get('/');
        $photos = $this->viewVariable('photos');
        $this->assertTrue(isset($photos));
        $this->assertEquals('horizontal.jpeg', $photos[0]->path);
        $this->assertEquals('photos-horizontal', $photos[0]->orientationClass);
        $this->assertResponseOk();
    }

    public function testFirstLoginSuccess()
    {
        $data = [
            'username' => 'person',
            'password' => 'photex',
            'x' => 176,
            'y' => 45
        ];
       
        $this->post('/', $data);
        $this->assertSession('91017bf5-5b19-438b-bd44-b0c4e1eaf903', 'Auth.User.id');
        $this->assertSession('person', 'Auth.User.type');
        $this->assertSession(['91017bf5-5b19-438b-bd44-b0c4e1eaf903'], 'LoggedInUsers.AllUsers');
        $this->assertSession('91017bf5-5b19-438b-bd44-b0c4e1eaf903', 'LoggedInUsers.ActiveUser');
    }
    
    public function testFirstLoginFail()
    {
        $data = [
            'username' => 'bestaatniet',
            'password' => 'bestaatniet',
            'x' => 176,
            'y' => 45
        ];
        
        $this->post('/', $data);
        $this->assertSession('Het inloggen is mislukt. Probeer het nogmaals.', 'Flash.flash.0.message');
        $this->assertRedirect('/');
    }
    
    public function testMulitpleLoginSuccess()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    'username' => 'person',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
            ]
        ]);
        
        $data = [
            'username' => 'person2',
            'password' => 'photex',
            'x' => 176,
            'y' => 45
        ];
        $this->post('/', $data);
        $loggedInUsers = [
            '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
            '61d2a03c-08f9-400b-9942-9d2f3a843aaa'
        ];
        $this->assertSession($loggedInUsers, 'LoggedInUsers.AllUsers');
        $this->assertRedirect('/');
    }
    
    public function testMultipleLoginUserAlreadyLoggedIn()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    'username' => 'person',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [
                    0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    1 => '61d2a03c-08f9-400b-9942-9d2f3a843aaa'
                ],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
            ]
        ]);
        
        $data = [
            'username' => 'person2',
            'password' => 'photex',
            'x' => 176,
            'y' => 45
        ];
        $this->post('/', $data);
        $this->assertSession('Kind al ingelogd.', 'Flash.flash.0.message');
        $this->assertRedirect('/');
    }
    
    public function testMulitpleLoginFail()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    'username' => 'person',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
            ]
        ]);
        
        $data = [
            'username' => 'bestaatniet',
            'password' => 'bestaatniet',
            'x' => 176,
            'y' => 45
        ];
        
        $this->post('/', $data);
        $this->assertSession('Het inloggen is mislukt. Probeer het nogmaals.', 'Flash.flash.0.message');
        $this->assertRedirect('/');
    }
    
    public function testLogout()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    'username' => 'person',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [
                    0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    1 => '61d2a03c-08f9-400b-9942-9d2f3a843aaa'
                ],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
            ]
        ]);
        
        $this->get('/logout');
        $this->assertSession('Het uitloggen is succesvol', 'Flash.flash.0.message');
        $this->assertSession(null, 'LoggedInUsers');
        $this->assertRedirect('/');
    }
}
