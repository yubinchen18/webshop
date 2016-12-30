<div class="row">
    <!-- left panel -->
    <?= $this->Flash->render(); ?>
    
    <div class="cart-cartlines-index col-md-9">
        <h2><?= __('Winkelwagen');?></h2>
        <div class='row col-md-12 col-xs-12'>
            <div class='cartlines-header col-xs-2'><?= __('Foto'); ?></div>
            <div class='cartlines-header col-xs-4'><?= __('Product'); ?></div>
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
                                                'photos/pickfreegroupspicture/'.$cartline->photo->barcode_id
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
                                        <div class='col-sm-7'><?= __('Subtotaal: '); ?></div>
                                        <div class='col-sm-3 text-right'>
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
                                        <div class='col-sm-7'><?= __('Verwerkingskosten: '); ?></div>
                                        <div class='col-sm-3 text-right'>
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
                                            <div class='col-sm-7'><?= __('Totaal: '); ?></div>
                                            <div class='col-sm-3 text-right'>
                                                <span><?= __('€ '); ?><span id='order-total'>
                                                    <?= $this->Number->format($orderTotal, [
                                                        'places' => 2
                                                    ]); ?>
                                                </span></span>
                                            </div>
                                        </b>
                                    </div>
                                </div>
                                <div class='order-korting col-sm-offset-6 col-sm-6'>
                                    <div class='row'>
                                        <div class='col-sm-7'><?= __('U BESPAART IN TOTAAL: '); ?></div>
                                        <div class='col-sm-3 text-right'>
                                            <span><?= __('€ '); ?><span class='price-<?= $cartline->id; ?>' id='order-discount'>
                                                <?= $this->Number->format($discount, [
                                                    'places' => 2
                                                ]); ?>
                                            </span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-sm-3 '>
                            <?= $this->Html->link(__('Naar foto-overzicht'),
                                         ['controller' => 'Photos', 'action' => 'index'],
                                         ['class' => 'btn btn-default']
                                    ); ?>
                        </div>
                        <div class='order-place-order col-sm-3 col-sm-offset-6'>
                                <?= $this->Html->link(__('Gegevens invullen en betalen'),
                                         ['action' => 'orderInfo'],
                                         ['class' => 'btn btn-success']
                                    ); ?>
                        </div>
                    </div>
                </div>
            
            <?php else: ?>
                <div>
                    <h3><?= __('Uw winkelwagen is leeg'); ?></h3>
                    <div class='col-sm-3 '>
                        <?= $this->Html->link(__('Naar foto-overzicht'),
                            ['controller' => 'Photos', 'action' => 'index'],
                            ['class' => 'btn btn-default']
                        ); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- right panel -->
    <div class="cart-order-details col-md-3 hidden-sm hidden-xs">
        <div class="photos-view-products-fixed">
            <div class="cart-order-details-action alert alert-success">
                <?= __('Gratis verzending vanaf 4 afdrukken!'); ?>
            </div>
            <div class="cart-order-details-message">
                <?= __('Let op! Gratis verzending alleen bij afdrukken tot en met formaat 20x30.'); ?>
            </div>
            
            <div class="add-coupon">
                <div class='add-coupon-block'>
                    <?= __('Couponcode'); ?>
                    <?= $this->Form->create(null, ['url' => ['action' => 'useCoupon'], 'class' => 'form-horizontal', 'autocomplete' => 'false']) ?>
                    <?= $this->Form->input('coupon_code', ['label' => false, 'required' => true, 'class' => 'form-control input-number']) ?>
                    <?= $this->Form->submit('Toepassen', ['class' => 'btn btn-success']) ?>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
