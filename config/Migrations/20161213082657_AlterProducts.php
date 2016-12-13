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
        $this->query("UPDATE `products` SET `slug` = 'afdruk_15x23' WHERE `slug` = 'afdruk_15x20'");
    }
}
