<div class='row col-xs-12 cartline-row <?= $cartline->subtotal == 0 ? "free-product" : ""; ?>' id='<?= $cartline->id; ?>'>
    <div class='cartline-photo-container col-xs-2'>
        <div class='cartline-photo'>
            <div class="<?= $cartline->photo->orientationClass.' '.$cartline->photo->orientationClass.'-background' ?>">
            </div>
            <?= $this->Html->image($this->Url->build([
                'controller' => 'Photos',
                'action' => 'displayProduct',
                'layout' => $cartline->product->layout,
                'id' => $cartline->photo_id,
                'suffix' => $cartline->product->image['suffix'],
            ]), [
                'alt' => $cartline->photo->path,
                'url' => ['controller' => 'Photos', 'action' => 'view', $cartline->photo_id],
                'class' => [$cartline->photo->orientationClass, 'img-responsive']
            ]); ?>
        </div>
    </div>
    <div class='cartline-product-details col-xs-4'>
        <div class='cartline-product-name'><b><?= $cartline->product->name; ?></b></div>
        <?php if ($cartline->product->article === 'GAF 13x19') : ?>
            <p>
                <?= $this->Html->link(
                        __('Wijzig keuze'),
                        'photos/changefreegroupspicture/'.$cartline->gift_for.'/'.$cartline->id
                )?>
            </p>
        <?php endif; ?>
        <?php if (!empty($cartline->cartline_productoptions)): ?>
            <div class='cartline-product-options'>
                <span><?= __('Opties:');?></span>
                <ul>
                    <?php foreach ($cartline->cartline_productoptions as $option): ?>
                        <li><?= $option->productoption_choice->productoption->name; ?>: 
                        <?= $option->productoption_choice->value; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <div class='cartline-product-quantity col-xs-2'>
        <div class="quantity-container">
            <div class="row">
                <div class="col-xs-11">
                    <?= $cartline->quantity; ?>
                </div>
            </div>
        </div>
    </div>

    <div class='cartline-product-unitPrice col-xs-2'>
        <?php if($cartline->product->has_discount == 1 && 
                 $cartline->quantity > 1 &&
                 $cartline->product->price_ex != $cartline->discountPrice
                ): ?>
        <span class='quantity-<?= $cartline->id; ?>'></span>
            <div class='normalprice'>1 x <?= $this->Number->currency($cartline->product->price_ex, 'EUR'); ?></div>
            <div class='discountprice'><?= $cartline->quantity-1; ?> x <?= $this->Number->currency($cartline->discountPrice, 'EUR'); ?></div>
        <?php else: ?>
        <span class='quantity-<?= $cartline->id; ?>'><?= $cartline->quantity; ?></span>
        <span> x <?= $this->Number->currency($cartline->product->price_ex, 'EUR'); ?></span>
        <?php endif; ?>
    </div>

    <div class='cartline-product-price col-xs-1'>
        <span><?= __('€ '); ?><span class='price-<?= $cartline->id; ?> cartline-subtotal'>
            <?= $this->Number->format($cartline->subtotal, [
                'places' => 2
            ]); ?>
        </span></span>
    </div>
</div>