<div class="photos-index-label row">
    <h2><?= __('Selecteer een foto') ?></h2>
    <div class="photos-index col-md-9">
    <?php if (isset($person)): ?>
        <?php $p = 0; $count = count($person->barcode->photos); ?>
        <?php foreach ($person->barcode->photos as $key => $photo): ?>
            <?php $p++; ?>
            <?php if ($p % 4 == 1): ?>
            <div class="row photos-index-row">
            <?php endif; ?>
                <div class="col-xs-3 container photo-container">
                    <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
                    </div>
                    <?= $this->Html->image($this->Url->build([
                        'controller' => 'Photos',
                        'action' => 'display',
                        'id' => $photo->id,
                        'size' => 'thumbs'
                    ]), [
                        'alt' => $photo->path,
                        'url' => ['controller' => 'Photos', 'action' => 'view', $photo->id],
                        'class' => [$photo->orientationClass, 'img-responsive']
                    ]); ?>
                </div>
            <?php if ($p % 4 == 0 || $key == ($count - 1)) : ?>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif ?>
    </div>
    <div class="photos-index col-md-3">
        <div class="photos-index-banner container col-md-11 col-md-offset-1">
            <ul class="photos-index-banner-ul  list-group">
                <li><h5><?= __('Betrouwbaar en veilig bestellen') ?></h5></li>
                <li><h5><?= __('Unieke inlog-barcode') ?></h5></li>
                <li><h5><?= __('Rechtstreeks betalen via eigen bank') ?></h5></li>
                <li><h5><?= __('U bestelt foto\'s van al uw kinderen in 1 keer') ?></h5></li>
                <li><h5><?= __('Veilig betalen via iDeal') ?></h5></li>
                <li><h5><?= __('Razendsnelle levering foto\'s') ?></h5></li>
                <li class="li-no-background">
                    <?= $this->Html->image('../img/layout/med/Hoogstraten_webshop-onderdelen-06.png', [
                        'class' => [
                            'photos-index-banner-img',
                            'img-responsive'
                        ]
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
</div>