<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Project details'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($project->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($project->name) ?></td>
                        </tr>                    
                        <tr>
                            <th><?= __('Slug') ?></th>
                            <td><?= h($project->slug) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($project->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($project->modified) ?></td>
                        </tr>
                    </table>

                    <hr></hr>
                    <h3><?=__('School'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($project->school->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($project->school->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Slug') ?></th>
                            <td><?= h($project->school->slug) ?></td>
                        </tr>                        
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($project->school->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($project->school->modified) ?></td>
                        </tr>                        
                    </table>
                    
                    <?php if (!empty($project->groups)): ?>
                        <div>
                            <?= $this->Html->link(__('Leerlingenkaart maken'),
                                [
                                    'action' => 'createProjectCards',
                                    $project->id
                                ],
                                [
                                    'escape' => false,
                                    'class' => 'btn btn-sm btn-pink pull-right',
                                    'target' => '_blank',
                                ]) ?>
                        </div>
                        <div class="clearfix"></div>
                    <?php endif; ?>
                        
                </div>
            </div>
        </div>
    </div>
</div>