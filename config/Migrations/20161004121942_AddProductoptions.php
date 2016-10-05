<?php
use Migrations\AbstractMigration;

class AddProductoptions extends AbstractMigration
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
            "INSERT INTO `productoptions` (`id`, `name`, `created`, `modified`, `deleted`) VALUES
            (UUID(), 'kleurbewerking', '2016-10-04 14:17:53', '2016-10-04 14:17:53', NULL),
            (UUID(), 'uitvoering', '2016-10-04 14:17:53', '2016-10-04 14:17:53', NULL);"
        );
    }
}
