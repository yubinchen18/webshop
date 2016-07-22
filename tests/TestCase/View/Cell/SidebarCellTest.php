<?php
namespace App\Test\TestCase\View\Cell;

use App\View\Cell\SidebarCell;
use Cake\TestSuite\TestCase;
use Cake\Controller\Exception\AuthSecurityException;

/**
 * App\View\Cell\SidebarCell Test Case
 */
class SidebarCellTest extends TestCase
{

    /**
     * Request mock
     *
     * @var \Cake\Network\Request|\PHPUnit_Framework_MockObject_MockObject
     */
    public $request;

    /**
     * Response mock
     *
     * @var \Cake\Network\Response|\PHPUnit_Framework_MockObject_MockObject
     */
    public $response;

    /**
     * Test subject
     *
     * @var \App\View\Cell\TestCell
     */
    public $Test;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = $this->createMock('Cake\Network\Request');
        $this->response = $this->createMock('Cake\Network\Response');
        $this->SidebarCell = new SidebarCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SidebarCell);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testAdmin()
    {
        $user['type'] = 'admin';
        $this->SidebarCell->display($user);
        $this->assertCount(7, $this->SidebarCell->viewVars['menu']);
    }

    public function testUser()
    {
        $user['type'] = 'user';
        $this->SidebarCell->display($user);
        $this->assertCount(1, $this->SidebarCell->viewVars['menu']);
    }

    public function testUnknown()
    {
        $user['type'] = 'unknown';
        $this->setExpectedException('Cake\Controller\Exception\AuthSecurityException');
        $this->SidebarCell->display($user);
        $this->assertCount(0, $this->SidebarCell->viewVars['menu']);
    }
}
