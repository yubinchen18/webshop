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
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->name) ?></td>
                        </tr>                    
                        
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($school->modified) ?></td>
                        </tr>
                    </table>

                    <hr></hr>
                    <h3><?=__('Contactgegevens'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->contact->id) ?></td>
                        </tr>
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
                            <td><?= ($school->contact->gender == 'm') ? _('Man') : _('Vrouw'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->contact->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($school->contact->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Bezoek adres'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->visitaddress->id) ?></td>
                        </tr>
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
                            <td><?= ($school->visitaddress->gender == 'm') ? _('Man') : _('Vrouw'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->visitaddress->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($school->visitaddress->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Post adres'); ?></h3>
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->mailaddress->id) ?></td>
                        </tr>
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
                            <td><?= ($school->mailaddress->gender == 'm') ? _('Man') : _('Vrouw'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->mailaddress->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($school->mailaddress->modified) ?></td>
                        </tr>
                    </table>

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
                <?= $this->Form->create($school, [
                        'class' => 'form-horizontal school',
                        'autocomplete' => 'false',
                        'novalidate' => true,
                        'type' =>'file',
                        'url' => [
                            'action' => 'saveproject'
                        ]
                    ]) ?>

                <div class="widget-body newprojectcontainer">
                    <div class="widget-main">
                        <div class="form-group">
                            <?= $this->Form->label('name', __('Projectnaam'), ['class' => 'col-sm-2 control-label no-padding-right ']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('projects.x.name', [
                                    'label' => false,
                                    'class' => 'form-control slugx newproject',
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
                                ]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label('grouptext', __('Groeptekst'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('projects.x.grouptext', [
                                    'label' => false,
                                    'class' => 'form-control newproject',
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
                             <div class="form-group">
                                <?= $this->Form->label('upload', __('Upload Excel'), ['class' => 'col-sm-2 control-label no-padding-right']);?>
                                <div class="col-sm-10">
                                    <?= $this->Form->input('projects.'. $count .'.file', [
                                        'label' => false,
                                        'class' => '',
                                        'type' => 'file'
                                    ]); ?>
                                </div>
                            </div>
                            <br><br>
                            <?=$this->Form->button(__('Verwijderen'), ['type' => 'submit', 'class' => 'btn btn-sm btn-danger deleteproject']); ?>
                            <?=$this->Form->button(__('Opslaan'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success pull-right']); ?>

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

