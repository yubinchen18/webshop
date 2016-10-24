<?php
use Migrations\AbstractMigration;

class AddPhoneToAddresses extends AbstractMigration
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
        $table->addColumn('phone', 'string', [
            'default' => null,
            'limit' => 45,
            'null' => true,
            'after' => 'lastname'
        ])
        ->addColumn('email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'after' => 'lastname'
        ])
        ->update();
    }
}
