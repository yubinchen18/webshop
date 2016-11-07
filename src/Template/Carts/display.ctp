<div class="row">
    <!-- left panel -->
    <div class="cart-cartlines-index col-md-9">
        <h2><?= __('Winkelwagen');?></h2>
        <?=$this->Form->create(null, ['class' => 'orderForm', 'url' => '/carts/orderInfo']); ?>
        <div class='row col-md-12 col-xs-12'>
            <div class='cartlines-header col-xs-3'><?= __('Foto'); ?></div>
            <div class='cartlines-header col-xs-3'><?= __('Product detail'); ?></div>
            <div class='cartlines-header col-xs-2'><?= __('Aantal'); ?></div>
            <div class='cartlines-header col-xs-2'><?= __('Stukprijs'); ?></div>
            <div class='cartlines-header col-xs-1'><?= __('Prijs'); ?></div>
            <div class='cartlines-header col-xs-1'><?= __('Wis'); ?></div>
            <?php if (!empty($cart->cartlines)): ?>        
                <?php foreach($cart->cartlines as $cartline): ?>
                    <?php if (!$cartline->gift_for): ?>
                        <?= $this->element('Cart/cartline', ['cartline' => $cartline]); ?>
                        <?php if($cartline->product->article === 'DPack') : ?>
                            <?php foreach($cart->cartlines as $line) : ?>
                                <?php if ($line->gift_for === $cartline->photo->barcode_id): ?>
                                    <?= $this->element('Cart/cartline', ['cartline' => $line]); ?>
                                <?php endif; ?>                              
                            <?php endforeach; ?>
                            <?php if(!array_key_exists($cartline->photo->barcode_id, $groupSelectedArr)) : ?>
                                <div class="col-xs-12 panel panel-info navigation-groups-picture">
                                    <div class="panel-body text-center">
                                        <?= $this->Html->link(
                                                __('< Kies gratis een groepsfoto naar keuze (niet digitaal). '),
                                                'photos/groups/'.$cartline->photo->barcode_id
                                        )?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
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
                                <button class="btn btn-success <?php if(!$groupSelected) { ?>disabled<?php } ?>" type="submit"><?=__('Gegevens invullen en betalen'); ?></button>
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
