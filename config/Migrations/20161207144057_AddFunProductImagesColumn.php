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
        
        $this->query("UPDATE `products` SET `image` = 'DSC_0479.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEER'");
        $this->query("UPDATE `products` SET `image` = 'Img117860.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_BLAUW'");
        $this->query("UPDATE `products` SET `image` = 'Img117857.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_GEEL'");
        $this->query("UPDATE `products` SET `image` = 'Img117848.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_ROZE'");
        $this->query("UPDATE `products` SET `image` = 'Img117854.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBEKER_WITE'");
        $this->query("UPDATE `products` SET `image` = 'Img117864.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FBIERPUL'");
        $this->query("UPDATE `products` SET `image` = 'Img117958.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FDIENBLAD'");
        $this->query("UPDATE `products` SET `image` = 'Img117898.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FETUI'");
        $this->query("UPDATE `products` SET `image` = 'Img117782.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FKUSSEN'");
        $this->query("UPDATE `products` SET `image` = 'Img117702.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FLUNCHBOX'");
        $this->query("UPDATE `products` SET `image` = 'Img117977.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FMUISMAT'");
        $this->query("UPDATE `products` SET `image` = 'Img118054.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FONDERZETTER'");
        $this->query("UPDATE `products` SET `image` = 'Img117883.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FJUWELEN'");
        $this->query("UPDATE `products` SET `image` = 'Img118013.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPORTLEDER'");
        $this->query("UPDATE `products` SET `image` = 'Img117913.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPORTBLUE'");
        $this->query("UPDATE `products` SET `image` = 'Img117933.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPUZZEL'");
        $this->query("UPDATE `products` SET `image` = 'Img117941.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPUZZEL120'");
        $this->query("UPDATE `products` SET `image` = 'Img117942.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPUZZEL252'");
        $this->query("UPDATE `products` SET `image` = 'Img118009.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FTASGROOT'");
        $this->query("UPDATE `products` SET `image` = 'Img117924.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLAB_BLAUW'");
        $this->query("UPDATE `products` SET `image` = 'Img117925.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLAB_ROZE'");
        $this->query("UPDATE `products` SET `image` = 'Img117725.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLEUTELHANGER'");
        $this->query("UPDATE `products` SET `image` = 'Img117999.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FTAS'");
        $this->query("UPDATE `products` SET `image` = 'DSC_0522.jpg' WHERE `product_group` = 'funproducts' AND `article` LIKE 'FTSHIRT%'");
        $this->query("UPDATE `products` SET `image` = 'Img117713.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FKNUFSLEUTELH'");
        $this->query("UPDATE `products` SET `image` = 'Img118057.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLEUTEL_FOTO_RND'");
        $this->query("UPDATE `products` SET `image` = 'Img117903.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FSLEUTEL_FOTO_HRT'");
        $this->query("UPDATE `products` SET `image` = 'Img117969.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FIPAD_HOES'");
        $this->query("UPDATE `products` SET `image` = 'Img117987.jpg' WHERE `product_group` = 'funproducts' AND `article` = 'FPLACEMAT'");
        
    }
}
