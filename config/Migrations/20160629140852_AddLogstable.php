<?php
use Migrations\AbstractMigration;

class AddLogstable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('logs', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('url', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('method', 'string', [
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('request', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('response', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'limit' => null,
                'null' => false,
            ])
            ->create();
    }
}
