<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Persoon bewerken'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <?= $this->Form->create($person, ['class' => 'form-horizontal', 'autocomplete' => 'false']) ?>

                    <div class="form-group">
                        <?= $this->Form->label(_('Voornaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('firstname', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label(_('Tussenvoegsel'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('prefix', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label(_('Achternaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('lastname', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label(_('Studentnummer'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('studentnumber', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label(_('Email'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('email', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <?= $this->Form->hidden('full_name'); ?>
                    <div class="form-group">
                        <?= $this->Form->label('slug', __('Slug'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('slug', ['label' => false, 'class' => 'form-control slug','readonly'=>true]); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('type', __('Type'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->select(
                                    'type',
                                    ['leerling' => __('leerling'), 'docent' => __('docent')],
                                    ['empty' => __('(Kies een type)')]
                                );
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('group_id', __('Klas'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->select(
                                    'group_id',
                                    $groups,
                                    ['empty' => __('(Kies een klas)')]
                                );
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('barcode_id', __('Barcode'), ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->select(
                                    'barcode_id',
                                    $barcodes,
                                    ['empty' => __('(Kies een barcode)')]
                                );
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label(_('Gebruikersnaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('user.username', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label(_('Email'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('user.email', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <?= $this->Form->label(_('Wachtwoord'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                        <div class="col-sm-9">
                            <?= $this->Form->input('user.password', ['label' => false, 'class' => 'form-control', 'required' => false]); ?>
                        </div>
                    </div>
                    <?= $this->Form->hidden('user.type', ['value' => 'person']); ?>

                    <div class="mailaddress">
                        <hr></hr>
                        <h3><?=__('Adres'); ?></h3>
                        <div class="form-group">
                            <?= $this->Form->label(_('Straat'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.street', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label(_('Nummer'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.number', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label(_('Toevoeging'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.extension', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label(_('Postcode'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.zipcode', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label(_('Plaats'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.city', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label(_('Voornaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.firstname', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label(_('Tussenvoegsel'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.prefix', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label(_('Achternaam'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->input('address.lastname', ['label' => false, 'class' => 'form-control']); ?>
                            </div>
                        </div>
                        <div class="form-group gender">
                            <?= $this->Form->label(_('Geslacht'), null, ['class' => 'col-sm-2 control-label no-padding-righ']);?>
                            <div class="col-sm-9">
                                <?= $this->Form->radio('address.gender', [
                                        ['value' => 'm', 'text' => __('Man')],
                                        ['value' => 'f', 'text' => __('Vrouw')]
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <?=$this->Html->link(__('Annuleer'),['action' => 'index'], ['class' => 'btn btn-sm']); ?>
                    <?=$this->Form->button(__('Voeg toe'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('/admin/js/jquery.slug'); ?>
<?= $this->Html->script('/admin/js/Controllers/projects'); ?>
