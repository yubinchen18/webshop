<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Nieuwe Coupon'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <?= $this->Form->create($coupon, ['class' => 'form-horizontal', 'autocomplete' => 'false']) ?>

                    <div class="form-group">
                        <?= $this->Form->label('coupon_code', __('Coupon Code'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('coupon_code', ['label' => false, 'disabled' => true, 'class' => 'form-control']); ?>
                            <?= $this->Html->link(__('Genereer Coupon Code'), '#', ['class' => 'btn btn-sm btn-success', 'id' => 'generate-coupon-code']); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                       <?= $this->Form->label('school_id', __('School'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('school_id', ['label' => false, 'options' => $schools, 'empty' => __('Kies een school')]); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                       <?= $this->Form->label('project_id', __('Project'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('project_id', ['label' => false, 'options' => $projects, 'empty' => __('Selecteer een school')]); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('group_id', __('Klas'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('group_id', ['label' => false, 'options' => $groups,'empty' => __('Selecteer een project')]); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?= $this->Form->label('person_id', __('Person'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('person_id', ['label' => false, 'options' => $persons, 'empty' => __('Selecteer een klas')]); ?>
                        </div>
                    </div>
                    
                    <hr>
                    <?= $this->Form->input('coupon_code_hidden', ['type' => 'hidden']); ?>
                    <?= $this->Form->input('type', ['type' => 'hidden', 'value' => 'product']); ?>
                    <?= $this->Form->input('typedata', ['type' => 'hidden', 'value' => '9227785e-ada4-11e6-b5c0-a402b93f601a']); ?>
                    <?= $this->Html->link(__('Annuleer'),['action' => 'index'], ['class' => 'btn btn-sm']); ?>
                    <?= $this->Form->button(__('Voeg toe'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('/admin/js/Controllers/coupons'); ?>
