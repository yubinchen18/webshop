<div class="table-header"><?=__('Schools')?></div>
<div>
    <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
               aria-describedby="dynamic-table_info">
            <thead>
            <tr role="row">
                <th><?= $this->Paginator->sort('name', __('School')) ?></th>
                <th><?= $this->Paginator->sort('contact.full_name', __('Contact')) ?></th>
                <th><?= $this->Paginator->sort('contact.phone', __('Phone')) ?></th>
                <th><?= $this->Paginator->sort('visitaddress.city', __('City')) ?></th>
                <th><?= $this->Paginator->sort('created', __('Created')) ?></th>
                <th><?= $this->Paginator->sort('modified', __('Modified')) ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($schools as $school): ?>
                <tr>
                    <td><?= h($school->name) ?></td>
                    <td><?= h($school->contact->full_name) ?></td>
                    <td><?= h($school->contact->phone) ?></td>
                    <td><?= h($school->visitaddress->city) ?></td>
                    <td><?= h($school->created) ?></td>
                    <td><?= h($school->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $school->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $school->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $school->id], ['confirm' => __('Are you sure you want to delete # {0}?', $school->name)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-6">
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>

                    <?= $this->Html->link(__('New school'),
                        [
                            'action' => 'add'
                        ],
                        [
                            'class' => 'btn btn-sm btn-purple'
                        ]
                    ) ?>


                </div>
            </div>
        </div>
    </div>
</div>