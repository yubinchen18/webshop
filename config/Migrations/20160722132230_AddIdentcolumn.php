<?php
use Migrations\AbstractMigration;

class AddIdentcolumn extends AbstractMigration
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
        $table = $this->table('orders');
        $table->addColumn('ident', 'string', [
            'null' => false,
            'default' => '',
            
        ])->update();
    }
}
