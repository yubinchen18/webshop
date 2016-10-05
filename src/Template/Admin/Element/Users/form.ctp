<div class="form-group">
    <?= $this->Form->label(__('Gebruikersnaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('username', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label(__('Email'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('email', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label(__('Wachtwoord'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('password', ['label' => false, 'class' => 'form-control', 'required' => false]); ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label(__('Profiel foto'), null, ['class' => 'col-sm-2 control-label no-padding-righ']) ;?>
    <div class="col-sm-9">
        <?= $this->Form->input('Upload', ['type' => 'file', 'label' => false]); ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label(__('Rol'), null, ['class' => 'col-sm-2 control-label no-padding-righ']) ;?>
    <div class="col-sm-9">
        <?= $this->Form->select(
            'type',[
                'admin' => 'Admin',
                'photographer' => 'Fotograaf',
                'person' => 'Persoon'
            ], 
            [
                'disabled' => $this->request->action == 'edit'
            ]) 
        ;?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label(__('Actief'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->checkbox('active', ['label' => false]) ;?>
    </div>
</div>

