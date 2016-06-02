<div class="mailaddress">
    <hr></hr>
    <h3><?=__('Post adres'); ?></h3>
    <div class="form-group">
        <?= $this->Form->label(_('Straat'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.street', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $this->Form->label(_('Nummer'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.number', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $this->Form->label(_('Toevoeging'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.extension', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $this->Form->label(_('Postcode'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.zipcode', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $this->Form->label(_('Plaats'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.city', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= $this->Form->label(_('Voornaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.firstname', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="form-group">
        <?= $this->Form->label(_('Tussenvoegsel'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.prefix', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="form-group">
        <?= $this->Form->label(_('Achternaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->input('mailaddress.lastname', ['label' => false, 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="form-group gender">
        <?= $this->Form->label(_('Geslacht'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
        <div class="col-sm-9">
            <?= $this->Form->radio('mailaddress.gender', [
                    ['value' => 'm', 'text' => __('Man')],
                    ['value' => 'f', 'text' => __('Vrouw')]
                ]);
            ?>
        </div>
    </div>
</div>