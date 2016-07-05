<?php
namespace App\Test\TestCase\Controller;

use App\Controller\QueuesController;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\QueuesController Test Case
 */
class QueuesControllerTest extends BaseIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.downloadqueues',
        'app.schools',
        'app.barcodes',
        'app.groups',
        'app.projects',
        'app.persons',
        'app.photos',
        'app.addresses',
        'app.logs',
    ];

    public function setUp()
    {
        parent::setUp();
        TableRegistry::clear();
        $this->setBasicAuth();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testGetDownloadQueue()
    {
        $this->get('/api/v1/get_download_queue.json');
        $this->assertResponseSuccess();

        $data = $this->getDecodedResponse();

        $expected = [
            'downloadqueueitems' => [
                [
                    'id' => 'c7872eea-eb05-4bcf-8a16-0233a7f12e7a',
                    'profile_name' => 'photographer',
                    'model' => 'Schools',
                    'foreign_key' => '82199cab-fc52-4853-8f64-575a7721b8e7',
                    'created' => '2016-06-27T09:22:26+0000',
                    'modified' => '2016-06-27T09:22:26+0000',
                    'deleted' => null,
                    'person' => null,
                    'group' => null,
                    'project' => null,
                    'user' => null,
                    'barcode' => null,
                    'school' => [
                        'id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
                        'name' => 'De ring van putten',
                        'slug' => 'de-ring-van-putten',
                        'contact_id' => 'b552c2c1-3d94-4734-b974-c15d5e35fe7c',
                        'visitaddress_id' => '9e953dd7-fbac-4dc4-9fec-3ca9cd55397e',
                        'mailaddress_id' => '8888b43c-68aa-4845-b7d6-6f50f6f7cece',
                        'created' => '2016-06-01T14:18:27+0000',
                        'modified' => '2016-06-01T14:18:27+0000',
                        'deleted' => null
                    ]
                ],
                [
                    'id' => '97acd799-7a3f-4bae-af70-ec70d7e8d4b7',
                    'profile_name' => 'photographer',
                    'model' => 'Users',
                    'foreign_key' => 'ed2438e7-f8e4-472a-a6de-48d763c29ed8',
                    'created' => '2016-06-27T09:22:26+0000',
                    'modified' => '2016-06-27T09:22:26+0000',
                    'deleted' => null,
                    'person' => null,
                    'group' => null,
                    'project' => null,
                    'user' => [
                        'id' => 'ed2438e7-f8e4-472a-a6de-48d763c29ed8',
                        'username' => 'photographer03',
                        'email' => 'photographer@photographer.nl',
                        'type' => 'photographer',
                        'created' => '2016-05-25T09:02:25+0000',
                        'modified' => '2016-05-25T09:02:25+0000',
                        'deleted' => null,
                        'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                    ],
                    'barcode' => null,
                    'school' => null
                ],
                [
                    'id' => '62beb0e3-ef13-458a-8973-67aabbf101d0',
                    'profile_name' => 'photographer',
                    'model' => 'Barcodes',
                    'foreign_key' => 'cb7f7c7d-fafb-452e-9b2d-e156f90f6209',
                    'created' => '2016-06-27T09:22:26+0000',
                    'modified' => '2016-06-27T09:22:26+0000',
                    'deleted' => null,
                    'person' => null,
                    'group' => null,
                    'project' => null,
                    'user' => null,
                    'barcode' => [
                        'id' => 'cb7f7c7d-fafb-452e-9b2d-e156f90f6209',
                        'barcode' => '4444',
                        'type' => 'barcode',
                        'created' => '2016-06-06T13:58:07+0000',
                        'modified' => '2016-06-06T13:58:07+0000',
                        'deleted' => null
                    ],
                    'school' => null
                ],
                [
                    'id' => 'fb7d9668-c2a2-4be0-9d04-3dc236d9fd2d',
                    'profile_name' => 'photographer',
                    'model' => 'Projects',
                    'foreign_key' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
                    'created' => '2016-06-27T09:22:26+0000',
                    'modified' => '2016-06-27T09:22:26+0000',
                    'deleted' => null,
                    'person' => null,
                    'group' => null,
                    'project' => [
                        'id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
                        'school_id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
                        'name' => 'Eindejaars 2016',
                        'slug' => 'eindejaars-2016',
                        'grouptext' => 'Gefeliciteerd geslaagde!',
                        'created' => '2016-06-06T10:18:42+0000',
                        'modified' => '2016-06-06T10:18:42+0000',
                        'deleted' => null
                    ],
                    'user' => null,
                    'barcode' => null,
                    'school' => null
                ],
                [
                    'id' => '97a9f95d-7212-42f9-bb2c-3d0c20b7808d',
                    'profile_name' => 'photographer',
                    'model' => 'Groups',
                    'foreign_key' => 'e5b778cd-68cd-469f-88b3-37846b984868',
                    'created' => '2016-06-27T09:22:26+0000',
                    'modified' => '2016-06-27T09:22:26+0000',
                    'deleted' => null,
                    'person' => null,
                    'group' => [
                        'id' => 'e5b778cd-68cd-469f-88b3-37846b984868',
                        'name' => 'Klas 2A',
                        'slug' => 'klas-2a',
                        'created' => '2016-06-06T11:47:13+0000',
                        'modified' => '2016-06-06T11:47:13+0000',
                        'deleted' => null,
                        'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
                        'barcode_id' => '0e46688d-02a9-4da4-9f91-ed61a3e7246e'
                    ],
                    'project' => null,
                    'user' => null,
                    'barcode' => null,
                    'school' => null
                ],
                [
                    'id' => '442800b8-a449-4a1e-b539-ce8cf79f9099',
                    'profile_name' => 'photographer',
                    'model' => 'Persons',
                    'foreign_key' => '1447e1dd-f3a5-4183-9508-725519b3107d',
                    'created' => '2016-06-27T09:22:26+0000',
                    'modified' => '2016-06-27T09:22:26+0000',
                    'deleted' => null,
                    'person' => [
                        'id' => '1447e1dd-f3a5-4183-9508-725519b3107d',
                        'group_id' => 'e5b778cd-68cd-469f-88b3-37846b984868',
                        'address_id' => '9e953dd7-fbac-4dc4-9fec-3ca9cd55397e',
                        'studentnumber' => '123456789',
                        'firstname' => 'Pieter',
                        'prefix' => '',
                        'lastname' => 'Vos',
                        'slug' => 'pieter-vos',
                        'email' => 'pietertje@pietervos.nl',
                        'type' => 'leerling',
                        'created' => '2016-06-06T11:47:18+0000',
                        'modified' => '2016-06-06T11:47:18+0000',
                        'deleted' => null,
                        'barcode_id' => 'df99d62f-258c-424d-a1fe-af3213e70867',
                        'user_id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
                    ],
                    'group' => null,
                    'project' => null,
                    'user' => null,
                    'barcode' => null,
                    'school' => null
                ]
            ]
        ];

        $this->assertEquals($expected, $data);
    }


    public function testRemoveQueueItems()
    {
        $this->Downloadqueue = TableRegistry::get('Downloadqueues');
        $data = [
            '1' => 'c7872eea-eb05-4bcf-8a16-0233a7f12e7a',
            '2' => '442800b8-a449-4a1e-b539-ce8cf79f9099'
        ];

        $this->post('/api/v1/remove_queue_items.json', $data);
        $this->assertResponseSuccess();
        $queue = $this->Downloadqueue->find()->toArray();
        $data = $this->getDecodedResponse();

        $this->assertCount(4, $queue);
    }

    public function testAddNeww()
    {
        $this->Downloadqueue = TableRegistry::get('Downloadqueues');
        $this->Barcodes = TableRegistry::get('Barcodes');
        $this->Users = TableRegistry::get('Users');
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Groups = TableRegistry::get('Groups');

        $data = [
            'Barcodes' => [
                "id"=> 'a34c9d93-b89f-4b6d-a10c-8a7e939df834',
                "online_id"=> 0,
                "barcode"=> "stuezdar9s5bko",
                "type"=> "person",
                "created"=> "\/Date(1392384692000)\/",
                "modified" => "\/Date(1392384692000)\/",
            ],
            'Photos' => [
                "id"=> '44a4e893-3f80-474f-8a8f-2870513c9d1d',
                "online_id"=> 0,
                "barcode_id"=> "ba0f3313-757a-430a-bda3-908082dea691",
                "type"=> "sibling",
                "path"=> "HA088268.jpg",
                "modified"=> "\/Date(1393595241733)\/",
                "created"=> "\/Date(1393595241733)\/",
            ],
            'Groups' => [
                "id"=> 2271,
                "online_id"=> 0,
                "project_id"=> '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
                "barcode_id"=> "ba0f3313-757a-430a-bda3-908082dea691",
                "slug"=> "test",
                "name"=> "test",
                "modified"=> "\/Date(1393486879563)\/",
                "created"=> "\/Date(1393486879563)\/",
                "deleted"=> false,
            ],
            "Users" => [
                "id"=> 47068,
                "online_id"=> 0,
                "real_pass"=> "VPWC86JO",
                "username"=> "4401sta99993969",
                "typetype"=> "student",
                "name"=> "Docentsta99993969",
                "created"=> "\/Date(1393593969567)\/",
                "modified"=> "\/Date(1393593969567)\/",
            ],
            "Persons" => [
                "id"=> 35628,
                "online_id"=> 0,
                "barcode_id"=> "a34c9d93-b89f-4b6d-a10c-8a7e939df834",
                "group_id"=> "af83fdb0-c76c-4643-913c-e74f318026d7",
                "studentnumber"=> "7",
                "lastname"=> ".",
                "user_id"=> 182075,
                "slug"=> "anis_danoun_",
                "firstname"=> "Anis Danoun",
                "prefix"=> "",
                "zipcode"=> "3027 JM ROTTERDAM",
                "city"=> "spijkenisse",
                "address"=> "Multatulistraat 7 d",
                "created"=> "\/Date(1391594379000)\/",
                "modified"=> "\/Date(1393343552463)\/",
                "deleted"=> false,
            ]
        ];


        $queue = $this->Downloadqueue->find()->toArray();
        $barcodes = $this->Barcodes->find()->toArray();
        $users = $this->Users->find()->toArray();
        $groups = $this->Groups->find()->toArray();
        $persons = $this->Persons->find()->toArray();
        $photos = $this->Photos->find()->toArray();

        $this->assertCount(6, $queue);
        $this->assertCount(7, $barcodes);
        $this->assertCount(6, $users);
        $this->assertCount(4, $groups);
        $this->assertCount(2, $persons);
        $this->assertCount(4, $photos);

        $this->post('/api/v1/upload_item.json', $data);

        $queue = $this->Downloadqueue->find()->toArray();
        $barcodes = $this->Barcodes->find()->toArray();
        $users = $this->Users->find()->toArray();
        $groups = $this->Groups->find()->toArray();
        $persons = $this->Persons->find()->toArray();
        $photos = $this->Photos->find()->toArray();

        $this->assertCount(14, $queue);
        $this->assertCount(8, $barcodes);
        $this->assertCount(7, $users);
        $this->assertCount(5, $groups);
        $this->assertCount(3, $persons);
        $this->assertCount(5, $photos);

        $this->assertResponseSuccess();
    }

    public function testAddNew2()
    {
        $this->Downloadqueue = TableRegistry::get('Downloadqueues');
        $this->Barcodes = TableRegistry::get('Barcodes');
        $this->Users = TableRegistry::get('Users');
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Groups = TableRegistry::get('Groups');

        $data = [
            'Photos' => [
                "id"=> '44a4e893-3f80-474f-8a8f-2870513c9d1d',
                "online_id"=> 0,
                "barcode_id"=> "ba0f3313-757a-430a-bda3-908082dea691",
        "type"=> "sibling",
        "path"=> "HA088268.jpg",
                "modified"=> "\/Date(1393595241733)\/",
                "created"=> "\/Date(1393595241733)\/",
            ],
            'Groups' => [
            "id"=> 2271,
                "online_id"=> 0,
            "project_id"=> '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            "barcode_id"=> "ba0f3313-757a-430a-bda3-908082dea691",
            "slug"=> "test",
            "name"=> "test",
                "modified"=> "\/Date(1393486879563)\/",
            "created"=> "\/Date(1393486879563)\/",
                "deleted"=> false,
            ],
            "Users" => [
                "id"=> 47068,
                "online_id"=> 0,
                "real_pass"=> "VPWC86JO",
                "username"=> "4401sta99993969",
                "typetype"=> "student",
                "name"=> "Docentsta99993969",
                "created"=> "\/Date(1393593969567)\/",
                "modified"=> "\/Date(1393593969567)\/",
            ],
            "Persons" => [
                "id"=> 35628,
            "online_id"=> 0,
            "barcode_id"=> "a34c9d93-b89f-4b6d-a10c-8a7e939df834",
                "group_id"=> "af83fdb0-c76c-4643-913c-e74f318026d7",
            "studentnumber"=> "7",
            "lastname"=> ".",
            "user_id"=> 182075,
            "slug"=> "anis_danoun_",
            "firstname"=> "Anis Danoun",
            "prefix"=> "",
                "zipcode"=> "3027 JM ROTTERDAM",
                "city"=> "spijkenisse",
                "address"=> "Multatulistraat 7 d",
                "created"=> "\/Date(1391594379000)\/",
                "modified"=> "\/Date(1393343552463)\/",
                "deleted"=> false,
            ]
        ];


        $queue = $this->Downloadqueue->find()->toArray();
        $barcodes = $this->Barcodes->find()->toArray();
        $users = $this->Users->find()->toArray();
        $groups = $this->Groups->find()->toArray();
        $persons = $this->Persons->find()->toArray();
        $photos = $this->Photos->find()->toArray();

        $this->assertCount(6, $queue);
        $this->assertCount(7, $barcodes);
        $this->assertCount(6, $users);
        $this->assertCount(4, $groups);
        $this->assertCount(2, $persons);
        $this->assertCount(4, $photos);

        $this->post('/api/v1/upload_item.json', $data);

        $queue = $this->Downloadqueue->find()->toArray();
        $barcodes = $this->Barcodes->find()->toArray();
        $users = $this->Users->find()->toArray();
        $groups = $this->Groups->find()->toArray();
        $persons = $this->Persons->find()->toArray();
        $photos = $this->Photos->find()->toArray();

        $this->assertCount(12, $queue);
        $this->assertCount(7, $barcodes);
        $this->assertCount(7, $users);
        $this->assertCount(5, $groups);
        $this->assertCount(3, $persons);
        $this->assertCount(5, $photos);

        $this->assertResponseSuccess();
    }

    public function testAddExisting()
    {
        $this->Downloadqueue = TableRegistry::get('Downloadqueues');
        $this->Barcodes = TableRegistry::get('Barcodes');
        $this->Users = TableRegistry::get('Users');
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Groups = TableRegistry::get('Groups');

        $data = [
            'Barcodes' => [
                "id"=> 'a34c9d93-b89f-4b6d-a10c-8a7e939df834',
                "online_id"=> "0e46688d-02a9-4da4-9f91-ed61a3e7246e",
        "barcode"=> "stuezdar9s5bko",
        "type"=> "person",
        "created"=> "\/Date(1392384692000)\/",
        "modified" => "\/Date(1392384692000)\/",
            ],
            'Photos' => [
                "id"=> '44a4e893-3f80-474f-8a8f-2870513c9d1d',
                "online_id"=> "59d395fa-e723-43f0-becb-0078425f9a27",
                "barcode_id"=> "ba0f3313-757a-430a-bda3-908082dea691",
            "type"=> "sibling",
            "path"=> "HA088268.jpg",
                "modified"=> "\/Date(1393595241733)\/",
                "created"=> "\/Date(1393595241733)\/",
            ],
            'Groups' => [
            "id"=> 2271,
                "online_id"=> "e5b778cd-68cd-469f-88b3-37846b984868",
            "project_id"=> '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            "barcode_id"=> "ba0f3313-757a-430a-bda3-908082dea691",
            "slug"=> "test",
            "name"=> "test",
                "modified"=> "\/Date(1393486879563)\/",
            "created"=> "\/Date(1393486879563)\/",
                "deleted"=> false,
            ],
            "Users" => [
                "id"=> 47068,
                "online_id"=> "ed2438e7-f8e4-472a-a6de-48d763c29ed8",
                "real_pass"=> "VPWC86JO",
                "username"=> "4401sta99993969",
                "typetype"=> "student",
                "name"=> "Docentsta99993969",
                "created"=> "\/Date(1393593969567)\/",
                "modified"=> "\/Date(1393593969567)\/",
            ],
            "Persons" => [
                "id"=> 35628,
            "online_id"=> "0fdcdf18-e0a9-43c0-b254-d373eefb79a0",
            "barcode_id"=> "a34c9d93-b89f-4b6d-a10c-8a7e939df834",
                "group_id"=> "af83fdb0-c76c-4643-913c-e74f318026d7",
            "studentnumber"=> "7",
            "lastname"=> ".",
            "user_id"=> 182075,
            "slug"=> "anis_danoun_",
            "firstname"=> "Anis Danoun",
            "prefix"=> "",
                "zipcode"=> "3027 JM ROTTERDAM",
                "city"=> "spijkenisse",
                "address"=> "Multatulistraat 7 d",
                "created"=> "\/Date(1391594379000)\/",
                "modified"=> "\/Date(1393343552463)\/",
                "deleted"=> false,
            ]
        ];


        $queue = $this->Downloadqueue->find()->toArray();
        $barcodes = $this->Barcodes->find()->toArray();
        $users = $this->Users->find()->toArray();
        $groups = $this->Groups->find()->toArray();
        $persons = $this->Persons->find()->toArray();
        $photos = $this->Photos->find()->toArray();

        $this->assertCount(6, $queue);
        $this->assertCount(7, $barcodes);
        $this->assertCount(6, $users);
        $this->assertCount(4, $groups);
        $this->assertCount(2, $persons);
        $this->assertCount(4, $photos);

        $this->post('/api/v1/upload_item.json', $data);

        $queue = $this->Downloadqueue->find()->toArray();
        $barcodes = $this->Barcodes->find()->toArray();
        $users = $this->Users->find()->toArray();
        $groups = $this->Groups->find()->toArray();
        $persons = $this->Persons->find()->toArray();
        $photos = $this->Photos->find()->toArray();

        $this->assertCount(14, $queue);
        $this->assertCount(7, $barcodes);
        $this->assertCount(6, $users);
        $this->assertCount(4, $groups);
        $this->assertCount(2, $persons);
        $this->assertCount(4, $photos);

        $this->assertResponseSuccess();
    }

    public function testAddUnknownGroup()
    {
        $this->Downloadqueue = TableRegistry::get('Downloadqueues');
        $this->Barcodes = TableRegistry::get('Barcodes');

        $data = [
            'Groups' => [ //offline aangemaakt                
                "id"=> 2271,
                "online_id"=> 0,
                "project_id"=> '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
                "barcode_id"=> 0,
                "url"=> "onbekend",                
                "name"=> "Onbekend",                
                "created"=> "\/Date(1393486879563)\/",
                "modified"=> "\/Date(1393486879563)\/",
                "deleted"=> false,
            ]
        ];

        $this->post('/api/v1/upload_item.json', $data);

        $this->assertResponseSuccess();
        $data = $this->getDecodedResponse();
       
    }
}
