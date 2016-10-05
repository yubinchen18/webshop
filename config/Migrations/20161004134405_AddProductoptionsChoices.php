<?php
use Migrations\AbstractMigration;

class AddProductoptionsChoices extends AbstractMigration
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
            "INSERT INTO `productoption_choices` 
            (`id`, `productoption_id`, `value`, `created`, `modified`) VALUES
            (UUID(), (SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), ('geen'), now(), now());

            INSERT INTO `productoption_choices` 
            (`id`, `productoption_id`, `value`, `created`, `modified`) VALUES
            (UUID(), (SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), ('zwart/wit'), now(), now());

            INSERT INTO `productoption_choices` 
            (`id`, `productoption_id`, `value`, `created`, `modified`) VALUES
            (UUID(), (SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), ('sepia'), now(), now());

            INSERT INTO `productoption_choices` 
            (`id`, `productoption_id`, `value`, `created`, `modified`) VALUES
            (UUID(), (SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), ('speciaal'), now(), now());

            INSERT INTO `productoption_choices` 
            (`id`, `productoption_id`, `value`, `created`, `modified`) VALUES
            (UUID(), (SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), ('glans'), now(), now());

            INSERT INTO `productoption_choices` 
            (`id`, `productoption_id`, `value`, `created`, `modified`) VALUES
            (UUID(), (SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), ('mat'), now(), now());"
        );
    }
}
