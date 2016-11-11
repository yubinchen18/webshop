<div class="photos-index-label row">
    <h2><?= __('Selecteer een foto') ?></h2>
    <div class="col-md-9 photos-index">
    <?php if (!empty($persons)): ?>
        <div class="row photos-index-row">
        <?php foreach ($persons as $person): ?>
            <?php foreach ($person->barcode->photos as $key => $photo): ?>
                <div class="col-md-3 col-xs-4 photos-index-container">
                    <div class="photos-index-icon">
                        <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
                    </div>
                    <?= $this->Html->image($this->Url->build([
                        'controller' => 'Photos',
                        'action' => 'display',
                        'id' => $photo->id,
                        'size' => 'med'
                    ]), [
                        'alt' => $photo->path,
                        'url' => ['controller' => 'Photos', 'action' => 'view', $photo->id],
                        'class' => [$photo->orientationClass, 'img-responsive']
                    ]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Group Photos -->
            <?php foreach ($person->groupPhotos as $key => $photo): ?>
                <div class="col-md-3 col-xs-4 photos-index-container">
                    <div class="photos-index-icon">
                        <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
                    </div>
                    <?= $this->Html->image($this->Url->build([
                        'controller' => 'Photos',
                        'action' => 'display',
                        'id' => $photo->id,
                        'size' => 'med'
                    ]), [
                        'alt' => $photo->path,
                        'url' => ['controller' => 'Photos', 'action' => 'view', $photo->id],
                        'class' => [$photo->orientationClass, 'img-responsive']
                    ]); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </div>
    <?php endif ?>
    </div>
    <div class="photos-index col-md-3 col-sm-12">
        <!-- Medium screen -->
        <div class="photos-index-banner container col-md-11 col-md-offset-1 hidden-sm hidden-xs">
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
                            'img-responsive',
                            'center-block'
                        ]
                    ]) ?>
                </li>
            </ul>
        </div>
        <!-- Small screen -->
        <div class="photos-index-banner-sm col-sm-12 hidden-lg hidden-md">
            <div class="banner-flex-item small-font"><?= __('Betrouwbaar en veilig bestellen') ?></div>
            <div class="banner-flex-item small-font long"><?= __('Rechtstreeks betalen via eigen bank') ?></div>
            <div class="banner-flex-item small-font last"><?= __('Veilig betalen via iDeal') ?></div>
            <div class="banner-flex-item small-font"><?= __('Unieke inlog-barcode') ?></div>
            <div class="banner-flex-item small-font long"><?= __('U bestelt foto\'s van al uw kinderen in 1 keer') ?></div>
            <div class="banner-flex-item small-font last"><?= __('Razendsnelle levering foto\'s') ?></div>
                <?= $this->Html->image('../img/layout/med/Hoogstraten_webshop-onderdelen-06.png', [
                    'class' => [
                        'photos-index-banner-img'
                    ]
                ]) ?>
        </div>
    </div>
</div>