<?php
use Migrations\AbstractMigration;

class AddProductoptionsColumn extends AbstractMigration
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
        $table->addColumn('productoptions', 'string', [
            'null' => false,
            'default' => null,
            'after' => 'productname'
            
        ])->update();
    }
}
