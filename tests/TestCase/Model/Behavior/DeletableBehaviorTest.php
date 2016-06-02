<?php
namespace App\Test\TestCase\Model\Behavior;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use App\Model\Behavior\DeletableBehavior;

/**
 * Portable\Model\Behavior\DeletableBehavior Test Case
 */
class DeletableBehaviorTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = ['app.users'];

    /**
     * Setup the test case, backup the static object values so they can be restored.
     * Specifically backs up the contents of Configure and paths in App if they have
     * not already been backed up.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Users = TableRegistry::get('Users');
    }

    public function testDelete()
    {
        $entity = $this->Users->find()->first();
        $this->assertEmpty($entity->deleted);
        $this->Users->delete($entity);
        $this->assertNotEmpty($entity->deleted);
        $this->assertInstanceOf('Cake\I18n\Time', $entity->deleted);
    }

    public function testDeleteReturnsFalseIfSaveFails()
    {
        $table = $this->getMockBuilder('\App\Model\Table\UsersTable')
            ->setMethods(['save'])
            ->getMock();
        $table->method('save')
            ->willReturn(false);
        $behavior = new DeletableBehavior($table);

        $entity = $this->Users->find()->first();

        $options = new \ArrayObject();
        $eventData = compact('entity', 'options');
        $event = new Event('Model.beforeDelete', $this->Users, $eventData);
        $this->assertFalse($behavior->beforeDelete($event, $entity, $options));
    }

    public function testFind()
    {
        $entity = $this->Users->find()->first();
        $this->Users->delete($entity);
        $entities = $this->Users->find()->toArray();
        $this->assertCount(1, $entities);
    }

    public function testFindWithDeleted()
    {
        $entity = $this->Users->find()->first();
        $this->Users->delete($entity);
        $entities = $this->Users->find('all', ['withDeleted' => true])->toArray();
        $this->assertCount(2, $entities);
    }

    public function testRestore()
    {
        $entity = $this->Users->find()->first();
        $this->assertEmpty($entity->deleted);
        $this->Users->delete($entity);
        $this->assertNotEmpty($entity->deleted);
        $this->assertInstanceOf('Cake\I18n\Time', $entity->deleted);
        $this->Users->restore($entity->id);
        $entity = $this->Users->find()->first();
        $this->assertEmpty($entity->deleted);
    }

    /**
     * teardown any static object changes and restore them.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->behavior);
    }
}
