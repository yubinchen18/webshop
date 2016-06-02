<div class="row">
    <div class="col-md-6">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><?=__('Add school'); ?></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <?= $this->Form->create($school, ['class' => 'form-horizontal', 'autocomplete' => 'false']) ?>
                    <?php
                        echo $this->Form->input('name');
                    ?>
                    <hr></hr>
                    <h3><?=__('Contact'); ?></h3>

                    <?php
                        echo $this->Form->input('contact.first_name');
                        echo $this->Form->input('contact.prefix');
                        echo $this->Form->input('contact.last_name');
                        echo $this->Form->input('contact.phone');
                        echo $this->Form->input('contact.fax');
                        echo $this->Form->input('contact.email');
                        echo $this->Form->radio('contact.gender', [
                            ['value' => 'm', 'text' => 'male'],
                            ['value' => 'f', 'text' => 'female']
                        ]);
                    ?>

                    <hr></hr>
                    <h3><?=__('Visitaddress'); ?></h3>

                    <?php
                        echo $this->Form->input('visitaddress.street');
                        echo $this->Form->input('visitaddress.number');
                        echo $this->Form->input('visitaddress.extension');
                        echo $this->Form->input('visitaddress.zipcode');
                        echo $this->Form->input('visitaddress.city');
                        echo $this->Form->input('visitaddress.firstname');
                        echo $this->Form->input('visitaddress.prefix');
                        echo $this->Form->input('visitaddress.lastname');
                        echo $this->Form->radio('visitaddress.gender', [
                            ['value' => 'm', 'text' => 'male'],
                            ['value' => 'f', 'text' => 'female']
                        ]);
                    ?>

                    <hr></hr>
                    <h3><?=__('Mailaddress'); ?></h3>

                    <?php
                        echo $this->Form->input('mailaddress.street');
                        echo $this->Form->input('mailaddress.number');
                        echo $this->Form->input('mailaddress.extension');
                        echo $this->Form->input('mailaddress.zipcode');
                        echo $this->Form->input('mailaddress.city');
                        echo $this->Form->input('mailaddress.firstname');
                        echo $this->Form->input('mailaddress.prefix');
                        echo $this->Form->input('mailaddress.lastname');
                        echo $this->Form->radio('mailaddress.gender', [
                            ['value' => 'm', 'text' => 'male'],
                            ['value' => 'f', 'text' => 'female']
                        ]);
                    ?>

                    <hr>
                    <?=$this->Html->link(__('Cancel'),['action' => 'index'], ['class' => 'btn btn-sm']); ?>
                    <?=$this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-sm btn-success']); ?>
                </div>

            </div>
        </div>
    </div>
</div>