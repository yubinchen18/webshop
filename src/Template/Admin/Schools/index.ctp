<div class="table-header"><?=__('Scholen')?></div>
<div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('name', __('School')) ?></th>
                <th><?= __('Naam contact') ?></th>
                <th><?= __('Telefoonnummer') ?></th>
                <th><?= __('Plaats') ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= __('Omzet') ?></th>
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
                    <td><?= h(count($school->turnover)) ?></td>

                    <td class="actions">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'view',
                                    $school->id
                                ],['escape' => false]) ?>

                        <?= $this->Html->link('<button class="btn btn-app btn-primary btn-xs">
                             <i class="ace-icon fa fa-pencil-square-o  bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'edit',
                                    $school->id
                                ],['escape' => false]) ?>

                        <?= $this->Form->postLink(' <button class="btn btn-app btn-danger btn-xs">
                             <i class="ace-icon fa fa-trash-o bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'delete',
                                    $school->id
                                ],
                                [
                                    'confirm' => __('Weet je zeker dat je {0} wilt verwijderen?', $school->name),
                                    'escape' => false
                                ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-12">
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('Vorige')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Volgende') . ' >') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>

                    <?= $this->Html->link(__('Nieuwe school'),
                        [
                            'action' => 'add'
                        ],
                        [
                            'class' => 'btn btn-sm btn-purple'
                        ]
                    ) ?>
                    
                    <?= $this->Html->link(__('Scholen exporteren'),
                        [
                            'action' => 'export',
                            '_ext' => 'csv'
                        ],
                        [
                            'class' => 'btn btn-sm btn-pink pull-right',
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
