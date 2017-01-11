<div class="row">
    <div class='col-md-3'>
        <div class='widget-box'>
            <div class='widget-header'>
                <h4 class='widget-title'><?=__('Order details');?></h4>
                <div class='widget-toolbar'>
                    <a href='#' data-action='collapse'>
                        <i class='ace-icon fa fa-chevron-up'></i>
                    </a>
                </div>
            </div>
            <div class='widget-body'>
                <div class="widget-main">
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Ordernummer') ?></th>
                            <td><?= h($order->ident) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Geplaatst op') ?></th>
                            <td><?= h($order->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Betalingsmethode') ?></th>
                            <td><?= h($order->payment_method); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Verwerkingsstatus') ?></th>
                            <td>
                                <?= $this->Form->select('orderstatus', $statusOptions, [
                                    'default' => $order->orders_orderstatuses[0]->orderstatus->id,
                                    'id' => 'orderstatus-supplier',
                                    'class' => 'form-control',
                                    'data-id' => $order->id
                                ]); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class='col-md-3'>
        <div class='widget-box'>
            <div class='widget-header'>
                <h4 class='widget-title'><?=__('Statuswijzigingen');?></h4>
                <div class='widget-toolbar'>
                    <a href='#' data-action='collapse'>
                        <i class='ace-icon fa fa-chevron-up'></i>
                    </a>
                </div>
            </div>
            <div class='widget-body'>
                <div class="widget-main">
                     <table class="vertical-table">
                         <tbody id='statusHistory'>
                            <?php foreach ($order->orders_orderstatuses as $statusChange): ?>
                            <tr>
                                <th><?= h($statusChange->created) ?></th>
                                <td><?= h($statusChange->orderstatus->name) ?></td>
                            </tr>
                            <?php endforeach;?>
                         </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class='col-md-3'>
        <div class='widget-box'>
            <div class='widget-header'>
                <h4 class='widget-title'><?=__('Factuuradres');?></h4>
                <div class='widget-toolbar'>
                    <a href='#' data-action='collapse'>
                        <i class='ace-icon fa fa-chevron-up'></i>
                    </a>
                </div>
            </div>
            <div class='widget-body'>
                <div class="widget-main">
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($order->invoiceaddress->fullName) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Adres') ?></th>
                            <td><?= h($order->invoiceaddress->fullAddress) ?></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td><?= h($order->invoiceaddress->zipcode .' '. $order->invoiceaddress->city);?></td>
                        </tr>
                        <tr>
                            <th><?= __('Telefoonnummer') ?></th>
                            <td><?= h($order->invoiceaddress->phone); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($order->invoiceaddress->email); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class='col-md-3'>
        <div class='widget-box'>
            <div class='widget-header'>
                <h4 class='widget-title'><?=__('Download');?></h4>
                <div class='widget-toolbar'>
                    <a href='#' data-action='collapse'>
                        <i class='ace-icon fa fa-chevron-up'></i>
                    </a>
                </div>
            </div>
            <div class='widget-body'>
                <div class="widget-main">
                     <?= $this->Html->link('Klik hier om de foto\'s te downloaden', [
                        'controller' => 'orders',
                        'action' => 'download',
                        'id' => $order->id,
                        '_full' => true
                        ],['escape' => false]); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!--<?php if ($order->invoiceaddress->id !== $order->deliveryaddress->id) : ?>-->
        <div class='col-md-3'>
            <div class='widget-box'>
                <div class='widget-header'>
                    <h4 class='widget-title'><?=__('Afleveradres');?></h4>
                    <div class='widget-toolbar'>
                        <a href='#' data-action='collapse'>
                            <i class='ace-icon fa fa-chevron-up'></i>
                        </a>
                    </div>
                </div>
                <div class='widget-body'>
                    <div class="widget-main">
                         <table class="vertical-table">
                            <tr>
                                <th><?= __('Naam') ?></th>
                                <td><?= h($order->deliveryaddress->fullName) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Adres') ?></th>
                                <td><?= h($order->deliveryaddress->fullAddress) ?></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td><?= h($order->deliveryaddress->zipcode .' '. $order->deliveryaddress->city);?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!--<?php endif; ?>-->
</div>

<div class='row'>
    <div class='col-md-12'>
        <div class='widget-box'>
            <div class='widget-header'>
                <h4 class='widget-title'><?=__('Producten');?></h4>
                <div class='widget-toolbar'>
                    <a href='#' data-action='collapse'>
                        <i class='ace-icon fa fa-chevron-up'></i>
                    </a>
                </div>
            </div>
            <div class='widget-body'>
                <div class="widget-main">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?= __('Foto'); ?></th>
                                <th><?= __('Product detail'); ?></th>
                                <th><?= __('Aantal'); ?></th>
                                <th><?= __('Stukprijs'); ?></th>
                                <th><?= __('Prijs'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order->orderlines as $orderline): ?>
                                <tr>
                                    <td>
                                        <?= $this->Html->image($this->Url->build([
                                            'controller' => 'Photos',
                                            'action' => 'display',
                                            'path' => $orderline->photo->id,
                                            'size' => 'thumbs',
                                            'rotate' => 1
                                        ])); ?>
                                    </td>
                                    <td>
                                        <div class='orderline-product-name'><b><?= $orderline->product->name; ?></b></div>
                                        <?php if (!empty($orderline->orderline_productoptions)): ?>
                                            <div class='orderline-product-options'>
                                                <span><?= __('Options:');?></span>
                                                <ul>
                                                    <?php foreach ($orderline->orderline_productoptions as $option): ?>
                                                        <li><?= $option->productoption_choice->productoption->name; ?>: 
                                                        <?= $option->productoption_choice->value; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $orderline->quantity ?></td>
                                    <td>
                                        <?php if($orderline->product->has_discount == 1 && $orderline->quantity > 1): ?>
                                            <span class='quantity-<?= $orderline->id; ?>'></span>
                                            <div class='normalprice'>1 x <?= $this->Number->currency($orderline->product->price_ex, 'EUR'); ?></div>
                                            <div class='discountprice'><?= $orderline->quantity-1; ?> x <?= $this->Number->currency($orderline->discountprice, 'EUR'); ?></div>
                                        <?php else: ?>
                                            <span class='quantity-<?= $orderline->id; ?>'><?= $orderline->quantity; ?></span>
                                            <span> x <?= $this->Number->currency($orderline->product->price_ex, 'EUR'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $this->Number->currency($orderline->price_ex, 'EUR'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                
                                
                            <tr class='order-summary-block'>
                                <td colspan='3'>
                                </td>
                                <td colspan='2'>
                                    <div class='row'>
                                        <div class='col-sm-6'><?= __('Subtotaal: '); ?></div>
                                        <div class='col-sm-6'><?= $this->Number->currency($order->totalprice, 'EUR'); ?></div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-sm-6'><?= __('Verwerkingskosten: '); ?></div>
                                        <div class='col-sm-6'><?= $this->Number->currency($order->shippingcosts, 'EUR'); ?></div>
                                    </div>
                                    <div class='row' style='margin-top: 10px'>
                                        <div class='col-sm-6'><b><?= __('Totaal: '); ?></b></div>
                                        <div class='col-sm-6'><b>
                                            <?= $this->Number->currency(($order->shippingcosts + $order->totalprice), 'EUR'); ?>
                                        </b></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->Html->script('/admin/js/jquery.slug'); ?>
<?= $this->Html->script('/admin/js/Controllers/orders'); ?>
    
