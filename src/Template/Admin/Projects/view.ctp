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
                            <th><?= __('Naam') ?></th>
                            <td><?= h($project->name) ?></td>
                        </tr>                    
                        <tr>
                            <th><?= __('Slug') ?></th>
                            <td><?= h($project->slug) ?></td>
                        </tr>
                    </table>

                    <hr></hr>
                    <h3><?=__('School'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td colspan="2"><?= h($project->school->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Slug') ?></th>
                            <td colspan="2"><?= h($project->school->slug) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Wachtrij') ?></th>
                            <td><?= $this->Form->create(null,['url' => ['action' => 'enableSync']]); ?>
                            <?= $this->Form->input('project_id', ['type' => 'hidden','value' => $project->id]); ?>
                            <?= $this->Form->input('photographer',[
                                'type' => 'select', 
                                'options' => $photographers, 
                                'empty' => __('Kies een profiel'),
                                'label' =>false]); 
                            ?>
                            </td>
                            <td>
                            <?= $this->Form->button(__('Opnieuw synchroniseren'),
                                [
                                    'id' => 'sync-button',
                                    'disabled' => true,
                                    'class' => 'btn btn-sm btn-success',
                                    'style' => 'margin-left: 12px'
                                ]); ?>
                            <?= $this->Form->end(); ?>
                            </td>
                        </tr>
                    </table>
                    
                    <?php if (!empty($project->groups)): ?>
                    <br/>
                    <div class="row">
                        <div class="col-md-4 pull-right">
                            <?= $this->Html->link(__('Leerlingkaarten maken'),
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
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
       
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Klassen'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <table class="vertical-table">
                        <tr role="row">
                            <th><?= __('') ?></th>
                        </tr>
                        <tbody>
                        <?php foreach ($project->groups as $group): ?>
                            <tr>
                                <td><?= h($group->name); ?></td>
                                <td>
                                    <div enabled="enabled" class="showstudents">                                        
                                    <input class="group-id" type="hidden" value='<?php echo $group->id?>'>
                                    <button type="button" class="btn btn-primary btn-xs" style="padding: 2px; margin: 2px;"><?= __(' Toon leerling details'); ?></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="clearfix"></div>                    
                </div>
            </div>  
        </div>
    </div>
       
    <div class="row">
        <div class="projectdetails">
            <div class="col-md-6">            
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('/admin/js/jquery.slug'); ?>
<?= $this->Html->script('/admin/js/Controllers/projects'); ?>

