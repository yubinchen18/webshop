<h1><?= __('Bedankt voor uw bestelling!'); ?></h1>
<p><?= __('Uw ordernummer is: <strong> {0} </strong>', $order->ident); ?><br/>
<?= __('U ontvangt een bevestiging van uw bestelling via e-mail.'); ?><br/>
<br/>
<?php if($order->payment_method == 'ideal') : ?>
<?= $this->Flash->render(); ?>
<?php endif;?>
    <?= $this->Html->link(__('Naar winkelwagen'),
        ['controller' => 'Carts', 'action' => 'display'],
        ['class' => 'btn btn-default']
    ); ?>
</p>