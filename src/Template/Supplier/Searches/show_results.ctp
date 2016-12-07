<div class="table-header"><?=__("Zoekopdracht: ' {0} '", h($searchTerm)); ?></div>
<br>
<div class="table-header<?php echo (!empty($orders)) ? " search-active" : "";?>" <?php echo (empty($orders)) ? "style='opacity:0.4'" : "";?>><?=__('Orders')?></div>
<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <?php if (!empty($orders)): ?>
            <thead>
            <tr role="row">
                <th><?= __('Ordernummer') ?></th>
                <th><?= __('Afleveringsadres') ?></th>
                <th><?= __('Invoiceadres') ?></th>
                <th><?= __('Totale prijs') ?></th>
                <th><?= __('Aangemaakt') ?></th>
                <th><?= __('Gewijzigd') ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr ondblclick="openView('orders', '<?= $order->id ?>')">
                    <td><?= h($order->ident) ?></td>
                    <td><?= h($order->deliveryaddress->full_address) ?></td>
                    <td><?= h($order->invoiceaddress->full_address) ?></td>
                    <td><?= h($order->totalprice) ?></td>
                    <td><?= h($order->created) ?></td>
                    <td><?= h($order->modified) ?></td>
                    <td class="actions">
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?=__("Geen orders gevonden voor de zoekopdracht: ' {0} '", h($searchTerm)) ?>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->Html->script('/admin/js/Controllers/searches'); ?>