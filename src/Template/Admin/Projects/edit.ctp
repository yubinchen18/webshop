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
                    <?= $this->Form->create($project, ['class' => 'form-horizontal', 'autocomplete' => 'false']) ?>
                    <div class="form-group">
                        <?= $this->Form->label('name', __('Projectnaam'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('name', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('slug', __('Slug'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('slug', ['label' => false, 'class' => 'form-control slug','readonly'=>true]); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('school_id', __('School'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->select(
                                    'school_id',
                                    $schools,
                                    ['empty' => __('(Kies een school)')]
                                );
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('grouptext', __('Groeptekst'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('grouptext', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    
                    <hr>
                    <?=$this->Html->link(__('Annuleer'),['action' => 'index'], ['class' => 'btn btn-sm']); ?>
                    <?=$this->Form->button(__('Opslaan'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('/admin/js/jquery.slug'); ?>
<?= $this->Html->script('/admin/js/Controllers/projects'); ?>
