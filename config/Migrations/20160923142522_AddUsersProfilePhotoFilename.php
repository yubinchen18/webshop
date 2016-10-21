<?php
use Migrations\AbstractMigration;

class AddUsersProfilePhotoFilename extends AbstractMigration
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
        $table->addColumn('profile_photo_filename', 'string', [
            'null' => true,
            'default' => null,
            'after' => 'active'
        ])->update();
    }
}
