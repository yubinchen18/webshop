<?php
use Migrations\AbstractMigration;

class AlterDefaultfields extends AbstractMigration
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
        $table = $this->table('addresses');
        $table->changeColumn('gender', 'string', [
            'default' => null,
            'null' => true
        ])
        ->update();

        $table = $this->table('schools');
        $table->changeColumn('address_id', 'uuid', [
            'default' => null,
            'null' => true
        ])
        ->update();
    }
}
