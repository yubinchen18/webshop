<?php
use Migrations\AbstractMigration;

class AlterUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->removeColumn('real_pass');
        $table->update();

        $this->execute('ALTER TABLE `users` ADD `genuine` VARBINARY(200) NOT NULL AFTER `password`;');
        $this->execute('INSERT INTO `users` (`id`, `username`, `password`, `genuine`, `email`, `type`, `created`,
            `modified`, `deleted`, `address_id`) VALUES ("35e9eddf-8a7c-43ee-aa40-0a152e71f5a5", "xseeding",
            "$2y$10$ql6zl5mZkctVrhudVqy4VO/dkcGcJf59XxvaXRaHawgb87qx4tMWK",
                0x636663306630396338643537663337343631386262646434366165323933623032653534333563626136656265393332353139343231646163393965643432640f2dedc52d20b490b783cc703aeb224f2bff14b3af74a7970c68b67b47ce1362,
                "support@xseeding.nl", "admin", "2016-06-06 09:48:59", "2016-06-06 09:48:59", NULL, NULL);');
    }
}
