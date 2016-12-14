<?php
use Migrations\AbstractMigration;

class AddDiscountColumn extends AbstractMigration
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
        $table->addColumn('discount', 'float', [
            'default' => null,
            'null' => true,
            'precision' => 9,
            'scale' => 2,
            'after' => 'product_id'
        ])->update();
    }
}
