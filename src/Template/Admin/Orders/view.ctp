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
                            <th><?= __('Order-ident') ?></th>
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
                            <td><?= h($order->orderstatuses[0]->name); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='row'>
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
                            <th><?= __('Order-ident') ?></th>
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
                            <td><?= h($order->orderstatuses[0]->name); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('/admin/js/jquery.slug'); ?>
<?= $this->Html->script('/admin/js/Controllers/persons'); ?>
    
