<?php
use Migrations\AbstractMigration;

class AlterProductoptionsChoices extends AbstractMigration
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
        $this->query(
            'UPDATE productoption_choices
            SET value="zwartwit"
            WHERE value="zwart/wit"'
        );
    }
}
