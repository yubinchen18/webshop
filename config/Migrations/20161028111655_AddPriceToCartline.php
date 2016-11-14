<?php
use Migrations\AbstractMigration;

class AddPriceToCartline extends AbstractMigration
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
        $table->addColumn('subtotal', 'float', [
            'default' => 0,
            'limit' => 15,
            'null' => false,
            'after' => 'product_id'
        ])
        ->update();
    }
}
