<?php
use Migrations\AbstractMigration;

class AddCanvas extends AbstractMigration
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
            (UUID(), 'Canvas 20x30cm', 'C 20X30', 'canvas_20x30', '<div>\r\n<div>FOTO AFDRUK VAN 20x30 CM</div>\r\n<div>OP CANVAS, GESPANNEN OP EEN HOUTEN FRAME VAN 2 CM.</div>\r\n<div>GEREED OM GELIJK OP TE HANGEN!!</div>\r\n</div>', 24.95, 21.00, NULL, 1, '2016-09-30 03:08:10', '2016-09-30 03:08:10', NULL, 'LoosePrintLayout1', 'canvas'),
            (UUID(), 'Canvas 30x45cm', 'C 30X45', 'canvas_30x40', '<div>FOTO AFDRUK VAN 30 X 45 CM</div>\r\n<div>OP CANVAS, GESPANNEN OP EEN HOUTEN FRAME VAN 2 CM.</div>\r\n<div>GEREED OM GELIJK OP TE HANGEN!!</div>', 29.50, 21.00, NULL, 1, '2016-09-30 03:01:08', '2016-09-30 03:01:08', NULL, 'LoosePrintLayout1', 'canvas'),
            (UUID(), 'Canvas 40x60cm', 'C 40X60', 'canvas_40x60', '<div>FOTOAFDRUK OP CANVAS</div>\r\n<div>OP HET FORMAAT 40 X 60 CM, GESPANNEN OP HOUTEN</div>\r\n<div>FRAME VAN 2 CM. GEREED OM GELIJK OP TE HANGEN!!</div>', 49.50, 21.00, NULL, 1, '2016-09-30 03:01:08', '2016-09-30 03:01:08', NULL, 'LoosePrintLayout1', 'canvas'),
            (UUID(), 'Canvas 50x75cm', 'C 50X75', 'canvas_50x75', '<div>FOTOAFDRUK OP CANVAS</div>\r\n<div>OP HET FORMAAT 50 X 75 CM, GESPANNEN OP HOUTEN FRAME</div>\r\n<div>VAN 2 CM. GEREED OM GELIJK</div>\r\n<div>OP TE HANGEN!!</div>', 69.50, 21.00, NULL, 1, '2016-09-30 03:08:10', '2016-09-30 03:08:10', NULL, 'LoosePrintLayout1', 'canvas'),
            (UUID(), 'Canvas 60x90cm', 'C 60X90', 'canvas_60x90', '<div>FOTOAFDRUK OP CANVAS</div>\r\n<div>OP HET FORMAAT 60 X 90 CM, GESPANNEN OP HOUTEN</div>\r\n<div>FRAME VAN 2 CM. GEREED OM</div>\r\n<div>GELIJK OP TE HANGEN!!</div>', 94.50, 21.00, NULL, 1, '2016-09-30 03:08:10', '2016-09-30 03:08:10', NULL, 'LoosePrintLayout1', 'canvas'),
            (UUID(), 'Canvas 70x100cm', 'C 70x100', 'canvas_70x100', '<div>.</div>', 129.00, 21.00, NULL, 1, '2016-09-30 03:08:10', '2016-09-30 03:08:10', NULL, 'LoosePrintLayout1', 'canvas');"
        );
    }
}
