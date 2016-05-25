<?php
use Migrations\AbstractMigration;

class BasicauthUser extends AbstractMigration
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
                'INSERT INTO `users` (`id`,`username`,`password`,`real_pass`,`email`,`type`,`created`,`modified`) '
                . 'VALUES '
                . '('
                . 'UUID(),'
                . '"hoogstraten",'
                . '"$2y$10$dBK/7unj8TKx3amOUJjui.ImChzUBZTDYLFPtQuso3KMpsrbPQQZy",'
                . '"staging",'
                . '"admin@xseeding.nl",'
                . '"basic",'
                . 'NOW(),'
                . 'NOW()'
                . ')'
            );
    }
}
