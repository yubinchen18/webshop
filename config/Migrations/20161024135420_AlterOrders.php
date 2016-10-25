<?php
use Migrations\AbstractMigration;

class AlterOrders extends AbstractMigration
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
        
        $table->changeColumn('created', 'datetime', [
            'limit' => null,
            'null' => false,
        ])
        ->changeColumn('modified', 'datetime', [
            'limit' => null,
            'null' => false,
        ])
        ->changeColumn('deleted', 'datetime', [
            'default' => null,
            'limit' => null,
            'null' => true,
        ])
        ->addColumn('payment_method', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
        ->update();
    }
}
