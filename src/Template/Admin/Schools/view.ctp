<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('School details'); ?></h4>

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
                            <td><?= h($school->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->name) ?></td>
                        </tr>                    
                        
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($school->modified) ?></td>
                        </tr>
                    </table>

                    <hr></hr>
                    <h3><?=__('Contactgegevens'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->contact->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->contact->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Telefoonnummer') ?></th>
                            <td><?= h($school->contact->phone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Faxnummer') ?></th>
                            <td><?= h($school->contact->fax) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($school->contact->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Geslacht') ?></th>
                            <td><?= ($school->contact->gender == 'm') ? _('Man') : _('Vrouw'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->contact->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($school->contact->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Bezoek adres'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->visitaddress->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Straat') ?></th>
                            <td><?= h($school->visitaddress->street) . ' ' . h($school->visitaddress->number)?></td>
                        </tr>
                        <tr>
                            <th><?= __('Toevoeging') ?></th>
                            <td><?= h($school->visitaddress->extension) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Postcode') ?></th>
                            <td><?= h($school->visitaddress->zipcode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Plaats') ?></th>
                            <td><?= h($school->visitaddress->city) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->visitaddress->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Geslacht') ?></th>
                            <td><?= ($school->visitaddress->gender == 'm') ? _('Man') : _('Vrouw'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->visitaddress->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($school->visitaddress->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Post adres'); ?></h3>
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->mailaddress->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Straat') ?></th>
                            <td><?= h($school->mailaddress->street) . ' ' . h($school->mailaddress->number)?></td>
                        </tr>
                        <tr>
                            <th><?= __('Toevoeging') ?></th>
                            <td><?= h($school->mailaddress->extension) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Postcode') ?></th>
                            <td><?= h($school->mailaddress->zipcode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Stad') ?></th>
                            <td><?= h($school->mailaddress->city) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Naam') ?></th>
                            <td><?= h($school->mailaddress->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Geslacht') ?></th>
                            <td><?= ($school->mailaddress->gender == 'm') ? _('Man') : _('Vrouw'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($school->mailaddress->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($school->mailaddress->modified) ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>