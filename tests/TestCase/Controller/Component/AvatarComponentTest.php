<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\AvatarComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\AvatarComponent Test Case
 */
class AvatarComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\AvatarComponent
     */
    public $Avatar;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Avatar = new AvatarComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Avatar);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
