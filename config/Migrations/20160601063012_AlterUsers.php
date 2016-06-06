<?php
use Migrations\AbstractMigration;

class AlterUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->removeColumn('real_pass');
        $table->addColumn('genuine', 'varbinary', ['limit' => 200, 'after' => 'password']);
        $table->update();
    }
}
