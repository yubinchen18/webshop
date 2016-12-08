<?php
use Migrations\AbstractMigration;

class AddFunProductImagesColumn extends AbstractMigration
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
        $table = $this->table('products');
        $table->addColumn('image', 'string', [
            'limit' => 45,
            'null' => true,
            'default' => '',
            'after' => 'description'
        ])->update();
        
        $this->query("UPDATE `products` SET `image` = 'FBEER.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEER'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_BLAUW.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_BLAUW'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_GEEL.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_GEEL'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_GROEN.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_GROEN'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_LICHTBLAUW.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_LICHTBLAUW'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_ORANJE.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_ORANJE'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_ROOD.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_ROOD'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_ROSE.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_ROSE'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_WITE.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_WITE'");
        $this->query("UPDATE `products` SET `image` = 'FBEKER_ZWART.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_ZWART'");
        $this->query("UPDATE `products` SET `image` = 'FBIERPUL.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBIERPUL'");
        $this->query("UPDATE `products` SET `image` = 'FBCOVER_SAM.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBCOVER_SAM'");
        $this->query("UPDATE `products` SET `image` = 'FDIENBLAD.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FDIENBLAD'");
        $this->query("UPDATE `products` SET `image` = 'FETUI.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FETUI'");
        $this->query("UPDATE `products` SET `image` = 'FHOESJEIPHONE.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FHOESJEIPHONE'");
        $this->query("UPDATE `products` SET `image` = 'FJUWELEN.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FJUWELEN'");
        $this->query("UPDATE `products` SET `image` = 'FKUSSEN.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FKUSSEN'");
        $this->query("UPDATE `products` SET `image` = 'FLEEUW.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FLEEUW'");
        $this->query("UPDATE `products` SET `image` = 'FLUNCHBOX.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FLUNCHBOX'");
        $this->query("UPDATE `products` SET `image` = 'FMUISMAT.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FMUISMAT'");
        $this->query("UPDATE `products` SET `image` = 'FMUISMATHART.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FMUISMATHART'");
        $this->query("UPDATE `products` SET `image` = 'FONDERZETTER.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FONDERZETTER'");
        $this->query("UPDATE `products` SET `image` = 'FPORTGROOT.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPORTGROOT'");
        $this->query("UPDATE `products` SET `image` = 'FPORTKLEIN.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPORTKLEIN'");
        $this->query("UPDATE `products` SET `image` = 'FPUZZEL.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPUZZEL'");
        $this->query("UPDATE `products` SET `image` = 'FPUZHART.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPUZHART'");
        $this->query("UPDATE `products` SET `image` = 'FSCHORT.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSCHORT'");
        $this->query("UPDATE `products` SET `image` = 'FSCHOUDERTAS.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSCHOUDERTAS'");
        $this->query("UPDATE `products` SET `image` = 'FSLAB_BLAUW.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLAB_BLAUW'");
        $this->query("UPDATE `products` SET `image` = 'FSLAB_ROZE.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLAB_ROZE'");
        $this->query("UPDATE `products` SET `image` = 'FSLEUTELHANGER.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLEUTELHANGER'");
        $this->query("UPDATE `products` SET `image` = 'FSPAARPOT.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSPAARPOT'");
        $this->query("UPDATE `products` SET `image` = 'FTAS.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FTAS'");
        $this->query("UPDATE `products` SET `image` = 'FHOESJE.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FHOESJE'");
        $this->query("UPDATE `products` SET `image` = 'FTSHIRT.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FTSHIRT'");
        $this->query("UPDATE `products` SET `image` = 'FVELDFLES.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FVELDFLES'");
        
    }
}
