<?php
use Migrations\AbstractMigration;

class AddOrderidToCart extends AbstractMigration
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
        $table = $this->table('carts');
        $table->addColumn('order_id', 'uuid', [
            'default' => null,
            'limit' => 36   ,
            'null' => true,
            'after' => 'user_id'
        ])
        ->update();
    }
}
