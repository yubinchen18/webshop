<div class="row">
        <div class="col-sm-12 filters">
            <div class="form-group">
                <?= $this->Form->create('Photos'); ?>
                <?= $this->Form->label(__('Filter'),null, ['class' => 'col-sm-1']);?>
                <div class="col-sm-3">
                    
                    <?= $this->Form->input('school_id', [
                        'label' => false, 
                        'class' => 'form-control', 
                        'options' => $schools,
                        'empty' => __('Kies een school')
                            ]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $this->Form->input('project_id', [
                        'label' => false, 
                        'class' => 'form-control', 
                        'options' => $projects]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $this->Form->input('group_id', [
                        'label' => false, 
                        'class' => 'form-control', 
                        'options' => $groups]); ?>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-sm btn-primary"><?= __('Filter'); ?></button>
                    <button type="button" class="btn btn-sm btn-warning" 
                            onclick="document.location.href='<?= $this->Url->build([
                                'controller' => 'Photos', 'action' => 'index'
                            ]); ?>'">
                    <?= __('Reset filters'); ?>
                    </button>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
</div>
<div class="photos index large-9 medium-8 columns content">
    <h3><?= __('Foto\'s') ?></h3>
    <?= $this->Form->create(null, ['id' => 'moveform','url' => $this->Url->build(['controller' => 'Photos','action' => 'move'])]); ?>
    <table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="dynamic-table_info">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= __('Leerling'); ?></th>
                <th><?= __('Project'); ?></th>
                <th><?= __('Klas / Groep'); ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($photos as $photo): ?>
            <tr>
                <td class="col-lg-1"><?= $this->Form->checkbox('photos.'.$photo->id, ['value' => 1, 'class' => 'check']); ?></td>
                <td class="col-lg-1"><?= $this->Html->image($this->Url->build([
                    'controller' => 'Photos',
                    'action' => 'display',
                    'path' => $photo->path,
                    'size' => 'thumb'
                ])); ?></td>
                <td class="col-lg-1"><?= h($photo->type) ?></td>
                <td class="col-lg-3"><?= h($photo->barcode->person->full_name_sorted) ?></td>
                <td class="col-lg-2"><?= h($photo->barcode->person->group->project->name) ?></td>
                <td class="col-lg-2"><?= h($photo->barcode->person->group->name) ?></td>
                <td class="col-lg-2 actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $photo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $photo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $photo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $photo->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="button" disabled="disabled" class="btn btn-warning" id="move"><?= __('Verplaats foto\'s'); ?></button>
    <?= $this->Form->end(); ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
<?= $this->Html->scriptBlock("
$(document).ready(function() { 
    $('#school-id').on('change', function() {
        $.ajax({
            url: '". $this->Url->build(['controller' => 'Projects', 'action' => 'index']) . "/'+ $(this).val() +'.json',
            dataType: 'json',
            success: function(response) {
                $('#project-id').html('<option value=\"\">". __('Selecteer een project') . "</option>');
                for(item in response.projects) {
                    option = $(\"<option>\").val(item).html(response.projects[item]);
                    $('#project-id').append(option);
                }
            }
        });
    });
    
    $('#project-id').on('change', function() {
        $.ajax({
            url: '". $this->Url->build(['controller' => 'Groups', 'action' => 'index']) . "/'+ $(this).val() +'.json',
            dataType: 'json',
            success: function(response) {
                $('#group-id').html('<option value=\"\">". __('Selecteer een klas') . "</option>');

                for(item in response.groups) {
                    option = $(\"<option>\").val(item).html(response.groups[item]);
                    $('#group-id').append(option);
                    console.log(item);
                }
            }
        });
    });
    
    $('.check').on('click', function() {
        var selected = false;
        $('#move').attr('disabled','disabled');
        $('.check').each(function() {
            if(this.checked) {
                selected = true;
            }
        });
        
        if(selected === true) {
            $('#move').removeAttr('disabled');
        }
    });
    
    $('#move').on('click', function() {
        $('#moveform').submit();
    });

});
", ['block' => 'scriptBottom']); ?>
