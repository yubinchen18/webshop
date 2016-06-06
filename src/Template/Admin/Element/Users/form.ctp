<div class="form-group">
    <?= $this->Form->label(_('Gebruikersnaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('username', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(_('Email'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('email', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>


<div class="form-group">
    <?= $this->Form->label(_('Wachtwoord'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('password', ['label' => false, 'class' => 'form-control', 'required' => false]); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(_('Rol'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('type', ['options' => ['admin' => 'admin', 'photex' => 'photex'], 'label' => false]); ?>
    </div>
</div>

