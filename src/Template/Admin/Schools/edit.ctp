<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('School bewerken'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?= $this->Form->create($school, ['class' => 'form-horizontal school', 'autocomplete' => 'false', 'novalidate' => true, 'type' =>'file']) ?>
                    <div class="form-group">
                        <?= $this->Form->label('name', __('Naam'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('name', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <?php
                    ?>
                    <hr></hr>

                    <?= $this->element('Schools/contact_form'); ?>
                    <?= $this->element('Schools/visitaddress_form'); ?>
                    <?= $this->element('Schools/postaddress_form'); ?>
                    
                    <hr>
                    <?=$this->Html->link(__('Annuleer'),['action' => 'index'], ['class' => 'btn btn-sm']); ?>
                    <?=$this->Form->button(__('Opslaan'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="widget-box collapsed">
                <div class="widget-header">
                    <h4 class="widget-title"><?=__('Nieuw project toevoegen'); ?></h4>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse" class="shownewproject">
                            <i class="ace-icon fa fa-chevron-down"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body newprojectcontainer">
                    <div class="widget-main">
                        <div class="form-group">
                            <?= $this->Form->label('name', __('Projectnaam'), ['class' => 'col-sm-2 control-label no-padding-right ']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('projects.x.name', [
                                    'label' => false,
                                    'class' => 'form-control slugx newproject',
                                    'disabled' => true
                                ]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label('slug', __('Slug'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('projects.x.slug', [
                                    'label' => false,
                                    'class' => 'form-control slugx newproject',
                                    'readonly'=>true,
                                    'disabled' => true
                                ]); ?>
                            </div>
                        </div>

                        <?= $this->Form->hidden('projects.x.school_id', [
                            'value' => $school->id,
                            'class' => 'newproject',
                            'disabled' => true
                        ]) ?>

                     

                        <div class="form-group">
                            <?= $this->Form->label('grouptext', __('Groeptekst'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('projects.x.grouptext', [
                                    'label' => false,
                                    'class' => 'form-control newproject',
                                    'disabled' => true
                                ]); ?>
                            </div>
                        </div>
                        <hr>

                        <?=$this->Form->button(__('Verwijderen'), ['type' => 'submit', 'class' => 'btn btn-sm btn-danger deleteproject']); ?>
                        <?=$this->Form->button(__('Opslaan'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success pull-right']); ?>

                    </div>
                </div>
            </div>
            <?php $count = 0; ?>
            <?php foreach($school->projects as $project): ?>
                <div class="widget-box <?php echo ($count != 0) ? '' :''; ?> project">
                    <div class="widget-header">
                        <h4 class="widget-title"><?= $project->name ?></h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-<?php echo ($count != 1) ? 'down' :'up'; ?>"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">

                            <div class="form-group">
                                <?= $this->Form->label('name', __('Projectnaam'), ['class' => 'col-sm-2 control-label no-padding-right ']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('projects.'. $count .'.name', [
                                        'label' => false,
                                        'class' => 'form-control slug'. $count,
                                        'value' =>  $project->name
                                    ]); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?= $this->Form->label('slug', __('Slug'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('projects.'. $count .'.slug', [
                                        'label' => false,
                                        'class' => 'form-control slug'. $count,
                                        'readonly'=>true,
                                        'value' =>  $project->slug
                                    ]); ?>
                                </div>
                            </div>

                            <?= $this->Form->hidden('projects.'. $count .'.school_id', [
                                'value' => $project->school_id,
                            ]) ?>

                            <?= $this->Form->hidden('projects.'. $count .'.id', [
                                'value' => $project->id,
                                'class' => 'project_id'
                            ]) ?>

                            <div class="form-group">
                                <?= $this->Form->label('grouptext', __('Groeptekst'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('projects.'. $count .'.grouptext', [
                                        'label' => false,
                                        'class' => 'form-control',
                                        'value' =>  $project->grouptext
                                    ]); ?>
                                </div>
                            </div>
                            <hr>
                           
                            <?=$this->Form->button(__('Verwijderen'), ['type' => 'submit', 'class' => 'btn btn-sm btn-danger deleteproject']); ?>
                            <?=$this->Form->button(__('Opslaan'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                            
                            <br><br>
                        <label class="btn btn-default btn-file">
                            Browse <input type="file" name="test" style="">
                        </label>
                            
                        </div>
                    </div>
                </div>
            <?php $count++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->Html->script('/admin/js/jquery.slug'); ?>
<?= $this->Html->script('/admin/js/Controllers/schools'); ?>
<?= $this->Html->script('/admin/js/dropzone'); ?>