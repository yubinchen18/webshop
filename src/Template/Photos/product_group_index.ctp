<?php foreach ($products as $product): ?>
    <div class="col-xxl-2 col-xl-3 col-md-4 col-xs-6 photos-product-container">
        <div class="photos-product-label">
            <div class="row">
                <div class="flex-box price col-xs-5">
                    <?= $this->Number->currency($product->price_ex, 'EUR'); ?>
                    <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', [
                        'class' => 'plus-sign',
                        'data-cartline' => json_encode([
                            'photo_id' => $photo->id,
                            'product_id' => $product->id,
                            'product_price' => $product->price_ex,
                            'product_name' => $product->name,
                            'product_options' => ''
                        ]),
                    ])?>
                </div>
                <div class="flex-box dimensions col-xs-7">
                    <?php $size = explode('_', $product->slug); ?>
                    <?= $size[1] . ' cm'?>
                </div>
            </div>
        </div>
        <div class="photos-product-icon">
            <div class="<?= $photo->orientationClass.' '.$photo->orientationClass.'-background' ?>">
            </div>
                <?= $this->Html->image($this->Url->build([
                    'controller' => 'Photos',
                    'action' => 'displayProduct',
                    'layout' => $product->layout,
                    'id' => $photo->id,
                    'suffix' => $product->image['suffix'],
                ]), ['class' => [$photo->orientationClass, 'img-responsive']]); ?>
        </div>
    </div>
<?php endforeach; ?>
