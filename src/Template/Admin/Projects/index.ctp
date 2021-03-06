<div class="table-header"><?=__('Projecten')?></div>
<div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('name', __('Project')) ?></th>
                <th><?= $this->Paginator->sort('school.name', __('School')) ?></th>
                <th><?= $this->Paginator->sort('slug', __('Slug')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Aangemaakt')) ?></th>
                <th><?= $this->Paginator->sort('persons', __('Aantal leerlingen/docenten')) ?></th>
                <th><?= $this->Paginator->sort('turnover', __('Omzet')) ?></th>
                <th class="actions"><?= __('Acties') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project): ?>
                <tr ondblclick="openView('projects', '<?= $project->id ?>')">
                    <td><?= h($project->name) ?></td>
                    <td><?= h($project->school->name) ?></td>
                    <td><?= h($project->slug) ?></td>
                    <td><?= h($project->created) ?></td>
                    <td>
                        <?php 
                            $totalNumberOfPersons= 0;
                                foreach ($project->groups as $group) {
                                    $numberOfPersons = count($group->persons);
                                    $totalNumberOfPersons += $numberOfPersons;
                                } 
                            echo $totalNumberOfPersons;
                        ?>
                    </td>
                    <td><?= h(count($project->turnover)) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<button class="btn btn-app btn-default btn-xs">
                             <i class="ace-icon fa fa-eye bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'view',
                                    $project->id
                                ],['escape' => false]) ?>

                        <?= $this->Html->link('<button class="btn btn-app btn-primary btn-xs">
                             <i class="ace-icon fa fa-pencil-square-o  bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'edit',
                                    $project->id
                                ],['escape' => false]) ?>

                        <?= $this->Form->postLink(' <button class="btn btn-app btn-danger btn-xs">
                             <i class="ace-icon fa fa-trash-o bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'delete',
                                    $project->id
                                ],
                                [
                                    'confirm' => __('Weet je zeker dat je {0} wilt verwijderen?', $project->name),
                                    'escape' => false
                                ]) ?>
                        
                        <?php if (!empty($project->groups)): ?>
                            <?= $this->Html->link('<button class="btn btn-app btn-pink btn-xs">
                             <i class="ace-icon fa fa-file-pdf-o  bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'createProjectCards',
                                    $project->id
                                ],
                                [
                                    'escape' => false,
                                    'target' => '_blank'
                                ]) ?>
                        <?php endif; ?>
                        
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

                    <?= $this->Html->link(__('Nieuwe project'),
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
