<div class="table-header"><?=__('Klassen')?></div>
<div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('name', __('Naam')) ?></th>
                <th><?= $this->Paginator->sort('group.name', __('Project')) ?></th>
                <th><?= $this->Paginator->sort('slug', __('Slug')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Gewijzigd')) ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= h($group->name) ?></td>
                    <td><?= h($group->project->name) ?></td>
                    <td><?= h($group->slug) ?></td>
                    <td><?= h($group->created) ?></td>
                    <td><?= h($group->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'view',
                                    $group->id
                                ],['escape' => false]) ?>

                        <?= $this->Html->link('<button class="btn btn-app btn-primary btn-xs">
                             <i class="ace-icon fa fa-pencil-square-o  bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'edit',
                                    $group->id
                                ],['escape' => false]) ?>

                        <?= $this->Form->postLink(' <button class="btn btn-app btn-danger btn-xs">
                             <i class="ace-icon fa fa-trash-o bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'delete',
                                    $group->id
                                ],
                                [
                                    'confirm' => __('Weet je zeker dat je {0} wilt verwijderen?', $group->name),
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

                    <?= $this->Html->link(__('Nieuwe group'),
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