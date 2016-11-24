<div class='order-confirm row'>
    <!-- left panel -->
    <div class="order-confirm-details col-md-9">
        <h2><?= __('Controleer uw bestelling');?></h2>
        
        <div class='row'>
            <div class="order-cofirm-billing-address col-sm-5">
                <div>
                    <h3><?= ($data['different-address']) ? __('Factuuradres') : __('Factuur- en verzendadres'); ?></h3>
                </div>
                <div>
                    <?= $data['firstname']. ' ' .$data['prefix']. ' ' . $data['lastname']; ?><br>
                    <?= $data['street']. ' ' .$data['number']; ?><br>
                    <?= $data['city']. ', '. $data['zipcode']; ?><br>
                    <?= $data['phone']; ?>
                </div>
            </div>
            
            <?php if ($data['different-address']): ?>
                <div class="order-confirm-shipping-address col-sm-5">
                    <div>
                        <h3><?= __('Verzendadres'); ?></h3>
                    </div>
                    <div>
                        <?= $data['alternative']['firstname']. ' ' .$data['alternative']['prefix']. ' ' . $data['alternative']['lastname']; ?><br>
                        <?= $data['alternative']['street']; ?><br>
                        <?= $data['alternative']['city']. ', '. $data['alternative']['zipcode']; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class='row order-confirm-payment-method'>
            <div class='col-sm-10'>
                <div>
                    <h3><?= __('Betaling'); ?></h3>
                </div>
                <div>
                    <?php if ($data['paymentmethod'] == 'transfer'): ?>
                        <u><b><?= __('Betaalmethode: ');?></b></u> <?= __('Bankoverschrijving'); ?>
                    <?php elseif ($data['paymentmethod'] == 'ideal'): ?>
                        <u><b><?= __('Betaalmethode: ');?></b></u> <?= __('{0} via {1}', ['iDeal',  $issuers['Nederland'][$data['issuerId']]]); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class='order-confirm-cartlines'>
            <div class='row col-md-12 col-xs-12'>
                <div class='cartlines-header col-xs-2'><?= __('Foto'); ?></div>
                <div class='cartlines-header col-xs-4'><?= __('Product'); ?></div>
                <div class='cartlines-header col-xs-2'><?= __('Aantal'); ?></div>
                <div class='cartlines-header col-xs-2'><?= __('Stukprijs'); ?></div>
                <div class='cartlines-header col-xs-2'><?= __('Prijs'); ?></div>
                <?php if (!empty($cart->cartlines)): ?>
                    <?php foreach($cart->cartlines as $cartline): ?>
                        <?php if (!$cartline->gift_for): ?>
                            <?= $this->element('Cart/cartline_confirm', ['cartline' => $cartline]); ?>
                            <?php if($cartline->product->article === 'DPack') : ?>
                                <?php foreach($cart->cartlines as $line) : ?>
                                    <?php if ($line->gift_for === $cartline->photo->barcode_id): ?>
                                        <?= $this->element('Cart/cartline_confirm', ['cartline' => $line]); ?>
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
                            <?= $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'add']]); ?>
                                <div class='col-sm-3 '>
                                    <input type="hidden" name='orderData' value= '<?= $dataJson ?>' />
                                    <?= $this->Html->link(__('Terug naar winkelwagen'),
                                        ['controller' => 'Carts', 'action' => 'display'],
                                        ['class' => 'btn btn-default']
                                    ); ?>
                                </div>
                                <div class='order-place-order col-sm-3 col-sm-offset-6'>
                                    <?= $this->Form->button(__('Plaats uw bestelling'), [
                                        'type' => 'submit',
                                        'id' => 'order-confirm-submit',
                                        'class' => 'btn btn-success'
                                    ]); ?>
                                </div>
                            <?= $this->Form->end(); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div>
                        <h3><?= __('Uw winkelwagen is leeg'); ?></h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- right panel -->
    <div class="cart-order-details col-md-3 hidden-sm hidden-xs">
        
    </div>
</div>

