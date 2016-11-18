<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('School details'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                     <table class="vertical-table">
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->name) ?></td>
                        </tr>                    
                    </table>
                    <hr></hr>
                    <h3><?=__('Contactgegevens'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->contact->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Telefoonnummer') ?></th>
                            <td><?= h($school->contact->phone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Faxnummer') ?></th>
                            <td><?= h($school->contact->fax) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($school->contact->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Geslacht') ?></th>
                            <td><?= ($school->contact->gender == 'm') ? __('Man') : __('Vrouw'); ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Bezoek adres'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Straat') ?></th>
                            <td><?= h($school->visitaddress->street) . ' ' . h($school->visitaddress->number)?></td>
                        </tr>
                        <tr>
                            <th><?= __('Toevoeging') ?></th>
                            <td><?= h($school->visitaddress->extension) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Postcode') ?></th>  
                            <td><?= h($school->visitaddress->zipcode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Plaats') ?></th>
                            <td><?= h($school->visitaddress->city) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->visitaddress->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Geslacht') ?></th>
                            <td><?= ($school->visitaddress->gender == 'm') ? __('Man') : __('Vrouw'); ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <?php if(!empty($school->mailadress)): ?>
                        <h3><?=__('Post adres'); ?></h3>
                         <table class="vertical-table">
                            <tr>
                                <th><?= __('Straat') ?></th>
                                <td><?= h($school->mailaddress->street) . ' ' . h($school->mailaddress->number)?></td>
                            </tr>
                            <tr>
                                <th><?= __('Toevoeging') ?></th>
                                <td><?= h($school->mailaddress->extension) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Postcode') ?></th>
                                <td><?= h($school->mailaddress->zipcode) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Stad') ?></th>
                                <td><?= h($school->mailaddress->city) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Naam') ?></th>
                                <td><?= h($school->mailaddress->full_name) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Geslacht') ?></th>
                                <td><?= ($school->mailaddress->gender == 'm') ? __('Man') : __('Vrouw'); ?></td>
                            </tr>
                        </table>
                    <?php endif; ?>
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
                <?= $this->Form->create($project, [
                        'class' => 'form-horizontal school',
                        'autocomplete' => 'false',
                        'novalidate' => true,
                        'type' =>'file',
                        'url' => [
                            'controller' => 'Projects',
                            'action' => 'add'
                        ]
                    ]) ?>
                <?= $this->Form->input('school_id',['type' => 'hidden','value' => $school->id]); ?>
                <div class="widget-body newprojectcontainer">
                    <div class="widget-main">
                        <div class="form-group">
                            <?= $this->Form->label('name', __('Projectnaam'), ['class' => 'col-sm-2 control-label no-padding-right ']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('name', [
                                    'label' => false,
                                    'class' => 'form-control slug newproject',
                                ]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label('slug', __('Slug'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('slug', [
                                    'label' => false,
                                    'class' => 'form-control slugx newproject',
                                    'readonly'=>true,
                                ]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label('grouptext', __('Groeptekst'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('grouptext', [
                                    'label' => false,
                                    'class' => 'form-control newproject',
                                ]); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <?=$this->Form->button(__('Opslaan'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success pull-right right-fix']); ?>
                        </div>                        
                        
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
            <?php $count = 0; ?>
            <?php foreach($school->projects as $project): ?>
                <div class="widget-box <?php echo ($count != 0) ? 'collapsed' :''; ?> project">
                    
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
                            <?= $this->Form->create($project, [
                                'class' => 'form-horizontal school',
                                'autocomplete' => 'false',
                                'novalidate' => true,
                                'type' =>'file',
                                'url' => [
                                    'controller' => 'Projects',
                                    'action' => 'edit'
                                ]
                            ]) ?>
                            <?= $this->Form->input('project.id',['type' => 'hidden','value' => $project->id]); ?>
                            <div class="form-group">
                                <?= $this->Form->label('name', __('Projectnaam'), ['class' => 'col-sm-2 control-label no-padding-right ']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('project.name', [
                                        'label' => false,
                                        'class' => 'form-control slugname'. $count,
                                        'value' =>  $project->name
                                    ]); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?= $this->Form->label('slug', __('Slug'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('project.slug', [
                                        'label' => false,
                                        'class' => 'form-control slug'. $count,
                                        'readonly'=>true,
                                        'value' =>  $project->slug
                                    ]); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?= $this->Form->label('grouptext', __('Groeptekst'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('project.grouptext', [
                                        'label' => false,
                                        'class' => 'form-control',
                                        'value' =>  $project->grouptext
                                    ]); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <?= $this->Form->label('upload', __('Upload Excel'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('project.file', [
                                        'label' => false,
                                        'class' => '',
                                        'type' => 'file'
                                    ]); ?>
                                </div>
                            </div>
                            <br><br>
                            <?=$this->Form->button(__('Verwijderen'), ['type' => 'button', 'class' => 'btn btn-sm btn-danger deleteproject']); ?>
                            <?=$this->Form->button(__('Opslaan'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success pull-right']); ?>
                        </div>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
            <?php $count++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->Html->script('/admin/js/jquery.slug'); ?>
<?= $this->Html->script('/admin/js/Controllers/schools'); ?>

