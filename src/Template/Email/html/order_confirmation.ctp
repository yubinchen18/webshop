<div style="font-family: Arial;">
<?= __('Beste {0} {1},', ($order->invoiceaddress->gender == 'm' ? 'meneer':'mevrouw'), $order->invoiceaddress->full_name); ?><br/>
<br/>
<?= __('Hartelijk dank voor uw bestelling bij Hoogstraten Fotografie!'); ?><br/>
<?= __('Uw ordernummer is <strong>{0}</strong>', $order->ident); ?>. <?= __('We vragen u in eventuele communicatie dit nummer te gebruiken.'); ?><br/>
<br/>
<h3><?= __('Uw bestelling:'); ?></h3>
<table cellspacing="0" cellpadding="1" style="width: 500px; font-family: Arial">
    <tr>
        <th width="20%" style="text-align: left; border-bottom: 2px solid black;"><?= __('Aantal'); ?></th>
        <th width="50%" style="text-align: left; border-bottom: 2px solid black;"><?= __('Product'); ?></th>
        <th width="30%" style="text-align: right; border-bottom: 2px solid black;"><?= __('Subtotaal'); ?></th>
    </tr>
    <?php foreach($order->orderlines as $line): ?>
    <?php $total = 0; ?>
    <tr>
        <td style="line-height: 30px;"><?= $line->quantity; ?></td>
        <td><?= $line->productname; ?></td>
        <td align="right">&euro; <?= number_format((!empty($line->price_ex) ? $line->price_ex : $line->product->price_ex),2,',','.'); ?></td>
    </tr>
    <?php $total += (!empty($line->price_ex) ? $line->price_ex : $line->product->price_ex); ?>
    <?php endforeach; ?>
    <tr>
        <td style="line-height: 30px;border-top: 2px solid black;"></td>
        <td style="line-height: 30px;border-top: 2px solid black;"><?= __('Verwerkingskosten'); ?></td>
        <td style="line-height: 30px;border-top: 2px solid black;" align="right">&euro; <?= number_format($order->shipping_costs,2,',','.'); ?></td>
    </tr>
    <tr>
        <td></td>
        <td><strong><?= __('Totaal'); ?></strong></td>
        <td align="right"><strong>&euro; <?= number_format($total,2,',','.'); ?></strong></td>
    </tr>
</table>
<br/>
<p>
<?php if($order->payment_method == 'ideal' && $payment_status != 'failed'): ?>
<?= __('We hebben uw betaling via iDeal ontvangen'); ?>
<?php endif; ?>
<?php if($order->payment_method == 'transfer'): ?>
<?= __('U heeft gekozen om te betalen via een bankoverschrijving.'); ?><br/><br/>
<?= __('We verzoeken u de betaling over te maken op rekening <strong>NL82INGB0000863978</strong> t.n.v. Hoogstraten Fotografie B.V.'); ?><br/>
<?= __('U dient het ordernummer ({0}) als betalingskenmerk gebruiken', $order->ident); ?>
<?php endif; ?>
</p>
<p>
    <?= __('Bestellingen worden meestal binnen 5 werkdagen na ontvangst van de betaling afgeleverd.'); ?><br/>
    <?= __('We wensen u veel plezier met uw bestelling!'); ?><br/>
    <br/>
    <?= __('Met vriendelijke groet,'); ?><br/>
    Hoogstraten Fotografie B.V.
</p>
</div>