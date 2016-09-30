<h3><?=__('Bezoek adres'); ?></h3>
<div class="form-group">
    <?= $this->Form->label(__('Straat'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.street', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(__('Nummer'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.number', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(__('Toevoeging'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.extension', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(__('Postcode'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.zipcode', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(__('Plaats'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.city', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?= $this->Form->label(__('Voornaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.firstname', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label(__('Tussenvoegsel'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.prefix', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->label(__('Achternaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->input('visitaddress.lastname', ['label' => false, 'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group gender">
    <?= $this->Form->label(__('Geslacht'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?= $this->Form->radio('visitaddress.gender', [
                ['value' => 'm', 'text' => __('Man')],
                ['value' => 'f', 'text' => __('Vrouw')]
            ]);
        ?>
    </div>
</div>
<div class="form-group ">
    <?= $this->Form->label(__('Ander post adres'), null, ['class' => 'col-sm-3 control-label no-padding-righ']);?>
    <div class="col-sm-9">
        <?php
            $bool = (isset($school->mailaddress)) ? true : false;
            echo $this->Form->checkbox('differentmail', ['checked' => $bool]);
        ?>
    </div>
</div>



