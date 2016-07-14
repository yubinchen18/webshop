<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Klas details'); ?></h4>

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
                            <td><?= h($group->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($group->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Slug') ?></th>
                            <td><?= h($group->slug) ?></td>
                        </tr>
                        
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($group->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($group->modified) ?></td>
                        </tr>
                    </table>

                    <hr></hr>
                    <h3><?=__('Project'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($group->project->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Projectnaam') ?></th>
                            <td><?= h($group->project->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Slug') ?></th>
                            <td><?= h($group->project->slug) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Groeptekst') ?></th>
                            <td><?= h($group->project->grouptext) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('School') ?></th>
                            <td><?= h($group->project->school->name) ?></td>
                        </tr>
                        
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($group->project->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($group->project->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Barcode'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($group->barcode->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Barcode') ?></th>
                            <td><?= h($group->barcode->barcode)?></td>
                        </tr>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <td><?= h($group->barcode->type) ?></td>
                        </tr>                      
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($group->barcode->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($group->barcode->modified) ?></td>
                        </tr>
                    </table>
                    
                    <?= $this->Html->link(__('Leerlingenkaart maken'),
                        [
                            'action' => 'createGroupCards',
                            $group->id
                        ],
                        [
                            'escape' => false,
                            'class' => 'btn btn-sm btn-pink pull-right',
                            'target' => '_blank'
                        ]
                    ) ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>