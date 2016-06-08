<h3><?=__('Contactgegevens'); ?></h3>

<div class="form-group">
    <?= $this->Form->label(_('Voornaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('contact.first_name', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(_('Tussenvoegsel'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('contact.prefix', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(_('Achternaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('contact.last_name', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(_('Telefoonnummer'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('contact.phone', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(_('Faxnummer'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('contact.fax', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(_('Email'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('contact.email', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group gender">
    <?= $this->Form->label(_('Geslacht'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->radio('contact.gender', [
                ['value' => 'm', 'text' => __('Man')],
                ['value' => 'f', 'text' => __('Vrouw')]
            ]);
        ?>
    </div>
</div>
<hr></hr>