<div style="font-family: Arial;">
<?= __('Beste {0} {1},', ($order->invoiceaddress->gender == 'm' ? 'meneer':'mevrouw'), $order->invoiceaddress->full_name); ?><br/>
<br/>
<?= __('De betaling van uw bestelling met nummer {0} is ontvangen', $order->ident); ?><br/>
<br/>
<?= __('U heeft 1 of meer digitale beelden besteld. Hierbij sturen wij u de link toe om de bestanden te downloaden.'); ?><br/>
<?= __('U ontvangt &eacute;&eacute;n ZIP-bestand voor alle bestelde foto\'s'); ?><br/>
<br/>
<br/>
<?= $this->Html->link('Klik hier om de foto\'s te downloaden', [
    'controller' => 'orders',
    'action' => 'download',
    'id' => $order->id,
    '_full' => true
    ],['escape' => false]); ?><br/>
<br/><br/>
<?= __('Met vriendelijke groet,'); ?><br/>
Hoogstraten Fotografie B.V.
<br/>
</div>