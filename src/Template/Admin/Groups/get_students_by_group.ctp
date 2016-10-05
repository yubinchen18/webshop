<div class="col-md-6" id="tow">
    <div class="widget-box">
        <div class="widget-header">
            <h4 class="widget-title"><?=__('Leerling Details'); ?></h4>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>

            </div>
        </div>
        <div class="widget-body">
            <div class="widget-main">
                <table class="vertical-table">
                    <th><?= __('Klas') ?></th>
                    <td><?= h($groups->name); ?></td>
                </table>
                <table class="vertical-table">
                           <hr></hr>
                    <tr role="row">
                        <th><?= __('Voornaam') ?></th>
                        <th><?= __('Achternaam') ?></th>
                        <th><?= __('Student nummer') ?></th>
                    </tr>
                    <?php foreach ($groups->persons as $person): ?>
                        <tr>
                            <td><?= h($person->firstname); ?></td>
                            <td><?= h($person->lastname); ?></td>
                            <td><?php
                                    echo $this->Html->link(
                                        h($person->studentnumber),
                                        '/admin/persons/view/' . $person->id
                                    )
                                ;?>
                            </td>
                        </tr>
                    <?php endforeach; ?>                  
                </table>
                <div class="clearfix"></div>                    
            </div>
        </div>
    </div>
</div>