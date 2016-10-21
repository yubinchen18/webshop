<?php
use Migrations\AbstractMigration;

class AddDiscountfilter extends AbstractMigration
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
        $table->addColumn('has_discount', 'integer', [
            'null' => true,
            'default' => '0',
            'length' => 1,
            'after' => 'price_ex'
        ])->update();
    }
}
