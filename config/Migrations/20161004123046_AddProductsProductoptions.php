<?php
use Migrations\AbstractMigration;

class AddProductsProductoptions extends AbstractMigration
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
            "INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), (SELECT `id` FROM `products` WHERE `article` = 'AF 10x15' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), (SELECT `id` FROM `products` WHERE `article` = 'AF 10x15' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), (SELECT `id` FROM `products` WHERE `article` = 'AF 13x19' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), (SELECT `id` FROM `products` WHERE `article` = 'AF 13x19' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), (SELECT `id` FROM `products` WHERE `article` = 'AF 15X23' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), (SELECT `id` FROM `products` WHERE `article` = 'AF 15X23' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), (SELECT `id` FROM `products` WHERE `article` = 'AF 20X30' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), (SELECT `id` FROM `products` WHERE `article` = 'AF 20X30' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), (SELECT `id` FROM `products` WHERE `article` = 'AF 30X45' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), (SELECT `id` FROM `products` WHERE `article` = 'AF 30X45' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), (SELECT `id` FROM `products` WHERE `article` = 'AF 40X60' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), (SELECT `id` FROM `products` WHERE `article` = 'AF 40X60' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'kleurbewerking'), (SELECT `id` FROM `products` WHERE `article` = 'AF 50X75' ), UUID());

            INSERT INTO `products_productoptions` 
            (`productoption_id`, `product_id`, `id`) VALUES
            ((SELECT `id` FROM `productoptions` WHERE `name` = 'uitvoering'), (SELECT `id` FROM `products` WHERE `article` = 'AF 50X75' ), UUID());"
        );
    }
}
