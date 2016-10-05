<?php
use Migrations\AbstractMigration;

class AddUsersActive extends AbstractMigration
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
        $table->addColumn('active', 'string', [
            'null' => false,
            'default' => '1',
            'after' => 'type'
        ])->update();
    }
}
