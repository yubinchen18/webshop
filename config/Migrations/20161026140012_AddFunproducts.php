<?php
use Migrations\AbstractMigration;

class AddFunproducts extends AbstractMigration
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
            (UUID(), 'Beer', 'FBEER', 'beer', '<div>Pluche knuffelbeer</div>', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker donkerblauw', 'FBEKER_BLAUW', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker geel', 'FBEKER_GEEL', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker groen', 'FBEKER_GROEN', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker lichtblauw', 'FBEKER_LICHTBLAUW', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker oranje', 'FBEKER_ORANJE', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker rood', 'FBEKER_ROOD', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker rose', 'FBEKER_ROSE', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker wit', 'FBEKER_WITE', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Beker zwart', 'FBEKER_ZWART', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Bierpul', 'FBIERPUL', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Cover Samsung', 'FBCOVER_SAM', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Dienblad', 'FDIENBLAD', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Etui', 'FETUI', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Hoesje iPhone', 'FHOESJEIPHONE', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Juwelendoos', 'FJUWELEN', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Kussen', 'FKUSSEN', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Leeuw', 'FLEEUW', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Lunchbox', 'FLUNCHBOX', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Muismat', 'FMUISMAT', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Muismat hart', 'FMUISMATHART', 'beker-donkerblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Onderzetters', 'FONDERZETTER', 'onderzetters', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Portemonnee groot', 'FPORTGROOT', 'portemonnee_groot', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Portemonnee klein', 'FPORTKLEIN', 'portemonnee_klein', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Puzzel', 'FPUZZEL', 'puzzel', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Puzzel hart', 'FPUZHART', 'puzzelhart', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Schort', 'FSCHORT', 'schort', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Schoudertas', 'FSCHOUDERTAS', 'schoudertas', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Slab blauw', 'FSLAB_BLAUW', 'slabblauw', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Slab roze', 'FSLAB_ROZE', 'slabroze', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Sleutelhanger', 'FSLEUTELHANGER', 'sleutelhanger', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Spaarpot', 'FSPAARPOT', 'spaarpot', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Tas', 'FTAS', 'tas', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Telefoonhoesje', 'FHOESJE', 'hoesje', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Tshirt', 'FTSHIRT', 'tshirt', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts'),
            (UUID(), 'Veldfles', 'FVELDFLES', 'veldfles', '', 15.00, 21.00, NULL, 1, NOW(), NOW(), NULL, 'FunProducts', 'funproducts');
        ");
    }
}
