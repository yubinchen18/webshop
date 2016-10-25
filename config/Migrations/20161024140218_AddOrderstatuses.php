<?php
use Migrations\AbstractMigration;

class AddOrderstatuses extends AbstractMigration
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
            "INSERT INTO `orderstatuses` (`id`, `name`, `description`, `created`, `modified`, `deleted`) VALUES
            (UUID(), 'Betaald', 'Betaald maar nog niet verwerkt', '2016-10-24 16:27:15', '2016-10-24 16:27:15', NULL),
            (UUID(), 'Verzonden naar Photex', 'via FTP naar afdrukcentrale daar wordt de order verwerkt', '2016-10-24 16:28:55', '2016-10-24 16:28:55', NULL),
            (UUID(), 'Verzonden naar eindklant', 'Door Photex/afdrukcentrale verzonden via DHL of PostNL', '2016-10-24 16:30:32', '2016-10-24 16:30:32', NULL),
            (UUID(), 'Geannuleerd', NULL, '2016-10-24 16:30:32', '2016-10-24 16:30:32', NULL);
            "
        );
    }
}
