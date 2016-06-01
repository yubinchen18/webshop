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
                            <td><?= h($user->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Type') ?></th>
                            <td><?= h($user->type) ?></td>
                        </tr>                     
                        <tr>
                            <th><?= __('Username') ?></th>
                            <td><?= h($user->username) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($user->email) ?></td>
                        </tr>

                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($user->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($user->modified) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Deleted') ?></th>
                            <td><?= h($user->deleted) ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>