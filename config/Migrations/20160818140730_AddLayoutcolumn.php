<?php
use Migrations\AbstractMigration;

class AddLayoutcolumn extends AbstractMigration
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
        $table = $this->table('products');
        $table->addColumn('layout', 'string', [
            'null' => false,
            'default' => '',
            'after' => 'active'
            
        ])->update();
    }
}
