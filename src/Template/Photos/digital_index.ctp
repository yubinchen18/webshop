<div class="row">
    <div class="photos-product-index col-md-8 col-xs-9">
        <!-- left pics panel -->
        <div class='row'>
            <div class='col-sm-11 col-xs-12'>
                <div class="row">
                    <h2 class='col-xs-12'><?= __('Digitaal') ?></h2>
                    
                    <div class='addToCartPopup-confirmation col-md-4 col-xs-5 alert'>
                        <span id='msg'></span>
                    </div>
                    <?php foreach ($photos as $key => $digitalphoto): ?>
                        <?php foreach ($products as $product): ?>
                            <?php if($product->article == 'D1'): ?>
                                <div class="col-md-4 col-xs-6 photos-product-container">
                                    <div class="photos-product-label">
                                        <div class="row">
                                            <div class="flex-box price col-xs-5">
                                                <?= $this->Number->currency($product->price_ex, 'EUR'); ?>
                                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', [
                                                    'class' => 'plus-sign-non-quantity addToCartPopup-addButton',
                                                    'data-cartline' => json_encode([
                                                        'digital_product' => $digitalProduct,
                                                        'digital_pack' => $digitalPack,
                                                        'photo_id' => $digitalphoto->id,
                                                        'product_id' => $product->id,
                                                        'product_price' => $product->price_ex,
                                                        'product_name' => $product->name,
                                                        'product_options' => '',
                                                    ]),
                                                ])?>
                                            </div>
                                            <div class="col-xs-5">
                                                <span class="photos-product-name"><strong><?= __('Digitaal ') . ($key+1); ?></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="photos-product-icon">
                                        <div class="<?= $digitalphoto->orientationClass.' '.$digitalphoto->orientationClass.'-background' ?>">
                                        </div>
                                            <?= $this->Html->image($this->Url->build([
                                                'controller' => 'Photos',
                                                'action' => 'displayProduct',
                                                'layout' => $product->layout,
                                                'id' => $digitalphoto->id,
                                                'suffix' => $product->image['suffix'],
                                            ]), ['class' => [$digitalphoto->orientationClass, 'img-responsive']]); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($product->article == 'DPack'): ?>
                                <div class="col-md-4 col-xs-6 photos-product-container">
                                    <div class="photos-product-label">
                                        <div class="row">
                                            <div class="flex-box price col-xs-5">
                                                <?= $this->Number->currency($product->price_ex, 'EUR'); ?>
                                                <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', [
                                                    'class' => 'plus-sign-non-quantity addToCartPopup-addButton',
                                                    'data-cartline' => json_encode([
                                                        'digital_product' => $digitalProduct,
                                                        'digital_pack' => $digitalPack,
                                                        'photo_id' => $digitalphoto->id,
                                                        'product_id' => $product->id,
                                                        'product_price' => $product->price_ex,
                                                        'product_name' => $product->name,
                                                        'product_options' => '',
                                                    ]),
                                                ])?>
                                            </div>
                                            <div class="col-xs-5">
                                                <span class="photos-product-name"><strong><?= __('Compleet') ?></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="photos-product-icon">
                                        <div class="photos-product-img-wrapper">
                                            <?= $this->Html->image('../img/layout/digitalpack-bg.png',
                                            [
                                                'alt' => $digitalphoto->path,
                                                'url' => ['controller' => 'Photos', 'action' => 'view', $digitalphoto->id],
                                                'class' => ['img-responsive']
                                            ]); ?>
                                            <div class="photos-portrait-container">
                                                <?php if ($digitalphoto->portrait): ?>
                                                    <?= $this->Html->image($this->Url->build([
                                                        'controller' => 'Photos',
                                                        'action' => 'display',
                                                        'id' => $digitalphoto->portrait->id,
                                                        'size' => 'thumbs'
                                                    ]), [
                                                        'alt' => $digitalphoto->portrait->path,
                                                        'class' => [$digitalphoto->portrait->orientationClass, 'img-responsive']
                                                    ]); ?>
                                                <?php else: ?>
                                                    <?= $this->Html->image('layout/user-default.png', [
                                                        'alt' => 'default_user',
                                                        'class' => ['img-responsive']
                                                    ]); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->element('Frontend/productsPanel', ['photo' => $photo]); ?>
</div>