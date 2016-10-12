<?php
use Migrations\AbstractMigration;

class AddOptionHashColumn extends AbstractMigration
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
        $table = $this->table('cartlines');
        $table->addColumn('options_hash', 'string', [
            'null' => false,
            'default' => '',
            'after' => 'quantity'
        ])->update();
    }
}
