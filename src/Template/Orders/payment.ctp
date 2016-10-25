<?= $this->Form->create(); ?>
<?= $this->Form->input('issuer',[
    'type' => 'select',
    'options' => $issuers
]); ?>
<?= $this->Form->submit('Betalen'); ?>
