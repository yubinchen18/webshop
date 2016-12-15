<?php
use Migrations\AbstractMigration;

class AlterProducts extends AbstractMigration
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
        $this->query(
            "UPDATE `products` SET `slug` = 'afdruk_15x23' WHERE `slug` = 'afdruk_15x20';"
            ."UPDATE `products` SET `price_ex` = '17.50' WHERE `slug` = 'digital_1';"
            ."UPDATE `products` SET `price_ex` = '45' WHERE `slug` = 'digital_pack';"
            ."UPDATE `products` SET `high_shipping` = '1' WHERE `slug` = 'afdruk_30x45';"
            ."UPDATE `products` SET `high_shipping` = '1' WHERE `slug` = 'afdruk_50x75';"
            ."UPDATE `products` SET `high_shipping` = '1' WHERE `slug` = 'afdruk_40x60';"
        );
    }
}
