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
        $table = $this->table('orderstatuses');
        $table->addColumn('alias','string',[
            'null' => true,
            'after' => 'name',
            'length' => 80
        ])->update();
        
        $this->query(
            "INSERT INTO `orderstatuses` (`id`, `name`,`alias`, `description`, `created`, `modified`, `deleted`) VALUES
            (UUID(), 'Betaald','payment_received', 'Betaald maar nog niet verwerkt', NOW(), NOW(), NULL),
            (UUID(), 'Betaald','payment_failed', 'Betaling mislukt', NOW(), NOW(), NULL),
            (UUID(), 'Verzonden naar Photex','to_photex', 'via FTP naar afdrukcentrale daar wordt de order verwerkt', NOW(), NOW(), NULL),
            (UUID(), 'Verzonden naar eindklant','shipped_to_customer', 'Door afdrukcentrale verzonden via PostNL', NOW(), NOW(), NULL),
            (UUID(), 'Geannuleerd','cancelled', NULL, NOW(), NOW(), NULL);
            "
        );
    }
}
