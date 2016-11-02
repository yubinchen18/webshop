<?php
use Migrations\AbstractMigration;

class AddDigital extends AbstractMigration
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
            "INSERT INTO `products` (`id`, `name`, `article`, `slug`, `description`, `price_ex`, `vat`, `high_shipping`, `active`, `created`, `modified`, `deleted`, `layout`, `product_group`) VALUES
            (UUID(), 'DIGITAAL LOS', 'D1', 'digital_1', '<div>\r\n<div>DIGITAAL AFDRUK</div>\r\n<div>DIGITAAL, 1 BEELD.</div>\r\n<div>GEREED OM GELIJK TE DOWNLOADEN!!</div>\r\n</div>', 9.75, 21.00, NULL, 1, '2016-09-30 03:08:10', '2016-09-30 03:08:10', NULL, 'LoosePrintLayout1', 'digital'),
            (UUID(), 'DIGITAAL ALLES', 'DPack', 'digital_pack', '<div><strong>Digitaal alles bestaat uit:</strong></div>\r\n<div>Alle foto\'s digitaal, behalve de groepfoto\'s en dat voor een standaard prijs.</div>', 35.00, 21.00, NULL, 1, '2016-09-28 15:04:22', '2016-09-28 15:04:22', NULL, 'LoosePrintLayout1', 'digital');"
        );
    }
}
