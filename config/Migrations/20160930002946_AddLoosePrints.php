<?php
use Migrations\AbstractMigration;

class AddLoosePrints extends AbstractMigration
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
        $this->query("
            INSERT INTO `products` (`id`, `name`, `article`, `slug`, `description`, `price_ex`, `vat`, `high_shipping`, `active`, `created`, `modified`, `deleted`, `layout`, `product_group`) VALUES
            (UUID(), 'AFDRUK 20X30', 'AF 20X30', 'afdruk_20x30', '<div>FOTOAFDRUK OP HET FORMAAT 20 X 30XM</div>', 15.00, 21.00, NULL, 1, '2016-09-29 16:36:56', '2016-09-29 16:36:56', NULL, 'LoosePrintLayout1', 'loose-prints'),
            (UUID(), 'AFDRUK 30X45', 'AF 30X45', 'afdruk_30x45', '<div>FOTOAFDRUK OP HET FORMAAT 30X45 CM.</div>', 22.00, 21.00, NULL, 1, '2016-09-29 16:36:56', '2016-09-29 16:36:56', NULL, 'LoosePrintLayout1', 'loose-prints'),
            (UUID(), 'AFDRUK 50X75', 'AF 50X75', 'afdruk_50x75', '<div>\r\n<div>FOTOAFDRUK OP HET FORMAAT&nbsp;50X75 CM.</div>\r\n</div>', 59.50, 21.00, NULL, 1, '2016-09-29 16:44:27', '2016-09-29 16:44:27', NULL, 'LoosePrintLayout1', 'loose-prints'),
            (UUID(), 'AFDRUK 10x15', 'AF 10x15', 'afdruk_10x15', '<div>\r\n<div>Losse afdruk 10x15 cm</div>\r\n</div>', 3.95, 21.00, NULL, 1, '2016-09-29 16:44:27', '2016-09-29 16:44:27', NULL, 'LoosePrintLayout1', 'loose-prints'),
            (UUID(), 'AFDRUK 40X60', 'AF 40X60', 'afdruk_40x60', '<div>\r\n<div>FOTOAFDRUK OP HET FORMAAT&nbsp;40X60 CM.</div>\r\n</div>', 39.00, 21.00, NULL, 1, '2016-09-29 16:19:24', '2016-09-29 16:19:24', NULL, 'LoosePrintLayout1', 'loose-prints'),
            (UUID(), 'AFDRUK 15X23', 'AF 15X23', 'afdruk_15x20', '<div>FOTOAFDRUK OP HET FORMAAT 15 X 23</div>', 8.95, 21.00, NULL, 1, '2016-09-29 16:19:24', '2016-09-29 16:19:24', NULL, 'LoosePrintLayout1', 'loose-prints'),
            (UUID(), 'AFDRUK 13x19', 'AF 13x19', 'afdruk_13x18', '<div>Losse afdruk 13x19 cm</div>', 5.95, 21.00, NULL, 1, '2016-09-29 15:59:48', '2016-09-29 15:59:48', NULL, 'LoosePrintLayout1', 'loose-prints');
        ");
    }
}
