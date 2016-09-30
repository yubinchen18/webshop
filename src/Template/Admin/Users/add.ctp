<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Gebruiker toevoegen'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?= $this->Form->create($user, ['class' => 'form-horizontal', 'autocomplete' => 'false', 'enctype' => 'multipart/form-data']) ?>
                    <?= $this->element('Users/form'); ?>
                    <?= $this->Html->link(__('Annuleer'), ['action' => 'index'], ['class' => 'btn btn-sm']); ?>
                    <?= $this->Form->button(__('Voeg toe'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                </div>
            </div>
        </div>
    </div>
</div>