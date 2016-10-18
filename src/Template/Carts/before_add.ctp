<div>
    <div class='addToCartPopup' id='<?= $cartlineData['product_id'];?>'>
        <div class='addToCartPopup-header' data-price=<?= $cartlineData['product_price']; ?>>
            <?= __('Totaal: €');?><span><?= $this->Number->format($cartlineData['product_price'], ['places' => 2]); ?></span>
        </div>
        <div class='addToCartPopup-body'>
            <div class='addToCartPopup-body-quantity'>
                <div class='addToCartPopup-minus'>
                    <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-20.png', [
                        'class' => ['img-responsive']
                    ]); ?>
                </div>
                <div class='addToCartPopup-quantity'>
                    <span class='addToCartPopup-quantity-top'><?= __('aantal'); ?></span>
                    <span class='addToCartPopup-quantity-bottom'>1</span>
                </div>
                <div class='addToCartPopup-plus'>
                    <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', [
                        'class' => ['img-responsive']
                    ]); ?>
                </div>
            </div>
            <div class='addToCartPopup-properties'>
                <div class='addToCartPopup-product'>
                    <div class='addToCartPopup-labels'><?= __('Product:') ?></div>
                    <div><?= $cartlineData['product_name']; ?></div>
                </div>
                <?php if (key_exists('product_options', $cartlineData) && !empty($cartlineData['product_options'])): ?>
                    <?php foreach ($cartlineData['product_options'] as $productOption) : ?>
                    <div class='addToCartPopup-options'>
                        <div class='addToCartPopup-labels'><?= $productOption['name'].':' ?></div>
                        <div class='addToCartPopup-icons'>
                            <?= $this->Html->image($productOption['icon']); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class='addToCartPopup-addButton' data-cartline='<?= json_encode($cartlineData); ?>'>
                    <?= __('VOEG TOE'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class='addToCartPopup-layer'>
    </div>
</div>
