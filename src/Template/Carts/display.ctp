<div class="row">
    <!-- left panel -->
    <div class="cart-cartlines-index col-md-9">
        <h2><?= __('Winkelwagen');?></h2>
        
        <?=$this->Form->create(null, ['class' => 'orderForm', 'url' => '/'.__('cart').'/'.__('add')]); ?>
        <div class='row col-md-12 col-xs-12'>
            <div class='cartlines-header col-xs-3'><?= __('Foto'); ?></div>
            <div class='cartlines-header col-xs-3'><?= __('Product detail'); ?></div>
            <div class='cartlines-header col-xs-2'><?= __('Aantal'); ?></div>
            <div class='cartlines-header col-xs-2'><?= __('Stukprijs'); ?></div>
            <div class='cartlines-header col-xs-1'><?= __('Prijs'); ?></div>
            <div class='cartlines-header col-xs-1'><?= __('Wis'); ?></div>
            
            <?php if (!empty($cart->cartlines)): ?>
                <?php foreach($cart->cartlines as $cartline): ?>
                    <div class='row col-xs-12 cartline-row' id='<?= $cartline->id; ?>'>
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
                        <div class='cartline-product-details col-xs-3'>
                            <div class='cartline-product-name'><b><?= $cartline->product->name; ?></b></div>
                            <?php if (!empty($cartline->cartline_productoptions)): ?>
                                <div class='cartline-product-options'>
                                    <span><?= __('Options:');?></span>
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
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                  -
                                                </button>
                                            </span>
                                            <input type="text" id="quantity-<?= $cartline->id; ?>" name="quantity-<?= $cartline->id; ?>" 
                                                class="form-control input-number" value='<?= $cartline->quantity; ?>' min="1" max="100"
                                                data-id='<?= $cartline->id; ?>' data-unitprice='<?= $cartline->product->price_ex;?>'>
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                    +
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class='cartline-product-unitPrice col-xs-2'>
                            <?php if($cartline->product->has_discount == 1 && $cartline->quantity > 1): ?>
                            <span class='quantity-<?= $cartline->id; ?>'></span>
                                <div class='normalprice'>1 x <?= $this->Number->currency($cartline->product->price_ex, 'EUR'); ?></div>
                                <div class='discountprice'><?= $cartline->quantity-1; ?> x <?= $this->Number->currency($cartline->discountprice, 'EUR'); ?></div>
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
                        
                        <div class="cartline-close col-xs-1">
                            <span class='close'>&times;</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            
                <!-- Summary -->
                <div class='order-summary col-sm-12'>
                    <div class='row'>
                        <div class='order-summary-block'>
                            <div class='row'>
                                <div class='order-subtotal col-sm-offset-6 col-sm-6'>
                                    <div class='row'>
                                        <div class='col-sm-8'><?= __('Subtotaal: '); ?></div>
                                        <div class='col-sm-4'>
                                            <span><?= __('€ '); ?><span class='price-<?= $cartline->id; ?>' id='order-subtotal'>
                                                <?= $this->Number->format($orderSubtotal, [
                                                    'places' => 2
                                                ]); ?>
                                            </span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class='order-costs col-sm-offset-6 col-sm-6'>
                                    <div class='row'>
                                        <div class='col-sm-8'><?= __('Verwerkingskosten: '); ?></div>
                                        <div class='col-sm-4'>
                                            <span><?= __('€ '); ?><span id='order-shippingcosts'>
                                                <?= $this->Number->format($shippingCost, [
                                                    'places' => 2
                                                ]); ?>
                                            </span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class='order-total col-sm-offset-6 col-sm-6'>
                                    <div class='row'>
                                        <b>
                                            <div class='col-sm-8'><?= __('Totaal: '); ?></div>
                                            <div class='col-sm-4'>
                                                <span><?= __('€ '); ?><span id='order-total'>
                                                    <?= $this->Number->format($orderTotal, [
                                                        'places' => 2
                                                    ]); ?>
                                                </span></span>
                                            </div>
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-sm-3 '>
                            <a href="/photos" class="btn btn-default" type="button"><?=__('Naar foto-overzicht'); ?></a>
                        </div>
                        <div class='order-place-order col-sm-3 col-sm-offset-6'>
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="submit"><?=__('Gegevens invullen en betalen'); ?></button>
                            </span>
                        </div>
                    </div>
                </div>
            
            <?php else: ?>
                <div>
                    <h3><?= __('Uw winkelwagen is leeg'); ?></h3>
                </div>
            <?php endif; ?>
        </div>
        <?=$this->Form->end();?>
    </div>
    <!-- right panel -->
    <div class="cart-order-details col-md-3 hidden-sm hidden-xs">
        
        
        
    </div>
</div>
