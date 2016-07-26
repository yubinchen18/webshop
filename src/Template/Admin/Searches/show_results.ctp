<div class="table-header"><?=__('Zoekopdracht'). ': '. "'$searchTerm'"?></div>
<br>
<div class="table-header"><?=__('Schools')?></div>

<?php if (!$schools->isEmpty()): ?>
<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('name', __('Naam')) ?></th>
                <th><?= $this->Paginator->sort('contact.full_name', __('Naam contact')) ?></th>
                <th><?= $this->Paginator->sort('contact.phone', __('Telefoonnummer')) ?></th>
                <th><?= $this->Paginator->sort('visitaddress.city', __('Plaats')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
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
                    <td class="actions">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
    <tbody>
        <tr>
            <td><?=__("Geen scholen gevonden voor de zoekopdracht: '$searchTerm'") ?>
        </tr>
    </tbody>
</table>        
<?php endif; ?>
<br>
<div class="table-header"><?=__('Projecten')?></div>

<?php if (!$projects->isEmpty()): ?>
<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('name', __('Naam')) ?></th>
                <th><?= $this->Paginator->sort('school.name', __('School')) ?></th>
                <th><?= $this->Paginator->sort('slug', __('Slug')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
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
                                    'controller' => 'schools',
                                    'action' => 'view',
                                    $school->id
                                ],['escape' => false]) ?>
                    </td>
                    <td><?= h($project->slug) ?></td>
                    <td><?= h($project->created) ?></td>
                    <td><?= h($project->modified) ?></td>
                    <td class="actions">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
    <tbody>
        <tr>
            <td><?=__("Geen projecten gevonden voor de zoekopdracht: '$searchTerm'") ?>
        </tr>
    </tbody>
</table>
<?php endif; ?>
<br>
<div class="table-header"><?=__('Klassen')?></div>

<?php if (!$groups->isEmpty()): ?>
<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('name', __('Naam')) ?></th>
                <th><?= $this->Paginator->sort('project.name', __('Project')) ?></th>
                <th><?= $this->Paginator->sort('project.school.name', __('School')) ?></th>
                <th><?= $this->Paginator->sort('slug', __('Slug')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr ondblclick=""ick="openView('groups', '<?= $group->id ?>')">
                    <td><?= h($group->name) ?></td>
                    <td>
                        <?= $this->Html->link(h($group->project->name),
                                [
                                    'controller' => 'projects',
                                    'action' => 'view',
                                    $group->project->id
                                ],['escape' => false]) ?>
                    </td>
                    <td><?= h($group->project->school->name) ?></td>
                    <td><?= h($group->slug) ?></td>
                    <td><?= h($group->created) ?></td>
                    <td><?= h($group->modified) ?></td>
                    <td class="actions">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
    <tbody>
        <tr>
            <td><?=__("Geen klassen gevonden voor de zoekopdracht: '$searchTerm'") ?>
        </tr>
    </tbody>
</table>
<?php endif; ?>
<br>
<div class="table-header"><?=__('Personen')?></div>

<?php if (!$persons->isEmpty()): ?>
<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('full_name', __('Naam')) ?></th>
                <th><?= $this->Paginator->sort('email', __('Email')) ?></th>
                <th><?= $this->Paginator->sort('group.name', __('Klas')) ?></th>
                <th><?= $this->Paginator->sort('group.project.name', __('Project')) ?></th>
                <th><?= $this->Paginator->sort('group.project.school.name', __('School')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($persons as $person): ?>
                <tr ondblclick=""ick="openView('persons', '<?= $person->id ?>')">
                    <td><?= h($person->full_name) ?></td>
                    <td><?= h($person->email) ?></td>
                    <td><?= h($person->group->name) ?></td>
                    <td><?= h($person->group->project->name) ?></td>
                    <td><?= h($person->group->project->school->name) ?></td>
                    <td><?= h($person->created) ?></td>
                    <td><?= h($person->modified) ?></td>
                    <td class="actions">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
    <tbody>
        <tr>
            <td><?=__("Geen personen gevonden voor de zoekopdracht: '$searchTerm'") ?>
        </tr>
    </tbody>
</table>
<?php endif; ?>
<br>
<div class="table-header"><?=__('Klanten')?></div>

<?php if (!$addresses->isEmpty()): ?>
<div>
    <div class="dataTables_wrapper form-inline no-footer">
        <table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('full_name', __('Naam')) ?></th>
                <th><?= $this->Paginator->sort('full_address', __('Adres')) ?></th>
                <th><?= $this->Paginator->sort('zipcode', __('Postcode')) ?></th>
                <th><?= $this->Paginator->sort('city', __('Plaats')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($addresses as $address): ?>
                <tr ondblclick=""ick="openView('addresses', '<?= $address->id ?>')">
                    <td><?= h($address->full_name) ?></td>
                    <td><?= h($address->full_address) ?></td>
                    <td><?= h($address->zipcode) ?></td>
                    <td><?= h($address->city) ?></td>
                    <td><?= h($address->created) ?></td>
                    <td><?= h($address->modified) ?></td>
                    <td class="actions">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<table class="table table-striped table-bordered table-hover dataTable no-footer table-condensed" role="grid"
               aria-describedby="dynamic-table_info">
    <tbody>
        <tr>
            <td><?=__("Geen klanten gevonden voor de zoekopdracht: '$searchTerm'") ?>
        </tr>
    </tbody>
</table>
<?php endif; ?>
