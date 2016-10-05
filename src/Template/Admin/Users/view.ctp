<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Gebruiker details'); ?></h4>

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
                            <th><?= __('Rol') ?></th>
                            <td><?= h($user->type) ?></td>
                        </tr>                     
                        <tr>
                            <th><?= __('Gebruikersnaam') ?></th>
                            <td><?= h($user->username) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($user->email) ?></td>
                        </tr>

                        <tr>
                            <th><?= __('Aangemaakt') ?></th>
                            <td><?= h($user->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Gewijzigd') ?></th>
                            <td><?= h($user->modified) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Status') ?></th>
                            <td><?= h($user->active == '1' ? __('Actief') : __('Niet actief')) ?></td>    
                        </tr>
                        <td class="actions">
                            <div class="widget-body">
                            <?= $this->Html->link('<button class="btn btn-app btn-primary btn-xs">
                             <i class="ace-icon fa fa-pencil-square-o  bigger-100"></i>
                             </button>',
                                [
                                    'action' => 'edit',
                                    $user->id
                                ],['escape' => false]) ?>
                            </div>
                        </td>
                        <?php if (!empty($user->profile_photo_filename)):?>
                            <div class="img-circle pull-right"> 
                                <img src="<?= $this->Url->build([
                                        'controller' => 'Users',
                                        'action' => 'displayProfilePhoto',
                                        'id' => $user->id,
                                    ]);?>" style="height: 150px; width: 150px; border-radius: 150px;">                               
                            </div>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
