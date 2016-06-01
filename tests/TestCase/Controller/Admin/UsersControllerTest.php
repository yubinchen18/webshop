<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\UsersController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends BaseIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Users = TableRegistry::get('Users');
    }

    public function testIndex()
    {
        $this->get('/admin/users');
        $this->assertResponseOk();
        $users = $this->viewVariable('users');
        $this->assertEquals(2, $users->count());
    }

    public function testView()
    {
        $this->get('/admin/users/view/7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa');
        $this->assertResponseOk();
        $user = $this->viewVariable('user');
        $this->assertEquals('7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa', $user->id);
    }

    public function testAddGet()
    {
        $this->get('/admin/users/add');
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\User', $this->viewVariable('user'));
    }

    public function testAdd()
    {
        $data = [
            'id' => '5c420372-fcaf-4f4f-ba61-f38253df4f46',
            'username' => 'test',
            'password' => 'test',
            'email' => 'test@test.nl',
            'type' => 'admin',
        ];
        $this->post('/admin/users/add', $data);
        $this->assertRedirect('/admin/users');

        $user = $this->Users->find()->where(['username' => 'test'])->first();
        $this->assertNotEmpty($user);
        $this->assertUuid($user->id);
    }

    public function testAddFailure()
    {
        $data = [
            'id' => '5c420372-fcaf-4f4f-ba61-f38253df4f46',
            'username' => '',
            'password' => 'test',
            'email' => 'test@test.nl',
            'type' => 'admin',
        ];
        $this->post('/admin/users/add', $data);
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\User', $this->viewVariable('user'));
        $errors = [
            'username' => [
                '_empty' => 'This field cannot be left empty'
            ]
        ];
        $this->assertEquals($errors, $this->viewVariable('user')->errors());
    }

    public function testEditGet()
    {
        $this->get('/admin/users/edit/7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa');

        $this->assertResponseOk();

        $user = $this->viewVariable('user');

        $this->assertEquals('7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa', $user->id);
    }

    public function testEdit()
    {
        $id = '7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa';
        $data = [
            'username' => 'changeduser',
            
        ];
        $this->put('/admin/users/edit/'.$id, $data);
        $this->assertRedirect('/admin/users');

        $user = $this->Users->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($user);
        $this->assertEquals($data['username'], $user->username);
    }

    public function testDeleteYourself()
    {
        $this->delete('/admin/users/delete/7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa');
        $this->assertRedirect('/admin/users');
        $user = $this->Users->find()->where(['id' => '7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa'])->first();
        $this->assertNotEmpty($user);
    }

    public function testDelete()
    {
        $id = '5c420372-fcaf-4f4f-ba61-f38253df4f46';
        $user = $this->Users->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($user);
        $this->delete('/admin/users/delete/'.$id);
        $this->assertRedirect('/admin/users');
        $user = $this->Users->find()->where(['id' => $id])->first();
        $this->assertEmpty($user);
    }

    public function testLogin()
    {
        $this->logout();
        $data = [
            'username' => 'xseeding',
            'password' => 'xseeding',
        ];
        $this->post('/admin/login', $data);

        $this->assertRedirect('/admin/users');
    }

    public function testLoginWrong()
    {
        $data = [
            'username' => 'test',
            'password' => 'test',
        ];
        $this->post('/admin/login', $data);
    }
}
