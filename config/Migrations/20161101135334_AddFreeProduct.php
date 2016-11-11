<?php

use Phinx\Migration\AbstractMigration;

class AddFreeProduct extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
         $this->query(
            "INSERT INTO `products` (`id`, `name`, `article`, `slug`, `description`, `price_ex`, `vat`, `high_shipping`, `active`, `created`, `modified`, `deleted`, `layout`, `product_group`) VALUES
            (UUID(), 'GRATIS AFDRUK 13x19', 'GAF 13x19', 'gratis_afdruk_13x18', '<div>Losse afdruk 13x19 cm</div>', 0.00, 21.00, NULL, 1, '2016-11-01 15:59:48', '2016-11-01 15:59:48', NULL, 'LoosePrintLayout1', 'loose-prints');"
        );      
    }
}
