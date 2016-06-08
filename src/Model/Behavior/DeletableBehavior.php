<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Event\Event;
use Cake\i18n\Time;

/**
 * Deletable behavior
 */
class DeletableBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'column' => 'deleted',
    ];

    /**
     *
     * @var type
     */
    protected $table;

    public function __construct(Table $table, array $config = [])
    {
        $this->table = $table;
        $this->config($config);
    }

    /**
     *
     * @param \Cake\Event\Event $event
     * @param \Cake\ORM\Entity $entity
     * @param array $options
     */
    public function beforeDelete(Event $event, Entity $entity, \ArrayObject $options)
    {
        $event->stopPropagation();

        $entity->set($this->config('column'), Time::now());

        if ($this->table->save($entity, ['validate' => false])) {
            $this->table->associations()->cascadeDelete(
                $entity,
                ['_primary' => false] + $options->getArrayCopy()
            );

            return true;
        }

        return false;
    }

    /**
     *
     * @param \Cake\Event\Event $event
     * @param \Cake\ORM\Query $query
     * @param array $options
     */
    public function beforeFind(Event $event, Query $query, \ArrayObject $options)
    {
        if (isset($options['withDeleted']) === false || $options['withDeleted'] !== true) {
            $query->where([sprintf('%s IS', $this->column()) => null]);
        }
    }

    public function restore($id)
    {
        $entity = $this->table->get($id, ['withDeleted' => true]);
        $entity->set($this->config('column'), null);

        return $this->table->save($entity);
    }

    private function column()
    {
        return sprintf('%s.%s', $this->table->alias(), $this->config('column'));
    }
}
