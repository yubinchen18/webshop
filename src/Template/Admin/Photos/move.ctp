<h3><?= __('Foto\'s verplaatsen') ?></h3>
<p><?= __('Je staat op het punt om de onderstaande foto\'s te verplaatsen'); ?></p>
<?= $this->Form->create(null,['id' => 'moveform']); ?>
<div class="col-xs-12 col-sm-4 widget-container-col ui-sortable">
    <div class="row">
        <div class="widget-box widget-color-blue ui-sortable-handle">
            <div class="widget-header"><h3 class="widget-title bigger lighter"><?= __('Geselecteerde foto\'s' ); ?></h3></div>
            <div class="widget-body widget-main">
            <?php foreach($moves as $photo) : ?>
                <div class="row">
                    <div class="col-lg-4"><?= $this->Html->image($this->Url->build([
                            'controller' => 'Photos',
                            'action' => 'display', 
                            'path' => $photo->id,
                            'size' => 'med']),
                            ['width' => 125]
                        ); ?>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-md-6">
                             <?= $this->Form->input('photos[]',['type' => 'hidden', 'value' => $photo->id]); ?>
                            <?= __('Leerling'); ?>:</div>
                            <div class="col-md-6"><?= $photo->barcode->person->full_name_sorted; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><?= __('Project'); ?>:</div>
                            <div class="col-md-6"><?= $photo->barcode->person->group->project->name; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><?= __('Klas'); ?>:</div>
                            <div class="col-md-6"><?= $photo->barcode->person->group->name; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><?= __('Barcode'); ?>:</div>
                            <div class="col-md-6"><?= $photo->barcode->barcode; ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-8 widget-container-col ui-sortable">
    <div class="widget-box widget-color-blue ui-sortable-handle">
        <div class="widget-header"><h3 class="widget-title bigger lighter"><?= __('Verplaats naar'); ?></h3></div>
        <?= $this->Form->input('destination_id', ['type' => 'hidden','default' => null]); ?>
        <div class="widget-body widget-main">
            
            <?php foreach($tree->projects as $project) : ?>
                    <h4><?= __('Project'); ?>: <?= $project->name; ?></h4>
                    <div id="project-<?= $project->id; ?>" class="panel-group accordion-style1 accordion-style2">
                    <?php foreach($project->groups as $group) : ?>
                            <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="#grp-<?= $group->id; ?>" class="accordion-toggle collapsed" data-toggle="collapse" aria-expanded="false" data-parent="group-<?= $group->project_id; ?>">
                                    <i class="ace-icon fa fa-chevron-right" data-icon-hide="ace-icon fa fa-chevron-down" data-icon-show="ace-icon fa fa-chevron-right"></i>
                                <?= __('Groep'); ?>: <?= $group->name; ?>
                                </a>
                            </div>
                            <div id="grp-<?= $group->id; ?>" class="panel-collapse collapse" aria-expanded="false">
                                <div class="panel-body">
                                <?php foreach($group->persons as $person) : ?>
                                    <div class="col-md-11 col-md-offset-1">
                                        <a href="#" class="person" data-person="<?= $person->id; ?>"><?= $person->full_name_sorted; ?></a>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            </div>
                            </div>
                    <?php endforeach; ?>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>
<?= $this->Html->scriptBlock("
$(document).ready(function() { 
    
    $('.person').on('click', function(e) {
        e.preventDefault();
        name = $(this).html();
        if(confirm(\"". __('De foto\'s worden gekoppeld aan ')."\" + name )) {
            $('#destination-id').val($(this).data('person'));
            $('#moveform').submit();
        }
    });

});
", ['block' => 'scriptBottom']); ?>