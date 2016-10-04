<?php
use Migrations\AbstractMigration;

class AddCombinationSheets extends AbstractMigration
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
        $this->query("INSERT INTO `products` (`id`, `name`, `article`, `slug`, `description`, `price_ex`, `vat`, `high_shipping`, `active`, `created`, `modified`, `deleted`, `layout`, `product_group`) VALUES
            (UUID(), 'Combinatievel 05 13x19cm', 'CO005', 'af_2x69_-_4offpas', '<div>COMBINATIEVEL BESTAAT UIT</div>\r\n<div>&nbsp;</div>\r\n<div>- 2 X&nbsp;6X9 CM</div>\r\n<div>- 4&nbsp;grote pasfoto\'s&nbsp;</div>\r\n<div>&nbsp;</div>', 5.95, 21.00, NULL, 1, '2016-09-28 16:10:33', '2016-09-28 16:10:33', NULL, 'CombinationLayout5', 'combination-sheets'),
            (UUID(), 'Combinatievel 06 13x19cm', 'CO006', 'combivel_6', '<div>COMBINATIEVEL 6 BESTAAT UIT:</div>\r\n<div>&nbsp;</div>\r\n<div>2 X 6X9 CM</div>\r\n<div>8 kleine pasfoto\'s</div>', 5.95, 21.00, NULL, 1, '2016-09-28 16:10:33', '2016-09-28 16:10:33', NULL, 'CombinationLayout6', 'combination-sheets'),
            (UUID(), 'Combinatievel 07 13x19cm', 'CO007', 'combinatievel_7', '<div>Combinatievel 7 bestaat uit:</div>\r\n<div>&nbsp;</div>\r\n<div>- 1 x 6x9cm</div>\r\n<div>- 4 kleine pasfoto\'s</div>\r\n<div>- 2 grote pasfoto\'s</div>', 5.95, 21.00, NULL, 1, '2016-09-28 16:10:33', '2016-09-28 16:10:33', NULL, 'CombinationLayout7', 'combination-sheets'),
            (UUID(), 'Combinatievel 08 13x19cm', 'CO008', 'combinatievel_8', '<div>Combinatievel 8 bestaat uit:</div>\r\n<div>&nbsp;</div>\r\n<div>-&nbsp;2 kleine zwart/wit pasfoto\'s</div>\r\n<div>- 2 kleine sepia pasfoto\'s</div>\r\n<div>- 4 kleine kleuren pasfoto\'s</div>\r\n<div>- 4 grote kleuren pasfoto\'s</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>', 5.95, 21.00, NULL, 1, '2016-09-28 16:10:33', '2016-09-28 16:10:33', NULL, 'CombinationLayout8', 'combination-sheets'),
            (UUID(), 'Combinatievel 09 13x19cm', 'CO009', 'combinatievel_9', '<div>Combinatievel 9 bestaat uit:</div>\r\n<div>&nbsp;</div>\r\n<div>-&nbsp;2 x 6x9 cm &quot;design&quot; kleur</div>\r\n<div>- 1 x 6x9 cm &quot;design&quot; zwart/wit</div>\r\n<div>- 1 x 6x9 cm &quot;design&quot; sepia</div>\r\n<div>&nbsp;</div>', 5.95, 21.00, NULL, 1, '2016-09-28 16:10:33', '2016-09-28 16:10:33', NULL, 'CombinationLayout9', 'combination-sheets'),
            (UUID(), 'Combinatievel 03 13x19cm', 'CO003', 'combinatievel_3', '<div>\r\n<div><strong>Combinatievel 3 bestaat uit:</strong></div>\r\n<div>1 vel, 13x18 cm met de volgende afdrukken:</div>\r\n</div>\r\n<div>&nbsp;</div>\r\n<div>2 maal 9x13cm</div>', 5.95, 21.00, NULL, 1, '2016-09-28 15:28:50', '2016-09-28 15:28:50', NULL, 'CombinationLayout3', 'combination-sheets'),
            (UUID(), 'Combinatievel 04 13x19cm', 'CO004', 'af_9x13__2off_pas_4pasf', '<div>combinatievel 4 bestaat uit:</div>\r\n<div>&nbsp;</div>\r\n<div>1 X 9X13</div>\r\n<div>2 PASFOTO\'S GROOT</div>\r\n<div>4 PASFOTO\'S KLEIN</div>', 5.95, 21.00, NULL, 1, '2016-09-28 15:28:50', '2016-09-28 15:28:50', NULL, 'CombinationLayout4', 'combination-sheets'),
            (UUID(), 'Combinatievel 10 13x19cm', 'CO010', 'combinatievel_010', '<div>Combinatievel 10 bestaat uit:</div>\r\n<div>&nbsp;</div>\r\n<div>- 1 x 9x13 cm</div>\r\n<div>- 8 kleine pasfoto\'s</div>', 5.95, 21.00, NULL, 1, '2016-09-28 16:19:18', '2016-09-28 16:19:18', NULL, 'CombinationLayout10', 'combination-sheets'),
            (UUID(), 'Combinatievel 11 13x19cm', 'CO011', 'combinatievel_011', '<div>Combinatievel 11 bestaat uit:</div>\r\n<div>&nbsp;</div>\r\n<div>- 4 x 6x9 cm</div>', 5.95, 21.00, NULL, 1, '2016-09-28 16:19:18', '2016-09-28 16:19:18', NULL, 'CombinationLayout11', 'combination-sheets'),
            (UUID(), 'Combinatievel 01 13x19cm', 'CO001', 'combinatievel_1', '<div><strong>Combinatievel 1 bestaat uit:</strong></div>\r\n<div>1 vel, 13x18 cm met de volgende afdrukken:</div>\r\n<div>&nbsp;</div>\r\n<div>- 2 maal 6x9 kleur</div>\r\n<div>- 1 maal 4x6 zwart / wit</div>\r\n<div>- 1 maal 4x6 sepia</div>\r\n<div>- 4 pasfoto\'s</div>', 5.95, 21.00, NULL, 1, '2016-09-28 15:04:22', '2016-09-28 15:04:22', NULL, 'CombinationLayout1', 'combination-sheets'),
            (UUID(), 'Combinatievel 02 13x19cm', 'CO002', 'combinatievel_2', '<div>\r\n<div><strong>Combinatievel 2 bestaat uit:</strong></div>\r\n<div>1 vel, 13x18 cm met de volgende afdrukken:</div>\r\n<div>&nbsp;</div>\r\n</div>\r\n<div>- 1 maal 9 x 13cm</div>\r\n<div>- 7 kleine&nbsp; pasfoto\'s</div>', 5.95, 21.00, NULL, 1, '2016-09-28 15:04:22', '2016-09-28 15:04:22', NULL, 'CombinationLayout2', 'combination-sheets');");
    }
}
