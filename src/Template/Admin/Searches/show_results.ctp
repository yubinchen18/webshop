<div class="table-header"><?=__("Zoekopdracht: ' {0} '", h($searchTerm)); ?></div>
<br>
<div class="table-header<?php echo (!empty($schools)) ? " search-active" : "";?>" <?php echo (empty($schools)) ? "style='opacity:0.4'" : "";?>><?=__('Schools')?></div>
<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <?php if (!empty($schools)): ?>
            <thead>
            <tr role="row">
                <th><?= __('School naam') ?></th>
                <th><?= __('Naam contact') ?></th>
                <th><?= __('Telefoonnummer') ?></th>
                <th><?= __('Plaats') ?></th>
                <th><?= __('Aangemaakt') ?></th>
                <th><?= __('Gewijzigd') ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($schools as $school): ?>
                <tr ondblclick="openView('schools', '<?= $school->id ?>')">
                    <td><?= h($school->name) ?></td>
                    <td><?= h($school->contact->full_name) ?></td>
                    <td><?= h($school->contact->phone) ?></td>
                    <td><?= h($school->visitaddress->city) ?></td>
                    <td><?= h($school->created) ?></td>
                    <td><?= h($school->modified) ?></td>
                    <td class="actions" style="padding-top:1px;padding-bottom:1px">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs" 
                            style="width:25px;height:25px;border-radius:5px;padding-top:0px">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'controller' => 'Schools',
                                    'action' => 'view',
                                    $school->id
                                ],['escape' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?=__("Geen scholen gevonden voor de zoekopdracht: ' {0} '", h($searchTerm)) ?>
                </tr>
            <?php endif; ?>    
            </tbody>
        </table>
    </div>
</div>

<br>
<div class="table-header<?php echo (!empty($projects)) ? " search-active" : "";?>" <?php echo (empty($projects)) ? "style='opacity:0.4'" : "";?>><?=__('Projecten')?></div>

<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <?php if (!empty($projects)): ?>
            <thead>
            <tr role="row">
                <th><?= __('Naam') ?></th>
                <th><?= __('School') ?></th>
                <th><?= __('Aangemaakt') ?></th>
                <th><?= __('Gewijzigd') ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project): ?>
                <tr ondblclick="openView('projects', '<?= $project->id ?>')">
                    <td><?= h($project->name) ?></td>
                    <td>
                        <?= $this->Html->link(h($project->school->name),
                                [
                                    'controller' => 'Schools',
                                    'action' => 'view',
                                    $project->school->id
                                ],['escape' => false]) ?>
                    </td>
                    <td><?= h($project->created) ?></td>
                    <td><?= h($project->modified) ?></td>
                    <td class="actions" style="padding-top:1px;padding-bottom:1px">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs" 
                            style="width:25px;height:25px;border-radius:5px;padding-top:0px">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'controller' => 'Projects',
                                    'action' => 'view',
                                    $project->id
                                ],['escape' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?=__("Geen projecten gevonden voor de zoekopdracht: ' {0} '", h($searchTerm)) ?>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="table-header<?php echo (!empty($groups)) ? " search-active" : "";?>" <?php echo (empty($groups)) ? "style='opacity:0.4'" : "";?>><?=__('Klassen')?></div>

<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <?php if (!empty($groups)): ?>
            <thead>
            <tr role="row">
                <th><?= __('Naam') ?></th>
                <th><?= __('Project') ?></th>
                <th><?= __('School') ?></th>
                <th><?= __('Aangemaakt') ?></th>
                <th><?= __('Gewijzigd') ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr ondblclick="openView('groups', '<?= $group->id ?>')">
                    <td><?= h($group->name) ?></td>
                    <td>
                        <?= $this->Html->link(h($group->project->name),
                                [
                                    'controller' => 'projects',
                                    'action' => 'view',
                                    $group->project->id
                                ],['escape' => false]) ?>
                    </td>
                    <td>
                        <?= $this->Html->link(h($group->project->school->name),
                                [
                                    'controller' => 'Schools',
                                    'action' => 'view',
                                    $group->project->school->id
                                ],['escape' => false]) ?>
                    </td>
                    <td><?= h($group->created) ?></td>
                    <td><?= h($group->modified) ?></td>
                    <td class="actions" style="padding-top:1px;padding-bottom:1px">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs" 
                            style="width:25px;height:25px;border-radius:5px;padding-top:0px">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'controller' => 'Groups',
                                    'action' => 'view',
                                    $group->id
                                ],['escape' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?=__("Geen klassen gevonden voor de zoekopdracht: ' {0} '", h($searchTerm)) ?>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="table-header<?php echo (!empty($persons)) ? " search-active" : "";?>" <?php echo (empty($persons)) ? "style='opacity:0.4'" : "";?>><?=__('Personen')?></div>

<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <?php if (!empty($persons)): ?>
            <thead>
            <tr role="row">
                <th><?= __('Naam') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Klas') ?></th>
                <th><?= __('Project') ?></th>
                <th><?= __('School') ?></th>
                <th><?= __('Aangemaakt') ?></th>
                <th><?= __('Gewijzigd') ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($persons as $person): ?>
                <tr ondblclick="openView('persons', '<?= $person->id ?>')">
                    <td><?= h($person->full_name) ?></td>
                    <td><?= h($person->email) ?></td>
                    <td>
                        <?= $this->Html->link(h($person->group->name),
                                [
                                    'controller' => 'Groups',
                                    'action' => 'view',
                                    $person->group->id
                                ],['escape' => false]) ?>
                    </td>
                    <td>
                        <?= $this->Html->link(h($person->group->project->name),
                                [
                                    'controller' => 'Projects',
                                    'action' => 'view',
                                    $person->group->project->id
                                ],['escape' => false]) ?>
                    </td>
                    <td>
                        <?= $this->Html->link(h($person->group->project->school->name),
                                [
                                    'controller' => 'Schools',
                                    'action' => 'view',
                                    $person->group->project->school->id
                                ],['escape' => false]) ?>
                    </td>
                    <td><?= h($person->created) ?></td>
                    <td><?= h($person->modified) ?></td>
                    <td class="actions" style="padding-top:1px;padding-bottom:1px">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs" 
                            style="width:25px;height:25px;border-radius:5px;padding-top:0px">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'controller' => 'Persons',
                                    'action' => 'view',
                                    $person->id
                                ],['escape' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?=__("Geen personen gevonden voor de zoekopdracht: ' {0} '", h($searchTerm)) ?>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="table-header<?php echo (!empty($addresses)) ? " search-active" : "";?>" <?php echo (empty($addresses)) ? "style='opacity:0.4'" : "";?>><?=__('Adressen')?></div>

<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <?php if (!empty($addresses)): ?>
            <thead>
            <tr role="row">
                <th><?= __('Achternaam') ?></th>
                <th><?= __('Adres') ?></th>
                <th><?= __('Postcode') ?></th>
                <th><?= __('Plaats') ?></th>
                <th><?= __('Aangemaakt') ?></th>
                <th><?= __('Gewijzigd') ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($addresses as $address): ?>
                <tr ondblclick="openView('addresses', '<?= $address->id ?>')">
                    <td><?= h($address->lastname) ?></td>
                    <td><?= h($address->full_address) ?></td>
                    <td><?= h($address->zipcode) ?></td>
                    <td><?= h($address->city) ?></td>
                    <td><?= h($address->created) ?></td>
                    <td><?= h($address->modified) ?></td>
                    <td class="actions">
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?=__("Geen adressen gevonden voor de zoekopdracht: ' {0} '", h($searchTerm)) ?>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

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