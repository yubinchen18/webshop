<div class="photos-index-label row">
    <h2><?= __('Selecteer een groepsfoto') ?></h2>
    <div class="col-md-9 photos-index">
    <?php if (!empty($photos)): ?>
        <div class="row photos-product-index">
        <?php foreach ($photos as $photo): ?>
             <div class="col-md-4 col-xs-6 photos-product-container">
                <div class="photos-index-icon" data-toggle="modal" data-target=".modal-<?= $photo->id; ?>">
                    <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
                </div>
                <?= $this->Html->image($this->Url->build([
                        'controller' => 'Photos',
                        'action' => 'display',
                        'id' => $photo->id,
                        'size' => 'med',
                    ]),[
                        'class' => [$photo->orientationClass, 'img-responsive group-picture'],
                    ]); ?>
                </div>
                <div class="text-left">
                    <button type="button" class="btn btn-success fullwidth update-orderline" data-cartline='<?= json_encode([
                        'photo_id' => $photo->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->price_ex,
                        'product_options' => '',
                        'person_barcode' => $personBarcode]);
                 ?>'>
                        <i class="ace-icon fa fa-cart-plus"></i> <?= __('Kies') ?>
                    </button>
                 </div>
                <div class="modal fade modal-<?= $photo->id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><?= __('Groepsfoto'); ?></h4>
                            </div>
                            <div class="modal-body text-center">
                            <?= $this->Html->image($this->Url->build([
                                'controller' => 'Photos',
                                'action' => 'display',
                                'id' => $photo->id,
                                'size' => 'med']),
                                ['class' => 'img-responsive']
                            ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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