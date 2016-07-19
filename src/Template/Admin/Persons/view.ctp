<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Persoon details'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($person->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Studentenummer') ?></th>
                            <td><?= h($person->studentnumber) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Voornaam') ?></th>
                            <td><?= h($person->firstname) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Tussenvoegsel') ?></th>
                            <td><?= h($person->prefix) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Achternaam') ?></th>
                            <td><?= h($person->lastname) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('slug') ?></th>
                            <td><?= h($person->slug) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('email') ?></th>
                            <td><?= h($person->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('type') ?></th>
                            <td><?= h($person->type) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Barcode') ?></th>
                            <td><?= h($person->barcode->barcode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($person->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($person->modified) ?></td>
                        </tr>
                    </table>

                    <hr></hr>
                    <h3><?=__('Klas'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($person->group->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($person->group->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Slug') ?></th>
                            <td><?= h($person->group->slug) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Project') ?></th>
                            <td><?= h($person->group->project->name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Barcode') ?></th>
                            <td><?= h($person->group->barcode->barcode) ?></td>
                        </tr>
                     
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($person->group->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($person->group->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Adres'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($person->address->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Straat') ?></th>
                            <td><?= h($person->address->street) . ' ' . h($person->address->number)?></td>
                        </tr>
                        <tr>
                            <th><?= __('Toevoeging') ?></th>
                            <td><?= h($person->address->extension) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Postcode') ?></th>
                            <td><?= h($person->address->zipcode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Plaats') ?></th>
                            <td><?= h($person->address->city) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($person->address->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Geslacht') ?></th>
                            <td><?= ($person->address->gender == 'm') ? _('Man') : _('Vrouw'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($person->address->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($person->address->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Account gegevens'); ?></h3>
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($person->user->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Username') ?></th>
                            <td><?= h($person->user->username) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($person->user->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <td><?= h($person->user->type) ?></td>
                        </tr>                       
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($person->user->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($person->user->modified) ?></td>
                        </tr>
                    </table>
                    
                    <div>
                        <?= $this->Html->link(__('Leerlingenkaart maken'),
                            [
                                'action' => 'createPersonCard',
                                $person->id
                            ],
                            [
                                'escape' => false,
                                'class' => 'btn btn-sm btn-pink pull-right',
                                'target' => '_blank'
                            ]
                        ) ?>
                    </div>
                    <div class="clearfix"></div>
                    
                </div>
            </div>
        </div>
    </div>
</div>