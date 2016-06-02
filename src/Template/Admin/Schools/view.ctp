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
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <td><?= h($school->name) ?></td>
                        </tr>                    
                        
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($school->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($school->modified) ?></td>
                        </tr>
                    </table>

                    <hr></hr>
                    <h3><?=__('Contact'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->contact->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Full name') ?></th>
                            <td><?= h($school->contact->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Phone') ?></th>
                            <td><?= h($school->contact->phone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Fax') ?></th>
                            <td><?= h($school->contact->fax) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($school->contact->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gender') ?></th>
                            <td><?= h($school->contact->gender) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($school->contact->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($school->contact->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Visitaddress'); ?></h3>
                    <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->visitaddress->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Street') ?></th>
                            <td><?= h($school->visitaddress->street) . ' ' . h($school->visitaddress->number)?></td>
                        </tr>
                        <tr>
                            <th><?= __('Extension') ?></th>
                            <td><?= h($school->visitaddress->extension) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Zipcode') ?></th>
                            <td><?= h($school->visitaddress->zipcode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('City') ?></th>
                            <td><?= h($school->visitaddress->city) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Full name') ?></th>
                            <td><?= h($school->visitaddress->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gender') ?></th>
                            <td><?= h($school->visitaddress->gender) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($school->visitaddress->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($school->visitaddress->modified) ?></td>
                        </tr>
                    </table>
                    <hr></hr>
                    <h3><?=__('Mailaddress'); ?></h3>
                     <table class="vertical-table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= h($school->mailaddress->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Street') ?></th>
                            <td><?= h($school->mailaddress->street) . ' ' . h($school->mailaddress->number)?></td>
                        </tr>
                        <tr>
                            <th><?= __('Extension') ?></th>
                            <td><?= h($school->mailaddress->extension) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Zipcode') ?></th>
                            <td><?= h($school->mailaddress->zipcode) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('City') ?></th>
                            <td><?= h($school->mailaddress->city) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Full name') ?></th>
                            <td><?= h($school->mailaddress->full_name) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gender') ?></th>
                            <td><?= h($school->mailaddress->gender) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
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