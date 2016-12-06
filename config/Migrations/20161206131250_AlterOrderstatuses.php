<?php
use Migrations\AbstractMigration;

class AlterOrderstatuses extends AbstractMigration
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
        $table = $this->table('orderstatuses');
        $table->update();
        $this->query(
            "TRUNCATE TABLE orderstatuses"
        );
        $this->query(
            "INSERT INTO `orderstatuses` (`id`, `name`, `alias`, `description`, `created`, `modified`, `deleted`) VALUES
            (UUID(), 'Verzonden naar Photex', 'sent_to_photex', 'via FTP naar afdrukcentrale daar wordt de order verwerkt', NOW(), NOW(), NULL),
            (UUID(), 'Verzonden naar eindklant', 'sent_to_customer', 'Door afdrukcentrale verzonden via PostNL', NOW(), NOW(), NULL),
            (UUID(), 'Nieuw', 'new', 'Betaald maar nog niet verwerkt', NOW(), NOW(), NULL),
            (UUID(), 'Betaald', 'payment_received', 'Betaald maar nog niet verwerkt', NOW(), NOW(), NULL),
            (UUID(), 'Betaling mislukt', 'payment_failed', 'Betaling mislukt', NOW(), NOW(), NULL),
            (UUID(), 'Geannuleerd', 'cancelled', 'Order geannuleerd', NOW(), NOW(), NULL);"
        );
    }
}
