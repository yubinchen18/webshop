<div class="table-header"><?=__('Orders')?></div>
<div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('ident', __('Order-ident')) ?></th>
                <th><?= $this->Paginator->sort('invoiceaddress.full_name', __('Klant')) ?></th>
                <th><?= $this->Paginator->sort('user.person.group.project.school.name', __('School')) ?></th>
                <th><?= $this->Paginator->sort('orderlines', __('Aantal producten')) ?></th>
                <th><?= $this->Paginator->sort('totalprice', __('Totaalbedrag')) ?></th>
                <th><?= $this->Paginator->sort('payment_method', __('Betalingsmethode')) ?></th>
                <th><?= $this->Paginator->sort('orderstatus', __('Verwerkingsstatus')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr ondblclick="openView('orders', '<?= $order->id ?>')">
                    <td><?= h($order->ident) ?></td>
                    <td><?= h($order->invoiceaddress->fullName) ?></td>
                    <td><?= h($order->user->persons[0]->group->project->school->name) ?></td>
                    <td><?= h(count($order->orderlines)) ?></td>
                    <td><?= h($this->Number->currency($order->totalprice, 'EUR')); ?></td>
                    <td><?= h($order->payment_method); ?></td>
                    <td><?= h($order->orders_orderstatuses[0]->orderstatus->name); ?></td>
                    <td><?= h($order->created) ?></td>
                    <td><?= h($order->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'view',
                                    $order->id
                                ],['escape' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-6">
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('Vorige')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Volgende') . ' >') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
