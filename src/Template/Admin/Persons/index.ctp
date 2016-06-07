<div class="table-header"><?=__('Personen')?></div>
<div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('full_name', __('Naam')) ?></th>
                <th><?= $this->Paginator->sort('email', __('Email')) ?></th>
                <th><?= $this->Paginator->sort('group.name', __('Klas')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($persons as $person): ?>
                <tr>
                    <td><?= h($person->full_name) ?></td>
                    <td><?= h($person->email) ?></td>
                    <td><?= h($person->group->name) ?></td>
                    <td><?= h($person->created) ?></td>
                    <td><?= h($person->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'view',
                                    $person->id
                                ],['escape' => false]) ?>

                        <?= $this->Html->link('<button class="btn btn-app btn-primary btn-xs">
                             <i class="ace-icon fa fa-pencil-square-o  bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'edit',
                                    $person->id
                                ],['escape' => false]) ?>

                        <?= $this->Form->postLink(' <button class="btn btn-app btn-danger btn-xs">
                             <i class="ace-icon fa fa-trash-o bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'delete',
                                    $person->id
                                ],
                                [
                                    'confirm' => __('Weet je zeker dat je {0} wilt verwijderen?', $person->name),
                                    'escape' => false
                                ]) ?>
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

                    <?= $this->Html->link(__('Nieuw persoon'),
                        [
                            'action' => 'add'
                        ],
                        [
                            'class' => 'btn btn-sm btn-purple'
                        ]
                    ) ?>


                </div>
            </div>
        </div>
    </div>
</div>