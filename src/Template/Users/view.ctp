<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders Orderstatuses'), ['controller' => 'OrdersOrderstatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Orders Orderstatus'), ['controller' => 'OrdersOrderstatuses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Persons'), ['controller' => 'Persons', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Person'), ['controller' => 'Persons', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th><?= __('Real Pass') ?></th>
            <td><?= h($user->real_pass) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($user->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Address') ?></th>
            <td><?= $user->has('address') ? $this->Html->link($user->address->id, ['controller' => 'Addresses', 'action' => 'view', $user->address->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Deleted') ?></th>
            <td><?= h($user->deleted) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Orders') ?></h4>
        <?php if (!empty($user->orders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Deliveryaddress Id') ?></th>
                <th><?= __('Invoiceaddress Id') ?></th>
                <th><?= __('Totalprice') ?></th>
                <th><?= __('Shippingcosts') ?></th>
                <th><?= __('Remarks') ?></th>
                <th><?= __('Trx Id') ?></th>
                <th><?= __('Ideal Status') ?></th>
                <th><?= __('Exportstatus') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Deleted') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->orders as $orders): ?>
            <tr>
                <td><?= h($orders->id) ?></td>
                <td><?= h($orders->user_id) ?></td>
                <td><?= h($orders->deliveryaddress_id) ?></td>
                <td><?= h($orders->invoiceaddress_id) ?></td>
                <td><?= h($orders->totalprice) ?></td>
                <td><?= h($orders->shippingcosts) ?></td>
                <td><?= h($orders->remarks) ?></td>
                <td><?= h($orders->trx_id) ?></td>
                <td><?= h($orders->ideal_status) ?></td>
                <td><?= h($orders->exportstatus) ?></td>
                <td><?= h($orders->created) ?></td>
                <td><?= h($orders->modified) ?></td>
                <td><?= h($orders->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Orders Orderstatuses') ?></h4>
        <?php if (!empty($user->orders_orderstatuses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Order Id') ?></th>
                <th><?= __('Orderstatus Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Deleted') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->orders_orderstatuses as $ordersOrderstatuses): ?>
            <tr>
                <td><?= h($ordersOrderstatuses->id) ?></td>
                <td><?= h($ordersOrderstatuses->order_id) ?></td>
                <td><?= h($ordersOrderstatuses->orderstatus_id) ?></td>
                <td><?= h($ordersOrderstatuses->user_id) ?></td>
                <td><?= h($ordersOrderstatuses->created) ?></td>
                <td><?= h($ordersOrderstatuses->modified) ?></td>
                <td><?= h($ordersOrderstatuses->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OrdersOrderstatuses', 'action' => 'view', $ordersOrderstatuses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OrdersOrderstatuses', 'action' => 'edit', $ordersOrderstatuses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrdersOrderstatuses', 'action' => 'delete', $ordersOrderstatuses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordersOrderstatuses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Persons') ?></h4>
        <?php if (!empty($user->persons)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Group Id') ?></th>
                <th><?= __('Address Id') ?></th>
                <th><?= __('Studentnumber') ?></th>
                <th><?= __('Firstname') ?></th>
                <th><?= __('Prefix') ?></th>
                <th><?= __('Lastname') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Deleted') ?></th>
                <th><?= __('Barcode Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->persons as $persons): ?>
            <tr>
                <td><?= h($persons->id) ?></td>
                <td><?= h($persons->group_id) ?></td>
                <td><?= h($persons->address_id) ?></td>
                <td><?= h($persons->studentnumber) ?></td>
                <td><?= h($persons->firstname) ?></td>
                <td><?= h($persons->prefix) ?></td>
                <td><?= h($persons->lastname) ?></td>
                <td><?= h($persons->slug) ?></td>
                <td><?= h($persons->email) ?></td>
                <td><?= h($persons->type) ?></td>
                <td><?= h($persons->created) ?></td>
                <td><?= h($persons->modified) ?></td>
                <td><?= h($persons->deleted) ?></td>
                <td><?= h($persons->barcode_id) ?></td>
                <td><?= h($persons->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Persons', 'action' => 'view', $persons->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Persons', 'action' => 'edit', $persons->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Persons', 'action' => 'delete', $persons->id], ['confirm' => __('Are you sure you want to delete # {0}?', $persons->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
