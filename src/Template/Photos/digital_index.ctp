<div class="row">
    <div class="photos-product-index col-md-8 col-xs-9">
        <!-- left pics panel -->
        <div class='row'>
            <div class='col-sm-11 col-xs-12'>
                <?= $this->Flash->render(); ?>
                <div class="row">
                    <h2 class='col-xs-12'><?= __('Digitaal') ?></h2>
                    <div class='addToCartPopup-confirmation col-md-4 col-xs-5 alert'>
                        <span id='msg'></span>
                    </div>
                    <?php foreach ($persons as $person): ?>
                        <?php foreach ($person->barcode->photos as $key => $digitalphoto): ?>
                            <div class="col-xxl-2 col-xl-3 col-md-4 col-xs-6 photos-product-container">
                                <div class="photos-product-label">
                                    <div class="row">
                                        <div class="flex-box price col-xs-5">
                                            <?= $this->Number->currency($products[0]->price_ex, 'EUR'); ?>
                                            <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', [
                                                'class' => 'plus-sign-non-quantity addToCartPopup-addButton',
                                                'data-cartline' => json_encode([
                                                    'digital_product' => $products[0]->article,
                                                    'photo_id' => $digitalphoto->id,
                                                    'product_id' => $products[0]->id,
                                                    'product_price' => $products[0]->price_ex,
                                                    'product_name' => $products[0]->name,
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
                                            'action' => 'display',
                                            'size' => 'thumbs',
                                            'layout' => $products[0]->layout,
                                            'id' => $digitalphoto->id,
                                            'suffix' => $products[0]->image['suffix'],
                                        ]), ['class' => [$digitalphoto->orientationClass, 'img-responsive']]); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- Digital complete pack -->
                        <div class="col-xxl-2 col-xl-3 col-md-4 col-xs-6 photos-product-container">
                            <div class="photos-product-label">
                                <div class="row">
                                    <div class="flex-box price col-xs-5">
                                        <?= $this->Number->currency($products[1]->price_ex, 'EUR'); ?>
                                        <?= $this->Html->image('layout/Hoogstraten_webshop-onderdelen-21.png', [
                                            'class' => 'plus-sign-non-quantity addToCartPopup-addButton',
                                            'data-cartline' => json_encode([
                                                'digital_product' => $products[1]->article,
                                                'digital_pack' => $person->barcode_id,
                                                'photo_id' => $digitalphoto->id,
                                                'product_id' => $products[1]->id,
                                                'product_price' => $products[1]->price_ex,
                                                'product_name' => $products[1]->name,
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
                                    <span class="photos-digital-pack-title"><?= __('Complete digitale fotoshoot van:') ?></span>
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
                                    <span class="photos-digital-pack-subtitle"><?= __('+ Gratis klassenfoto') ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>   
                </div>
            </div>
        </div>
    </div>
    <?= $this->element('Frontend/productsPanel', ['photo' => $firstPhoto]); ?>
</div>