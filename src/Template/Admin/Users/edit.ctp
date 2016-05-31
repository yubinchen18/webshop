<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Add user'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <?= $this->Form->create($user, ['class' => 'form-horizontal', 'autocomplete' => 'false']) ?>
                    <?php
                    echo $this->Form->input('type', ['options' => ['admin' => 'admin', 'photex' => 'photex']]);
                    echo $this->Form->input('username');
                    echo $this->Form->input('email');
                    echo $this->Form->input('password', ['autocomplete' => 'new-password']);
                    ?>
                    <hr>
                    <?=$this->Html->link(__('Cancel'),['action' => 'index'], ['class' => 'btn btn-sm']); ?>
                    <?=$this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                </div>

            </div>
        </div>
    </div>
</div>