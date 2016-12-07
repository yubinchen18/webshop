<?php
use Migrations\AbstractMigration;

class AddSchoolsTurnover extends AbstractMigration
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
        $table = $this->table('projects');
        $table->addColumn('turnover', 'decimal', [
            'null' => true,
            'limit' => 10,
            'default' => null,
            'after' => 'grouptext'
        ])->update();
    }
}
